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
            <div class="col col-11 mx-auto">
                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf
                    <div class="row bg-white rounded shadow-sm p-2 add-todo-wrapper align-items-center justify-content-center">
                        <div class="col">
                            <input class="form-control form-control-lg border-0 add-todo-input bg-transparent rounded" type="text" name="description" placeholder="Add new .." value="{{ old('description') }}">
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- <div class="col-auto m-0 px-2 d-flex align-items-center">
                            <label class="text-secondary my-2 p-0 px-1 view-opt-label due-date-label d-none">Due date not set</label>
                            <i class="fa fa-calendar my-2 px-1 text-primary btn due-date-button" data-toggle="tooltip" data-placement="bottom" title="Set a Due date"></i>
                            <i class="fa fa-calendar-times-o my-2 px-1 text-danger btn clear-due-date-button d-none" data-toggle="tooltip" data-placement="bottom" title="Clear Due date"></i>
                        </div> --}}
                        <div class="col-auto px-0 mx-0 mr-2">
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="p-2 mx-4 border-black-25 border-bottom"></div>
    <!-- View options section -->
    {{-- <div class="row m-1 p-3 px-5 justify-content-end">
        <div class="col-auto d-flex align-items-center">
            <label class="text-secondary my-2 pr-2 view-opt-label">Filter</label>
            <select class="custom-select custom-select-sm btn my-2">
                <option value="all" selected>All</option>
                <option value="completed">Completed</option>
                <option value="active">Active</option>
                <option value="has-due-date">Has due date</option>
            </select>
        </div>
        <div class="col-auto d-flex align-items-center px-1 pr-3">
            <label class="text-secondary my-2 pr-2 view-opt-label">Sort</label>
            <select class="custom-select custom-select-sm btn my-2">
                <option value="added-date-asc" selected>Added date</option>
                <option value="due-date-desc">Due date</option>
            </select>
            <i class="fa fa fa-sort-amount-asc text-info btn mx-0 px-0 pl-1" data-toggle="tooltip" data-placement="bottom" title="Ascending"></i>
            <i class="fa fa fa-sort-amount-desc text-info btn mx-0 px-0 pl-1 d-none" data-toggle="tooltip" data-placement="bottom" title="Descending"></i>
        </div>
    </div> --}}
    <!-- Todo list section -->
    <div class="row mx-1 px-1 pb-1">
        <div class="col mx-auto">
            @foreach($tasks as $task)
            <div class="row px-3 align-items-center todo-item rounded" id="task-{{ $task->id }}">
                <div class="col px-1 m-1 d-flex align-items-center">
                    <input type="text" class="form-control form-control-lg border-0 edit-todo-input bg-transparent rounded" readonly value="{{ $task->description }}" title="{{ $task->description }}" id="task-input-{{ $task->id }}" />
                </div>
                <div class="col-auto m-1 p-0 todo-actions">
                    <div class="row d-flex align-items-center justify-content-end">
                        <h5 class="m-0 p-0 px-2">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editTaskModal" data-task-id="{{ $task->id }}" data-task-description="{{ $task->description }}">
                                Edit
                            </button>
                        </h5>
                        <h5 class="m-0 p-0 px-2 d-none" id="save-btn-{{ $task->id }}">
                            <button class="fa fa-save text-success btn m-0 p-0" data-toggle="tooltip" data-placement="bottom" title="Save todo" onclick="saveTask({{ $task->id }})"></button>
                        </h5>
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
                                <span class="completed-indicator">✔️</span> <!-- علامة صح مع كلمة Completed -->
                            @endif
                        </h5>
                    </div>
                </div>
                <div class="row todo-created-info">
                    <div class="col-auto d-flex align-items-center pr-2">
                        <i class="fa fa-info-circle my-2 px-2 text-black-50 btn" data-toggle="tooltip" data-placement="bottom" title="Created date"></i>
                        <label class="date-label my-2 text-black-50">{{ $task->created_at->format('d M Y') }}</label>
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
