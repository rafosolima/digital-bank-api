<?php

namespace App\Repositories\Contracts;

interface IBaseRepository
{
    public function findAll();
    public function find(string $id);
    public function create(array $payload);
    public function update(array $payload, string $id);
    public function delete(string $id);
    public function paginate(int $pages);
}
