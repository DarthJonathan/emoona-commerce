$(document).ready(function(){

  $('.bgpicHome').slick({
   
      slidesToShow:1,
      autoplay: true,
      autoplaySpeed: 2500,
      arrows:false,
    
  });
  
   $('.product-main-pic').slick({
  slidesToShow: 1,
  arrows: false,
  fade: true,
  asNavFor: '.product-secondary-pic'
  });

  $('.product-secondary-pic').slick({
  slidesToShow: 4,
  asNavFor: '.product-main-pic',
  arrows: false,
  focusOnSelect: true,
 
  });
  

});

$(document).ready(function(){

  var isWoman =false;
  var isMen =false;
  var isOthers =false;
  var isSale =false;
  

    $('#womanDropDown').click(function(){
      isWoman = true;
      checkProducts(this);
      $('#wdropdowns').animate({opacity:'1'});
      $('#wdropdowns').css('display','block');
      $('#mdropdowns').css('display','none');
      $('#odropdowns').css('display','none');

   });

    $('#menDropDown').click(function(){
      isMen = true;
      checkProducts(this);
       $('#mdropdowns').animate({opacity:'1'});
       $('#mdropdowns').css('display','block');
       $('#wdropdowns').css('display','none');
       $('#odropdowns').css('display','none');
    
   });

    $('#othersDropDown').click(function(){
      isOthers = true;
      checkProducts(this);
       $('#odropdowns').animate({opacity:'1'});
       $('#odropdowns').css('display','block');
       $('#wdropdowns').css('display','none');
       $('#mdropdowns').css('display','none');
    
   });

    $('#saleDropDown').click(function(){
      isSale = true;

       $('#odropdowns').css('display','none');
       $('#wdropdowns').css('display','none');
       $('#mdropdowns').css('display','none');
    
   });


});



