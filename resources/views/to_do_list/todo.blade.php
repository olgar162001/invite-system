@extends('layouts.app')

@section('title', 'To-Do List')
@section('content')
    @include('partials.sidebar')

    <div class="container">
        <h2>To-Do List</h2>

        <livewire:todo-list />
    </div>
@endsection