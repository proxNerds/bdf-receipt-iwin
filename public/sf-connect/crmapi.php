<?php
// ///////////////////////////////////////////////////////////////////////////////////////////////
//
// SF-Connect 1.0
// (C) 2021 Beiersdorf Shared Services GmbH
//
// crmapi.php
//
// This is the function library with all functions used by the sample code.
//
// Leave this file unchanged.
// Include this file in your PHP application.
//
// ///////////////////////////////////////////////////////////////////////////////////////////////
/*function setAuthToken() 
{
	
// This function authenticates via the OAuth 2.0 protocol against the API engine.
// It will write a cookie "pf-crmapiacc" with the current token.
// The function will only be called if the old token has expired.


require ("config.php");

// The function will ask for a token every 59 minutes and store it in a local file
// to avoid roundtrips. 
// It's a good idea to not store it in the web directory, but in the server's temp directory.

// This creates a unique file name for the cache file, as there can be different applications
// using SF-Connect on the server. If you have only one instance on SF-Connect running,
// you can also use a string like "/crmcache.cac".
$filepath = $_SERVER['DOCUMENT_ROOT'];
$filepath = str_replace("/", "-", $filepath);
$filepath = str_replace(".", "-", $filepath);
$filepath = substr($filepath, 1, strlen($filepath) -1);
$file = sys_get_temp_dir() . "/" . $filepath . "-crmcache.cac";


$current_time = time();
$cache_last_modified = filemtime($file); // time when the cache file was last modified

if(file_exists($file) && ($current_time < strtotime('+59 minutes', $cache_last_modified))){ 
	$crmapiacc = file_get_contents($file);
	
}
else
{
	
// Starting execution

// The array contains everything you need from the config file to authenticate.
$data = ["client_secret" => $crmAuthClient_secret, "scope" => $crmAuthScope, "client_id" => $crmAuthClient_id, "grant_type" => $crmAuthGrant_type];

// The POST request is done via standard CURL extension.
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $crmAuthURL);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded'] );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);

$obj = json_decode($result);
$crmapiacc = $obj->access_token;

// Write token to cache
file_put_contents($file, $crmapiacc);	
	}
	

// The token is then being returned.

return $crmapiacc;

}	*/

function setAuthToken()
{

// This function authenticates via the OAuth 2.0 protocol against the API engine.
    // It will write a cookie "pf-crmapiacc" with the current token.
    // The function will only be called if the old token has expired.

    require "config.php";

// The function will ask for a token every 59 minutes and store it in a local file
    // to avoid roundtrips.
    // It's a good idea to not store it in the web directory, but in the server's temp directory.

// This creates a unique file name for the cache file, as there can be different applications
    // using SF-Connect on the server. If you have only one instance on SF-Connect running,
    // you can also use a string like "/crmcache.cac".
    $filepath = $_SERVER['DOCUMENT_ROOT'];
    $filepath = str_replace("/", "-", $filepath);
    $filepath = str_replace(".", "-", $filepath);
    $filepath = substr($filepath, 1, strlen($filepath) - 1);
    $file = sys_get_temp_dir() . "/" . $filepath . "-crmcache.cac";
    //die(file_exists($file));
    //$crmapiacc = '';
    $crmapiacc_ok = false;
    if (file_exists($file)) {
        $current_time = time();
        $cache_last_modified = filemtime($file); // time when the cache file was last modified

        if (($current_time < strtotime('+59 minutes', $cache_last_modified))) {
            $crmapiacc = file_get_contents($file);
            $crmapiacc_ok = true;
        }
    }

//if(file_exists($file) && ($current_time < strtotime('+59 minutes', $cache_last_modified))){
    /*if(($current_time < strtotime('+59 minutes', $cache_last_modified))){
    $crmapiacc = file_get_contents($file);

    }*/
//else
    if (!$crmapiacc_ok) {

// Starting execution

// The array contains everything you need from the config file to authenticate.
        $data = ["client_secret" => $crmAuthClient_secret, "scope" => $crmAuthScope, "client_id" => $crmAuthClient_id, "grant_type" => $crmAuthGrant_type];

// The POST request is done via standard CURL extension.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $crmAuthURL);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        $obj = json_decode($result);
        $crmapiacc = $obj->access_token;

// Write token to cache
        file_put_contents($file, $crmapiacc);
    }

// The token is then being returned.
    return $crmapiacc;

}

