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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    <style>
    .highlight {
    background-color: yellow !important; /* Use !important to override inline styles if needed */
    }
    .feedback-list {
            max-height: 300px; /* Limit height of feedback list */
            overflow-y: auto; /* Enable scrolling if content exceeds height */
        }
        .emoji-select {
            cursor: pointer;
            font-size: 2rem;
            transition: transform 0.2s;
        }
        .emoji-select:hover {
            transform: scale(1.2);
        }
        .selected {
    color: gold; /* Change color to indicate selection */
    transform: scale(1.5); /* Scale up the selected emoji for emphasis */
}
.avatar {
        width: 30px; /* Set the width */
        height: 30px; /* Set the height */
        object-fit: cover; /* Cover ensures the image fills the circle without distorting */
        border-radius: 50%; /* Make it circular */
    }
        
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

    
    <section id="announcement" class="content-section">
    <div class="section-heading text-center borderYellow">
        <h1><br><em>ANNOUNCEMENT</em></h1>
    </div>
    <div class="section-content">
        <div class="tabs-content">
            <div class="wrapper">
                <section class="tabgroup">
    <ul>
        <?php
        // Ensure $allAnnouncement is an array and contains items
        if (is_array($allAnnouncement) && count($allAnnouncement) > 0) {
            // Sort the announcements by 'created_at' in descending order
            usort($allAnnouncement, function ($a, $b) {
                return strtotime($b['created_at']) - strtotime($a['created_at']);
            });

            foreach ($allAnnouncement as $row) {
                // Check if created_at is set and valid
                if (isset($row['created_at'])) {
                    $createdAt = new DateTime($row['created_at']);
                    $now = new DateTime();
                    $interval = $createdAt->diff($now);

                    // Check if the announcement is older than 24 hours
                    if ($interval->days >= 1) {
                        $timeAgo = $createdAt->format('Y-m-d'); // Display the full date
                    } else {
                        // Format the time difference for announcements less than 24 hours old
                        if ($interval->h > 0) {
                            $timeAgo = $interval->h . ' hours ago';
                        } elseif ($interval->i > 0) {
                            $timeAgo = $interval->i . ' minutes ago';
                        } else {
                            $timeAgo = 'just now';
                        }
                    }
                } else {
                    $timeAgo = 'unknown date'; // Fallback if created_at is not set
                }
                ?>
                <br>
                <li style="width:100%;">
                    <div class="item">
                        <div class="timestamp">
                            Created <?= $timeAgo ?>
                        </div>
                        <div class="text-content">
                            <img class="avaatar" src="uploaded/orgUploaded/<?= htmlspecialchars($row["org_image"], ENT_QUOTES, 'UTF-8') ?>" alt="">
                            <span><?= strtoupper(htmlspecialchars($row['org_name'] ?? 'Unknown Organization', ENT_QUOTES, 'UTF-8')) ?></span>
                        </div>
                        <div class="square">
                            <?php
                            // Check if announcement image exists
                            if (!empty($row["announcement_image"])) {
                                echo '<div style="text-align: right; margin: 5px 0;">
                                        <img src="uploaded/annUploaded/' . htmlspecialchars($row["announcement_image"], ENT_QUOTES, 'UTF-8') . '" alt=""
                                            style="max-width: 200px; width: 100%; height: auto; margin-left: 10px;">
                                      </div>';
                            }

                            // Clean up the announcement details
                            $details = $row['announcement_details'] ?? '';
                            $details = preg_replace('/<font[^>]*>/i', '', $details);  // Remove opening <font> tags
                            $details = preg_replace('/<\/font>/i', '', $details);     // Remove closing </font> tags
                            
                            // Remove inline color styles
                            $details = preg_replace('/style="[^"]*color:[^;"]*;?"/i', '', $details);
                            $details = preg_replace('/<li([^>]*)>/i', '<li$1 style="color: yellow;">', $details);

                            echo $details;
                            ?>
                        </div>
                    </div>
                </li>
                <?php
            }
        } else {
            echo '<li>No announcements found.</li>'; // Handle case where there are no announcements
        }
        ?>
    </ul>
</section>


