<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;

class SalesForceController extends Controller
{
    /**
     * Checks if the user is logged in and if yes gets user data and memberships
     *
     * @return string JSON that indicates if user is logged in or not and if logged in contains user Pdata and memberships,
     */

    public function checkUser()
    {
        //die($_SERVER['DOCUMENT_ROOT']);
        require $_SERVER['DOCUMENT_ROOT'] . '/sf-connect/crmapi.php';
        require $_SERVER['DOCUMENT_ROOT'] . '/sf-connect/config.php';

        $xsource = "sfconnect-development";
        $referer = "https://www.beiersdorf.com";

        $responseData = [];

        // get profile id if logged
        // The URL for the necessary API call
        $url = "https://gateway.api.beiersdorfgroup.com/xdcrm/api/v1.0/auth/sign-in-with-token";

        $crm_auth = isset($_COOKIE["crm_auth"]) ? $_COOKIE["crm_auth"] : '';

        if (empty($crm_auth)) {
            return response()->json([
                'message' => 'KO',
                'confirmed' => false,
                'Data' => $responseData,
                'errors' => 'User not logged in'
            ], 200);
        }

        // Please note that the token value is submitted with quotation marks!
        //echo $crm_auth;
        $token = chr(34) . $crm_auth . chr(34);

        // This is the call to the corresponding function from "crmapi.php".
        // $apiresult will contain a JSON with the token and the profile ID.
        // If there is no profile ID, there is an error code.

        $apiresult = crmPostRequest($url, $token, $xsource, $referer);
        $answer = json_decode($apiresult, true);

        if (isset($answer['profileId'])) {
            $profileId = $answer['profileId'];
            $userLogonGuid = $answer['profileId'];

            // get profile data
            $url = "https://gateway.api.beiersdorfgroup.com/xdcrm/api/v1.0/users/" . $profileId . "/profile";

            $crmapiacc = setAuthToken();
            $header = "Authorization: Bearer " . $crmapiacc . "\n";
            $header = $header . "X-Client-Id: " . $client_id;
            $options = "";

            // Initiate simple GET call
            $result = json_decode(crmGetRequest($url, $header, $options));

            foreach ($result as $key => $value) {
                switch ($key) {
                    case 'email':
                        $userEmail = $value;
                        break;
                    case 'firstName':
                        $userFirstname = $value;
                        break;
                    case 'lastName':
                        $userLastname = $value;
                        break;
                    case 'birthdate':
                        $userBirthday = $value;
                        break;
                    case 'salutation':
                        $userSalutation = $value;
                        break;
                    case 'gender':
                        $userGender = $value;
                }
            }

            //check if user has myNIVEA membership

            // get user memberships
            // The URL for the API call, including profile ID
            $url = "https://gateway.api.beiersdorfgroup.com/xdcrm/api/v1.0/users/" . $profileId . "/memberships";

            $crmapiacc = setAuthToken();
            $header = "Authorization: Bearer " . $crmapiacc . "\n";
            $header = $header . "X-Client-Id: " . $client_id;
            $options = "";

            // Initiate simple GET call
            $result = json_decode(crmGetRequest($url, $header, $options));
            //$userCommunity = false;
            $membership_ok = false;
            foreach ($result as $key => $value) {
                if ($value->name == 'myNIVEA') {
                    $membership_ok = true;
                }
            }

            // check if user has subscription topic NIVEA_myNIVEA
            // The URL for the API call, including profile ID
            $url = "https://gateway.api.beiersdorfgroup.com/xdcrm/api/v1.0/users/" . $profileId . "/subscriptions";

            $crmapiacc = setAuthToken();
            $header = "Authorization: Bearer " . $crmapiacc . "\n";
            $header = $header . "X-Client-Id: " . $client_id;
            $options = "";

            // Initiate simple GET call
            $result = json_decode(crmGetRequest($url, $header, $options));
            $subscription_ok = false;
            foreach ($result as $subscription) {
                if ($subscription->topic == "NIVEA_myNIVEA") {
                    $subscription_ok = true;
                }
            }

            // check if user has completed the profile with firstname, lastname and subscription topic NIVEA_myNIVEA
            $userCommunity = false;

            // uncomment if you have to skip membership validation
            //$subscription_ok = true;

            //if(!empty($userFirstname) && !empty($userLastname) && ($subscription_ok || $membership_ok)){
            if (!empty($userFirstname) && !empty($userLastname) && ($membership_ok)) {
                $userCommunity = true;
            }


            $responseData = array(
                'Email' => $userEmail, //get_user_profile
                'list:NIVEA_Community' => $userCommunity, //get_user_memberships
                'Firstname' => $userFirstname, //get_user_profile
                'Lastname' => $userLastname, //get_user_profile
                'Birthday' => $userBirthday, //get_user_profile
                'LogonGuid' => $userLogonGuid, // profileId
                'Salutation' => $userSalutation, //get_user_profile
                'Gender' => $userGender, //get_user_profile
                'ListNL' => $subscription_ok,
                'ListEmail' => $subscription_ok,
                'ListCommunity' => $userCommunity,
                // 'list:NIVEA_Email' => $userListEmail,
                // 'list:NIVEA_E_Newsletter' => $userListNL,

            );

            if ($userCommunity) {
                return response()->json([
                    'message' => 'OK',
                    'confirmed' => true,
                    'Data' => $responseData,
                    'errors' => ''
                ], 200);
            } else {
                return response()->json([
                    'message' => 'KO',
                    'confirmed' => false,
                    'Data' => $responseData,
                    'errors' => ''
                ], 200);
            }
        } else { // user not logged in
            return response()->json([
                'message' => 'KO',
                'confirmed' => false,
                'Data' => $responseData,
                'errors' => $answer['detail'],
            ], 200);
        }
    }

