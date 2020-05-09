@if($errors->any())
      <div class="alert alert-danger mt-2">
        @foreach($errors->all() as $error)
          {{$error}}</br>
        @endforeach
      </div>
  @endif

  @if(Session::has('success'))
      <div class="alert alert-success mt-2">
          {{Session::get('success')}}
      </div>
  @endif
  @if(Session::has('fail'))
      <div class="alert alert-danger mt-2">
        {{Session::get('fail')}}
      </div>
  @endif
