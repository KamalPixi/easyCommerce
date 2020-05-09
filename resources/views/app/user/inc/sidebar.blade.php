<ul class="nav flex-column">
  <li class="nav-item mb-2">
    <div class="pl-lg-3 d-flex align-items-center">
      <div class="d-flex align-items-center justify-content-center overflow-hidden wh-fixed-50 rounded-circle border border-secondary">
        <img src="{{ asset('storage/user_images/'.auth()->user()->image) }}" alt="user image" width="40" height="40">
      </div>
      <div class="d-inline-block ml-3 line-height-1">
        <span class="d-block text-dark font-weight-bold"> {{ $user->first_name . ' ' . $user->last_name ?? '' }}</span>
        <span class="font-size-half"> {{ $user->email ?? '' }}</span>
      </div>
    </div>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('user.index') }}">My Purchase</a>
    <hr>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('user.create', ['for'=>'profile']) }}">Profile</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#">Bank & Cards</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('user.create', ['for'=>'address']) }}">Address</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('user.create', ['for'=>'password']) }}">Change Password</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('user.index', ['for'=>'logout']) }}">Logout</a>
  </li>

</ul>
