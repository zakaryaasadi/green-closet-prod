<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * @mixin IdeHelperSetting
 */
class Setting extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'country_id',
        'language_id',
        'point_value',
        'point_count',
        'point_expire',
        'first_points',
        'first_points_expire',
        'container_value',
        'slug',
        'email',
        'mail_receiver',
        'location',
        'default_country_id',
        'phone',
        'header_title',
        'header_title_arabic',
        'auto_assign',
        'currency_ar',
        'currency_en',
        'tasks_per_day',
        'budget',
        'holiday',
        'start_work',
        'finish_work',
        'work_shift',
        'container_limit',
        'has_donation',
        'has_recycling',
        'has_recycling_admin',
        'has_donation_admin',
        'otp_active',
        'sms_user_name',
        'sms_password',
        'sms_sender_id',
        'calculate_points',
        'points_per_order',
        'favicon',
        'send_link',
        'sms_to_accepted',
        'sms_to_decline',
        'sms_to_cancel',
        'sms_to_delivering',
        'sms_to_failed',
        'secret_key',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function defaultCountry(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'default_country_id');
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
}
