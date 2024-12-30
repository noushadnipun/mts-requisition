<?php

namespace App\Repositories\User;

interface PermissionInterface
{
    public function getAll();

    public function getById($id);

    public function getByAny($column, $value);

    public function create(array $attributes);

    public function update($id, array $attributes);

    public function delete($id);

    public function batchInsert($data);

    public function batchUpsert($search, $data);

}
