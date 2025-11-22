<?php

use Livewire\Volt\Component;

// server code
new class extends Component {
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
    </form>
    @foreach ($todos as $todo)
     <div>
        {{ $todo->title }}   
    </div>   
        <button wire:click='delete({{ $todo->id }})' class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
    @endforeach
</div> 
