@extends('layouts.app')

@section('title', 'Page Title')

@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@endsection

@section('content')
    <p>Customers</p>

    @foreach ($users as $user)

        <p>{{ $user->id }}:{{ $user->name }}:{{ $user->email }} :{{ $user->balance }} </p>

    @endforeach

    <h3>Create Customer:</h3>
    <form method="POST" action="/customer/create">
        @csrf
        <label for="email">Customer Email:</label>
        <input type="text" id="email" name="email" value={{ old('email') }}>
        <label for="name">Customer Name:</label>
        <input type="text" id="name" name="name" value={{ old('name') }}>
        <label for="balance">Customer Balance:</label>
        <input type="text" id="balance" name="balance" value={{ old('balance') }}>
        <label for="branch">Select Branch: </label>
        <select name="branch" id="branch">
            @foreach ($branches as $branch)

                <option value="{{ $branch->id }}">{{ $branch->name }}</option>

            @endforeach
        </select>
        <input type="submit" value="Create">
    </form>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    @endif
@endsection
