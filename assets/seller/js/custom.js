/*---------------------get Country Data according to their Country Code-----------------------*/
$('#country_code').on('change', function() {
    var country_code = $(this).val();
    
    $("#country").val('');
    $("#state").val('');
    $("#city").val('');
    $("#postalcode").val('');
    $("#zip").val('');
    $("#address").val('');

    if (country_code == '') {
        $("#country").prop("disabled", true);
        $("#state").prop("disabled", true);
        $("#city").prop("disabled", true);
        $("#postalcode").prop("readonly", true);
    } else {

        $.ajax({
            url: SITE_URL + 'backend/common/getCountryData',
            type: 'POST',
            data: {
                country_code: country_code
            },
            cache: false,
            success: function(result) {
                var data = JSON.parse(result);
                if(data.status=='success'){
                    $("#country").val(data.optionData);
                    $.ajax({
                        url: SITE_URL + 'backend/common/getStateData',
                        type: 'POST',
                        data: {
                            country: data.optionData
                        },
                        cache: false,
                        success: function(result) {
                            var data = JSON.parse(result);
                            $('#state').html(data.optionData);
                        },
                    });
                }
            },
        });

        $("#country").prop("disabled", false);
        $("#state").prop("disabled", false);
        $("#city").prop("disabled", true);
        $("#postalcode").prop("readonly", true);
    }

    
});


/*------------------------get Country Data according to their Country Code-------------------------*/
$('.country_code').on('change', function() {
    var country_code = $(this).val();
    
    $("#country").val('');
    $("#state").val('');
    $("#city").val('');
    $("#postalcode").val('');
    $("#zip").val('');
    $("#address").val('');

    if (country_code == '') {
        $("#country").prop("disabled", true);
        $("#state").prop("disabled", true);
        $("#city").prop("disabled", true);
        $("#postalcode").prop("readonly", true);
    } else {

        $.ajax({
            url: SITE_URL + 'backend/common/getCountryData',
            type: 'POST',
            data: {
                country_code: country_code
            },
            cache: false,
            success: function(result) {
                var data = JSON.parse(result);
                if(data.status=='success'){
                    $("#country").val(data.optionData);
                    $.ajax({
                        url: SITE_URL + 'backend/common/getStateData',
                        type: 'POST',
                        data: {
                            country: data.optionData
                        },
                        cache: false,
                        success: function(result) {
                            var data = JSON.parse(result);
                            $('#state').html(data.optionData);
                        },
                    });
                }
            },
        });

        $("#country").prop("disabled", false);
        $("#state").prop("disabled", false);
        $("#city").prop("disabled", true);
        $("#postalcode").prop("readonly", true);
    }

    
});

/*----------------------------get state Data according to their country-----------------------------*/
$('#country').on('change', function() {
    var country = $(this).val();
    $("#state").val('');
    $("#city").val('');
    $("#postalcode").val('');
    $("#zip").val('');
    $("#address").val('');

    if (country == '') {
        $("#state").prop("disabled", true);
        $("#city").prop("disabled", true);
        $("#postalcode").prop("readonly", true);
    } else {

        $.ajax({
            url: SITE_URL + 'backend/common/getStateData',
            type: 'POST',
            data: {
                country: country
            },
            cache: false,
            success: function(result) {
                var data = JSON.parse(result);
                if(data.country_code){
                    $('select[name="country_code"]').val(data.country_code);
                }
                $('#state').html(data.optionData);
            },
        });

        $("#state").prop("disabled", false);
        $("#city").prop("disabled", true);
        $("#postalcode").prop("readonly", true);
    } 
});


/*------------------------get City Data according to their state-----------------------*/
$('#state').on('change', function() {

    var country = $('#country').val();
    var state = $(this).val();
    $("#city").val('');
    $("#postalcode").val('');
    $("#zip").val('');
    $("#address").val('');

    if (state == '') {
        $("#city").prop("disabled", true);
        $("#postalcode").prop("readonly", true);
    } else {
        $("#city").prop("disabled", false);
        $("#postalcode").prop("readonly", true);
    }

    $.ajax({
        url: SITE_URL + 'backend/common/getCityData',
        type: 'POST',
        data: {
            country: country,
            state: state
        },
        cache: false,
        success: function(result) {
            var data = JSON.parse(result);
            $('#city').html(data.optionData);
        },
    });

});


/*get Postal Codes Data according to their City*/
$('#city').on('change', function() {

    var country = $('#country').val();
    var state = $('#state').val();
    var city = $(this).val();
    $("#postalcode").val('');
    $("#zip").val('');
    $("#address").val('');

    if (city == '') {
        $("#postalcode").prop("readonly", true);
    } else {
        $("#postalcode").prop("readonly", false);
    }

});


