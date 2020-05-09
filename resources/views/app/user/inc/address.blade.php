<div class="card rounded-0 p-4">
    <div class="d-flex">
      <div class="">
        <h5 class="my-0 text-dark">My Address</h5>
      </div>
    </div>

    <div class="card-body">

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">First Name</label>

                <div class="col-md-6">
                    <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>
                </div>
            </div>

            <div class="form-group row">
                <label for="last_name" class="col-md-4 col-form-label text-md-right">Last Name</label>

                <div class="col-md-6">
                    <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required autocomplete="name" autofocus>
                </div>
            </div>

            <div class="form-group row">
                <label for="address_01" class="col-md-4 col-form-label text-md-right">Address 1*</label>
                <div class="col-md-6">
                    <input id="address_01" type="address_01" class="form-control @error('address_01') is-invalid @enderror" name="address_01" value="{{ old('email') }}" required autocomplete="email">
                </div>
            </div>

            <div class="form-group row">
                <label for="address_02" class="col-md-4 col-form-label text-md-right">Address 2</label>
                <div class="col-md-6">
                    <input id="address_02" type="address_02" class="form-control" name="address_02" required autocomplete="email">
                </div>
            </div>

            <div class="form-group row">
                <label for="mobile" class="col-md-4 col-form-label text-md-right">City</label>
                <div class="col-md-6">
                    <input id="mobile" type="tel" class="form-control" name="mobile" value="{{ old('email') }}" required autocomplete="mobile">
                </div>
            </div>

            <div class="form-group row">
                <label for="mobile" class="col-md-4 col-form-label text-md-right">State</label>
                <div class="col-md-6">
                    <input id="mobile" type="tel" class="form-control" name="mobile" value="{{ old('email') }}" required autocomplete="mobile">
                </div>
            </div>

            <div class="form-group row">
                <label for="mobile" class="col-md-4 col-form-label text-md-right">Zip</label>
                <div class="col-md-6">
                    <input id="mobile" type="tel" class="form-control" name="mobile" value="{{ old('email') }}" required autocomplete="mobile">
                </div>
            </div>

            <div class="form-group row">
                <label for="mobile" class="col-md-4 col-form-label text-md-right">Country</label>
                <div class="col-md-6">
                  <select class="custom-select d-block w-100" id="shipping_country" required="">
                    <option value="">Choose...</option>
                    <option>Bangladesh</option>
                    <option>UK</option>
                    <option>USA</option>
                  </select>
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
