@extends('layouts.app')
@section('content')
    <a type="button" class="underline" href="{{ url('/branches') }}">Back</a>
    <h2>Create Branch:</h2>
    <div>
        <form method="POST" action="/branch/store">
            @csrf
            <label for="name">Branch Name:</label>
            <input type="text" id="name" name="name">
            <label for="location">Location Name:</label>
            <input type="text" id="location" name="location">
            <input type="submit" value="Submit">
        </form>

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        @endif

    </div>
@endsection
