<div class="card rounded-0 p-4">
    <div class="d-flex">
      <div class="">
        <h5 class="my-0 text-dark">My Password</h5>
      </div>
    </div>

    <div class="card-body">

        <form method="POST" action="{{ route('user.store') }}">
          <input type="hidden" name="for" value="password">
            @csrf

            <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">Current Password</label>

                <div class="col-md-6">
                    <input type="password" class="form-control" name="current_password" required autofocus>
                </div>
            </div>

            <div class="form-group row">
                <label for="last_name" class="col-md-4 col-form-label text-md-right">New Password</label>
                <div class="col-md-6">
                    <input type="password" class="form-control" name="new_password">
                </div>
            </div>

            <div class="form-group row">
                <label for="last_name" class="col-md-4 col-form-label text-md-right">Repeat New Password</label>
                <div class="col-md-6">
                    <input type="password" class="form-control" name="repeat_new_password">
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">Change Password</button>
                </div>
            </div>
        </form>
    </div>
</div>
