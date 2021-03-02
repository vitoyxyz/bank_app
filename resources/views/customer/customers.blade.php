@extends('layouts.app')


@section('content')
    <h2>Customers:</h2>

    <br>
    @foreach ($users as $user)
        <div>

            <a class="underline" href="{{ url('customer', $user->id) }}">
                Customer Name: {{ $user->name }} |
                Customer Email: {{ $user->email }} |
                Customer Balance: {{ $user->balance }}$
                <hr>
            </a>

        </div>

    @endforeach


    <br>
    <h3>
        <a class="underline" href="{{ url('/customer/create') }}">Create Customer</a>
    </h3>
@endsection
