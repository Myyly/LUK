<?php

use GuzzleHttp\Psr7\Request;
use Infobip\Configuration;
use Infobip\Api\SmsApi;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;
use Infobip\Model\SmsAdvancedTextualRequest;
require __DIR__ . 'vendor/autoload.php';


$message = $_POST["message"];
$phoneNumber = $_POST["phoneNumber"];

$apiURL = "v3v4yv.api.infobip.com";
$apiKey = "66c686e88401b3de669baa7cea14f7b1-60d1aa3f-9f1c-463a-bf64-434f739f13a8";

$configration = new Configuration(host : $apiURL,apiKey:$apiKey );
$api = new SmsApi(config:$configration);

$destination = new SmsDestination(to:$phoneNumber);
$thêMsgae = new SmsTextualMessage(
destinations:[$destination],
text :$message,
from:"Syntax Flow"
);

$request = new SmsAdvancedTextualRequest(messages:[$theMessage]);
$response = $api -> sendSmsMessage($request);
echo 'SMS Messfae'
?>