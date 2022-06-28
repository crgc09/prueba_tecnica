<?php

namespace App\Http\Controllers\Api;

use Config;
use App\Http\Controllers\Controller;
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
                return response()->json([
                    'message' => "Short url: ".$arr_body->link
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        }
    }
}
