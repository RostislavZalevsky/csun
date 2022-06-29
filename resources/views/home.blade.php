@extends('layout')

@section('title',  'Page 1')

@section('content')
    <div>
        <p class="text-muted">{{ count($classes) }} result{{ count($classes) > 1 ? 's' : '' }} ({{ $executionTime }} sec)</p>

        @include('table.classes', ['classes' => $classes])
    </div>
@endsection
