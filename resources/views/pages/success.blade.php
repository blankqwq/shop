@extends('layouts.app')
@section('title', '操作成功')

@section('content')
    <div class="card" style="height: 500px">
        <h1 style="text-align: center">success</h1>
        <hr>
        <div class="card-body text-center">
            <h3>{{ $msg }}</h3>
            <br>
            <a class="btn btn-primary" href="{{ route('root') }}">返回首页</a>
        </div>
    </div>
    <br>
    <br>
@endsection