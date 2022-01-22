<?php

namespace App\Repositories;

use Illuminate\Support\Str;

abstract class AbstractRepository
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function findAll()
    {
        return $this->model->all();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, string $id)
    {
        return $this->model->find($id)->update($data);
    }

    public function delete(string $id)
    {
        return $this->model->find($id)->delete();
    }

    public function paginate(int $pages)
    {
        return $this->model->paginate($pages);
    }
}
