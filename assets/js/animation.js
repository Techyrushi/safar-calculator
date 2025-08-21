  jQuery(document).ready(function($) {
            "use strict";

            // Initialize travel showcase slider with multiple slides visible
            if ($('.travel-showcase-slider .slider-container').length) {
                $('.travel-showcase-slider .slider-container').slick({
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 4000,
                    speed: 800,
                    dots: true,
                    arrows: true,
                    fade: false,
                    cssEase: 'cubic-bezier(0.7, 0, 0.3, 1)',
                    prevArrow: '<button class="slick-prev"><i class="fas fa-chevron-left"></i></button>',
                    nextArrow: '<button class="slick-next"><i class="fas fa-chevron-right"></i></button>',
                    responsive: [
                        {
                            breakpoint: 991,
                            settings: {
                                slidesToShow: 2
                            }
                        },
                        {
                            breakpoint: 767,
                            settings: {
                                slidesToShow: 1,
                                arrows: false
                            }
                        }
                    ]
                });
            }

            // Enhanced scroll animation for package items
            function setupPackageAnimations() {
                // Set custom property for each item to control staggered animation
                $('.package-item').each(function(index) {
                    $(this).css('--item-index', index);
                });

                // Check if element is in viewport
                function isInViewport(element) {
                    var rect = element.getBoundingClientRect();
                    return (
                        rect.top <= (window.innerHeight || document.documentElement.clientHeight) * 0.85 &&
                        rect.bottom >= 0
                    );
                }

                // Function to handle scroll animation
                function handleScrollAnimation() {
                    $('.package-item').each(function() {
                        if (isInViewport(this)) {
                            $(this).addClass('animate');
                        }
                    });
                }

                // Initial check
                handleScrollAnimation();

                // Debounced scroll handler for better performance
                var scrollTimeout;
                $(window).on('scroll', function() {
                    if (scrollTimeout) {
                        clearTimeout(scrollTimeout);
                    }
                    scrollTimeout = setTimeout(handleScrollAnimation, 10);
                });

                // Handle resize events
                var resizeTimeout;
                $(window).on('resize', function() {
                    if (resizeTimeout) {
                        clearTimeout(resizeTimeout);
                    }
                    resizeTimeout = setTimeout(handleScrollAnimation, 100);
                });
            }
            setupPackageAnimations();

        });