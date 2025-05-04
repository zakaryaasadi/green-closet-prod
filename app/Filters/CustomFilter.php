<?php

namespace App\Filters;

use App\Models\Language;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class CustomFilter implements Filter
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
        $firstProperty = array_shift($this->properties);
        $query->where($firstProperty, 'like', "%$value%");
        foreach ($this->properties as $property) {
            $query->orWhere($property, 'like', "%$value%");
        }

        if (!is_null($this->languageJsonProperties)) {
            $languages = Language::getActive();
            foreach ($languages as $language) {
                foreach ($this->languageJsonProperties as $propertyJson) {
                    $query->orWhere(function ($query) use ($propertyJson, $language, $value) {
                        return $query->where('meta->translate->' . $propertyJson . '_' . $language->code, 'like', "%$value%");
                    });
                }
            }

        }
    }
}
