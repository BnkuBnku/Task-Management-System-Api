<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFetchValidation;
use App\Http\Requests\UserUpdateValidation;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * fetch users
     *
     * @param  UserFetchValidation $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetch(UserFetchValidation $request)
    {
        $payload = $request->validated();
        $query = User::when(!empty($payload['keyword']), function ($q) use ($payload){
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
            ->with('role')
            ->get();

        return response()->json(compact('data'));
    }

    /**
     * update tasks
     *
     * @param  UserUpdateValidation $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserUpdateValidation $request)
    {
        $data = $request->all();
        $user = User::where('id',$request->id)->first();
        $user->update($data);

        return response()->json(compact('user'));
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
