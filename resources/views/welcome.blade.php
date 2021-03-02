@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
            <h1>BANK APP</h1>
            <br>
        </div>
        <div class="ml-4 text-center text-sm text-gray-500 sm:text-center sm:ml-0">
            <a href="https://github.com/vitoyxyz/bank_app">Source Code.</a>
           <p>Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</p>
        </div>
    </div>
@endsection
