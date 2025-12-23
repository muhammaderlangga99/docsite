@extends('layout.app')

@section('title', 'API Playground')

@section('content')
    <div class="container mx-auto px-4 py-8 lg:w-[90%]">

        <x-api-playground :spec="$specPath ?? '/openapi/api-docs'" height="900px" />
    </div>
@endsection
