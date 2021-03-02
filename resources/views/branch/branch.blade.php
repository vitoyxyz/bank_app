@extends('layouts.app')


@section('content')
    <a type="button" class="underline" href="{{ url('/branches') }}">Back</a>
    <h2>Branch {{ $branch[0]->name }} Customers:</h2>
    @foreach ($users as $user)
        <div>

            <a class="underline" href="{{ url('customer', $user->id) }}">
                {{ $user->name }}
                {{ $user->email }}

            </a>
        </div>

    @endforeach

@endsection