    /**
     * Get user profile ID if the user is logged in
     *
     * @return string JSON that indicates if user is logged in or not and if logged in contains user Pdata and memberships,
     */

    public function get_profile_id()
    {
        require $_SERVER['DOCUMENT_ROOT'] . '/sf-connect/crmapi.php';
        require $_SERVER['DOCUMENT_ROOT'] . '/sf-connect/config.php';

        $xsource = "sfconnect-development";
        $referer = "https://www.beiersdorf.com";

        // The URL for the necessary API call
        $url = "https://gateway.api.beiersdorfgroup.com/xdcrm/api/v1.0/auth/sign-in-with-token";

        $crm_auth = isset($_COOKIE["crm_auth"]) ? $_COOKIE["crm_auth"] : '';
        // Please note that the token value is submitted with quotation marks!
        //echo $crm_auth;
        $token = chr(34) . $crm_auth . chr(34);

        // This is the call to the corresponding function from "crmapi.php".
        // $apiresult will contain a JSON with the token and the profile ID.
        // If there is no profile ID, there is an error code.

        $apiresult = crmPostRequest($url, $token, $xsource, $referer);
        $answer = json_decode($apiresult, true);

        //if user is logged, get profile id
        if (isset($answer['profileId'])) {
            session(['profileId' => $answer['profileId']]);
            $user_profile = $this->get_user_profile(session('profileId', ''));
            $user_memberships = $this->get_user_memberships(session('profileId', ''));
            var_dump($user_profile);
        }

        $responseData = array(
            'Email' => $userEmail, //get_user_profile
            'list:NIVEA_Community' => $userCommunity, //get_user_memberships
            'Firstname' => $userFirstname, //get_user_profile
            'Lastname' => $userLastname, //get_user_profile
            'Birthday' => $userBirthday, //get_user_profile
            'LogonGuid' => $userLogonGuid, // profileId
            'Salutation' => $userSalutation, //get_user_profile
            'list:NIVEA_Email' => $userListEmail,
            'list:NIVEA_E_Newsletter' => $userListNL,

        );

        return view('sf-connect', compact('answer'));
        // if ($answer['status'] != 200) {
        //     echo $answer['title'] . ': ' . $answer['detail'];
        // } else {
        //     $profileId = $answer['profileId'];
        //     echo $profileId;
        // }
    }

    /**
     * Get user personal data
     *
     * @param Request $request
     *
     * @return string JSON containing user's personal data
     */

    public function get_user_profile(Request $request)
    {
        $result = '';
        $profileId = session('profileId', '');
        if ($profileId) {
            require $_SERVER['DOCUMENT_ROOT'] . '/sf-connect/crmapi.php';
            require $_SERVER['DOCUMENT_ROOT'] . '/sf-connect/config.php';

            // Read user's profile ID
            // session_start();
            // $profileId = $_SESSION['profileId'];

            // The URL for the API call, including profile ID
            $url = "https://gateway.api.beiersdorfgroup.com/xdcrm/api/v1.0/users/" . $profileId . "/profile";

            $crmapiacc = setAuthToken();
            $header = "Authorization: Bearer " . $crmapiacc . "\n";
            $header = $header . "X-Client-Id: " . $client_id;
            $options = "";

            // Initiate simple GET call
            $result = crmGetRequest($url, $header, $options);
        }

        // From here, continue with the profile JSON
        return json_decode("[" . $result . "]");
    }

    /**
     * Get user memberships
     *
     * @param Request $request
     *
     * @return string JSON containing user's memberships
     */

    public function get_user_memberships(Request $request)
    {
        $result = '';
        $profileId = session('profileId', '');
        if ($profileId) {
            require $_SERVER['DOCUMENT_ROOT'] . '/sf-connect/crmapi.php';
            require $_SERVER['DOCUMENT_ROOT'] . '/sf-connect/config.php';

            // Read user's profile ID
            // session_start();
            // $profileId = $_SESSION['profileId'];

            // The URL for the API call, including profile ID
            $url = "https://gateway.api.beiersdorfgroup.com/xdcrm/api/v1.0/users/" . $profileId . "/memberships";

            $crmapiacc = setAuthToken();
            $header = "Authorization: Bearer " . $crmapiacc . "\n";
            $header = $header . "X-Client-Id: " . $client_id;
            $options = "";

            // Initiate simple GET call
            $result = crmGetRequest($url, $header, $options);
        }

        // From here, continue with the profile JSON
        return json_decode($result);
    }

