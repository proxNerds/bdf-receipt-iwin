<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Participation
 *
 * @property int $id
 * @property string $crm_id
 * @property int $status 0  - not yet managed
 *             |    1  - awaiting confirmation
 *             |    2  - confirmed
 *             |   -1  - rejected
 * @property string $receipt_number
 * @property string $receipt_total
 * @property string $receipt_hour
 * @property string $receipt_minute
 * @property string $receipt_date
 * @property string|null $receipt_img1_url
 * @property string|null $receipt_img2_url
 * @property string|null $region
 * @property string|null $shop
 * @property string|null $products
 * @property string|null $products_total
 * @property int $sweepstake_id
 * @property int $won
 * @property string|null $win_code
 * @property int $privacy_tc
 * @property int|null $privacy_age
 * @property int $privacy_nl
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Participation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Participation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Participation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Participation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Participation whereCrmId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Participation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Participation wherePrivacyAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Participation wherePrivacyNl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Participation wherePrivacyTc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Participation whereProducts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Participation whereProductsTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Participation whereReceiptDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Participation whereReceiptHour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Participation whereReceiptImg1Url($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Participation whereReceiptImg2Url($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Participation whereReceiptMinute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Participation whereReceiptNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Participation whereReceiptTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Participation whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Participation whereShop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Participation whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Participation whereSweepstakeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Participation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Participation whereWinCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Participation whereWon($value)
 */
	class Participation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

