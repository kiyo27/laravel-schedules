<?php

namespace App\Repositories;

use App\Schedule;

class ScheduleRepository extends AbstractRepository
{
    public function getModelClass(): String
    {
        return Schedule::class;
    }

    public function getAllByOwners(int $id)
    {
        return $this->model->where('owner', $id)->get();
    }

    public function update($id, $request)
    {
        $this->model->where('id', $id)
            ->update([
                'due_date' => $request->due_date,
                'title' => $request->title,
                'description' => $request->description,
            ]);
    }

    public function search()
    {
        return $this->model->where('title', 'LIKE', '%something')->get();
    }
}
