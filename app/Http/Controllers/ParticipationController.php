<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Http;
use Validator;
use Log;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use App\Http\Controllers\SalesForceController;

use App\Models\Participation;
use App\Models\ParticipationDraw;

class ParticipationController extends Controller
{
    //protected $client;
    protected $sweepstake_id;
    protected $sweepstake_api_url;
    protected $api_auth_clientid;
    protected $api_auth_secret;

    protected $consentTextConcorso;
    protected $legalTextConcorso;

    protected $engagement_type;
    protected $engagement_type_winner;
    protected $engagement_description;

    public function __construct()
    {
        $this->sweepstake_id = env('SWEEPSTAKE_ID');
        $this->sweepstake_api_url = env('SWEEPSTAKE_API_URL');
        // $this->sweepstake_api_auth = 'Bearer ' . env('SWEEPSTAKE_API_TOKEN');
        $this->api_auth_clientid = env('API_AUTH_CLIENTID');
        $this->api_auth_secret = env('API_AUTH_SECRET');

        $this->consentTextConcorso = config("legal.consent_text");
        $this->legalTextConcorso = config("legal.legal_text");

        $this->engagement_type = 'Participation';
        $this->engagement_type_winner = 'IT_Nivea_LC_promo-summer';
        $this->engagement_description = '202503_NIV_PromoSummer2025';
    }

