@extends('layouts.app')

@section('title', 'Page Title')

@section('sidebar')
@parent

<p>This is appended to the master sidebar.</p>
@endsection

@section('content')
<p>Branches Page</p>

@foreach($branches as $branch)

<p> {{$branch->location_name}} </p>

@endforeach

<form method="POST" action="/branch/create">
    @csrf

    <input type="text" id="name" name="name">
    <input type="submit" value="Submit">
</form>

@error('name')
<div class="alert alert-danger">Error:{{ $message }}</div>
@enderror
@endsection