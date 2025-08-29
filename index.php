<?php
session_start();
include("config.php");

$seo_query = mysqli_query($con, "SELECT * FROM seo_settings WHERE page_type='home' LIMIT 1");
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

<body class="home">
  <div id="siteLoader" class="site-loader">
    <div class="preloader-content">
      <img src="assets/images/loader1.gif" alt="" />
      <!-- <div class="loading-text">Loading Safar...</div> -->
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
                  <h5 class="header-contact-no">+91 9823059704</h5>
                </div>
              </a>
            </div>
            <div class="site-logo text-center">
              <h1 class="site-title">
                <a href="index">
                  <img
                    src="assets/images/Safar_Logo_White-removebg-preview.png"
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
                  <li class="menu-active">
                    <a href="index">Home</a>
                  </li>
                  <li>
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
    <main id="content" class="site-main">
      <!-- ***home banner html start form here*** -->
      <section class="home-banner-section home-banner-slider">
        <!-- Slide 1 -->
        <div
          class="home-banner d-flex flex-wrap align-items-center"
          style="
              background-image: url(assets/images/SAFAR\ HOME\ BANNER\ 1.png);
            ">
          <div class="container"></div>
        </div>
        <!-- Slide 2 -->
        <div
          class="home-banner d-flex flex-wrap align-items-center"
          style="
              background-image: url(assets/images/SAFAR\ HOME\ BANNER\ 2.png);
            ">
          <div class="container"></div>
        </div>
        <!-- Slide 3 -->
        <div
          class="home-banner d-flex flex-wrap align-items-center"
          style="
              background-image: url(assets/images/SAFAR\ HOME\ BANNER\ 3.png);
            ">
          <div class="container"></div>
        </div>
      </section>
      <!-- ***home banner html end here*** -->
      <!-- ***Home search field html start from here*** -->
      <div class="home-trip-search primary-bg">
        <div class="decorative-car"></div>
        <div
          class="decorative-car"
          style="left: auto; right: 5%; transform: scaleX(-1)"></div>
        <div class="container">
          <div class="search-title-section text-center">
            <h2>Calculate My Safar</h2>
            <p>
              Plan your journey with ease and get instant price estimates for
              your travel needs
            </p>
          </div>
          <form id="safarForm" class="trip-search-inner d-flex">
            <!-- Pickup Location -->
            <div class="group-input">
              <label>Pick-up Location*</label>
              <input
                type="text"
                id="pickup"
                placeholder="e.g., Nashik"
                required />
            </div>

            <!-- Drop Location -->
            <div class="group-input">
              <label>Drop Location*</label>
              <input
                type="text"
                id="drop"
                placeholder="e.g., Pune"
                required />
            </div>

            <!-- Trip Dates -->
            <div class="group-input">
              <label>Start Date*</label>
              <i class="far fa-calendar"></i>
              <input
                class="input-date-picker"
                type="text"
                id="startDate"
                name="s"
                placeholder="DD / MM / YY"
                autocomplete="off"
                readonly="readonly" />
            </div>

            <div class="group-input">
              <label>End Date*</label>
              <i class="far fa-calendar"></i>
              <input
                class="input-date-picker"
                type="text"
                id="endDate"
                name="s"
                placeholder="DD / MM / YY"
                autocomplete="off"
                readonly="readonly" />
            </div>

            <!-- Trip Type and Passengers -->
            <div class="group-input">
              <label>Trip Type*</label>
              <select id="tripType" required>
                <option value="single">One Way</option>
                <option value="round">Round Trip</option>
              </select>
            </div>

            <div class="group-input">
              <label>Passengers*</label>
              <input
                type="number"
                id="persons"
                min="1"
                max="24"
                placeholder="No. of People"
                required />
            </div>

            <div class="group-input">
              <input type="submit" value="CALCULATE PRICE" />
            </div>
          </form>
        </div>

        <!-- Vehicle Selection (hidden by default) -->
        <div
          class="container mt-4"
          id="vehicleSelection"
          style="display: none">
          <div class="row">
            <div class="col-12">
              <h4 class="text-white mb-3">Select Vehicle Type</h4>
              <div class="car-selector" id="carSelector"></div>
            </div>
          </div>
        </div>

        <!-- Results Section (hidden by default) -->
        <div class="container mt-4" id="result" style="display: none">
          <div class="row">
            <div class="col-md-6">
              <div class="card result-card">
                <div class="card-header text-white">
                  <h5 class="mb-0 text-white">
                    <i class="fas fa-route text-white"></i> Journey Details
                  </h5>
                </div>
                <div class="card-body" id="journeyDetails">
                  <!-- Details will be populated by JavaScript -->
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card result-card">
                <div class="card-header text-white">
                  <h5 class="mb-0 text-white">
                    <i class="fas fa-tag text-white"></i> Estimated Price
                  </h5>
                </div>
                <div class="card-body text-center">
                  <h3 id="priceDisplay" class="display-4"></h3>
                  <button class="whatsapp-btn" id="whatsappBookBtn">
                    <i class="fab fa-whatsapp"></i> Book on WhatsApp
                  </button>
                  <div class="disclaimer mt-3">
                    <i class="fas fa-exclamation-circle"></i>
                    <strong>Note:</strong> Extra charges like toll, parking,
                    driver allowance, permit, and state taxes will be added
                    separately if applicable.
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- ***search search field html end here*** -->

      <!--service section-->
      <div class="inner-service-wrap home-destination">
        <div class="container">
          <div class="row">
            <div class="col-lg-8 offset-lg-2 text-sm-center">
              <div class="section-heading">
                <h5 class="sub-title">WHAT WE OFFER</h5>
                <h2 class="section-title">On-Time Service</h2>
                <p>
                  From daily travel to customized tours, we ensure on-time
                  rides, comfortable vehicles, and trusted drivers for all
                  your needs.
                </p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-4 col-sm-6">
              <div
                class="icon-box bg-img-box"
                style="background-image: url(assets/images/img4.jpg)">
                <div class="box-icon">
                  <i class="fas fa-hotel"></i>
                </div>
                <div class="icon-box-content">
                  <h3>DAILY PICK & DROP</h3>
                  <p>
                    Convenient and reliable rides for school, office, or
                    personal travel – always on time, every time.
                  </p>
                  <!-- <a href="#" class="round-btn">Learn More</a> -->
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-sm-6">
              <div
                class="icon-box bg-img-box"
                style="background-image: url(assets/images/img17.jpg)">
                <div class="box-icon">
                  <i class="fas fa-bus"></i>
                </div>
                <div class="icon-box-content">
                  <h3>OUTSTATION TRIPS</h3>
                  <p>
                    Affordable and safe long-distance travel for vacations,
                    family functions, and weekend getaways.
                  </p>
                  <!-- <a href="#" class="round-btn">Learn More</a>   -->
                </div>
              </div>
            </div>

            <div class="col-lg-4 col-sm-6">
              <div
                class="icon-box bg-img-box"
                style="background-image: url(assets/images/img12.jpg)">
                <div class="box-icon">
                  <i class="fas fa-store"></i>
                </div>
                <div class="icon-box-content">
                  <h3>CORPORATE TRAVEL</h3>
                  <p>
                    Professional transport solutions for business meetings,
                    staff pick-up & drop, and client transfers.
                  </p>
                  <!-- <a href="#" class="round-btn">Learn More</a>   -->
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-sm-6">
              <div
                class="icon-box bg-img-box"
                style="background-image: url(assets/images/img13.jpg)">
                <div class="box-icon">
                  <i class="fas fa-file-alt"></i>
                </div>
                <div class="icon-box-content">
                  <h3>CITY TOURS</h3>
                  <p>
                    Explore your city’s attractions with guided tours and
                    comfortable vehicles for families & groups.
                  </p>
                  <!-- <a href="#" class="round-btn">Learn More</a>   -->
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-sm-6">
              <div
                class="icon-box bg-img-box"
                style="background-image: url(assets/images/img28.jpg)">
                <div class="box-icon">
                  <i class="fas fa-plane-departure"></i>
                </div>
                <div class="icon-box-content">
                  <h3>AIRPORT TRANSFERS</h3>
                  <p>
                    Hassle-free airport pick-up & drop with punctual drivers
                    and comfortable rides – never miss a flight.
                  </p>
                  <!-- <a href="#" class="round-btn">Learn More</a>   -->
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-sm-6">
              <div
                class="icon-box bg-img-box"
                style="background-image: url(assets/images/img10.jpg)">
                <div class="box-icon">
                  <i class="fas fa-headset"></i>
                </div>
                <div class="icon-box-content">
                  <h3>CUSTOMIZED TOUR PACKAGES</h3>
                  <p>
                    Plan your own journey with tailor-made tour packages that
                    suit your budget and travel needs.
                  </p>
                  <!-- <a href="#" class="round-btn">Learn More</a>   -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- ***service section end here*** -->

      <!-- ***Home package html start from here*** -->
      <section class="home-package mt-5">
        <div class="container">
          <div class="row">
            <div class="col-lg-8 offset-lg-2 text-sm-center">
              <div class="section-heading">
                <h5 class="sub-title">POPULAR PACKAGES</h5>
                <h2 class="section-title">CHECKOUT OUR PACKAGES</h2>
                <p>
                  Discover exciting destinations with Safar’s carefully
                  planned trips – from weekend getaways to long adventures.
                </p>
              </div>
            </div>
          </div>
          <div class="package-section">
            <article class="package-item">
              <figure
                class="package-image"
                style="
                    background-image: url('assets/images/Package\ Tour\ 1.png');
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
                    data-bs-target="#packageModal">
                    MAHABALESHWAR WEEKEND GETAWAY
                  </a>
                </h3>
                <p>
                  Escape the city and enjoy cool weather, strawberry farms,
                  and scenic viewpoints. Perfect for families and friends
                  looking for a short, refreshing trip.
                </p>
                <div class="package-meta">
                  <ul>
                    <li>
                      <i class="fas fa-clock"></i>
                      2D/1N
                    </li>
                    <li>
                      <i class="fas fa-user-friends"></i>
                      pax: 6
                    </li>
                    <li>
                      <i class="fas fa-map-marker-alt"></i>
                      Mahabaleshwar
                    </li>
                  </ul>
                </div>
                <!-- ✅ PDF Download Button -->
                <div class="package-meta">
                  <a href="assets/pdfs/mahabaleshwar.pdf" download>
                    <i class="fas fa-file-pdf"></i> Download Itinerary
                  </a>
                </div>
              </div>
              <div class="package-price">
                <div class="review-area">
                  <!-- <span class="review-text">(25 reviews)</span> -->
                  <div class="rating-start-wrap d-inline-block">
                    <div class="rating-start">
                      <span style="width: 80%"></span>
                    </div>
                  </div>
                </div>
                <h6 class="price-list">
                  <span>₹750</span>
                  / per person
                </h6>

                <div class="trip-start-label">Let's Start your trip</div>
                <a href="#" class="outline-btn outline-btn-white">Book now</a>
              </div>
            </article>
            <!-- ✅ Modal Popup -->
            <div class="modal fade" id="packageModal" tabindex="-1">
              <div class="modal-dialog modal-lg modal-dialog-centered">
                <div
                  class="modal-content"
                  style="border-radius: 12px; overflow: hidden">
                  <div
                    class="modal-header"
                    style="background: #f9ab30; color: #fff">
                    <h5 class="modal-title">Mahabaleshwar Weekend Getaway</h5>
                    <button
                      type="button"
                      class="btn-close"
                      data-bs-dismiss="modal"
                      aria-label="Close"></button>
                  </div>
                  <div class="modal-body" style="padding: 20px">
                    <p>
                      🌿 Escape to the hills of Mahabaleshwar for a refreshing
                      weekend getaway. Enjoy strawberry picking, scenic
                      viewpoints, boating at Venna Lake, and the cool mountain
                      breeze.
                    </p>
                    <ul>
                      <li>Duration: 2 Days / 1 Night</li>
                      <li>Inclusions: Stay, Meals, Sightseeing</li>
                      <li>Best Season: October – June</li>
                    </ul>
                  </div>
                  <div
                    class="modal-footer"
                    style="padding: 15px; border-top: 1px solid #eee">
                    <button
                      type="button"
                      class="btn btn-secondary"
                      data-bs-dismiss="modal">
                      Close
                    </button>
                    <a href="#" class="btn btn-primary">Book Now</a>
                  </div>
                </div>
              </div>
            </div>
            <article class="package-item">
              <figure
                class="package-image"
                style="
                    background-image: url(assets/images/Package\ Tour\ 2.png);
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
                  <a href="package"> GOA BEACH HOLIDAY </a>
                </h3>
                <p>
                  Relax on sandy beaches, explore vibrant nightlife, and enjoy
                  water sports. A perfect blend of adventure and leisure for
                  groups and couples.
                </p>
                <div class="package-meta">
                  <ul>
                    <li>
                      <i class="fas fa-clock"></i>
                      5D/4N
                    </li>
                    <li>
                      <i class="fas fa-user-friends"></i>
                      pax: 12
                    </li>
                    <li>
                      <i class="fas fa-map-marker-alt"></i>
                      Goa
                    </li>
                  </ul>
                </div>
                <!-- PDF Download Button -->
                <div class="package-meta">
                  <a href="assets/pdfs/goa.pdf" download>
                    <i class="fas fa-file-pdf"></i> Download Itinerary
                  </a>
                </div>
              </div>
              <div class="package-price">
                <div class="review-area">
                  <!-- <span class="review-text">(12 reviews)</span> -->
                  <div class="rating-start-wrap d-inline-block">
                    <div class="rating-start">
                      <span style="width: 80%"></span>
                    </div>
                  </div>
                </div>
                <h6 class="price-list">
                  <span>₹5200</span>
                  / per person
                </h6>
                <div class="trip-start-label">Let's Start your trip</div>
                <a href="#" class="outline-btn outline-btn-white">Book now</a>
              </div>
            </article>
            <article class="package-item">
              <figure
                class="package-image"
                style="
                    background-image: url(assets/images/Package\ Tour\ 3.png);
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
                  <a href="package">
                    SHIRDI & SHANI SHINGNAPUR PILGRIMAGE TOUR
                  </a>
                </h3>
                <p>
                  A soulful journey to the holy towns of Shirdi and Shani
                  Shingnapur, including temple visits and peaceful stays for a
                  divine experience.
                </p>
                <div class="package-meta">
                  <ul>
                    <li>
                      <i class="fas fa-clock"></i>
                      2D/1N
                    </li>
                    <li>
                      <i class="fas fa-user-friends"></i>
                      pax: 10
                    </li>
                    <li>
                      <i class="fas fa-map-marker-alt"></i>
                      Shirdi
                    </li>
                  </ul>
                </div>
                <!-- PDF Download Button -->
                <div class="package-meta">
                  <a href="assets/pdfs/shirdi.pdf" download>
                    <i class="fas fa-file-pdf"></i> Download Itinerary
                  </a>
                </div>
              </div>
              <div class="package-price">
                <div class="review-area">
                  <!-- <span class="review-text">(43 reviews)</span> -->
                  <div class="rating-start-wrap d-inline-block">
                    <div class="rating-start">
                      <span style="width: 80%"></span>
                    </div>
                  </div>
                </div>
                <h6 class="price-list">
                  <span>₹660</span>
                  / per person
                </h6>
                <div class="trip-start-label">Let's Start your trip</div>
                <a href="#" class="outline-btn outline-btn-white">Book now</a>
              </div>
            </article>
            <div class="section-btn-wrap text-center">
              <a href="package" class="round-btn">VIEW ALL PACKAGES</a>
            </div>
          </div>
        </div>
      </section>
      <!-- ***Home package html end here*** -->
      <!-- ***Home callback html start from here*** -->
      <section
        class="home-callback bg-img-fullcallback"
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
                  from daily rides to unforgettable tours. Safe, reliable, and
                  affordable travel made just for you.
                </p>
                <div class="callback-btn">
                  <a href="package" class="round-btn">View Packages</a>
                  <a href="about" class="round-btn">Learn More</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- ***Home callback html end here*** -->
      <!-- ***Home counter html start from here*** -->
      <div class="home-counter">
        <div class="container">
          <div class="counter-wrap">
            <div class="counter-item">
              <span class="counter-no">
                <span class="counter">50</span>K+
              </span>
              <span class="counter-desc"> SUCCESSFUL RIDES </span>
            </div>
            <div class="counter-item">
              <span class="counter-no">
                <span class="counter">100</span>+
              </span>
              <span class="counter-desc"> CITIES COVERED </span>
            </div>
            <div class="counter-item">
              <span class="counter-no">
                <span class="counter">24</span>/7
              </span>
              <span class="counter-desc"> CUSTOMER SUPPORT </span>
            </div>
            <div class="counter-item">
              <span class="counter-no">
                <span class="counter">99</span>%
              </span>
              <span class="counter-desc"> ON-TIME SERVICE </span>
            </div>
          </div>
        </div>
      </div>
      <!-- ***Home counter html end here*** -->
      <!-- ***Home offer html start from here*** -->
      <section class="home-offer">
        <div class="container">
          <div class="row">
            <div class="col-lg-8 offset-lg-2 text-sm-center">
              <div class="section-heading">
                <h5 class="sub-title">OFFER & DISCOUNT</h5>
                <h2 class="section-title">OUR SPECIAL PACKAGES</h2>
                <p>
                  Make your journeys extra memorable with Safar’s handpicked
                  special packages. Designed for families, friends, and solo
                  travellers, these tours combine comfort, adventure, and
                  unique experiences you won’t forget.
                </p>
              </div>
            </div>
          </div>
          <div class="offer-section">
            <div class="row">
              <div class="col-md-6">
                <article
                  class="offer-item"
                  style="background-image: url(assets/images/img8.jpg)">
                  <div class="offer-badge">UPTO <span>25%</span> off</div>
                  <div class="offer-content">
                    <div class="package-meta">
                      <ul>
                        <li>
                          <i class="fas fa-clock"></i>
                          7D/6N
                        </li>
                        <li>
                          <i class="fas fa-user-friends"></i>
                          pax: 10
                        </li>
                        <li>
                          <i class="fas fa-map-marker-alt"></i>
                          Goa
                        </li>
                      </ul>
                    </div>
                    <h3>
                      <a href="package">GOA SPECIAL ESCAPE</a>
                    </h3>
                    <p>
                      Enjoy sandy beaches, vibrant nightlife, and thrilling
                      water sports. A perfect mix of fun, relaxation, and
                      adventure.
                    </p>
                    <div class="price-list">
                      price:
                      <del>₹1300 </del>
                      <ins>₹1105</ins>
                    </div>
                    <a href="#" class="round-btn">Book Now</a>
                  </div>
                </article>
              </div>
              <div class="col-md-6">
                <article
                  class="offer-item"
                  style="background-image: url(assets/images/img9.jpg)">
                  <div class="offer-badge">UPTO <span>17%</span> off</div>
                  <div class="offer-content">
                    <div class="package-meta">
                      <ul>
                        <li>
                          <i class="fas fa-clock"></i>
                          5D/4N
                        </li>
                        <li>
                          <i class="fas fa-user-friends"></i>
                          pax: 10
                        </li>
                        <li>
                          <i class="fas fa-map-marker-alt"></i>
                          Nashik
                        </li>
                      </ul>
                    </div>
                    <h3>
                      <a href="package">NASHIK PILGRIMAGE & WINE TOUR</a>
                    </h3>
                    <p>
                      A soulful journey to Trimbakeshwar temple followed by a
                      relaxing vineyard experience in Nashik.
                    </p>
                    <div class="price-list">
                      price:
                      <del>₹1100 </del>
                      <ins>₹900</ins>
                    </div>
                    <a href="#" class="round-btn">Book Now</a>
                  </div>
                </article>
              </div>
            </div>
            <div class="section-btn-wrap text-center">
              <a href="package" class="round-btn">VIEW ALL PACKAGES</a>
            </div>
          </div>
        </div>
      </section>
      <!-- ***Home offer html end here*** -->


      <!-- ***Home testimonial html start from here*** -->
      <section class="home-testimonial">
        <div class="container">
          <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
              <div class="section-heading">
                <h5 class="sub-title">CLIENT'S REVIEWS</h5>
                <h2 class="section-title">TRAVELLER'S TESTIMONIAL</h2>
                <p>
                  Hear from our happy customers who trusted Safar for their
                  pick & drop services, airport transfers, and unforgettable
                  tours. Real experiences. Real journeys. Real smiles.
                </p>
              </div>
            </div>
          </div>
          <div class="testimonial-section testimonial-slider">
            <div class="testimonial-item">
              <div class="testimonial-content">
                <div class="rating-start-wrap">
                  <div class="rating-start">
                    <span style="width: 80%"></span>
                  </div>
                </div>
                <p>
                  Very reliable daily pick & drop service. They are always on
                  time and I never have to worry about delays. Great
                  experience!
                </p>
                <div class="author-content">
                  <!-- <figure class="testimonial-img">
                      <img src="assets/images/img18.jpg" alt="" />
                    </figure> -->
                  <div class="author-name">
                    <h5>MAHESH SONAWANE</h5>
                    <span>TRAVELLERS</span>
                  </div>
                </div>
                <div class="testimonial-icon">
                  <i aria-hidden="true" class="fas fa-quote-left"></i>
                </div>
              </div>
            </div>
            <div class="testimonial-item">
              <div class="testimonial-content">
                <div class="rating-start-wrap">
                  <div class="rating-start">
                    <span style="width: 80%"></span>
                  </div>
                </div>
                <p>
                  Our family city tour was perfectly organized by Safar. The
                  driver knew all the best spots and made the trip enjoyable
                  for everyone.
                </p>
                <div class="author-content">
                  <!-- <figure class="testimonial-img">
                      <img src="assets/images/img19.jpg" alt="" />
                    </figure> -->
                  <div class="author-name">
                    <h5>MADHURI GANDHE</h5>
                    <span>TRAVELLERS</span>
                  </div>
                </div>
                <div class="testimonial-icon">
                  <i aria-hidden="true" class="fas fa-quote-left"></i>
                </div>
              </div>
            </div>
            <div class="testimonial-item">
              <div class="testimonial-content">
                <div class="rating-start-wrap">
                  <div class="rating-start">
                    <span style="width: 80%"></span>
                  </div>
                </div>
                <p>
                  I booked an outstation trip with Safar and it was the best
                  decision. Clean car, safe driving, and affordable rates.
                  Will definitely travel again!
                </p>
                <div class="author-content">
                  <!-- <figure class="testimonial-img">
                      <img src="assets/images/img20.jpg" alt="" />
                    </figure> -->
                  <div class="author-name">
                    <h5>SHASHANK DEODHAR</h5>
                    <span>TRAVELLERS</span>
                  </div>
                </div>
                <div class="testimonial-icon">
                  <i aria-hidden="true" class="fas fa-quote-left"></i>
                </div>
              </div>
            </div>
            <div class="testimonial-item">
              <div class="testimonial-content">
                <div class="rating-start-wrap">
                  <div class="rating-start">
                    <span style="width: 80%"></span>
                  </div>
                </div>
                <p>
                  Safar made my airport transfer stress-free. The driver was
                  punctual, polite, and the ride was super comfortable. Highly
                  recommended!
                </p>
                <div class="author-content">
                  <!-- <figure class="testimonial-img">
                      <img src="assets/images/img19.jpg" alt="" />
                    </figure> -->
                  <div class="author-name">
                    <h5>NILESH SAMBAREKAR</h5>
                    <span>TRAVELLERS</span>
                  </div>
                </div>
                <div class="testimonial-icon">
                  <i aria-hidden="true" class="fas fa-quote-left"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- ***Home testimonial html end here*** -->
      <!-- ***Home callback html start from here*** -->
      <section
        class="home-callback bg-color-callback home-trip-search primary-bg">
        <div class="decorative-car"></div>
        <div
          class="decorative-car"
          style="left: auto; right: 5%; transform: scaleX(-1)"></div>
        <div class="container">
          <div class="row align-items-center">
            <div class="col-md-8">
              <h5 class="sub-title">CALL TO ACTION</h5>
              <h2 class="section-title">
                READY FOR AN UNFORGETTABLE JOURNEY? CHOOSE SAFAR!
              </h2>
              <p>
                Experience safe, reliable, and comfortable pick & drop
                services, airport transfers, and customized tours with Safar –
                your trusted travel partner. Book your ride today and make
                every journey memorable with us!
              </p>
            </div>
            <div class="col-md-4 text-md-end">
              <a href="contact" class="outline-btn outline-btn-white">Contact Us !</a>
            </div>
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
      <!-- ***Home callback html end here*** -->
    </main>
    <!-- ***site footer html start form here*** -->
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
                        src="assets/images/Safar_Logo_White-removebg-preview.png"
                        style="mix-blend-mode: color-burn"
                        alt="Safar Logo"
                        class="img-fluid" />
                    </a>
                  </div>
                  <div class="textwidget widget-text">
                    <p>
                      At Safar, we make travel simple, safe, and stress-free.
                      From daily pick & drop services and airport transfers to
                      city tours, outstation trips, and customized tour
                      packages, we provide reliable and affordable travel
                      solutions for every need.
                    </p>
                  </div>
                  <div class="header-social footer-social-icons">
                    <a
                      href="https://www.facebook.com/"
                      target="_blank"
                      class="social-icons">
                      <i class="fab fa-facebook-f" aria-hidden="true"></i>
                    </a>
                    <!-- <a href="https://www.twitter.com/" target="_blank" class="social-icons">
                        <i class="fab fa-twitter" aria-hidden="true"></i>
                      </a> -->
                    <a
                      href="https://www.instagram.com/"
                      target="_blank"
                      class="social-icons">
                      <i class="fab fa-instagram" aria-hidden="true"></i>
                    </a>
                    <a
                      href="https://www.linkedin.com/"
                      target="_blank"
                      class="social-icons">
                      <i class="fab fa-linkedin" aria-hidden="true"></i>
                    </a>
                    <a
                      href="https://www.youtube.com/"
                      target="_blank"
                      class="social-icons">
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
                          <img
                            src="assets/images/img21.jpg"
                            alt="Peaceful Places"
                            class="img-fluid rounded" />
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
                          <img
                            src="assets/images/img22.jpg"
                            alt="Travel with Friends"
                            class="img-fluid rounded" />
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
                            <i
                              aria-hidden="true"
                              class="fas fa-phone-alt"></i>
                          </div>
                          <div class="contact-text">
                            <span>Call Us</span>
                            +91 (982) 305 9704
                          </div>
                        </a>
                      </li>
                      <li>
                        <a
                          href="mailto:crushikesh74@gmail.com"
                          class="contact-item">
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
                          <i
                            aria-hidden="true"
                            class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-text">
                          <span>Visit Us</span>
                          Bunglow No 25 Shreeraj Society, HAL Colony Indira
                          Nagar, Nashik-422009
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
            <p>
              Copyright &copy; 2023 Safar. All rights reserved. | Designed
              with <i class="fas fa-heart"></i> for travelers
            </p>
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
  <script>
    const orsApiKey =
      "eyJvcmciOiI1YjNjZTM1OTc4NTExMTAwMDFjZjYyNDgiLCJpZCI6IjRlZTQ1ZjExMzI2NzRmMTE5YmUwMTMxZWVkNDkwODY4IiwiaCI6Im11cm11cjY0In0=";

    // Car data with all details
    let carData = [];

    async function loadVehicles() {
      try {
        const response = await fetch('get_vehicles.php');
        carData = await response.json();
        populateCarSelector();
      } catch (error) {
        console.error('Error loading vehicles:', error);
        // Fallback to empty array
        carData = [];
      }
    }

    document.addEventListener("DOMContentLoaded", function() {
      loadVehicles();
    });

    // Populate car selector
    function populateCarSelector() {
      const carSelector = document.getElementById("carSelector");
      carSelector.innerHTML = ""; // Clear existing options

      // Fuel type icons mapping
      const fuelIcons = {
        CNG: "fas fa-gas-pump",
        Petrol: "fas fa-gas-pump",
        Diesel: "fas fa-oil-can",
      };

      carData.forEach((car) => {
        const carOption = document.createElement("div");
        carOption.className = "car-option";
        carOption.dataset.carId = car.id;
        carOption.dataset.rate = car.rate;

        // Determine fuel badge class
        const fuelClass = `fuel-${car.fuel.toLowerCase()}`;

        carOption.innerHTML = `
        <div class="car-name">
          <i class="fas fa-car"></i>
          ${car.name}
          <span class="fuel-badge ${fuelClass}">${car.fuel}</span>
        </div>
        <div class="car-details">
          <span><i class="fas fa-users"></i> ${car.capacity}</span>
          <span><i class="fas fa-cogs"></i> ${car.fuel}</span>
        </div>
        <div class="car-price">
          ₹${car.rate} <small>/km</small>
        </div>
      `;
        carSelector.appendChild(carOption);
      });

      // Add click event to car options
      document.querySelectorAll(".car-option").forEach((option) => {
        option.addEventListener("click", function() {
          // Remove selection from all options
          document.querySelectorAll(".car-option").forEach((opt) => {
            opt.classList.remove("selected");
            opt.style.transform = "";
            opt.style.boxShadow = "0 4px 12px rgba(0,0,0,0.08)";
          });

          // Add selection to clicked option
          this.classList.add("selected");
          this.style.transform = "translateY(-5px)";
          this.style.boxShadow = "0 12px 24px rgba(67, 97, 238, 0.2)";

          // Get car details for calculation
          const carId = this.dataset.carId;
          const rate = parseFloat(this.dataset.rate);
          const carName = this.querySelector(".car-name").textContent.trim();
          const carCapacity =
            this.querySelector(".car-details span").textContent.trim();

          // Call your calculation function
          calculateJourney(carId, rate, carName, carCapacity);
        });
      });

      // Auto-select first car if needed
      // const firstCar = document.querySelector(".car-option");
      // if (firstCar) {
      //   setTimeout(() => {
      //     firstCar.click(); // Trigger click to select first car and calculate
      //   }, 300);
      // }
    }

    async function getCoordinates(place) {
      const url = `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(
          place
        )}&format=json&limit=1`;
      const response = await fetch(url);
      const data = await response.json();
      if (data.length === 0) throw new Error(`Location not found: ${place}`);
      return [parseFloat(data[0].lon), parseFloat(data[0].lat)];
    }

    async function getDistance(fromCoords, toCoords) {
      const url =
        "https://api.openrouteservice.org/v2/directions/driving-car/geojson";
      const response = await fetch(url, {
        method: "POST",
        headers: {
          Authorization: orsApiKey,
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          coordinates: [fromCoords, toCoords],
        }),
      });
      const data = await response.json();
      const distanceInMeters = data.features[0].properties.summary.distance;
      return distanceInMeters / 1000;
    }

    // Format date for display
    function formatDate(dateString) {
      const options = {
        weekday: "short",
        year: "numeric",
        month: "short",
        day: "numeric",
      };
      return new Date(dateString).toLocaleDateString("en-US", options);
    }

    // Capitalize first letter of a string
    function capitalizeFirstLetter(string) {
      if (!string) return string;
      return string.charAt(0).toUpperCase() + string.slice(1);
    }

    // Initialize the page
    document.addEventListener("DOMContentLoaded", function() {
      // Initialize datepickers
      $(".input-date-picker").datepicker({
        dateFormat: "mm/dd/yy", // Matches your placeholder format
        minDate: 0, // Disable all previous dates
        beforeShowDay: function(date) {
          // Optional: Add custom class to today's date
          if (
            date.getDate() === new Date().getDate() &&
            date.getMonth() === new Date().getMonth() &&
            date.getFullYear() === new Date().getFullYear()
          ) {
            return [true, "today-date"];
          }
          return [true, ""];
        },
      });

      // Set default dates
      const today = new Date();
      const tomorrow = new Date(today);
      tomorrow.setDate(tomorrow.getDate() + 1);

      function formatDate(date) {
        const month = (date.getMonth() + 1).toString().padStart(2, "0");
        const day = date.getDate().toString().padStart(2, "0");
        const year = date.getFullYear().toString().slice(-2);
        return `${month}/${day}/${year}`;
      }

      // Set initial values
      $("#startDate").datepicker("setDate", today);
      $("#endDate").datepicker("setDate", today);

      // Function to toggle endDate field based on trip type
      function toggleEndDateField() {
        const tripType = $("#tripType").val();
        const endDateField = $("#endDate");
        const endDateContainer = endDateField.closest(".group-input");

        if (tripType === "single") {
          // Disable end date for one-way trips
          endDateField.prop("disabled", true);
          endDateContainer.addClass("disabled-date-field");
        } else {
          // Enable end date for round trips
          endDateField.prop("disabled", false);
          endDateContainer.removeClass("disabled-date-field");
        }
      }

      // Initialize end date field state based on default trip type
      toggleEndDateField();

      // Listen for trip type changes
      $("#tripType").on("change", function() {
        toggleEndDateField();
      });

      // Update end date constraints when start date changes
      $("#startDate").on("change", function() {
        const startDate = $(this).datepicker("getDate");
        $("#endDate").datepicker("option", "minDate", startDate);

        // If end date is before start date, adjust it
        const endDate = $("#endDate").datepicker("getDate");
        if (endDate < startDate) {
          const nextDay = new Date(startDate);
          nextDay.setDate(nextDay.getDate() + 1);
          $("#endDate").datepicker("setDate", nextDay);
        }
      });

      // Capitalize first letter of location inputs
      const pickupInput = document.getElementById("pickup");
      const dropInput = document.getElementById("drop");

      pickupInput.addEventListener("input", function() {
        this.value = capitalizeFirstLetter(this.value);
      });

      dropInput.addEventListener("input", function() {
        this.value = capitalizeFirstLetter(this.value);
      });
    });

    // Form submission handler
    document
      .getElementById("safarForm")
      .addEventListener("submit", async function(e) {
        e.preventDefault();

        const pickup = capitalizeFirstLetter(
          document.getElementById("pickup").value
        );
        const drop = capitalizeFirstLetter(
          document.getElementById("drop").value
        );
        const tripType = document.getElementById("tripType").value;
        const persons = parseInt(document.getElementById("persons").value);
        const startDate = document.getElementById("startDate").value;
        const endDate = document.getElementById("endDate").value;

        // Show vehicle selection
        populateCarSelector();
        document.getElementById("vehicleSelection").style.display = "block";
        document.getElementById("result").style.display = "none";

        // Scroll to vehicle selection
        document
          .getElementById("vehicleSelection")
          .scrollIntoView({
            behavior: "smooth"
          });

        // Add event listener for vehicle selection
        document
          .getElementById("carSelector")
          .addEventListener("click", async function() {
            // Get selected car
            const selectedCar = document.querySelector(
              ".car-option.selected"
            );
            if (!selectedCar) {
              alert("Please select a vehicle");
              return;
            }

            const carId = selectedCar.dataset.carId;
            const rate = parseFloat(selectedCar.dataset.rate);
            const carName =
              selectedCar.querySelector(".car-name").textContent;
            const carCapacity = selectedCar
              .querySelector(".car-details span")
              .textContent.trim();

            const resultDiv = document.getElementById("result");
            const journeyDetailsDiv =
              document.getElementById("journeyDetails");
            const priceDisplay = document.getElementById("priceDisplay");

            // Show loading state
            resultDiv.style.display = "block";
            journeyDetailsDiv.innerHTML = `<div class="text-center py-4"><div class="spinner-border text-primary"></div><p class="mt-2">Calculating your journey...</p></div>`;

            try {
              const fromCoords = await getCoordinates(pickup);
              const toCoords = await getCoordinates(drop);

              let distance = await getDistance(fromCoords, toCoords);
              // Round off the distance first
              distance = Math.round(distance);
              // console.log(`One-way distance: ${distance} km`);
              let tripTypeText = "One-way journey";

              if (tripType === "round") {
                distance *= 2;
                tripTypeText = "Round trip";
                // console.log(`Round trip distance: ${distance} km`);
              }

              // Calculate days
              const start = new Date(startDate);
              const end = new Date(endDate);
              const days = Math.max(
                1,
                Math.ceil((end - start) / (1000 * 60 * 60 * 24)) + 1
              );

              let finalDistance;
              let pricingExplanation = "";

              // Apply different calculation logic based on trip type and distance
              if (tripType === "single") {
                // SINGLE TRIP LOGIC
                if (distance >= 300) {
                  // For single trips over 300km: full distance + half return distance
                  finalDistance =
                    (distance + Math.round(distance * 0.5)) * days;
                  pricingExplanation = `Single trip (${distance} km) + 50% return (${Math.round(
                      distance * 0.5
                    )} km (${finalDistance} km))`;
                } else {
                  // Apply minimum 300km rule
                  finalDistance =
                    distance < 300 ? 300 * days : distance * days;
                  pricingExplanation =
                    distance < 300 ?
                    "Minimum billable distance is 300 km" :
                    "";
                }
              } else {
                // ROUND TRIP LOGIC (new daily km rules)
                const roundTripDistance = distance; // Calculate full round trip distance
                tripTypeText = "Round trip";
                // console.log(`Round trip distance: ${roundTripDistance} km`);

                // Apply minimum 300km rule for round trips
                const effectiveRoundTripDistance =
                  roundTripDistance < 300 ? 300 : roundTripDistance;

                if (days === 1) {
                  // Single day round trip - charge effective distance (with minimum 300km)
                  finalDistance = effectiveRoundTripDistance;
                  pricingExplanation =
                    roundTripDistance < 300 ?
                    "Round trip < 300km - minimum 300km charged" :
                    "Single day round trip - charged exact distance";
                } else {
                  // Multi-day round trip
                  const perDayKm = effectiveRoundTripDistance / days;

                  if (perDayKm > 300) {
                    // If daily average > 300km, charge actual distance (with minimum)
                    finalDistance = effectiveRoundTripDistance;
                    pricingExplanation = `Multi-day round trip (${days} days) - charged ${effectiveRoundTripDistance} km`;
                  } else {
                    // If daily average ≤ 300km, charge 300km per day
                    finalDistance = 300 * days;
                    pricingExplanation = `Multi-day round trip (${days} days) - charged 300km per day`;
                  }
                }
              }

              // Calculate total price based on distance and days
              const total = finalDistance * rate;
              // console.log(
              //   `Total price (${finalDistance} km × ₹${rate}): ₹${Math.round(
              //     total
              //   )}`
              // );
              // console.log(`Pricing logic: ${pricingExplanation}`);

              // Format dates
              const formattedStartDate = formatDate(startDate);
              const formattedEndDate = formatDate(endDate);

              priceDisplay.innerHTML = `₹${Math.round(total)}`;

              // Prepare pricing method explanation text
              let pricingNoteHTML = "";
              if (distance < 300) {
                pricingNoteHTML = `
                <div class="alert alert-info mt-3">
                  <small><i class="fas fa-info-circle me-1"></i>Minimum billable distance is 300 km.</small>
                </div>
              `;
              }

              journeyDetailsDiv.innerHTML = `
          <div class="detail-row">
            <span class="detail-label">Journey Type</span>
            <span class="detail-value">${tripTypeText}</span>
          </div>
          <div class="detail-row">
            <span class="detail-label">From</span>
            <span class="detail-value">${pickup}</span>
          </div>
          <div class="detail-row">
            <span class="detail-label">To</span>
            <span class="detail-value">${drop}</span>
          </div>
          <div class="detail-row">
            <span class="detail-label">Start Date</span>
            <span class="detail-value">${formattedStartDate}</span>
          </div>
          <div class="detail-row">
            <span class="detail-label">End Date</span>
            <span class="detail-value">${formattedEndDate}</span>
          </div>
          <div class="detail-row">
            <span class="detail-label">Duration</span>
            <span class="detail-value">${days} day${days > 1 ? "s" : ""}</span>
          </div>
          <div class="detail-row">
            <span class="detail-label">Distance</span>
            <span class="detail-value">${finalDistance} km</span>
          </div>
          <div class="detail-row">
            <span class="detail-label">Vehicle</span>
            <span class="detail-value">${carName}</span>
          </div>
          <div class="detail-row">
            <span class="detail-label">Rate</span>
            <span class="detail-value">₹${rate}/km</span>
          </div>
          <div class="detail-row">
            <span class="detail-label">Passengers</span>
            <span class="detail-value">${persons} person${
                  persons > 1 ? "s" : ""
                }</span>
          </div>
          ${pricingNoteHTML}
        `;

              // Scroll to results
              resultDiv.scrollIntoView({
                behavior: "smooth"
              });
            } catch (error) {
              journeyDetailsDiv.innerHTML = `<div class="alert alert-danger"><i class="fas fa-exclamation-triangle me-2"></i>${error.message}</div>`;
            }
          });
      });
    // WhatsApp Booking Functionality
    document
      .getElementById("whatsappBookBtn")
      .addEventListener("click", function() {
        // Get all journey details
        const pickup = document.getElementById("pickup").value;
        const drop = document.getElementById("drop").value;
        const tripType =
          document.getElementById("tripType").options[
            document.getElementById("tripType").selectedIndex
          ].text;
        const persons = document.getElementById("persons").value;
        const startDate = document.getElementById("startDate").value;
        const endDate = document.getElementById("endDate").value;
        const carName = document
          .querySelector(".car-option.selected .car-name")
          .textContent.trim();
        const price = document.getElementById("priceDisplay").textContent;

        // Format dates
        const formattedStartDate = new Date(startDate).toLocaleDateString(
          "en-IN"
        );
        const formattedEndDate = new Date(endDate).toLocaleDateString(
          "en-IN"
        );

        // Create WhatsApp message
        const message =
          `Hi, I'd like to book a cab:\n\n` +
          `*From: ${pickup}\n` +
          `*To: ${drop}\n` +
          `*Trip Type: ${tripType}\n` +
          `*Dates: ${formattedStartDate} to ${formattedEndDate}\n` +
          `*Passengers: ${persons}\n` +
          `*Vehicle: ${carName}\n` +
          `*Estimated Price: ${price}\n\n` +
          `Please confirm availability.`;

        // Encode for URL
        const encodedMessage = encodeURIComponent(message);

        // Replace with your WhatsApp number (with country code, remove +)
        const whatsappNumber = "919823059704";

        // Open WhatsApp
        window.open(
          `https://wa.me/${whatsappNumber}?text=${encodedMessage}`,
          "_blank"
        );
      });
  </script>
</body>

</html>