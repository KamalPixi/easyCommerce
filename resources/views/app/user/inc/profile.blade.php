<div class="card rounded-0 p-4">
    <div class="d-flex">
      <div class="">
        <h5 class="my-0 text-dark">My Profile</h5>
        <p class="font-size-small">Manage and protect your account</p>
      </div>
    </div>

    <div class="card-body">

        <form method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data">
          <input type="hidden" name="for" value="profile">
            @csrf
            <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">First Name</label>

                <div class="col-md-6">
                    <input id="first_name" type="text" class="form-control" name="first_name" value="{{ $user->first_name ?? '' }}" required autocomplete="first_name" autofocus>
                </div>
            </div>

            <div class="form-group row">
                <label for="last_name" class="col-md-4 col-form-label text-md-right">Last Name</label>

                <div class="col-md-6">
                    <input id="last_name" type="text" class="form-control" name="last_name" value="{{ $user->last_name ?? '' }}" required autocomplete="name" autofocus>
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">Email Address</label>
                <div class="col-md-6">
                    <input id="email" type="email" class="form-control" name="email" value="{{ $user->email ?? '' }}" required autocomplete="email">
                </div>
            </div>

            <div class="form-group row">
                <label for="mobile" class="col-md-4 col-form-label text-md-right">Mobile</label>
                <div class="col-md-6">
                    <input id="mobile" type="tel" class="form-control" name="mobile" value="{{ $user->mobile ?? '' }}" placeholder="Mobile no.">
                </div>
            </div>

            <div class="form-group row">
                <label for="image" class="col-md-4 col-form-label text-md-right">Image</label>
                <div class="col-md-6">
                    <input id="image" type="file" class="form-control" name="image">
                </div>
            </div>
            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
