const CART_URL = '/cart';
const USER_REGISTER_URL = '/register';
const USER_LOGIN_URL = '/login';
const GET_INFO = '/get';
const CHECKOUT_URL = '/checkout';
const USER_URL = '/user';
const SEARCH_URL = '/search';

function variationClicked(el, att_id, val_id) {
  // get variation rows
  let rows = document.getElementsByClassName("product-variation-row-"+att_id);
  for(let i=0; i < rows.length; i++) {
    // remove product-v-selected class
    rows[i].classList.remove("product-v-selected");
    rows[i].removeAttribute('name');
    rows[i].removeAttribute('value');
  }

  // add class to selected variation.
  el.classList.add("product-v-selected");
  el.setAttribute("name", "attribute_value_id[]");
  el.setAttribute("value", val_id);
}


// submit product cart/buy form
function addToCart(btn_name) {
  // length of selected attribute_values of product
  let l = document.getElementsByClassName("product-v-selected").length;

  if (btn_name == "add_to_cart" || btn_name == "buy_now") {
    // att_val_size <- it has declared in the view(product_in_blade)
    if (att_val_size == l) {
      $selected_att = document.getElementsByClassName('product-v-selected');
      for (var i = 0; i < $selected_att.length; i++) {
        let container = document.getElementById('attribute_value_container');
        container.innerHTML += '<input type="hidden" name="attribute_value_id[]" value="'+ $selected_att[i].value +'">';
      }

      submitCart(btn_name);
    }
  }
}



function submitCart(btn_name) {
  // get slected btns
  let btns = document.getElementsByClassName('product-v-selected');
  let ids = [];
  // store attribute_value_ids
  for (var i = 0; i < btns.length; i++) {
    ids.push(btns[i].value);
  }

  // send add to cart request
  $.ajax({
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    url: CART_URL,
    method: "POST",
    data: { 'product_id' : $('#product_id').val(), 'qty':$('#qty').val(), 'attribute_value_id':ids },
  }).done(function(res) {
    if (btn_name == "add_to_cart") {
      // set cart html
      document.getElementById('cart_holder').innerHTML = res.cart;
      $.notify('Added to cart', 'success');
    }else {
      location.href = '/cart';
    }
  })
  .fail(function(xhttp, txtStatus, err) {
    console.log(err);
    $.notify("Somthing wrong", "error");
  });
}

function removeFromCart(product_id) {
  $.ajax({
    url: CART_URL,
    method: "GET",
    data: {'delete' : product_id}
  }).done(function(res) {
    $.notify(res.message, "success");
    location.href = location.href;
  })
  .fail(function(xhttp, txtStatus, err) {
    console.log(err);
    $.notify("Somthing wrong", "error");
  });
}


function shippingChoosed(shipping_method_id) {
  $.ajax({
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    url: CART_URL,
    method: "POST",
    data: {'shipping_method_id' : shipping_method_id}
  }).done(function(res) {
    $('#cart-subtotal').html(res.subtotal);
  })
  .fail(function(xhttp, txtStatus, err) {
    console.log(err);
  });
}

function addToCartSingle(p_id) {
  $.ajax({
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    url: CART_URL,
    method: "POST",
    data: {'product_id' : p_id, 'qty':1}
  }).done(function(res) {
    document.getElementById('cart_holder').innerHTML = res.cart;
    $.notify('Added to cart', "success");
  })
  .fail(function(xhttp, txtStatus, err) {
    console.log(err);
  });
}

function checkLoginStatus() {
  $.ajax({
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    url: GET_INFO,
    method: "POST",
    data: {'for': "is_user_logged_in"}
  }).done(function(res) {
    if (res.message)
      location.href = CHECKOUT_URL;
    else {
      $("#login_registration_model").modal('show');
      // location.href = USER_LOGIN_URL+'?redirect=checkout';
    }
  })
  .fail(function(xhttp, txtStatus, err) {
    console.log(err);
  });
}

