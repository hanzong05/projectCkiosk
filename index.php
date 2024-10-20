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
$all2 = $obj->show_alllvl2();
$all3 = $obj->show_alllvl3();
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

    <link rel="stylesheet" href="css/responsive.css">

    <!-- Modernizr for browser feature detection -->
    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    <style>
           .faq-header h1 {
            font-weight: bold;
        }

        .faq-header p.lead {
            margin-bottom: 30px;
            color: #666;
        }

        .accordion-button {
            font-size: 1.1rem;
            font-weight: bold;
        }

        .accordion-body {
            font-size: 1rem;
        }

        .faq-image {
            text-align: center;
            display: flex;
            justify-content: center; /* Center the image */
            align-items: center; /* Vertically center the image */
            height: 90%; /* Make the column full height */
        }

        .faq-image img {
            max-width: 80%;
            height: auto; /* Keep aspect ratio */
        }

        .faq-toggle-icon {
    right: 10px; /* Adjust the spacing from the right as needed */
    top: 50%;
    transform: translateY(-50%);
    transition: transform 0.3s ease; /* Smooth transition */
}
   .floating-card {
    position: relative;
    background-color: #fff;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2), 0 10px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease-in-out;
    margin-bottom: 20px;
    max-width: 400px;
    margin: 0 auto;
    z-index: 1;
}

.floating-card:before {
    content: '';
    position: absolute;
    top: 100%;
    left: 50%;
    width: 100px;
    height: 15px;
    background: rgba(0, 0, 0, 0.15);
    filter: blur(10px);
    border-radius: 50%;
    transform: translateX(-50%);
    z-index: -1;
    transition: all 0.3s ease-in-out;
}

.floating-card:hover {
    transform: translateY(-10px);
}

.floating-card:hover:before {
    width: 120px;
    height: 20px;
    filter: blur(12px);
    opacity: 0.8;
}


.text1{
	font-size: 13px;
    font-weight: 500;
    color: #56575b;
}
.text2{
	font-size: 13px;
    font-weight: 500;
    margin-left: 6px;
    color: #56575b;
}
.text3{
	font-size: 13px;
    font-weight: 500;
    margin-right: 4px;
    color: #828386;
}
.text3o{
	color: #00a5f4;

}
.text4{
	font-size: 13px;
    font-weight: 500;
    color: #828386;
}
.text4i{
	color: #00a5f4;
}
.text4o{
	color: white;
} /* Styles for the backdrop */
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
    /* Make the image circular */
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


<!-- Mobile Navigation --><nav class="navbar navbar-expand-lg navbar-light bg-light d-lg-none">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="img/C.png" alt="Logo" width="120"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mobileNavbar" aria-controls="mobileNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mobileNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="#announcement">ANNOUNCEMENT</a></li>
                <li class="nav-item"><a class="nav-link" href="#schoolcalendar">SCHOOL CALENDAR</a></li>
                <li class="nav-item"><a class="nav-link" href="#campusmap">CAMPUS MAP</a></li>
                <li class="nav-item"><a class="nav-link" href="#facultymembers">FACULTY MEMBERS</a></li>
                <li class="nav-item"><a class="nav-link" href="#campusorgs">CAMPUS ORGS</a></li>
                <li class="nav-item"><a class="nav-link" href="#faqs">FREQUENTLY ASKED QUESTIONS</a></li>
                <li class="nav-item"><a class="nav-link" href="#feed">FEEDBACK</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Desktop Sidebar Navigation -->
<div class="sidebar-navigation d-none d-lg-block">
    <div class="logo">
        <a href="#"><img src="img/C.png" alt="Logo" width="240"></a>
    </div>
    <nav>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="#announcement">
                    <span class="rect"></span>
                    <span class="circle"></span>
                    ANNOUNCEMENT
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#schoolcalendar">
                    <span class="rect"></span>
                    <span class="circle"></span>
                    SCHOOL CALENDAR
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#campusmap">
                    <span class="rect"></span>
                    <span class="circle"></span>
                    CAMPUS MAP
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#facultymembers">
                    <span class="rect"></span>
                    <span class="circle"></span>
                    FACULTY MEMBERS
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#campusorgs">
                    <span class="rect"></span>
                    <span class="circle"></span>
                    CAMPUS ORGS
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#faqs">
                    <span class="rect"></span>
                    <span class="circle"></span>
                    FREQUENTLY ASKED QUESTIONS
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#feed">
                    <span class="rect"></span>
                    <span class="circle"></span>
                    FEEDBACK
                </a>
            </li>
        </ul>
    </nav>
   
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
            echo '<li style="color: white;">No announcements found.</li>
