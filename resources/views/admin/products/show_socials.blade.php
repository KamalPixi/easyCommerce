<div class="row">
<div class="col-12">
<div class="card">
    <div class="card-header">
    <h3 class="card-title">Social Links</h3>

    <div class="card-tools">
        <div class="input-group input-group-sm" style="width: 150px; justify-content:right">
            <a href="@if(Route::has('socials.create')){{ route('socials.create') }} @endif" class="btn btn-primary btn-sm">Create Social Link</a>
        </div>
    </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>URL</th>
            <th>Publish</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @if(isset($socials))
            @foreach($socials as $key => $social)
            <tr>
                <td>{{ $key + 1}}</td>
                <td>{{ $social->name }}</td>
                <td>{{ $social->url }}</td>
                <td>{{ ($social->publish) ? 'Published' : 'Unpublished' }}</td>
                <td style="width:1.5rem;">
                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                        <a class="dropdown-item" href="@if( Route::has('socials.edit') ) {{ route('socials.edit', $social->id) }} @endif">Edit</a>

                        <form class="" action="@if( Route::has('socials.destroy') ) {{ route('socials.destroy', $social->id) }} @endif" method="POST">
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