// send checkout details
function submitCheckout() {
  // get form data
  let formData = {
    'shipping_firstName': $('#shipping_firstName').val(),
    'shipping_lastName': $('#shipping_lastName').val(),
    'shipping_address_1': $('#shipping_address_1').val(),
    'shipping_country': $('#shipping_country').val(),
    'shipping_state': $('#shipping_state').val(),
    'shipping_city': $('#shipping_city').val(),
    'shipping_zip': $('#shipping_zip').val(),
    'shipping_mobile': $('#shipping_mobile').val()
  }

  $.ajax({
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      url: CHECKOUT_URL,
      type: "post",
      data: formData,
      success: function (data) {
        $.notify("Checkout has been completed.", "success");
        setTimeout(function(){ location.href = USER_URL; }, 1000);
      },
      error: function (data) {
          var messages = '';
          var errors = $.parseJSON(data.responseText);
          $.each(errors.errors, function (key, value) {
            messages += value[0]+"\n";
          });
          $.notify(messages, "error");
      }
  });
}


// get search results
function search(el) {
  let formData = {'keyword': el.value}
  $.ajax({
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    url: SEARCH_URL,
    method: "GET",
    data: formData,
  }).done(function(res) {
    // make result container visible
    search_results = document.getElementsByClassName('seacrh-result');
    for (var i = 0; i < search_results.length; i++) {
      search_results[i].style.display = 'block';
    }

    // insert search result in container
    search_results = document.getElementsByClassName('seacrh-result');
    for (var i = 0; i < search_results.length; i++) {
      search_results[i].innerHTML = res;
    }
  })
  .fail(function(xhttp, txtStatus, err) {
    console.log(err);
  });
}

// to make thisgs hidden from dom
function closeThings() {
  search_results = document.getElementsByClassName('seacrh-result');
  for (var i = 0; i < search_results.length; i++) {
    search_results[i].style.display = 'none';
  }
}
// body on onclick listner
document.getElementsByTagName('body')[0].onclick = closeThings;


function submitSearch() {
  let search_input = $('#search_input').val();
  let search_input_mobile = $('#search_input_mobile').val();
  if ($(".mobile_search_bar").is(":visible"))
    return location.href = SEARCH_URL+'?keyword='+search_input_mobile;
  return location.href = SEARCH_URL+'?keyword='+search_input;
}

// show popup_banner
$(document).ready(function(){
    $("#popup_banner").modal('show');
});

// ajax user login
function loginUser() {
  let form = document.querySelector('#user_popup_login');
  let formData = {
    email: form.querySelector('#email').value,
    password: form.querySelector('#password').value
  }

  // login request
  $.ajax({
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    url: USER_LOGIN_URL,
    method: "POST",
    data: formData,
  }).done(function(res) {
    if (!res.error) {
      location.href = CHECKOUT_URL;
    }
  })
  .fail(function(xhttp, txtStatus, err) {
    document.querySelector('#login_error_container').innerHTML = '<div class="alert alert-danger" role="alert">Please check your credentials.</div>';
  });
}

// ajax user register
function registerUser() {
  // get the form
  let form = document.querySelector('#cart_user_registration');
  let formData = {
    first_name: form.querySelector('#first_name').value,
    last_name: form.querySelector('#last_name').value,
    email: form.querySelector('#email').value,
    password: form.querySelector('#password').value,
    password_confirmation: form.querySelector('#password-confirm').value
  };


  $.ajax({
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      url: USER_REGISTER_URL,
      type: "post",
      data: formData,
      success: function (data) {
          //redirect to checkout page
          location.href = CHECKOUT_URL;
      },
      error: function (data) {
          var messages = '';
          var errors = $.parseJSON(data.responseText);
          $.each(errors.errors, function (key, value) {
            messages += value[0]+'<br>';
          });
          $('#registration_error_container').html('<div class="alert alert-danger" role="alert">'+messages+'</div>');
      }
  });

}

const observer = lozad(); // lazy loads elements with default selector as '.lozad'
observer.observe();
