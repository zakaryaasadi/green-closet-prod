<?php

namespace App\Filters;

use App\Enums\UserType;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class AdminFilter implements Filter
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
        $query->where($firstProperty, 'like', "%$value%")->where('type', '=', UserType::ADMIN);
        foreach ($this->properties as $property) {
            $query->orWhere($property, 'like', "%$value%")
                ->where('type', '=', UserType::ADMIN);
        }
    }
}
