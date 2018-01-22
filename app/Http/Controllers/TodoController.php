<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Todo;
use Validator;

class TodoController extends Controller
{

    public function index()
    {
        $todos = Todo::orderBy('created_at', 'asc')->get();

        return view('todos.index', [
            'todos' => $todos
        ]);
    }

    public function index_ajax()
    {
        $todos = Todo::orderBy('created_at', 'asc')->get();

        return json_encode($todos);
    }

    /**
     * Create a new todo.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $response = [];

        $validator = Validator::make($request->all(), [
            'subject' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            $response['status'] = "Error";
            $response['msg'] = "Error while checking form!";
            return json_encode($response);
        }

        $todo = new Todo;
        $todo->subject = $request->subject;
        $todo->save();

        $response['status'] = "Success";
        $response['msg'] = "Data added!";
        $response['data'] = $todo;
        return json_encode($response);
    }

    public function destroy($todo_id)
    {
        $todo = Todo::find($todo_id);
        $todo->delete();

        $response['status'] = "Success";
        $response['msg'] = "Data removed!";
        return json_encode($response);
    }
}
