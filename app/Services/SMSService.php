<?php

namespace App\Services;
use App\Traits\CallExternalAPI;

class SMSService
{
	use CallExternalAPI ;
	public $baseUri;
	public $user_id;
	public $user_password;

	public function __construct(){
		$this->baseUri = "https://powersms.banglaphone.net.bd/"; 
		$this->user_id = config('services.smsService.sms_user_id');
		$this->user_password = config('services.smsService.sms_user_password');
	}

	function sendSMS($param){
		return $this->performRequest('GET', "https://powersms.banglaphone.net.bd/httpapi/sendsms?userId=".$this->user_id."&password=".$this->user_password."&commaSeperatedReceiverNumbers=".$param['commaSeperatedReceiverNumbers']."&smsText=".$param['smsText']."");
	}


	//https://powersms.banglaphone.net.bd/httpapi/sendsms?userId=tarik&password=t123456&commaSeperatedReceiverNumbers=01980340482&smsText=MOMT%20hello

}
