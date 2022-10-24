$(document).ready(function() {
    $('.dropdown-trigger').dropdown({
        inDuration: 300,
        outDuration: 225,
        constrainWidth: false, // Does not change width of dropdown to that of the activator
        hover: false, // Activate on hover
        gutter: 0, // Spacing from edge
        coverTrigger: false, // Displays dropdown below the button
        alignment: 'left', // Displays dropdown with edge aligned to the left of button
        stopPropagation: false // Stops event propagation
    });
    $('.message-center-dropdown-trigger').dropdown({
        inDuration: 300,
        outDuration: 225,
        constrainWidth: false, // Does not change width of dropdown to that of the activator
        hover: true, // Activate on hover
        gutter: 0, // Spacing from edge
        coverTrigger: false, // Displays dropdown below the button
        alignment: 'left', // Displays dropdown with edge aligned to the left of button
        stopPropagation: false // Stops event propagation
    });    
    $('.shop-categories-wrap li, .products-category-block li').hover(
        function() {
            $(this).addClass("current");
        }, function() {
            $(this).removeClass("current");
        }
    );

    $(".select2").select2({
        dropdownAutoWidth: true,
        width: '100%'
    });

    $(".tooltipped").tooltip();

    $('.slider').slider({
        'indicators':false
    });

    $(".mobile-search-btn").click(function(){
        $(".mobile-module-search").slideToggle();
    });

    $(".modal").modal();
    // this will hide the color-size modal from order details modal
    $(".hide-color-size-modal-trigger").click(function(){
        $(this).closest("#colorSizeModal").modal("close");
    });

    $(".product-more-details").click(function(){
        $(window).resize();
    });
    //$("#modal3").modal("open");
    //$("#modal3").modal("close");

    $('.tabs').tabs();
    $('.document_tabs').tabs();
    
    $('.spotlight_tabs').tabs({
        "swipeable": true
    });
    

    // var slider = document.getElementById('price-slider');
    // noUiSlider.create(slider, {
    //     start: [0, 100],
    //     connect: true,
    //     step: 1,
    //     orientation: 'horizontal', // 'horizontal' or 'vertical'
    //     range: {
    //         'min': 0,
    //         'max': 100
    //     },
    //     behaviour: 'tap-drag',
    //     tooltips: true,
    //     format: wNumb({
    //         decimals: 0
    //     })
    // });

    // Product grid and list toggle start
    $(".grid-list-filter .btn").click(function(){
        if($(this).hasClass("active")) {
            $(this).addClass("active");
            //alert("I am here 1");
        } else {
            $(this).parent().children().removeClass("active");
            $(this).addClass("active");

            if($(this).closest(".show-product-results-wrapper").next().children('.row').hasClass("active_grid")) {
                $(this).closest(".show-product-results-wrapper").next().children('.row').removeClass("active_grid");
                $(this).closest(".show-product-results-wrapper").next().children('.row').addClass("active_list");
                $(this).closest(".show-product-results-wrapper").next().children('.row').children().each(function(){
                    //console.log($(this).length);
                    replaceClass($(this), "col s12 m4 l4", "col s12 m12 l12");
                })
            } else {
                $(this).closest(".show-product-results-wrapper").next().children('.row').removeClass("active_list");
                $(this).closest(".show-product-results-wrapper").next().children('.row').addClass("active_grid");
                $(this).closest(".show-product-results-wrapper").next().children('.row').children().each(function(){
                    //console.log($(this).length);
                    replaceClass($(this), "col s12 m12 l12", "col s12 m4 l4");
                })
            }
        }
    });
    function replaceClass(attrClassName, oldClass, newClass) {
        var elem = attrClassName;
        if (elem.hasClass(oldClass)) {
            elem.removeClass(oldClass);
        }
        elem.addClass(newClass);
    }

    $('#image').change(function(){
        let reader = new FileReader();
        reader.onload = (e) => {
            $('#preview-image-before-upload').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });

    $('#seller_edit_images').change(function(){
        let reader = new FileReader();
        reader.onload = (e) => {
            $('#edit_preview-image-before-upload').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });

    $(document).on("click", ".btn-upload-product" , function() {
        $(this).closest('#products').children('.product-list-block').hide();
        $(this).closest('#products').children('.product-add-block').show();
    });

    $(document).on("click", ".btn-back-to-product-list" , function() {
        $(this).closest('#products').children('.product-list-block').show();
        $(this).closest('#products').children('.product-add-block').hide();
        $(this).closest('#products').children('.product-edit-block').hide();
    });

    $(document).on("click", ".addImage" , function() {
        var div = $(".clone").html();
        $(".increment").after(div);
    });
    $(document).on("click",".removeImage",function(){
        $(this).parents(".remove-div").remove();
    });

    $('#images').change(function(){
        $('.image-preview').show();
        let reader = new FileReader();
        reader.onload = (e) => {
          $('#preview-image-before-upload').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });

    // $(document).on("click", ".add_to_cart" , function() {
    //     var sku = $("input[name='sku']").val();
    //     var url = '{{ route("add.cart") }}';
    //     $.ajax({
    //         type:'GET',
    //         url: url,
    //         dataType:'json',
    //         data:{ sku :sku },
    //         success: function(data){
    //             console.log('hi');
    //             alert("added to cart");

    //         }
    //     });

    // });

    $(".cart-btn").click(function(event){
        event.stopPropagation;
        $("#cart-dropdown").fadeToggle("fast");
    });
    $("#cart-dropdown").on("click", function(event){
        event.stopPropagation;
    });

    $(".notification-btn").click(function(event){
        event.stopPropagation;
        $(".notification-list").fadeToggle("fast");
    });
    $(".notification-list").on("click", function(event){
        event.stopPropagation;
    });

    $(".card-alert .close").click(function(){$(this).closest(".card-alert").fadeOut("slow")});

    $(".custommaize_order_trigger").click(function(){
        $(this).closest(".ready_stock_config_block").children("#color-size-block").toggle("slow");
    });
    $(".mixedcontent_order_trigger").click(function(){
        $(this).closest(".ready_stock_config_block").children("#color-size-block").hide("slow");
    })

    $(".edit_store_block_trigger").click(function(){
        $(".location-details-block").find(".form-control").removeAttr('disabled');
        $(".location-details-block").find(".select2").removeAttr('disabled');
    });
    $(".cancel_store_information_trigger").click(function(){
        $(".location-details-block").find(".form-control").attr('disabled', true);
        $(".location-details-block").find(".select2").attr('disabled', true);
    });



    $(".upload-photo-btn-trigger").click(function(){
        $(this).next("#images").click();
    });
    $(".edit-upload-photo-btn-trigger").click(function(){
        $(this).next("#seller_edit_images").click();
    });

    $(".show_attr_trigger").click(function(){
        $('#attr-block').toggle("slow");
    });
    // $('.product-datatable').DataTable({
    //     pageLength: 10
    // });

    $(".view-more-color-trigger").click(function(){
        $(this).hide();
        $(this).closest(".module-color-filter").children(".view-less-color-trigger").show('slow');
        $(this).closest(".module-color-filter").children('.color-item:nth-child(n+6)').show('slow');
    });
    $(".view-less-color-trigger").click(function(){
        $(this).hide();
        $(this).closest(".module-color-filter").children(".view-more-color-trigger").show('slow');
        $(this).closest(".module-color-filter").children('.color-item:nth-child(n+6)').hide('slow');
    });

    $(".view-more-size-trigger").click(function(){
        $(this).hide();
        $(this).closest(".module-size-filter").children(".view-less-size-trigger").show('slow');
        $(this).closest(".module-size-filter").children('.size-item:nth-child(n+6)').show('slow');
    });
    $(".view-less-size-trigger").click(function(){
        $(this).hide();
        $(this).closest(".module-size-filter").children(".view-more-size-trigger").show('slow');
        $(this).closest(".module-size-filter").children('.size-item:nth-child(n+6)').hide('slow');
    });
    jQuery('#overall-star-rating').raty({
		number      : 5,
		scoreName   : 'overall_rating',
		halfShow    : false,
		half        : false,
		hints       : [1,2,3,4,5],
		starOff     : 'https://cdnjs.cloudflare.com/ajax/libs/raty/3.0.0/images/star-off.png',
		starHalf    : 'https://cdnjs.cloudflare.com/ajax/libs/raty/3.0.0/images/star-half.png',
		starOn      : 'https://cdnjs.cloudflare.com/ajax/libs/raty/3.0.0/images/star-on.png'
    });
    jQuery('#communication-star-rating').raty({
		number      : 5,
		scoreName   : 'communication_rating',
		halfShow    : false,
		half        : false,
		hints       : [1,2,3,4,5],
		starOff     : 'https://cdnjs.cloudflare.com/ajax/libs/raty/3.0.0/images/star-off.png',
		starHalf    : 'https://cdnjs.cloudflare.com/ajax/libs/raty/3.0.0/images/star-half.png',
		starOn      : 'https://cdnjs.cloudflare.com/ajax/libs/raty/3.0.0/images/star-on.png'
    });
    jQuery('#ontimedelivery-star-rating').raty({
		number      : 5,
		scoreName   : 'ontime_delivery_rating',
		halfShow    : false,
		half        : false,
		hints       : [1,2,3,4,5],
		starOff     : 'https://cdnjs.cloudflare.com/ajax/libs/raty/3.0.0/images/star-off.png',
		starHalf    : 'https://cdnjs.cloudflare.com/ajax/libs/raty/3.0.0/images/star-half.png',
		starOn      : 'https://cdnjs.cloudflare.com/ajax/libs/raty/3.0.0/images/star-on.png'
    });
    jQuery('#samplesupport-star-rating').raty({
		number      : 5,
		scoreName   : 'sample_support_rating',
		halfShow    : false,
		half        : false,
		hints       : [1,2,3,4,5],
		starOff     : 'https://cdnjs.cloudflare.com/ajax/libs/raty/3.0.0/images/star-off.png',
		starHalf    : 'https://cdnjs.cloudflare.com/ajax/libs/raty/3.0.0/images/star-half.png',
		starOn      : 'https://cdnjs.cloudflare.com/ajax/libs/raty/3.0.0/images/star-on.png'
    });
    jQuery('#productquality-star-rating').raty({
		number      : 5,
		scoreName   : 'product_quality_rating',
		halfShow    : false,
		half        : false,
		hints       : [1,2,3,4,5],
		starOff     : 'https://cdnjs.cloudflare.com/ajax/libs/raty/3.0.0/images/star-off.png',
		starHalf    : 'https://cdnjs.cloudflare.com/ajax/libs/raty/3.0.0/images/star-half.png',
		starOn      : 'https://cdnjs.cloudflare.com/ajax/libs/raty/3.0.0/images/star-on.png'
    });

    jQuery('.star-rating').raty({
        readOnly    :  true,
        half        :  true,
		starOff     : 'https://cdnjs.cloudflare.com/ajax/libs/raty/3.0.0/images/star-off.png',
		starHalf    : 'https://cdnjs.cloudflare.com/ajax/libs/raty/3.0.0/images/star-half.png',
		starOn      : 'https://cdnjs.cloudflare.com/ajax/libs/raty/3.0.0/images/star-on.png'
    });

});






//fresh order color metrics
function addFreshOrderColorSize()
{
    var html = '<tr class="tr">';
    html += '<td data-title="Color"><input class="combat" type="text" value="" name="color"/></td>';
    html += '<td data-title="XXS"><input class="combat" type="text" value="" name="xxs" /></td>';
    html += '<td data-title="XS"><input class="combat" type="text" value="" name="xs" /></td>';
    html += '<td data-title="Small"><input class="combat" type="text" value="" name="small" /></td>';
    html += '<td data-title="Medium"><input class="combat" type="text" value="" name="medium" /></td>';
    html += '<td data-title="Large"><input class="combat" type="text" value="" name="large" /></td>';
    html += '<td data-title="Extra Large"><input class="combat" type="text" value="" name="extra_large" /></td>';
    html += '<td data-title="XXL"><input class="combat" type="text" value="" name="xxl" /></td>';
    html += '<td data-title="XXXL"><input class="combat" type="text" value="" name="xxxl" /></td>';
    html += '<td data-title="4XXL"><input class="combat" type="text" value="" name="four_xxl" /></td>';
    html += '<td data-title="One Color"><input class="combat" type="text" value="" name="one_size" /></td>';
    html += '<td><a href="javascript:void(0);" class="btn_delete" onclick="removeFreshOrderColorSize(this)"><i class="material-icons dp48">delete_outline</i> <span>Delete</span></a></td>';
    html += '</tr>';
    $('#fresh_order_customize_block tbody').append(html);
}
function removeFreshOrderColorSize(el)
{
$(el).parent().parent().remove();
}


$("#resend-email-validtion").click(function(){
    $("#resend-email-verification-form").toggle('slow');
  });



  // slick slider
  $('.related_products_slider').slick({
    dots: false,
    infinite: false,
    speed: 300,
    slidesToShow: 4,
    slidesToScroll: 1,
    autoplay: false,
    autoplaySpeed: 1000,

    responsive: [
      {
        breakpoint: 1200,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1,
          infinite: true,
          dots: false
        }
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  });
