<?php

namespace App\Livewire;

use App\Models\Block1;
use Livewire\Component;



class BlogShow extends Component
{
    public Block1 $post;

    public function mount(Block1 $post) { $this->post = $post; }

    public function render()
    {
        return view('livewire.blog-show', ['post' => $this->post])
            ->layout('layouts.app')
            ->title($this->post->name1 ?? 'Запись');
    }
}