'; // Handle case where there are no announcements
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
        <div class="org-chart">
        <div class="level1">
                 <?php foreach ($allDean as $head): ?>
                        <div class="member">
                            <img src="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>" alt="Dean">
                            <p><strong><?= htmlspecialchars($head['faculty_name']) ?></strong><br>Dean</p>
                        </div>
                    <?php endforeach; ?>
            </div>
    
            <div class="level2">
                    <?php foreach ($all2 as $head): ?>
                        <div class="member">
                            <img src="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>" alt="Dean">
                            <p><strong><?= htmlspecialchars($head['faculty_name']) ?></strong><br>Dean</p>
                        </div>
                    <?php endforeach; ?>
            </div>  
    
            <div class="level3">
                     <?php foreach ($all3 as $head): ?>
                        <div class="member">
                            <img src="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>" alt="Dean">
                            <p><strong><?= htmlspecialchars($head['faculty_name']) ?></strong><br>Dean</p>
                        </div>
                    <?php endforeach; ?>
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
                            <img src="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>" alt="Dean">
                            <p><strong><?= htmlspecialchars($head['faculty_name']) ?></strong><br>Dean</p>
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
    
    

        <section id="campusorgs" class="content-section">
        <div class="section-heading text-center borderYellow">
        <h1><br><em>CAMPUS ORGS</em></h1>
    </div>
            <div class="section-content section-content-orgs">
                <div class="row">
                    <?php foreach ($allOrg as $row): ?>
                        <div class="col-md-4">
                            <div class="faculty-card">
                                <div class="faculty-image">
                                    <a href="#" 
                                    data-bs-toggle="modal"
                                    data-bs-target="#newsModal"
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
            </div>
           
        </section>

         

        <section id="faqs" class="content-section">
        <div class="section-heading text-center borderYellow">
        <h1><br><em>FREQUENTLY ASKED QUESTIONS</em></h1>
    </div>
        <div class="container py-5">
            <div class="row">
                <!-- Left Column: Illustration -->
                <div class="col-lg-6">
                    <div class="faq-image">
                        <img src="img/faq-img-1.png" alt="Illustration" class="img-fluid">
                    </div>
                </div>

                <!-- Right Column: FAQ Section -->
                <div class="col-lg-5">
                    <div class="faq-header text-center">
                        <h1>How can we help you?</h1>
                        <p class="lead">
                            We hope you have found an answer to your question. If you need any help, please search your query on our Support Center or contact us via email.
                        </p>
                    </div>

                    <div class="accordion accordion-flush" id="faqsAccordion">
                        <?php if(!empty($showfaqs)): ?>
                            <?php foreach ($showfaqs as $index => $faq): ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading<?php echo $index; ?>">
                                        <button class="accordion-button <?php echo $index == 0 ? '' : 'collapsed'; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $index; ?>" aria-expanded="<?php echo $index == 0 ? 'true' : 'false'; ?>" aria-controls="collapse<?php echo $index; ?>" style="background-color: #e7f1ff; color: #004085; position: relative;">
                                            <?php echo htmlspecialchars(strip_tags($faq['faqs_question'])); ?>
                                            <!-- Drop-down/up icon -->
                                            <i class="fas fa-chevron-down ms-auto faq-toggle-icon" style="position: absolute; right: 10px;"></i>
                                        </button>
                                    </h2>
                                    <div id="collapse<?php echo $index; ?>" class="accordion-collapse collapse <?php echo $index == 0 ? 'show' : ''; ?>" aria-labelledby="heading<?php echo $index; ?>" data-bs-parent="#faqsAccordion">
                                        <div class="accordion-body">
                                            <?php echo nl2br(htmlspecialchars(strip_tags($faq['faqs_answer']))); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No FAQs available at the moment.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

        <section id="feed" class="content-section">
        <div class="section-heading text-center borderYellow">
        <h1><br><em>FEED BACKS</em></h1>
    </div>
                <div class="container mt-5">
                    <!-- Heading -->
                    <h2 class="section-heading text-center mb-4">Give Us Your Feedback</h2>

                    <!-- Feedback Display Section -->
                    <div class="row d-flex justify-content-center mt-4">
                        <div class="col-md-8 col-lg-6">
                            <div class="card shadow-0 border" style="background-color: #f0f2f5;">
                                <div class="card-body p-4">
                                    <div class="text-end mb-4 border-bottom pb-3">
                                        <button type="button" class="btn btn-modern border" data-bs-toggle="modal" data-bs-target="#feedbackModal" style="border: 1px solid #ccc; border-radius: 5px;">
                                            <i class="fas fa-comments me-2"></i>Add Your Feedback
                                        </button>
                                    </div>
                                    <h5 class="card-title text-center mb-3">Recent Feedback</h5>
                                    <div id="feedbackList" class="feedback-list mb-4">
                                    </div>
                                    <div class="total-ratings">
                            <h6>Average Rating:</h6>
                            <small class="text-muted" id="averageRatingText">No Ratings Yet</small>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