</section>
<section id="schoolcalendar" class="content-section">
    <div class="section-heading text-center borderYellow">
        <h1><em>SCHOOL CALENDAR</em></h1>
    </div>
    <div class="section-content">
        <div class="tabs-content">
            <div class="wrapper">
                <section class="tabgroup">
                    <ul>
                        <?php 
                        $today = date('Y-m-d'); // Get today's date
                        $todayEvents = []; // Initialize array for today's events
                        $upcomingEvents = []; // Initialize array for upcoming events

                        // Loop through the outer array (months)
                        foreach ($allEvent as $month => $events) {
                            foreach ($events as $event) {
                                // Check if the necessary keys exist
                                if (isset($event['calendar_date'], $event['calendar_id'], $event['calendar_details'])) {
                                    // Check if the event is happening today
                                    if ($event['calendar_date'] === $today) {
                                        $todayEvents[] = $event; // Store today's events
                                    } elseif ($event['calendar_date'] > $today) {
                                        $upcomingEvents[] = $event; // Store upcoming events
                                    }
                                }
                            }
                        }

                        // Display today's events if any
                        if (!empty($todayEvents)) {
                            echo '<li style="width: 100%;">';
                            echo '<div class="item">';
                            echo '<div class="text-content">';
                            echo '<h4>Happening Today</h4>';
                            echo '<table cellspacing="10">'; // Start the table outside of the loop
                            
                            foreach ($todayEvents as $event) {
                                echo '<tr>';
                                echo '<td style="color: white;">' . htmlspecialchars($event['calendar_date']) . ' </td>';
                                echo '<td style="color: white;"> . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . .' . htmlspecialchars(strip_tags($event['calendar_details'])) . '</td>';
                                echo '</tr>';
                            }
                            
                            echo '</table>'; // End the table here
                            echo '</div>'; // Close text-content
                            echo '</div>'; // Close item
                            echo '</li>';
                        }

                        // Display upcoming events if any
                        if (!empty($upcomingEvents)) {
                            echo '<li style="width: 100%;">';
                            echo '<div class="item">';
                            echo '<div class="text-content">';
                            echo '<h4>Upcoming Events</h4>';
                            echo '<table cellspacing="10">'; // Start the table outside of the loop
                            
                            foreach ($upcomingEvents as $event) {
                                echo '<tr>';
                                echo '<td style="color: white;">' . htmlspecialchars($event['calendar_date']) . ' </td>';
                                echo '<td style="color: white;"> . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . .' . htmlspecialchars(strip_tags($event['calendar_details'])) . '</td>';
                                echo '</tr>';
                            }
                            
                            echo '</table>'; // End the table here
                            echo '</div>'; // Close text-content
                            echo '</div>'; // Close item
                            echo '</li>';
                        }

                        // If no events today and no upcoming events
                        if (empty($todayEvents) && empty($upcomingEvents)) {
                            echo '<li style="width: 100%;">';
                            echo '<div class="item">';
                            echo '<div class="text-content">';
                            echo '<h4>No Events Happening Today or Upcoming</h4>';
                            echo '</div>'; // Close text-content
                            echo '</div>'; // Close item
                            echo '</li>';
                        }
                        ?>
                    </ul>
                </section>
            </div>
        </div>
    </div>
