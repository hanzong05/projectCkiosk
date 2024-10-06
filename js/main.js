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
    });

    // Smooth Scroll
    var contentSection = $('.content-section, .main-banner');
    var navigation = $('nav');

    // When a nav link is clicked, smooth scroll to the section
    navigation.on('click', 'a', function(event){
        event.preventDefault(); // Prevent default action
        smoothScroll($(this.hash));
    });

    // Update navigation on scroll
    $(window).on('scroll', function(){
        updateNavigation();
    });
    
    // Update navigation on page load
    updateNavigation();

    // Functions
    function updateNavigation() {
        var scrollPos = $(window).scrollTop() + ($(window).height() / 2);
        var activeSectionFound = false;
    
        contentSection.each(function() {
            var $section = $(this);
            var sectionTop = $section.offset().top;
            var sectionBottom = sectionTop + $section.outerHeight();
            var sectionId = $section.attr('id');
            var navigationMatch = $('nav a[href="#' + sectionId + '"]');
    
            // Check if the section is in view
            if (scrollPos >= sectionTop && scrollPos < sectionBottom) {
                navigationMatch.addClass('active-section');
                activeSectionFound = true;
            } else {
                navigationMatch.removeClass('active-section');
            }
        });
    
        // If no section is in view, remove 'active-section' from all nav items
        if (!activeSectionFound) {
            $('nav a').removeClass('active-section');
        }
    }
    

    function smoothScroll(target){
        $('body,html').animate({
            scrollTop: target.offset().top
        }, 800);
    }

    // Smooth scroll for anchor links
    $('.button a[href*=#]').on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({ scrollTop: $($(this).attr('href')).offset().top }, 500, 'linear');
    });
});
