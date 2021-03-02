@extends('layouts.app')
@section('content')

    <h2>Create Customer:</h2>
    <form method="POST" action="/customer/store">
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
