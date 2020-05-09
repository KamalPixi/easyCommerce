<!-- error message display -->
@if(Session::has('success'))
  @include('admin.parts.flash', $flash_msg = ['class' => 'alert-success','title' => 'Success','msg' => Session::get('success')])
@endif

@if(Session::has('fail'))
  @include('admin.parts.flash', $flash_msg = ['class' => 'alert-danger','title' => 'Error!','msg' => Session::get('fail')])
@endif
<!-- end error msg -->
