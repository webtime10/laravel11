<section>
  <a href="{{ route('blog.index') }}" wire:navigate class="underline">&larr; К списку</a>

  <h1 class="text-3xl font-semibold mt-3">{{ $post->name1 }}</h1>
  @if(!empty($post->image1))
    <img src="{{ asset($post->image1) }}" alt="{{ $post->name1 }}" class="my-4 max-h-96 object-cover">
  @endif

  <article class="prose max-w-none">
    {!! $post->content !!}
  </article>
</section>
