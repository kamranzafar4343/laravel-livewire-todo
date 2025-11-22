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
    @foreach ($todos as $todo)
     <div>
    <li>
        {{ $todo->title }}   
    </li>
    
    </div>   
        
    @endforeach
</div> 
