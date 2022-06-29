<?php

namespace App\Http\Controllers\Api;

use Config;
use App\Http\Controllers\Controller;
use App\Models\Binnacle;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index(){
        return response()->json([
            'message' => "API PT Traxion. Version 1.0.",
        ], 200);
    }
    // URL TO BITLY SHORTCODE
    public function urlToShortcode(Request $request){
        //Vars
        $long_url = $request->url;
        $url = 'https://api-ssl.bitly.com/v4/bitlinks';
        // BITLY_TOKEN .env
        $token =  config('services.bitly.token');
        //$token = 'cea4455c3164e6266cdbae072a7f31932c45369c';
        $headers = [
            'Authorization' => 'Bearer '.$token,
            'Content-Type' => 'application/json'
        ];
        $json = [
            'long_url' => $long_url
        ];
        //
        try {
            //Http client
            $client = new \GuzzleHttp\Client;
            $response = $client->post($url, 
                [
                    'headers' => $headers,
                    'json' => $json,
                    'verify' => false,
                ] 
            );
            //Search and json-decodification 
            if(in_array($response->getStatusCode(), [200, 201])) {
                $body = $response->getBody();
                $arr_body = json_decode($body);
                //Record
                $binnacle = new Binnacle;
                $binnacle->action = 'encode';
                $binnacle->method = 'post';
                $binnacle->original_url = $long_url;
                $binnacle->bitly_url = $arr_body->link;
                $binnacle->save();
                //
                return response()->json([
                    'message' => "Short url: ".$arr_body->link
                ], 200);
            }
            else{
               return response()->json([
                    'message' => 'Internal error'
                ], 500); 
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        }
    }
    // BITLY SHORTCODE TO URL
    public function shortcodeToUrl(Request $request){
        //Vars
        $short_url = $request->url;
        $parse_url = parse_url($short_url);
        $domain = $parse_url['host'].$parse_url['path'];
        $url = 'https://api-ssl.bitly.com/v4/bitlinks/'.$domain;
        $token =  config('services.bitly.token');
        $headers = [
            'Authorization' => 'Bearer '.$token,
            'Content-Type' => 'application/json'
        ];
        //
        try {
            //Http client
            $client = new \GuzzleHttp\Client;
            $response = $client->get($url, ['headers' => $headers,]);
            //Search and json-decodification 
            if(in_array($response->getStatusCode(), [200, 201])) {
                $body = $response->getBody();
                $arr_body = json_decode($body);
                //Record
                $binnacle = new Binnacle;
                $binnacle->action = 'decode';
                $binnacle->method = 'get';
                $binnacle->original_url = $arr_body->long_url;
                $binnacle->bitly_url = $short_url;
                $binnacle->save();
                //
                return response()->json([
                    'message' => "Original url: ".$arr_body->long_url
                ], 200);
            }
            else{
               return response()->json([
                    'message' => 'Internal error'
                ], 500); 
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        }
    }
}
