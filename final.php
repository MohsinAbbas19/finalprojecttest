<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Job Finder - Header</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="final.css">
</head>
<body>

<!-- Main Header -->
<header>
    <!-- First Navbar: Logo and Heading -->
    <div class="navbar-top">
        <div class="logo">
            <img src="looo.jpg" alt="Job Finder Logo"> <!-- Placeholder for the logo -->
            <h1>JOB FINDER</h1>

        </div>
    </div>

    <!-- Second Navbar: Search Bar and Icons -->
    <div class="navbar-middle">
        <!-- Search Bar -->
        <div class="search-bar">
            <input type="text" placeholder="Search for jobs, companies...">
            <button type="submit">Search</button>
        </div>
        <!-- Icons -->
        <i class="icon fas fa-user"></i>
        <i class="icon fas fa-bell"></i>
        <i class="icon fas fa-envelope"></i>
    </div>

    <!-- Third Navbar: Page Links -->
    <div class="navbar-bottom">
        <a href="#">Home</a>
        <a href="#">Jobs</a>
        <a href="#">Companies</a>
        <a href="#">Contact Us</a>
    </div>
</header>









<!-- Carousel -->
<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="img11.jpg" class="d-block w-100" alt="First slide">
        </div>
        <div class="carousel-item">
            <img src="img22.jpg" class="d-block w-100" alt="Second slide">
        </div>
        <div class="carousel-item">
            <img src="img33.jpg" class="d-block w-100" alt="Third slide">
        </div>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>

    <!-- Fixed Text Overlay -->
    <div class="carousel-caption-fixed">
        <h5>Jobboard Finder</h5>
        <p>The world's largest Job board search engine</p>
        <p>Find the most relevant international job boards</p>
        <p>Compare and find valuable and verified information</p>
        <p>Publish your job adverts in more than 200 countries</p>
        <p>Browse over 900+ partner job sites</p>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>



    















<div class="container mt-5">
    <div class="row">
        <?php
            // API request details
            $url = 'https://api.apijobs.dev/v1/job/search';
            $apiKey = 'a8a04eeabe295aa4fa9c04d673f302fc5aae8b3794db30db1b82c6dd16248ef6';  // Use your API key here
            
            // Data for the POST request (q and country are separate)
            $data = array('q' => '');
            $data['country'] = 'Pakistan'; // Use the same array

            // Set up HTTP context for POST request
            $options = array(
                'http' => array(
                    'header'  => "Content-type: application/json\r\n" .
                                 "apikey: $apiKey\r\n",
                    'method'  => 'POST',
                    'content' => json_encode($data)
                )
            );

            // Create context resource
            $context  = stream_context_create($options);

            // Send request to the API
            $result = file_get_contents($url, false, $context);

            // Check if request was successful
            if ($result === FALSE) {
                echo "<div class='alert alert-danger'>Failed to retrieve data from the API.</div>";
            } else {
                // Decode JSON response
                $jobs = json_decode($result, true);

                // Check if the 'hits' array exists
                if ($jobs['ok'] && isset($jobs['hits']) && is_array($jobs['hits'])) {
                    // Loop through each job and create a card with expandable details
                    foreach ($jobs['hits'] as $index => $job) {
                        // Ensure variables exist before using them
                        $title = isset($job['title']) ? htmlspecialchars($job['title']) : 'No title available';
                        $organization = isset($job['hiringOrganizationName']) ? htmlspecialchars($job['hiringOrganizationName']) : 'Unknown organization';

                        // Use country and region as location
                        $country = isset($job['country']) ? htmlspecialchars($job['country']) : 'Country not specified';
                        $region = isset($job['region']) ? htmlspecialchars($job['region']) : 'Region not specified';
                        $location = $country . ', ' . $region;

                        $description = isset($job['description']) ? htmlspecialchars($job['description']) : 'No description available';
                        $url = isset($job['url']) ? htmlspecialchars($job['url']) : '#';

                        echo "
                        <div class='col-12 col-sm-6 col-md-4 col-lg-3 mb-4'> <!-- Responsive col sizes -->
                            <div class='card custom-card h-100'> <!-- Added custom-card class -->
                                <div class='card-body'>
                                    <h5 class='card-title'>$title</h5>
                                    <h6 class='card-subtitle mb-2 text-muted'>$organization</h6>
                                    <p class='card-text'><strong>Location:</strong> $location</p>

                                    <!-- Collapse Button -->
                                    <p>
                                        <a class='btn btn-primary' data-bs-toggle='collapse' href='#collapseJob$index' role='button' aria-expanded='false' aria-controls='collapseJob$index'>
                                            View Details
                                        </a>
                                    </p>

                                    <!-- Collapsible Job Details -->
                                    <div class='collapse' id='collapseJob$index'>
                                        <div class='card card-body'>
                                            <p>" . nl2br($description) . "</p>
                                            <a href='$url' class='btn btn-success' target='_blank'>Apply Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>"; // Close col-12 col-md-6
                    }
                } else {
                    echo "<div class='alert alert-info'>No jobs found.</div>";
                }
            }
        ?>
    </div>
</div>













<!-- Footer Container -->
<div class="container">
    <footer>
      <!-- Social Media Section -->
      <section class="social-section">
        <div>
          <span>Get connected with us on social networks:</span>
        </div>
        <div>
          <a href="#"><i class="fab fa-facebook-f"></i> Facebook</a>
          <a href="#"><i class="fab fa-twitter"></i> Twitter</a>
          <a href="#"><i class="fab fa-google"></i> Google</a>
          <a href="#"><i class="fab fa-instagram"></i> Instagram</a>
          <a href="#"><i class="fab fa-linkedin"></i> LinkedIn</a>
          <a href="#"><i class="fab fa-github"></i> Github</a>
        </div>
      </section>



      <!-- Footer Content -->
      <section class="footer-content">
          <!-- Column 1 -->
          <div class="footer-column">
              <h6>Company name</h6>
              <hr>
              <p>
                Here you can use rows and columns to organize your footer content. Lorem ipsum dolor sit amet, consectetur adipisicing elit.
              </p>
          </div>

          <!-- Column 2 -->
          <div class="footer-column">
              <h6>Products</h6>
              <hr>
              <p><a href="#">MDBootstrap</a></p>
              <p><a href="#">MDWordPress</a></p>
              <p><a href="#">BrandFlow</a></p>
              <p><a href="#">Bootstrap Angular</a></p>
          </div>

          <!-- Column 3 -->
          <div class="footer-column">
              <h6>Useful links</h6>
              <hr>
              <p><a href="#">Your Account</a></p>
              <p><a href="#">Become an Affiliate</a></p>
              <p><a href="#">Shipping Rates</a></p>
              <p><a href="#">Help</a></p>
          </div>

          <!-- Column 4 -->
          <div class="footer-column contact-info">
              <h6>Contact</h6>
              <hr>
              <p><i class="fas fa-home"></i> New York, NY 10012, US</p>
              <p><i class="fas fa-envelope"></i> info@example.com</p>
              <p><i class="fas fa-phone"></i> + 01 234 567 88</p>
              <p><i class="fas fa-print"></i> + 01 234 567 89</p>
          </div>
      </section>

      <!-- Footer Bottom -->
      <div class="footer-bottom">
        © 2020 Copyright:
        <a href="https://mdbootstrap.com/">MDBootstrap.com</a>
      </div>
    </footer>
</div>

    


</body>
</html>
