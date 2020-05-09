<ul>
  @foreach($products as $product)
    <li><a href="{{ route('product', $product->slug) }}"> {{ $product->title ?? '' }} </a></li>
  @endforeach
</ul>
