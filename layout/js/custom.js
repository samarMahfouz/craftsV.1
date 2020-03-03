/*global $, alert, console*/
$(function () {
  'use strict';
  // header
  $('header').height($(window).height() - $('nav').height());
  // adjust list item center
  $('header section').css('paddingTop', ($(window).height()-$('header section').height()) / 2);
  $('.logg').click(function () {
  $('.login').addClass('hidden');
  $('.signup').removeClass('hidden');
});
$('.signn').click(function () {
  $('.login').removeClass('hidden');
  $('.signup').addClass('hidden');
});
  // adjust shuffle links
  $('.links li').click(function () {
    $(this).addClass('select').siblings().removeClass('select');
  });
  $('.link li').click(function () {
    $(this).addClass('selected').siblings().removeClass('selected');
  });
  // smooth scroll to div
  $('a').click(function () {
    $('html, body').animate({
      scrollTop: $('#' + $(this).data('value')).offset().top
    }, 1500);
  });

  // testimonials slider
  $(".slider section:first-of-type").addClass("active");

  (function autoslider() {
    $('.slider .active').each(function () {
      if(!$(this).is(':last-child')) {
        $(this).delay(2000).fadeOut(1000, function () {
          $(this).removeClass('active').next().addClass('active').fadeIn();
          autoslider()
        });
      }else{
        $(this).delay(2000).fadeOut(1000, function () {
          $(this).removeClass('active');
          $('.slider section').eq(0).addClass('active').fadeIn();
          autoslider();
        });
      }
    });
  }());
  // Trigger mixitup
   window.mixitup('#gallery');
});
