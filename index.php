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
        .tab-navigation {
        text-align: center;
        margin-bottom: 20px;
    }
    .tab-button {
        background-color: #f1f1f1;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        margin: 0 5px;
    }
    .tab-button.active {
        background-color: #ccc;
        font-weight: bold;
    }
    .tab-content {
        display: block;
    }
    .tab-content.active {
        display: block;
    }
    .svg-container {
        width: 100%;
        overflow: auto;
    }
    .map-building {
        cursor: pointer;
        transition: fill 0.3s;
    }
    .map-building:hover {
        fill: orange;
    }
        .highlight {
            fill: yellow; /* Highlight color */
        }
        svg {
            width: 100%;
            height: auto;
        }
        
        /* Hover effects */
        rect {
            transition: fill 0.3s;
                
        }

        rect:hover {
            fill: #B0B0B0; /* Change color on hover */
        }

        text {
            font-family: Arial, sans-serif;
            
            fill: black;
            pointer-events: none; /* Prevent hover effects on text */
        }
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

@media (max-width: 576px) {
    .section-heading h1 {
        font-size: 1.25em;
    }

    .content-section {
        padding: 10px;
    }

    .item {
        padding: 10px;
    }

    .timestamp {
        font-size: 0.7em;
        text-align: left;
    }

    .text-content {
        flex-direction: column;
        align-items: flex-start;
    }

    .text-content img.avaatar {
        width: 40px;
        height: 40px;
        margin: 0 0 5px 0;
    }

    .text-content span {
        font-size: 0.9em;
    }

    .square img {
        max-width: 90%;
        margin: 5px 0;
    }
    .fclty-div {
        flex-direction: row; /* Stack buttons vertically */
        align-items: center;
    }

    .button-faculty-btn {
        width: 20%; /* Adjust width to fit screen */
        padding: 15px;
        font-size: 10px; /* Smaller font for smaller screens */
    }
}
/* Set a wider max-width for the item section */
.item {
    max-width: 600px; /* Adjusted max-width to make the card wider */
    width: 100%;
    margin: 0 auto;
    padding: 20px;
    background-color: #1a1a1a;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    color: #ffd700; /* Yellow text color */
}

/* Adjust the font size and alignment for better readability */
.item h4 {
    font-size: 1.5em;
    text-align: center;
    color: #ffd700; /* Yellow for headings */
    margin-bottom: 10px;
}

.item .text-content {
    padding: 15px;
    color: #ffd700; /* Yellow text color */
}

.item table {
    width: 100%;
    border-collapse: collapse;
}

/* Change the text color to yellow and improve spacing */
.item table td {
    padding: 10px;
    border-bottom: 1px solid #444;
    font-size: 1.1em;
    color: #ffd700; /* Yellow for event details */
}

.item table td:first-child {
    font-weight: bold;
}

