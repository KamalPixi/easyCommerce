@extends('admin.app')
  @section('content')

  <!-- error message display -->
  @if($errors->any())
      @foreach($errors->all() as $error)
          @include('admin.parts.flash', $flash_msg = ['class' => 'alert-danger','title' => 'Error!','msg' => $error])
      @endforeach
  @endif

  @if(Session::has('success'))
    @include('admin.parts.flash', $flash_msg = ['class' => 'alert-success','title' => 'Success','msg' => Session::get('success')])
  @endif

  @if(Session::has('fail'))
    @include('admin.parts.flash', $flash_msg = ['class' => 'alert-danger','title' => 'Error!','msg' => Session::get('fail')])
  @endif
  <!-- end error msg -->


  <div class="wrapper">
    @include('admin.includes.nav')
    @include('admin.includes.aside', ['data'=>'some data'])

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!--breadcrumb-->
    @include('admin.includes.breadcrumb')

    <!-- Main content -->
    <div class="container-fluid">


      <div class="row">
      <div class="col-12">
      <div class="card">
          <div class="card-header">
          <h3 class="card-title">Social Links</h3>

          <div class="card-tools">
              <div class="input-group input-group-sm" style="width: 150px; justify-content:right">
                  <a href="@if(Route::has('popup_banners.create')){{ route('popup_banners.create') }} @endif" class="btn btn-primary btn-sm">Create Popup</a>
              </div>
          </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
          <table class="table table-hover text-nowrap">
              <thead>
              <tr>
                  <th>#</th>
                  <th>Title</th>
                  <th>Description</th>
                  <th>URL</th>
                  <th>Image</th>
                  <th>Showing Page</th>
                  <th>Action</th>
              </tr>
              </thead>
              <tbody>
              @if(isset($popup_banners))
                  @foreach($popup_banners as $key => $popup_banner)
                  <tr>
                      <td>{{ $key + 1}}</td>
                      <td>{{ $popup_banner->title ?? '' }}</td>
                      <td>{{ $popup_banner->description ?? '' }}</td>
                      <td>{{ $popup_banner->call_to_action ?? '' }}</td>
                      <td> <a target="_blank" href="{{ asset('storage/media/'.$popup_banner->image) }}"> <img src="{{ asset('storage/media/'.$popup_banner->image) }}" alt="" width="40"> </a></td>
                      <td>{{ $popup_banner->show_on_page ?? '' }}</td>
                      <td style="width:1.5rem;">
                          <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                          <div class="btn-group" role="group">
                              <button id="btnGroupDrop1" type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Action
                              </button>
                              <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                              <a class="dropdown-item" href="@if( Route::has('popup_banners.edit') ) {{ route('popup_banners.edit', $popup_banner->id) }} @endif">Edit</a>

                              <form class="" action="@if( Route::has('popup_banners.destroy') ) {{ route('popup_banners.destroy', $popup_banner->id) }} @endif" method="POST">
                                @CSRF
                                @method('DELETE')
                                <input class="dropdown-item" type="submit" name="destroy" value="Delete">
                              </form>

                              </div>
                          </div>
                          </div>
                      </td>
                  </tr>
                  @endforeach
              @endif
              </tbody>
          </table>
          </div>
          <!-- /.card-body -->
      </div>
      <!-- /.card -->
      </div>
      </div>
      <!-- /.row -->



    </div>
    <!-- End Main content -->
    </div>
  <!-- /.content-wrapper -->
  @include('admin.includes.footer')
  <!-- /.control-sidebar -->
  @include('admin.includes.side_controll')
  </div>
  <!-- ./wrapper -->
  @endsection('content')
