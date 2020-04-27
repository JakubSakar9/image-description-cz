<?php

require_once 'HTTP_Request2-2.3.0/HTTP/Request2.php';
global $wpdb;
$tableName = $wpdb->prefix . "api_data";

$apiSubscribtionKey = $wpdb->get_var(
    "SELECT key FROM $tableName WHERE ID = 1"
);

$apiURI = $wpdb->get_var(
    "SELECT URI FROM $tableName WHERE ID = 1"
);

$request = new Http_Request2($apiURI);
$url = $request->getUrl();
$imageUrl = $argv[1];

$headers = array(
    // Request headers
    'Content-Type' => 'application/json',
    'Ocp-Apim-Subscription-Key' => $apiSubscriptionKey
);
$request->setHeader($headers);

$parameters = array(
    // Request parameters
    'visualFeatures' => 'Categories,Description',
    'details' => '',
    'language' => 'en'
);
$url->setQueryVariables($parameters);

$request->setMethod(HTTP_Request2::METHOD_POST);

// Request body parameters
$body = json_encode(array('url' => $imageUrl));

// Request body
$request->setBody($body);

try
{
    $response = $request->send();
    $rawJSON = json_encode(json_decode($response->getBody()), JSON_PRETTY_PRINT);
        for($i = 0; $i < strlen($rawJSON); $i++){
            if(substr($rawJSON, $i, 9) == '"text": "'){
                $i += 9;
                $j = 0;
                while($rawJSON[$i + $j] != '"'){
                    $j++;
                }
                echo substr($rawJSON, $i, $j);
            }   
        }
}
catch (HttpException $ex)
{
    echo $ex;
}