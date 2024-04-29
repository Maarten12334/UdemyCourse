<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Task;

Route::get('/', function () {
    return redirect()->route('tasks.index');
});

Route::get('/tasks', function () {
    return view('index', [
        'tasks' => Task::latest()->get()
    ]);
})->name('tasks.index');

Route::view('/tasks/create', 'create')
    ->name('tasks.create');

Route::get('/tasks/{id}', function ($id) {
    return view('show', [
        'task' => Task::findorFail($id)
    ]);
})->name('tasks.show');

Route::get('/tasks/{id}/edit', function ($id) {
    return view('edit', [
        'task' => Task::findorFail($id)
    ]);
})->name('tasks.edit');

Route::post('/tasks', function (Request $request) {
    $data = $request->validate([
        'title' => 'required|max:255',
        'description' => 'required',
        'long_description' => 'required'
    ]);

    $task = new Task;
    $task->title = $data['title'];
    $task->description = $data['description'];
    $task->long_description = $data['long_description'];
    $task->save();

    return redirect()->route('tasks.show', ['id' => $task->id])
        ->with('success', 'Task created succesfully!');
})->name('tasks.store');

Route::put('/tasks/{id}', function ($id, Request $request) {
    $data = $request->validate([
        'title' => 'required|max:255',
        'description' => 'required',
        'long_description' => 'required'
    ]);

    $task = Task::findOrFail($id);
    $task->title = $data['title'];
    $task->description = $data['description'];
    $task->long_description = $data['long_description'];
    $task->save();

    return redirect()->route('tasks.show', ['id' => $task->id])
        ->with('success', 'Task updated succesfully!');
})->name('tasks.update');

/*
Route::get('/hello', function(){
    return 'Hello';
})->name('hello');

Route::get('hallo', function(){
    return redirect()->route('hello');
});

Route::get('/greet/{name}', function($name){
    return 'Hello ' . $name . '!';
});*/

Route::fallback(function () {
    return 'Still got somewhere';
});
