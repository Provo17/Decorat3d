jQuery(function($){$(function(){$('#main-slider').carousel({interval:8000});});$('.centered').each(function(e){$(this).css('margin-top',($('#main-slider').height()-$(this).height())/2);});$(window).resize(function(){$('.centered').each(function(e){$(this).css('margin-top',($('#main-slider').height()-$(this).height())/2);});});$(window).load(function(){$portfolio_selectors=$('.portfolio-filter >li>a');if($portfolio_selectors!='undefined'){$portfolio=$('.portfolio-items');$portfolio.isotope({itemSelector:'li',layoutMode:'fitRows'});$portfolio_selectors.on('click',function(){$portfolio_selectors.removeClass('active');$(this).addClass('active');var selector=$(this).attr('data-filter');$portfolio.isotope({filter:selector});return false;});}});var form=$('.contact-form');form.submit(function(){$this=$(this);$.post($(this).attr('action'),function(data){$this.prev().text(data.message).fadeIn().delay(3000).fadeOut();},'json');return false;});$('.gototop').click(function(event){event.preventDefault();$('html, body').animate({scrollTop:$("body").offset().top},500);});$("a[rel^='prettyPhoto']").prettyPhoto({social_tools:false});});