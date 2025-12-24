@extends('layouts.app')

@section('title', 'Блог')

@section('content')
<section>
  <h1 class="text-2xl font-semibold mb-4">Блог</h1>

  <ul class="space-y-4">
    @foreach($posts as $post)
      <li class="border rounded p-4">
        <a href="{{ route('blog.show', $post->id) }}" class="block">
          @if(!empty($post->image1))
            <img src="{{ \Illuminate\Support\Facades\Storage::url($post->image1) }}" alt="{{ $post->name1 }}" class="mb-3 max-h-48 object-cover">
          @endif
          
          @php
            $lang = (int) session('lang', 1);
            $postTitle = $post->name1 ?? 'Без названия';
            if ($post->description) {
              if ($lang === 2) {
                $postTitle = $post->description->title_2 ?? $post->description->title_1 ?? $post->name1 ?? 'Без названия';
              } else {
                $postTitle = $post->description->title_1 ?? $post->description->title_2 ?? $post->name1 ?? 'Без названия';
              }
            }
          @endphp
          
          <h2 class="text-xl font-medium">{{ $postTitle }}</h2>
          
          @php
            $postDescription = null;
            if ($post->description) {
              if ($lang === 2) {
                $postDescription = $post->description->description_2 ?? $post->description->description_1;
              } else {
                $postDescription = $post->description->description_1 ?? $post->description->description_2;
              }
            }
            $preview = $postDescription ? \Illuminate\Support\Str::limit(strip_tags($postDescription), 140) : \Illuminate\Support\Str::limit(strip_tags($post->content ?? ''), 140);
          @endphp
          
          <p class="text-sm text-gray-600">
            {{ $preview }}
          </p>
          <span class="inline-block mt-2 underline">Читать</span>
        </a>
      </li>
    @endforeach
  </ul>

  <div class="mt-6">
    {{ $posts->links() }}
  </div>
</section>
@endsection

