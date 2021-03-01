@extends('layouts.app')

@section('title', 'Page Title')

@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@endsection

@section('content')
    <hr>
    <p>Customers</p>



    <p>{{ $user[0]->id }}:{{ $user[0]->name }}:{{ $user[0]->balance }} </p>

    <form method="POST" action="/customer/transfer">
        @csrf
        <label for="user">Send To: </label>
        <select name="user" id="user">
            @foreach ($other_users as $user)

                <option value="{{ $user->id }}">{{ $user->name }}</option>

            @endforeach
        </select>
        <label for="balance">Amount:</label>
        <input type="text" id="balance" name="balance" value={{ old('balance') }}>
        <input type="submit" value="Send!">
    </form>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    @endif
@endsection
