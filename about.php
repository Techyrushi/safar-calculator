<?php
session_start();
include("config.php");

$seo_query = mysqli_query($con, "SELECT * FROM seo_settings WHERE page_type='about' LIMIT 1");
$seo_data = mysqli_fetch_assoc($seo_query);

$page_title = isset($seo_data['title']) ? $seo_data['title'] : "Mahalaxmi Construction | Building Your Dreams";
$meta_keywords = isset($seo_data['keywords']) ? $seo_data['keywords'] : "construction, building, real estate, mahalaxmi, home builders";
$meta_description = isset($seo_data['description']) ? $seo_data['description'] : "Mahalaxmi Construction is a leading construction company specializing in residential and commercial projects.";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="keywords" content="<?php echo htmlspecialchars($meta_keywords); ?>">
  <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
  <!-- favicon -->
  <link rel="icon" type="image/ico" href="assets/images/favicon.ico" />
  <!-- Bootstrap CSS -->
  <link
    rel="stylesheet"
    href="assets/vendors/bootstrap/css/bootstrap.min.css"
    media="all" />
  <!-- jquery-ui css -->
  <link
    rel="stylesheet"
    type="text/css"
    href="assets/vendors/jquery-ui/jquery-ui.min.css" />
  <!-- fancybox box css -->
  <link
    rel="stylesheet"
    type="text/css"
    href="assets/vendors/fancybox/dist/jquery.fancybox.min.css" />
  <!-- Fonts Awesome CSS -->
  <link
    rel="stylesheet"
    type="text/css"
    href="assets/vendors/fontawesome/css/all.min.css" />
  <!-- Elmentkit Icon CSS -->
  <link
    rel="stylesheet"
    type="text/css"
    href="assets/vendors/elementskit-icon-pack/assets/css/ekiticons.css" />
  <!-- slick slider css -->
  <link
    rel="stylesheet"
    type="text/css"
    href="assets/vendors/slick/slick.css" />
  <link
    rel="stylesheet"
    type="text/css"
    href="assets/vendors/slick/slick-theme.css" />
  <!-- google fonts -->
  <link
    href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400&amp;family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400&amp;display=swap"
    rel="stylesheet" />
  <!-- Custom CSS -->
  <link rel="stylesheet" type="text/css" href="style.css" />
  <link rel="stylesheet" type="text/css" href="footer-styles.css" />
  <title><?php echo htmlspecialchars($page_title); ?></title>
  <style>
/* Minimal Story Section Styles */
.minimal-story-section {
    padding: 80px 0;
    background: #f9f9f9;
    position: relative;
    overflow: hidden;
}

.story-visual {
    position: relative;
    margin: 0 auto;
    max-width: 1200px;
}

.story-image-container {
    position: relative;
    padding: 20px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 5px 25px rgba(0, 0, 0, 0.05);
}

.image-wrapper {
    position: relative;
    border-radius: 6px;
    overflow: hidden;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    transition: all 0.5s ease;
}

.image-wrapper:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.image-wrapper img {
    width: 100%;
    height: auto;
    display: block;
    transition: transform 1.2s ease;
}

.image-wrapper:hover img {
    transform: scale(1.03);
}

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(248, 184, 100, 0.1) 0%, rgba(35, 33, 33, 0.05) 100%);
    opacity: 0;
    transition: opacity 0.5s ease;
}

.image-wrapper:hover .image-overlay {
    opacity: 1;
}

/* Corner decorations */
.corner-decoration {
    position: absolute;
    width: 30px;
    height: 30px;
    z-index: 2;
}

.corner-1 {
    top: 0;
    left: 0;
    border-top: 2px solid #f8b864;
    border-left: 2px solid #f8b864;
    border-top-left-radius: 8px;
}

.corner-2 {
    top: 0;
    right: 0;
    border-top: 2px solid #f8b864;
    border-right: 2px solid #f8b864;
    border-top-right-radius: 8px;
}

.corner-3 {
    bottom: 0;
    left: 0;
    border-bottom: 2px solid #f8b864;
    border-left: 2px solid #f8b864;
    border-bottom-left-radius: 8px;
}

.corner-4 {
    bottom: 0;
    right: 0;
    border-bottom: 2px solid #f8b864;
    border-right: 2px solid #f8b864;
    border-bottom-right-radius: 8px;
}

/* Subtle animation for corners */
@keyframes cornerPulse {
    0%, 100% {
        opacity: 0.7;
    }
    50% {
        opacity: 1;
    }
}

