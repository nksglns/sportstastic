<?php

namespace App\Repositories;

use App\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class BaseRepository implements BaseRepositoryInterface
{
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function save(array $data): bool
    {
        if (count($this->validate($data)) == 0) {
            $entity = $this->model::where('id', $data['id'])->firstOrNew();
            $entity->fill(Arr::only($data, $this->model->getFillable()));
            return $entity->save();
        } else {
            return false;
        }
    }

    public function validate(array $data): array
    {
        $validator = Validator::make($data, $this->model::$validateRules);
        if ($validator->fails()) {
            return $validator->errors()->keys();
        }
        return [];
    }
}
