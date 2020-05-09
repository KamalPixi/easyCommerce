<!-- Product Basic -->
<form action="@if(Route::has('socials.update')) {{ route('socials.update', $social->id) }} @endif" method="POST">
@CSRF
@method('PATCH')
<div class="card card-default">

  <div class="card-header">
    <h3 class="card-title">
      <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
      Social Link Edit Form
    </h3>
    <div class="card-tools">
      <a href="{{ route('socials.index') }}" class="btn btn-sm btn-primary">Back</a>
    </div>
  </div>

  <!-- /.card-header -->
  <div class="card-body" style="display: block;">


    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
            <label>Social Platform Name *</label>
            <input type="text" name="social_name" value="{{ $social->name }}" class="form-control">
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
            <label>URL * <span style="font-size:.9rem;font-weight:400">(Ex: www.facebook.com)</span></label>
            <input type="text" name="url" value="{{ $social->url }}" class="form-control">
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
            <label>Publish *</label>
            <select class="form-control" name="publish">
              <option @if($social->publish == "1") selected @endif value="1">Publish</option>
              <option @if($social->publish == "0") selected @endif value="0">Unpublish</option>
            </select>
        </div>
      </div>
    </div>


  </div>
  <!-- /.card-body -->
  <div class="card-footer" style="display: block;">
    <button type="submit" class="btn btn-primary">Update Social Link</button>
  </div>
</div>
</form>
<!-- end Product Basic -->
