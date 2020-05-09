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
@include('admin.includes.aside')
<div class="content-wrapper">
<!--breadcrumb-->
@include('admin.includes.breadcrumb')
<div class="container-fluid">


<!-- content goes here -->
<div class="row">
<div class="col-12">
<div class="card">
    <div class="card-header">
    <h3 class="card-title">Products</h3>

    <div class="card-tools">
        <div class="input-group input-group-sm" style="width: 150px; justify-content:right">
            <a href="@if(Route::has('products.create')){{ route('products.create') }} @endif" class="btn btn-primary btn-sm">Create Product</a>
        </div>
    </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap" style="font-size:0.7rem;">
        <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Brand</th>
            <th>Category</th>
            <th>Cost</th>
            <th>Price</th>
            <th>Discount</th>
            <th>Disc.T</th>
            <th>Disc.Price</th>
            <th>Disc.Perc.</th>
            <th>Viewed</th>
            <th>Thumb</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @if(isset($products))
            @foreach($products as $key => $product)


            <tr>
                <td>{{ $key + $products->firstItem() }}</td>
                <td> {{ $product->title ?? '' }} </td>
                <td> {{ $product->brand->name ?? '' }} </td>
                <td> {{ $product->category->name ?? '' }} </td>
                <td> {{ $product->buy_price ?? '' }} </td>
                <td> {{ $product->sale_price ?? '' }} </td>
                <td> {{ $product->has_discount ?? '' }} </td>
                <td> {{ $product->discount_type ?? '' }} </td>
                <td> {{ $product->discount_fixed_price ?? '' }} </td>
                <td> {{ $product->discount_percent ?? '' }} </td>
                <td> {{ $product->viewed ?? '' }} </td>
                <td>
                  @if(isset($product->thumbnail->thumbnail))
                  <a target="_blank" href="{{ asset('storage/product_thumbs/'.$product->thumbnail->thumbnail) }}">
                    <img src="{{ asset('storage/product_thumbs/'.$product->thumbnail->thumbnail) }}" alt="" style="width:30px;height:30px;border-radius:50%;">
                  </a>
                  @endif
                </td>
                <td> {{ $product->is_active ?? '' }} </td>


                <td style="width:1.5rem;">
                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                        <a class="dropdown-item" href="@if( Route::has('products.edit') ) {{ route('products.edit', $product->id) }} @endif">Edit</a>

                        <form class="" action="@if( Route::has('products.destroy') ) {{ route('products.destroy', $product->id) }} @endif" method="POST">
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

<div class="">
  {{ $products->appends($_GET)->links() }}
</div>

<!-- end content goes here -->


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
