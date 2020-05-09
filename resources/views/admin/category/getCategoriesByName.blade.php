@if(isset($categories[0]))
  <ul>
  @foreach($categories as $category)
      <li onclick="insertCateValue(this)" value="{{ $category->id }}">{{ $category->name }}</li>
  @endforeach
  </ul>
@else
<ul>
  <li onclick="makeDivEmpty('input_result_list')">Nothing Found</li>
</ul>
@endif
