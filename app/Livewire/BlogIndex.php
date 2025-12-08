<?php

namespace App\Livewire;

use App\Models\Block1;
use Livewire\Component;
use Livewire\WithPagination;

class BlogIndex extends Component
{
    use WithPagination;

    public function render()
    {
        $posts = Block1::query()->latest('id')->paginate(10);

        return view('livewire.blog-index', compact('posts'))
            ->layout('layouts.app')
            ->title('Блог');
    }
}

