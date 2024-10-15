<?php
session_start();
include_once ("class/mainclass.php");
$obj = new mainClass();
$allAnnouncement = $obj->show_announcement2();
$allEvent = $obj->show_eventsByMonth();
$allIt = $obj->show_allIt();
$allCs = $obj->show_allCs();
$allIs = $obj->show_allIs();
$allOrg = $obj->show_org();
$allMit = $obj->show_allMit();

$allItHeads = $obj->show_allItHeads();
$allCsHeads = $obj->show_allCsHeads();
$allIsHeads = $obj->show_allIsHeads();
$allMitHeads = $obj->show_allMitHeads();
$allDean = $obj->show_allDeanHeads();
$showfaqs = $obj->show_allFAQS();


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Modal Example</title>
    <!-- Bootstrap CSS -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/light-box.css">
    <link rel="stylesheet" href="css/owl-carousel.css">
    <link rel="stylesheet" href="css/templatemo-style.css">

    <!-- Modernizr for browser feature detection -->
    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    <style> 
    /* Styles for the backdrop */
#backdrop {
    position: fixed; /* Make backdrop cover the entire viewport */
    top: 0;
    left: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    background: rgba(0, 0, 0, 0.7); /* Semi-transparent black */
    display: none; /* Hidden by default */
    z-index: 999; /* On top of other elements */
}

#profileCard {
      display: none; /* Initially hidden */
      position: fixed; /* Fixed position */
      top: 50%; /* Center vertically */
      left: 50%; /* Center horizontally */
      transform: translate(-50%, -50%); /* Adjust position */
      z-index: 1000; /* Ensure it appears on top */
      background-color: white; /* Background color */
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Shadow for depth */
      border-radius: 10px; /* Rounded corners */
      overflow: hidden; /* Prevent overflow */
      width: 300px; /* Adjust width to fit the content */
      height: auto; /* Automatic height based on content */
      padding: 20px; /* Padding around content */
  }

  .card {
      width: 100%; /* Full width of the profile card */
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center; /* Center items */
      text-align: center; /* Center text */
  }

    .modal-body img {
    max-width: 150px; /* Set a max width for the image */
    height: 150px; /* Set a fixed height for a perfect circle */
    border-radius: 50%; /* Make the image circular */
    border: 2px solid #f0f0f0; /* Optional: Add a border around the image */
    object-fit: cover; /* Ensure the image covers the entire area */
    }
.org-chart {
    text-align: center;
    background-color: #f9f9f9; /* Light gray background */
    padding: 20px;
}

.level1, .level2, .level3 {
    display: flex;
    justify-content: center;
    margin-bottom: 30px;
}

/* Level 1 specific styling */
.level1 .member {
    background-color: #2e0f13; /* Deep pink for main level */
}

/* Level 2 specific styling */
.level2 {
    justify-content: space-around;
    margin-top: 50px;
}

.level2 .member {
    background-color: #2e0f13; /* Deep indigo for secondary levels */
}

/* Level 3 specific styling */
.level3 {
    justify-content: center; /* Center items for responsiveness */
    flex-wrap: wrap; /* Allow wrapping of items */
    margin-top: 50px;
    width: 90%;
    margin: 0 auto;
}

/* Member ovals */
.member {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    background-color: #2e0f13; /* Deep indigo for default */
    padding: 10px 20px;
    border-radius: 50px; /* Oval shape */
    max-width: 250px; /* Set a max width */
    height: 80px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2); /* Add shadow for depth */
    transition: background-color 0.3s, transform 0.2s;
    margin: 10px; /* Add margin for spacing between items */
    flex: 0 1 auto; /* Allow the flex item to be auto-sized */
}

/* Adjust member width for different item counts */
.level3 .member {
    flex: 0 1 calc(33.33% - 20px); /* 3 items per row with margin */
}

/* For 4 or fewer items, center them */
.level3 .member:nth-last-child(-n+4) {
    flex: 0 1 calc(50% - 20px); /* 2 items per row if 4 or fewer */
}

.level3 .member:nth-last-child(1) {
    flex: 0 1 100%; /* 1 item should take full width */
}

/* Hover effect for ovals */
.member:hover {
    background-color: #1E88E5; /* Lighter blue on hover */
    transform: scale(1.05); /* Slight scale on hover */
}

/* Image in the oval */
.member img {
    width: 50px;
    height: 50px;
    border-radius: 50%; /* Circle image */
    object-fit: cover;
    border: 2px solid #ffffff; /* White border for contrast */
    margin-right: 10px;
}

/* Text inside the oval */
.member p {
    color: #FFD700; /* Gold text for contrast */
    font-size: 12px; /* Smaller font size for readability */
    font-weight: bold;
    margin: 0;
    line-height: 1.2;
}

