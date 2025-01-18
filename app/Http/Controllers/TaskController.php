<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use GuzzleHttp\Psr7\Message;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function Pest\Laravel\get;

class TaskController extends Controller
{
    //

    public function index()
    {

        $allTasks = Task::paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'all tasks retrevied successfully',
            'data' => $allTasks
        ]);
    }

    public function show($id)
    {
        try {

            $findTask = Task::findOrFail($id);

            return response()->json(
                [
                    'success' => true,
                    'message' => 'task retrived successfully',
                    'data' => $findTask
                ]
            );
        } catch (ModelNotFoundException $e) {

            return response()->json(
                [
                    'success' => false,
                    'errors' => "Task Not Found " . $e->getMessage()
                ]
            );
        }
    }

    public function userTasks(Request $request)
    {
        $user = $request->user();
        // dd($user);
        $tasks = Task::where('user_id', $user->id)->get();
        // dd($tasks);
        return response()->json([
            'success' => true,
            'message' => "tasks retrevied successfully for user => {$user->name}",
            'data' => $tasks
        ]);
    }

    public function userTask(Request $request, $id)
    {
        $findTaskForUser = Task::where('id', $id)->where('user_id', $request->user()->id)->first();
        if ($findTaskForUser) {
            return response()->json([
                'success' => true,
                'message' => "task retrevied successfully for user => {$request->user()->name}",
                'data' => $findTaskForUser
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => "task not found for user => {$request->user()->name}"
            ]);
        }
    }


    public function store(Request $request)
    {

        $user = $request->user()->id;
        $validateData = Validator::make($request->all(), [
            'title' => 'required|max:200',
            'desc' => 'required|max:700',
            'status' => 'nullable|in:pending,completed',

        ]);

        if ($validateData->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validateData->errors()
            ], 422);
        }

        try {

            $validateData = $validateData->validated();
            $validateData['user_id'] = $user;

            $addNewTask = Task::create($validateData);

            return response()->json(
                [
                    'success' => true,
                    'message' => 'the task created succesfully',
                    'data' => $addNewTask
                ],
                201
            );
        } catch (\Exception $e) {


            return response()->json(
                [
                    'success' => false,
                    'error' => "falid to create task " . $e->getMessage(),
                ],
                500
            );
        }
    }


    public function update(Request $request, $id)
    {

        try {

            $findTask = Task::findOrFail($id);
            $user = $request->user();

            if ($findTask->user_id !== $user->id) {
                return response()->json(
                    [
                        'success' => false,
                        'error' => 'you are not the owner of this task'
                    ],
                    403
                );
            }

            $validateData = Validator::make($request->all(), [
                'title' => 'required|max:200',
                'desc' => 'required|max:700',
                'status' => 'nullable|in:pending,completed'
            ]);



            if ($validateData->fails()) {
                return response()->json(
                    [
                        'success' => false,
                        'errors' => $validateData->errors()
                    ],
                    422
                );
            }

            $findTask->update($validateData->validated());

            return response()->json([
                'success' => true,
                'message' => 'the task was updated successfully',
                'data' => $findTask
            ], 201);
        } catch (ModelNotFoundException $e) {

            return response()->json(
                [
                    'success' => false,
                    'errors' => 'Task Not Found'
                ],
                404
            );
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'error' => "Failed to update task" . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $findTask = Task::findOrFail($id);
            $user = $request->user();

            if ($findTask->user_id !== $user->id) {
                return response()->json([
                    'success' => false,
                    'error' => 'You are not the owner of this task'
                ], 403);
            }

            $findTask->delete();

            return response()->json(
                [
                    'success' => true,
                    'message' => "the task deleted with id => {$findTask->id} successfully",

                ],
                200
            );
        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                    'success' => false,
                    'errors' => "Task not found " . $e->getMessage()
                ],
                404
            );
        }
    }
}
