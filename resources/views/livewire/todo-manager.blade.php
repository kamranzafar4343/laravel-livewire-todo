<?php

use Livewire\Volt\Component;
use App\Models\Todo;

// server code
new class extends Component {
    public Todo $todo;
    public string $todoName = '';

    public function createTodo(){
        $this->validate([
            'todoName' => 'required|min:3',
        ]);

        Auth::user()->todos()->create([
            'title' => $this->todoName,
        ]);

    $this->reset('todoName');   // ← input clears instantly

    }
    
    public function delete($id){
        $todo = Todo::find($id);
        if($todo && $todo->user_id === Auth::id()){
            $todo->delete();
        }
    }
    public function with()
    {
        return[
            'todos' => Auth::user()->todos()->latest()->get(),
    ];
    }
}; ?>


{{-- html --}}
<div> 
    <form wire:submit='createTodo'>
        <x-text-input wire:model='todoName' placeholder="Enter todo title" class="mr-2"/>
        <x-primary-button type="submit">Add Todo</x-primary-button>
        <x-input-error :messages="$errors->get('todoName')" class="mt-2"/>
    </form>
    @foreach ($todos as $todo)
     <div>
        {{ $todo->title }}   
<x-danger-button 
    wire:click="delete({{ $todo->id }})" 
    size="sm" 
    class="mr-4 mt-4"
>
    Delete
</x-danger-button>

    </div>   

    @endforeach
</div> 