</section>




        <section id="campusmap" class="content-section ">
            <div class="section-heading text-center borderYellow">
                <h1><br><em>CAMPUS MAP</em></h1>
            </div>
            <div id="map" >
                <div class="map section-content-map">
                    <div class="dropdown">
                        <input type="text" id="search-input" placeholder="Enter room name">
                        <button onclick="searchAndHighlight()" class="search-button">
                        <i class="fa fa-search"></i>
                    </button>
                    
                    <select id="dropdownMenu">
                        <option value="1" selected>1st Floor</option>
                        <option value="2">2nd Floor</option>
                        <option value="3">3rd Floor</option>
                        <option value="4">4th Floor</option>
                        <option value="5">5th Floor</option>
                    </select>
                    </div>
            <div class="table-container"> 
            <table class="floor-table" id="floor-1" border="1">
                    <tbody>
                        <tr>
                            <td class="floor-gray"colspan="2" id="1" style="height: 100px;"></td>
                        
                            <td id="2" class="floor-gray" rowspan="2" style="width: 120px;"></td>
                            <td id="3" class="floor-gray"rowspan="2" style="width: 120px;"></td>
                            <td id="4" class="floor-gray" colspan="2" rowspan="2"></td>
                            <td id="5" class="floor-gray"rowspan="2" style="width: 70px; "></td>
                            <td id="6" class="floor-gray"rowspan="2" style="width: 70px; "></td>
                            <td id="7" class="floor-gray"colspan="2"></td>
                        </tr>
                        <tr>
                            <td id="8" class="floor-gray"colspan="2" style="height: 50px;"></td>
                            <td id="9" class="floor-gray"colspan="2"></td>
                        </tr>
                        <tr>
                            <td class="floor-gray"colspan="2" id="10">0</td>
                            <td id="11"  class="floor-maroon" colspan="6" rowspan="4">1</td>
                            <td id="12" class="floor-gray"colspan="2">2</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="floor-gray"id="13">3</td>
                            <td id="14" class="floor-gray"colspan="2">4</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="floor-gray"id="15"   style="height: 60px;">5</td>
                            <td id="16" class="floor-gray"colspan="2">6</td>
                        
                        </tr>
                        <tr>
                            <td colspan="2" class="floor-gray"id="17"  style="height: 50px;">7</td>
                            <td id="18" class="floor-gray"colspan="2">8</td>
                        
                        </tr>
                    </tbody>
                </table>
                <table class="floor-table" id="floor-2" border="1">
                    <tbody>
                        <tr>
                            <td colspan="2" class="floor-gray"id="19" style="height: 100px;">18</td>
                            <td id="20" class="floor-gray"rowspan="2" >19</td>
                            <td id="21" class="floor-gray"rowspan="2" >20</td>
                            <td id="22"  class="floor-gray"rowspan="2">21</td>
                            <td id="23" class="floor-gray"rowspan="2" >22</td>
                            <td id="24" class="floor-gray"colspan="2" rowspan="2">23</td>
                            <td id="25" class="floor-gray"colspan="2" >24</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="floor-gray"id="26" style="height: 50px; ">25</td>
                            <td id="27" class="floor-gray"colspan="2">26</td>
                        </tr>
                        <tr>
                            <td colspan="2"class="floor-gray"id="28">27</td>
                            <td id="29" class="floor-maroon"colspan="6" rowspan="4">138</td>
                            <td id="32" class="floor-gray"colspan="2">29</td>
                        </tr>
                        <tr>
                            <td colspan="2"class="floor-gray"id="31">30</td>
                            <td id="30"class="floor-gray" colspan="2">31</td>
                        </tr>
                        <tr>
                            <td colspan="2"id="33" class="floor-gray "  style="height: 60px;">32</td>
                            <td id="34" class="floor-gray"colspan="2">33</td>
                        
                        </tr>
                        <tr>
                            <td colspan="2"id="35" class="floor-gray" style="height: 50px;">34</td>
                            <td id="36" class="floor-gray"colspan="2">35</td>
                        
                        </tr>
                    </tbody>
                </table>

                <table class="floor-table" id="floor-3" border="1">
                    <tbody>
                        <tr>
                            <td colspan="2"id="37"  class="floor-gray" style="height: 100px;">18</td>
                            <td id="38" rowspan="2" class="floor-gray">19</td>
                            <td id="39" rowspan="2" class="floor-gray">20</td>
                            <td id="40" rowspan="2" class="floor-gray">21</td>
                            <td id="41" rowspan="2" class="floor-gray">22</td>
                            <td id="42" colspan="2" rowspan="2" class="floor-gray">23</td>
                            <td id="43" colspan="2" class="floor-gray">24</td>
                        </tr>
                        <tr>
                            <td colspan="2"id="44" style="height: 50px;" class="floor-gray">25</td>
                            <td id="45" colspan="2" class="floor-gray">26</td>
                        </tr>
                        <tr>
                            <td colspan="2"id="46"class="floor-gray">27</td>
                            <td id="47" colspan="6" rowspan="4" class="floor-maroon">138</td>
                            <td id="48" colspan="2" class="floor-gray">29</td>
                        </tr>
                        <tr>
                            <td colspan="2"id="50" class="floor-gray">30</td>
                            <td id="49" colspan="2" class="floor-gray">31</td>
                        </tr>
                        <tr>
                            <td colspan="2"id="51"  style="height: 60px;" class="floor-gray">32</td>
                            <td id="52" colspan="2" class="floor-gray">33</td>
                        
                        </tr>
                        <tr>
                            <td colspan="2"id="53"  style="height: 50px; " class="floor-gray">34</td>
                            <td id="54" colspan="2" class="floor-gray">35</td>
                        
                        </tr>
                    </tbody>
                </table>

                <table class="floor-table" id="floor-4" border="1">
                    <tbody>
                        <tr>
                            <td colspan="2"id="55" style="height: 100px; " class="floor-gray">18</td>
                            <td id="56" rowspan="2" class="floor-gray">19</td>
                            <td id="57" rowspan="2" class="floor-gray">20</td>
                            <td id="58" rowspan="2"class="floor-gray">21</td>
                            <td id="59" rowspan="2" class="floor-gray">22</td>
                            <td id="60" rowspan="2"class="floor-gray">23</td>
                            <td id="61" rowspan="2"class="floor-gray">23</td>
                            <td id="62" colspan="2" class="floor-gray">24</td>
                        </tr>
                        <tr>
                            <td colspan="2" id="63" style="height: 50px;" class="floor-gray">25</td>
                            <td id="64" colspan="2" class="floor-gray">26</td>
                        </tr>
                        <tr>
                            <td colspan="2"id="65" class="floor-gray">27</td>
                            <td id="66" colspan="6" rowspan="4" class="floor-maroon">138</td>
                            <td id="67" colspan="2" class="floor-gray">29</td>
                        </tr>
                        <tr>
                            <td colspan="2"id="68" class="floor-gray">30</td>
                            <td id="69" colspan="2" class="floor-gray">31</td>
                        </tr>
                        <tr>
                            <td colspan="2"id="70"   style="height: 60px; " class="floor-gray">32</td>
                            <td id="71" colspan="2" class="floor-gray">33</td>
                        
                        </tr>
                        <tr>
                            <td colspan="2"id="72"  style="height: 50px;" class="floor-gray">34</td>
                            <td id="73" colspan="2" class="floor-gray"> 35</td>
                        
                        </tr>
                    </tbody>
                </table>
                <table class="floor-table" id="floor-5" border="1">
                    <tbody>
                        <tr>
                            <td colspan="2"id="74" style="height: 100px; " class="floor-gray">18</td>
                            <td id="75" colspan="6" rowspan="2" class="floor-gray">19</td>
                            <td id="76" colspan="2" class="floor-gray">24</td>
                        </tr>
                        <tr>
                            <td colspan="2" id="77" style="height: 50px;" class="floor-gray">25</td>
                            <td id="78" colspan="2" class="floor-gray">26</td>
                        </tr>
                        <tr>
                            <td colspan="2"id="79" class="floor-gray">27</td>
                            <td id="80" colspan="6" rowspan="4" class="floor-maroon">138</td>
                            <td id="81" colspan="2" rowspan="2" class="floor-gray">29</td>
                        </tr>
                        <tr>
                            <td colspan="2"id="82" class="floor-gray">30</td>
                        </tr>
                        <tr>
                            <td colspan="2"id="83"   style="height: 60px;" class="floor-gray">32</td>
                            <td id="84" colspan="2" class="floor-gray">33</td>
                        
                        </tr>
                        <tr>
                            <td colspan="2"id="85"  style="height: 50px;" class="floor-gray">34</td>
                            <td id="86" colspan="2" class="floor-gray"> 35</td>
                        
                        </tr>
                    </tbody>
                </table>
              </div>
                
            </div>
        </section>
    <section id="facultymembers" class="content-section">
            <div class="section-heading text-center borderYellow">
                <h1><br><em>FACULTY MEMBERS</em></h1>
            </div>
        <div class="section-content">
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
           
                <div id="tab1" class="tab-content">
                    <div class="section-content">
                        <!-- Campus Heads -->
                        <div class="campus-heads">
                            <h3>Campus Heads</h3>
                            <div class="row">
                            <?php foreach ($allDean as $head): ?>
    <div class="col-md-4">
        <div class="faculty-card">
            <div class="faculty-image">
                <a href="uploaded/Heads/<?= htmlspecialchars($head['img']) ?>" data-lightbox="image">
                    <img src="uploaded/Heads/<?= htmlspecialchars($head['img']) ?>" alt="image">
                </a>
            </div>
        </div>
        <div class="faculty-info">
            <h6><?= htmlspecialchars($head['name']) ?></h6>
            <a>Dean</a>
        </div>
    </div>
