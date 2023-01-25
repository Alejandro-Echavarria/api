<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait ApiTrait {

    public function scopeIncluded(Builder $query)
    {
        if (!empty([$this->allowIncuded, request('included')])) {

            $relations = explode(',', request('included')); // [posts, relation2]
            $allowIncuded = collect($this->allowIncuded);

            foreach ($relations as $key => $relationship) {
                if (!$allowIncuded->contains($relationship)) {

                    unset($relations[$key]);
                }
            }

            $query->with($relations);
        }
    }

    public function scopeFilter(Builder $query)
    {
        if (isset($this->allowFilter) && !empty(request('filter'))) {
            
            $filters = request('filter');
            $allowFilter = collect($this->allowFilter);

            foreach ($filters as $filter => $value) {
                if ($allowFilter->contains($filter)) {
    
                    $query->where($filter, 'LIKE', '%' . $value . '%');
                }
            }
        }
    }

    public function scopeSort(Builder $query)
    {
        if (empty($this->allowSort) || !empty(request('sort'))) {

            $sortFields = explode(',', request('sort'));
            $allowSort = collect($this->allowSort);

            foreach ($sortFields as $sortField) {

                $direction = 'asc';

                if (substr($sortField, 0, 1) == '-') {

                    $direction = 'desc';
                    $sortField = substr($sortField, 1); // Indicamos que limpie la cadena para que no cuente el signo negativo
                }

                if ($allowSort->contains($sortField)) {

                    $query->orderBy($sortField, $direction);
                }
            }
        }
    }

    public function scopeGetOrPaginate(Builder $query)
    {
        if (request('perPage')) {

            $perPage = intval(request('perPage'));

            if ($perPage) {
                return $query->paginate($perPage);
            }
        }

        return $query->get();
    }
}