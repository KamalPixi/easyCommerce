@extends('admin.app')
  @push('css')
    <link href="{{ asset('backend/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">
  @endpush

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
    <!-- Main content -->

    <div class="container-fluid">
    <!-- ### content goes here ####-->

    <!-- Product Basic -->
    <form action="@if(Route::has('products.update')) {{ route('products.update', $product->id) }} @endif" method="post">
      @csrf
      @method('PATCH')
    <input type="hidden" name="for" value="update_basic">
    <input type="hidden" name="product_id" value="{{ $product->id ?? '' }}">

    <div class="card card-default">

      <div class="card-header">
        <h3 class="card-title">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
          Product Basic *
        </h3>


        <div class="card-tools">
            <div class="input-group input-group-sm" style="width: 150px; justify-content:right">
                <a href="@if(Route::has('products.index')){{ route('products.index') }} @endif" class="btn btn-primary btn-sm">Back</a>
            </div>
        </div>
      </div>

      <!-- /.card-header -->
      <div class="card-body" style="display: block;">

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="brand_id">Brand</label>
              <select name="brand_id" class="custom-select " id="brand_id">
                  <option disabled="" selected="">Choose Brand</option>

                  @if(isset($brands))
                    @foreach($brands as $brand)
                      <option @if($brand->id == $product->brand_id) selected @endif value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                  @endif
              </select>
            </div>

          </div>
          <div class="col-md-6">
            <div class="form-group">
                <label>Category *</label>
                <input type="hidden" name="category_id" id="category_id_form" value="{{ $product->category->id }}">
                <input value="{{ $product->category->name ?? '' }}" onkeyup="getCategoriesByName(this)" id="category_id" type="text" autocomplete="off" class="form-control" placeholder="Enter to search">
                <div class="input_result_list" id="input_result_list"></div>
            </div>
          </div>
        </div>
        <!-- /.row -->

        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
                <label>SKU</label>
                <input id="sku" name="sku" value="{{ $product->sku ?? '' }}" type="text" class="form-control" placeholder="Enter SKU">
            </div>
          </div>
        </div>
        <!-- /.row -->


        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
                <label>Name *</label>
                <input onkeyup="createSlug(this, 'slug')" value="{{ $product->title ?? '' }}" name="title" id="title" type="text" class="form-control" placeholder="Enter ...">
            </div>
            <div class="form-group">
                <label>Slug *</label>
                <input name="slug" id="slug" value="{{ $product->slug ?? '' }}" type="text" class="form-control" placeholder="Enter ...">
            </div>
            <!-- /.form-group -->
            <div class="form-group">
              <label>Description *</label>
              <textarea name="description" rows="6" cols="6"  class="form-control textarea">{{ $product->description ?? '' }}</textarea>
            </div>

            <div class="form-group">
              <label>Supplier Details</label>
              <textarea name="supplier_details" rows="2" cols="2"  class="form-control">{{ $product->supplier_details ?? '' }}</textarea>
            </div>

          </div>
        </div>

      </div>
      <!-- /.card-body -->
      <div class="card-footer" style="display: block;">
        <button type="submit" class="btn btn-primary">Update Basic</button>
      </div>
    </div>
  </form>
    <!-- end Product Basic -->


    <!-- Product Price -->
    <form action="@if(Route::has('products.update')) {{ route('products.update', $product->id) }} @endif" method="post">
      @csrf
      @method('PATCH')
    <input type="hidden" name="for" value="update_price">
    <input type="hidden" name="product_id" value="{{ $product->id ?? '' }}">

    <div class="card card-default">

      <div class="card-header">
        <h3 class="card-title">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
          Product Price *</h3>
      </div>

      <!-- /.card-header -->
      <div class="card-body" style="display: block;">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
                <label>Purchase Price </label>
                <input name="buy_price" value="{{ $product->buy_price ?? '' }}" id="buy_price" type="text" class="form-control" placeholder="Enter purchase price.">
            </div>
            <!-- /.form-group -->
            <div class="form-group">
                <label>Selling Price *</label>
                <input name="sale_price" id="sale_price" value="{{ $product->sale_price ?? '' }}" type="text" class="form-control" placeholder="Enter selling price.">
            </div>
            <!-- /.form-group -->
            <div class="form-group">
                <label>Stock Qty</label>
                <input name="stock" id="stock" value="{{ $product->stock ?? '' }}" type="number" class="form-control" placeholder="Enter stock qty">
            </div>
          </div>
          <!-- /.col -->
          <div class="col-md-6">
            <div class="form-group">
              <label for="has_discount">Has Discount</label>
              <select onchange="changeDiscountState(this)" name="has_discount" class="custom-select " id="has_discount">
                  <option @if($product->has_discount == '0') selected @endif value="0">No</option>
                  <option @if($product->has_discount == '1') selected @endif value="1">Yes</option>
              </select>
            </div>

            <div class="form-group">
              <label for="discount_type">Discount Type</label>
              <select name="discount_type" class="custom-select " id="discount_type">
                  <option disabled="" selected="">Please Choose</option>
                  <option @if($product->discount_type == 'fixed') selected @endif value="fixed">Fixed</option>
                  <option @if($product->discount_type == 'percent') selected @endif value="percent">Percent</option>
              </select>
            </div>

            <div class="form-group">
                <label>Discount Amount</label>
                <input id="discount_amount"
                value="@if($product->discount_type == 'fixed'){{ $product->discount_fixed_price ?? '' }}@elseif($product->discount_type == 'percent'){{ $product->discount_percent ?? '' }}@endif"
                name="discount_amount" type="number" class="form-control" placeholder="Enter discount.">
            </div>

          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

      </div>
      <!-- /.card-body -->
      <div class="card-footer" style="display: block;">
        <button type="submit" class="btn btn-primary">Update Price</button>
      </div>
    </div>
  </form>
    <!-- end Product price -->


    <!-- onsubmit="saveAttributes(event)" -->
    <!-- Product Attribute -->
    <form action="@if(Route::has('products.update')) {{ route('products.update', $product->id) }} @endif" method="post">
      @csrf
      @method('PATCH')
    <input type="hidden" name="for" value="update_attribute">
    <input type="hidden" name="product_id" value="{{ $product->id ?? '' }}">

    <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
          Product Attribute
        </h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
      </div>

      <!-- /.card-header -->
      <div class="card-body" style="display: block;">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="has_attribute">Has Attribute</label>
              <select name="has_attribute" class="custom-select " id="has_attribute">
                  <option @if($product->has_attribute == '0') selected @endif value="0">No</option>
                  <option @if($product->has_attribute == '1') selected @endif value="1">Yes</option>
              </select>
            </div>
          </div>
        </div>
        <!-- /.row -->
        <div class="" id="attribute_container">

          <div id="attribute_container_rows">
            <div class="row">

              @foreach($product->attributes as $attribute)
              <div class="col-md-6">
                <div class="form-group">
                    <label>Attribute Key</label>
                    <input name="attribute_key[]" value="{{ $attribute->key }}" type="text" class="form-control attribute_key" placeholder="Enter">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  @php $v = '' @endphp
                  @foreach($attribute->values as $value)
                    @php $v .= $value->value.',' @endphp
                  @endforeach
                    <label>Attribute Values <span style="font-size:.8rem;font-weight:400;">(sperate by coma)</span></label>
                    <input  name="attribute_value[]"value="{{ rtrim($v, ',') }}" type="text" class="form-control attribute_value" placeholder="Example: Red, Green, etc">
                </div>
              </div>
              @endforeach

            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <button onclick="addAttribute()" type="button" class="btn btn-sm btn-info">Add Another</button>
              </div>
            </div>
          </div>

        </div>


      </div>
      <!-- /.card-body -->
      <div class="card-footer" style="display: block;">
        <button type="submit" class="btn btn-primary">Save Attribute</button>
      </div>
    </div>
  </form>
    <!-- end Product Attribute -->


    <!-- Product SEO -->
    <form action="@if(Route::has('products.update')) {{ route('products.update', $product->id) }} @endif" method="post">
      @csrf
      @method('PATCH')
    <input type="hidden" name="for" value="update_seo">

    <div class="card card-default">

      <div class="card-header">
        <h3 class="card-title">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>

          Product SEO
        </h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
      </div>

      <!-- /.card-header -->
      <div class="card-body" style="display: block;">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                    <label>Meta Title</label>
                    <input id="meta_title" value="{{ $product->meta_title ?? '' }}" name="meta_title" type="text" class="form-control" placeholder="Enter meta title">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                    <label>Meta Keywords<span style="font-size:.8rem;font-weight:400;">(sperate by coma)</span></label>
                    <input id="meta_keywords" value="{{ $product->meta_keywords ?? '' }}" name="meta_keywords" type="text" class="form-control" placeholder="Example: Red, Green, etc">
                </div>
              </div>
            </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Meta Description</label>
                <textarea id="meta_description" name="meta_description" class="form-control" rows="3" placeholder="Enter ...">{{ $product->meta_description ?? '' }}</textarea>
              </div>
            </div>
          </div>

      </div>
      <!-- /.card-body -->
      <div class="card-footer" style="display: block;">
        <button type="submit" class="btn btn-primary">Save SEO</button>
      </div>
    </div>
  </form>
    <!-- end Product SEO -->




    <!-- Product Image -->
    <form action="@if(Route::has('products.update')) {{ route('products.update', $product->id) }} @endif" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <input type="hidden" name="for" value="update_image">

    <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>

          Product Image *
        </h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
      </div>


      <!-- /.card-header -->
      <div class="card-body" style="display: block;">
            <div class="row">
              <div class="col-md-12">

                <div id="product_image_container">
                  <div class="form-group">
                    <div class="" style="width:90%; display:inline-block">
                      <label>Image * <span style="font-size:.9rem;font-weight:400">Allowed Ext. (jpeg, png, jpg)</span> </label>
                      <input name="product_images[]" type="file" class="form-control">
                    </div>

                      <div class="" style="display:inline-block; margin-left:1rem;">
                        <i onclick="addImage()" class="fas fa-plus-circle img-add"></i>
                      </div>
                  </div>
                </div>

                <div id="upload_img_container">

                  @if(isset($product->thumbnail->thumbnail))
                  <div class="d-inline-block text-align-center">
                    <a href="{{ asset('storage/product_thumbs/'.$product->thumbnail->thumbnail) }}" target="_blank">
                      <img src="{{ asset('storage/product_thumbs/'.$product->thumbnail->thumbnail) }}" alt="image" style="width:80px; border:5px solid #f3f4f4;margin-bottom:5px;">
                    </a>

                    <br>
                    <form class="" action="@if( Route::has('products.destroy') ) {{ route('products.destroy', $product->id) }} @endif" method="POST">
                      @CSRF
                      @method('DELETE')
                      <input type="hidden" name="thumb_id" value="{{$product->thumbnail->id}}">
                      <input type="hidden" name="for" value="destroy_thumb">
                      <input type="submit" name="" class="btn btn-sm btn-danger" value="Delete thumbnail">
                    </form>
                  </div>
                  @endif

                    @foreach($product->images as $img)
                    <div class="d-inline-block text-align-center">
                      <a href="{{ asset('storage/product_images/'.$img->image) }}" target="_blank">
                        <img src="{{ asset('storage/product_images/'.$img->image) }}" alt="image" style="width:80px; border:5px solid #f3f4f4;margin-bottom:5px;">
                      </a>

                      <br>
                      <form class="" action="@if( Route::has('products.destroy') ) {{ route('products.destroy', $product->id) }} @endif" method="POST">
                        @CSRF
                        @method('DELETE')
                        <input type="hidden" name="image_id" value="{{$img->id}}">
                        <input type="hidden" name="for" value="destroy_image">
                        <input type="submit" name="" class="btn btn-sm btn-danger" value="Delete">
                      </form>
                    </div>
                    @endforeach
                </div>

              </div>

            </div>


      </div>
      <!-- /.card-body -->
      <div class="card-footer" style="display: block;">
        <button type="submit" class="btn btn-primary">Update Image</button>
      </div>
    </div>
  </form>
    <!-- end Product Image -->



    <!-- publish product -->
    <form action="@if(Route::has('products.update')) {{ route('products.update', $product->id) }} @endif" method="post">
    @csrf
    @method('PATCH')
    <input type="hidden" name="for" value="update_publish">

    <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>

          Publish Product *
        </h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
      </div>


      <!-- /.card-header -->
      <div class="card-body" style="display: block;">
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="is_active">Publish Product</label>
              <select name="is_active" class="custom-select " id="is_active">
                <option @if($product->is_active == '1') selected @endif value="1">Yes</option>
                <option @if($product->is_active == '0') selected @endif value="0">No</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <!-- /.card-body -->
      <div class="card-footer" style="display: none;">
        <button id="is_active_btn" type="submit" class="btn btn-success">Publish Product</button>
      </div>
    </div>
  </form>
    <!-- end publish product -->




    <!--### end content goes here ### -->
    </div>
    <!-- End Main content -->
    </div>
    <!-- /.content-wrapper -->
    @include('admin.includes.footer')
    <!-- /.control-sidebar -->
    @include('admin.includes.side_controll')
    </div>
    <!-- ./wrapper -->

    <!-- push textEdit js library -->
    @push('js')
      <script src="{{ asset('backend/plugins/summernote/summernote-bs4.min.js') }}"></script>
      <script> $(function () { $('.textarea').summernote()}) </script>
    @endpush

  @endsection('content')