</section>
</div>

        <!-- <section class="footer">
                <p>Copyright &copy; 2024.</p>
            </section> -->
    </div>
    
</div>
                <div class="modal fade custom-modal" id="newsModal" tabindex="-1" aria-labelledby="newsModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title" id="newsModalTitle">News Feed</h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div id="newsFeedContent" class="news-feed"></div>
                            </div>
                            <div class="modal-footer">
                                <!-- Optional footer buttons -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg"> <!-- Changed to modal-lg for consistency -->
                        <div class="modal-content" style="color: white">
                            <div class="modal-header">
                                <h3 class="modal-title" id="feedbackModalLabel">Feedback Form</h3> <!-- Changed to h3 for consistency -->
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
                                            <input type="email" class="form-control" name="email"id="email" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Name (optional)</label>
                                            <input type="text" class="form-control"  name="name" id="name">
                                        </div>
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Address (optional)</label>
                                            <input type="text" class="form-control" name="address" id="address">
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
                            <div class="modal-footer">
                                <!-- Optional footer buttons, if needed -->
                            </div>
                        </div>
                    </div>
                </div>

    <script>
        window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')
    </script>

    <!-- Popper.js and Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


    <!-- Custom JS and Plugins -->
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>
    
<script> 
    // Add event listener to toggle the icon on click
document.addEventListener('DOMContentLoaded', function () {
    var accordionItems = document.querySelectorAll('.accordion-button');
    
    accordionItems.forEach(function (item) {
        item.addEventListener('click', function () {
            var icon = this.querySelector('.faq-toggle-icon');
            if (this.classList.contains('collapsed')) {
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            } else {
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            }
        });
    });
});

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
});

