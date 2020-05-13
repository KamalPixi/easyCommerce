// for ajax call
function callAjax(data) {
  return $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       },
      url: data.url,
      type: data.type ? data.type : 'POST',
      cache: data.cache ? data.cache : false,
      processData: data.processData ? data.processData : false,
      data: data.formData,
  });
}


// get sub-category by category id
function getSubCategoriesById(e) {
  if (e.value != undefined && e.value != '') {

      let formData = {
        'url':'/get',
        'processData': true,
        'formData': {'for':'subcategories', 'category_id': e.value}
      };

      $.when(callAjax(formData)).done(function(res) {
        $('#sub_sub_category_id').html(res);
      });
  }
}//end getSubCategoriesById


function getCategoriesByName(e) {
  if (e.value != '') {
      let formData = {
        'url':'/get',
        'processData': true,
        'formData': {'for':'categories_by_name', 'name': e.value}
      };

      $.when(callAjax(formData)).done(function(res) {
        $('#input_result_list').html(res);
      });
  }
}//end getSubCategoriesById


// create a slug
function createSlug(e, result_div_id) {
  if (e.value != undefined && e.value != '') {
      let title = e.value;
      let formData = {
        'url':'/get',
        'processData': true,
        'formData': {'for':'create_slug','title': title}
      };

      $.when(callAjax(formData)).done(function(res) {
        $('#'+result_div_id).val(res);
      });
  }
}//end getSlug


// applied on product addform page
function changeDiscountState(e) {
  if (e.value === 'no') {
    $("#discount_type").attr("disabled",'disabled');
    $("#discount_amount").attr("disabled",'disabled');
    return;
  }

  $("#discount_type").attr("disabled",false);
  $("#discount_amount").attr("disabled",false);
}




// insert result value in the search box
function insertCateValue(e) {
  $('#category_id').val(e.innerText);
  $('#category_id_form').val(e.value);
  $('#input_result_list').html('');
}
// make empty a dive by his id
function makeDivEmpty(div_id) {
  $('#'+div_id).html('');
}

// get attribute div row
function addAttribute() {
  let formData = {
    'url':'/get',
    'processData': true,
    'formData':{'for':'attribute_div'}
  };

  $.when(callAjax(formData)).done(function(res) {
    $('#attribute_container_rows').append(res);
  });
}




/* functions for product */
// send product basic info
function saveBasic(e) {
  if (true) {
      let formData = {
        'url':e.action,
        'processData': true,
        'formData': {
          'for':'save_basic',
          'brand_id':$('#brand_id').val(),
          'category_id':$('#category_id_form').val(),
          'sku':$('#sku').val(),
          'title':$('#title').val(),
          'slug':$('#slug').val(),
          'description':$('#post_long_description').val(),
          'supplier_details':$('#supplier_details').val(),
          '_method': $('#patch').val()
        }
      };

      $.when(callAjax(formData)).done(function(res) {
        $.notify(res.msg, "success");
      }).fail(function (x, textStatus, errorThrown) {
        let response = JSON.parse(x.responseText);
        let errorMsgs = "";
        response.errors.brand_id.forEach((item, i) => {
          errorMsgs += item+"\n";
        });
        response.errors.category_id.forEach((item, i) => {
          errorMsgs += item+"\n";
        });
        response.errors.title.forEach((item, i) => {
          errorMsgs += item+"\n";
        });
        response.errors.slug.forEach((item, i) => {
          errorMsgs += item+"\n";
        });
        response.errors.description.forEach((item, i) => {
          errorMsgs += item+"\n";
        });

        $.notify(errorMsgs, "error");
      });
  }
}





