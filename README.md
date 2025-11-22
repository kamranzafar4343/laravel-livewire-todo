<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

📄 README.md (Single File Including EVERYTHING)
# Laravel Todo App (Laravel 12 + Breeze + Livewire Volt)

A simple Todo app where users can:

- Register / Login
- Add Todos
- Delete Todos
- Only see their own Todos

Built using:

- Laravel 12
- Breeze Auth
- Livewire v3
- Livewire Volt (Class API)
- TailwindCSS

Everything you need is in this one file.

---

# 🛠 Installation

## 1. Create Laravel 12 Project

```bash
composer create-project laravel/laravel todo-app
cd todo-app

2. Install Breeze (Livewire + Volt)
composer require laravel/breeze --dev
php artisan breeze:install livewire --volt
npm install
npm run dev

3. Setup Database

Edit .env:

DB_DATABASE=todo_db
DB_USERNAME=root
DB_PASSWORD=


Run migrations:

php artisan migrate

📌 Todo Feature Setup

Below is EVERYTHING needed for Todos in one file.

4. Create Todo Migration
php artisan make:migration create_todos_table


Replace migration with:

public function up()
{
    Schema::create('todos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->string('title');
        $table->timestamps();
    });
}


Run:

php artisan migrate

5. Create Todo Model

File: app/Models/Todo.php

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = ['title', 'user_id'];
}

6. Create Todo Volt Component

File:
resources/views/livewire/todo-manager.blade.php

<?php

use Livewire\Volt\Component;
use App\Models\Todo;

new class extends Component {

    public string $todoName = '';
    public $todos = [];

    // Load user's todos on mount
    public function mount()
    {
        $this->loadTodos();
    }

    // Fetch todos from database
    public function loadTodos()
    {
        $this->todos = Todo::where('user_id', auth()->id())
            ->latest()
            ->get();
    }

    // Create todo
    public function createTodo()
    {
        $this->validate([
            'todoName' => 'required|min:3'
        ]);

        Todo::create([
            'title' => $this->todoName,
            'user_id' => auth()->id()
        ]);

        $this->reset('todoName'); // Clear input
        $this->loadTodos();       // Refresh list
    }

    // Delete todo
    public function delete($id)
    {
        Todo::where('id', $id)
            ->where('user_id', auth()->id())
            ->delete();

        $this->loadTodos();
    }

}; ?>

<div class="max-w-lg p-4 space-y-4">

    <!-- Add Todo Form -->
    <form wire:submit="createTodo" class="flex gap-2">
        <x-text-input wire:model="todoName" placeholder="Enter todo title" class="w-full"/>
        <x-primary-button type="submit">Add</x-primary-button>
    </form>

    <x-input-error :messages="$errors->get('todoName')" />

    <!-- List Todos -->
    @foreach ($todos as $todo)
        <div class="border border-gray-300 rounded-lg p-3 mb-2 flex items-center justify-between">
            <span>{{ $todo->title }}</span>

            <x-danger-button 
                wire:click="delete({{ $todo->id }})"
                size="sm"
                class="px-2 py-1 text-xs"
            >
                Delete
            </x-danger-button>
        </div>
    @endforeach

</div>

7. Load Todo Component in Dashboard

File: resources/views/dashboard.blade.php

<x-app-layout>
    <livewire:todo-manager />
</x-app-layout>

▶️ Start The App
php artisan serve


Visit:

http://127.0.0.1:8000/register
http://127.0.0.1:8000/login
http://127.0.0.1:8000/dashboard


You can now:

Add todos

Delete todos

Input resets automatically

Todos are wrapped in nice bordered containers

Each user sees only their own tasks

🎉 Done!

Your Todo App is fully ready with:

✔ Auth
✔ Livewire Volt
✔ Add/Delete Todo
✔ Clean UI
✔ Everything in ONE FILE README