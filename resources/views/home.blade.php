@extends('layouts.app')

@section('title', $title ?? 'Главная')



@section('content')
<section>
  <h1>{{ $title }}</h1>
<h2>{{ __('post.posts_list') }}:</h2>
  @if($block1)
    <div class="block-1">
      {!! $block1 !!}
    </div>
  @endif

  @if($block2)
    <div class="block-2">
      {!! $block2 !!}
    </div>
  @endif
</section>
@endsection





