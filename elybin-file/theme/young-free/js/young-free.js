
/*!
 * Young Free v1.0.0 (http://elybin.com)
 * Copyright 2014 Start Bootstrap
 * Licensed under Apache 2.0 (https://github.com/IronSummitMedia/startbootstrap/blob/gh-pages/LICENSE)
 */
$(".container").hide();
$(".loading-screen").show();
$(window).bind("load",function(){
  $(".loading-screen").fadeOut();
  $(".container").fadeIn(1000);
});
// Contact
$(function() {
	$("#contact-form form .btn").click(function(){
		// get all value
		var name = $("#contact-form #name").val();
		var email = $("#contact-form #email").val();
		var message = $("#contact-form #message").val();
		var code = $("#contact-form #code").val();
		
		if(name==''|| email=='' || message=='' || code==''){
			$("#error").slideDown();
			$("#error p").html($("#pleasefill").text());
			$("#contact-form, #contact-title").slideUp();
		}else{
		
			$("#loading").fadeIn();
			$.ajax({
			  url: $("#contact-form form").attr('action'),
			  type: 'POST',
			  data: 'name=' + name + '&email=' + email + '&message=' + message + '&code=' + code,
			  success: function(data) {
			  	console.log(data);
			  	var data = $.parseJSON(data);
			  	// check first success nor
			  	if(data.status == "ok"){
					$("#success").slideDown();
					$("#success p").html(data.isi);
					$("#contact-form, #contact-title").slideUp();
					

					$("#loading").fadeOut();	
			  	}
			  	else if(data.status == "error"){
					$("#error p").html(data.isi);
			  		$("#error").slideDown();
					$("#contact-form, #contact-title").slideUp();
					$("#loading").fadeOut();
			  	}
				
			  },
			  error: function(data) {
				$("#error").slideDown();
				$("#contact-form, #contact-title").slideUp();
				
				$("#loading").fadeOut();
			  }
			});
		}
		return false;
	});
	
	$("#error .close").click(function(){
		$("#error").slideUp();
		$("#contact-form, #contact-title").slideDown();
	});
});

// Comments
$(function() {
	$('#comment-post').submit(function(e){
		$("#comment-form #loading").fadeIn();
	    $.ajax({
	      url: $(this).attr('action'),
	      type: 'POST',
	      data: new FormData(this),
	      processData: false,
	      contentType: false,
	      success: function(data) {
				console.log(data);
			  	var data = $.parseJSON(data);
			  	// check first success nor
			  	if(data.status == "ok"){
					$("#comment-form #success").slideDown();
					$("#comment-form #success h4 span").html(data.isi);
					$("#comment-post, #comment-title").slideUp();
					

					$("#comment-form #loading").fadeOut();	

					$("#comment-dummy div p strong").html(data.fullname);
					$("#comment-dummy div p span").html(data.message);
					if(data.avatar == "default/no-ava.png"){
						$("#comment-dummy div img").attr('src', 'elybin-file/avatar/default/medium-no-ava.png');
					}else{
						$("#comment-dummy div img").attr('src', 'elybin-file/avatar/' + data.avatar);
					}
					$("#comment-dummy").slideDown();
			  	}
			  	else if(data.status == "error"){
					$("#comment-form #error h4 span").html(data.isi);
			  		$("#comment-form #error").slideDown();
					$("#comment-post, #comment-title").slideUp();
					$("#comment-form #loading").fadeOut();
			  	}
		   },
		 error: function(data) {
				$("#comment-form #error").slideDown();
				$("#comment-post, #comment-title").slideUp();
				
				$("#comment-form #loading").fadeOut();
		 }
	    });
	    e.preventDefault();
	    return false;
  	});
	
	$("#comment-form #error .close").click(function(){
		$("#comment-form #error").slideUp();
		$("#comment-post, #comment-title").slideDown();
		
		return false;
	});
});
 
// Floating label headings for the contact form
$(function() {
    $("body").on("input propertychange", ".floating-label-form-group", function(e) {
        $(this).toggleClass("floating-label-form-group-with-value", !!$(e.target).val());
    }).on("focus", ".floating-label-form-group", function() {
        $(this).addClass("floating-label-form-group-with-focus");
    }).on("blur", ".floating-label-form-group", function() {
        $(this).removeClass("floating-label-form-group-with-focus");
    });
});



// Search Bar 
$(function() {
	$("#search-toggle, #search-toggle2").click(function(){
		//$(this).hide();
		$("#search").addClass('search-active');
	});
	
	$("#search-close").click(function(){
		//$/("#search-toggle").show();
		$("#search").removeClass('search-active');
	});
});

// Navigation Scripts to Show Header on Scroll-Up
jQuery(document).ready(function($) {
    var MQL = 1170;
	
    //primary navigation slide-in effect
    if ($(window).width() > MQL) {
        var headerHeight = $('.navbar-custom').height();
        $(window).on('scroll', {
                previousTop: 0
            },
            function() {
                var currentTop = $(window).scrollTop();
                //check if user is scrolling up
                if (currentTop < this.previousTop) {
                    //if scrolling up...
                    if (currentTop > 0 && $('.navbar-custom').hasClass('is-fixed')) {
                        $('.navbar-custom').addClass('is-visible');
						//$('.dropdown-menu').fadeIn();
						$('.dropdown-menu').css("margin-top","0px");
                    } else {
                        $('.navbar-custom').removeClass('is-visible is-fixed');
                    }
                } else {
                    //if scrolling down...
                    $('.navbar-custom').removeClass('is-visible');
					$('.dropdown-menu').css("margin-top","-400px");
					
                    if (currentTop > headerHeight && !$('.navbar-custom').hasClass('is-fixed')) $('.navbar-custom').addClass('is-fixed');
                }
                this.previousTop = currentTop;
            });
    }
});
$(function() {
	parallax();
	function parallax(){
		if (navigator.appVersion.indexOf("Win") >= 0) {
			if (navigator.userAgent.indexOf("Chrome") >= 0) {
				// Load SmoothScroll
				(function() {
					var sstag = document.createElement('script'); sstag.type = 'text/javascript'; sstag.async = true;
					sstag.src = 'http://cdn.inst.ag/assets/scripts/SmoothScroll.js';
					var s = document.getElementsByTagName('script')[0];
					s.parentNode.insertBefore(sstag, s);
				})();
			}
		}
	  var scrolled = $(window).scrollTop(); 
	  if(scrolled < $(".intro-header").height() && scrolled > 0){
		$(".intro-header").css("background-position", "0% " + (50-(scrolled * 0.40)) + "%");
	  
		//$(".intro-header").css("margin-bottom", "-" + (scrolled*2) + "px");
		//$(".intro-header h1, .intro-header span, .intro-header hr").css("opacity", (1-(scrolled/$(".intro-header").height() * 1.7)) + "");
	  }
	}
	
	$(window).scroll(function(e){
		parallax();
	});
});