// save product price
function savePrice(e) {
  if (true) {
      let formData = {
        'url':e.action,
        'processData': true,
        'formData': {
          'for':'save_price',
          'buy_price':$('#buy_price').val(),
          'sale_price':$('#sale_price').val(),
          'stock':$('#stock').val(),
          'has_discount':$('#has_discount').val(),
          'discount_type':$('#discount_type').val(),
          'discount_amount':$('#discount_amount').val()
        }
      };

      $.when(callAjax(formData)).done(function(res) {
        $.notify(res.msg, "success");
      }).fail(function (x, textStatus, errorThrown) {
        let response = JSON.parse(x.responseText);
        let errorMsgs = "";
        response.errors.buy_price.forEach((item, i) => {
          errorMsgs += item+"\n";
        });
        response.errors.sale_price.forEach((item, i) => {
          errorMsgs += item+"\n";
        });
        response.errors.stock.forEach((item, i) => {
          errorMsgs += item+"\n";
        });
        if (response.errors.discount_type) {
          response.errors.discount_type.forEach((item, i) => {
            errorMsgs += item+"\n";
          });
          response.errors.discount_amount.forEach((item, i) => {
            errorMsgs += item+"\n";
          });
        }

        $.notify(errorMsgs, "error");
      });
  }
}


// save product attribute
function saveAttributes(e) {
  e.preventDefault();

  let attribute_key = [];
  let attribute_value = [];

  // push attribute_key
  $.each($('.attribute_key'), function(key, input) {
    attribute_key.push(input.value);
  });

  // push attribute_value
  $.each($('.attribute_value'), function(key, input) {
    attribute_value.push(input.value);
  });

  let formData = {
    'url':e.target.action,
    'processData': true,
    'formData': {'for':'save_attribute', 'has_attribute':$('#has_attribute').val(), 'attribute_key':attribute_key, 'attribute_value':attribute_value}
  };

  $.when(callAjax(formData)).done(function(res) {
    $.notify(res.msg, "success");
  }).fail(function (x, textStatus, errorThrown) {
    $.notify("Somthing wrong with attribute", "error");
  });

}


// save product SEO
function saveSEO(e) {
  e.preventDefault();

  if (true) {
      let formData = {
        'url':e.target.action,
        'processData': true,
        'formData': {
          'for':'save_seo',
          'meta_title':$('#meta_title').val(),
          'meta_keywords':$('#meta_keywords').val(),
          'meta_description':$('#meta_description').val()
        }
      };

      $.when(callAjax(formData)).done(function(res) {
        $.notify(res.msg, "success");
      }).fail(function (x, textStatus, errorThrown) {
        let response = JSON.parse(x.responseText);
        let errorMsgs = "";
        response.errors.meta_title.forEach((item, i) => {
          errorMsgs += item+"\n";
        });
        response.errors.meta_keywords.forEach((item, i) => {
          errorMsgs += item+"\n";
        });
        response.errors.meta_description.forEach((item, i) => {
          errorMsgs += item+"\n";
        });

        $.notify(errorMsgs, "error");
      });
  }
}


// save product Images
function saveImage(e) {

  $.ajax({
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    url: e.action,
    type: "POST",
    data: new FormData(e),
    contentType: false,
    cache: false,
    processData:false,
    success: function(res){
      $.notify(res.msg, "success");
    },
    error: function(xhr, textStatus, errorThrown){
      $.notify("Somthing wrong", "error");
    }
    });
}

// adding more images on product
let imgKey = 0;
function addImage() {
  imgKey++;
  let img = '<div id="img_'+imgKey+'" class="form-group"><div class="" style="width:90%; display:inline-block"><input name="product_images[]" type="file" class="form-control"></div><div class="" style="display:inline-block; margin-left:1rem;"><i onclick="deletImage(\'img_'+imgKey+'\')" class="fas fa-minus-circle img-delete"></i></div></div>';
  $('#product_image_container').append(img);
}

// delete image input from product
function deletImage(id) {
  $('#'+id).remove();
}

// change text of product publish btn on product add page
function productPublishBtnChange(e) {
  if(e.value === 'no')
    $('#is_active_btn').text('Save as Draft');
  else
    $('#is_active_btn').text('Publish Product');
}