    public function has_participated($crm_id = 0, $contest_id = 0)
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/vnd.api+json'
        ];

        $url = $this->sweepstake_api_url . '/has_participated/' . $crm_id . '/' . $contest_id;

        // $api_request = Http::withHeaders($headers)->withToken($this->sweepstake_api_auth)->get($url);
        $api_request = Http::withHeaders($headers)->withBasicAuth($this->api_auth_clientid, $this->api_auth_secret)->get($url);


        if ($api_request->successful()) {
            $api_response = json_decode($api_request->body());
            //dd($api_request->body());
            $returnData['status'] = 'OK';
            $returnData['hasParticipated'] = $api_response->hasParticipated;
        } else {
            $returnData['status'] = 'KO';
            $returnData['hasParticipated'] = '';
        }


        return $returnData;
    }

    public function index(Request $request)
    {

        $view = 'home';

        $contestStatus['errors'] = '';
        $contestStatus['status'] = '';

        if (!env('APP_TESTING')) {

            Carbon::setLocale('it');
            $now = Carbon::now();

            $startDate = Carbon::createFromFormat('Y-m-d H:i:s', env('CONTEST_START_DATE'));
            $endDate = Carbon::createFromFormat('Y-m-d H:i:s', env('CONTEST_END_DATE'));

            $today = Carbon::now()->format('Y-m-d');

            $sweepstake_id = env('SWEEPSTAKE_ID', 0);

            // $has_participated = $this->

            // $view = 'home';


            $contestStatus['errors'] = '';
            $contestStatus['status'] = '';

            $startDate = env('CONTEST_START_DATE');
            $endDate = env('CONTEST_END_DATE');

            if ($now < $startDate) {
                $contestStatus['status'] = 'not-started';
                $view = 'service.not-started';
            }

            if ($now > $endDate) {
                $contestStatus['status'] = 'ended';
                $view = 'service.ended';
            }

            //uncomment if using includes in view instead of redirects
            //$view = 'home';
        }

        return view($view, compact('contestStatus'));
    }

    public function invalidIP()
    {
        return view('service.invalidip');
    }

    public function getContestStatus($id = 0)
    {
        $headers = [
            //'Authorization' => $this->sweepstake_api_auth,
            'Content-Type' => 'application/json',
            'Accept' => 'application/vnd.api+json'
        ];

        $url = $this->sweepstake_api_url . '/' . $id . '/status';

        // $api_request = Http::withHeaders($headers)->withToken($this->sweepstake_api_auth)->get($url);
        $api_request = Http::withHeaders($headers)->withBasicAuth($this->api_auth_clientid, $this->api_auth_secret)->get($url);


        if ($api_request->successful()) {
            $api_response = json_decode($api_request->body());
            //dd($api_request->body());

            $returnData['errors'] = $api_response->errors;
            $returnData['status'] = $api_response->status;
        } else {
            $returnData['errors'] = 'KO';
            $returnData['status'] = '';
        }


        return $returnData;
    }

    public function participate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'birthdate' => 'nullable|date_format:Y-m-d|before:18 years ago',
            'receipt_date' => 'required|date_format:"d/m/Y"',
            'receipt_hour' => 'required',
            'receipt_minute' => 'required',
            'receipt_total' => 'required|string|min:2',
            'receipt_number' => 'required',
            //'crm_id' => 'required',

            'email' => 'required|email',
            'firstname' => 'required',
            'lastname' => 'required',
            'dob' => 'required|date_format:Y-m-d|before:18 years ago',

            'phone' => 'required',
            'privacy_tc' => 'accepted',
            'privacy_age' => 'required',
        ]);

        $validator->after(function ($validator) use ($request) {

            if (empty($request->get('crm_id')) && (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL))) {
                $profileId = $this->mapEmailToSFProfile($request, $request->get('email'));
                if ($profileId) {
                    $request->merge(['crm_id' => $profileId]);
                } else {
                    $validator->errors()->add('crm_id', 'Questo indirizzo email appartiene ad un utente registrato, effettua il <a id="loginUrl" href="https://www.nivea.it/session/signin?returnUrl=' . url()->current() . '">login</a> o utilizza un altro indirizzo email.');
                }
            } else if (!empty($request->get('crm_id')) && (!filter_var($request->get('email'), FILTER_VALIDATE_EMAIL))) {
                $validator->errors()->add('email', 'Indirizzo email non valido.');
            }

            //check birthdate
            // if (empty($request->get('birthdate')) && ($request->get('privacy_age') == 0)) {
            //     $validator->errors()->add('birthdate', 'Per partecipare devi essere maggiorenne.');
            // }

            //check receipt date
            $receipt_date_check = str_replace('/', '-', $request->get('receipt_date'));
            $receipt_date_check = strtotime($receipt_date_check . " " . $request->get('receipt_hour') . ":" . $request->get('receipt_minute'));
            if (($receipt_date_check < strtotime(env('CONTEST_START_DATE'))) || ($receipt_date_check >= strtotime(now()))) {
                $validator->errors()->add('receipt_date_range', 'La data e/o ora dello scontrino non è valida.');
            }

            /*$diff_in_days = Carbon::now()->diffInDays(Carbon::parse($receipt_date_check));
            if($diff_in_days>5){
            $validator->errors()->add('receipt_date_max_days', 'La data dello scontrino è più vecchia di 5 giorni.');
            }*/


            if (intval(env('CONTEST_RECEIPT_MIN_TOTAL')) > 0) {
                //dd(intval($request->get('receipt_total')));
                if (intval($request->get('receipt_total')) < intval(env('CONTEST_RECEIPT_MIN_TOTAL', 10))) {
                    $validator->errors()->add('receipt_total', 'L\'importo dello scontrino deve essere di almeno ' . env('CONTEST_RECEIPT_MIN_TOTAL', 10) . '€.');
                }
            }

            //check if receipt is receiptUnique
            if (!empty($request->get('receipt_date')) && !empty($request->get('receipt_hour')) && !empty($request->get('receipt_minute')) && !empty($request->get('receipt_total')) && !empty($request->get('receipt_number'))) {
                if (!Participation::receiptUnique($request)) {
                    $validator->errors()->add('receipt_duplicate', 'Questo scontrino è già stato utilizzato.');
                }
            }
        });

        if ($validator->fails()) {
            return response()->json(['msg' => 'OK', 'errors' => $validator->errors()], 200);
            //return back()->withErrors( $validator )->withInput();
        }

        $input_fields['sweepstake_id'] = $this->sweepstake_id;
        $input_fields['ext_id'] = request('crm_id');
        $input_fields['email'] = request('email');

        $input_fields['receipt_number'] = request('receipt_number');
        $input_fields['receipt_total'] = request('receipt_total');
        $input_fields['receipt_hour'] = request('receipt_hour');
        $input_fields['receipt_minute'] = request('receipt_minute');
        $input_fields['receipt_date'] = request('receipt_date');

        $input_fields['privacy_tc'] = request('privacy_tc');
        $input_fields['privacy_age'] = 1;

        $winCode = Str::uuid()->toString();
        $input_fields['extra_win_code'] = $winCode;



        //TEST
        // participation sent to bdf-contest
        $play = $this->play($input_fields);
        // $play['errors'] = true;
        // dd($play);
        if ($play['errors'] == true) {

            //if play NOT OK return errors
            $errors = new MessageBag;
            foreach ($play as $key => $value) {
                if ($key != 'errors') {
                    $errors->add($key, $value);
                }
            }
            //dd($errors);
            return response()->json(['errors' => $errors], 200);
        } else {

            //if play OK save data  in local DB

            $participation = new Participation;
            $participation->crm_id = $input_fields['ext_id'];
            //$participation->email = $input_fields['email'];
            $participation->receipt_number = $input_fields['receipt_number'];
            $participation->receipt_total = $input_fields['receipt_total'];
            $participation->receipt_hour = $input_fields['receipt_hour'];
            $participation->receipt_minute = $input_fields['receipt_minute'];
            $participation->receipt_date = $input_fields['receipt_date'];
            $participation->status = 1;
            $participation->sweepstake_id = $this->sweepstake_id;
            $participation->won = $play['won'];
            $participation->win_code = $winCode;
            $participation->privacy_tc = $input_fields['privacy_tc'];
            $participation->privacy_age = $input_fields['privacy_age'];
            if ($request->has('privacy_nl')) {
                $participation->privacy_nl = request('privacy_nl');
            }

            if (!$participation->save()) {
                $errors = new MessageBag;
                foreach ($play as $key => $value) {
                    if ($key != 'errors') {
                        $errors->add($key, $value);
                    }
                }
                return response()->json($errors, 200);
            } else {
                $ref_id = $participation->id;
            }

            //TEST
            // send data to SslesForce
            $sf = $this->saveParticipationToSF($request, $play);

            $messages = new MessageBag;
            foreach ($play as $key => $value) {
                if ($key != 'errors') {
                    $messages->add($key, $value);
                }
            }
            $messages->add('typ_external', env('CONTEST_TYP_EXTERNAL'));
            if (env('CONTEST_TYP_EXTERNAL')) {
                $messages->add('typ_win_url', env('CONTEST_TYP_WIN_URL'));
                $messages->add('typ_loose_url', env('CONTEST_TYP_LOOSE_URL'));
            }

            return response()->json($messages, 200);
        }

        //return $play;

    }

    public function play($input_fields)
    {

        //$test_ext_id = 'asdfas.2345sda)0';

        $headers = [
            //'Authorization' => $this->sweepstake_api_auth,
            'Content-Type' => 'application/json',
            'Accept' => 'application/vnd.api+json'
        ];

        $url = $this->sweepstake_api_url . '/play';

        // $api_request = Http::withHeaders($headers)->withToken($this->sweepstake_api_auth)->get($url);
        $api_request = Http::withHeaders($headers)->withBasicAuth($this->api_auth_clientid, $this->api_auth_secret)->get($url);

        $body = [
            'sweepstake_id' => $input_fields['sweepstake_id'],
            'ext_id' => $input_fields['ext_id'],
            //'extra_email' => $input_fields['email'],
            'extra_receipt_number' => $input_fields['receipt_number'],
            'extra_receipt_total' => $input_fields['receipt_total'],
            'extra_receipt_hour' => $input_fields['receipt_hour'],
            'extra_receipt_minute' => $input_fields['receipt_minute'],
            'extra_receipt_date' => $input_fields['receipt_date'],
            'privacy_tc' => $input_fields['privacy_tc'],
            'privacy_age' => $input_fields['privacy_age'],
            'extra_win_code' => $input_fields['extra_win_code'],
        ];



        $returnData = [];

        $api_request = Http::withHeaders($headers)->withBasicAuth($this->api_auth_clientid, $this->api_auth_secret)->post($url, $body);


        //dd($api_request->body());

        if ($api_request->successful()) {
            $api_response = json_decode($api_request->body());
            //dd($api_request->body());

            $returnData['errors'] = $api_response->errors;
            if (!$api_response->errors) {
                $returnData['won'] = $api_response->won;
                $returnData['award'] = $api_response->award;
                $returnData['winCode'] = $input_fields['extra_win_code'];
            } else {
                foreach ($api_response as $key => $value) {
                    if ($key != "errors") {
                        $returnData[$key] = $value;
                    }
                }
            }
        } else {
            $returnData['errors'] = true;
            $returnData['status'] = 'System error';
        }



        return $returnData;
    }

    /**
     * Save participation data into a SalesForce Engagement
     * @param Request $request Object containing participation data
     * @param bool $winner indicates if the participant is a winner
     * @param null $code win code generated for this participation
     *
     * @return bool true if data are correctly saved, false in case of api error
     */
    public function saveParticipationToSF(Request $request, $play)
    {
        $profileId = $request->get('crm_id');
        $prize_name = '';
        if (!$profileId) {
            $profileId = $request->get('email');
        }

        if ($profileId) {

            $participation = Participation::where('crm_id', $profileId)->orderBy('id', 'DESC')->first();
            // Source and URL
            // should be sent with each request
            $xsource = "sfconnect-development";
            $referer = "https://www.beiersdorf.com";

            // Please always include these 2 files:
            require_once $_SERVER['DOCUMENT_ROOT'] . '/sf-connect/crmapi.php';
            require_once $_SERVER['DOCUMENT_ROOT'] . '/sf-connect/config.php';

            // The URL for the API call, including profile ID
            $url = "https://gateway.api.beiersdorfgroup.com/xdcrm/api/v1.0/users/" . $profileId . "/engagements";

            $apiresult = "";
            if ($play['won']) {
                // The full JSON to be submitted. Please comment out what you don't need.
                $data_array = array(
                    "engagementTypeName" => $this->engagement_type_winner,
                    "description" => $this->engagement_description . '_Winner',
                    "attributes" => array(
                        'id18' => $participation->crm_id, //18 digits SF contactId
                        'receipt_date' => $participation->receipt_date,
                        'receipt_time' => $participation->receipt_hour . ':' . $participation->receipt_minute,
                        'receipt_amount' => $participation->receipt_total,
                        'receipt_number' => $participation->receipt_number,
                        'firstname' => $request->get('firstname'),
                        'lastname' => $request->get('lastname'),
                        'phone' => $request->get('phone'),
                        'dob' => $request->get('dob'),
                        'winner' => $play['won'] ? 'true' : 'false',
                        'prize' => $play['award'],
                        'code' => $play['winCode'] ? $play['winCode'] : null,
                        'ConsentText_TermsConditions' => $this->consentTextConcorso,
                    ),
                );

                $data = json_encode($data_array);

                // This is the call to the corresponding function from "crmapi.php".
                // $apiresult will contain the API's answer in JSON format.
                // Please examine the status code and implement proper error handling if it is not 200.
                // In the errors object, there is an error code and a message.
                // Unfortunately, we can't deliver a complete list of status codes at this time.

                $apiresult = crmPostRequest($url, $data, $xsource, $referer);
                $apiresult_decoded = json_decode($apiresult, true);
            }

            $data_array = array(
                "engagementTypeName" => $this->engagement_type,
                "description" => $this->engagement_description . '_Participation',
                "attributes" => array(
                    'id18' => $participation->crm_id,
                    'receipt_date' => $participation->receipt_date,
                    'receipt_time' => $participation->receipt_hour . ':' . $participation->receipt_minute,
                    'receipt_amount' => $participation->receipt_total,
                    'receipt_number' => $participation->receipt_number,
                    'firstname' => $request->get('firstname'),
                    'lastname' => $request->get('lastname'),
                    'phone' => $request->get('phone'),
                    'dob' => $request->get('dob'),
                    'winner' => $play['won'] ? 'true' : 'false',
                    'prize' => $play['award'],
                    'code' => $play['winCode'] ? $play['winCode'] : null,
                    'ConsentText_TermsConditions' => $this->consentTextConcorso,
                ),
            );

            $data = json_encode($data_array);

            $apiresult_part = crmPostRequest($url, $data, $xsource, $referer);

            $apiresult_part_decoded = json_decode($apiresult_part, true);

            if (isset($apiresult_part_decoded["errors"]) || (isset($apiresult_part_decoded["status"]) && $apiresult_part_decoded["status"] != 200)) {
                // api error
                Log::error("User: " . $profileId . " --> " . chr(10) . "Winner engagement: " . $apiresult_decoded . chr(10) . chr(10) . "participation engagement: " . $apiresult_part_decoded["errors"][0]["message"]);
                return false;
            } else {
                // OK
                return true;
            }
        }
        return false;
    }

    /**
     * Save participation data into a SalesForce Engagement
     * @param Request $request Object containing participation data
     * @param bool $winner indicates if the participant is a winner
     * @param null $code win code generated for this participation
     *
     * @return bool true if data are correctly saved, false in case of api error
     */
    public function mapEmailToSFProfile(Request $request, $email)
    {
        // Setup
        $xsource = "sfconnect-development";
        $referer = "https://www.beiersdorf.com";

        // Please always include these 2 files:
        require_once $_SERVER['DOCUMENT_ROOT'] . '/sf-connect/crmapi.php';
        require_once $_SERVER['DOCUMENT_ROOT'] . '/sf-connect/config.php';


        // URL for API call
        $url = "https://gateway.api.beiersdorfgroup.com/xdcrm/api/v1.0/auth/local-sign-up";

        $data_array = array(

            "email"         => $email,
            "permissions"    => "newsletter-subscriptions",
            //		"source"		=> "will-also-be-used-in-future"

        );

        $data = json_encode($data_array);

        $apiresult = crmPostRequest($url, $data, $xsource, $referer);
        $apiresult_decoded = json_decode($apiresult, true);

        if (isset($apiresult_decoded["errors"]) || (isset($apiresult_decoded["status"]) && $apiresult_decoded["status"] != 200)) {
            // api error
            //Log::error("User: " . $email . " --> " . chr(10) . "Map Email To Profile: " . var_dump($apiresult_decoded));
            return null;
        } else {
            // OK
            // Log::info("User: " . $request->get('email') . " --> " . chr(10) . "mapEmailToSFProfile: " . var_dump($apiresult_decoded));

            $this->setProfileDataToSFProfile($request);
            return $apiresult_decoded["profileId"];
        }
    }

    public function setProfileDataToSFProfile(Request $request)
    {
        // Setup
        $xsource = "sfconnect-development";
        $referer = "https://www.beiersdorf.com";

        // Please always include these 2 files:
        require_once $_SERVER['DOCUMENT_ROOT'] . '/sf-connect/crmapi.php';
        require_once $_SERVER['DOCUMENT_ROOT'] . '/sf-connect/config.php';


        // URL for API call
        $url = "https://gateway.api.beiersdorfgroup.com/xdcrm/api/v1.0/consumers";

        $data_array = array(
            "profile"    => array(
                "firstName"     => $request->get('firstname'),
                "lastName"      => $request->get('lastname'),
                "email"         => $request->get('email'),                    // mandatory
                "phone"         => $request->get('phone'),
                "birthdate"     => $request->get('dob'),
            ),

            // "consents"    => array(array(
            //     "id"            => "1",                // for consents, please make sure
            //     "name"            => "PrivacyPolicy",            // that the ID changes every time there
            //     "text"            => config('legal.consent_text')        // has been a text modification in the
            // )),
            // "newsletterSubscriptions" => array(array(
            //     "topic"            =>"NIVEA_myNIVEA",
            //     // "topic"            =>"myNIVEA",
            // )),


            //		"source"		=> "will-also-be-used-in-future"
        );

        $data = json_encode($data_array);

        $apiresult = crmPostRequest($url, $data, $xsource, $referer);
        $apiresult_decoded = json_decode($apiresult, true);

        if (isset($apiresult_decoded["errors"]) || (isset($apiresult_decoded["status"]) && $apiresult_decoded["status"] != 200)) {
            // api error
            //Log::error("User: " . $email . " --> " . chr(10) . "Map Email To Profile: " . var_dump($apiresult_decoded));
            return null;
        } else {
            // OK
            // Log::info("User: " . $request->get('email') . " --> " . chr(10) . "setProfileDataToSFProfile: " . var_dump($apiresult_decoded));
            return true;
        }
    }
}
