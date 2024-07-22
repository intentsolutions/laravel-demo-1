<?php

namespace App\Repositories;

use App\Filters\Filterable;

abstract class BaseRepository
{
    use Filterable;

    protected string $model;

    public function getAll($params): mixed
    {
        return $this->addFilters($params)
            ->applyFiltersToQuery($this->model::query())
            ->paginate($this->getLimit());
    }

    public function getById(int $id): mixed
    {
        return $this->model::find($id);
    }

    public function create(array $data): mixed
    {
        return $this->model::create($data);
    }

    public function update(array $data, int $id): mixed
    {
        return tap($this->model::whereId($id)->first())->update($data);
    }

    public function delete(int $id): mixed
    {
        return $this->model::whereId($id)->delete();
    }
}
