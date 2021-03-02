@extends('layouts.app')

@section('content')
    <a type="button" class="underline" href="{{ url('/customers') }}">Back</a>
    <hr>
    <h2>Customer Info</h2>
    <h3>Customer Name: {{ $user[0]->name }}</h3>
    <h3>Customer Email: {{ $user[0]->email }}</h3>
    <h3>Customer Balance: {{ $user[0]->balance }}$</h3>
    <br>
    <h2>Send Money</h2>
    <form method="POST" action="/customer/transfer">
        @csrf
        <input type='hidden' name='from_user' value={{ $user[0]->id }}>
        <label for="to_user">To: </label>
        <select name="to_user" id="to_user">
            @foreach ($other_users as $user)

                <option value="{{ $user->id }}">{{ $user->email }}</option>

            @endforeach
        </select>
        <label for="balance">Amount:</label>
        <input type="text" id="amount" name="amount" value={{ old('balance') }}>
        <input type="submit" class="btn" value="Send!">
    </form>
    <br>
    <h2>Transaction:</h2>

    @foreach ($transactions['send'] as $item)
        <div>
            <h3>Send:</h3>
            <p>You send <span class="underline">{{ $item->amount }}$</span> to {{ $item->email }} </p>

        </div>

    @endforeach

    <br>


    @foreach ($transactions['received'] as $item)
        <div>
            <h3>Received:</h3>
            You received <span class="underline">{{ $item->amount }}$</span> from {{ $item->email }}

        </div>

    @endforeach




    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    @endif
@endsection
