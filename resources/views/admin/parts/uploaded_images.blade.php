@foreach(session('product_images') as $img)
  <img src="{{ asset('storage/product_images/'.$img) }}" alt="image" style="width:100px; border:5px solid #f3f4f4;margin-bottom:5px;">
@endforeach
