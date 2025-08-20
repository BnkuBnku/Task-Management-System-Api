<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskFetchValidation;
use App\Http\Requests\TaskStoreValidation;
use App\Http\Requests\TaskUpdateValidation;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * fetch tasks
     *
     * @param  TaskFetchValidation $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetch(TaskFetchValidation $request)
    {
        $payload = $request->validated();
        $query = Task::when(!empty($payload['keyword']), function ($q) use ($payload){
                        return  $q->where('title', 'ilike', '%'.$payload['keyword'].'%');
                    })
                    ->when(!empty($payload['status']), function ($q) use ($payload){
                        return  $q->where('status',$payload['status']);
                    })
                    ->when(!empty($payload['priority']), function ($q) use ($payload){
                        return  $q->where('priority',$payload['priority']);
                    })
                    ->orderBy('created_at', 'DESC');

        $data = $query->skip($payload['skip'])
            ->take($payload['take'])
            ->get();

        return response()->json(compact('data'));
    }

    /**
     * store tasks
     *
     * @param  TaskStoreValidation $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TaskStoreValidation $request)
    {
        $data = $request->validated();
        $task = Task::create($data);

        return response()->json(compact('task'));
    }

    /**
     * update tasks
     *
     * @param  TaskUpdateValidation $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TaskUpdateValidation $request)
    {
        $data = $request->all();
        $task = Task::where('id',$request->id)->first();
        $task->update($data);

        return response()->json(compact('task'));
    }

    /**
     * delete tasks
     *
     * @param  $id
     * @return string
     */
    public function delete($id)
    {
        Task::where('id',$id)->delete();
        $message = 'Task deleted successfully.';
        return $message;
    }
}
