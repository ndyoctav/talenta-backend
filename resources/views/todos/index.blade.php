@extends('app')

@section('content')

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                To Do List
            </div>

            <div class="panel-body">

                <!-- Display Validation Errors -->
                @include('common.errors')

                <!-- New Todo Form -->
                <form action="{{ url('todo') }}" method="POST" class="form-horizontal" id="todoForm">
                    {{ csrf_field() }}

                    <!-- Task Name -->
                    <div class="form-group">
                        <label for="task" class="col-sm-3 control-label">Todo</label>

                        <div class="col-sm-6">
                            <input type="text" name="subject" id="todo-subject" class="form-control">
                        </div>
                    </div>

                    <input type="submit" onclick="return false;" style="display:none" />

                    <!-- Add Task Button -->
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <a href="javascript:void(0);" onclick="submitForm('todoForm');" class="btn btn-default" id="todoSubmit">
                                <i class="fa fa-plus"></i> Add Todo
                            </a>
                        </div>
                    </div>
                </form>

                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="table-responsive">
                                <table class="table table-striped todo-table">

                                    <!-- Table Headings -->
                                    <thead>
                                        <th>Todo</th>
                                        <th width="10%">&nbsp;</th>
                                    </thead>

                                    <!-- Table Body -->
                                    <tbody id="todoTbody">
                                        @if (count($todos) > 0)
                                            @foreach ($todos as $todo)
                                                <tr id="todo-{{ $todo->id }}">
                                                    <td>
                                                        <div>{{ $todo->subject }}</div>
                                                    </td>
                                                    <td>
                                                        <a href="javascript:void(0);" class="btn btn-danger" onclick="deleteTodo({{ $todo->id }});">
                                                            <i class="fa fa-trash"></i> Delete
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

    function deleteTodo(todoId){
        $.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': $('input[name="_token"]').val()
           }
       });
        $.ajax({
            type: "DELETE",
            url: '{{ url('todo') }}/' + todoId,
            success: function (data) {
                $("#todo-" + todoId).remove();
            },
            error: function (data) {
                alert('Error!');
                console.log('Error:', data);
            }
        });
    }

    function submitForm(formId){
        $.ajax({
            type: "POST",
            url: $("#"+formId).attr("action"),
            data: $("#"+formId).serialize(),
            success: function(response){
                var json = JSON.parse(response);
                if(json.status == 'Error'){
                    alert('Error while validating form!');
                }
                else{
                    var data = json.data;
                    var todo = '<tr id="todo-'+ data.id +'"><td><div>'+ data.subject +'</div></td>';
                    todo += '<td><a href="javascript:void(0);" class="btn btn-danger" onclick="deleteTodo('+ data.id +');" value="'+ data.id +'"><i class="fa fa-trash"></i> Delete</a></td></tr>';
                    $('#todoTbody').append(todo);
                }
            },
            error: function (data) {
                alert('Error!');
                console.log('Error:', data);
            }
        });
    }
@endsection