.corner-decoration {
    animation: cornerPulse 3s ease-in-out infinite;
}

.corner-2 {
    animation-delay: 0.5s;
}

.corner-3 {
    animation-delay: 1s;
}

.corner-4 {
    animation-delay: 1.5s;
}

/* Responsive Styles */
@media (max-width: 991px) {
    .minimal-story-section {
        padding: 60px 0;
    }
    
    .story-image-container {
        padding: 15px;
    }
}

@media (max-width: 767px) {
    .minimal-story-section {
        padding: 40px 0;
    }
    
    .story-image-container {
        padding: 10px;
    }
    
    .corner-decoration {
        width: 20px;
        height: 20px;
    }
}
  </style>
</head>

<body>
  <div id="siteLoader" class="site-loader">
    <div class="preloader-content">
      <img src="assets/images/loader1.gif" alt="" />
    </div>
  </div>
  <div id="page" class="page">
    <!-- site header html start  -->
    <header id="masthead" class="site-header">
      <!-- header html start -->
      <div class="header-overlay"></div>
      <div class="top-header">
        <div class="container">
          <div class="top-header-inner">
            <div class="header-contact text-left">
              <a href="tel:+919823059704">
                <i aria-hidden="true" class="icon icon-phone-call2"></i>
                <div class="header-contact-details d-none d-sm-block">
                  <span class="contact-label">For Further Inquires :</span>
                  <h5 class="header-contact-no">+91 (982) 305 9704</h5>
                </div>
              </a>
            </div>
            <div class="site-logo text-center">
              <h1 class="site-title">
                <a href="index">
                  <img src="assets/images/Safar_Logo_White-removebg-preview.png" style="mix-blend-mode: color-burn" alt="Logo" />
                </a>
              </h1>
            </div>
            <div class="header-icon text-right">
              <!-- <div class="header-search-icon d-inline-block">
                  <a href="#">
                    <i aria-hidden="true" class="fas fa-search"></i>
                  </a>
                </div> -->
              <div class="offcanvas-menu d-inline-block">
                <a href="#">
                  <i aria-hidden="true" class="icon icon-burger-menu"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="bottom-header">
        <div class="container">
          <div
            class="bottom-header-inner d-flex justify-content-between align-items-center">
            <div class="header-social social-icon">
              <ul>
                <li>
                  <a href="https://www.facebook.com/" target="_blank">
                    <i class="fab fa-facebook-f" aria-hidden="true"></i>
                  </a>
                </li>
                <li>
                  <a href="https://www.linkedin.com/" target="_blank">
                    <i class="fab fa-linkedin" aria-hidden="true"></i>
                  </a>
                </li>
                <li>
                  <a href="https://www.instagram.com/" target="_blank">
                    <i class="fab fa-instagram" aria-hidden="true"></i>
                  </a>
                </li>
              </ul>
            </div>
            <div class="navigation-container d-none d-lg-block">
              <nav id="navigation" class="navigation">
                <ul>
                  <li>
                    <a href="index">Home</a>
                  </li>
                  <li class="menu-active">
                    <a href="about">About Us</a>
                  </li>
                  <li>
                    <a href="package">Packages</a>
                  </li>
                  <!-- <li class="menu-item-has-children">
                      <a href="index">packages</a>
                      <ul>
                        <li>
                          <a href="package">Packages</a>
                        </li>
                        <li>
                          <a href="package-offer">Package offer</a>
                        </li>
                        <li>
                          <a href="package">Package detail</a>
                        </li>
                        <li>
                          <a href="cart">Cart page</a>
                        </li>
                        <li>
                          <a href="#">Booking page</a>
                        </li>
                        <li>
                          <a href="confirmation">Confirmation</a>
                        </li>
                      </ul>
                    </li> -->
                  <!-- <li class="menu-item-has-children">
                      <a href="index">Pages</a>
                      <ul>
                        <li>
                          <a href="home-banner">Home Banner</a>
                        </li>
                        <li>
                          <a href="service">Service</a>
                        </li>
                        <li class="menu-item-has-children">
                          <a href="#">Career</a>
                          <ul>
                            <li>
                              <a href="career">Career</a>
                            </li>
                            <li>
                              <a href="career-detail">Career detail</a>
                            </li>
                          </ul>
                        </li>
                        <li>
                          <a href="team">Tour guide</a>
                        </li>
                        <li>
                          <a href="gallery">Gallery page</a>
                        </li>
                        <li class="menu-item-has-children">
                          <a href="#">Blog</a>
                          <ul>
                            <li>
                              <a href="#">Blog archive</a>
                            </li>
                            <li>
                              <a href="#">blog single</a>
                            </li>
                          </ul>
                        </li>
                        <li>
                          <a href="single-page">Single Page</a>
                        </li>
                        <li>
                          <a href="testimonial">Testimonial</a>
                        </li>
                        <li>
                          <a href="faq">Faq Page</a>
                        </li>
                        <li>
                          <a href="search-page">Search Page</a>
                        </li>
                        <li>
                          <a href="404">404 Page</a>
                        </li>
                        <li>
                          <a href="comming-soon">Comming Soon Page</a>
                        </li>
                      </ul>
                    </li> -->
                  <li>
                    <a href="contact">Contact Us</a>
                  </li>
                </ul>
              </nav>
            </div>
            <div class="header-btn">
              <a href="#" class="round-btn">Book My Safar</a>
            </div>
          </div>
        </div>
      </div>
      <div class="mobile-menu-container"></div>
    </header>
    <!-- site header html end  -->
    <!-- ***site header html end*** -->
    <main id="content" class="site-main">
      <section class="inner-page-wrap">
        <!-- ***Inner Banner html start form here*** -->
        <div class="inner-banner-wrap">
          <div
            class="inner-baner-container"
            style="background-image: url(assets/images/About_Banner_Image.png)">
            <div class="container">
              <div class="inner-banner-content">
                <h1 class="page-title">About Us</h1>
              </div>
            </div>
          </div>
        </div>
        <!-- ***Inner Banner html end here*** -->
        <!-- ***about section html start form here*** -->
        <div class="inner-about-wrap">
          <div class="container">
            <div class="row">
              <div class="col-lg-8">
                <div class="about-content">
                  <figure class="about-image">
                    <img src="assets/images/img27.jpg" alt="" />
                    <div class="about-image-content">
                      <h3>WE ARE BEST FOR TOURS & TRAVEL SINCE 2020 !</h3>
                    </div>
                  </figure>
                  <h2>HOW WE ARE BEST FOR TRAVEL !</h2>
                  <p>
                    At Safar Pick & Drop Services, we’ve been creating
                    memorable journeys for our customers since 1985. With
                    decades of experience, we specialize in providing safe,
                    reliable, and affordable travel solutions – from daily
                    pick & drop to long tours across India.
                  </p>
                  <p>
                    What makes Safar stand out is our commitment to comfort,
                    punctuality, and customer satisfaction. Whether it’s a
                    short ride or a multi-day tour, we ensure every trip is
                    smooth, stress-free, and enjoyable.
                  </p>
                </div>
                <div class="client-slider white-bg">
                  <figure class="client-item">
                    <img src="assets/images/client-img7.png" alt="" />
                  </figure>
                  <figure class="client-item">
                    <img src="assets/images/client-img8.png" alt="" />
                  </figure>
                  <figure class="client-item">
                    <img src="assets/images/client-img9.png" alt="" />
                  </figure>
                  <figure class="client-item">
                    <img src="assets/images/client-img10.png" alt="" />
                  </figure>
                  <figure class="client-item">
                    <img src="assets/images/client-img11.png" alt="" />
                  </figure>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="icon-box">
                  <div class="box-icon">
                    <i aria-hidden="true" class="fas fa-umbrella-beach"></i>
                  </div>
                  <div class="icon-box-content">
                    <h3>AFFORDABLE TOURS</h3>
                    <p>
                      We offer budget-friendly travel packages without
                      compromising on comfort and safety.
                    </p>
                  </div>
                </div>
                <div class="icon-box">
                  <div class="box-icon">
                    <i aria-hidden="true" class="fas fa-user-tag"></i>
                  </div>
                  <div class="icon-box-content">
                    <h3>ON-TIME SERVICE</h3>
                    <p>
                      Punctual pick-up and drop services you can always count
                      on.
                    </p>
                  </div>
                </div>
                <div class="icon-box">
                  <div class="box-icon">
                    <i aria-hidden="true" class="fas fa-headset"></i>
                  </div>
                  <div class="icon-box-content">
                    <h3>COMFORTABLE RIDES</h3>
                    <p>
                      Well-maintained vehicles to make your travel experience
                      safe and comfortable.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- ***about section html start form here*** -->


        <!-- ***story section html start form here*** -->
        <section class="minimal-story-section">
          <div class="container">
            <div class="story-visual">
              <div class="story-image-container">
                <div class="image-wrapper">
                  <img src="assets/images/About Us Safar Story Image.png" alt="Safar Journey" class="img-fluid">
                  <div class="image-overlay"></div>
                </div>
                <div class="corner-decoration corner-1"></div>
                <div class="corner-decoration corner-2"></div>
                <div class="corner-decoration corner-3"></div>
                <div class="corner-decoration corner-4"></div>
              </div>
            </div>
          </div>
        </section>
        <!-- ***story section html end here*** -->

        <!-- ***callback section html start form here*** -->
        <div
          class="bg-img-fullcallback"
          style="background-image: url(assets/images/img7.jpg)">
          <div class="overlay"></div>
          <div class="container">
            <div class="row">
              <div class="col-lg-8 offset-lg-2 text-center">
                <div class="callback-content">
                  <div class="video-button">
                    <a
                      id="video-container"
                      data-fancybox="video-gallery"
                      href="https://www.youtube.com/watch?v=2OYar8OHEOU">
                      <i class="fas fa-play"></i>
                    </a>
                  </div>
                  <h2 class="section-title">
                    ARE YOU READY TO TRAVEL? REMEMBER US !!
                  </h2>
                  <p>
                    Plan your next journey with Safar Pick & Drop Services –
                    from daily rides to unforgettable tours. Safe, reliable,
                    and affordable travel made just for you.
                  </p>
                  <div class="callback-btn">
                    <a href="package" class="round-btn">View Packages</a>
                    <a href="about" class="round-btn">Learn More</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- ***callback section html end here*** -->
      </section>
      <a
        href="https://wa.me/919823059704?text=Hi%20Safar%2C%20I%27d%20like%20to%20book%20a%20ride."
        class="whatsapp-float"
        target="_blank"
        rel="noopener"
        aria-label="Chat on WhatsApp">
        <!-- WhatsApp SVG Icon -->
        <svg viewBox="0 0 32 32" aria-hidden="true">
          <path
            d="M19.11 17.27c-.26-.13-1.54-.76-1.78-.85-.24-.09-.41-.13-.58.13-.17.26-.67.85-.82 1.02-.15.17-.3.2-.56.07-.26-.13-1.1-.4-2.1-1.27-.78-.7-1.3-1.56-1.45-1.82-.15-.26-.02-.4.11-.53.11-.11.26-.3.39-.45.13-.15.17-.26.26-.43.09-.17.04-.32-.02-.45-.07-.13-.58-1.39-.8-1.9-.21-.5-.42-.43-.58-.44l-.5-.01c-.17 0-.45.06-.69.32-.24.26-.9.88-.9 2.14 0 1.26.93 2.48 1.06 2.65.13.17 1.84 2.8 4.46 3.93.62.27 1.11.43 1.49.55.63.2 1.21.17 1.67.1.51-.08 1.54-.63 1.76-1.25.22-.62.22-1.15.15-1.27-.07-.12-.23-.19-.49-.32zM16 3c7.18 0 13 5.82 13 13 0 7.18-5.82 13-13 13-2.29 0-4.44-.6-6.31-1.64L3 29l1.71-6.52A12.93 12.93 0 0 1 3 16C3 8.82 8.82 3 16 3zm0 2.5C10.22 5.5 5.5 10.22 5.5 16c0 2.17.7 4.18 1.89 5.82l-.97 3.71 3.8-.99A10.45 10.45 0 0 0 16 26.5c5.78 0 10.5-4.72 10.5-10.5S21.78 5.5 16 5.5z" />
        </svg>
      </a>
    </main>
    <!-- ***site footer html start form here*** -->
    <footer id="colophon" class="site-footer footer-primary">
      <div class="top-footer">
        <div class="container">
          <!-- Wave decoration at top of footer -->
          <div class="footer-wave">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 100" preserveAspectRatio="none">
              <path fill="#ffffff" fill-opacity="1" d="M0,32L60,42.7C120,53,240,75,360,74.7C480,75,600,53,720,48C840,43,960,53,1080,58.7C1200,64,1320,64,1380,64L1440,64L1440,0L1380,0C1320,0,1200,0,1080,0C960,0,840,0,720,0C600,0,480,0,360,0C240,0,120,0,60,0L0,0Z"></path>
            </svg>
          </div>

          <div class="upper-footer">
            <div class="row">
              <div class="col-lg-4 col-md-6">
                <aside class="widget widget_text">
                  <div class="footer-logo">
                    <a href="index">
                      <img src="assets/images/Safar_Logo_White-removebg-preview.png" style="mix-blend-mode: color-burn" alt="Safar Logo" class="img-fluid">
                    </a>
                  </div>
                  <div class="textwidget widget-text">
                    <p>At Safar, we make travel simple, safe, and stress-free. From daily pick & drop services and airport transfers to city tours, outstation trips, and customized tour packages, we provide reliable and affordable travel solutions for every need.</p>
                  </div>
                  <div class="header-social footer-social-icons">
                    <a href="https://www.facebook.com/" target="_blank" class="social-icons">
                      <i class="fab fa-facebook-f" aria-hidden="true"></i>
                    </a>
                    <!-- <a href="https://www.twitter.com/" target="_blank" class="social-icons">
                        <i class="fab fa-linkedin" aria-hidden="true"></i>
                      </a> -->
                    <a href="https://www.instagram.com/" target="_blank" class="social-icons">
                      <i class="fab fa-instagram" aria-hidden="true"></i>
                    </a>
                    <a href="https://www.linkedin.com/" target="_blank" class="social-icons">
                      <i class="fab fa-linkedin" aria-hidden="true"></i>
                    </a>
                    <a href="https://www.youtube.com/" target="_blank" class="social-icons">
                      <i class="fab fa-youtube" aria-hidden="true"></i>
                    </a>
                  </div>
                </aside>
              </div>

              <div class="col-lg-4 col-md-6">
                <aside class="widget widget_latest_post widget-post-thumb">
                  <h3 class="widget-title">Popular Destinations</h3>
                  <ul class="modern-post-list">
                    <li>
                      <figure class="post-thumb">
                        <a href="#">
                          <img src="assets/images/img21.jpg" alt="Peaceful Places" class="img-fluid rounded">
                        </a>
                      </figure>
                      <div class="post-content">
                        <h6>
                          <a href="#">Journey to Peaceful Places</a>
                        </h6>
                        <div class="entry-meta">
                          <span class="posted-on">
                            <i class="far fa-calendar-alt"></i>
                            <a href="#">February 17, 2023</a>
                          </span>
                        </div>
                      </div>
                    </li>
                    <li>
                      <figure class="post-thumb">
                        <a href="#">
                          <img src="assets/images/img22.jpg" alt="Travel with Friends" class="img-fluid rounded">
                        </a>
                      </figure>
                      <div class="post-content">
                        <h6>
                          <a href="#">Travel with Friends</a>
                        </h6>
                        <div class="entry-meta">
                          <span class="posted-on">
                            <i class="far fa-calendar-alt"></i>
                            <a href="#">March 5, 2023</a>
                          </span>
                        </div>
                      </div>
                    </li>
                  </ul>
                </aside>
              </div>

              <div class="col-lg-4 col-md-12">
                <aside class="widget widget_text">
                  <h3 class="widget-title">Get In Touch</h3>
                  <div class="textwidget widget-text contact-info">
                    <ul>
                      <li>
                        <a href="tel:+919823059704" class="contact-item">
                          <div class="icon-wrapper">
                            <i aria-hidden="true" class="fas fa-phone-alt"></i>
                          </div>
                          <div class="contact-text">
                            <span>Call Us</span>
                            +91 (982) 305 9704
                          </div>
                        </a>
                      </li>
                      <li>
                        <a href="mailto:crushikesh74@gmail.com" class="contact-item">
                          <div class="icon-wrapper">
                            <i aria-hidden="true" class="fas fa-envelope"></i>
                          </div>
                          <div class="contact-text">
                            <span>Email Us</span>
                            crushikesh74@gmail.com
                          </div>
                        </a>
                      </li>
                      <li class="contact-item">
                        <div class="icon-wrapper">
                          <i aria-hidden="true" class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-text">
                          <span>Visit Us</span>
                          Bunglow No 25 Shreeraj Society, HAL Colony Indira Nagar, Nashik-422009
                        </div>
                      </li>
                    </ul>
                  </div>
                </aside>
              </div>
            </div>
          </div>

          <div class="lower-footer">
            <div class="row">
              <div class="col-md-12">
                <div class="footer-menu quick-links">
                  <h4>Quick Links</h4>
                  <ul>
                    <li><a href="index">Home</a></li>
                    <li><a href="about">About Us</a></li>
                    <li><a href="package">Packages</a></li>
                    <li><a href="contact">Contact Us</a></li>
                    <!-- <li><a href="#">FAQ</a></li>
                      <li><a href="#">Privacy Policy</a></li> -->
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="bottom-footer">
        <div class="container">
          <div class="copy-right text-center">
            <p>Copyright &copy; 2023 Safar. All rights reserved. | Designed with <i class="fas fa-heart"></i> for travelers</p>
          </div>
        </div>
      </div>
    </footer>
    <!-- ***site footer html end*** -->
    <a id="backTotop" href="#" class="to-top-icon">
      <i class="fas fa-chevron-up"></i>
    </a>
    <!-- ***custom search field html*** -->
    <div class="header-search-form">
      <div class="container">
        <div class="header-search-container">
          <form class="search-form" role="search" method="get">
            <input type="text" name="s" placeholder="Enter your text..." />
          </form>
          <a href="#" class="search-close">
            <i class="fas fa-times"></i>
          </a>
        </div>
      </div>
    </div>
    <!-- ***custom search field html*** -->
    <!-- ***custom top bar offcanvas html*** -->
    <div id="offCanvas" class="offcanvas-container">
      <div class="offcanvas-inner">
        <div class="offcanvas-sidebar">
          <aside class="widget author_widget">
            <h3 class="widget-title">OUR PROPRIETOR</h3>
            <div class="widget-content text-center">
              <div class="profile">
                <figure class="avatar">
                  <img src="assets/images/img21.jpg" alt="" />
                </figure>
                <div class="text-content">
                  <div class="name-title">
                    <h4>Nitin Kulkarni</h4>
                  </div>
                  <p>
                    Safar Pick & Drop Services is proudly managed by Me. With
                    a vision to provide safe, reliable, and affordable travel
                    solutions, Safar has become a trusted name for daily pick
                    & drop, airport transfers, city tours, and outstation
                    trips.
                  </p>
                </div>
                <div class="socialgroup">
                  <ul>
                    <li>
                      <a target="_blank" href="#">
                        <i class="fab fa-facebook"></i>
                      </a>
                    </li>
                    <li>
                      <a target="_blank" href="#">
                        <i class="fab fa-google"></i>
                      </a>
                    </li>
                    <li>
                      <a target="_blank" href="#">
                        <i class="fab fa-linkedin"></i>
                      </a>
                    </li>
                    <li>
                      <a target="_blank" href="#">
                        <i class="fab fa-instagram"></i>
                      </a>
                    </li>
                    <!-- <li>
                        <a target="_blank" href="#">
                          <i class="fab fa-pinterest"></i>
                        </a>
                      </li> -->
                  </ul>
                </div>
              </div>
            </div>
          </aside>
          <aside class="widget widget_text text-center">
            <h3 class="widget-title">CONTACT US</h3>
            <div class="textwidget widget-text">
              <p>
                Feel free to contact and<br />
                reach us !!
              </p>
              <ul>
                <li>
                  <a href="tel:+01988256203">
                    <i aria-hidden="true" class="icon icon-phone1"></i>
                    +91 (982) 305 9704
                  </a>
                </li>
                <li>
                  <a href="mailto:crushikesh74@gmail.com">
                    <i aria-hidden="true" class="icon icon-envelope1"></i>
                    crushikesh74@gmail.com
                  </a>
                </li>
                <li>
                  <i aria-hidden="true" class="icon icon-map-marker1"></i>
                  Bunglow No 25 Shreeraj Society, HAL Colony Indira Nagar,
                  Nashik-422009
                </li>
              </ul>
            </div>
          </aside>
        </div>
        <a href="#" class="offcanvas-close">
          <i class="fas fa-times"></i>
        </a>
      </div>
      <div class="overlay"></div>
    </div>
    <!-- ***custom top bar offcanvas html*** -->
  </div>

  <!-- JavaScript -->
  <script src="assets/vendors/jquery/jquery.js"></script>
  <script src="assets/vendors/waypoint/waypoints.js"></script>
  <script src="assets/vendors/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/vendors/jquery-ui/jquery-ui.min.js"></script>
  <script src="assets/vendors/countdown-date-loop-counter/loopcounter.js"></script>
  <script src="assets/vendors/counterup/jquery.counterup.min.js"></script>
  <script src="../../../unpkg.com/imagesloaded%404.1.4/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendors/masonry/masonry.pkgd.min.js"></script>
  <script src="assets/vendors/slick/slick.min.js"></script>
  <script src="assets/vendors/fancybox/dist/jquery.fancybox.min.js"></script>
  <script src="assets/vendors/slick-nav/jquery.slicknav.js"></script>
  <script src="assets/js/custom.min.js"></script>
</body>

</html>