    public function get_user_care_profile(Request $request)
    {
        $result = '';
        $profileId = session('profileId', '');

        if ($profileId) {
            // Include Config and API files
            require $_SERVER['DOCUMENT_ROOT'] . '/sf-connect/crmapi.php';
            require $_SERVER['DOCUMENT_ROOT'] . '/sf-connect/config.php';

            // Read user's profile ID
            // session_start();
            // $profileId = $_SESSION['profileId'];

            // The URL for the API call, including profile ID
            $url = "https://gateway.api.beiersdorfgroup.com/xdcrm/api/v1.0/users/" . $profileId . "/careProfile";

            $crmapiacc = setAuthToken();
            $header = "Authorization: Bearer " . $crmapiacc . "\n";
            $header = $header . "X-Client-Id: " . $client_id;
            $options = "";

            // Initiate simple GET call
            $result = crmGetRequest($url, $header, $options);
        }

        // From here, continue with the profile JSON
        return json_decode($result);
    }

    public function get_user_channel_permissions(Request $request)
    {
        $result = '';
        $profileId = session('profileId', '');
        if ($profileId) {
            require $_SERVER['DOCUMENT_ROOT'] . '/sf-connect/crmapi.php';
            require $_SERVER['DOCUMENT_ROOT'] . '/sf-connect/config.php';

            // Read user's profile ID
            // session_start();
            // $profileId = $_SESSION['profileId'];

            // The URL for the API call, including profile ID
            $url = "https://gateway.api.beiersdorfgroup.com/xdcrm/api/v1.0/users/" . $profileId . "/channel-permissions";

            $crmapiacc = setAuthToken();
            $header = "Authorization: Bearer " . $crmapiacc . "\n";
            $header = $header . "X-Client-Id: " . $client_id;
            $options = "";

            // Initiate simple GET call
            $result = crmGetRequest($url, $header, $options);
        }
        // From here, continue with the profile JSON
        return json_decode($result);
    }

    public function get_user_nl_subscription(Request $request)
    {
        $result = '';
        $profileId = session('profileId', '');
        if ($profileId) {
            require $_SERVER['DOCUMENT_ROOT'] . '/sf-connect/crmapi.php';
            require $_SERVER['DOCUMENT_ROOT'] . '/sf-connect/config.php';

            // Read user's profile ID
            // session_start();
            // $profileId = $_SESSION['profileId'];

            // The URL for the API call, including profile ID
            $url = "https://gateway.api.beiersdorfgroup.com/xdcrm/api/v1.0/users/" . $profileId . "/subscriptions";

            $crmapiacc = setAuthToken();
            $header = "Authorization: Bearer " . $crmapiacc . "\n";
            $header = $header . "X-Client-Id: " . $client_id;
            $options = "";

            // Initiate simple GET call
            $result = crmGetRequest($url, $header, $options);
        }
        // From here, continue with the profile JSON
        return json_decode($result);
    }

    public function write_engagement(Request $request)
    {
        // $profileId, $engagementType, $engagementDescription, $attributes
        $profileId = session('profileId', '');
        if ($profileId) {
            $validator = Validator::make($request->all(), [
                // 'profile_id' => 'required',
                // 'engagement_type' => 'required',
                // 'engagement_description' => 'required',
                'attributes' => 'required|array',
            ]);

            if ($validator->fails()) {
                return response()->json(['msg' => 'KO', 'errors' => $validator->errors()], 200);
            }

            // Source and URL
            // should be sent with each request
            $xsource = "sfconnect-development";
            $referer = "https://www.beiersdorf.com";

            // Please always include these 2 files:
            require $_SERVER['DOCUMENT_ROOT'] . '/sf-connect/crmapi.php';
            require $_SERVER['DOCUMENT_ROOT'] . '/sf-connect/config.php';

            // The URL for the API call, including profile ID
            $url = "https://gateway.api.beiersdorfgroup.com/xdcrm/api/v1.0/users/" . $profileId . "/engagements";

            // The full JSON to be submitted. Please comment out what you don't need.
            $data_array = array(
                "engagementTypeName" => $this->engagement_type,
                "description" => $this->engagement_description,
                "attributes" => array(
                    "someAttribute1" => "someAttributeValue1",
                    "someAttribute2" => "someAttributeValue2",
                ),
            );

            $data = json_encode($data_array);

            // This is the call to the corresponding function from "crmapi.php".
            // $apiresult will contain the API's answer in JSON format.
            // Please examine the status code and implement proper error handling if it is not 200.
            // In the errors object, there is an error code and a message.
            // Unfortunately, we can't deliver a complete list of status codes at this time.

            $apiresult = crmPostRequest($url, $data, $xsource, $referer);

            // Implement your reaction to succesful storage here.
            return response()->json(['msg' => 'OK', 'result' => $apiresult], 200);
        }

        return response()->json(['msg' => 'KO', 'errors' => 'User not logged in'], 200);
    }
}
