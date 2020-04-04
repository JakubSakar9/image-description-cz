<?php
// Replace <Subscription Key> with a valid subscription key.
$ocpApimSubscriptionKey = '';

// You must use the same location in your REST call as you used to obtain
// your subscription keys. For example, if you obtained your subscription keys
// from westus, replace "westcentralus" in the URL below with "westus".
//$uriBase = 'https://westcentralus.api.cognitive.microsoft.com/vision/v2.0/';
$imageUrl = $argv[1];

require_once 'HTTP_Request2-2.3.0/HTTP/Request2.php';

$request = new Http_Request2('');
$url = $request->getUrl();

$headers = array(
    // Request headers
    'Content-Type' => 'application/json',
    'Ocp-Apim-Subscription-Key' => $ocpApimSubscriptionKey
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