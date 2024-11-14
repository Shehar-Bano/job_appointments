<?php

namespace App\Repositories;

interface PositionRepositoryInterface
{
    public function create($data);

    public function index($limit);

    public function show($id);

    public function update($id, $data);

    public function delete($id);
}
