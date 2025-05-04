<?php

namespace App\Filters;

use App\Models\Language;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class CountryCustomFilter implements Filter
{
    protected array $properties;

    protected ?array $languageJsonProperties = null;

    public function __construct(array $properties, array $languageJsonProperties = null)
    {
        $this->properties = $properties;
        $this->languageJsonProperties = $languageJsonProperties;
    }

    public function __invoke(Builder $query, $value, string $property)
    {
        if (is_array($value)) {
            $value = implode(' ', $value);
        }
        $firstProperty = array_shift($this->properties);
        if (request()->has('filter.province_id'))
            $query->where($firstProperty, 'like', "%$value%")->where('country_id', '=', request()->input('filter.country_id'))
                ->where('province_id', '=', request()->input('filter.province_id'));
        elseif (request()->has('filter.district_id'))
            $query->where($firstProperty, 'like', "%$value%")->where('country_id', '=', request()->input('filter.country_id'))
                ->where('district_id', '=', request()->input('filter.district_id'));
        elseif (request()->has('filter.neighborhood_id'))
            $query->where($firstProperty, 'like', "%$value%")->where('country_id', '=', request()->input('filter.country_id'))
                ->where('neighborhood_id', '=', request()->input('filter.neighborhood_id'));
        elseif (request()->has('filter.type'))
            $query->where($firstProperty, 'like', "%$value%")->where('country_id', '=', request()->input('filter.country_id'))
                ->where('type', '=', request()->input('filter.type'));
        else $query->where($firstProperty, 'like', "%$value%")->where('country_id', '=', request()->input('filter.country_id'));

        foreach ($this->properties as $property) {
            if (request()->has('filter.province_id'))
                $query->orWhere($property, 'like', "%$value%")->where('country_id', '=', request()->input('filter.country_id'))
                    ->where('province_id', '=', request()->input('filter.province_id'));
            elseif (request()->has('filter.district_id'))
                $query->orWhere($property, 'like', "%$value%")->where('country_id', '=', request()->input('filter.country_id'))
                    ->where('district_id', '=', request()->input('filter.district_id'));
            elseif (request()->has('filter.neighborhood_id'))
                $query->orWhere($property, 'like', "%$value%")->where('country_id', '=', request()->input('filter.country_id'))
                    ->where('neighborhood_id', '=', request()->input('filter.neighborhood_id'));
            elseif (request()->has('filter.type'))
                $query->orWhere($property, 'like', "%$value%")->where('country_id', '=', request()->input('filter.country_id'))
                    ->where('type', '=', request()->input('filter.type'));
            else $query->orWhere($property, 'like', "%$value%")->where('country_id', '=', request()->input('filter.country_id'));
        }

        if (!is_null($this->languageJsonProperties)) {
            $languages = Language::getActive();
            foreach ($languages as $language) {
                foreach ($this->languageJsonProperties as $propertyJson) {
                    if (request()->has('filter.province_id'))
                        $query->orWhere(function ($query) use ($propertyJson, $language, $value) {
                            return $query->where('meta->translate->' . $propertyJson . '_' . $language->code, 'like', "%$value%")->where('country_id', '=', request()->input('filter.country_id'))
                                ->where('province_id', '=', request()->input('filter.province_id'));
                        });
                    elseif (request()->has('filter.district_id'))
                        $query->orWhere(function ($query) use ($propertyJson, $language, $value) {
                            return $query->where('meta->translate->' . $propertyJson . '_' . $language->code, 'like', "%$value%")->where('country_id', '=', request()->input('filter.country_id'))
                                ->where('district_id', '=', request()->input('filter.district_id'));
                        });
                    elseif (request()->has('filter.neighborhood_id'))
                        $query->orWhere(function ($query) use ($propertyJson, $language, $value) {
                            return $query->where('meta->translate->' . $propertyJson . '_' . $language->code, 'like', "%$value%")->where('country_id', '=', request()->input('filter.country_id'))
                                ->where('neighborhood_id', '=', request()->input('filter.neighborhood_id'));
                        });
                    elseif (request()->has('filter.type'))
                        $query->orWhere(function ($query) use ($propertyJson, $language, $value) {
                            return $query->where('meta->translate->' . $propertyJson . '_' . $language->code, 'like', "%$value%")->where('country_id', '=', request()->input('filter.country_id'))
                                ->where('type', '=', request()->input('filter.type'));
                        });
                    else $query->orWhere(function ($query) use ($propertyJson, $language, $value) {
                        return $query->where('meta->translate->' . $propertyJson . '_' . $language->code, 'like', "%$value%")->where('country_id', '=', request()->input('filter.country_id'));
                    });
                }
            }

        }
    }
}