/* Active state for member */
.button-faculty-btn.active {
    background-color: #F06292; /* Light pink for active state */
}

/* Hover and focus effect for buttons */
.button-faculty-btn:hover,
.button-faculty-btn.active {
    background-color: #F06292;
    transform: scale(1.05);
}

.button-faculty-btn:focus {
    outline: none;
}

.faculty-image img {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #333;
    margin-bottom: 10px;
}

.faculty-info {
    padding: 15px;
    text-align: center;
}

.faculty-info h6 {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 5px;
}

.faculty-info a {
    font-size: 14px;
    color: #fff;
    display: block;
    margin-top: 5px;
}

    </style>
</head>
<body>

<div class="page-content">
    
<section id="campusorgs" class="content-section">
    <div class="section-heading text-center borderYellow">
        <!-- Optional Section Heading -->
    </div>
    <div class="section-content">
    <div class="org-chart">
        <div class="level1">
            <div class="member">
                <img src="uploaded/facultyUploaded/dawd_2.png" alt="Dean">
                <p><strong>Alvinson L. Guzman</strong><br>Dean</p>
            </div>
        </div>

        <div class="level2">
            <div class="member">
                <img src="uploaded/facultyUploaded/dawd_2.png" alt="Assistant Dean">
                <p><strong>Henry L. Cuello</strong><br>Assistant Dean</p>
            </div>
        </div>

        <div class="level3">
            <div class="member">
                <img src="uploaded/facultyUploaded/dawd_2.png" alt="College Clerk">
                <p><strong>Caroline Carmen</strong><br>College Clerk</p>
            </div>
            <div class="member">
                <img src="uploaded/facultyUploaded/dawd_2.png" alt="College Clerk">
                <p><strong>Jane Mae De Vene</strong><br>College Clerk</p>
            </div>
            <div class="member">
                <img src="uploaded/facultyUploaded/dawd_2.png" alt="Technical Assistant">
                <p><strong>Carlota Tupasuriano</strong><br>Technical Assistant</p>
            </div>
            <div class="member">
                <img src="uploaded/facultyUploaded/dawd_2.png" alt="College Secretary">
                <p><strong>Raymundo Punzalan</strong><br>College Secretary</p>
            </div>
        </div>
    </div>

    <div class="wrapper">
    <!-- Department Buttons -->
    <div class="fclty-div">
        <button type="button" class="button-faculty-btn active" data-tab="tab1">IT Department</button>
        <button type="button" class="button-faculty-btn" data-tab="tab2">IS Department</button>
        <button type="button" class="button-faculty-btn" data-tab="tab3">CS Department</button>
        <button type="button" class="button-faculty-btn" data-tab="tab4">MIT</button>
    </div>

    <!-- Tab Content -->
   <section id="first-tab-group" class="tabgroup">
    <!-- IT Department Tab -->
    <div id="tab1" class="org-chart">
        <div class="section-content">
            <!-- Campus Heads -->
            <h3>Campus Heads</h3>
            <div class="level1">
                <?php foreach ($allDean as $head): ?>
                    <div class="member">
                        <img src="uploaded/Heads/<?= htmlspecialchars($head['img']) ?>" alt="Dean">
                        <p><strong><?= htmlspecialchars($head['name']) ?></strong><br>Dean</p>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="level2">
                <?php foreach ($allItHeads as $head): ?>
                    <div class="member">
                        <img src="uploaded/Heads/<?= htmlspecialchars($head['img']) ?>" alt="IT Chair">
                        <p><strong><?= htmlspecialchars($head['name']) ?></strong><br>IT Chair Person</p>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Faculty Members -->
            <h3>Faculty Members</h3>
            <div class="level3">
                <?php foreach ($allIt as $row): ?>
                    <div class="member" 
                         data-name="<?= htmlspecialchars($row['faculty_name']) ?>" 
                         data-specialization="<?= htmlspecialchars($row['specialization']) ?>" 
                         data-consultation="<?= htmlspecialchars($row['consultation_time']) ?>" 
                         data-image="uploaded/facultyUploaded/<?= htmlspecialchars($row['faculty_image']) ?>">
                        <img src="uploaded/facultyUploaded/<?= htmlspecialchars($row['faculty_image']) ?>" alt="Faculty">
                        <p><strong><?= htmlspecialchars($row['faculty_name']) ?></strong><br>
                            Department: IT<br>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- IS Department Tab -->
    <div id="tab2" class="org-chart">
        <div class="section-content">
            <!-- Campus Heads for IS Department -->
            <h3>Campus Heads</h3>
            <div class="level1">
                <?php foreach ($allDean as $head): ?>
                    <div class="member">
                        <img src="uploaded/Heads/<?= htmlspecialchars($head['img']) ?>" alt="IS Dean">
                        <p><strong><?= htmlspecialchars($head['name']) ?></strong><br>Dean</p>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="level2">
                <?php foreach ($allIsHeads as $head): ?>
                    <div class="member">
                        <img src="uploaded/Heads/<?= htmlspecialchars($head['img']) ?>" alt="IS Chair">
                        <p><strong><?= htmlspecialchars($head['name']) ?></strong><br>IS Chair Person</p>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Faculty Members for IS Department -->
            <h3>Faculty Members</h3>
            <div class="level3">
                <?php foreach ($allIs as $row): ?>
                    <div class="member" 
                         data-name="<?= htmlspecialchars($row['faculty_name']) ?>" 
                         data-specialization="<?= htmlspecialchars($row['specialization']) ?>" 
                         data-consultation="<?= htmlspecialchars($row['consultation_time']) ?>" 
                         data-image="uploaded/facultyUploaded/<?= htmlspecialchars($row['faculty_image']) ?>">
                        <img src="uploaded/facultyUploaded/<?= htmlspecialchars($row['faculty_image']) ?>" alt="IS Faculty">
                        <p><strong><?= htmlspecialchars($row['faculty_name']) ?></strong><br>
                            Department: IS<br>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- CS Department Tab -->
    <div id="tab3" class="org-chart">
        <div class="section-content">
            <!-- Campus Heads for CS Department -->
            <h3>Campus Heads</h3>
            <div class="level1">
                <?php foreach ($allDean as $head): ?>
                    <div class="member">
                        <img src="uploaded/Heads/<?= htmlspecialchars($head['img']) ?>" alt="CS Dean">
                        <p><strong><?= htmlspecialchars($head['name']) ?></strong><br>Dean</p>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="level2">
                <?php foreach ($allCsHeads as $head): ?>
                    <div class="member">
                        <img src="uploaded/Heads/<?= htmlspecialchars($head['img']) ?>" alt="CS Chair">
                        <p><strong><?= htmlspecialchars($head['name']) ?></strong><br>CS Chair Person</p>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Faculty Members for CS Department -->
            <h3>Faculty Members</h3>
            <div class="level3">
                <?php foreach ($allCs as $row): ?>
                    <div class="member" 
                         data-name="<?= htmlspecialchars($row['faculty_name']) ?>" 
                         data-specialization="<?= htmlspecialchars($row['specialization']) ?>" 
                         data-consultation="<?= htmlspecialchars($row['consultation_time']) ?>" 
                         data-image="uploaded/facultyUploaded/<?= htmlspecialchars($row['faculty_image']) ?>">
                        <img src="uploaded/facultyUploaded/<?= htmlspecialchars($row['faculty_image']) ?>" alt="CS Faculty">
                        <p><strong><?= htmlspecialchars($row['faculty_name']) ?></strong><br>
                            Department: CS
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- MIT Department Tab -->
    <div id="tab4" class="org-chart">
        <div class="section-content">
            <!-- Campus Heads for MIT Department -->
            <h3>Campus Heads</h3>
            <div class="level1">
                <?php foreach ($allDean as $head): ?>
                    <div class="member">
                        <img src="uploaded/Heads/<?= htmlspecialchars($head['img']) ?>" alt="MIT Dean">
                        <p><strong><?= htmlspecialchars($head['name']) ?></strong><br>Dean</p>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="level2">
                <?php foreach ($allMitHeads as $head): ?>
                    <div class="member">
                        <img src="uploaded/Heads/<?= htmlspecialchars($head['img']) ?>" alt="MIT Chair">
                        <p><strong><?= htmlspecialchars($head['name']) ?></strong><br>MIT Chair Person</p>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Faculty Members for MIT Department -->
            <h3>Faculty Members</h3>
            <div class="level3">
                <?php foreach ($allMit as $row): ?>
                    <div class="member" 
                         data-name="<?= htmlspecialchars($row['faculty_name']) ?>" 
                         data-specialization="<?= htmlspecialchars($row['specialization']) ?>" 
                         data-consultation="<?= htmlspecialchars($row['consultation_time']) ?>" 
                         data-image="uploaded/facultyUploaded/<?= htmlspecialchars($row['faculty_image']) ?>">
                        <img src="uploaded/facultyUploaded/<?= htmlspecialchars($row['faculty_image']) ?>" alt="MIT Faculty">
                        <p><strong><?= htmlspecialchars($row['faculty_name']) ?></strong><br>
                            Department: MIT<br>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>



