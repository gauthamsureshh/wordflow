@extends('layouts.main')

@section('css')
<link rel="stylesheet" href="{{ URL::asset('css/homePage.css') }}"/>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card text-center">
        <h1>WORDFLOW</h1>
        @auth
            <div class="buttons">
                <h6 class="text-center">Welcome to our blog, where we share insights, tips, and stories to inspire your journey and enrich your knowledge!</h6>
                <a class="btn btn-outline-info" href="{{route('listblog')}}">Blog</a> 
            </div>
        @else
            <h6 class="text-center">Let's Get Started, <a href="{{ route('loginpage') }}">Login</a></h6>
        @endauth
    </div>
</div>
@endsection
