@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Student List
                        <button class="btn btn-primary float-right">
                            <a href="{{route('student.create')}}" style="color: white">Add New</a>
                        </button>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="table">
                            <table class="table table-bordered">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                                @foreach($students as $key=>$student)
                                <tr>
                                    <td>{{$key +1 }}</td>
                                    <td>{{$student->name}}</td>
                                    <td>
                                        <img class="img-thumbnail img-responsive" src="{{Storage::disk('public')->url('student/'.$student->image)}}" alt="" height="150px;" width="150px;">
                                    </td>
                                    <td>
                                        <button class="btn btn-success"><a href="{{route('student.edit',$student->id)}}">Edit</a></button>

                                        <form method="POST" id="delete-form-{{ $student->id }}" action="{{ route('student.destroy',$student->id) }}" style="display: none;">
                                            @csrf
                                            @method('DELETE')

                                        </form>
                                        <button class="btn btn-danger"
                                            onclick="if(confirm('Are you Sure, You went to delete this?')){
                                                event.preventDefault();
                                                document.getElementById('delete-form-{{ $student->id }}').submit();
                                            }else{
                                                event.preventDefault();
                                            }">Delete
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