<?php endforeach; ?>
<?php foreach ($allItHeads as $head): ?>
    <div class="col-md-4">
        <div class="faculty-card">
            <div class="faculty-image">
                <a href="uploaded/Heads/<?= htmlspecialchars($head['img']) ?>" data-lightbox="image">
                    <img src="uploaded/Heads/<?= htmlspecialchars($head['img']) ?>" alt="image">
                </a>
            </div>
        </div>
        <div class="faculty-info">
            <h6><?= htmlspecialchars($head['name']) ?></h6>
            <a>IT CHAIR PERSON</a>
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
                <div class="faculty-card">
                    <div class="faculty-image">
                        <a href="uploaded/facultyUploaded/<?= htmlspecialchars($row['faculty_image']) ?>" data-lightbox="image">
                            <img src="uploaded/facultyUploaded/<?= htmlspecialchars($row['faculty_image']) ?>" alt="image">
                        </a>
                    </div>
                </div>
                <div class="faculty-info">
                    <h6><?= htmlspecialchars($row['faculty_name']) ?></h6>
                    <a>Department: IT</a>
                    <a>Specialization: <?= htmlspecialchars($row['specialization']) ?></a> <!-- Add specialization -->
                    <a>Consultation Time: <?= htmlspecialchars($row['consultation_time']) ?></a> <!-- Add consultation time -->
                </div>
            </div>
        <?php endforeach; ?>
    </div>
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
                                        <div class="faculty-card">
                                            <div class="faculty-image">
                                                <a href="uploaded/Heads/<?= htmlspecialchars($head['img']) ?>" data-lightbox="image">
                                                    <img src="uploaded/Heads/<?= htmlspecialchars($head['img']) ?>" alt="image">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="faculty-info">
                                            <h6><?= htmlspecialchars($head['name']) ?></h6>
                                            <a>Dean</a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <?php foreach ($allIsHeads as $head): ?>
                                    <div class="col-md-4">
                                        <div class="faculty-card">
                                            <div class="faculty-image">
                                                <a href="uploaded/Heads/<?= htmlspecialchars($head['img']) ?>" data-lightbox="image">
                                                    <img src="uploaded/Heads/<?= htmlspecialchars($head['img']) ?>" alt="image">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="faculty-info">
                                            <h6><?= htmlspecialchars($head['name']) ?></h6>
                                            <a>IS CHAIR PERSON</a>
                                            
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
                                        <div class="faculty-card">
                                            <div class="faculty-image">
                                                <a href="uploaded/facultyUploaded/<?= htmlspecialchars($row['faculty_image']) ?>" data-lightbox="image">
                                                    <img src="uploaded/facultyUploaded/<?= htmlspecialchars($row['faculty_image']) ?>" alt="image">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="faculty-info">
                                            <h6><?= htmlspecialchars($row['faculty_name']) ?></h6>
                                            <a>Department: IS</a>
                                            <a>Specialization: <?= htmlspecialchars($row['specialization']) ?></a> <!-- Add specialization -->
                    <a>Consultation Time: <?= htmlspecialchars($row['consultation_time']) ?></a>
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
                                        <div class="faculty-card">
                                            <div class="faculty-image">
                                                <a href="uploaded/Heads/<?= htmlspecialchars($head['img']) ?>" data-lightbox="image">
                                                    <img src="uploaded/Heads/<?= htmlspecialchars($head['img']) ?>" alt="image">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="faculty-info">
                                            <h6><?= htmlspecialchars($head['name']) ?></h6>
                                            <a>Dean</a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <?php foreach ($allCsHeads as $head): ?>
                                    <div class="col-md-4">
                                        <div class="faculty-card">
                                            <div class="faculty-image">
                                                <a href="uploaded/Heads/<?= htmlspecialchars($head['img']) ?>" data-lightbox="image">
                                                    <img src="uploaded/Heads/<?= htmlspecialchars($head['img']) ?>" alt="image">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="faculty-info">
                                            <h6><?= htmlspecialchars($head['name']) ?></h6>
                                            <a>CS CHAIR PERSON</a>
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
                                        <div class="faculty-card">
                                            <div class="faculty-image">
                                                <a href="uploaded/facultyUploaded/<?= htmlspecialchars($row['faculty_image']) ?>" data-lightbox="image">
                                                    <img src="uploaded/facultyUploaded/<?= htmlspecialchars($row['faculty_image']) ?>" alt="image">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="faculty-info">
                                            <h6><?= htmlspecialchars($row['faculty_name']) ?></h6>
                                            <a>Department: CS</a>
                                            <a>Specialization: <?= htmlspecialchars($row['specialization']) ?></a> <!-- Add specialization -->
                    <a>Consultation Time: <?= htmlspecialchars($row['consultation_time']) ?></a>
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
                                        <div class="faculty-card">
                                            <div class="faculty-image">
                                                <a href="uploaded/Heads/<?= htmlspecialchars($head['img']) ?>" data-lightbox="image">
                                                    <img src="uploaded/Heads/<?= htmlspecialchars($head['img']) ?>" alt="image">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="faculty-info">
                                            <h6><?= htmlspecialchars($head['name']) ?></h6>
                                            <a>Dean</a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <?php foreach ($allMitHeads as $head): ?>
                                    <div class="col-md-4">
                                        <div class="faculty-card">
                                            <div class="faculty-image">
                                                <a href="uploaded/Heads/<?= htmlspecialchars($head['img']) ?>" data-lightbox="image">
                                                    <img src="uploaded/Heads/<?= htmlspecialchars($head['img']) ?>" alt="image">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="faculty-info">
                                            <h6><?= htmlspecialchars($head['name']) ?></h6>
                                            <a>MIT CHAIR PERSON</a>
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
                                        <div class="faculty-card">
                                            <div class="faculty-image">
                                                <a href="uploaded/facultyUploaded/<?= htmlspecialchars($row['faculty_image']) ?>" data-lightbox="image">
                                                    <img src="uploaded/facultyUploaded/<?= htmlspecialchars($row['faculty_image']) ?>" alt="image">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="faculty-info">
                                            <h6><?= htmlspecialchars($row['faculty_name']) ?></h6>
                                            <a>Department: MIT</a>
                                            <a>Specialization: <?= htmlspecialchars($row['specialization']) ?></a> <!-- Add specialization -->
                    <a>Consultation Time: <?= htmlspecialchars($row['consultation_time']) ?></a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

        </section>
        </section>

        <section id="campusorgs" class="content-section"> 
            <div class="section-heading text-center borderYellow">
                <!-- You can add your heading content here -->
            </div>
            <div class="section-content section-content-orgs">
                <div class="row">
                    <?php foreach ($allOrg as $row): ?>
                        <div class="col-md-4">
                            <div class="faculty-card">
                                <div class="faculty-image">
                                    <a href="#"
                                    data-toggle="modal"
                                    data-target="#newsModal"
                                    data-orgid="<?= htmlspecialchars($row['org_id']) ?>" 
                                    data-title="<?= htmlspecialchars($row['org_name']) ?>"
                                    data-image="uploaded/orgUploaded/<?= htmlspecialchars($row['org_image']) ?>"
                                    data-profilephoto="uploaded/orgUploaded/<?= htmlspecialchars($row['org_image']) ?>"
                                    data-author="<?= htmlspecialchars($row['org_name']) ?>">
                                        <img src="uploaded/orgUploaded/<?= htmlspecialchars($row['org_image']) ?>"
                                            alt="<?= htmlspecialchars($row['org_name']) ?>"
                                            class="orgimage">
                                    </a>
                                </div>
                            </div>
                            <div class="faculty-info">
                                <h6><?= htmlspecialchars($row['org_name']) ?></h6>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="newsModal" tabindex="-1" role="dialog" aria-labelledby="newsModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header d-flex justify-content-between align-items-center">
                                <h3 class="modal-title" id="newsModalTitle">News Feed</h3>
                                <button type="button" class="close custom-close" data-dismiss="modal" aria-label="Close">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div id="newsFeedContent" class="news-feed">
                                    <!-- News feed content goes here -->
                                </div>
                            </div>
                            <div class="modal-footer">
                                <!-- Footer content goes here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="faqs" class="content-section">
            <div id="faqs-content">
                <div class="section-heading text-center borderYellow">
                    <h1>FREQUENTLY ASKED QUESTIONS</h1>
                </div>
                <div class="section-content section-content-faqs">
                    <!-- Search Bar -->
                    <div class="search-container">
                        <input type="text" id="faq-search" placeholder="Search FAQs..." onkeyup="filterFAQs()">
                    </div>

                    <div class="faq-items-container">
                        <?php if (is_array($showfaqs) && !empty($showfaqs)): ?>
                            <?php foreach ($showfaqs as $faq): ?>
                                <div class="faq-item" data-question="<?= strtolower(strip_tags($faq['faqs_question'])); ?>">
                                    <h3 class="faq-question" onclick="toggleAnswer(<?= $faq['faqs_id']; ?>)">
                                        <?= htmlspecialchars($faq['faqs_question']); ?>
                                    </h3>
                                    <div id="answer-<?= $faq['faqs_id']; ?>" class="faq-answer">
                                        <strong>Answer: </strong> <?= htmlspecialchars($faq['faqs_answer']); ?>
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

        <section id="feed" class="content-section">
                <h3>Feed Back</h3>
                <div class="container mt-5">
                    <!-- Heading -->
                    <h2 class="section-heading text-center mb-4">Give Us Your Feedback</h2>

                    <!-- Feedback Display Section -->
                    <div class="row d-flex justify-content-center mt-4">
                        <div class="col-md-8 col-lg-6">
                            <div class="card shadow-0 border" style="background-color: #f0f2f5;">
                                <div class="card-body p-4">
                                    <!-- Button to trigger modal aligned to the right -->
                                    <!-- Button Wrapper with Border -->
                                    <div class="text-end mb-4 border-bottom pb-3">
                                        <button type="button" class="btn btn-modern border" data-bs-toggle="modal" data-bs-target="#feedbackModal" style="border: 1px solid #ccc; border-radius: 5px;">
                                            <i class="fas fa-comments me-2"></i>Add Your Feedback
                                        </button>
                                    </div>
                                    <h5 class="card-title text-center mb-3">Recent Feedback</h5>
                                    <div id="feedbackList" class="feedback-list mb-4">
                                        <!-- Dynamically filled feedback items will go here -->
                                    </div>

                                    <!-- Average Ratings -->
                                    <div class="total-ratings">
                                        <h6>Average Rating:</h6>
                                        <small class="text-muted" id="averageRatingText">No Ratings Yet</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal for feedback -->
                <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="feedbackModalLabel">Feedback Form</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="feedbackForm" enctype="multipart/form-data">
                                    <!-- Step 1: Emoji Rating -->
                                    <div class="step" id="step1">
                                        <h4>Rate Your Experience</h4>
                                        <div class="d-flex justify-content-around my-4">
                                            <span class="emoji-select" data-value="1">😠</span>
                                            <span class="emoji-select" data-value="2">😞</span>
                                            <span class="emoji-select" data-value="3">😐</span>
                                            <span class="emoji-select" data-value="4">😊</span>
                                            <span class="emoji-select" data-value="5">😍</span>
                                        </div>
                                        <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
                                    </div>

                                    <!-- Step 2: Personal Information -->
                                    <div class="step" id="step2" style="display:none;">
                                        <h4>Provide Your Information</h4>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email address (required)</label>
                                            <input type="email" class="form-control" id="email" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Name (optional)</label>
                                            <input type="text" class="form-control" id="name">
                                        </div>
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Address (optional)</label>
                                            <input type="text" class="form-control" id="address">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Course</label><br>
                                            <div>
                                                <input type="radio" id="college1" name="college" value="Information Systems" required>
                                                <label for="college1">Information Systems</label>
                                            </div>
                                            <div>
                                                <input type="radio" id="college2" name="college" value="Information Technology">
                                                <label for="college2">Information Technology</label>
                                            </div>
                                            <div>
                                                <input type="radio" id="college3" name="college" value="Computer Science">
                                                <label for="college3">Computer Science</label>
                                            </div>
                                            <div>
                                                <input type="radio" id="college4" name="college" value="other">
                                                <label for="college4">Other / From Other College</label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Year (required)</label><br>
                                            <div>
                                                <input type="radio" id="year1" name="year" value="1" required>
                                                <label for="year1">1st Year</label>
                                            </div>
                                            <div>
                                                <input type="radio" id="year2" name="year" value="2">
                                                <label for="year2">2nd Year</label>
                                            </div>
                                            <div>
                                                <input type="radio" id="year3" name="year" value="3">
                                                <label for="year3">3rd Year</label>
                                            </div>
                                            <div>
                                                <input type="radio" id="year4" name="year" value="4">
                                                <label for="year4">4th Year</label>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-secondary" onclick="prevStep()">Previous</button>
                                        <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
                                    </div>

                                    <!-- Step 3: Feedback and Image Upload -->
                                    <div class="step" id="step3" style="display:none;">
                                        <h4>Leave Your Feedback</h4>
                                        <div class="mb-3">
                                            <label for="feedback" class="form-label">Your feedback</label>
                                            <textarea class="form-control" id="feedback" rows="3" placeholder="Tell us more about your experience"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Upload a Profile Image (optional)</label>
                                            <input class="form-control" type="file" id="image">
                                        </div>
                                        <button type="button" class="btn btn-secondary" onclick="prevStep()">Previous</button>
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        <!-- <section class="footer">
                <p>Copyright &copy; 2024.</p>
            </section> -->
    </div>
    
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
        
      // Attach event listener to search button
