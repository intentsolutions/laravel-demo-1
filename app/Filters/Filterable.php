<?php

namespace App\Filters;

trait Filterable
{
    use BaseFilters;

    protected array $filters = [];
    protected array $sorts = [];

    private array $filtersForQuery = [];

    private ?string $sortForQuery = null;
    private string $sortDirection = 'asc';

    public function addFilters($requestFilters): self
    {
        if (is_array($requestFilters)) {
            $this->checkFilters($requestFilters);
            $this->checkSort($requestFilters);
        }

        return $this;
    }

    private function checkFilters($requestFilters): void
    {
        foreach ($requestFilters as $key => $value) {
            if (in_array($key, $this->filters)) {
                $this->filtersForQuery[$key] = $value;
            }
        }
    }
    private function checkSort($requestFilters): void
    {
        if (isset($requestFilters['sort'])) {
            if (in_array($requestFilters['sort'], $this->sorts)) {
                $this->sortForQuery = $requestFilters['sort'];
            }
        }

        if (isset($requestFilters['sort_direction'])
            && $requestFilters['sort_direction'] === 'desc') {
            $this->sortDirection = 'desc';
        }
    }

    protected function applyFiltersToQuery($query): object
    {
        foreach ($this->filtersForQuery as $field => $value) {
            $filterMethod = 'filter' . str_replace('_', '', ucwords($field, '_'));

            if (method_exists($this, $filterMethod)) {
                $this->$filterMethod($query, $value);
            } else {
                $query->where($field, $value);
            }
        }

        if ($this->sortForQuery) {
            $sortMethod = 'sort' . str_replace('_', '', ucwords($this->sortForQuery, '_'));

            if (method_exists($this, $sortMethod)) {
                $this->$sortMethod($query, $this->sortForQuery, $this->sortDirection);
            } else {
                $query->orderBy($this->sortForQuery, $this->sortDirection);
            }
        }

        return $query;
    }

    /**
     * todo need to refactor
     */
    protected function getLimit()
    {
        if (request()->get('limit') && request()->get('limit') === '-1') {
            return 1000;
        }

        if (request()->get('limit') && request()->get('limit') <= 100) {
            return request()->get('limit');
        }

        return 20;
    }
}
