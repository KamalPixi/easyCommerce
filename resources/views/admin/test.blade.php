<form action="{{route('order_master.destroy', 1)}}" method="post">
  <input type="hidden" name="for" value="mark_as_shipped">
  @csrf
  @method('PATCH')
  <input type="submit" name="submit" value="send">
</form>