document.querySelector('button[onclick="searchAndHighlight()"]').addEventListener('click', searchAndHighlight);

// Attach change event listener to dropdown
const dropdownMenu = document.getElementById('dropdownMenu');
dropdownMenu.addEventListener('change', function () {
    const floorId = this.value;
    if (floorId) {
        fetchRoomsForFloor(floorId);
        showFloorTable(floorId);
    } else {
        clearTableCells();
    }
});

// Trigger the change event to load the default table
dropdownMenu.dispatchEvent(new Event('change'));

// Fetch and update rooms based on the selected floor
function fetchRoomsForFloor(floorId) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax/floor_data.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status === 200) {
            try {
                const rooms = JSON.parse(xhr.responseText);
                console.log('Rooms Data:', rooms); // Log the rooms data
                updateTableWithRooms(rooms);
            } catch (e) {
                console.error("Error parsing JSON:", e);
            }
        } else {
            console.error('Fetch Error:', xhr.statusText);
        }
    };
    xhr.send('floor_id=' + floorId);
}

// Function to update table with room data
function updateTableWithRooms(rooms) {
    clearTableCells();
    rooms.forEach(room => {
        const cell = document.getElementById(room.room_id); // Use id for cell selection
        if (cell) {
            cell.textContent = room.room_name; // Assuming room_name is what you want to display
            cell.style.backgroundColor = ''; // Reset the color
            console.log('Updated Cell:', cell.id, room.room_name); // Log each updated cell
        } else {
            console.error('Cell Not Found:', room.room_id);
        }
    });
}

