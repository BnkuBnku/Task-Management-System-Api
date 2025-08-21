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
        $safeSkip = $payload['skip'] ?? 0;
        $query = Task::when(!empty($payload['keyword']), function ($q) use ($payload){
                        return  $q->where('title', 'ilike', '%'.$payload['keyword'].'%');
                    })
                    ->when(!empty($payload['status']), function ($q) use ($payload){
                        return  $q->where('status',$payload['status']);
                    })
                    ->when(!empty($payload['priority']), function ($q) use ($payload){
                        return  $q->where('priority',$payload['priority']);
                    })
                    ->orderBy('order', 'DESC');

        $data = $query->skip($safeSkip)
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
        $validated = $request->validated();
        $data = Task::create($validated);

        return response()->json(compact('data'));
    }

    /**
     * update tasks
     *
     * @param  TaskUpdateValidation $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(TaskUpdateValidation $request)
    {
        $validated = $request->validated();
        $data = Task::where('id',$request->id)->first();
        $data->update($validated);

        return response()->json(compact('data'));
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
