<?php

namespace App\Traits;
use GuzzleHttp\Client;

trait CallExternalAPI{

    public function performRequest($method, $requestUrl, $formParams = [], $headers = []){
       $client = new Client([
			'base_uri' => $this->baseUri,
       ]);

		//echo $method.'--'.$requestUrl.'--'.$this->baseUri.'======='.$this->secret;die;
		//return "From Call MicroService";die;
        //dd($method, $requestUrl, $formParams, $headers);
		$response = $client->request($method, $requestUrl, ['form_params' => $formParams, 'headers' => $headers]);
		return $response->getBody()->getContents();
    }
}
