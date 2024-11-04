<?php

namespace App\Repositories;

use App\Models\Position;

class PositionRepository implements PositionRepositoryInterface
{
    protected $job;

    public function __construct(Position $job)
    {
        $this->job = $job;
    }

    public function create($data)
    {
        return $this->job->create($data);
    }

    public function index()
    {
        return $this->job->get();
    }

    public function show($id)
    {
        return $this->job->find($id);
    }

    public function update($id, $data)
    {
        return $this->job->find($id)->update($data);
    }

    public function delete($id)
    {
        return $this->job->find($id);
    }
}
