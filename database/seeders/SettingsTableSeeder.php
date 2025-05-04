<?php

namespace Database\Seeders;

use App\Enums\DaysEnum;
use App\Enums\DischargeShift;
use App\Models\Country;
use App\Models\Language;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    protected int $days = 14;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $UAE = Country::whereCode('AE')->first();
        $KSA = Country::whereCode('SA')->first();
        $KW = Country::whereCode('KW')->first();

        $arabicLanguage = Language::whereCode('ar')->first();
        $englishLanguage = Language::whereCode('en')->first();

        $this->createSettingByCountry($UAE->id, $arabicLanguage->id, 0.5, 0.5, 10,
            100, 20, 0.5, 'uae-ar', 'iteamjad@gmail.com',
            'الامارات – الفروانية – خيطان – قطعة 7', $UAE->id, '+971934922354', 'KISWA UAE', 1,
            'د.إ', 'AED'
        );

        $this->createSettingByCountry($KSA->id, $englishLanguage->id, 0.5, 0.5, 10,
            100, 20, 0.5, 'ksa-ar', 'iteSaudi@gmail.com',
            'السعودية – الفروانية – خيطان – قطعة 7', $KSA->id, '+971934922354', 'KISWA KSA', 0,
            'ريال', 'SAR');

        $this->createSettingByCountry($KW->id, $arabicLanguage->id, 0.5, 0.5, 10,
            100, 20, 0.5, 'kwt-ar', 'iteKW@gmail.com',
            'الكويت – الفروانية – خيطان – قطعة 7', $UAE->id, '+971934922354', 'KISWA KWT', 0,
            'د.ك', 'KED'
        );

        $this->createGeneralSetting($englishLanguage->id, 0.5, 0.5, 10,
            100, 20, 0.5, 'uae-ar', 'iteSaudi@gmail.com',
            'السعودية – الفروانية – خيطان – قطعة 7', $UAE->id, '+971934922354', 'KISWA KSA', 1);

    }

    public static function createSettingByCountry(
        $countryId, $languageId, $pointValue,
        $pointCount, $pointExpire,
        $firstPoints, $firstPointsExpire, $containerValue, $slug,
        $email, $location, $defaultCountryId, $phone, $headerTitle,
        $autoAssign, $currencyAr = null, $currencyEn = null): Model|Setting
    {
        return Setting::create([
            'country_id' => $countryId,
            'language_id' => $languageId,
            'point_value' => $pointValue,
            'point_count' => $pointCount,
            'point_expire' => $pointExpire,
            'first_points' => $firstPoints,
            'first_points_expire' => $firstPointsExpire,
            'container_value' => $containerValue,
            'mail_receiver' => 'ramez.alharri@flick.ae',
            'slug' => $slug,
            'email' => $email,
            'location' => $location,
            'default_country_id' => $defaultCountryId,
            'phone' => $phone,
            'header_title' => $headerTitle,
            'auto_assign' => $autoAssign,
            'currency_ar' => $currencyAr,
            'currency_en' => $currencyEn,
            'tasks_per_day' => 5,
            'budget' => 100,
            'holiday' => DaysEnum::SATURDAY,
            'start_work' => '12:00',
            'secret_key' => '2SxbqoyGQgrQNRM2MgwzH6H3hvdFOFenm7nsW2mX',
            'finish_work' => '04:00',
            'work_shift' => DischargeShift::EVENING_SHIFT,
            'favicon' => 'https://green-closet.com/storage/all_media/favicon (2)_20230403102147000.png',
            'header_title_arabic' => 'جرين كلوزيت',
        ]);
    }

    public static function createGeneralSetting(
        $languageId,
        $pointValue,
        $pointCount, $pointExpire,
        $firstPoints, $firstPointsExpire,
        $containerValue, $slug,
        $email, $location, $defaultCountryId,
        $phone, $headerTitle,
        $autoAssign, $currencyAr = null, $currencyEn = null): Model|Setting
    {
        return Setting::create([
            'country_id' => null,
            'language_id' => $languageId,
            'point_value' => $pointValue,
            'point_count' => $pointCount,
            'point_expire' => $pointExpire,
            'first_points' => $firstPoints,
            'first_points_expire' => $firstPointsExpire,
            'container_value' => $containerValue,
            'slug' => $slug,
            'email' => $email,
            'mail_receiver' => 'ramez.alharri@flick.ae',
            'location' => $location,
            'default_country_id' => $defaultCountryId,
            'phone' => $phone,
            'header_title' => $headerTitle,
            'auto_assign' => $autoAssign,
            'currency_ar' => $currencyAr,
            'currency_en' => $currencyEn,
            'secret_key' => '2SxbqoyGQgrQNRM2MgwzH6H3hvdFOFenm7nsW2mX',
            'tasks_per_day' => 5,
            'budget' => 100,
            'holiday' => DaysEnum::SATURDAY,
            'start_work' => '12:00',
            'finish_work' => '04:00',
            'work_shift' => DischargeShift::EVENING_SHIFT,
            'favicon' => 'https://green-closet.com/storage/all_media/favicon (2)_20230403102147000.png',
            'header_title_arabic' => 'جرين كلوزيت',
        ]);
    }
}
