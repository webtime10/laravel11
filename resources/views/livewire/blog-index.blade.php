<section>
  <h1 class="text-2xl font-semibold mb-4">Блог</h1>

  <ul class="space-y-4">
    @foreach($posts as $p)
      <li class="border rounded p-4">
        <a href="{{ route('blog.show', $p->id) }}" wire:navigate class="block">
          @if(!empty($p->image1))
            <img src="{{ asset($p->image1) }}" alt="{{ $p->name1 }}" class="mb-3 max-h-48 object-cover">
          @endif
          <h2 class="text-xl font-medium">{{ $p->name1 ?? 'Без названия' }}</h2>
          <p class="text-sm text-gray-600">
            {{ \Illuminate\Support\Str::limit(strip_tags($p->content), 140) }}
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

