@extends('layouts.app')

@section('content')
    <h2>Branches:</h2>

    @foreach ($branches as $branch)

        <a class="underline" href="{{ url('branch', $branch->id) }}">
            {{ $branch->name }} | Location:
            {{ $branch->location }} |
            {{ $branch->highest_balance == null ? 0 : $branch->highest_balance }}$

        </a>
        <br>

    @endforeach
    <h2>Branches With Over 50000$ balance</h2>

    @foreach ($over_50 as $branch)

        <a class="underline" href="{{ url('branch', $branch->id) }}">
            {{ $branch->name }} | Location:
            {{ $branch->location }} |
            {{ $branch->highest_balance == null ? 0 : $branch->highest_balance }}$

        </a>
        <br>

    @endforeach
    {{-- {{ $highest_balance_branch }} --}}

    <br>
    <h3>
        <a class="btn" href="{{ url('/branch/create') }}">Create Branch</a>
    </h3>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    @endif
@endsection
