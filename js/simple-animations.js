// Simple Animation Fix for Section Navigation
document.addEventListener('DOMContentLoaded', function() {
    // Get all navigation links
    const navLinks = document.querySelectorAll('.sidebar-navigation .nav-link, .navbar-nav .nav-link');
    
    // Add click event to each navigation link
    navLinks.forEach(link => {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Get target section ID
        const targetId = this.getAttribute('href');
        
        // Only proceed if it's a valid section link
        if (targetId && targetId.startsWith('#') && targetId.length > 1) {
          const targetSection = document.querySelector(targetId);
          
          if (targetSection) {
            // Close mobile menu if it's open
            const mobileNavbar = document.getElementById('mobileNavbar');
            if (mobileNavbar && mobileNavbar.classList.contains('show')) {
              try {
                const bsCollapse = new bootstrap.Collapse(mobileNavbar);
                bsCollapse.hide();
              } catch (e) {
                mobileNavbar.classList.remove('show');
              }
            }
            
            // Update URL
            history.pushState(null, null, targetId);
            
            // Scroll to section
            window.scrollTo({
              top: targetSection.offsetTop - 80,
              behavior: 'smooth'
            });
            
            // Apply animation to the section
            applyEntranceAnimation(targetSection);
          }
        }
      });
    });
    
    // Function to apply entrance animation to a section
    function applyEntranceAnimation(section) {
      // First remove any existing animation classes
      section.classList.remove('animate-section');
      
      // Force browser reflow to ensure animation restarts
      void section.offsetWidth;
      
      // Apply animation class
      section.classList.add('animate-section');
      
      // Get all animatable elements within the section
      const elements = section.querySelectorAll('.animate-item');
      
      // Reset and animate each element with a staggered delay
      elements.forEach((element, index) => {
        // Remove any existing animation classes
        element.classList.remove('animate-item-visible');
        
        // Set a timeout to add the animation class with staggered delay
        setTimeout(() => {
          element.classList.add('animate-item-visible');
        }, 100 + (index * 100)); // 100ms base delay + 100ms per item
      });
    }
    
    // Add the required CSS
    const style = document.createElement('style');
    style.textContent = `
      .animate-section {
        animation: sectionFadeIn 0.5s ease forwards;
      }
      
      .animate-item {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.5s ease, transform 0.5s ease;
      }
      
      .animate-item-visible {
        opacity: 1;
        transform: translateY(0);
      }
      
      @keyframes sectionFadeIn {
        from { opacity: 0.7; }
        to { opacity: 1; }
      }
    `;
    document.head.appendChild(style);
    
    // Add animation classes to elements on page load
    function initializeAnimations() {
      // Add animation class to all sections
      document.querySelectorAll('section').forEach(section => {
        section.classList.add('animate-section');
      });
      
      // Add animation class to animatable elements
      const animatableSelectors = [
        '.section-heading', '.announcement-item', '.card', 
        '.member', '.carousel-container', '.floor-table',
        '.stat-card', '.feedback-card', '.about-card', 
        '.strategy-card', '.leader-card', '.accordion-item',
        '.event-card', 'h3', '.row-container > div'
      ];
      
      // Select all animatable elements
      const animatableElements = document.querySelectorAll(animatableSelectors.join(', '));
      
      // Add animation class to each element
      animatableElements.forEach(el => {
        el.classList.add('animate-item');
        
        // Add visible class to make initial page load animated
        el.classList.add('animate-item-visible');
      });
    }
    
    // Initialize animations on page load
    initializeAnimations();
    
    // Apply animation to the current section on page load
    function animateInitialSection() {
      // Get current hash or default to first section
      const hash = window.location.hash || '#announcement';
      const currentSection = document.querySelector(hash);
      
      if (currentSection) {
        setTimeout(() => {
          applyEntranceAnimation(currentSection);
        }, 500); // Delay to ensure page is fully loaded
      }
    }
    
    // Animate initial section
    animateInitialSection();
  });