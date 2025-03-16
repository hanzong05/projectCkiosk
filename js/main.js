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
document.addEventListener('DOMContentLoaded', function() {
  // Set initial states for all sections
  const sections = document.querySelectorAll('.content-section');
  sections.forEach(section => {
    section.style.opacity = '0';
    section.style.transform = 'translateY(30px)';
    section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
  });
  
  // Show the first visible section immediately
  const firstVisibleSection = document.querySelector('.content-section');
  if (firstVisibleSection) {
    firstVisibleSection.style.opacity = '1';
    firstVisibleSection.style.transform = 'translateY(0)';
  }
  
  // Setup Intersection Observer to trigger animations when sections come into view
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      // If the section is entering the viewport
      if (entry.isIntersecting) {
        entry.target.style.opacity = '1';
        entry.target.style.transform = 'translateY(0)';
        
        // Animate the child elements with a staggered delay
        const animatableElements = entry.target.querySelectorAll('.section-heading, h3, .card, .member, .announcement-item, .floor-table, .stat-card, .strategy-card');
        
        animatableElements.forEach((element, index) => {
          element.style.opacity = '0';
          element.style.transform = 'translateY(20px)';
          element.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
          element.style.transitionDelay = `${0.1 + index * 0.05}s`; // Staggered delay
          
          // Trigger the animation after a small delay
          setTimeout(() => {
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
          }, 100);
        });
      }
    });
  }, {
    threshold: 0.1, // Trigger when at least 10% of the section is visible
    rootMargin: '-50px 0px' // Adjust the trigger point to be a bit before the section becomes visible
  });
  
  // Observe all sections
  sections.forEach(section => {
    observer.observe(section);
  });
  
  // Add click event listeners to navigation links
  const navLinks = document.querySelectorAll('.nav-link, .navbar-nav .nav-link');
  navLinks.forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      
      // Get the target section id from the href attribute
      const targetId = this.getAttribute('href');
      
      // Only proceed if it's a section link
      if (targetId && targetId.startsWith('#') && targetId.length > 1) {
        const targetSection = document.querySelector(targetId);
        
        // If target section exists, scroll to it smoothly
        if (targetSection) {
          // Add animation class to the clicked link
          this.classList.add('nav-link-clicked');
          
          // Remove the class after animation completes
          setTimeout(() => {
            this.classList.remove('nav-link-clicked');
          }, 500);
          
          // Smooth scroll to the target section
          window.scrollTo({
            top: targetSection.offsetTop - 70, // Adjust for fixed headers
            behavior: 'smooth'
          });
        }
      }
    });
  });
  
  // Create a progress indicator for scrolling
  const progressIndicator = document.createElement('div');
  progressIndicator.className = 'scroll-progress-indicator';
  document.body.appendChild(progressIndicator);
  
  // Update the progress indicator on scroll
  window.addEventListener('scroll', () => {
    const windowHeight = window.innerHeight;
    const documentHeight = document.documentElement.scrollHeight;
    const scrollTop = window.scrollY;
    
    const scrollPercentage = (scrollTop / (documentHeight - windowHeight)) * 100;
    progressIndicator.style.width = `${scrollPercentage}%`;
  });
});