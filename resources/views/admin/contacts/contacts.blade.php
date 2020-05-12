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
          <h3 class="card-title">Contact Request</h3>

          <div class="card-tools">
              <div class="input-group input-group-sm" style="width: 150px; justify-content:right">
                  <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-sm">Back</a>
              </div>
          </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
          <table class="table table-hover text-nowrap">
              <thead>
              <tr>
                  <th>#</th>
                  <th style="width:120px">Name</th>
                  <th style="width:120px">Subject</th>
                  <th>Message</th>
                  <th style="width:120px">Email</th>
                  <th>Action</th>
              </tr>
              </thead>
              <tbody>
                  @foreach($contacts as $key => $contact)
                  <tr>
                      <td>{{ $key + 1}}</td>
                      <td>{{ $contact->name }}</td>
                      <td>{{ $contact->subject }}</td>
                      <td>
                        <textarea style="width:300px" name="name" rows="1" cols="10" class="form-control">{{ $contact->message }}</textarea>
                      </td>
                      <td>{{ $contact->email }}</td>
                      <td style="width:1.5rem;">
                          <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                          <div class="btn-group" role="group">
                              <button id="btnGroupDrop1" type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Action
                              </button>
                              <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                              <form class="" action="@if( Route::has('contacts.destroy') ) {{ route('contacts.destroy', $contact->id) }} @endif" method="POST">
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
              </tbody>
          </table>
          </div>
          <!-- /.card-body -->
      </div>
      <!-- /.card -->
      </div>
      </div>
      <!-- /.row -->

      <div class="d-flex justify-content-end">
        {{ $contacts->links() }}
      </div>


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
