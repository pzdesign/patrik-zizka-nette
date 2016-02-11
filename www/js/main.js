// WOW.js //

new WOW().init();

jQuery(function ($) {
  var $active = $('#accordion .panel-collapse.in').prev().addClass('active');
  $active.find('a').append('<span class="glyphicon glyphicon-minus pull-right"></span>');
  $('#accordion .panel-heading').not($active).find('a').prepend('<span class="glyphicon glyphicon-plus pull-right"></span>');
  $('#accordion').on('show.bs.collapse', function (e)
  {
    $('#accordion .panel-heading.active').removeClass('active').find('.glyphicon').toggleClass('glyphicon-plus glyphicon-minus');
    $(e.target).prev().addClass('active').find('.glyphicon').toggleClass('glyphicon-plus glyphicon-minus');
  });
  $('#accordion').on('hide.bs.collapse', function (e)
  {
    $(e.target).prev().removeClass('active').find('.glyphicon').removeClass('glyphicon-minus').addClass('glyphicon-plus');
  });
});

// history push //
function main() {  
  // URL will change to /plate/uvod
  history.pushState( { 
    plate_id: 1, 
  }, null, "#uvod.html");

}

// history push //
function whyme() {  
  // URL will change to /plate/uvod
  history.pushState( { 
    plate_id: 0, 
  }, null, "#whyme.html");

}

function pricing() {  
  // URL will change to /plate/pricing
  history.pushState( { 
    plate_id: 2, 
  }, null, "#pricing.html");
}

function gallery() {  
  // URL will change to /plate/gallery
  history.pushState( { 
    plate_id: 3, 
  }, null, "#gallery.html");

}

function contact() {  
  // URL will change to /plate/contact
  history.pushState( { 
    plate_id: 4, 
  }, null, "#contact.html");
}

function funkcni() {  
  // URL will change to /plate/contact
  history.pushState( { 
    plate_id: 5, 
  }, null, "#function.html");
}

function technologie() {  
  // URL will change to /plate/contact
  history.pushState( { 
    plate_id: 6, 
  }, null, "#technology.html");
}

function podpora() {  
  // URL will change to /plate/contact
  history.pushState( { 
    plate_id: 7, 
  }, null, "#help.html");
}

function zkusenosti() {  
  // URL will change to /plate/contact
  history.pushState( { 
    plate_id: 8, 
  }, null, "#experience.html");
}


window.onpopstate = function (event) {  
  var content = "";
  if(event.state) {
    content = event.state.plate;
  }
}




