@extends('layouts.app')

@section('title', 'Page Title')

@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@endsection

@section('content')
    <p>Branches Page</p>

    @foreach ($branches as $branch)

        <p> {{ $branch->name }} </p>

    @endforeach

    <form method="POST" action="/branch/create">
        @csrf

        <input type="text" id="name" name="name">
        <input type="submit" value="Submit">
    </form>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    @endif
@endsection
