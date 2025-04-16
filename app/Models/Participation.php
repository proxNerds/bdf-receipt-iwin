<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Participation extends Model
{
    use HasFactory;

    const WIN_STATUS = [
        -1  => [
            'label' => 'rejected',
            'button' => 'reject',
            'bs-class' => 'danger'
            ],
        0  =>[
            'label' => 'not checked',
            'button' => '',
            'bs-class' => 'primary'
            ],
        1  => [
            'label' => 'on hold',
            'button' => 'put on hold',
            'bs-class' => 'warning'
            ],
        2  => [
            'label' => 'confirmed',
            'button' => 'confirm',
            'bs-class' => 'success'
            ],
        ];


    protected $fillable = [
            'procampaign_id',
            'status',
            'receipt_number',
            'receipt_total',
            'receipt_hour',
            'receipt_minute',
            'receipt_date',
            'receipt_img1_url',
            'receipt_img2_url',
            'region',
            'shop',
            'products',
            'products_total',
            'salutation',
            'firstname',
            'lastname',
            'street',
            'street_num',
            'notes',
            'city',
            'prov',
            'zip',
            'mobile_phone',
            'privacy_tc',
            'privacy_age',
            'privacy_nl'
    ];

    /*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/

	/**
	 * Method to activate sweepstake
	 *
	 * @return bool
	*/

	public function confirm(){

        $this->status=2;
        return true;


	}

    public function onHold(){

            $this->status=1;
            return true;


	}

    public function reject(){

            $this->status=-1;
            return true;


	}

    public function isActive(){
        if($this){
            if($this->is_active){
              return true;
            } else {
              return false;
            }
        }
        return false;
      }

    public static function receiptUnique($input) {
        //dd($input);
        // if($input['receipt_date']==''){
        //     return false;
        // }
        //Log::info($input);

		$receipt_date=Carbon::createFromFormat('d/m/Y', $input['receipt_date']);
		//$receipt_date_query=Carbon::parse($receipt_date)->format('Y-m-d');
        $receipt_date_query=$input['receipt_date'];
		$count = Participation::where('receipt_date', '=', $receipt_date_query)
						->where('receipt_hour', '=', $input['receipt_hour'])
						->where('receipt_minute', '=', $input['receipt_minute'])
						->where('receipt_total', '=', $input['receipt_total'])
						->where('receipt_number', '=', $input['receipt_number'])
						->count();

		if($count>0){
			return false;
		}

		return true;

	}
}
