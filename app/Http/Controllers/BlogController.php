<?php

namespace App\Http\Controllers;

use App\Models\Block1;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Block1::with('description')
            ->latest('id')
            ->paginate(10);
        
        return view('blog.index', compact('posts'));
    }

    public function show(Block1 $post)
    {
        $post->load('description');
        
        $lang = (int) session('lang', 1);
        
        // Получаем локализованные данные
        $title = $post->name1 ?? 'Запись';
        $description = null;
        
        if ($post->description) {
            if ($lang === 2) {
                $title = $post->description->title_2 ?? $post->description->title_1 ?? $post->name1 ?? 'Запись';
                $description = $post->description->description_2 ?? $post->description->description_1;
            } else {
                $title = $post->description->title_1 ?? $post->description->title_2 ?? $post->name1 ?? 'Запись';
                $description = $post->description->description_1 ?? $post->description->description_2;
            }
        }
        
        return view('blog.show', [
            'post' => $post,
            'title' => $title,
            'description' => $description,
        ]);
    }
}





