(function($) {
  "use strict"; // Start of use strict

  // Configure tooltips for collapsed side navigation
  $('.navbar-sidenav [data-toggle="tooltip"]').tooltip({
    template: '<div class="tooltip navbar-sidenav-tooltip" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
  })
  
 
  
  // Toggle the side navigation
  $("#sidenavToggler").click(function(e) {
    e.preventDefault();
    $("body").toggleClass("sidenav-toggled");
    $(".navbar-sidenav .nav-link-collapse").addClass("collapsed");
    $(".navbar-sidenav .sidenav-second-level, .navbar-sidenav .sidenav-third-level").removeClass("show");
    
    /* verifica se o menu vertital está aberto ou fechado para setar o cookie */
    var aberto = $("body").hasClass("sidenav-toggled");
    var set_cookie_name = $("#sidenavToggler").attr('rel');
    /* Ajustar listagem de resistros datatable JS */
   if($("#table").length){
    reload_table();
   }
	if(aberto==true){
        setCookie(set_cookie_name,'sim',365);
    }else{
        eraseCookie(set_cookie_name);
    }  
     
  });

  // Force the toggled class to be removed when a collapsible nav link is clicked
  $(".navbar-sidenav .nav-link-collapse").click(function(e) {
    e.preventDefault();
    $("body").removeClass("sidenav-toggled");
  });

  // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
  $('body.fixed-nav .navbar-sidenav, body.fixed-nav .sidenav-toggler, body.fixed-nav .navbar-collapse').on('mousewheel DOMMouseScroll', function(e) {
    var e0 = e.originalEvent,
      delta = e0.wheelDelta || -e0.detail;
    this.scrollTop += (delta < 0 ? 1 : -1) * 30;
    e.preventDefault();
  });

  // Scroll to top button appear
  $(document).scroll(function() {
    var scrollDistance = $(this).scrollTop();
    if (scrollDistance > 100) {
      $('.scroll-to-top').fadeIn();
    } else {
      $('.scroll-to-top').fadeOut();
    }
  });

  // Configure tooltips globally
  $('[data-toggle="tooltip"]').tooltip()

  // Smooth scrolling using jQuery easing
  $(document).on('click', 'a.scroll-to-top', function(event) {
    var $anchor = $(this);
    $('html, body').stop().animate({
      scrollTop: ($($anchor.attr('href')).offset().top)
    }, 1000, 'easeInOutExpo');
    event.preventDefault();
  });
	
  
  $(".zoom-foto").fancybox({
    padding: 0,

    openEffect : 'elastic',
    openSpeed  : 450,

    closeEffect : 'elastic',
    closeSpeed  : 350,

    closeClick : true,
    helpers : {
        
		thumbs	: {
			width	: 50,
			height	: 50
		},
		media : {},
        overlay : {
            css : {
                'background' : 'rgba(255,255,255,0.6)' 
            }
        }
    }
	
  });	
	
  // Call the dataTables jQuery plugin
  $(document).ready(function() {
	if($("#dataTable").length){
		$('#dataTable').DataTable( {
				"language": {
					"url": "assets/pluguins/datatables/Portuguese-Brasil.json"
				}
		 });
	}
  });
})(jQuery); // End of use strict




 
function setCookie(name,value,exdays){ //função universal para criar cookie    
   
    var expires;
    var date; 
    var value;
    
    date = new Date(); //  criando o COOKIE com a data atual
    date.setTime(date.getTime()+(exdays*24*60*60*1000));
    expires = date.toUTCString();
    
    document.cookie = name+"="+value+"; expires="+expires+"; path=/";
}


function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length,c.length);
        }
    }
    return "";
} 
 

function eraseCookie(name){
    setCookie(name,-1); // deletando o cookie encontrado a partir do mostraCookie
} 