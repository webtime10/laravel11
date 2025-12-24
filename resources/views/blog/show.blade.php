@extends('layouts.app')

@section('title', $title ?? 'Запись')

@section('content')
<section>
  <a href="{{ route('blog.index') }}" class="underline">&larr; К списку</a>

  <h1 class="text-3xl font-semibold mt-3">{{ $title }}</h1>
  
  @if(!empty($post->image1))
    <img src="{{ \Illuminate\Support\Facades\Storage::url($post->image1) }}" alt="{{ $title }}" class="my-4 max-h-96 object-cover">
  @endif

  <article class="prose max-w-none">
    @if($description)
      {!! $description !!}
    @else
      {!! $post->content !!}
    @endif
  </article>
</section>
@endsection

