jQuery(document).ready(function($) {
    'use strict';

    // Initialize Slick Slider
    $(".Modern-Slider").slick({
        autoplay: true,
        speed: 1000,
        slidesToShow: 1,
        slidesToScroll: 1,
        pauseOnHover: false,
        dots: true,
        fade: true,
        pauseOnDotsHover: true,
        cssEase: 'linear',
        draggable: false,
        prevArrow: '<button class="PrevArrow"></button>',
        nextArrow: '<button class="NextArrow"></button>', 
    });

    // Toggle Navigation Menu
    $('#nav-toggle').on('click', function (event) {
        event.preventDefault();
        $('#main-nav').toggleClass("open");
    });

    // Tabs Functionality
    $('.tabgroup > div').hide();
    $('.tabgroup > div:first-of-type').show();
    $('.button-faculty-btn').click(function() {
        var $this = $(this);
        var tabId = $this.data('tab');
        
        $('.button-faculty-btn').removeClass('active');
        $this.addClass('active');
        
        $('.tab-content').hide();
        $('#' + tabId).show();
    });

    // Autoplay YouTube Videos
    $(".box-video").click(function(){
        $('iframe', this)[0].src += "&amp;autoplay=1";
        $(this).addClass('open');
    });

    // Owl Carousel Initialization
    $('.owl-carousel').owlCarousel({
        loop: true,
        margin: 30,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: true
            },
            600: {
                items: 2,
                nav: false
            },
            1000: {
                items: 3,
                nav: true,
                loop: false
            }
        }
    });var scrollTimeout;

$(window).on('scroll', function() {
    clearTimeout(scrollTimeout);  // Clear the previous timeout
    scrollTimeout = setTimeout(function() {
        // Your scroll event logic goes here
        console.log("Scrolled");
    }, 100);  // Adjust the delay as needed
});


    var contentSection = $('.content-section');
    var navigation = $('nav');
    
    // Hide all sections initially
    contentSection.hide().removeClass('active-section');
    
    // Show announcement section by default
    $('#announcement').show().addClass('active-section');
    $('nav a[href="#announcement"], #mobileNavbar a[href="#announcement"]').addClass('active-section');

    // When a nav link is clicked
    $('nav a, #mobileNavbar a').on('click', function(event) {
        event.preventDefault();
        
        // Get the target section
        var target = $($(this).attr('href'));
        
        // Remove active class from all nav items
        $('nav a, #mobileNavbar a').removeClass('active-section');
        // Add active class to clicked nav item
        $(this).addClass('active-section');
        
        // Hide all sections
        contentSection.hide().removeClass('active-section');
        // Show target section
        target.show().addClass('active-section');
        
        // Close mobile menu if open
        $('#main-nav').removeClass("open");
    });

    // Update navigation based on hash change
    $(window).on('hashchange', function() {
        var hash = window.location.hash;
        if (hash) {
            var target = $(hash);
            if (target.length) {
                contentSection.hide().removeClass('active-section');
                target.show().addClass('active-section');
                
                $('nav a, #mobileNavbar a').removeClass('active-section');
                $('nav a[href="' + hash + '"], #mobileNavbar a[href="' + hash + '"]').addClass('active-section');
            }
        }
    });

    // Handle initial hash on page load
    if (window.location.hash) {
        var initialHash = window.location.hash;
        var target = $(initialHash);
        if (target.length) {
            contentSection.hide().removeClass('active-section');
            target.show().addClass('active-section');
            
            $('nav a, #mobileNavbar a').removeClass('active-section');
            $('nav a[href="' + initialHash + '"], #mobileNavbar a[href="' + initialHash + '"]').addClass('active-section');
        }
    }

    // Smooth scroll for anchor links
    $('.button a[href*=#]').on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({ scrollTop: $($(this).attr('href')).offset().top }, 500, 'linear');
    });
});
// Toggle Navigation Menu
$('#nav-toggle').on('click', function (event) {
    event.preventDefault();
    $('#main-nav').toggleClass("open");
    
    // Close the menu when clicking on a nav link
    $('#mobileNavbar a').on('click', function () {
        $('#main-nav').removeClass("open");
    });
});