/*----------------------get Product Quantity----------------------*/
$('body').on('click','.updateQuantity',function() {

    var variationID = $(this).attr('attrId');
    var value = $('#quantity'+variationID).val();
    if($('#quantity'+variationID).is(':disabled')){

        $(this).removeAttr("data-original-title");
        $(this).attr("data-original-title","Click to Update Quantity");

        $.getScript(SITE_URL+"assets/frontend/js/bootstrap.min.js", function() {
            $('.tooltips').tooltip();
        });

        $('#quantity'+variationID).removeAttr("disabled");
        $('#iconQuan'+variationID).removeClass("fa fa-pencil");
        $('#iconQuan'+variationID).addClass("fa fa-undo");
        return false;
    }

    if(variationID!='' && value!='' && value!='0'){

        $.ajax({
            url: SITE_URL + 'backend/common/updateQuantity',
            type: 'POST',
            data: {
                variationID: variationID,
                value: value
            },
            cache: false,
            success: function(result) {
                var data = JSON.parse(result);
                if(data.status=='success'){
                    //$('html, body').animate({scrollTop: '0px'}, 0);
                    successMsg(data.msg);
                }else{
                    //$('html, body').animate({scrollTop: '0px'}, 0);
                    errorMsg(data.msg);
                }
            },
        });

    }else{

    }

});

/*----------------------get Product Sellprice-----------------------*/
$('body').on('click','.updateSellPrice',function() {

    var variationID = $(this).attr('attrId');
    var base_price = parseFloat($('#base_price'+variationID).val());
    var value = parseFloat($('#sellprice'+variationID).val());

    if($('#sellprice'+variationID).is(':disabled')){

        $(this).removeAttr("data-original-title");
        $(this).attr("data-original-title","Click to Update Retail Price(MRP)");

        $.getScript(SITE_URL+"assets/frontend/js/bootstrap.min.js", function() {
            $('.tooltips').tooltip();
        });

        $('#sellprice'+variationID).removeAttr("disabled");
        $('#iconSellPrice'+variationID).removeClass("fa fa-pencil");
        $('#iconSellPrice'+variationID).addClass("fa fa-undo");
        return false;

    }else{

        if(value > base_price){
            if(variationID!='' && value!='' && value!='0'){
                $.ajax({
                    url: SITE_URL + 'backend/common/updateSellPrice',
                    type: 'POST',
                    data: {
                        variationID: variationID,
                        value: value
                    },
                    cache: false,
                    success: function(result) {
                        var data = JSON.parse(result);
                        if(data.status=='success'){
                            successMsg(data.msg);
                        }else{
                            errorMsg(data.msg);
                        }
                    },
                });
            }
        }else{
            errorMsg("The Retail Price(MRP) always should be greater than sell price.");
            return false;
        }
    }

});

/*------------------get Product Sellprice---------------------*/
$('body').on('click','.updateBasePrice',function() {

    var variationID = $(this).attr('attrId');
    var value = parseFloat($('#base_price'+variationID).val());
    var sellprice = parseFloat($('#sellprice'+variationID).val());


    if($('#base_price'+variationID).is(':disabled')){

        $(this).removeAttr("data-original-title");
        $(this).attr("data-original-title","Click to Update Sell Price");

        $.getScript(SITE_URL+"assets/frontend/js/bootstrap.min.js", function() {
            $('.tooltips').tooltip();
        });

        $('#base_price'+variationID).removeAttr("disabled");
        $('#iconBasePrice'+variationID).removeClass("fa fa-pencil");
        $('#iconBasePrice'+variationID).addClass("fa fa-undo");
        return false;

    }else{

        if(value < sellprice){

            if(variationID!='' && value!='' && value!='0'){
                $.ajax({
                    url: SITE_URL + 'backend/common/updateBasePrice',
                    type: 'POST',
                    data: {
                        variationID: variationID,
                        value: value
                    },
                    cache: false,
                    success: function(result) {
                        var data = JSON.parse(result);
                        if(data.status=='success'){
                            successMsg(data.msg);
                        }else{
                            errorMsg(data.msg);
                        }
                    },
                });
            }
        }else{
            errorMsg("The sell price always should be smaller than Retail Price(MRP).");
            return false;
        }
    }
});


