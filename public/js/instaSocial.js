$(document).ready(function(){

  var feed = new Instafeed({
  get: 'tagged',
  tagName:'EmoonaForce',

  accessToken: '4725717949.1677ed0.2c5f92d495e342a4b1a6740d518d3eb6',
  template: '<a class="animation" href="{{link}}"><img src="{{image}}" /></a>',
  sortBy:'most-recent',
  limit:12,


  });
  feed.run();
});