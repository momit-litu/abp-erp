<?php

namespace App\Traits;
use GuzzleHttp\Client;

trait CallMicroService{

    public function performRequest($method, $requestUrl, $formParams = [], $headers = []){
       $client = new Client([
			'base_uri' => $this->baseUri,
		]);
		//echo $this->secret;die;
		if(isset($this->secret)){
			$headers['Authorization'] = $this->secret;
			$headers['Accept'] = 'application/json';
		}
		
		$response = $client->request($method, $requestUrl, ['form_params' => $formParams, 'headers' => $headers]);
		return $response->getBody()->getContents();
    }
}