</div>

    </div>
</section>
<!-- Profile Modal -->
<div id="backdrop" class="backdrop" style="display: none;"></div>
<div id="profileCard" class="card mb-4">
    <div class="card-body text-center">
        <img id="profileImage" src="" alt="Profile Picture" class="rounded-circle img-fluid" style="width: 150px;">
        <h5 class="my-3" id="profileName">Name</h5>
        <p class="text-muted mb-1" id="profileSpecialization">Specialization: <span class="specialization-value"></span></p>
        <p class="text-muted mb-4" id="profileConsultationTime">Consultation Time: <span class="consultation-value"></span></p>
        <div class="d-flex justify-content-center mb-2">
            <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary">Follow</button>
            <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-primary ms-1">Message</button>
        </div>
    </div>
</div>


    <script>
        window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')
    </script>

    <!-- Bootstrap JS with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom JS and Plugins -->
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>
    <script>
        // Hide Header on on scroll down
        var didScroll;
        var lastScrollTop = 0;
        var delta = 5;
        var navbarHeight = $('header').outerHeight();

        $(window).scroll(function (event) {
            didScroll = true;
        });

        setInterval(function () {
            if (didScroll) {
                hasScrolled();
                didScroll = false;
            }
        }, 250);

        function hasScrolled() {
            var st = $(this).scrollTop();

            // Make sure they scroll more than delta
            if (Math.abs(lastScrollTop - st) <= delta)
                return;

            // If they scrolled down and are past the navbar, add class .nav-up.
            // This is necessary so you never see what is "behind" the navbar.
            if (st > lastScrollTop && st > navbarHeight) {
                // Scroll Down
                $('header').removeClass('nav-down').addClass('nav-up');
            } else {
                // Scroll Up
                if (st + $(window).height() < $(document).height()) {
                    $('header').removeClass('nav-up').addClass('nav-down');
                }
            }

            lastScrollTop = st;
        }

       
    </script>
  <script>