// Function to clear all table cells
function clearTableCells() {
    document.querySelectorAll('.floor-table td').forEach(cell => {
        cell.textContent = ''; // Clear the cell content
        cell.style.backgroundColor = ''; // Reset the color
    });
}

// Function to handle search and highlight
function searchAndHighlight() {
    var input = document.getElementById('search-input').value.trim();

    if (input === '') {
        alert('Please enter a room name');
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax/search.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            console.log('Search Response:', xhr.responseText);
            var data = JSON.parse(xhr.responseText);

            if (data.error) {
                console.error('PHP Error:', data.error);
                return;
            }

            var roomIds = data.highlight || [];
            var floorIds = data.floor || [];
            console.log('Highlighting IDs:', roomIds);
            console.log('Floor IDs:', floorIds);

            // Clear previous highlights
            document.querySelectorAll('.highlight').forEach(cell => {
                cell.classList.remove('highlight');
            });

            // Highlight cells based on room IDs
            document.querySelectorAll('.floor-table td').forEach(cell => {
                if (roomIds.includes(parseInt(cell.id))) { // Ensure IDs are compared as integers
                    cell.classList.add('highlight');
                }
            });

            // Trigger the dropdown change event to update table and highlight results
            var dropdown = document.getElementById('dropdownMenu');
            dropdown.value = floorIds[0] || dropdown.value; // Default to the first floor in the array or keep current value
            dropdown.dispatchEvent(new Event('change')); // Trigger the change event

        } else {
            console.error('Search Error:', xhr.statusText);
        }
    };
    xhr.send('query=' + encodeURIComponent(input));
}

