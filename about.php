<?php
session_start();
include("config.php");

$seo_query = mysqli_query($con, "SELECT * FROM seo_settings WHERE page_type='about' LIMIT 1");
$seo_data = mysqli_fetch_assoc($seo_query);

$page_title = isset($seo_data['title']) ? $seo_data['title'] : "Safar - Pick and Drop Services";
$meta_keywords = isset($seo_data['keywords']) ? $seo_data['keywords'] : "safar, pick and drop, services, transport, delivery";
$meta_description = isset($seo_data['description']) ? $seo_data['description'] : "Safar is a leading pick and drop service provider specializing in transport and delivery.";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1.0" />
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

      0%,
      100% {
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

<body class="about">
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
            <?php
            $query = mysqli_query($con, "SELECT * FROM contact_cms");
            while ($row = mysqli_fetch_array($query)) {
            ?>
              <div class="header-contact text-left d-flex align-items-center">
                <?php
                $phones = preg_split('/<br\s*\/?>|\r\n|\n/', $row['mobile_number']);
                if (!empty($phones[0])) {
                  echo '<a href="tel:+91' . trim($phones[0]) . '">
          <i aria-hidden="true" class="icon icon-phone-call2 mr-2"></i>
        </a>';
                }
                ?>
                <div class="header-contact-details d-none d-sm-block">
                  <span class="contact-label">For Further Inquires :</span>
                  <h5 class="header-contact-no">
                    <?php
                    $phones = preg_split('/<br\s*\/?>|\r\n|\n/', $row['mobile_number']);
                    if (!empty($phones[0])) {
                      echo '<a href="tel:+91' . trim($phones[0]) . '">+91 ' . trim($phones[0]) . '</a>';
                    }
                    ?>
                  </h5>
                </div>
              </div>
            <?php } ?>

            <?php
            $query = mysqli_query($con, "SELECT * FROM footer_cms");
            while ($row = mysqli_fetch_array($query)) {
            ?>
              <div class="site-logo text-center">
                <h1 class="site-title">
                  <a href="index">
                    <img
                      src="admin/packages/<?php echo $row['logo_path']; ?>"
                      style="mix-blend-mode: color-burn"
                      alt="Logo" />
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
                  <a href="<?php echo $row['facebook_url']; ?>" target="_blank">
                    <i class="fab fa-facebook-f" aria-hidden="true"></i>
                  </a>
                </li>
                <li>
                  <a href="<?php echo $row['linkedin_url']; ?>" target="_blank">
                    <i class="fab fa-linkedin" aria-hidden="true"></i>
                  </a>
                </li>
                <li>
                  <a href="<?php echo $row['instagram_url']; ?>" target="_blank">
                    <i class="fab fa-instagram" aria-hidden="true"></i>
                  </a>
                </li>
              </ul>
            </div>
          <?php } ?>
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
                <li>
                  <a href="contact">Contact Us</a>
                </li>
              </ul>
            </nav>
          </div>
          <div class="header-btn">
            <a href="contact" class="round-btn">Book My Safar</a>
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
          <?php
          // Fetch all banners ordered by display_order
          $banners = mysqli_query($con, "SELECT * FROM about_cms");

          if ($banners && mysqli_num_rows($banners) > 0) {
            while ($banner = mysqli_fetch_assoc($banners)) {
          ?>
              <div
                class="about-banner"
                style="background-image: url('admin/about/<?php echo $banner['banner_image']; ?>');">
                <div class="container">
                  <div class="inner-banner-content">
                    <!-- <h1 class="page-title">About Us</h1> -->
                  </div>
                </div>
              </div>
          <?php
            }
          }
          ?>
        </div>
        <!-- ***Inner Banner html end here*** -->
        <!-- ***about section html start form here*** -->
        <?php
        $query = mysqli_query($con, "SELECT * FROM about_cms");
        while ($row = mysqli_fetch_array($query)) {
        ?>
          <div class="inner-about-wrap">
            <div class="container">
              <div class="row">
                <div class="col-lg-8">
                  <div class="about-content">
                    <figure class="about-image">
                      <img src="admin/about/<?php echo $row['main_image']; ?>" alt="" />
                      <div class="about-image-content">
                        <h3><?php echo $row['text1']; ?></h3>
                      </div>
                    </figure>
                    <h2><?php echo $row['text2']; ?></h2>
                    <p>
                      <?php echo $row['description']; ?>
                    </p>
                  </div>
                  <div class="client-slider white-bg">
                    <?php
                    $query = mysqli_query($con, "SELECT * FROM about_partners");
                    while ($partner = mysqli_fetch_array($query)) {
                    ?>
                      <figure class="client-item">
                        <img src="admin/about/partners/<?php echo $partner['partner_image']; ?>" alt="" />
                      </figure>
                    <?php } ?>
                  </div>
                </div>
              <?php } ?>
              <div class="col-lg-4">
                <?php
                $query = mysqli_query($con, "SELECT * FROM services ORDER BY created_at DESC LIMIT 3");
                while ($row = mysqli_fetch_array($query)) {
                ?>
                  <div class="icon-box">
                    <div class="box-icon">
                      <i aria-hidden="true" class="fas <?php echo $row['icon']; ?>"></i>
                    </div>
                    <div class="icon-box-content">
                      <h3><?php echo $row['title']; ?></h3>
                      <p>
                        <?php echo $row['description']; ?>
                      </p>
                    </div>
                  </div>
                <?php } ?>
              </div>
              </div>
            </div>
          </div>
          <!-- ***about section html start form here*** -->


          <!-- ***story section html start form here*** -->
          <?php
          $query = mysqli_query($con, "SELECT * FROM about_cms");
          while ($row = mysqli_fetch_array($query)) {
          ?>
            <section class="minimal-story-section">
              <div class="container">
                <div class="story-visual">
                  <div class="story-image-container">
                    <div class="image-wrapper">
                      <img src="admin/about/<?php echo $row['story_image']; ?>" alt="Safar Journey" class="img-fluid">
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
          <?php } ?>
          <!-- ***story section html end here*** -->

          <!-- ***callback section html start form here*** -->
          <?php
          $query = mysqli_query($con, "SELECT * FROM statistics");
          while ($row = mysqli_fetch_array($query)) {
          ?>
            <div
              class="bg-img-fullcallback"
              style="background-image: url(admin/upload/<?php echo $row['image_path']; ?>)">
              <div class="overlay"></div>
              <div class="container">
                <div class="row">
                  <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="callback-content">
                      <div class="video-button">
                        <a
                          id="video-container"
                          data-fancybox="video-gallery"
                          href="<?php echo $row['video_url']; ?>">
                          <i class="fas fa-play"></i>
                        </a>
                      </div>
                      <h2 class="section-title">
                        <?php echo $row['title']; ?>
                      </h2>
                      <p>
                        <?php echo $row['description']; ?>
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
          <?php } ?>
          <!-- ***callback section html end here*** -->
      </section>
      <div class="feedbackFormDiv">
        <button onclick="toggleFeedbackForm()">Feedback <i class="fas fa-comment" aria-hidden="true"></i></button>
      </div>
      <section>
        <div class="bgFeedBack">
          <div class="app">
            <div class="formTopHead mb-4">
              <i class="fa fa-times-circle" onclick="toggleFeedbackForm()"></i>
              <h3 class="mt-3"><i class="fa fa-compass"></i> Ready to <span class="orange-color">explore more</span></h3>
              <h5 class="gray-color">Help us craft better travel experiences by sharing your journey with us. Your feedback guides our next destination!</h5>
            </div>

            <div class="container">
              <form action="submit_feedback.php" method="POST">
                <!-- 📧 Email -->
                <div class="row justify-content-center mb-3">
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="feature-email">
                      <input
                        type="email"
                        name="email"
                        placeholder="✉ Enter Your Email"
                        required
                        class="email-input">
                    </div>
                  </div>
                </div>
            </div>

            <!-- ⭐ Star Rating -->
            <div class="row justify-content-center mb-3">
              <div class="col-lg-12 col-md-12 col-sm-12">
                <label><strong>Your Rating</strong></label>
                <div class="star-rating">
                  <input type="radio" name="rating" id="star5" value="5" required>
                  <label for="star5" title="5 stars">★</label>
                  <input type="radio" name="rating" id="star4" value="4">
                  <label for="star4" title="4 stars">★</label>
                  <input type="radio" name="rating" id="star3" value="3">
                  <label for="star3" title="3 stars">★</label>
                  <input type="radio" name="rating" id="star2" value="2">
                  <label for="star2" title="2 stars">★</label>
                  <input type="radio" name="rating" id="star1" value="1">
                  <label for="star1" title="1 star">★</label>
                </div>
              </div>
            </div>

            <!-- 📝 Review/Suggestion -->
            <div class="row justify-content-center mb-4">
              <div class="col-lg-12 col-md-12 col-sm-12">
                <label for="review"><strong>Your Review or Suggestion</strong></label>
                <textarea id="review" name="review" rows="5" placeholder="Write your feedback here..." style="border: 2px solid #f58634;" required></textarea>
              </div>
            </div>

            <!-- 📤 Submit Button -->
            <div class="row justify-content-center">
              <button type="submit" class="upgrade-btn">Submit</button>
            </div>
            </form>
          </div>
        </div>
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
    <?php
    $query = mysqli_query($con, "SELECT * FROM footer_cms");
    while ($row = mysqli_fetch_array($query)) {
    ?>
      <footer id="colophon" class="site-footer footer-primary">
        <div class="top-footer">
          <div class="container">
            <!-- Wave decoration at top of footer -->
            <div class="footer-wave">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 1440 100"
                preserveAspectRatio="none">
                <path
                  fill="#ffffff"
                  fill-opacity="1"
                  d="M0,32L60,42.7C120,53,240,75,360,74.7C480,75,600,53,720,48C840,43,960,53,1080,58.7C1200,64,1320,64,1380,64L1440,64L1440,0L1380,0C1320,0,1200,0,1080,0C960,0,840,0,720,0C600,0,480,0,360,0C240,0,120,0,60,0L0,0Z"></path>
              </svg>
            </div>

            <div class="upper-footer">
              <div class="row">
                <div class="col-lg-4 col-md-6">
                  <aside class="widget widget_text">
                    <div class="footer-logo">
                      <a href="index">
                        <img
                          src="admin/packages/<?php echo $row['logo_path']; ?>"
                          style="mix-blend-mode: color-burn"
                          alt="Safar Logo"
                          class="img-fluid" />
                      </a>
                    </div>
                    <div class="textwidget widget-text">
                      <p>
                        <?php echo $row['description']; ?>
                      </p>
                    </div>
                    <div class="header-social footer-social-icons">
                      <?php
                      if ($row['facebook_status'] == 1) {
                      ?>
                        <a
                          href="<?php echo $row['facebook_url']; ?>"
                          target="_blank"
                          class="social-icons">
                          <i class="fab fa-facebook-f" aria-hidden="true"></i>
                        </a>
                      <?php
                      }
                      ?>
                      <?php
                      if ($row['twitter_status'] == 1) {
                      ?>
                        <a
                          href="<?php echo $row['twitter_url']; ?>"
                          target="_blank"
                          class="social-icons">
                          <i class="fab fa-twitter" aria-hidden="true"></i>
                        </a>
                      <?php
                      }
                      ?>
                      <?php
                      if ($row['instagram_status'] == 1) {
                      ?>
                        <a
                          href="<?php echo $row['instagram_url']; ?>"
                          target="_blank"
                          class="social-icons">
                          <i class="fab fa-instagram" aria-hidden="true"></i>
                        </a>
                      <?php
                      }
                      ?>
                      <?php
                      if ($row['linkedin_status'] == 1) {
                      ?>
                        <a
                          href="<?php echo $row['linkedin_url']; ?>"
                          target="_blank"
                          class="social-icons">
                          <i class="fab fa-linkedin" aria-hidden="true"></i>
                        </a>
                      <?php
                      }
                      ?>
                      <?php
                      if ($row['youtube_status'] == 1) {
                      ?>
                        <a
                          href="<?php echo $row['youtube_url']; ?>"
                          target="_blank"
                          class="social-icons">
                          <i class="fab fa-youtube" aria-hidden="true"></i>
                        </a>
                      <?php
                      }
                      ?>
                    </div>
                  </aside>
                </div>

                <div class="col-lg-4 col-md-6">
                  <aside class="widget widget_latest_post widget-post-thumb">
                    <h3 class="widget-title">Popular Packages

                    </h3>
                    <ul class="modern-post-list">
                      <?php
                      $query = mysqli_query($con, "SELECT * FROM packages ORDER BY created_at DESC LIMIT 3");
                      while ($row = mysqli_fetch_array($query)) {
                      ?>
                        <li>
                          <figure class="post-thumb">
                            <a href="#">
                              <img
                                src="admin/packages/<?php echo $row['image_path']; ?>"
                                alt="Peaceful Places"
                                class="img-fluid rounded" />
                            </a>
                          </figure>
                          <div class="post-content">
                            <h6>
                              <a href="#"><?php echo $row['title']; ?></a>
                            </h6>
                            <div class="entry-meta">
                              <span class="posted-on">
                                <i class="far fa-calendar-alt"></i>
                                <a href="#">
                                  <?php echo date("F d, Y", strtotime($row['created_at'])); ?>
                                </a>
                              </span>
                            </div>
                          </div>
                        </li>
                      <?php
                      }
                      ?>
                    </ul>
                  </aside>
                </div>
                <?php
                $query = mysqli_query($con, "SELECT * FROM contact_cms");
                while ($row = mysqli_fetch_array($query)) {
                ?>
                  <div class="col-lg-4 col-md-12">
                    <aside class="widget widget_text">
                      <h3 class="widget-title">Get In Touch</h3>
                      <div class="textwidget widget-text contact-info">
                        <ul>
                          <!-- Phone -->
                          <li>
                            <div class="contact-item">
                              <div class="icon-wrapper">
                                <i aria-hidden="true" class="fas fa-phone-alt"></i>
                              </div>
                              <div class="contact-text">
                                <span>Call Us</span>
                                <?php
                                $phones = preg_split('/<br\s*\/?>|\r\n|\n/', $row['mobile_number']);
                                foreach ($phones as $phone) {
                                  $phone = trim($phone);
                                  if (!empty($phone)) {
                                    echo '<div><a href="tel:+91' . $phone . '">+91 ' . $phone . '</a></div>';
                                  }
                                }
                                ?>
                              </div>
                            </div>
                          </li>

                          <!-- Email -->
                          <li>
                            <div class="contact-item">
                              <div class="icon-wrapper">
                                <i aria-hidden="true" class="fas fa-envelope"></i>
                              </div>
                              <div class="contact-text">
                                <span>Email Us</span>
                                <?php
                                $emails = preg_split('/<br\s*\/?>|\r\n|\n/', $row['email']);
                                foreach ($emails as $email) {
                                  $email = trim($email);
                                  if (!empty($email)) {
                                    echo '<div><a href="mailto:' . $email . '">' . $email . '</a></div>';
                                  }
                                }
                                ?>
                              </div>
                            </div>
                          </li>

                          <!-- Address -->
                          <li class="contact-item">
                            <div class="icon-wrapper">
                              <i aria-hidden="true" class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="contact-text">
                              <span>Visit Us</span>
                              <?php echo nl2br($row['address']); ?>
                            </div>
                          </li>
                        </ul>
                      </div>
                    </aside>
                  </div>
                <?php } ?>
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
              <p>
                Copyright &copy; 2025 Safar. All rights reserved. | Designed
                with <i class="fas fa-heart"></i> for travelers
              </p>
            </div>
          </div>
        </div>
      </footer>
    <?php } ?>

    <!-- ***site footer html end*** -->
    <a id="backTotop" href="#" class="to-top-icon">
      <i class="fas fa-chevron-up"></i>
    </a>

    <!-- ***custom top bar offcanvas html*** -->
    <?php
    $query = mysqli_query($con, "SELECT * FROM footer_cms");
    while ($row = mysqli_fetch_array($query)) {
    ?>
      <div id="offCanvas" class="offcanvas-container">
        <div class="offcanvas-inner">
          <div class="offcanvas-sidebar">
            <aside class="widget author_widget">
              <h3 class="widget-title">OUR PROPRIETOR</h3>
              <div class="widget-content text-center">
                <div class="profile">
                  <figure class="avatar">
                    <img src="admin/packages/<?php echo $row['profile_path']; ?>" alt="" />
                  </figure>
                  <div class="text-content">
                    <div class="name-title">
                      <h4>Nitin Kulkarni</h4>
                    </div>
                    <p>
                      <?php echo $row['description']; ?>
                    </p>
                  </div>
                  <div class="socialgroup">
                    <ul>
                      <li>
                        <a target="_blank" href="<?php echo $row['facebook_url']; ?>">
                          <i class="fab fa-facebook"></i>
                        </a>
                      </li>
                      <li>
                        <a target="_blank" href="https://share.google/9bXDkYn3acIVhP8ay">
                          <i class="fab fa-google"></i>
                        </a>
                      </li>
                      <li>
                        <a target="_blank" href="<?php echo $row['linkedin_url']; ?>">
                          <i class="fab fa-linkedin"></i>
                        </a>
                      </li>
                      <li>
                        <a target="_blank" href="<?php echo $row['instagram_url']; ?>">
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
          <?php } ?>
          <?php
          $query = mysqli_query($con, "SELECT * FROM contact_cms");
          while ($row = mysqli_fetch_array($query)) {
          ?>
            <aside class="widget widget_text text-center">
              <h3 class="widget-title">CONTACT US</h3>
              <div class="textwidget widget-text">
                <p>
                  Feel free to contact and<br />
                  reach us !!
                </p>
                <ul>
                  <li>
                    <i aria-hidden="true" class="icon icon-phone1"></i>
                    <?php
                    $phones = preg_split('/<br\s*\/?>|\r\n|\n/', $row['mobile_number']);
                    foreach ($phones as $phone) {
                      $phone = trim($phone);
                      if (!empty($phone)) {
                        echo '<div><a href="tel:+91' . $phone . '">+91 ' . $phone . '</a></div>';
                      }
                    }
                    ?>

                  </li>
                  <li>
                    <i aria-hidden="true" class="icon icon-envelope1"></i>
                    <?php
                    $emails = preg_split('/<br\s*\/?>|\r\n|\n/', $row['email']);
                    foreach ($emails as $email) {
                      $email = trim($email);
                      if (!empty($email)) {
                        echo '<div><a href="mailto:' . $email . '">' . $email . '</a></div>';
                      }
                    }
                    ?>
                  </li>
                  <li>
                    <a href="<?php echo $row['location_url']; ?>">
                      <i aria-hidden="true" class="icon icon-map-marker1"></i>
                      <?php echo $row['address']; ?>
                    </a>
                  </li>
                </ul>
              </div>
            </aside>
          <?php } ?>
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
  <script>
    function toggleFeedbackForm() {
      const feedbackForm = document.querySelector('.bgFeedBack');
      feedbackForm.classList.toggle('show');
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const urlParams = new URLSearchParams(window.location.search);
      const status = urlParams.get('status');

      if (status === 'success') {
        Swal.fire({
          icon: 'success',
          title: 'Thank you!',
          text: 'Feedback submitted successfully.',
          confirmButtonColor: '#ff6f00'
        }).then(() => {
          window.location.href = 'about';
        });
      } else if (status === 'email_exists') {
        Swal.fire({
          icon: 'error',
          title: 'Oops!',
          text: 'You have already given feedback with this email.',
          confirmButtonColor: '#ff6f00'
        }).then(() => {
          window.location.href = 'about';
        });
      } else if (status === 'missing_fields') {
        Swal.fire({
          icon: 'warning',
          title: 'Incomplete!',
          text: 'Please fill all required fields.',
          confirmButtonColor: '#ff6f00'
        }).then(() => {
          window.location.href = 'about';
        });
      }
    });
  </script>
</body>

</html>