<?php

namespace App\Http\API\V1\Repositories;

use App\Http\API\V1\Core\PaginatedData;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;

abstract class BaseRepository
{
    protected Model $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function filter($relation, $filters = [], $sorts = [], $defaultSorts = [], $perPage = 15): PaginatedData
    {
        $per_page = request('per_page', $perPage);
        $entities = QueryBuilder::for($relation)
            ->defaultSorts($defaultSorts)
            ->allowedFilters($filters)
            ->allowedSorts($sorts);

        return new PaginatedData($entities, $per_page);
    }

    public function getAllData($relation, $filters = [], $sorts = [], $defaultSorts = []): Collection|array
    {
        return QueryBuilder::for($relation)
            ->defaultSorts($defaultSorts)
            ->allowedFilters($filters)
            ->allowedSorts($sorts)->get();
    }

    public function index(): PaginatedData
    {
        return $this->filter($this->model, [], []);
    }

    public function show(Model $model): Model
    {
        return $model;
    }

    public function store($data): Model
    {
        return $this->model::create($data);
    }

    public function update(Model $model, $attributes): Model
    {
        $model->fill($attributes);
        $model->save();

        return $model;
    }

    public function updateWithMeta(Model $model, array $data): Model
    {
        if (array_key_exists('meta', $data)) {
            $meta = $data['meta'];
            $data['meta'] = array_replace_recursive($model->meta, $meta);
        }

        return $this->update($model, $data);
    }

    /**
     * @param Model $model
     * @return bool|null
     */
    public function delete(Model $model): ?bool
    {
        return $model->delete();
    }
}

