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
       
.org-chart {
    text-align: center;
}

.level1, .level2, .level3 {
    display: flex;
    justify-content: center;
    margin-bottom: 30px;
}

.level2 {
    margin-top: 50px;
}

.level3 {
    margin-top: 50px;
    justify-content: space-around;
    width: 80%;
    margin: 0 auto;
}

.member {
    text-align: center;
    margin: 0 20px;
    background-color: #2e0f13; /* Maroon color */
    padding: 10px; /* Optional: Add some padding for better spacing */
    border-radius: 5px; /* Optional: Add border radius for rounded corners */
}


.member img {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #333;
    margin-bottom: 10px;
}

.member p {
    font-size: 14px;
    color: #fff; /* White color */
    line-height: 1.5;
}


.fclty-div {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-bottom: 20px;
}

.button-faculty-btn:hover,
.button-faculty-btn.active {
    background-color: #ae2d3e;
    transform: scale(1.05);
}

.button-faculty-btn.active {
    background-color: #ba0019;
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
                <div class="campus-heads">
                    <h3>Campus Heads</h3>
                    <div class="row">
                        <?php foreach ($allDean as $head): ?>
                            <div class="col-md-4">
                                <div class="member">
                                    <div class="faculty-image">
                                        <a href="uploaded/Heads/<?= htmlspecialchars($head['img']) ?>" data-lightbox="image">
                                            <img src="uploaded/Heads/<?= htmlspecialchars($head['img']) ?>" alt="image">
                                        </a>
                                    </div>
                                    <div class="faculty-info">
                                        <h6><?= htmlspecialchars($head['name']) ?></h6>
                                        <a>Dean</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <?php foreach ($allItHeads as $head): ?>
                            <div class="col-md-4">
                                <div class="member">
                                    <div class="faculty-image">
                                        <a href="uploaded/Heads/<?= htmlspecialchars($head['img']) ?>" data-lightbox="image">
                                            <img src="uploaded/Heads/<?= htmlspecialchars($head['img']) ?>" alt="image">
                                        </a>
                                    </div>
                                    <div class="faculty-info">
                                        <h6><?= htmlspecialchars($head['name']) ?></h6>
                                        <a>IT CHAIR PERSON</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Faculty Members -->
                <div class="faculty-members">
                    <h3>Faculty Members</h3>
                    <div class="row">
                        <?php foreach ($allIt as $row): ?>
                            <div class="col-md-4">
                                <div class="member">
                                    <div class="faculty-image">
                                        <a href="uploaded/facultyUploaded/<?= htmlspecialchars($row['faculty_image']) ?>" data-lightbox="image">
                                            <img src="uploaded/facultyUploaded/<?= htmlspecialchars($row['faculty_image']) ?>" alt="image">
                                        </a>
                                    </div>
                                    <div class="faculty-info">
                                        <h6><?= htmlspecialchars($row['faculty_name']) ?></h6>
                                        <a>Department: IT</a>
                                        <a>Specialization: <?= htmlspecialchars($row['specialization']) ?></a>
                                        <a>Consultation Time: <?= htmlspecialchars($row['consultation_time']) ?></a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- IS Department Tab -->
        <div id="tab2" class="tab-content">
            <div class="section-content">
                <!-- Campus Heads -->
                <div class="campus-heads">
                    <h3>Campus Heads</h3>
                    <div class="row">
                        <?php foreach ($allDean as $head): ?>
                            <div class="col-md-4">
                                <div class="member">
                                    <div class="faculty-image">
                                        <a href="uploaded/Heads/<?= htmlspecialchars($head['img']) ?>" data-lightbox="image">
                                            <img src="uploaded/Heads/<?= htmlspecialchars($head['img']) ?>" alt="image">
                                        </a>
                                    </div>
                                    <div class="faculty-info">
                                        <h6><?= htmlspecialchars($head['name']) ?></h6>
                                        <a>Dean</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <?php foreach ($allIsHeads as $head): ?>
                            <div class="col-md-4">
                                <div class="member">
                                    <div class="faculty-image">
                                        <a href="uploaded/Heads/<?= htmlspecialchars($head['img']) ?>" data-lightbox="image">
                                            <img src="uploaded/Heads/<?= htmlspecialchars($head['img']) ?>" alt="image">
                                        </a>
                                    </div>
                                    <div class="faculty-info">
                                        <h6><?= htmlspecialchars($head['name']) ?></h6>
                                        <a>IS CHAIR PERSON</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Faculty Members -->
                <div class="faculty-members">
                    <h3>Faculty Members</h3>
                    <div class="row">
                        <?php foreach ($allIs as $row): ?>
                            <div class="col-md-4">
                                <div class="member">
                                    <div class="faculty-image">
                                        <a href="uploaded/facultyUploaded/<?= htmlspecialchars($row['faculty_image']) ?>" data-lightbox="image">
                                            <img src="uploaded/facultyUploaded/<?= htmlspecialchars($row['faculty_image']) ?>" alt="image">
                                        </a>
                                    </div>
                                    <div class="faculty-info">
                                        <h6><?= htmlspecialchars($row['faculty_name']) ?></h6>
                                        <a>Department: IS</a>
                                        <a>Specialization: <?= htmlspecialchars($row['specialization']) ?></a>
                                        <a>Consultation Time: <?= htmlspecialchars($row['consultation_time']) ?></a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- CS Department Tab -->
        <div id="tab3" class="tab-content">
            <div class="section-content">
                <!-- Campus Heads -->
                <div class="campus-heads">
                    <h3>Campus Heads</h3>
                    <div class="row">
                        <?php foreach ($allDean as $head): ?>
                            <div class="col-md-4">
                                <div class="member">
                                    <div class="faculty-image">
                                        <a href="uploaded/Heads/<?= htmlspecialchars($head['img']) ?>" data-lightbox="image">
                                            <img src="uploaded/Heads/<?= htmlspecialchars($head['img']) ?>" alt="image">
                                        </a>
                                    </div>
                                    <div class="faculty-info">
                                        <h6><?= htmlspecialchars($head['name']) ?></h6>
                                        <a>Dean</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <?php foreach ($allCsHeads as $head): ?>
                            <div class="col-md-4">
                                <div class="member">
                                    <div class="faculty-image">
                                        <a href="uploaded/Heads/<?= htmlspecialchars($head['img']) ?>" data-lightbox="image">
                                            <img src="uploaded/Heads/<?= htmlspecialchars($head['img']) ?>" alt="image">
                                        </a>
                                    </div>
                                    <div class="faculty-info">
                                        <h6><?= htmlspecialchars($head['name']) ?></h6>
                                        <a>CS CHAIR PERSON</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Faculty Members -->
                <div class="faculty-members">
                    <h3>Faculty Members</h3>
                    <div class="row">
                        <?php foreach ($allCs as $row): ?>
                            <div class="col-md-4">
                                <div class="member">
                                    <div class="faculty-image">
                                        <a href="uploaded/facultyUploaded/<?= htmlspecialchars($row['faculty_image']) ?>" data-lightbox="image">
                                            <img src="uploaded/facultyUploaded/<?= htmlspecialchars($row['faculty_image']) ?>" alt="image">
                                        </a>
                                    </div>
                                    <div class="faculty-info">
                                        <h6><?= htmlspecialchars($row['faculty_name']) ?></h6>
                                        <a>Department: CS</a>
                                        <a>Specialization: <?= htmlspecialchars($row['specialization']) ?></a>
                                        <a>Consultation Time: <?= htmlspecialchars($row['consultation_time']) ?></a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- MIT Department Tab -->
        <div id="tab4" class="tab-content">
            <div class="section-content">
                <!-- Campus Heads -->
                <div class="campus-heads">
                    <h3>Campus Heads</h3>
                    <div class="row">
                        <?php foreach ($allDean as $head): ?>
                            <div class="col-md-4">
                                <div class="member">
                                    <div class="faculty-image">
                                        <a href="uploaded/Heads/<?= htmlspecialchars($head['img']) ?>" data-lightbox="image">
                                            <img src="uploaded/Heads/<?= htmlspecialchars($head['img']) ?>" alt="image">
                                        </a>
                                    </div>
                                    <div class="faculty-info">
                                        <h6><?= htmlspecialchars($head['name']) ?></h6>
                                        <a>Dean</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <?php foreach ($allMitHeads as $head): ?>
                            <div class="col-md-4">
                                <div class="member">
                                    <div class="faculty-image">
                                        <a href="uploaded/Heads/<?= htmlspecialchars($head['img']) ?>" data-lightbox="image">
                                            <img src="uploaded/Heads/<?= htmlspecialchars($head['img']) ?>" alt="image">
                                        </a>
                                    </div>
                                    <div class="faculty-info">
                                        <h6><?= htmlspecialchars($head['name']) ?></h6>
                                        <a>MIT CHAIR PERSON</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Faculty Members -->
                <div class="faculty-members">
                    <h3>Faculty Members</h3>
                    <div class="row">
                        <?php foreach ($allMit as $row): ?>
                            <div class="col-md-4">
                                <div class="member">
                                    <div class="faculty-image">
                                        <a href="uploaded/facultyUploaded/<?= htmlspecialchars($row['faculty_image']) ?>" data-lightbox="image">
                                            <img src="uploaded/facultyUploaded/<?= htmlspecialchars($row['faculty_image']) ?>" alt="image">
                                        </a>
                                    </div>
                                    <div class="faculty-info">
                                        <h6><?= htmlspecialchars($row['faculty_name']) ?></h6>
                                        <a>Department: MIT</a>
                                        <a>Specialization: <?= htmlspecialchars($row['specialization']) ?></a>
                                        <a>Consultation Time: <?= htmlspecialchars($row['consultation_time']) ?></a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

    </div>
</section>


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
</script>

</body>
</html>
