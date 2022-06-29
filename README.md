<p align="center">
	<h1>Test URL Encode/Decode</h1>
</p>

### Required 

> Composer

	"php": "^7.3",
	"fideloper/proxy": "^4.2",
	"fruitcake/laravel-cors": "^2.0",
	"guzzlehttp/guzzle": "^7.0.1",
	"laravel/framework": "^8.0",
	"laravel/tinker": "^2.0"

> Bitly API V4

	https://dev.bitly.com/
	https://dev.bitly.com/api-reference/
	You need to create account to get a token

***

### Run Aplication

> Run server 

	php artisan serve

> Run migrations

	php artisan migrate

> Edit .env file

	Add BITLY_TOKEN=XXXXXXXXXXXXX (Account token)

> Endpoints

	Local

	Encode: post method 
	http://localhost:8000/api/url-to-shortcode
	url form example = https://www.youtube.com/watch?v=9uKjr5RNoXc 

	Decode: get method 
	http://localhost:8000/api/shortcode-to-url?url=https://bit.ly/3QTU1vl
	url param example = https://bit.ly/3QTU1vl


