<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Contact
 * This model handles Contact entries in the db and may provide added features.
 *
 * @author  Dylan Millikin <dylan.millikin@gmail.com>
 * @package App\Models
 */
class Contact extends Model
{
    use HasFactory;

    /**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contacts';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['full_name', 'email', 'phone', 'message'];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        /**
         * Consistently formats the phone number provided to the E164 format.
         */
        Contact::saving(
            function ($contact) {
                $contact->phone = (string)PhoneNumber::make($contact->phone);
            }
        );
    }
}
