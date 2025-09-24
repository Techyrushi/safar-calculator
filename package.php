<?php
session_start();
include("config.php");

$seo_query = mysqli_query($con, "SELECT * FROM seo_settings WHERE page_type='packages' LIMIT 1");
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
                <li>
                  <a href="about">About Us</a>
                </li>
                <li class="menu-active">
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
          $banners = mysqli_query($con, "SELECT * FROM contact_cms");

          if ($banners && mysqli_num_rows($banners) > 0) {
            while ($banner = mysqli_fetch_assoc($banners)) {
          ?>
              <div
                class="about-banner"
                style="background-image: url('admin/packages/<?php echo $banner['package_banner']; ?>');">
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

        <!-- ***Auto Slider Section start*** -->
        <!-- <div class="travel-showcase-slider">
          <div class="container">
            <div class="slider-container car-slider">
              <div class="travel-slide">
                <div class="car-sketch">
                  <svg
                    viewBox="0 0 240 120"
                    xmlns="http://www.w3.org/2000/svg">
                    <g class="car-body">
                      <path
                        d="M40,80 L60,80 L70,60 L170,60 L180,80 L200,80 L200,100 L40,100 Z"
                        fill="#3498db" />
                      <rect
                        x="50"
                        y="80"
                        width="30"
                        height="20"
                        fill="#2980b9" />
                      <rect
                        x="160"
                        y="80"
                        width="30"
                        height="20"
                        fill="#2980b9" />
                      <path
                        d="M70,60 L80,40 L160,40 L170,60 Z"
                        fill="#3498db" />
                      <rect
                        x="85"
                        y="45"
                        width="70"
                        height="15"
                        fill="#d5e8f8" />
                    </g>
                    <g class="wheels">
                      <circle cx="70" cy="100" r="15" fill="#2c3e50" />
                      <circle cx="70" cy="100" r="7" fill="#7f8c8d" />
                      <circle cx="170" cy="100" r="15" fill="#2c3e50" />
                      <circle cx="170" cy="100" r="7" fill="#7f8c8d" />
                    </g>
                  </svg>
                </div>
                <div class="slide-caption">
                  <h3>Comfortable Travel</h3>
                  <p>Enjoy our luxury car services</p>
                </div>
              </div>
              <div class="travel-slide">
                <div class="car-sketch">
                  <svg
                    viewBox="0 0 240 120"
                    xmlns="http://www.w3.org/2000/svg">
                    <g class="car-body">
                      <path
                        d="M40,80 L60,80 L70,60 L170,60 L180,80 L200,80 L200,100 L40,100 Z"
                        fill="#e74c3c" />
                      <rect
                        x="50"
                        y="80"
                        width="30"
                        height="20"
                        fill="#c0392b" />
                      <rect
                        x="160"
                        y="80"
                        width="30"
                        height="20"
                        fill="#c0392b" />
                      <path
                        d="M70,60 L80,40 L160,40 L170,60 Z"
                        fill="#e74c3c" />
                      <rect
                        x="85"
                        y="45"
                        width="70"
                        height="15"
                        fill="#f9ebea" />
                    </g>
                    <g class="wheels">
                      <circle cx="70" cy="100" r="15" fill="#2c3e50" />
                      <circle cx="70" cy="100" r="7" fill="#7f8c8d" />
                      <circle cx="170" cy="100" r="15" fill="#2c3e50" />
                      <circle cx="170" cy="100" r="7" fill="#7f8c8d" />
                    </g>
                  </svg>
                </div>
                <div class="slide-caption">
                  <h3>Safe Journeys</h3>
                  <p>Travel with peace of mind</p>
                </div>
              </div>
              <div class="travel-slide">
                <div class="car-sketch">
                  <svg
                    viewBox="0 0 240 120"
                    xmlns="http://www.w3.org/2000/svg">
                    <g class="car-body">
                      <path
                        d="M40,80 L60,80 L70,60 L170,60 L180,80 L200,80 L200,100 L40,100 Z"
                        fill="#2ecc71" />
                      <rect
                        x="50"
                        y="80"
                        width="30"
                        height="20"
                        fill="#27ae60" />
                      <rect
                        x="160"
                        y="80"
                        width="30"
                        height="20"
                        fill="#27ae60" />
                      <path
                        d="M70,60 L80,40 L160,40 L170,60 Z"
                        fill="#2ecc71" />
                      <rect
                        x="85"
                        y="45"
                        width="70"
                        height="15"
                        fill="#d5f5e3" />
                    </g>
                    <g class="wheels">
                      <circle cx="70" cy="100" r="15" fill="#2c3e50" />
                      <circle cx="70" cy="100" r="7" fill="#7f8c8d" />
                      <circle cx="170" cy="100" r="15" fill="#2c3e50" />
                      <circle cx="170" cy="100" r="7" fill="#7f8c8d" />
                    </g>
                  </svg>
                </div>
                <div class="slide-caption">
                  <h3>Eco-Friendly Options</h3>
                  <p>Sustainable transportation choices</p>
                </div>
              </div>
            </div>
          </div>
        </div> -->
        <!-- ***Auto Slider Section end*** -->

        <!-- ***package section html start form here*** -->
        <div class="package-item-wrap">
          <!-- Decorative floating elements -->
          <div class="floating-element"></div>
          <div class="floating-element"></div>
          <div class="floating-element"></div>
          <div class="container">
            <div class="section-heading text-center">
              <div class="row">
                <?php
                $query = mysqli_query($con, "SELECT * FROM packages ORDER BY created_at DESC LIMIT 1");
                while ($row = mysqli_fetch_array($query)) {
                ?>
                  <div class="col-lg-8 offset-lg-2">
                    <h5 class="dash-style">EXPLORE OUR PACKAGES</h5>
                    <h2><?php echo $row['pkg_title']; ?></h2>
                    <p>
                      <?php echo $row['pkg_desc']; ?>
                    </p>
                  </div>
                <?php } ?>
              </div>
            </div>
            <?php
            $query = mysqli_query($con, "SELECT * FROM packages ORDER BY display_order");
            while ($row = mysqli_fetch_array($query)) {
              $rating = isset($row['rating']) ? (float)$row['rating'] : 0;
              $fullStars = floor($rating);
              $halfStar  = ($rating - $fullStars) >= 0.5 ? 1 : 0;
              $emptyStars = 5 - ($fullStars + $halfStar);
              $modalId = "packageModal" . $row['id'];
            ?>
              <article class="package-item">
                <figure
                  class="package-image"
                  style="
                    background-image: url('admin/packages/<?php echo $row['image_path']; ?>');
                    background-size: cover;
                    background-repeat: no-repeat;
                    background-position: center;
                    aspect-ratio: 1/1; /* makes it a square box */
                    width: 100%;
                    border-radius: 16px;
                    overflow: hidden;
                    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
                  "></figure>
                <div class="package-content">
                  <h3>
                    <a
                      href="javascript:void(0)"
                      data-bs-toggle="modal"
                      data-bs-target="#<?php echo $modalId; ?>">
                      <?php echo $row['title']; ?>
                    </a>
                  </h3>
                  <p>
                    <?php echo $row['description']; ?>
                  </p>
                  <div class="package-meta">
                    <ul>
                      <li>
                        <i class="fas fa-clock"></i>
                        <?php echo $row['duration']; ?>
                      </li>
                      <li>
                        <i class="fas fa-user-friends"></i>
                        pax: <?php echo $row['group_size']; ?>
                      </li>
                      <li>
                        <i class="fas fa-map-marker-alt"></i>
                        <?php echo $row['location']; ?>
                      </li>
                    </ul>
                  </div>
                  <!-- ✅ PDF Download Button -->
                  <div class="package-meta">
                    <a href="admin/packages/pdf/<?php echo $row['pdf_path']; ?>" download>
                      <i class="fas fa-file-pdf"></i> Download Itinerary
                    </a>
                  </div>
                </div>
                <div class="package-price">
                  <div class="review-area">
                    <!-- <span class="review-text">(25 reviews)</span> -->
                    <div class="rating-start-wrap d-inline-block">
                      <div class="rating-starts">
                        <span style="width: 80%">
                          <?php
                          for ($i = 0; $i < $fullStars; $i++) {
                            echo '<i class="fas fa-star text-warning"></i>';
                          }
                          // Half star
                          if ($halfStar) {
                            echo '<i class="fas fa-star-half-alt text-warning"></i>';
                          }
                          // Empty stars
                          for ($i = 0; $i < $emptyStars; $i++) {
                            echo '<i class="far fa-star text-warning"></i>'; // empty star
                          }
                          ?>
                        </span>
                      </div>
                    </div>
                  </div>
                  <h6 class="price-list">
                    <span>₹<?php echo $row['price']; ?></span>
                    / <?php echo $row['price_unit']; ?>
                  </h6>

                  <div class="trip-start-label">Let's Start your trip</div>
                  <a href="https://wa.me/919823059704?text=Hi%20Safar%2C%20I%27d%20like%20to%20book%20a%20ride." class="outline-btn outline-btn-white" target="_blank">Book now</a>
                </div>
              </article>
              <!-- ✅ Modal Popup -->
              <div class="modal fade" id="<?php echo $modalId; ?>" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                  <div class="modal-content" style="border-radius: 12px; overflow: hidden">
                    <div class="modal-header" style="background: #f9ab30; color: #fff">
                      <h5 class="modal-title"><?php echo $row['title']; ?></h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="padding: 20px">
                      <?php echo $row['modal_content']; ?>
                    </div>
                    <div class="modal-footer" style="padding: 15px; border-top: 1px solid #eee">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <a href="https://wa.me/919823059704?text=Hi%20Safar%2C%20I%27d%20like%20to%20book%20a%20ride." class="btn btn-primary" target="_blank">Book Now</a>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
        <!-- ***package section html start form here*** -->
        <!-- ***client section html start form here*** -->
        <!-- <div
            class="client-section"
            style="background-image: url(assets/images/banner-img1.jpg)"
          >
            <div class="overlay"></div>
            <div class="container">
              <div class="row align-items-center">
                <div class="col-lg-6">
                  <article class="client-content">
                    <h5 class="sub-title">DISCOUNT OFFER</h5>
                    <h2 class="section-title">
                      GET SPECIAL DISCOUNT ON SIGN UP !
                    </h2>
                    <p>
                      Fusce hic augue velit wisi quibusdam pariatur, iusto
                      primis, nec nemo, rutrum. Vestibulum cumque laudantm sit.
                    </p>
                    <a href="contact" class="round-btn">Sign Up Now</a>
                  </article>
                </div>
                <div class="col-lg-6">
                  <div class="client-logo">
                    <ul>
                      <li>
                        <img src="assets/images/client-img1.png" alt="" />
                      </li>
                      <li>
                        <img src="assets/images/client-img2.png" alt="" />
                      </li>
                      <li>
                        <img src="assets/images/client-img3.png" alt="" />
                      </li>
                      <li>
                        <img src="assets/images/client-img4.png" alt="" />
                      </li>
                      <li>
                        <img src="assets/images/client-img5.png" alt="" />
                      </li>
                      <li>
                        <img src="assets/images/client-img6.png" alt="" />
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div> -->
        <!-- ***clinet section html end here*** -->
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
  <script src="assets/js/custom.js"></script>
  <script src="assets/js/animation.js"></script>
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
          window.location.href = 'package';
        });
      } else if (status === 'email_exists') {
        Swal.fire({
          icon: 'error',
          title: 'Oops!',
          text: 'You have already given feedback with this email.',
          confirmButtonColor: '#ff6f00'
        }).then(() => {
          window.location.href = 'package';
        });
      } else if (status === 'missing_fields') {
        Swal.fire({
          icon: 'warning',
          title: 'Incomplete!',
          text: 'Please fill all required fields.',
          confirmButtonColor: '#ff6f00'
        }).then(() => {
          window.location.href = 'package';
        });
      }
    });
  </script>
</body>

</html>