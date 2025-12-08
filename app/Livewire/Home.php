<?php

namespace App\Livewire;

use App\Models\Home as HomeModel;
use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        $lang = (int) session('lang', 1);
        $home = HomeModel::with('description')->first();
        
        $title = 'Главная';
        $metaDescription = null;
        $block1 = null;
        $block2 = null;
        
        if ($home && $home->description) {
            $desc = $home->description;
            
            if ($lang === 2) {
                $title = $desc->title_2 ?? $desc->title_1 ?? 'Главная';
                $metaDescription = $desc->meta_description_2 ?? $desc->meta_description_1;
                $block1 = $desc->block_1_2 ?? $desc->block_1_1;
                $block2 = $desc->block_2_2 ?? $desc->block_2_1;
            } else {
                $title = $desc->title_1 ?? $desc->title_2 ?? 'Главная';
                $metaDescription = $desc->meta_description_1 ?? $desc->meta_description_2;
                $block1 = $desc->block_1_1 ?? $desc->block_1_2;
                $block2 = $desc->block_2_1 ?? $desc->block_2_2;
            }
        }
        
        return view('livewire.home', [
            'title' => $title,
            'metaDescription' => $metaDescription,
            'block1' => $block1,
            'block2' => $block2,
        ])
            ->layout('layouts.app') // общий лейаут
            ->title($title);     // <title>
    }
}
