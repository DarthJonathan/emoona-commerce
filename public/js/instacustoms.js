$(document).ready(function(){

var userFeed = new Instafeed({
  get: 'user',
  userId: '4725717949',
  accessToken: '4725717949.1677ed0.2c5f92d495e342a4b1a6740d518d3eb6',
  template: '<a class="animation" href="{{link}}"><img src="{{image}}" /></a>',
  sortBy:'most-recent',
  after:function(){
  	$('.instagram-feed-box').slick({
  		slidesToShow:8,
  		autoplay: true,
  		autoplaySpeed: 2000,
  		arrows:false,
  	
  		responsive: [
    {
      	breakpoint: 800,
      	settings: {
        slidesToShow: 5,
      }

    },

    {
    	breakpoint:1030,
    	settings:{
    	slidesToShow:6,
    	}
    },

    ]

  	});
  }

});

userFeed.run();

});

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