/*-----------------Product Adding on wishlist------------------*/
$('body').on('click', '.addToWishlist', function() {
    user_id = CUSTOMER_ID;
    if(!user_id) window.location.replace(SITE_URL + "page/login");
    
    var curr = $(this);
    var PID = curr.attr('pID');
    if (PID!= ''){
        $.ajax({
             type: 'POST',
             url: SITE_URL + 'order/add_to_wishlist_using_ajax',
             data: {
                product_variation_id : PID
             },
             success: function(result) {
                 var data = jQuery.parseJSON(result);
                 if (data.status=='success'){
                     $('[data-toggle="tooltip"]').tooltip('hide');
                     $('.tooltip').remove();
                     curr.parent().closest('div').attr('data-original-title', 'Remove from Wishlist');
                     curr.removeClass('addToWishlist').addClass('removeFromWishlist');
                     curr.attr('src', SITE_URL+'assets/frontend/img/icons/heart-full.svg');
                     successMsg(data.msg);
                 } else {
                     errorMsg(data.msg);
                     return false;
                 }
             }
        });
    }else{
        errorMsg('Something went wrong! Please try again');
        return false;
    }
});


/*--------------Product Remove on wishlist-------------*/
$('body').on('click','.removeFromWishlist',function() {
    user_id = CUSTOMER_ID;
    if(!user_id) window.location.replace(SITE_URL + "page/login");

    var curr = $(this);
    var PID = curr.attr('pID');
    if (PID != '') {
        $.ajax({
             type: 'POST',
             url: SITE_URL + 'order/remove_from_wishlist_using_ajax',
             data: {
                product_variation_id : PID
             },
             success: function(result) {
                 var data = jQuery.parseJSON(result);
                 if (data.status=='success'){
                     $('[data-toggle="tooltip"]').tooltip('hide');
                     $('.tooltip').remove();
                     curr.parent().closest('div').attr('data-original-title', 'Add to Wishlist');
                     curr.removeClass('removeFromWishlist').addClass('addToWishlist');
                     curr.attr('src', SITE_URL+'assets/frontend/img/icons/heart-empty.svg');
                     successMsg(data.msg);
                 } else {
                     errorMsg(data.msg);
                     return false;
                 }
             }
        });
    } else {
        errorMsg('Something went wrong! Please try again');
        return false;
    }
});


/*-----------------Notify Message function------------------*/

function successMsg(msg){ 
    $('.custom-alert-msg-wrap').remove();
    $('.notifyjs-corner').empty();
    /*$.notify("<?php //echo $CI->session->flashdata('msg_success'); ?>", "success");*/

    $.notify({
        icon: SITE_URL + "assets/backend/image/alert-icons/alert-checked.svg",
        title: "<strong>Success</strong> ",
        message: msg          
    },{
        icon_type: 'image',
        type: 'success',
        allow_duplicates: false
    });
}


function infoMsg(msg){
    $('.custom-alert-msg-wrap').remove();
    $('.notifyjs-corner').empty();
    /*$.notify("<?php //echo $CI->session->flashdata('msg_info'); ?>", "info");*/

    $.notify({
        icon: SITE_URL + "assets/backend/image/alert-icons/alert-checked.svg",
        title: "<strong>Info</strong> ",
        message: msg          
    },{
        icon_type: 'image',
        type: 'success',
        allow_duplicates: false
    });
}


function warningMsg(msg){
    $('.custom-alert-msg-wrap').remove();
    $('.notifyjs-corner').empty();
    /*$.notify("<?php //echo $CI->session->flashdata('msg_warning'); ?>", "warn");*/

    $.notify({
        icon: SITE_URL + "assets/backend/image/alert-icons/alert-danger.svg",
        title: "<strong>Warning</strong> ",
        message: msg

    },{
        icon_type: 'image',
        type: 'warning',
        allow_duplicates: false
    });
}


function errorMsg(msg){
    $('.custom-alert-msg-wrap').remove();
    $('.notifyjs-corner').empty();  
    $.notify({
        icon: SITE_URL + "assets/backend/image/alert-icons/alert-disabled.svg",
        title: "<strong>Error</strong> ",
        message: msg
    },{
        icon_type: 'image',
        type: 'danger',
        allow_duplicates: false
    });
}

function errMsg(msg){
    $('.custom-alert-msg-wrap').remove();
    $('.notifyjs-corner').empty();  
    $.notify({
        icon: SITE_URL + "assets/backend/image/alert-icons/alert-disabled.svg",
        title: "<strong>Error</strong> ",
        message: msg
    },{
        icon_type: 'image',
        type: 'danger',
        allow_duplicates: false
    });
}


/*Call function for autoscrolling when the window size is less than 1050*/

function windowSizeAutoScroll(){ 
    if($(window).width() <= 1050){
        $('html, body').animate({
              scrollTop: $(".product_attribute").offset().top - 70
        }, 1000); 
        return false;
    }
}