.item table td:last-child {
    font-style: italic;
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
                <li class="nav-item"><a class="nav-link" href="#aboutus ">ABOUT US</a></li>
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
            <li class="nav-item">
                <a class="nav-link" href="#aboutus">
                    <span class="rect"></span>
                    <span class="circle"></span>
                    ABOUT US
                </a>
            </li>
        </ul>
    </nav>
   
</div>
    <div class="page-content">

    
    <?php
// Database connection (assuming you have a PDO connection)
$dsn = 'mysql:host=localhost;dbname=ckiosk';
$username = 'root';
$password = '';
$connection = new PDO($dsn, $username, $password);

// Set the default timezone to Asia/Manila
date_default_timezone_set('Asia/Manila');

function getAnnouncements($connection, $userId) {
    // Query to get the user's organization from users_tbl
    $orgQuery = "SELECT users_org FROM users_tbl WHERE users_id = :userId";
    $orgStatement = $connection->prepare($orgQuery);
    $orgStatement->bindValue(':userId', $userId, PDO::PARAM_INT);
    $orgStatement->execute();
    $orgRow = $orgStatement->fetch(PDO::FETCH_ASSOC);
    
    // Safely escape the organization ID
    $userOrgId = $orgRow ? intval($orgRow['users_org']) : 0;

    // If the user has no organization, return an empty result or error message
    if ($userOrgId == 0) {
        return "No organization found for the user.";
    }

    // Main announcement query, filtered by the user's organization
    $query = "
        SELECT a.*, 
               u.users_username AS author_name, 
               COALESCE(c.users_username, o.username, 'Unknown Creator') AS creator_name, 
               org.org_name, 
               org.org_image 
        FROM announcement_tbl a 
        LEFT JOIN users_tbl u ON a.announcement_creator = u.users_id 
        LEFT JOIN users_tbl c ON a.created_by = c.users_id  
        LEFT JOIN orgmembers_tbl o ON a.created_by = o.id  
        LEFT JOIN organization_tbl org ON u.users_org = org.org_id  
        WHERE u.users_org = :userOrgId AND a.is_archived = 0
    ";

    // Prepare and execute the statement
    $statement = $connection->prepare($query);
    $statement->bindValue(':userOrgId', $userOrgId, PDO::PARAM_INT);

    if ($statement->execute()) {
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Clean and prepare data for output
        foreach ($result as &$row) {
            $row['org_image'] = isset($row['org_image']) && !empty($row['org_image'])
                                ? htmlspecialchars($row['org_image'], ENT_QUOTES, 'UTF-8')
                                : 'default_org_image.jpg'; 

            // Sanitize creator name
            $row['creator_name'] = htmlspecialchars($row['creator_name'], ENT_QUOTES, 'UTF-8');

            // Ensure the org_name has a default if not found
            $row['org_name'] = isset($row['org_name']) && !empty($row['org_name'])
                               ? htmlspecialchars($row['org_name'], ENT_QUOTES, 'UTF-8')
                               : 'Unknown Organization'; 
        }

        return $result;
    } else {
        return "No Data";
    }

    
}

// Fetch the user's ID based on session variable
$userId = isset($_SESSION['aid']) ? intval($_SESSION['aid']) : 0;

// Get announcements
$allAnnouncement = getAnnouncements($connection, $userId);
?>

<!-- HTML Section -->
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
                        Created <?= $timeAgo ?> by <?= $row['creator_name'] ?>
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
        echo '<li style="color: white;">No announcements found.</li>';
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
                        $today = date('Y-m-d');
                        $todayEvents = [];
                        $upcomingEvents = [];

                        foreach ($allEvent as $month => $events) {
                            foreach ($events as $event) {
                                if (isset($event['calendar_date'], $event['calendar_id'], $event['calendar_details'])) {
                                    if ($event['calendar_date'] === $today) {
                                        $todayEvents[] = $event;
                                    } elseif ($event['calendar_date'] > $today) {
                                        $upcomingEvents[] = $event;
                                    }
                                }
                            }
                        }

                        if (!empty($todayEvents)) {
                            echo '<li>';
                            echo '<div class="item">';
                            echo '<div class="text-content">';
                            echo '<h4>Happening Today</h4>';
                            echo '<table>';
                            
                            foreach ($todayEvents as $event) {
                                echo '<tr>';
                                echo '<td>' . htmlspecialchars($event['calendar_date']) . '</td>';
                                echo '<td>' . htmlspecialchars(strip_tags($event['calendar_details'])) . '</td>';
                                echo '</tr>';
                            }
                            
                            echo '</table>';
                            echo '</div>';
                            echo '</div>';
                            echo '</li>';
                        }

                        if (!empty($upcomingEvents)) {
                            echo '<li>';
                            echo '<div class="item">';
                            echo '<div class="text-content">';
                            echo '<h4>Upcoming Events</h4>';
                            echo '<table>';
                            
                            foreach ($upcomingEvents as $event) {
                                echo '<tr>';
                                echo '<td>' . htmlspecialchars($event['calendar_date']) . '</td>';
                                echo '<td>' . htmlspecialchars(strip_tags($event['calendar_details'])) . '</td>';
                                echo '</tr>';
                            }
                            
                            echo '</table>';
                            echo '</div>';
                            echo '</div>';
                            echo '</li>';
                        }

                        if (empty($todayEvents) && empty($upcomingEvents)) {
                            echo '<li>';
                            echo '<div class="item">';
                            echo '<div class="text-content">';
                            echo '<h4>No Events Happening Today or Upcoming</h4>';
                            echo '</div>';
                            echo '</div>';
                            echo '</li>';
                        }
                        ?>
                    </ul>
                </section>
            </div>
        </div>
    </div>
</section>




<section id="campusmap" class="content-section">
    <div class="section-heading text-center borderYellow">
        <h1><br><em>CAMPUS MAP</em></h1>
    </div>

    <!-- Tab Navigation -->
    <div class="tab-container">
    <button class="tab-button active" onclick="openTab(event, 'ccs')">CCS</button>
    <button class="tab-button" onclick="openTab(event, 'cit')">CIT</button>
    <button class="tab-button" onclick="openTab(event, 'cafa')">CAFA</button>
    </div>

    <!-- Floor Map Section -->
    <div id="ccs" class="tab-content">
        <div id="map">
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
                                <td class="floor-gray" colspan="2" id="1" style="height: 100px;"></td>
                                <td id="2" class="floor-gray" rowspan="2" style="width: 120px;"></td>
                                <td id="3" class="floor-gray" rowspan="2" style="width: 120px;"></td>
                                <td id="4" class="floor-gray" colspan="2" rowspan="2"></td>
                                <td id="5" class="floor-gray" rowspan="2" style="width: 70px;"></td>
                                <td id="6" class="floor-gray" rowspan="2" style="width: 70px;"></td>
                                <td id="7" class="floor-gray" colspan="2"></td>
                            </tr>
                            <tr>
                                <td id="8" class="floor-gray" colspan="2" style="height: 50px;"></td>
                                <td id="9" class="floor-gray" colspan="2"></td>
                            </tr>
                            <tr>
                                <td class="floor-gray" colspan="2" id="10">0</td>
                                <td id="11" class="floor-maroon" colspan="6" rowspan="4">1</td>
                                <td id="12" class="floor-gray" colspan="2">2</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="floor-gray" id="13">3</td>
                                <td id="14" class="floor-gray" colspan="2">4</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="floor-gray" id="15" style="height: 60px;">5</td>
                                <td id="16" class="floor-gray" colspan="2">6</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="floor-gray" id="17" style="height: 50px;">7</td>
                                <td id="18" class="floor-gray" colspan="2">8</td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="floor-table" id="floor-2" border="1">
                        <tbody>
                            <tr>
                                <td colspan="2" class="floor-gray" id="19" style="height: 100px;">18</td>
                                <td id="20" class="floor-gray" rowspan="2">19</td>
                                <td id="21" class="floor-gray" rowspan="2">20</td>
                                <td id="22" class="floor-gray" rowspan="2">21</td>
                                <td id="23" class="floor-gray" rowspan="2">22</td>
                                <td id="24" class="floor-gray" colspan="2" rowspan="2">23</td>
                                <td id="25" class="floor-gray" colspan="2">24</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="floor-gray" id="26" style="height: 50px;">25</td>
                                <td id="27" class="floor-gray" colspan="2">26</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="floor-gray" id="28">27</td>
                                <td id="29" class="floor-maroon" colspan="6" rowspan="4">138</td>
                                <td id="32" class="floor-gray" colspan="2">29</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="floor-gray" id="31">30</td>
                                <td id="30" class="floor-gray" colspan="2">31</td>
                            </tr>
                            <tr>
                                <td colspan="2" id="33" class="floor-gray" style="height: 60px;">32</td>
                                <td id="34" class="floor-gray" colspan="2">33</td>
                            </tr>
                            <tr>
                                <td colspan="2" id="35" class="floor-gray" style="height: 50px;">34</td>
                                <td id="36" class="floor-gray" colspan="2">35</td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="floor-table" id="floor-3" border="1">
                        <tbody>
                            <tr>
                                <td colspan="2" id="37" class="floor-gray" style="height: 100px;">18</td>
                                <td id="38" rowspan="2" class="floor-gray">19</td>
                                <td id="39" rowspan="2" class="floor-gray">20</td>
                                <td id="40" rowspan="2" class="floor-gray">21</td>
                                <td id="41" rowspan="2" class="floor-gray">22</td>
                                <td id="42" colspan="2" rowspan="2" class="floor-gray">23</td>
                                <td id="43" colspan="2" class="floor-gray">24</td>
                            </tr>
                            <tr>
                                <td colspan="2" id="44" style="height: 50px;" class="floor-gray">25</td>
                                <td id="45" colspan="2" class="floor-gray">26</td>
                            </tr>
                            <tr>
                                <td colspan="2" id="46" class="floor-gray">27</td>
                                <td id="47" colspan="6" rowspan="4" class="floor-maroon">138</td>
                                <td id="48" colspan="2" class="floor-gray">29</td>
                            </tr>
                            <tr>
                                <td colspan="2" id="50" class="floor-gray">30</td>
                                <td id="49" colspan="2" class="floor-gray">31</td>
                            </tr>
                            <tr>
                                <td colspan="2" id="51" style="height: 60px;" class="floor-gray">32</td>
                                <td id="52" colspan="2" class="floor-gray">33</td>
                            </tr>
                            <tr>
                                <td colspan="2" id="53" style="height: 50px;" class="floor-gray">34</td>
                                <td id="54" colspan="2" class="floor-gray">35</td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="floor-table" id="floor-4" border="1">
                        <tbody>
                            <tr>
                                <td colspan="2" id="55" style="height: 100px;" class="floor-gray">18</td>
                                <td id="56" rowspan="2" class="floor-gray">19</td>
                                <td id="57" rowspan="2" class="floor-gray">20</td>
                                <td id="58" rowspan="2" class="floor-gray">21</td>
                                <td id="59" rowspan="2" class="floor-gray">22</td>
                                <td id="60" rowspan="2" class="floor-gray">23</td>
                                <td id="61" rowspan="2" class="floor-gray">23</td>
                                <td id="62" colspan="2" class="floor-gray">24</td>
                            </tr>
                            <tr>
                                <td colspan="2" id="63" style="height: 50px;" class="floor-gray">25</td>
                                <td id="64" colspan="2" class="floor-gray">26</td>
                            </tr>
                            <tr>
                                <td colspan="2" id="65" class="floor-gray">27</td>
                                <td id="66" colspan="6" rowspan="4" class="floor-maroon">138</td>
                                <td id="67" colspan="2" class="floor-gray">29</td>
                            </tr>
                            <tr>
                                <td colspan="2" id="68" class="floor-gray">30</td>
                                <td id="69" colspan="2" class="floor-gray">31</td>
                            </tr>
                            <tr>
                                <td colspan="2" id="70" style="height: 60px;" class="floor-gray">32</td>
                                <td id="71" colspan="2" class="floor-gray">33</td>
                            </tr>
                            <tr>
                                <td colspan="2" id="72" style="height: 50px;" class="floor-gray">34</td>
                                <td id="73" colspan="2" class="floor-gray">35</td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="floor-table" id="floor-5" border="1">
                        <tbody>
                            <tr>
                                <td colspan="2" id="74" style="height: 100px;" class="floor-gray">18</td>
                                <td id="75" rowspan="2" class="floor-gray">19</td>
                                <td id="76" rowspan="2" class="floor-gray">20</td>
                                <td id="77" rowspan="2" class="floor-gray">21</td>
                                <td id="78" rowspan="2" class="floor-gray">22</td>
                                <td id="79" rowspan="2" class="floor-gray">23</td>
                                <td id="80" rowspan="2" class="floor-gray">23</td>
                                <td id="81" colspan="2" class="floor-gray">24</td>
                            </tr>
                            <tr>
                                <td colspan="2" id="82" style="height: 50px;" class="floor-gray">25</td>
                                <td id="83" colspan="2" class="floor-gray">26</td>
                            </tr>
                            <tr>
                                <td colspan="2" id="84" class="floor-gray">27</td>
                                <td id="85" colspan="6" rowspan="4" class="floor-maroon">138</td>
                                <td id="86" colspan="2" class="floor-gray">29</td>
                            </tr>
                            <tr>
                                <td colspan="2" id="87" class="floor-gray">30</td>
                                <td id="88" colspan="2" class="floor-gray">31</td>
                            </tr>
                            <tr>
                                <td colspan="2" id="89" style="height: 60px;" class="floor-gray">32</td>
                                <td id="90" colspan="2" class="floor-gray">33</td>
                            </tr>
                            <tr>
                                <td colspan="2" id="91" style="height: 50px;" class="floor-gray">34</td>
                                <td id="92" colspan="2" class="floor-gray">35</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

            <!-- SVG Map Section -->
            <div id="cit" class="tab-content" style="display: none;">
    <div id="map">
        <div class="map section-content-map">
            <div class="dropdown">
                <input type="text" id="search" placeholder="Enter room name">
                <button onclick="searchElement()" class="search-button">
                    <i class="fa fa-search"></i>
                </button>
            </div>
            <div class="table-container">
                <svg id="room-svg" viewBox="0 0 985 588" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect  x="40.5" y="205.5" width="52" height="95" fill="#D9D9D9" stroke="black"/>
                    <rect  x="220.5" y="205.5" width="53" height="95" fill="#D9D9D9" stroke="black"/>
                    <rect id="cit-5-a-b" x="167.5" y="205.5" width="52" height="95" fill="#D9D9D9" stroke="black"/>
                    <text id="stock-room" x="195" y="250" text-anchor="middle" font-size="12">
                        STOCK
                        <tspan dy="1.2em" dx="-44">ROOM</tspan>
                    </text>
                    <rect id="ctl-1-a" x="40.5" y="301.5" width="52" height="67" fill="#D9D9D9" stroke="black"/>
                    <text id="ctl-1-a-text" x="63" y="335" text-anchor="middle" font-size="12">CTL 1-A</text>
                    <rect id="cit-3-b-rect" x="303.5" y="72.5" width="49" height="69" fill="#D9D9D9" stroke="black"/>
                    <text id="cit-3-b-text" x="328" y="105" text-anchor="middle" font-size="12">CIT 3-B</text>
                    <rect id="cit-5-a-b-rect" x="353.5" y="72.5" width="53" height="69" fill="#D9D9D9" stroke="black"/>
                    <rect id="cit-5-a-b-combined" x="361.5" y="205.5" width="90" height="95" fill="#D9D9D9" stroke="black"/>
                    <text id="cit-5-a-b-text" x="406" y="250" text-anchor="middle" font-size="12">CIT 5-A & 5-B
                        <tspan dy="1.2em" dx="-80">ELECTRICAL</tspan>
                    </text>
                    <rect id="etl-5" x="452.5" y="205.5" width="90" height="95" fill="#D9D9D9" stroke="black"/>
                    <text id="etl-5-text" x="497" y="250" text-anchor="middle" font-size="12">ETL 5</text>
                    <rect id="cit-5-b-lec" x="543.5" y="205.5" width="90" height="95" fill="#D9D9D9" stroke="black"/>
                    <text id="cit-5-b-lec-text" x="588" y="250" text-anchor="middle" font-size="12">CIT 5-B LEC</text>
                    <rect id="bodega" x="634.5" y="205.5" width="90" height="95" fill="#D9D9D9" stroke="black"/>
                    <text id="bodega-text" x="679" y="250" text-anchor="middle" font-size="12">BODEGA</text>
                    <rect id="library" x="725.5" y="205.5" width="89" height="95" fill="#D9D9D9" stroke="black"/>
                    <text id="library-text" x="770" y="250" text-anchor="middle" font-size="12">LIBRARY</text>
                    <rect id="chairperson-office" x="220.5" y="136.5" width="53" height="68" fill="#D9D9D9" stroke="black"/>
                    <text id="chairperson-office-text" x="250" y="170" text-anchor="middle" font-size="8">
                        CHAIRPERSON
                        <tspan dy="1.2em" dx="-44">OFFICE</tspan>
                    </text>
                    <rect id="d-o" x="40.5" y="369.5" width="52" height="68" fill="#D9D9D9" stroke="black"/>
                    <text id="d-o-text" x="63" y="405" text-anchor="middle" font-size="12">D.O.</text>
                    <rect id="cr" x="40.5" y="438.5" width="52" height="69" fill="#D9D9D9" stroke="black"/>
                    <text id="cr-text" x="63" y="475" text-anchor="middle" font-size="12">CR</text>
                    <rect id="cit-2-a" x="93.5" y="205.5" width="73" height="46" fill="#D9D9D9" stroke="black"/>
                    <text id="cit-2-a-text" x="130" y="230" text-anchor="middle" font-size="12">CIT 2-A</text>
                    <path id="welding" d="M274 205H361V301H274V205Z" fill="#D9D9D9"/>
                    <text id="welding-text" x="317" y="250" text-anchor="middle" font-size="12">WELDING</text>
                    <rect id="cit-3-a" x="220.5" y="72.5" width="82" height="69" fill="#D9D9D9" stroke="black"/>
                    <text id="cit-3-a-text" x="261" y="105" text-anchor="middle" font-size="12">CIT 3-A</text>
                    <rect id="cit-2-b" x="93.5" y="252.5" width="73" height="48" fill="#D9D9D9" stroke="black"/>
                    <text id="cit-2-b-text" x="130" y="280" text-anchor="middle" font-size="12">CIT 2-B</text>
                    <path id="pantry" d="M274 142H407V205H274V142Z" fill="#D9D9D9"/>
                    <text id="pantry-text" x="340" y="172" text-anchor="middle" font-size="12">PANTRY</text>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M405.629 205H407V142H405.629V205Z" fill="black"/>
                    <rect id="breaker" x="815.5" y="180.5" width="39" height="48" fill="#D9D9D9" stroke="black"/>
                    <text id="breaker-text" x="834" y="205" text-anchor="middle" font-size="8">BREAKER</text>
                    <rect id="ctl-6" x="855.5" y="286.5" width="89" height="94" fill="#D9D9D9" stroke="black"/>
                    <text id="ctl-6-text" x="900" y="322" text-anchor="middle" font-size="12">CTL 6</text>
                    <rect id="ctl-6-a-b" x="855.5" y="190.5" width="89" height="95" fill="#D9D9D9" stroke="black"/>
                    <text id="ctl-6-a-b-text" x="900" y="225" text-anchor="middle" font-size="12">CTL 6-A & 6-B</text>
                </svg>
            </div>
        </div>
    </div>
    </div>
    <div id="cafa" class="tab-content" style="display: none;">
    <div id="map">
        <div class="map section-content-map">
            <div class="dropdown">
                <input type="text" id="search2" placeholder="Enter room name" aria-label="Search for a room">
                <button onclick="searchElement2()" class="search-button" aria-label="Search">
                    <i class="fa fa-search"></i>
                </button>
                <select id="dropdown" aria-label="Select floor" onchange="showFloor(this.value)">
                    <option value="1" selected>1st Floor</option>
                    <option value="2">2nd Floor</option>
                    <option value="3">3rd Floor</option>
                </select>
            </div>

            <div class="table-container">
                <!-- Floor 1 -->
                <!--floor 1-->
         <svg id="room-svg-1" class="floor-svg" viewBox="0 0 1200 300" fill="none" xmlns="http://www.w3.org/2000/svg">
         <rect id="stairs-rect" x="140.5" y="140.5" width="61" height="100" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="stairs-text" x="171" y="190" font-family="Arial" font-size="12" text-anchor="middle">STAIRS</text>
    
    <rect id="men-cr-rect" x="332.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="men-cr-text" x="370" y="190" font-family="Arial" font-size="12" text-anchor="middle">MALE CR</text>
    

    
    <rect id="female-cr-rect" x="473.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="female-cr-text" x="511" y="190" font-family="Arial" font-size="12" text-anchor="middle">FEMALE CR</text>
    
    <rect id="s-104-rect" x="620.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="s-104-text" x="650" y="190" font-family="Arial" font-size="12" text-anchor="middle">S-104</text>
    
    <rect id="s-106-rect" x="550" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="s-106-text" x="585" y="190" font-family="Arial" font-size="12" text-anchor="middle">S-106</text>
    
    <rect id="s-102-rect" x="755" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="s-102-text" x="780" y="190" font-family="Arial" font-size="12" text-anchor="middle">S-102</text>
    
    <rect id="s-103-rect" x="680.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="s-103-text" x="720" y="190" font-family="Arial" font-size="12" text-anchor="middle">S-103</text>
    
    <rect id="s-101-rect" x="890" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="s-101-text" x="930" y="190" font-family="Arial" font-size="12" text-anchor="middle">S-101</text>
    
    <rect id="male-cr-rect" x="820.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="male-cr-text" x="860" y="190" font-family="Arial" font-size="12" text-anchor="middle">MALE CR</text>
    
    <rect id="s-109-rect" x="202.5" y="140.5" width="64" height="65" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="s-109-text" x="230" y="170" font-family="Arial" font-size="12" text-anchor="middle">S-109</text>

    <rect id="pwd-cr-base-rect" x="408.5" y="140.5" width="64" height="53" fill="#D9D9D9" stroke="#0D0D0D"/>
    <rect id="pwd-cr-rect" x="408.5" y="193.5" width="64" height="53" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="pwd-cr-text" x="440" y="220" font-family="Arial" font-size="12" text-anchor="middle">PWD CR</text>
    
    <rect id="stairs-2-rect" x="965" y="140.5" width="64" height="54" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="stairs-2-text" x="1000" y="170" font-family="Arial" font-size="12" text-anchor="middle">STAIRS</text>
    
    <mask id="path-18-inside-1_0_1" fill="white">
        <path d="M267 140H332V206H267V140Z"/>
    </mask>
    
    <path d="M267 140H332V206H267V140Z" fill="#D9D9D9"/>
    <path d="M267 141H332V139H267V141Z" fill="#0D0D0D" mask="url(#path-18-inside-1_0_1)"/>
    
    <rect id="s-108-rect" x="202.5" y="206.5" width="64" height="65" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="s-108-text" x="230" y="240" font-family="Arial" font-size="12" text-anchor="middle">S-108</text>
</svg>
<!--floor 2-->
<svg id="room-svg-2" class="floor-svg" style="display:none;" width="1367" height="472" viewBox="0 0 1367 472" fill="none" xmlns="http://www.w3.org/2000/svg">
    <rect id="stairs-rect" x="140.5" y="140.5" width="61" height="84" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="stairs-text" x="150" y="182" font-family="Arial" font-size="12" fill="black">STAIRS</text>

    <rect id="male-cr-rect" x="332.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="male-cr-text" x="340" y="182" font-family="Arial" font-size="12" fill="black">MALE CR</text>

    <rect id="s-205-rect" x="570.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="s-205-text" x="600" y="182" font-family="Arial" font-size="12" fill="black">S-205</text>

    <rect id="s-206-rect" x="494.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="s-206-text" x="520" y="182" font-family="Arial" font-size="12" fill="black">S-206</text>

    <rect id="s-201-rect" x="1022.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="s-201-text" x="1050" y="182" font-family="Arial" font-size="12" fill="black">S-201</text>

    <rect id="s-204-rect" x="643.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="s-204-text" x="673" y="182" font-family="Arial" font-size="12" fill="black">S-204</text>

    <rect id="female-cr-rect" x="946.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="female-cr-text" x="950" y="182" font-family="Arial" font-size="12" fill="black">FEMALE CR</text>

    <rect id="s-202-rect" x="831.5" y="140.5" width="114" height="106" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="s-202-text" x="860" y="182" font-family="Arial" font-size="12" fill="black">S-202</text>

    <rect id="s-203-rect" x="716.5" y="140.5" width="114" height="106" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="s-203-text" x="745" y="182" font-family="Arial" font-size="12" fill="black">S-203</text>

    <rect id="s-208-rect" x="202.5" y="140.5" width="130" height="107" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="s-208-text" x="244" y="200" font-family="Arial" font-size="12" fill="black">S-208</text>

    <rect id="s-207-rect" x="408.5" y="140.5" width="85" height="106" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="s-207-text" x="435" y="182" font-family="Arial" font-size="12" fill="black">S-207</text>

    <rect id="stairs-2-rect" x="1098.5" y="140.5" width="64" height="54" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="stairs-2-text" x="1106" y="165" font-family="Arial" font-size="12" fill="black">STAIRS</text>
</svg>
<!--floor 3-->
<svg id="room-svg-3" class="floor-svg" style="display:none;" width="1367" height="472" viewBox="0 0 1367 472" fill="none" xmlns="http://www.w3.org/2000/svg">
    <rect id="stairs-1" x="140.5" y="140.5" width="61" height="84" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="stairs-1-text" x="150" y="182" font-family="Arial" font-size="12" fill="black">STAIRS</text>

    <rect id="male-cr-rect" x="332.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="male-cr-text" x="340" y="182" font-family="Arial" font-size="12" fill="black">S-307</text>

    <rect id="male-cr-2-rect" x="570.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="male-cr-2-text" x="580" y="182" font-family="Arial" font-size="12" fill="black">MALE CR</text>

    <rect id="female-cr-1-rect" x="494.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="female-cr-1-text" x="498" y="182" font-family="Arial" font-size="12" fill="black">FEMALE CR</text>

    <rect id="s-301-rect" x="1022.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="s-301-text" x="1050" y="182" font-family="Arial" font-size="12" fill="black">S-301</text>

    <rect id="s-305-rect" x="643.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="s-305-text" x="673" y="182" font-family="Arial" font-size="12" fill="black">S-305</text>

    <rect id="female-cr-2-rect" x="946.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="female-cr-2-text" x="950" y="182" font-family="Arial" font-size="8" fill="black">FACULTY ROOM</text>

    <rect id="s-303-rect" x="831.5" y="140.5" width="114" height="106" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="s-303-text" x="860" y="182" font-family="Arial" font-size="12" fill="black">S-303</text>

    <rect id="s-304-rect" x="716.5" y="140.5" width="114" height="106" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="s-304-text" x="745" y="182" font-family="Arial" font-size="12" fill="black">S-304</text>

    <rect id="uapsa-rect" x="202.5" y="140.5" width="130" height="107" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="uapsa-text" x="244" y="200" font-family="Arial" font-size="12" fill="black">UAPSA</text>

    <rect id="s-306-rect" x="408.5" y="140.5" width="85" height="106" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="s-306-text" x="435" y="182" font-family="Arial" font-size="12" fill="black">S-306</text>

    <rect id="stairs-2-rect" x="1098.5" y="140.5" width="64" height="54" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="stairs-2-text" x="1106" y="165" font-family="Arial" font-size="12" fill="black">STAIRS</text>
</svg>


            </div>
        </div>
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
                        <div class="member" data-name="<?= htmlspecialchars($head['faculty_name']) ?>" 
                             data-specialization="<?= htmlspecialchars($head['specialization']) ?>" 
                             data-consultation="<?= htmlspecialchars($head['consultation_time']) ?>" 
                             data-image="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>">
                            <img src="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>" alt="Dean">
                            <p><strong><?= htmlspecialchars($head['faculty_name']) ?></strong><?= htmlspecialchars($head['department_name']) ?></p>
                        </div>
                    <?php endforeach; ?>
            </div>
    
            <div class="level2">
                <?php foreach ($all2 as $head): ?>
                    <div class="member" data-name="<?= htmlspecialchars($head['faculty_name']) ?>" 
                             data-specialization="<?= htmlspecialchars($head['specialization']) ?>" 
                             data-consultation="<?= htmlspecialchars($head['consultation_time']) ?>" 
                             data-image="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>">
                        <img src="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>" alt="Dean">
                        <p><strong><?= htmlspecialchars($head['faculty_name']) ?></strong><br><?= htmlspecialchars($head['department_name']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>

    
            <div class="level3">
                     <?php foreach ($all3 as $head): ?>
                        <div class="member" data-name="<?= htmlspecialchars($head['faculty_name']) ?>" 
                             data-specialization="<?= htmlspecialchars($head['specialization']) ?>" 
                             data-consultation="<?= htmlspecialchars($head['consultation_time']) ?>" 
                             data-image="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>">
                            <img src="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>" alt="Dean">
                            <p><strong><?= htmlspecialchars($head['faculty_name']) ?></strong><br><?= htmlspecialchars($head['department_name']) ?></p>
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
                    <div class="member" data-name="<?= htmlspecialchars($head['faculty_name']) ?>" 
                             data-specialization="<?= htmlspecialchars($head['specialization']) ?>" 
                             data-consultation="<?= htmlspecialchars($head['consultation_time']) ?>" 
                             data-image="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>">
                            <img src="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>" alt="Dean">
                            <p><strong><?= htmlspecialchars($head['faculty_name']) ?> </strong><br><?= htmlspecialchars($head['department_name']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
    
                <div class="level2">
                    <?php foreach ($allItHeads as $head): ?>
                        <div class="member" data-name="<?= htmlspecialchars($head['faculty_name']) ?>" 
                             data-specialization="<?= htmlspecialchars($head['specialization']) ?>" 
                             data-consultation="<?= htmlspecialchars($head['consultation_time']) ?>" 
                             data-image="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>">
                            <img src="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>" alt="Dean">
                            <p><strong><?= htmlspecialchars($head['faculty_name']) ?></strong><br><?= htmlspecialchars($head['department_name']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
    
                <!-- Faculty Members -->
                <h3>Faculty Members</h3>
                <div class="level3">
                    <?php foreach ($allIt as $head): ?>
                        <div class="member" data-name="<?= htmlspecialchars($head['faculty_name']) ?>" 
                             data-specialization="<?= htmlspecialchars($head['specialization']) ?>" 
                             data-consultation="<?= htmlspecialchars($head['consultation_time']) ?>" 
                             data-image="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>">
                            <img src="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>" alt="Dean">
                            <p><strong><?= htmlspecialchars($head['faculty_name']) ?></strong><br><?= htmlspecialchars($head['department_name']) ?></p>
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
                        <div class="member" data-name="<?= htmlspecialchars($head['faculty_name']) ?>" 
                             data-specialization="<?= htmlspecialchars($head['specialization']) ?>" 
                             data-consultation="<?= htmlspecialchars($head['consultation_time']) ?>" 
                             data-image="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>">
                            <img src="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>" alt="Dean">
                            <p><strong><?= htmlspecialchars($head['faculty_name']) ?></strong><br><?= htmlspecialchars($head['department_name']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
    
                <div class="level2">
                    <?php foreach ($allIsHeads as $head): ?>
                        <div class="member" data-name="<?= htmlspecialchars($head['faculty_name']) ?>" 
                             data-specialization="<?= htmlspecialchars($head['specialization']) ?>" 
                             data-consultation="<?= htmlspecialchars($head['consultation_time']) ?>" 
                             data-image="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>">
                            <img src="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>" alt="Dean">
                            <p><strong><?= htmlspecialchars($head['faculty_name']) ?></strong><br><?= htmlspecialchars($head['department_name']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
    
                <!-- Faculty Members for IS Department -->
                <h3>Faculty Members</h3>
                <div class="level3">
                    <?php foreach ($allIs as $head): ?>
                        <div class="member" data-name="<?= htmlspecialchars($head['faculty_name']) ?>" 
                             data-specialization="<?= htmlspecialchars($head['specialization']) ?>" 
                             data-consultation="<?= htmlspecialchars($head['consultation_time']) ?>" 
                             data-image="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>">
                            <img src="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>" alt="Dean">
                            <p><strong><?= htmlspecialchars($head['faculty_name']) ?></strong><br><?= htmlspecialchars($head['department_name']) ?></p>
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
                        <div class="member" data-name="<?= htmlspecialchars($head['faculty_name']) ?>" 
                             data-specialization="<?= htmlspecialchars($head['specialization']) ?>" 
                             data-consultation="<?= htmlspecialchars($head['consultation_time']) ?>" 
                             data-image="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>">
                            <img src="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>" alt="Dean">
                            <p><strong><?= htmlspecialchars($head['faculty_name']) ?></strong><br><?= htmlspecialchars($head['department_name']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
    
                <div class="level2">
                    <?php foreach ($allCsHeads as $head): ?>
                        <div class="member" data-name="<?= htmlspecialchars($head['faculty_name']) ?>" 
                             data-specialization="<?= htmlspecialchars($head['specialization']) ?>" 
                             data-consultation="<?= htmlspecialchars($head['consultation_time']) ?>" 
                             data-image="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>">
                            <img src="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>" alt="Dean">
                            <p><strong><?= htmlspecialchars($head['faculty_name']) ?></strong><br><?= htmlspecialchars($head['department_name']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
    
                <!-- Faculty Members for CS Department -->
                <h3>Faculty Members</h3>
                <div class="level3">
                    <?php foreach ($allCs as $head): ?>
                        <div class="member" data-name="<?= htmlspecialchars($head['faculty_name']) ?>" 
                             data-specialization="<?= htmlspecialchars($head['specialization']) ?>" 
                             data-consultation="<?= htmlspecialchars($head['consultation_time']) ?>" 
                             data-image="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>">
                            <img src="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>" alt="Dean">
                            <p><strong><?= htmlspecialchars($head['faculty_name']) ?></strong><br><?= htmlspecialchars($head['department_name']) ?></p>
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
                        <div class="member" data-name="<?= htmlspecialchars($head['faculty_name']) ?>" 
                             data-specialization="<?= htmlspecialchars($head['specialization']) ?>" 
                             data-consultation="<?= htmlspecialchars($head['consultation_time']) ?>" 
                             data-image="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>">
                            <img src="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>" alt="Dean">
                            <p><strong><?= htmlspecialchars($head['faculty_name']) ?></strong><br><?= htmlspecialchars($head['department_name']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
    
                <div class="level2">
                    <?php foreach ($allMitHeads as $head): ?>
                        <div class="member" data-name="<?= htmlspecialchars($head['faculty_name']) ?>" 
                             data-specialization="<?= htmlspecialchars($head['specialization']) ?>" 
                             data-consultation="<?= htmlspecialchars($head['consultation_time']) ?>" 
                             data-image="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>">
                            <img src="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>" alt="Dean">
                            <p><strong><?= htmlspecialchars($head['faculty_name']) ?></strong><br><?= htmlspecialchars($head['department_name']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
    
                <!-- Faculty Members for MIT Department -->
                <h3>Faculty Members</h3>
                <div class="level3">
                    <?php foreach ($allMit as $head): ?>
                        <div class="member" data-name="<?= htmlspecialchars($head['faculty_name']) ?>" 
                             data-specialization="<?= htmlspecialchars($head['specialization']) ?>" 
                             data-consultation="<?= htmlspecialchars($head['consultation_time']) ?>" 
                             data-image="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>">
                            <img src="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>" alt="Dean">
                            <p><strong><?= htmlspecialchars($head['faculty_name']) ?></strong><br><?= htmlspecialchars($head['department_name']) ?></p>
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
<section id="aboutus" class="content-section">
    <div class="section-heading text-center borderYellow">
    <h1><br><em>ABOUT US</em></h1>
    </div>
    <div class="container py-5">
        <div class="row gy-3 gy-md-4 gy-lg-0 align-items-lg-center">
            <div class="col-12 col-lg-6 col-xl-5">
                <img class="img-fluid rounded" loading="lazy" src="img/about.jpg" alt="About 1">
            </div>
            <div class="col-12 col-lg-6 col-xl-6">
                <div class="row justify-content-xl-center">
                    <div class="col-12 col-xl-11">
                        <h2 class="mb-3">Who Are We?</h2>
                        <p class="lead fs-4 text-secondary mb-3">We help people to build incredible brands and superior products. Our perspective is to furnish outstanding captivating services.</p>
                        <p class="mb-5">We are a fast-growing company, but we have never lost sight of our core values. We believe in collaboration, innovation, and customer satisfaction. We are always looking for new ways to improve our products and services.</p>
                        <div class="row gy-4 gy-md-0 gx-xxl-5X">
                            <div class="col-11 col-md-5">
                                <div class="d-flex">
                                    <div class="me-4 text-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
                                            <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h2 class="h3 mb-3">Versatile Brand</h2>
                                        <p class="text-secondary mb-0">We are crafting a digital method that subsists life across all mediums.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-11 col-md-5">
                                <div class="d-flex">
                                    <div class="me-3 text-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-fire" viewBox="0 0 16 16">
                                            <path d="M8 16c3.314 0 6-2 6-5.5 0-1.5-.5-4-2.5-6 .25 1.5-1.25 2-1.25 2C11 4 9 .5 6 0c.357 2 .5 4-2 6-1.25 1-2 2.729-2 4.5C2 14 4.686 16 8 16Zm0-1c-1.657 0-3-1-3-2.75 0-.75.25-2 1.25-3C6.125 10 7 10.5 7 10.5c-.375-1.25.5-3.25 2-3.5-.179 1-.25 2 1 3 .625.5 1 1.364 1 2.25C11 14 9.657 15 8 15Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h2 class="h4 mb-3">Digital Agency</h2>
                                        <p class="text-secondary mb-0">We believe in innovation by merging primary with elaborate ideas.</p>
                                    </div>
                                </div>
                            </div>
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
const roomFloors = {
    // Floor 1
    "stairs": 1,
    "men cr": 1,
    "block 3": 1,
    "female cr": 1,
    "s-104": 1,
    "s-106": 1,
    "s-102": 1,
    "s-103": 1,
    "block 9": 1,
    "male cr": 1,
    "s-109": 1,
    "pwd cr": 1,
    "s-108": 1,

    // Floor 2
    "stairs": 2,
    "male cr": 2,
    "s-205": 2,
    "s-206": 2,
    "s-201": 2,
    "s-204": 2,
    "female cr": 2,
    "s-202": 2,
    "s-203": 2,
    "s-208": 2,
    "s-207": 2,

    // Floor 3
    "stairs": 3,
    "s-307": 3,
    "male cr": 3,
    "female cr": 3,
    "s-301": 3,
    "s-305": 3,
    "faculty room": 3,
    "s-303": 3,
    "s-304": 3,
    "uapsa": 3,
    "s-306": 3,
};



function showFloor(floor) {
    document.querySelectorAll('.floor-svg').forEach(svg => {
        svg.style.display = 'none'; // Hide all floors
    });
    document.getElementById('room-svg-' + floor).style.display = 'block'; // Show selected floor
}
function searchElement2() {
    const searchInput = document.getElementById("search2").value.toLowerCase();
    const allSvgs = document.querySelectorAll("svg.floor-svg");
    const dropdown = document.getElementById("dropdown"); // Get the dropdown for floors

    // Clear previous highlights
    allSvgs.forEach(svg => {
        svg.querySelectorAll("rect").forEach(rect => {
            rect.classList.remove("highlight");
        });
    });

    // Reset dropdown selection
    dropdown.value = "1"; // Default to the 1st floor or clear selection

    let found = false;
    let foundRoom = null;
    let floorNumber = null;

    // Search through all rooms
    Object.keys(roomFloors).forEach(room => {
        if (room.toLowerCase().includes(searchInput)) { // Ensure case-insensitive search
            foundRoom = room; // Found the room
            floorNumber = roomFloors[room]; // Get the associated floor
            found = true;
        }
    });

    if (found && floorNumber) {
        showFloor(floorNumber); // Show the relevant floor

        // Highlight the associated rectangle for the found room
        const rectId = foundRoom.toLowerCase()+ "-rect"; // Ensure rect ID matches the format
        const rect = document.getElementById(rectId);
        if (rect) {
            rect.classList.add("highlight");
        } else {
            console.error('Rectangle not found for ID:', rectId);
        }

        // Change the selected dropdown option
        dropdown.value = floorNumber ; // Set dropdown to the found floor number
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Room not found',
            text: 'Please check the room name and try again.',
        });
    }
}
</script>
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
                    var timeAgo = formatRelativeTime(createdAt); // Function to format time
                    var sanitizedDetails = removeColorTags(announcement.announcement_details);
                    
                    // Include creator_name from the response
                    var creatorName = announcement.creator_name || 'Unknown Creator'; // Fallback if creator_name is not found

                    content += `
                        <div class="announcement-item mb-3 p-3 border rounded announcement-item-bg">
                            <p class="announcement-date mb-1"><strong>Created:</strong> ${timeAgo} by ${creatorName}</p>
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

    function formatRelativeTime(date) {
    const now = new Date();
    const seconds = Math.floor((now - date) / 1000);

    if (seconds < 60) {
        return seconds < 30 ? "just now" : seconds + " seconds ago";
    }
    
    const minutes = Math.floor(seconds / 60);
    if (minutes < 60) {
        return minutes + " minute" + (minutes > 1 ? "s" : "") + " ago";
    }

    const hours = Math.floor(minutes / 60);
    if (hours < 24) {
        return hours + " hour" + (hours > 1 ? "s" : "") + " ago";
    }

    const days = Math.floor(hours / 24);
    if (days < 30) {
        return days + " day" + (days > 1 ? "s" : "") + " ago";
    }

    const months = Math.floor(days / 30);
    if (months < 12) {
        return months + " month" + (months > 1 ? "s" : "") + " ago";
    }

    const years = Math.floor(months / 12);
    return years + " year" + (years > 1 ? "s" : "") + " ago";
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

function openTab(event, tabName) {
    // Hide all tab contents
    const tabContents = document.querySelectorAll('.tab-content');
    tabContents.forEach(content => {
        content.style.display = 'none';
    });

    // Remove active class from all buttons
    const tabButtons = document.querySelectorAll('.tab-button');
    tabButtons.forEach(button => {
        button.classList.remove('active');
    });

    // Show the clicked tab's content and add active class to the button
    document.getElementById(tabName).style.display = 'block';
    event.currentTarget.classList.add('active');
}

// Initial setup: show the first tab
document.addEventListener('DOMContentLoaded', () => {
    openTab({ currentTarget: document.querySelector('.tab-button.active') }, 'ccs');
});

    function searchElement() {
    var searchInput = document.getElementById('search').value.toLowerCase().replace(/\s+/g, '-');  // Replace spaces with hyphens
    var roomSvg = document.getElementById('room-svg');  // Get the SVG

    if (!roomSvg) {
        console.error('SVG not found!');
        return;  // Stop if the SVG is not found
    }

    var elements = roomSvg.querySelectorAll('rect, path, text');  // Get all rect, path, and text elements
    var found = false;  // Flag to check if a match is found

    // Loop through each element and check for a match
    for (var i = 0; i < elements.length; i++) {
        var elementId = elements[i].id.toLowerCase().replace(/-/g, '');  // Remove hyphens from the element ID for comparison

        if (elementId.includes(searchInput.replace(/-/g, ''))) {  // Compare without hyphens
            found = true;
            elements[i].classList.add('highlight');  // Highlight the element if it matches
        } else {
            elements[i].classList.remove('highlight');  // Remove highlight if not a match
        }
    }

    // If no match is found, display a SweetAlert message
    if (!found) {
        Swal.fire({
            icon: 'error',
            title: 'Room not found',
            text: 'Please check the room name and try again.',
        });
    }
}


</script>
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script> -->

</body>

</html>