<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
          <div class="d-flex align-items-center h-100">
            <h1 class="m-0 text-dark" style="font-size:1.2rem;">
              @if(isset($breadcrumb['title']))
                  {{ $breadcrumb['title'] }}
              @endif
            </h1>
          </div>

        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">
                @if(isset($breadcrumb['sub_title']))
                    {{ $breadcrumb['sub_title'] }}
                @endif
            </li>
        </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