function toggleAnswer(faqId) {
    var answerDiv = document.getElementById('answer-' + faqId);
    // Toggle display based on current state
    answerDiv.style.display = answerDiv.style.display === 'none' ? 'block' : 'none';
}

function filterFAQs() {
    var input = document.getElementById('faq-search');
    var filter = input.value.toLowerCase();
    var faqItems = document.getElementsByClassName('faq-item');

    for (var i = 0; i < faqItems.length; i++) {
        var questionText = faqItems[i].getAttribute('data-question');
        // Show or hide FAQ item based on filter
        faqItems[i].style.display = questionText.includes(filter) ? '' : 'none';
    }
}
</script>

<script>
    
    document.addEventListener("DOMContentLoaded", function() {
    // Tab functionality
    const tabButtons = document.querySelectorAll(".button-faculty-btn");
    const tabs = document.querySelectorAll(".tabgroup > div");

    tabButtons.forEach(button => {
        button.addEventListener("click", function() {
            const tabId = this.getAttribute("data-tab");

            // Remove active class from all buttons and hide all tabs
            tabButtons.forEach(btn => btn.classList.remove("active"));
            tabs.forEach(tab => tab.style.display = "none");

            // Add active class to the clicked button and show the associated tab
            this.classList.add("active");
            document.getElementById(tabId).style.display = "block";
        });
    });

    // Show the first tab and mark the first button as active by default
    if (tabButtons.length > 0 && tabs.length > 0) {
        tabButtons[0].classList.add("active");
        tabs[0].style.display = "block";
    }

    // Profile display functionality
 // Profile display functionality
function updateProfileDisplay(name, specialization, consultationTime, imageUrl) {
    document.getElementById('profileName').textContent = name;
    document.getElementById('profileSpecialization').innerHTML = 'Specialization: <span class="specialization-value">' + specialization + '</span>';
    document.getElementById('profileConsultationTime').innerHTML = 'Consultation Time: <span class="consultation-value">' + consultationTime + '</span>';
    document.getElementById('profileImage').src = imageUrl;

    // Show the profile card and backdrop
    document.getElementById('profileCard').style.display = 'flex'; // Show the profile card
    document.getElementById('backdrop').style.display = 'block'; // Show the backdrop
}


    // Function to close the profile card
    function closeProfileCard() {
        document.getElementById('profileCard').style.display = 'none'; // Hide the profile card
        document.getElementById('backdrop').style.display = 'none'; // Hide the backdrop
    }

    // Add event listener to backdrop to close the profile card on click
    document.getElementById('backdrop').addEventListener('click', closeProfileCard);

    // Add click event listeners to all member cards
    const memberCards = document.querySelectorAll('.member');
    memberCards.forEach(member => {
        member.addEventListener('click', function() {
            const name = this.getAttribute('data-name');
            const specialization = this.getAttribute('data-specialization');
            const consultationTime = this.getAttribute('data-consultation');
            const imageUrl = this.getAttribute('data-image');

            updateProfileDisplay(name, specialization, consultationTime, imageUrl);
        });
    });
});

</script>
</body>
</html>
