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

    public function update(int $id, $request)
    {
        $this->model->where('id', $id)
            ->update([
                'due_date' => $request->due_date,
                'title' => $request->title,
                'description' => $request->description,
            ]);
    }

    public function search(int $ownerId, string $keyword)
    {
        $ambiguous = '%' . $keyword . '%';

        return $this->model
            ->where('owner', $ownerId)
            ->where(function ($query) use ($ambiguous) {
                $query->where('title', 'LIKE', $ambiguous)
                    ->orWhere('description', 'LIKE', '%something%');
            })
            ->get();
    }

    public function create($param)
    {
        $this->model->create($param);
    }

    public function delete($id)
    {
        $this->model->destroy($id);
    }
}