// Function to show a specific floor table
function showFloorTable(floorId) {
    document.querySelectorAll('.floor-table').forEach(table => {
        table.style.display = 'none'; // Hide all floor tables
    });

    const selectedTable = document.getElementById(`floor-${floorId}`);
    if (selectedTable) {
        selectedTable.style.display = 'table'; // Show the selected table
        selectedTable.scrollIntoView({ behavior: 'smooth', block: 'start' }); // Smooth scroll to the table
    }
}
       
    </script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Get all tab buttons and tab contents
    const tabButtons = document.querySelectorAll('.button-faculty-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    // Function to show a specific tab
    function showTab(tabId) {
        // Hide all tab contents
        tabContents.forEach(content => {
            content.style.display = 'none';
        });

        // Remove 'active' class from all buttons
        tabButtons.forEach(button => {
            button.classList.remove('active');
        });

        // Show the selected tab content
        document.getElementById(tabId).style.display = 'block';

        // Set the clicked button as active
        const activeButton = document.querySelector(`button[data-tab="${tabId}"]`);
        if (activeButton) {
            activeButton.classList.add('active');
        }
    }

    // Attach click event listeners to each tab button
    tabButtons.forEach(button => {
        button.addEventListener('click', function () {
            const tabId = this.getAttribute('data-tab');
            showTab(tabId);
        });
    });

    // Show the first tab by default
    if (tabButtons.length > 0) {
        showTab(tabButtons[0].getAttribute('data-tab'));
    }
});