$(document).ready(function () {
    $('#newsModal').on('show.bs.modal', function (e) {
        var title = $(e.relatedTarget).data('title');
        var imageSrc = $(e.relatedTarget).data('image');
        var profilePhoto = $(e.relatedTarget).data('profilephoto');
        var authorName = $(e.relatedTarget).data('author');
        var orgId = $(e.relatedTarget).data('orgid'); // Get org_id from the data attribute

        console.log('Organization ID:', orgId); // Debugging org_id to ensure it's fetched correctly

        // Initial fetch for announcements
        fetchAnnouncements(orgId, profilePhoto, authorName);
    });

    // Fetch announcements
    function fetchAnnouncements(orgId, profilePhoto, authorName) {
        $.ajax({
            url: 'ajax/fetch_announcement.php',
            type: 'POST',
            dataType: 'json',
            data: { org_id: orgId },
            success: function (response) {
                console.log('AJAX Success Response:', response);

                if (response.error) {
                    $('#newsFeedContent').html('<p>' + response.error + '</p>');
                    return;
                }

                var content = `
                    <div class="news-feed-item">
                        <div class="news-feed-header d-flex align-items-center mb-3">
                            <img src="${profilePhoto}" alt="Profile Photo" class="img-fluid rounded-circle profile-photo" style="width: 50px; height: 50px; margin-right: 10px;">
                            <h5 class="font-weight-bold mb-0">${authorName}</h5>
                            <button type="button" class="btn btn-secondary show-members-btn" data-orgid="${orgId}" id="modalShowMembersBtn">
                                Show Members
                            </button>
                        </div>
                `;

                if (response.announcements && response.announcements.length > 0) {
                    content += '<div class="announcement-details">';
                    response.announcements.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

                    response.announcements.forEach(function (announcement) {
                        var createdAt = new Date(announcement.created_at);
                        var timeAgo = formatRelativeTime(createdAt);
                        var sanitizedDetails = removeColorTags(announcement.announcement_details);

                        content += `
                            <p class="announcement-date mb-2"><strong>Created:</strong> ${timeAgo}</p>
                            <div class="announcement-item mb-3 p-3 border rounded announcement-item-bg">
                                <p class="announcement-details mb-1">${sanitizedDetails}</p>
                                ${announcement.announcement_image ? `<img src="uploaded/annUploaded/${announcement.announcement_image}" class="img-fluid mb-2 announcement-image">` : ''}
                            </div>`;
                    });
                    content += '</div>';
                } else {
                    content += '<p>No announcements found.</p>';
                }

                content += '</div>';
                $('#newsFeedContent').html(content);
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', status, error);
                $('#newsFeedContent').html('<p>An error occurred while fetching announcements. Please try again later.</p>');
            }
        });
    }

$(document).on('click', '.show-members-btn', function () {
    var orgId = $(this).data('orgid');
    fetchMembers(orgId);
});

// Fetch members based on org ID
function fetchMembers(orgId) {
    $.ajax({
        url: 'ajax/fetch_members.php', // Replace with the correct URL for fetching members
        type: 'POST',
        dataType: 'json',
        data: { org_id: orgId },
        success: function (response) {
            console.log('AJAX Success Response (Members):', response);

            if (response.error) {
                $('#newsFeedContent').html('<p>' + response.error + '</p>');
                return;
            }

            var membersContent = `
    <div class="members-list">
        <h5 style="color: yellow;">Members</h5>
        <div class="row">
`;

if (response.members && response.members.length > 0) {
    response.members.forEach(function (member, index) {
        // Open a new row after every 4 members
        if (index % 4 === 0 && index > 0) {
            membersContent += `</div><div class="row">`; // Close and open a new row
        }
        
        membersContent += `
    <div class="col-md-3 mb-4"> <!-- Use col-md-3 for four cards per row -->
    <div class="card profile-card">
        <img src="uploaded/orgUploaded/${member.member_img}" alt="${member.name}" class="card-img-top profile-img">
        <div class="card-body">
            <h5 class="card-title profile-name">${member.name}</h5>
            <p class="card-text profile-username">@${member.username}</p>
        </div>
    </div>
</div>


        `;
    });
} else {
    membersContent += `<p>No members found.</p>`; // Handle case with no members
}

membersContent += `
        </div> <!-- Close the last row -->
    </div>
`;

            $('#newsFeedContent').html(membersContent);
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error (Members):', status, error);
            $('#newsFeedContent').html('<p>An error occurred while fetching members. Please try again later.</p>');
        }
    });
}

    // Utility function to remove font tags and color styles
    function removeColorTags(content) {
        return content
            .replace(/<font[^>]*>/g, '') // Remove <font> tags
            .replace(/<\/font>/g, '')    // Remove </font> tags
            .replace(/style="[^"]*color:[^;"]*;?"/g, ''); // Remove inline color styles
    }

    // Utility function to format relative time
    function formatRelativeTime(date) {
        var now = new Date();
        var diff = Math.floor((now - date) / 1000); // Get difference in seconds

        var seconds = diff;
        var minutes = Math.floor(seconds / 60);
        var hours = Math.floor(minutes / 60);
        var days = Math.floor(hours / 24);

        if (days > 1) {
            return date.toLocaleDateString(); // Return the full date
        } else if (days === 1) {
            return '1 day ago';
        } else if (hours > 0) {
            return hours + ' hours ago';
        } else if (minutes > 0) {
            return minutes + ' minutes ago';
        } else {
            return 'just now';
        }
    }
});

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
    $('#myModal').modal({
    backdrop: false // Disable the backdrop
});
    // Adjust modal position when the page loads
    window.addEventListener('load', adjustModalPosition);

    // Adjust modal position when the window is resized
    window.addEventListener('resize', adjustModalPosition);


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
                    newFeedback.className = 'card mb-4 card-body floating-card'; // Add card styling
                       // Use a default image if no image is uploaded
                       const imageUrl = feedback.image; // Set your default image path here
                    newFeedback.innerHTML = `
                     
                       
                            <div class="second py-2 px-2"><span class="text1">${feedback.feedback_text}</span></div>

                            <div class="d-flex justify-content-between py-1 pt-2">
                                <div><img src="${imageUrl}" width="18"><span class="text2">${feedback.name || 'Anonymous'} (${feedback.email}</span></div>
                            </div>

                            <p class="card-text">
                                <small class="text-muted">
                                    Course: ${feedback.college || 'N/A'} | ${getYearWithSuffix(feedback.year) || 'N/A'}
                                </small>
                            </p>
                        </div>
                        `;
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
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script> -->

</body>

</html>