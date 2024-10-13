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
<div class="modal fade custom-modal" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="profileModalTitle">Profile</h3>
                <button type="button" class="btn-close" onclick="closeModal()" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="text-align: center;"> <!-- Centering the content -->
                <img id="modalImage" src="" alt="Profile Image" style="max-width: 100%; height: auto;" /> <!-- Image centered on top -->
                <h4 id="modalName" style="margin: 10px 0;"></h4> <!-- Name under the image -->
                <p id="modalDetails"></p> <!-- Details section -->
            </div>
            <div class="modal-footer">
                <!-- Optional footer buttons -->
            </div>
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
   <script>function toggleAnswer(faqId) {
    var answerDiv = document.getElementById('answer-' + faqId);
    if (answerDiv.style.display === 'none') {
        answerDiv.style.display = 'block';
    } else {
        answerDiv.style.display = 'none';
    }
}
function filterFAQs() {
    var input, filter, faqItems, questionText, i;
    input = document.getElementById('faq-search');
    filter = input.value.toLowerCase();
    faqItems = document.getElementsByClassName('faq-item');

    for (i = 0; i < faqItems.length; i++) {
        questionText = faqItems[i].getAttribute('data-question');
        if (questionText.includes(filter)) {
            faqItems[i].style.display = '';
        } else {
            faqItems[i].style.display = 'none';
        }
    }
}

document.addEventListener("DOMContentLoaded", function() {
    const tabButtons = document.querySelectorAll(".button-faculty-btn");
    const tabs = document.querySelectorAll(".tabgroup > div");

    tabButtons.forEach(button => {
        button.addEventListener("click", function() {
            const tabId = this.getAttribute("data-tab");

            // Remove active class from all buttons and tabs
            tabButtons.forEach(btn => btn.classList.remove("active"));
            tabs.forEach(tab => tab.style.display = "none");

            // Add active class to the clicked button and display the associated tab
            this.classList.add("active");
            document.getElementById(tabId).style.display = "block";
        });
    });

    // By default, show the first tab and mark the first button as active
    tabButtons[0].classList.add("active");
    tabs[0].style.display = "block";
});// Get the modal and related elements
var profileModal = document.getElementById("profileModal");
var modalTitle = document.getElementById("profileModalTitle");
var modalImage = document.getElementById("modalImage");
var modalName = document.getElementById("modalName");
var modalDetails = document.getElementById("modalDetails");

// Get the close button for the modal
var closeButton = document.getElementsByClassName("btn-close")[0];

// When the user clicks on a member
document.querySelectorAll('.member').forEach(function(member) {
    member.addEventListener('click', function() {
        // Set the title to the name
        modalTitle.textContent = "Profile";

        // Set the name and image
        modalName.textContent = member.dataset.name; // Assuming dataset.name has the name
        modalImage.src = member.dataset.image; // Assuming dataset.image has the image URL

        // Set the details using innerHTML for formatted output
        modalDetails.innerHTML = `
            <strong>Specialization:</strong> ${member.dataset.specialization}<br>
            <strong>Consultation Time:</strong> ${member.dataset.consultation}
        `;

        // Show the modal
        profileModal.classList.add("show"); // Add the class to show the modal
        profileModal.style.display = "block"; // Ensure it's displayed
    });
});

// When the user clicks on the close button, hide the modal
closeButton.onclick = function() {
    profileModal.style.display = "none"; // Hide the modal
    profileModal.classList.remove("show"); // Remove the class for hiding
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target === profileModal) { // Check if the clicked target is the modal
        profileModal.style.display = "none"; // Hide the modal
        profileModal.classList.remove("show"); // Remove the class for hiding
    }
}


</script>

</body>
</html>
