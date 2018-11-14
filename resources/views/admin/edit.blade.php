@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit
                        <button class="btn btn-primary float-right">
                            <a href="{{route('student.index')}}" style="color: white">Back</a>
                        </button>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="">
                            <form action="{{route('student.update',$student->id)}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" id="name" name="name" class="form-control"  placeholder="Enter Name" value="{{$student->name}}">
                                </div>
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <input type="file" class="form-control-file" name="image" id="image">
                                </div>
                                <img class="img-thumbnail img-responsive" src="{{Storage::disk('public')->url('student/'.$student->image)}}" alt="" height="150px;" width="150px;"><br><br>
                                <button type="submit" class="btn btn-success">UPDATE</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
