@extends('layouts.main')

@section('css')
<link rel="stylesheet" href="{{URL::asset('css/auth.css')}}"/>
@endsection

@section('title','Login')
@section('content')
<div class="container-fluid">
    <div class="mt-5">
        @if ($errors instanceof Illuminate\Support\ViewErrorBag && $errors->any())
            <div class="col">
                @foreach ($errors->all() as $error )
                    <div class="alert alert-danger">{{$error}}</div>
                @endforeach
            </div>

        @elseif (session()->has('errors'))
            <div class="alert alert-danger">
                {{session('errors')}}
            </div>
        @endif
    </div>
    <form method="post" action="{{route('login.post')}}" class="mr-auto ml-auto mt-3" style="width: 500px">
        @csrf
        @method('post')
        <div class="form-group">
            <label >Email</label>
            <input type="email" class="form-control"   placeholder="Email" name="email">
        </div>
        <div class="form-group">
            <label >Password</label>
            <input type="password" class="form-control" placeholder="Password" name="password">
        </div>
        <div class="form-group">
            <label class="form-check-label">Not a Member ?<a href="{{route('registerpage')}}"> Register</a></label>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>



@endsection