function toggleAnswer(faqId) {
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

function adjustModalPosition() {
        var modal = document.getElementById('myModal');

        if (modal) {
            var viewportWidth = window.innerWidth;
            var viewportHeight = window.innerHeight;
            var modalWidth = modal.offsetWidth;
            var modalHeight = modal.offsetHeight;

            // Calculate new position to center the modal within the viewport
            var top = Math.max(10, (viewportHeight - modalHeight) / 2); // Ensure modal is at least 10px from top
            var left = Math.max(10, (viewportWidth - modalWidth) / 2); // Ensure modal is at least 10px from left

            // Apply new position to modal
            modal.style.top = top + 'px';
            modal.style.left = left + 'px';
        }
    }

    // Adjust modal position when the page loads
    window.addEventListener('load', adjustModalPosition);

    // Adjust modal position when the window is resized
    window.addEventListener('resize', adjustModalPosition);
</script>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let selectedRating; // To hold the selected rating
    let feedbackCount = 0; // To track the number of feedback submissions

    // Handle emoji selection
    document.querySelectorAll('.emoji-select').forEach(item => {
    item.addEventListener('click', function() {
        // Remove selected class from all emojis
        document.querySelectorAll('.emoji-select').forEach(emoji => {
            emoji.classList.remove('selected');
        });
        // Add selected class to the clicked emoji
        this.classList.add('selected');
        selectedRating = this; // Store the selected rating
    });
});

function nextStep() {
    const currentStep = document.querySelector('.step:not([style*="display: none"])');

    // Check required fields in the current step
    if (currentStep.id === "step1") {
        // Check if a rating is selected
        if (!selectedRating) {
            alert("Please select a rating before proceeding.");
            return;
        }
    } else if (currentStep.id === "step2") {
        // Validate required fields in Step 2
        const emailInput = document.getElementById('email').value.trim();
        
        // Get selected college
        const collegeInput = document.querySelector('input[name="college"]:checked');
        const collegeValue = collegeInput ? collegeInput.value : '';

        // Get selected year
        const yearInput = document.querySelector('input[name="year"]:checked');
        const yearValue = yearInput ? yearInput.value : '';

        if (!emailInput || !collegeValue || !yearValue) {
            alert("Please fill in all required fields before proceeding.");
            return;
        }
    }

    // Proceed to the next step if all validations pass
    if (currentStep.nextElementSibling) {
        currentStep.style.display = 'none';
        currentStep.nextElementSibling.style.display = 'block';
    }
}


    // Function to go to the previous step
    function prevStep() {
        const currentStep = document.querySelector('.step:not([style*="display: none"])');
        if (currentStep.previousElementSibling) {
            currentStep.style.display = 'none';
            currentStep.previousElementSibling.style.display = 'block';
        }
    }

    let totalScore = 0; // To accumulate the total score
    let averageRatingText = document.getElementById('averageRatingText'); // Reference to average rating display
// Event listener for feedback submission
        document.getElementById('feedbackForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form submission
            const feedbackInput = document.getElementById('feedback').value.trim();
            const emailInput = document.getElementById('email').value.trim();
            const nameInput = document.getElementById('name').value.trim();
            const addressInput = document.getElementById('address').value.trim();

            // Retrieve selected college
            const collegeInput = document.querySelector('input[name="college"]:checked');
            const collegeValue = collegeInput ? collegeInput.value : '';

            // Retrieve selected year
            const yearInput = document.querySelector('input[name="year"]:checked');
            const yearValue = yearInput ? yearInput.value : '';

            const imageInput = document.getElementById('image').files[0];

            if (feedbackInput && selectedRating && collegeValue && yearValue) {
                const formData = new FormData();
                formData.append('rating', selectedRating.getAttribute('data-value'));
                formData.append('feedback', feedbackInput);
                formData.append('email', emailInput);
                formData.append('name', nameInput);
                formData.append('address', addressInput);
                formData.append('college', collegeValue);
                formData.append('year', yearValue);
                if (imageInput) {
                    formData.append('image', imageInput);
                }

                // Show loading alert
                Swal.fire({
                    title: 'Submitting your feedback',
                    text: 'Please wait...',
                    allowOutsideClick: false,
                    onOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Send data to PHP script via fetch
                fetch('ajax/submit_feedback.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    console.log('Response:', response); // Log the response
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.statusText);
                    }
                    return response.json(); // Parse response as JSON
                })
                .then(data => {
                    // Close the loading alert
                    Swal.close();

                    if (data.success) {
                        // Show Toast notification for success
                        Toast.fire({
                            icon: 'success',
                            title: 'Feedback submitted successfully!'
                        }).then(() => {
                            // Reload the page after showing the toast
                            location.reload();
                        });
                    } else {
                        console.error('Submission failed:', data.message);
                        // Show Toast notification for error
                        Toast.fire({
                            icon: 'error',
                            title: data.message || 'An error occurred while submitting your feedback.'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Close the loading alert
                    Swal.close();
                    // Show Toast notification for unexpected error
                    Toast.fire({
                        icon: 'error',
                        title: 'An unexpected error occurred. Please try again later.'
                    });
                });

                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('feedbackModal'));
                modal.hide();
            } else {
                alert('Please select a rating and provide feedback.');
            }
        });

        // Toast configuration
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

        // Load feedback when the page loads
        function loadFeedback() {
            fetch('ajax/fetch_feedback.php') // Point to your PHP script
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    const feedbackList = document.getElementById('feedbackList');
                    feedbackList.innerHTML = ''; // Clear existing feedback
                    let totalScore = 0; // Initialize total score
                    let feedbackCount = data.length; // Get feedback count

                    if (feedbackCount > 0) {
                        data.forEach(feedback => {
                            const newFeedback = document.createElement('div');
                            newFeedback.className = 'card mb-4'; // Add card styling
                            // Use a default image if no image is uploaded
                            const imageUrl = feedback.image; // Set your default image path here
                            newFeedback.innerHTML = `
                            
                                <div class="card-body">
                                    <img src="${imageUrl}" class="avatar" alt="Avatar" />
                                    <h5 class="card-title">${feedback.name || 'Anonymous'} (${feedback.email})</h5>
                                    <p class="card-text">Rating: ${getEmojiForRating(feedback.rating)}</p>
                                    <p class="card-text" style="border: 1px solid #ccc; max-height: 150px; overflow-y: auto;">
                                        FeedBack: ${feedback.feedback_text}
                                    </p>
                                    <p class="card-text"><small class="text-muted">
                                        Course: ${feedback.college || 'N/A'} | ${getYearWithSuffix(feedback.year) || 'N/A'}
                                    </small>
                                </div>`;
                            feedbackList.appendChild(newFeedback);

                            // Sum the ratings for average calculation
                            totalScore += parseInt(feedback.rating);
                        });

                        // Calculate average rating
                        const averageRating = (totalScore / feedbackCount).toFixed(2);
                        document.getElementById('averageRatingText').textContent = `${averageRating} ${getEmojiForRating(averageRating)}`;
                    } else {
                        feedbackList.innerText = 'No feedback available.';
                    }
                })
                .catch(error => {
                    console.error('Error during fetch:', error);
                });
        }
        function getYearWithSuffix(year) {
        if (!year) return ''; // Handle case where year is undefined or null

        const ordinalSuffix = (n) => {
            const suffixes = ["th", "st", "nd", "rd", "th"];
            return n % 100 >= 11 && n % 100 <= 13 ? suffixes[0] : suffixes[(n % 10) > 4 ? 0 : n % 10];
        };

        return `${year}${ordinalSuffix(year)} year`;
        }
        // Function to get emoji for a given rating
        function getEmojiForRating(rating) {
            switch (parseInt(rating)) {
                case 1: return '😠';
                case 2: return '😞';
                case 3: return '😐';
                case 4: return '😊';
                case 5: return '😍';
                default: return '';
            }
        }

        // Load feedback when the page loads
        window.onload = loadFeedback;

        </script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>


    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script> -->

</body>

</html>