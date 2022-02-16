<?php

namespace App\Traits;
use GuzzleHttp\Client;

trait CallExternalAPI{

    public function performRequest($method, $requestUrl, $formParams = []){
        $headers =  array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen(json_encode($formParams)),
            'accept:application/json'
        );

        $client = new Client([
            'base_uri' => $this->domain,
        ]);

		//echo $method.'--'.$requestUrl.'--'.$this->baseUri.'======='.$this->secret;die;
		//return "From Call MicroService";die;
        //dd($method, $requestUrl, $formParams, $headers);
		$response = $client->request($method, $requestUrl, ['form_params' => $formParams, 'headers' => $headers]);
		return $response->getBody()->getContents();
    }
}
