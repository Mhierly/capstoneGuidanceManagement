@extends('layouts.app')
@section('title-page', 'List of Student')
@section('content')
    @if (request()->input('student'))
        <div class="row">

        </div>
    @else
        <div class="row">

        </div>
    @endif
@endsection
