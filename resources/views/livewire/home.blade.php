<section>
  <h1>{{ $title }}</h1>
  
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
