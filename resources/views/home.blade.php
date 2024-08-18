@extends('layouts.app')

@section('title', 'Home Page')

@section('custom-css')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container m-5 p-2 rounded mx-auto ">
        <!-- App title section -->
        <div class="row m-1 p-4">
            <div class="col">
                <div class="p-1 h1 text-primary text-center mx-auto display-inline-block">
                    <i class="fa fa-check bg-primary text-white rounded p-2"></i>
                    <u>My Todo-s</u>
                </div>
            </div>
    </div>
        <!-- Create todo section -->
    <div class="row m-1 p-3">
        <div class="col-12 col-md-8 mx-auto">
            <form action="{{ route('tasks.store') }}" method="POST">
                @csrf
                <div class="row bg-white rounded shadow-sm p-2 add-todo-wrapper align-items-center">
                    <div class="col">
                        <input class="form-control form-control-lg border-0 bg-transparent rounded" type="text" name="description" placeholder="Add new .." value="{{ old('description') }}">
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-auto m-0 px-2 d-flex align-items-center">
                        <label for="deadline" class="visually-hidden">Deadline</label>
                        <input type="datetime-local" class="form-control" name="deadline" id="deadline">
                    </div>
                </div>
                <div class="row mt-3 justify-content-center">
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
        {{-- <div class="p-2 mx-4 border-black-25 border-bottom"></div> --}}

    <!-- Todo list section -->
    <div class="row mx-1 px-1 pb-1">
        <div class="col mx-auto">
            @foreach($tasks as $task)
            <div class="row px-3 align-items-center todo-item rounded mb-2" id="task-{{ $task->id }}">
                <div class="col px-1 m-1 d-flex align-items-center">
                    <input type="text" class="form-control form-control-lg border-0 edit-todo-input bg-transparent rounded" readonly value="{{ $task->description }}" title="{{ $task->description }}" id="task-input-{{ $task->id }}" />
                </div>
                <div class="col-auto m-1 p-0 todo-actions">
                    <div class="row d-flex flex-column align-items-end">
                        @if ($task->deadline == null || $task->deadline > now())
                        <h5 class="m-0 p-0 px-2">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editTaskModal" data-task-id="{{ $task->id }}" data-task-description="{{ $task->description }}">
                                Edit
                            </button>
                        </h5>
                        @else
                        <div class="alert alert-danger mb-2" style="width: 100%;">
                            Deadline passed!
                        </div>
                        @endif
                        <h5 class="m-0 p-1 px-2">
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    Delete
                                </button>
                            </form>
                        </h5>
                        <h5 class="m-0 p-1 px-2">
                            @if ($task->is_completed)
                                <span class="completed-indicator">✔️</span>
                            @endif
                        </h5>
                    </div>
                </div>
                <div class="row todo-created-info">
                    <div class="col-auto d-flex align-items-center pr-2">
                        <i class="fa fa-info-circle my-2 px-2 text-black-50 btn" data-toggle="tooltip" data-placement="bottom" title="Created date"></i>
                        <label class="date-label my-2 text-black-50"></label>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Modal for editing task -->
    <div class="modal" tabindex="-1" id="editTaskModal" aria-labelledby="editTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTaskModalLabel">Edit Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editTaskForm" action="{{ route('tasks.update', 'task_id_placeholder') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="taskDescriptionInput" class="form-label">Task Description</label>
                            <textarea class="form-control" id="taskDescriptionInput" name="description"></textarea>
                            <input type="hidden" id="taskIdInput" name="id">
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name="is_completed">
                            <label class="form-check-label" for="flexSwitchCheckDefault">Completed</label>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection


@section('custom-js')

@endsection
