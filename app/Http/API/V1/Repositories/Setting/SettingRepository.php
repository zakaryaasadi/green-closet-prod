<?php

namespace App\Http\API\V1\Repositories\Setting;


use App\Enums\UserType;
use App\Helpers\AppHelper;
use App\Http\API\V1\Core\PaginatedData;
use App\Http\API\V1\Repositories\BaseRepository;
use App\Models\Setting;
use App\Models\User;
use App\Traits\ApiResponse;
use ipinfo\ipinfo\IPinfoException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class SettingRepository extends BaseRepository
{
    use ApiResponse;

    public function __construct(Setting $model)
    {
        parent::__construct($model);
    }

    public function index(): PaginatedData
    {
        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('country_id'),
            AllowedFilter::exact('language_id'),
        ];
        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('created_at'),
        ];

        return parent::filter(Setting::class, $filters, $sorts);
    }

    /**
     * @throws IPinfoException
     */
    public function updateSettings(Setting $setting, $data): \Illuminate\Database\Eloquent\Model
    {
        $country = AppHelper::getCoutnryForMobile();
        $agents = User::where(['country_id' => $country->id, 'type' => UserType::AGENT])->with('agentSettings')->get();

        if (array_key_exists('tasks_per_day', $data)) {
            foreach ($agents as $agent) {
                if ($agent->agentSettings?->tasks_per_day == $setting->tasks_per_day)
                    $agent->agentSettings()->update(['tasks_per_day' => $data['tasks_per_day']]);
            }
        }
        if (array_key_exists('budget', $data)) {
            foreach ($agents as $agent) {
                if ($agent->agentSettings?->tasks_per_day == $setting->tasks_per_day)
                    $agent->agentSettings()->update(['tasks_per_day' => $data['tasks_per_day']]);
            }
        }
        if (array_key_exists('holiday', $data)) {
            foreach ($agents as $agent) {
                if ($agent->agentSettings?->holiday == $setting->holiday)
                    $agent->agentSettings()->update(['holiday' => $data['holiday']]);
            }
        }
        if (array_key_exists('start_work', $data)) {
            foreach ($agents as $agent) {
                if ($agent->agentSettings?->start_work == $setting->start_work)
                    $agent->agentSettings()->update(['start_work' => $data['start_work']]);
            }
        }
        if (array_key_exists('finish_work', $data)) {
            foreach ($agents as $agent) {
                if ($agent->agentSettings?->finish_work == $setting->finish_work)
                    $agent->agentSettings()->update(['finish_work' => $data['finish_work']]);
            }
        }
        if (array_key_exists('work_shift', $data)) {
            foreach ($agents as $agent) {
                if ($agent->agentSettings?->work_shift == $setting->work_shift)
                    $agent->agentSettings()->update(['work_shift' => $data['work_shift']]);
            }
        }

        return parent::update($setting, $data);

    }
}
