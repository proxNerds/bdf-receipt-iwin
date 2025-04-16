<?php
// ///////////////////////////////////////////////////////////////////////////////////////////////
//
// SF-Connect 1.0
// (C) 2021 Beiersdorf Shared Services GmbH
//
// config.php
// NIVEA IT
//
// This is the config file for SF-Connect. It is used by the sample code.
//
// The file is provided with individual settings per webspace or application.
// It has 2 separate configurations for Developement/Testing ("QA") and production ("Prod").
// Initially, "QA" is activated. If you are ready to go live, please set "$environment" to "Prod".
//
// ///////////////////////////////////////////////////////////////////////////////////////////////

// Set your environment here - this is the only change you need to make in this file

//$environment = "QA";
$environment = "Prod";


if ($environment == "Prod")
{
$crmAuthClient_secret = "mp2R0/bFMFoVbrabk2Uzi6PrzeOYZeAFxa877qn2bos=";
$crmAuthClient_id = "73cd5533-714b-401d-a8f7-62631185ffba";
$client_id = "NIVEA-PROD-IT";
$crmAuthURL = "https://login.microsoftonline.com/631f985f-427e-4921-a153-c467ec975fb6/oauth2/v2.0/token";
$crmAuthScope = "api://xdcrm/.default";
$crmAuthGrant_type = "client_credentials";
$host = "gateway.api.beiersdorfgroup.com";
$loginUrl = "https://uat.nivea.it/session/signin?returnUrl=/";
}

else

{
$crmAuthClient_secret = "mp2R0/bFMFoVbrabk2Uzi6PrzeOYZeAFxa877qn2bos=";
$crmAuthClient_id = "73cd5533-714b-401d-a8f7-62631185ffba";
//$client_id = "NIVEA-UAT-IT";
$client_id = "NIVEA-PROD-IT-PRE";
//$client_id = "NIVEA-UAT-DE";
$crmAuthURL = "https://login.microsoftonline.com/631f985f-427e-4921-a153-c467ec975fb6/oauth2/v2.0/token";
$crmAuthScope = "api://xdcrm/.default";
$crmAuthGrant_type = "client_credentials";
$host = "gateway.api.beiersdorfgroup.com";
$loginUrl = "https://uat.nivea.it/session/signin?returnUrl=/";
}

?>