// //////////////////////////////////////////////////////////////////////////////////////////////////

// Standard GET Request
function crmGetRequest($url, $header, $options) {

if ($options != "") 
{
	$url = $url . "?" . $options; 
}
$crmapiacc = setAuthToken();
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [$header]);
$result = curl_exec($ch);
$httpstatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
return $result;
}
// //////////////////////////////////////////////////////////////////////////////////////////////////

// Standard POST Request
function crmPostRequest($url, $data, $xsource, $referer)
{

require ("config.php");


	
// Getting a valid access token for the API endpoint
// This part checks if a cookie with the token is available
// If not, it calls the function to create one.
	
$crmapiacc = setAuthToken();

// Double-check if a token is available
// If not, the standard error page from the "errorpage.txt" file is displayed

// $headerAuth will contain the final auth token
$headerAuth = "Bearer " . $crmapiacc;

// Creating the JSON body for POST request

$datalength = strlen($data);


// This is the full API call via the CURL extension

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

// Headers: Please note that Host, Content Length and Content Type are mandatory,
// although not described in the official API documentation
curl_setopt($ch, CURLOPT_HTTPHEADER, 
			["Authorization: $headerAuth", 
			 "X-Client-Id: $client_id",
			 "Content-Type: application/json",
			 "Host: $host",
			 "Content-Length: $datalength",
			 "Cache-Control: no-cache",
			 "X-Source: $xsource",
			 "referer: $referer"
			]);
	
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
$httpstatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

	if ($httpstatus == "200" && $result == "")
	{ return $httpstatus; }
// "200" means that everything is okay, there is no JSON to be returned
else
{ return $result; }
// in case there is an error and / or status code is not equal to 200, the JSON is returned.	

}

// //////////////////////////////////////////////////////////////////////////////////////////////////

// Standard PUT Request
function crmPutRequest($url, $data, $xsource, $referer)
{

require ("config.php");

// Getting a valid access token for the API endpoint
// This part checks if a cookie with the token is available
// If not, it calls the function to create one.
	
$crmapiacc = setAuthToken();

// Double-check if a token is available
// If not, the standard error page from the "errorpage.txt" file is displayed

// $headerAuth will contain the final auth token
$headerAuth = "Bearer " . $crmapiacc;


// Creating the JSON body for POST request

$datalength = strlen($data);


// This is the full API call via the CURL extension
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

// Headers: Please note that Host, Content Length and Content Type are mandatory,
// although not described in the official API documentation
curl_setopt($ch, CURLOPT_HTTPHEADER, 
			["Authorization: $headerAuth", 
			 "X-Client-Id: $client_id",
			 "Content-Type: application/json",
			 "Host: $host",
			 "Content-Length: $datalength",
			 "Cache-Control: no-cache",
			 "X-Source: $xsource",
			 "referer: $referer"
			]);
	
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
$httpstatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpstatus == "200" && $result == "")
	{ return $httpstatus; }
// "200" means that everything is okay, there is no JSON to be returned
else
{ return $result; }
// in case there is an error and / or status code is not equal to 200, the JSON is returned.	

}

// //////////////////////////////////////////////////////////////////////////////////////////////////

// Standard DELETE Request
function crmDelRequest($url, $data, $xsource, $referer)
{

require ("config.php");

// Getting a valid access token for the API endpoint
// This part checks if a cookie with the token is available
// If not, it calls the function to create one.
	
$crmapiacc = setAuthToken();

// Double-check if a token is available
// If not, the standard error page from the "errorpage.txt" file is displayed

// $headerAuth will contain the final auth token
$headerAuth = "Bearer " . $crmapiacc;

$datalength = strlen($data);


// This is the full API call via the CURL extension
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
 

// Headers: Please note that Host, Content Length and Content Type are mandatory,
// although not described in the official API documentation
curl_setopt($ch, CURLOPT_HTTPHEADER, 
			["Authorization: $headerAuth", 
			 "X-Client-Id: $client_id",
			 "Content-Type: application/json",
			 "Host: $host",
			 "Content-Length: $datalength",
			 "Cache-Control: no-cache",
			 "X-Source: $xsource",
			 "referer: $referer"
			]);
	
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
$httpstatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpstatus == "200" && $result == "")
	{ return $httpstatus; }
// "200" means that everything is okay, there is no JSON to be returned
else
{ return $result; }
// in case there is an error and / or status code is not equal to 200, the JSON is returned.	

}
?>