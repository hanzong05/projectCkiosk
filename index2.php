<?php
session_start();
include_once ("class/mainclass.php");
include_once ("class/connection.php");
$obj = new mainClass();
$allAnnouncement = $obj->show_announcement();
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


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Campus Kiosk</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/fontAwesome.css">
    <link rel="stylesheet" href="css/light-box.css">
    <link rel="stylesheet" href="css/owl-carousel.css">
    <link rel="stylesheet" href="css/templatemo-style.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    <style>

</style>
</head>

<body>



    <header class="nav-down responsive-nav hidden-lg hidden-md">
        <button type="button" id="nav-toggle" class="navbar-toggle" data-toggle="collapse" data-target="#main-nav">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <!--/.navbar-header-->
        <div id="main-nav" class="collapse navbar-collapse">
            <nav>
                <ul class="nav navbar-nav">
                    <li><a href="#announcement">ANNOUNCEMENT</a></li>
                    <li><a href="#schoolcalendar">SCHOOL CALENDAR</a></li>
                    <li><a href="#campusmap">CAMPUS MAP</a></li>
                    <li><a href="#facultymembers">FACULTY MEMBERS</a></li>
                    <li><a href="#campusorgs">CAMPUS ORGS</a></li>
                    <li><a href="#faqs">FREQUENTLY ASKED QUESTIONS</a></li>
                    <li><a href="#feed">FEEDBACK</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="sidebar-navigation hidde-sm hidden-xs">
        <div class="logo">
            <a href="#"><img src="img/C.png" alt="" width="240"></a>
        </div>
        <nav>
            <ul>
                <li>
                    <a href="#announcement">
                        <span class="rect"></span>
                        <span class="circle"></span>
                        ANNOUNCEMENT
                    </a>
                </li>
                <li>
                    <a href="#schoolcalendar">
                        <span class="rect"></span>
                        <span class="circle"></span>
                        SCHOOL CALENDAR
                    </a>
                </li>
                <li>
                    <a href="#campusmap">
                        <span class="rect"></span>
                        <span class="circle"></span>
                        CAMPUS MAP
                    </a>
                </li>
                <li>
                    <a href="#facultymembers">
                        <span class="rect"></span>
                        <span class="circle"></span>
                        FACULTY MEMBERS
                    </a>
                </li>
                <li>
                    <a href="#campusorgs">
                        <span class="rect"></span>
                        <span class="circle"></span>
                        CAMPUS ORGS
                    </a>
                </li>
                <li>
                    <a href="#faqs">
                        <span class="rect"></span>
                        <span class="circle"></span>
                        FREQUENTLY ASKED QUESTIONS
                    </a>
                </li>
                <li>
                    <a href="#feed">
                        <span class="rect"></span>
                        <span class="circle"></span>
                        FEEDBACK
                    </a>
                </li>
            </ul>
        </nav>
        <ul class="social-icons">
            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
            <li><a href="#"><i class="fa fa-rss"></i></a></li>
            <li><a href="#"><i class="fa fa-behance"></i></a></li>
        </ul>
    </div>

    <div class="page-content">
    <section id="faqs" class="content-section">
    <div id="faqs-content">
        <div class="section-heading text-center borderYellow">
            <h1>FREQUENTLY ASKED QUESTIONS</h1>
        </div>
        <div class="section-content">
            <!-- Search Bar -->
            <div class="search-container">
                <input type="text" id="faq-search" placeholder="Search FAQs..." onkeyup="filterFAQs()">
            </div>

            <div class="faq-items-container">
                <?php if (is_array($showfaqs)): ?>
                    <?php foreach ($showfaqs as $faq): ?>
                        <div class="faq-item" data-question="<?php echo strtolower(strip_tags($faq['faqs_question'])); ?>">
                            <h3 class="faq-question" onclick="toggleAnswer(<?php echo $faq['faqs_id']; ?>)">
                                <?php echo strip_tags($faq['faqs_question']); ?>
                            </h3>
                            <div id="answer-<?php echo $faq['faqs_id']; ?>" class="faq-answer">
                                <?php echo strip_tags($faq['faqs_answer']); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No FAQs available</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>



            </div>

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> -->
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

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





    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script> -->

</body>

</html>