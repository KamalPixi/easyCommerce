@extends('app.app')
@section('content')
  <!--include header-->

  @include('app.includes.header')

    <div class="container my-2">
      <div class="row">
        <div class="col">
          @if($errors->any())
              <div class="alert alert-danger">
              @foreach($errors->all() as $error)
                  {{$error}}</br>
              @endforeach
              </div>
          @endif

          @if(Session::has('success'))
              <div class="alert alert-success">
                  {{Session::get('success')}}
              </div>
          @endif
          @if(Session::has('fail'))
              <div class="alert alert-danger">
              {{Session::get('fail')}}
              </div>
          @endif
        </div>
      </div>
    </div>


    <div class="container mt-4 mb-5">
      <div class="row">
        <div class="col">
          <div class="">
            <h2 class="section-title m-0">Contact Us</h2>
            <p>We are ready to help you, Just drop a message. Thank You :)</p>
          </div>
        </div>
      </div>
    </div>


    <!-- ================ contact section start ================= -->
    <section class="section_gap mb-5">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h2 class="contact-title">Get in Touch</h2>
        </div>
        <div class="col-lg-8 mb-4 mb-lg-0">
          <form class="form-contact contact_form" action="{{ route('contact.store') }}" method="post" id="contactForm">
          @csrf
          <div class="row">
              <div class="col-12">
                <div class="form-group">
                    <textarea required class="form-control w-100" name="message" id="message" cols="30" rows="9" placeholder="Enter Message *"></textarea>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <input class="form-control" name="name" id="name" type="text" placeholder="Enter your name">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <input required class="form-control" name="email" id="email" type="email" placeholder="Enter email address *">
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <input class="form-control" name="subject" id="subject" type="text" value="{{ request()->input('subject') ?? '' }}" placeholder="Enter Subject"/>
                </div>
              </div>
            </div>
            <div class="form-group mt-lg-3">
              <button type="submit" class="btn btn-primary">Send Message</button>
            </div>
          </form>


        </div>

        <div class="col-lg-4">
          <div class="media contact-info">
            <span class="contact-info__icon"><i class="ti-home"></i></span>
            <div class="media-body">
              <h3></h3>
              <p></p>
            </div>
          </div>
          <div class="media contact-info">
            <span class="contact-info__icon"><i class="ti-tablet"></i></span>
            <div class="media-body">
              <h3><a href="tel:454545654">(+880) 1940 977 996</a></h3>
              <p>Monday to Friday</p>
            </div>
          </div>
          <div class="media contact-info">
            <span class="contact-info__icon"><i class="ti-email"></i></span>
            <div class="media-body">
              <h3><a href="mailto:medleyMartBD@gmail.com">MedleyMartBD@gmail.com</a></h3>
              <p>Send us your query anytime!</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
	<!-- ================ contact section end ================= -->

<!--include footer-->
@include('app.includes.footer')
@endsection
