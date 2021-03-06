<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ScheduleRepository;
use App\Schedule;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  App\Repositories\ScheduleRepository
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(ScheduleRepository $repository, Request $request)
    {
        // $datas = $repository->getAll();
        // return $datas;
        $ownerId = Auth::id();
        $keyword = $request->keyword;

        if (is_null($keyword)) {
            return $repository->getAllByOwners($ownerId);
        } else {
            return $repository->search($ownerId, $keyword);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Repositories\ScheduleRepository
     */
    public function store(Request $request, ScheduleRepository $repository)
    {
        $ownerId = Auth::id();
        $param = [
            'owner' => $ownerId,
            'due_date' => $request->dueDate,
            'title' => $request->title,
            'description' => $request->description,
        ];
        $repository->create($param);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Repositories\ScheduleRepository
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ScheduleRepository $repository)
    {
        $ownerId = Auth::id();
        return $repository->search($ownerId, $request->keyword);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Repositories\ScheduleRepository
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ScheduleRepository $repository)
    {
        $id = $request->id;
        $repository->update($id, $request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Schedule $model
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $model)
    {
        $model->delete();
    }
}
