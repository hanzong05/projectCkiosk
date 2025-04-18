<?php
    include_once ("class/mainClass.php");
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $obj = new mainClass();
    $allAnnouncement = $obj->show_announcement2();
    $allIt = $obj->show_allIt(1);            // IT members or data for some purpose
    $allItHeads = $obj->show_allItHeads(10);  // IT heads data
    $allCs = $obj->show_allcs(2);            // CS members or data
    $allCsHeads = $obj->show_allCsHeads(12);  // CS heads data
    $allIs = $obj->show_allis(3);            // IS members or data
    $allIsHeads = $obj->show_allIsHeads(11);  // IS heads data
    $allMit = $obj->show_allmit(4);         // MIT members or data
    $allMitHeads = $obj->show_allMitHeads(13);
    $showfaqs = $obj->show_allFAQS();
    $allOrg = $obj->show_org();
    $allDean = $obj->show_dean(5);
    $all2 = $obj->all_assist(6);
    $all3 = $obj->all_mem([7, 8, 9]); // Fetch faculty data for departments 7, 8, and 9

    $allEvent = $obj->show_eventsByMonth();


    
    ?>
    <!DOCTYPE html>

    <html>

    <head><meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Campus Kiosk</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">

    <!-- Tailwind CSS --><link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />

    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.3/dist/tailwind.min.css" rel="stylesheet">


    <!-- Bootstrap 5.3.0 (corrected version) CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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
    @media (min-width: 951px) { /* Corrected max-width instead of min-width */
        .page-content {
    width: 77.5%;
    float: right;
    }
}   .navbar-collapse {
        transition: all 0.3s ease;
    }
            .navbar-collapse.collapse {
        visibility: visible !important; /* Ensure visibility is set properly */
        display: none !important; /* Enforce display none to hide when collapsed */
    }

    .navbar-collapse.collapse.show {
        display: block !important; /* Enforce display block when shown */
    }

            @media (max-width: 768px) {
    .remove-padding-sm {
        padding-left: 0 !important;
        padding-right: 0 !important;
    }
            }
 </style>
        
       
    </head>

    <body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light d-lg-none fixed-top" style="transition: top 0.3s ease;">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mobileNavbar" aria-controls="mobileNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mobileNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="#announcement">ANNOUNCEMENT</a></li>
                    <li class="nav-item"><a class="nav-link" href="#schoolcalendar">SCHOOL CALENDAR</a></li>
                    <li class="nav-item"><a class="nav-link" href="#campusmap">CAMPUS BUILDINGS</a></li>
                    <li class="nav-item"><a class="nav-link" href="#facultymembers">FACULTY MEMBERS</a></li>
                    <li class="nav-item"><a class="nav-link" href="#campusorgs">STUDENT ORGS</a></li>
                    <li class="nav-item"><a class="nav-link" href="#faqs">FREQUENTLY ASKED QUESTIONS</a></li>
                    <li class="nav-item"><a class="nav-link" href="#feed">FEEDBACK</a></li>
                    <li class="nav-item"><a class="nav-link" href="#aboutus">ABOUT US</a></li>
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
                            ANNOUNCEMENT
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#schoolcalendar">
                            SCHOOL CALENDAR
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#campusmap">
                            CAMPUS BUILDINGS
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#facultymembers">
                            FACULTY MEMBERS
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#campusorgs">
                            STUDENT ORGS
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#faqs">
                            FREQUENTLY ASKED QUESTIONS
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#feed">
                            FEEDBACK
                        </a>
                    </li>
                      <li class="nav-item">
                <a class="nav-link" href="#aboutus">
                    ABOUT US
                </a>
            </li>
                </ul>
            </nav>

        </div>
        <div class="page-content ">
        <?php
include_once("class/connection.php");
date_default_timezone_set('Asia/Manila');

function getAllAnnouncements($connection) {
    $query = "
          SELECT a.*, 
            u.users_username AS author_name, 
            COALESCE(c.users_username, o.username, 'Unknown Creator') AS creator_name, 
            org.org_name, 
            org.org_image,
            a.category,  /* Add this line to select category */
            GROUP_CONCAT(ai.image_path) AS announcement_images
        FROM announcement_tbl a 
        LEFT JOIN users_tbl u ON a.announcement_creator = u.users_id 
        LEFT JOIN users_tbl c ON a.created_by = c.users_id  
        LEFT JOIN orgmembers_tbl o ON a.created_by = o.id  
        LEFT JOIN organization_tbl org ON u.users_org = org.org_id  
        LEFT JOIN announcement_images ai ON a.announcement_id = ai.announcement_id
        WHERE a.is_archived = 0
        GROUP BY a.announcement_id
        ORDER BY a.created_at DESC
    ";

    try {
        $statement = $connection->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as &$row) {
            // Format the created_at date
            if (!empty($row['created_at'])) {
                $timestamp = strtotime($row['created_at']);
                if ($timestamp !== false) {
                    $row['created_at_formatted'] = date('c', $timestamp); // ISO 8601 format
                    $row['created_at_timestamp'] = $timestamp;
                } else {
                    $row['created_at_formatted'] = null;
                    $row['created_at_timestamp'] = null;
                }
            }

            // Other existing formatting
            $row['org_image'] = !empty($row['org_image']) ? htmlspecialchars($row['org_image'], ENT_QUOTES, 'UTF-8') : 'default_org_image.jpg';
            $row['announcement_images'] = !empty($row['announcement_images']) ? explode(',', $row['announcement_images']) : [];
            $row['creator_name'] = !empty($row['creator_name']) ? htmlspecialchars($row['creator_name'], ENT_QUOTES, 'UTF-8') : 'Unknown Creator';
            $row['org_name'] = !empty($row['org_name']) ? htmlspecialchars($row['org_name'], ENT_QUOTES, 'UTF-8') : 'Unknown Organization';
            
            // Ensure that the announcement details are preserved in HTML format
            $row['announcement_details'] = $row['announcement_details'] ?? '';
        }

        return $result;
    } catch (PDOException $e) {
        return "Error: " . $e->getMessage();
    }
}

// Fetch all announcements
$allAnnouncement = getAllAnnouncements($connect);
?><!-- Facebook-Style Announcements Section -->
<section id="announcement" class="content-section py-4">
    <div class="section-heading text-center mb-5">
        <h1 class="display-5 fw-bold position-relative d-inline-block mb-0">
            <span class="gradient-text">ANNOUNCEMENTS</span>
        </h1>
        <div class="animated-bar mx-auto mt-2 mb-3"></div>
    </div>
    
    <!-- Facebook-style search and filters -->
    <div class="mx-auto px-4 sm:px-6 lg:px-8 mb-4" style="max-width: 900px; width: 100%;">
        <!-- Facebook-style search bar -->
        <div class="bg-white rounded-lg shadow p-2 mb-3">
            <div class="flex items-center">
                <div class="relative flex-grow">
                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input 
                        type="text" 
                        id="announcement-search" 
                        class="block w-full pl-10 pr-3 py-2 border-0 bg-gray-100 rounded-full focus:ring-0 focus:bg-white"
                        placeholder="Search announcements">
                </div>
                <button id="toggle-filters-btn" class="ml-2 flex items-center justify-center w-8 h-8 text-maroon hover:bg-gray-100 rounded-full">
                    <i class="fas fa-filter"></i>
                </button>
            </div>
        </div>
    
        <!-- Facebook-style filters (hidden by default) -->
        <div id="filters-container" class="bg-white rounded-lg shadow p-3 hidden">
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center">
                    <i class="fas fa-filter text-maroon mr-2"></i>
                    <h3 class="text-gray-800 font-medium text-lg">Filters</h3>
                </div>
                <button id="close-filters-btn" class="hover:bg-gray-100 rounded-full w-8 h-8 flex items-center justify-center">
                    <i class="fas fa-times text-gray-500"></i>
                </button>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <!-- Category filter -->
                <div class="relative">
                    <label for="category-filter" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select id="category-filter" class="block w-full py-2 px-3 bg-gray-100 rounded-md appearance-none">
                        <option value="all">All Categories</option>
                        <option value="academic">Academic</option>
                        <option value="event">Events</option>
                        <option value="org">Organizations</option>
                        <option value="general">General</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700" style="top: 22px;">
                        <i class="fas fa-chevron-down text-xs"></i>
                    </div>
                </div>
                
                <!-- Date range -->
                <div>
                    <label for="date-from" class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                    <input 
                        type="date" 
                        id="date-from" 
                        class="block w-full py-2 px-3 bg-gray-100 rounded-md">
                </div>
                
                <div>
                    <label for="date-to" class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                    <input 
                        type="date" 
                        id="date-to" 
                        class="block w-full py-2 px-3 bg-gray-100 rounded-md">
                </div>
                
                <!-- Clear filters button -->
                <div class="sm:col-span-2">
                    <button 
                        id="clear-filters" 
                        class="w-full py-2 px-4 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-md transition duration-200 flex items-center justify-center">
                        <i class="fas fa-times mr-2"></i> Clear Filters
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Announcements Container with max height constraint -->
    <div id="announcement-container" class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 max-h-[calc(100vh-280px)] overflow-y-auto">
        <div class="space-y-4">
            <?php if (empty($allAnnouncement)): ?>
                <!-- Empty state -->
                <div class="text-center py-8 bg-white rounded-lg shadow">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">No announcements</h3>
                    <p class="mt-1 text-sm text-gray-500">Please check back later.</p>
                </div>
            <?php else: ?>
                <?php foreach ($allAnnouncement as $announcement): ?>
                    <!-- Facebook-style announcement card -->
                    <div class="announcement-item bg-white rounded-lg shadow overflow-hidden" data-category="<?= strtolower(htmlspecialchars($announcement['category'])) ?>">
                        <div class="p-4">
                            <!-- Header with profile image and name (Facebook style) -->
                            <div class="flex items-center mb-3">
                                <img src="uploaded/orgUploaded/<?= htmlspecialchars($announcement['org_image']) ?>" 
                                     alt="<?= htmlspecialchars($announcement['org_name']) ?>" 
                                     class="w-10 h-10 rounded-full object-cover">
                                <div class="ml-3">
                                    <h6 class="font-semibold text-primary text-lg tracking-wide mb-1 capitalize hover:text-primary-dark transition-colors duration-200" data-original-text="<?= htmlspecialchars($announcement['org_name']) ?>">
                                        <?= htmlspecialchars($announcement['org_name']) ?>
                                    </h6>
                                    <div class="flex items-center text-xs text-gray-500">
                                        <span><?= htmlspecialchars($announcement['author_name'] ?? $announcement['creator_name'] ?? 'Unknown Author') ?></span>
                                        <span class="mx-1">·</span>
                                        <span id="time-<?php echo $announcement['announcement_id']; ?>" 
                                              data-created-at="<?php echo $announcement['created_at_formatted']; ?>">
                                            <?php echo date('F j, Y', $announcement['created_at_timestamp']); ?>
                                        </span>
                                        <span class="mx-1">·</span>
                                        <span class="category-badge">
                                            <?= htmlspecialchars($announcement['category']) ?>
                                        </span>
                                    </div>
                                </div>
                                <!-- Facebook-style options menu -->
                                <div class="ml-auto">
                                    <button class="hover:bg-gray-100 rounded-full w-9 h-9 flex items-center justify-center">
                                        <i class="fas fa-ellipsis-h text-gray-500"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Announcement content with Facebook-style "See more" -->
                            <div class="announcement-details mb-3" 
                                 data-original-html="<?= htmlspecialchars(nl2br($announcement['announcement_details'])) ?>">
                                <?= nl2br($announcement['announcement_details']) ?>
                            </div>
                            
                            <!-- Facebook-style images/Carousel with FIXED HEIGHT -->
                            <?php if (!empty($announcement['announcement_images'])): ?>
                                <div class="mt-3">
                                    <div id="carousel-<?php echo $announcement['announcement_id']; ?>" class="carousel slide announcement-carousel" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            <?php foreach ($announcement['announcement_images'] as $index => $image): ?>
                                                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>" 
                                                     data-image-index="<?php echo $index; ?>">
                                                    <div class="fixed-height-image-container">
                                                        <img src="uploaded/annUploaded/<?php echo htmlspecialchars($image); ?>" 
                                                             alt="Announcement image"
                                                             onclick="openModal(this, <?php echo $announcement['announcement_id']; ?>)"
                                                             class="announcement-image">
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        
                                        <!-- Carousel controls with improved styling -->
                                        <?php if (count($announcement['announcement_images']) > 1): ?>
                                            <button class="carousel-control-prev" type="button" data-bs-target="#carousel-<?php echo $announcement['announcement_id']; ?>" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#carousel-<?php echo $announcement['announcement_id']; ?>" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Facebook-style divider -->
                            <div class="border-t border-gray-200 mt-3 pt-2"></div>
                            
                            <!-- Facebook-style action buttons -->
                          
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <!-- No results message (shown when filtering returns no results) -->
        <div id="no-results-message" class="hidden">
            <div class="text-center py-8 bg-white rounded-lg shadow mt-4">
                <i class="fas fa-search text-gray-400 text-4xl mb-2"></i>
                <p class="text-lg font-medium text-gray-700">No announcements found matching your filters</p>
                <p class="text-sm text-gray-500 mt-1">Try adjusting your search or filters</p>
            </div>
        </div>
    </div>
</section>

<!-- Image Modal - UPDATED VERSION with properly positioned controls -->
<div id="imageModal" class="hidden">
    <button id="close-modal-btn" class="modal-close">&times;</button>
    <button id="prev-image-btn" class="modal-prev">
        <i class="fas fa-chevron-left"></i>
    </button>
    <img class="modal-img" src="" alt="Image preview">
    <button id="next-image-btn" class="modal-next">
        <i class="fas fa-chevron-right"></i>
    </button>
</div>

<!-- Scoped CSS that only affects the announcement section -->
<style>
/* CSS Variables */
#announcement {
    --maroon-dark: #7A0D0D;    /* Dark maroon from top section */
    --maroon: #C33232;          /* Medium red from second section */
    --gold: #E9CF8B;            /* Gold/tan from third section */
    --light-gray: #EEEEEE;      /* Light gray from bottom section */
    --facebook-bg: #f0f2f5;
    --facebook-text: #000000; 
    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
 
    padding: 20px 0;
    margin: 0 auto;
    color: #000000; /* Set all text to black by default */
}

/* Typography styles for the organization name */
.text-primary {
    color: #C33232;
}

.text-primary-dark:hover {
    color: #7A0D0D;
}

.text-lg {
    font-size: 1.125rem; /* 18px */
    line-height: 1.5;
}

.font-semibold {
    font-weight: 600;
}

.tracking-wide {
    letter-spacing: 0.025em;
}

.capitalize {
    text-transform: capitalize;
}

.transition-colors {
    transition-property: color;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 200ms;
}

/* Section heading - Facebook style with root colors */
#announcement .section-heading {
    margin-bottom: 16px;
    border-bottom: none;
}

#announcement .section-heading h1 {
    color: var(--maroon);
    font-size: 24px;
    font-weight: 700;
    text-align: left;
    margin-left: 16px;
}

#announcement .section-heading h1:after {
    display: none; /* Remove the decorative line */
}

/* Gradient text for the heading */
.gradient-text {
    background: linear-gradient(45deg, var(--maroon-dark), var(--maroon));
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    display: inline-block;
}

/* Animated bar for the heading */
.animated-bar {
    height: 4px;
    width: 80px;
    background: linear-gradient(to right, var(--maroon-dark), var(--maroon));
    border-radius: 2px;
}

/* Fixed height image container styling */
.fixed-height-image-container {
    height: 300px;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f8f9fa;
    overflow: hidden;
    border-radius: 8px;
    position: relative; /* Added for proper carousel control positioning */
}

.announcement-image {
    max-width: 100%;
    object-fit: contain;
    cursor: pointer;
    transition: transform 0.2s ease;
}

.announcement-image:hover {
    transform: scale(1.02);
}

/* Carousel container */
.announcement-carousel {
    position: relative;
    width: 100%;
}

/* Styling for carousel controls - FIXED VERSION */
.announcement-carousel .carousel-control-prev,
.announcement-carousel .carousel-control-next {
    width: 40px;
    height: 40px;
    background-color: rgba(0, 0, 0, 0.5);
    border-radius: 50%;
    top: 50%;
    transform: translateY(-50%);
    opacity: 0.7;
    position: absolute;
    z-index: 5;
    display: flex;
    align-items: center;
    justify-content: center;
}

.announcement-carousel .carousel-control-prev {
    left: 10px;
}

.announcement-carousel .carousel-control-next {
    right: 10px;
}

.announcement-carousel .carousel-control-prev:hover,
.announcement-carousel .carousel-control-next:hover {
    opacity: 1;
    background-color: rgba(0, 0, 0, 0.7);
}

.announcement-carousel .carousel-control-prev-icon,
.announcement-carousel .carousel-control-next-icon {
    width: 20px;
    height: 20px;
    background-size: 100%;
}

/* Make sure the carousel item takes up the full container and positions correctly */
.carousel-item {
    width: 100%;
    position: relative;
}

/* Search container */
#announcement .search-container {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    margin-bottom: 16px;
    padding: 12px 16px;
}

/* Search input wrapper */
#announcement .search-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

/* Search icon */
#announcement .search-icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #65676B;
    pointer-events: none;
    z-index: 1;
}

/* Facebook-style search input */
#announcement .search-input {
    background-color: #f0f2f5;
    border: none;
    border-radius: 50px;
    padding: 8px 12px 8px 40px;
    font-size: 15px;
    color: black;
    height: 40px;
    flex-grow: 1;
}

#announcement .search-input:focus {
    background-color: white;
    box-shadow: 0 0 0 2px var(--maroon);
    outline: none;
}

/* Filter button styling */
#announcement .filter-button {
    background: none;
    border: none;
    color: var(--maroon);
    cursor: pointer;
    padding: 0 0 0 10px;
    margin-left: 8px;
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    flex-shrink: 0;
}

#announcement .filter-button:hover {
    color: var(--maroon-dark);
    background-color: #f0f2f5;
}

/* Update search input styling */
#announcement-search {
    padding-right: 40px; /* Ensure there's enough space for the filter button */
}

/* Toggle filters button */
#toggle-filters-btn {
    background: none;
    border: none;
    color: var(--maroon);
    cursor: pointer;
    transition: all 0.2s ease;
    flex-shrink: 0; /* Prevent the button from shrinking */
}

#toggle-filters-btn:hover {
    color: var(--maroon-dark);
    background-color: #f0f2f5;
}

/* Search input container */
.search-container {
    display: flex;
    align-items: center;
    width: 100%;
}

/* Make sure the search input takes available space */
.search-container .relative {
    flex-grow: 1;
}

/* Announcements card styling */
.announcement-item {
    transition: opacity 0.3s ease, transform 0.2s ease;
    opacity: 1;
    margin-bottom: 16px;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

.announcement-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Category badge styling */
.category-badge {
    display: inline-block;
    padding: 2px 6px;
    background-color: #f0f2f5;
    border-radius: 4px;
    font-size: 0.7rem;
    font-weight: 500;
}

/* "See more" link styling */
.see-more-link {
    color: #1877f2;
    cursor: pointer;
    font-weight: 600;
}

.see-more-link:hover {
    text-decoration: underline;
}

/* Filter container styling */
#filters-container {
    margin-bottom: 16px;
    transition: all 0.3s ease;
}
.collapse {
    visibility: visible;
}

/* Styling for form elements in filters */
#filters-container select,
#filters-container input[type="date"] {
    width: 100%;
    border: 1px solid #ddd;
    border-radius: 6px;
    padding: 8px 12px;
    outline: none;
    transition: all 0.2s;
}

#filters-container select:focus,
#filters-container input[type="date"]:focus {
    border-color: var(--maroon);
    box-shadow: 0 0 0 1px rgba(195, 50, 50, 0.2);
}

/* Clear filters button */
#clear-filters {
    transition: all 0.2s;
}

#clear-filters:hover {
    background-color: #e2e2e2;
}

/* No results message styling */
#no-results-message {
    transition: opacity 0.3s ease;
    opacity: 1;
}

#no-results-message.hidden {
    opacity: 0;
    display: none;
}

/* Image Modal Styling - FIXED VERSION */
#imageModal {
    position: fixed;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.9);
    z-index: 50;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 1;
    transition: opacity 0.3s ease, visibility 0.3s;
}

#imageModal.hidden {
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
}

/* Close button styling */
#close-modal-btn {
    position: absolute;
    top: 20px;
    right: 20px;
    width: 40px;
    height: 40px;
    background-color: rgba(0, 0, 0, 0.5);
    color: white;
    border: none;
    border-radius: 50%;
    font-size: 24px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background-color 0.2s;
}

/* Previous button styling */
#prev-image-btn {
    position: absolute;
    left: 20px;
    top: 50%;
    transform: translateY(-50%);
    width: 50px;
    height: 50px;
    background-color: rgba(0, 0, 0, 0.5);
    color: white;
    border: none;
    border-radius: 50%;
    font-size: 24px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background-color 0.2s;
}

/* Next button styling */
#next-image-btn {
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    width: 50px;
    height: 50px;
    background-color: rgba(0, 0, 0, 0.5);
    color: white;
    border: none;
    border-radius: 50%;
    font-size: 24px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background-color 0.2s;
}

#imageModal button:hover {
    background-color: rgba(0, 0, 0, 0.7);
}

/* Modal image styling */
.modal-img {
    max-width: 80vw;
    max-height: 80vh;
    object-fit: contain;
    border-radius: 4px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .fixed-height-image-container {
        height: 200px;
    }
    
    #announcement .section-heading h1 {
        font-size: 20px;
    }
    
    .announcement-carousel .carousel-control-prev,
    .announcement-carousel .carousel-control-next {
        width: 32px;
        height: 32px;
    }
    
    #prev-image-btn,
    #next-image-btn {
        width: 40px;
        height: 40px;
    }
    
    .modal-img {
        max-width: 90vw;
    }
}

/* Tailwind-like utility classes used in the HTML */
.bg-white {
    background-color: white;
}

.rounded-lg {
    border-radius: 0.5rem;
}

.shadow {
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
}

.p-2, .p-3, .p-4 {
    padding: 0.5rem;
    padding: 0.75rem;
    padding: 1rem;
}

.mb-2, .mb-3, .mb-4, .mb-5 {
    margin-bottom: 0.5rem;
    margin-bottom: 0.75rem;
    margin-bottom: 1rem;
    margin-bottom: 1.25rem;
}

.hidden {
    display: none;
}

.flex {
    display: flex;
}

.grid {
    display: grid;
}

.items-center {
    align-items: center;
}

.justify-center {
    justify-content: center;
}

.justify-between {
    justify-content: space-between;
}

.w-full {
    width: 100%;
}

.text-center {
    text-align: center;
}

.py-4, .py-8 {
    padding-top: 1rem;
    padding-bottom: 1rem;
    padding-top: 2rem;
    padding-bottom: 2rem;
}

.px-4 {
    padding-left: 1rem;
    padding-right: 1rem;
}

.mx-auto {
    margin-left: auto;
    margin-right: auto;
}

.overflow-hidden {
    overflow: hidden;
}

.overflow-y-auto {
    overflow-y: auto;
}

.relative {
    position: relative;
}

/* Fixes for specific elements */
#announcement-container {
    scroll-behavior: smooth;
    padding-right: 4px; /* Prevents horizontal scrollbar */
}

.announcement-details {
    overflow-wrap: break-word;
    word-break: break-word;
}
</style>

<!-- JavaScript for Announcements Functionality -->
<script>
// Wait for the DOM to be fully loaded
document.addEventListener("DOMContentLoaded", function() {
    // Get direct references to the filter elements
    const searchInput = document.getElementById('announcement-search');
    const categoryFilter = document.getElementById('category-filter');
    const dateFrom = document.getElementById('date-from');
    const dateTo = document.getElementById('date-to');
    const clearFiltersBtn = document.getElementById('clear-filters');
    const noResultsMessage = document.getElementById('no-results-message');
    
    // Toggle filters functionality
    const toggleFiltersBtn = document.getElementById('toggle-filters-btn');
    const closeFiltersBtn = document.getElementById('close-filters-btn');
    const filtersContainer = document.getElementById('filters-container');

    if (toggleFiltersBtn && filtersContainer) {
        toggleFiltersBtn.addEventListener('click', function() {
            filtersContainer.classList.toggle('hidden');
            // Toggle icon
            const icon = this.querySelector('i');
            if (filtersContainer.classList.contains('hidden')) {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-filter');
            } else {
                icon.classList.remove('fa-filter');
                icon.classList.add('fa-times');
            }
        });
    }

    if (closeFiltersBtn && filtersContainer) {
        closeFiltersBtn.addEventListener('click', function() {
            filtersContainer.classList.add('hidden');
            // Reset toggle button icon
            const toggleIcon = toggleFiltersBtn.querySelector('i');
            toggleIcon.classList.remove('fa-times');
            toggleIcon.classList.add('fa-filter');
        });
    }

    // Also close filters when clicking clear filters
    if (clearFiltersBtn && filtersContainer) {
        clearFiltersBtn.addEventListener('click', function() {
            // Hide filter panel
            filtersContainer.classList.add('hidden');
            
            // Reset toggle button icon
            const toggleIcon = toggleFiltersBtn.querySelector('i');
            if (toggleIcon) {
                toggleIcon.classList.remove('fa-times');
                toggleIcon.classList.add('fa-filter');
            }
            
            // Clear all filters
            clearAllFilters();
        });
    }
    
    // Main filter function
    function filterAnnouncements() {
        // Get filter values
        const searchTerm = searchInput.value.toLowerCase().trim();
        const selectedCategory = categoryFilter.value;
        const fromDate = dateFrom.value ? new Date(dateFrom.value) : null;
        const toDate = dateTo.value ? new Date(dateTo.value + 'T23:59:59') : null;
        
        // Get all announcements
        const announcements = document.querySelectorAll('.announcement-item');
        let visibleCount = 0;
        
        announcements.forEach(announcement => {
            // Extract content for filtering
            const textContent = announcement.textContent.toLowerCase();
            const category = announcement.getAttribute('data-category') || '';
            
            // Get date for date filtering
            const timeElement = announcement.querySelector('[data-created-at]');
            const createdAt = timeElement ? new Date(timeElement.getAttribute('data-created-at')) : null;
            
            // Check all filter conditions
            let matchesSearch = !searchTerm || textContent.includes(searchTerm);
            let matchesCategory = selectedCategory === 'all' || category === selectedCategory;
            let matchesDateRange = true;
            
            // Date range checking
            if (createdAt && (fromDate || toDate)) {
                if (fromDate && createdAt < fromDate) matchesDateRange = false;
                if (toDate && createdAt > toDate) matchesDateRange = false;
            }
            
            // Final visibility check
            const isVisible = matchesSearch && matchesCategory && matchesDateRange;
            
            // Apply visibility with a nice transition
            if (isVisible) {
                announcement.style.display = '';
                setTimeout(() => {
                    announcement.style.opacity = '1';
                }, 10);
                visibleCount++;
            } else {
                announcement.style.opacity = '0';
                setTimeout(() => {
                    announcement.style.display = 'none';
                }, 300);
            }
        });
        
        // Toggle no results message
        if (visibleCount === 0) {
            noResultsMessage.classList.remove('hidden');
        } else {
            noResultsMessage.classList.add('hidden');
        }
        
        return visibleCount;
    }
    
    // Clear all filters
    function clearAllFilters() {
        // Reset filter values
        if (searchInput) searchInput.value = '';
        if (categoryFilter) categoryFilter.value = 'all';
        if (dateFrom) dateFrom.value = '';
        if (dateTo) dateTo.value = '';
        
        // Show all announcements
        const announcements = document.querySelectorAll('.announcement-item');
        announcements.forEach(announcement => {
            announcement.style.display = '';
            announcement.style.opacity = '1';
        });
        
        // Hide no results message
        if (noResultsMessage) {
            noResultsMessage.classList.add('hidden');
        }
    }
    
    // Set up Facebook-style "See more" functionality
    function setupSeeMoreFunctionality() {
        const announcements = document.querySelectorAll('.announcement-details');
        
        announcements.forEach(function(announcement) {
            // Get the original text content
            const originalHTML = announcement.innerHTML;
            const fullText = announcement.textContent.trim();
            
            // Only process if text is long enough to need truncation
            if (fullText.length > 130) {
                // Find a truncation point around 130 chars
                let truncateAt = 130;
                while (truncateAt > 100 && fullText[truncateAt] !== ' ') {
                    truncateAt--;
                }
                
                // Create truncated text
                const truncatedText = fullText.substring(0, truncateAt);
                
                // Set up toggle functionality
                let isExpanded = false;
                
                function toggleExpand() {
                    if (isExpanded) {
                        // Collapse - show truncated version
                        announcement.innerHTML = truncatedText + 
                            '... <span class="text-blue-600 font-semibold cursor-pointer hover:underline see-more-link">See more</span>';
                    } else {
                        // Expand - show full version
                        announcement.innerHTML = originalHTML + 
                            ' <span class="text-blue-600 font-semibold cursor-pointer hover:underline see-more-link">See less</span>';
                    }
                    
                    // Add click event to the new link
                    const toggleLink = announcement.querySelector('.see-more-link');
                    if (toggleLink) {
                        toggleLink.addEventListener('click', function(e) {
                            e.preventDefault();
                            isExpanded = !isExpanded;
                            toggleExpand();
                        });
                    }
                }
                
                // Initial setup - truncate the text
                announcement.innerHTML = truncatedText + 
                    '... <span class="text-blue-600 font-semibold cursor-pointer hover:underline see-more-link">See more</span>';
                
                // Add initial click handler
                const toggleLink = announcement.querySelector('.see-more-link');
                if (toggleLink) {
                    toggleLink.addEventListener('click', function(e) {
                        e.preventDefault();
                        isExpanded = !isExpanded;
                        toggleExpand();
                    });
                }
            }
        });
    }
    
    // Format relative time
    function formatRelativeTime() {
        const timeElements = document.querySelectorAll('[id^="time-"]');
        
        timeElements.forEach(function(timeElement) {
            const createdAt = timeElement.getAttribute('data-created-at');
            
            if (createdAt) {
                const now = new Date();
                const date = new Date(createdAt);
                
                if (isNaN(date.getTime())) {
                    timeElement.textContent = "Invalid date";
                    return;
                }
                
                const diffInSeconds = Math.floor((now - date) / 1000);
                const diffInMinutes = Math.floor(diffInSeconds / 60);
                const diffInHours = Math.floor(diffInMinutes / 60);
                const diffInDays = Math.floor(diffInHours / 24);
                
                if (diffInSeconds < 60) {
                    timeElement.textContent = `${diffInSeconds} seconds ago`;
                } else if (diffInMinutes < 60) {
                    timeElement.textContent = `${diffInMinutes} minutes ago`;
                } else if (diffInHours < 24) {
                    timeElement.textContent = `${diffInHours} hours ago`;
                } else if (diffInDays < 7) {
                    timeElement.textContent = `${diffInDays} days ago`;
                } else {
                    timeElement.textContent = date.toLocaleDateString();
                }
            } else {
                timeElement.textContent = "Date not available";
            }
        });
    }
    
    // Set up image modal functionality - UPDATED VERSION with proper positioning
    function setupImageModal() {
        const modal = document.getElementById('imageModal');
        const modalImg = modal.querySelector('.modal-img');
        const closeBtn = document.getElementById('close-modal-btn');
        const prevBtn = document.getElementById('prev-image-btn');
        const nextBtn = document.getElementById('next-image-btn');
        
        // Keep track of the current carousel and image index
        let currentCarouselId = null;
        let currentImageIndex = 0;
        let totalImages = 0;
        let imageItems = [];
        
        // Function to open the modal
        window.openModal = function(img, announcementId) {
            // Set the image src
            modalImg.src = img.src;
            
            // Get the carousel and its items
            const carousel = document.getElementById(`carousel-${announcementId}`);
            currentCarouselId = announcementId;
            imageItems = carousel.querySelectorAll('.carousel-item');
            totalImages = imageItems.length;
            
            // Find current image index
            for (let i = 0; i < imageItems.length; i++) {
                if (imageItems[i].querySelector('img').src === img.src) {
                    currentImageIndex = i;
                    break;
                }
            }
            
            // Show the modal
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
            
            // Update button visibility
            updateNavigationButtons();
        };
        
        // Update button visibility based on current index
        function updateNavigationButtons() {
            // Only show navigation buttons if there are multiple images
            if (totalImages <= 1) {
                prevBtn.style.display = 'none';
                nextBtn.style.display = 'none';
            } else {
                prevBtn.style.display = 'flex';
                nextBtn.style.display = 'flex';
            }
        }
        
        // Navigate to previous image
        prevBtn.addEventListener('click', function() {
            if (totalImages > 1) {
                currentImageIndex = (currentImageIndex - 1 + totalImages) % totalImages;
                modalImg.src = imageItems[currentImageIndex].querySelector('img').src;
            }
        });
        
        // Navigate to next image
        nextBtn.addEventListener('click', function() {
            if (totalImages > 1) {
                currentImageIndex = (currentImageIndex + 1) % totalImages;
                modalImg.src = imageItems[currentImageIndex].querySelector('img').src;
            }
        });
        
        // Close modal when clicking the close button
        closeBtn.addEventListener('click', function() {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        });
        
        // Also close when clicking outside the image
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        });
        
        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (modal.classList.contains('hidden')) return;
            
            if (e.key === 'Escape') {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            } else if (e.key === 'ArrowLeft') {
                prevBtn.click();
            } else if (e.key === 'ArrowRight') {
                nextBtn.click();
            }
        });
    }
    
    // Attach event listeners
    if (searchInput) {
        searchInput.addEventListener('input', filterAnnouncements);
    }
    
    if (categoryFilter) {
        categoryFilter.addEventListener('change', filterAnnouncements);
    }
    
    if (dateFrom) {
        dateFrom.addEventListener('change', filterAnnouncements);
    }
    
    if (dateTo) {
        dateTo.addEventListener('change', filterAnnouncements);
    }
    
    // Set max date for date inputs to today
    const today = new Date().toISOString().split('T')[0];
    if (dateFrom) dateFrom.max = today;
    if (dateTo) dateTo.max = today;
    
    // Initialize all functionality
    setupSeeMoreFunctionality();
    formatRelativeTime();
    setupImageModal();
    
    // Dynamic section height calculation
    function setAnnouncementsHeight() {
        const windowHeight = window.innerHeight;
        const headerOffset = 180; // Adjust based on your header size
        const footerOffset = 40;  // Adjust based on your footer size
        
        const container = document.getElementById('announcement-container');
        if (container) {
            const availableHeight = windowHeight - headerOffset - footerOffset;
            const minHeight = 300;
            container.style.maxHeight = `${Math.max(availableHeight, minHeight)}px`;
        }
    }
    
    // Set initial height and update on resize
    setAnnouncementsHeight();
    window.addEventListener('resize', setAnnouncementsHeight);
    
    console.log("Facebook-style announcement section fully initialized with fixed carousel and modal controls");
});
</script>
<section id="schoolcalendar" class="content-section py-4">
    <div class="max-w-7xl mx-auto px-6">
    <div class="text-center mb-8">
    <div class="section-heading text-center mb-5">
        <h1 class="display-5 fw-bold position-relative d-inline-block mb-0">
            <span class="gradient-text">SCHOOL CALENDAR</span>
        </h1>
        <div class="animated-bar mx-auto mt-2 mb-3"></div>
    </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Calendar View (Left Side) -->
            <div class="lg:w-7/12 rounded-lg overflow-hidden border border-amber-700/50" style="height: auto; width: 600px; background: linear-gradient(135deg, #EAD196, #8C6239);" >
                <div class="p-4 bg-amber-700 flex justify-between items-center " style="background: linear-gradient(135deg, #962626, #b03a3a);">
                    <button id="prevMonth" class="flex items-center justify-center w-8 h-8 text-white hover:text-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <h2 id="currentMonth"  class="text-xl font-bold text-white">March 2025</h2>
                    <button id="nextMonth" class="flex items-center justify-center w-8 h-8 text-white hover:text-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>

                <!-- Calendar Grid -->
                <div class="bg-[#3A1616]"> <!-- Removed fixed height -->
                    <div class="grid grid-cols-7 border-b border-gray-700">
                        <!-- Week days header -->
                        <div class="text-center text-sm font-medium text-white py-2">Sun</div>
                        <div class="text-center text-sm font-medium text-white py-2">Mon</div>
                        <div class="text-center text-sm font-medium text-white py-2">Tue</div>
                        <div class="text-center text-sm font-medium text-white py-2">Wed</div>
                        <div class="text-center text-sm font-medium text-white py-2">Thu</div>
                        <div class="text-center text-sm font-medium text-white py-2">Fri</div>
                        <div class="text-center text-sm font-medium text-white py-2">Sat</div>
                    </div>

                    <!-- Calendar days - removed fixed height -->
                    <div id="calendarDays" class="grid grid-cols-7 gap-[1px]"></div>
                </div>
            </div>

            <!-- Events View (Right Side) -->
            <div class="lg:w-5/12 space-y-6">
                <!-- Today's Events -->
                <div class="bg-white rounded-lg overflow-hidden border border-gray-200 shadow-md">
                <div class="px-4 py-3 flex items-center" style="background: linear-gradient(135deg, #962626, #b03a3a);">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="#ffffff" style="color: white;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <h2 class="text-base font-medium" style="color: white;">Today's Events</h2>
                </div>
                    <div id="todayEvents" class="p-3 bg-white max-h-[250px] overflow-y-auto" style="background: linear-gradient(135deg, #EAD196, #8C6239);">
                        <!-- Today's events will be populated by JavaScript -->
                    </div>
                </div>
                
                <!-- Upcoming Events -->
                <div class="bg-white rounded-lg overflow-hidden border border-gray-200 shadow-md">
                <div class="px-4 py-3 flex items-center" style="background: linear-gradient(135deg, #962626, #b03a3a);">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="#ffffff" style="color: white;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h2 class="text-base font-medium" style="color: white; " >Upcoming Events</h2>
                </div>
                    <div id="upcomingEvents" class="p-3 bg-white max-h-[220px] overflow-y-auto" style="background: linear-gradient(135deg, #EAD196, #8C6239);">
                        <!-- Upcoming events will be populated by JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .event-header {
  background: linear-gradient(135deg, #962626, #b03a3a);
  border-bottom: 1px solid rgba(255,255,255,0.2);
}

.event-header h2,
.event-header svg {
  color: white !important;
}

/* Explicit styling for the headers if needed */
#todayEvents-header h2,
#upcomingEvents-header h2 {
  color: white !important;
}

#todayEvents-header svg,
#upcomingEvents-header svg {
  color: white !important;
  stroke: white !important;
}
#todayEvents, #upcomingEvents {
  max-height: 220px !important;
  overflow-y: auto !important;
  display: block !important;
  scrollbar-width: thin;
  scrollbar-color: rgba(217, 119, 6, 0.5) rgba(243, 244, 246, 0.5);
}

/* Calendar cell styling */
#calendarDays > div {
  min-height: 70px; /* Set minimum height for calendar cells */
  max-height: 95px; /* Limit maximum height */
}

/* Upcoming events card styling */
#upcomingEvents .event-card {
  margin-bottom: 12px;
  border-radius: 8px;
  background: linear-gradient(to right, #fffbeb, #fff);
  border: 1px solid #fef3c7;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
  overflow: hidden;
  transition: transform 0.2s, box-shadow 0.2s;
}

#upcomingEvents .event-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

#upcomingEvents .event-date {
  font-size: 0.75rem;
  font-weight: 600;
  color: #92400e;
  background-color: #fef3c7;
  padding: 3px 8px;
  border-radius: 12px;
}

#upcomingEvents .event-title {
  font-weight: 600;
  color: #78350f;
  margin-bottom: 4px;
}

#upcomingEvents .event-description {
  color: #78350f;
  font-size: 0.875rem;
  line-height: 1.25rem;
}

/* Empty state styling */
#upcomingEvents .empty-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 2rem 1rem;
  text-align: center;
}

#upcomingEvents .empty-state-icon {
  width: 3.5rem;
  height: 3.5rem;
  background-color: #fffbeb;
  border-radius: 9999px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 0.75rem;
}

/* Custom scrollbar for Webkit browsers */
#upcomingEvents::-webkit-scrollbar {
  width: 8px;
}

#upcomingEvents::-webkit-scrollbar-track {
  background: rgba(243, 244, 246, 0.5);
  border-radius: 4px;
}

#upcomingEvents::-webkit-scrollbar-thumb {
  background-color: rgba(217, 119, 6, 0.5);
  border-radius: 4px;
}
#todayEvents .event-card {
  margin-bottom: 12px;
  border-radius: 8px;
  background: linear-gradient(to right, #fffbeb, #fff);
  border: 1px solid #fef3c7;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
  overflow: hidden;
  transition: transform 0.2s, box-shadow 0.2s;
}

#todayEvents .event-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

#todayEvents .event-date {
  font-size: 0.75rem;
  font-weight: 600;
  color: #92400e;
  background-color: #fef3c7;
  padding: 3px 8px;
  border-radius: 12px;
}

#todayEvents .event-title {
  font-weight: 600;
  color: #78350f;
  margin-bottom: 4px;
}

#todayEvents .event-description {
  color: #78350f;
  font-size: 0.875rem;
  line-height: 1.25rem;
}

/* Empty state styling for today events */
#todayEvents .empty-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 2rem 1rem;
  text-align: center;
}

#todayEvents .empty-state-icon {
  width: 3.5rem;
  height: 3.5rem;
  background-color: #fffbeb;
  border-radius: 9999px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 0.75rem;
}

/* Custom scrollbar for Webkit browsers */
#todayEvents::-webkit-scrollbar {
  width: 8px;
}

#todayEvents::-webkit-scrollbar-track {
  background: rgba(243, 244, 246, 0.5);
  border-radius: 4px;
}

#todayEvents::-webkit-scrollbar-thumb {
  background-color: rgba(217, 119, 6, 0.5);
  border-radius: 4px;
}
</style>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarDays = document.getElementById('calendarDays');
        const currentMonthElement = document.getElementById('currentMonth');
        const prevMonthButton = document.getElementById('prevMonth');
        const nextMonthButton = document.getElementById('nextMonth');
        const todayEventsContainer = document.getElementById('todayEvents');
        const upcomingEventsContainer = document.getElementById('upcomingEvents');
        
        let currentDate = new Date();
        
        // Define all events
        const events = [
            { 
                date: new Date(2025, 2, 9), // March 9, 2025
                title: 'Sample Event Day',
                description: 'This is a detailed description for Sample Event Day.'
            },
            { 
                date: new Date(2025, 2, 20), // March 20, 2025
                title: 'MIDTERM EXAMS',
                description: 'Midterm examinations begin on this day.'
            },
            { 
                date: new Date(2025, 2, 21), // March 21, 2025
                title: 'MIDTERM EXAMS',
                description: 'Continuation of midterm examinations.'
            },
            { 
                date: new Date(2025, 2, 22), // March 22, 2025
                title: 'MIDTERM EXAMS',
                description: 'Continuation of midterm examinations.'
            },
            { 
                date: new Date(2025, 2, 23), // March 23, 2025
                title: 'MIDTERM EXAMS',
                description: 'Continuation of midterm examinations.'
            },
            { 
                date: new Date(2025, 2, 24), // March 24, 2025
                title: 'MIDTERM EXAMS',
                description: 'Final day of midterm examinations.'
            }
        ];

        // Helper to format date
        function formatDate(date) {
            return new Intl.DateTimeFormat('en-US', {
                weekday: 'short',
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            }).format(date);
        }

        // Helper to check if two dates are the same day
        function isSameDay(date1, date2) {
            return date1.getFullYear() === date2.getFullYear() &&
                   date1.getMonth() === date2.getMonth() &&
                   date1.getDate() === date2.getDate();
        }

        // Helper to check if a date is in the future (or today)
        function isFutureOrToday(date) {
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            return date >= today;
        }

        
function displayEvents() {
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    // Filter events for today
    const todaysEvents = events.filter(event => isSameDay(event.date, today));
    
    // Display today's events with matching style to upcoming events
    if (todaysEvents.length > 0) {
        todayEventsContainer.innerHTML = '';
        todaysEvents.forEach(event => {
            const eventElement = document.createElement('div');
            eventElement.className = 'event-card';
            
            // Format the date in a more readable way
            const eventDate = formatDate(event.date);
            const dayName = eventDate.split(',')[0]; // e.g., "Thu"
            const restOfDate = eventDate.split(',')[1].trim(); // e.g., "Mar 20, 2025"
            
            eventElement.innerHTML = `
                <div class="p-3">
                <div class="flex justify-between items-start mb-2">
                    <h3 class="event-title">${event.title}</h3>
                    <span class="event-date">${dayName}, ${restOfDate}</span>
                </div>
                <p class="event-description">${event.description}</p>
                </div>
            `;
            todayEventsContainer.appendChild(eventElement);
        });
    } else {
        todayEventsContainer.innerHTML = `
            <div class="empty-state">
                <div class="empty-state-icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-amber-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
                </svg>
                </div>
                <p class="text-sm text-gray-500">No events scheduled for today</p>
            </div>
        `;
    }

    const futureEvents = events.filter(event => isFutureOrToday(event.date) && !isSameDay(event.date, today))
                     .sort((a, b) => a.date - b.date);

    // Display upcoming events with improved styling
    if (futureEvents.length > 0) {
        upcomingEventsContainer.innerHTML = '';
        futureEvents.forEach(event => {
            const eventElement = document.createElement('div');
            eventElement.className = 'event-card';
            
            // Format the date in a more readable way
            const eventDate = formatDate(event.date);
            const dayName = eventDate.split(',')[0]; // e.g., "Thu"
            const restOfDate = eventDate.split(',')[1].trim(); // e.g., "Mar 20, 2025"
            
            eventElement.innerHTML = `
                <div class="p-3">
                <div class="flex justify-between items-start mb-2">
                    <h3 class="event-title">${event.title}</h3>
                    <span class="event-date">${dayName}, ${restOfDate}</span>
                </div>
                <p class="event-description">${event.description}</p>
                </div>
            `;
            upcomingEventsContainer.appendChild(eventElement);
        });
    } else {
        upcomingEventsContainer.innerHTML = `
        <div class="empty-state">
            <div class="empty-state-icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-amber-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
            </svg>
            </div>
            <p class="text-sm text-gray-500">No upcoming events</p>
        </div>
        `;
    }
}


        function renderCalendar(date) {
            const firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
            const lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
            const startingDay = firstDay.getDay();
            const monthLength = lastDay.getDate();

            currentMonthElement.textContent = new Intl.DateTimeFormat('en-US', {
                month: 'long',
                year: 'numeric'
            }).format(date);

            calendarDays.innerHTML = '';
            
            // Determine if we need 5 or 6 rows for the current month
            const totalDaysToShow = startingDay + monthLength;
            const rowsNeeded = Math.ceil(totalDaysToShow / 7);
            
            // Set grid template rows based on needed rows (5 or 6)
            calendarDays.style.gridTemplateRows = `repeat(${rowsNeeded}, minmax(70px, auto))`;
            
            // Days from previous month
            for (let i = 0; i < startingDay; i++) {
                const emptyDay = document.createElement('div');
                emptyDay.className = 'border border-gray-800 bg-[#3A1616]';
                calendarDays.appendChild(emptyDay);
            }

            // Days of current month
            for (let day = 1; day <= monthLength; day++) {
                const currentDayDate = new Date(date.getFullYear(), date.getMonth(), day);
                const dayCell = document.createElement('div');
                dayCell.className = 'border border-gray-700 bg-[#3A1616] relative p-2';
                
                // Add day number
                const dayNumber = document.createElement('div');
                dayNumber.className = 'text-gray-300 text-sm';
                dayNumber.textContent = day;
                dayCell.appendChild(dayNumber);

                // Check if it's today
                const today = new Date();
                if (day === today.getDate() && date.getMonth() === today.getMonth() && date.getFullYear() === today.getFullYear()) {
                    dayCell.classList.add('relative');
                    const todayLabel = document.createElement('div');
                    todayLabel.className = 'absolute top-2 left-[30px] bg-purple-600 text-white text-xs px-2 py-0.5 rounded-sm';
                    todayLabel.textContent = 'TODAY';
                    dayCell.appendChild(todayLabel);
                }

                // Find events for this day
                const dayEvents = events.filter(event => 
                    event.date.getFullYear() === currentDayDate.getFullYear() &&
                    event.date.getMonth() === currentDayDate.getMonth() &&
                    event.date.getDate() === day
                );

                // Add events to the day cell
                dayEvents.forEach((event, index) => {
                    const eventDiv = document.createElement('div');
                    eventDiv.className = `mt-${index === 0 ? '6' : '2'} text-xs p-1 rounded bg-gray-600 text-white truncate`;
                    eventDiv.textContent = event.title;
                    dayCell.appendChild(eventDiv);
                    
                    // Make day cell clickable to view events
                    dayCell.style.cursor = 'pointer';
                    dayCell.addEventListener('click', () => {
                        // Update the displayed events when clicking on a day with events
                        const clickedDate = new Date(date.getFullYear(), date.getMonth(), day);
                        showEventDetails(clickedDate);
                    });
                });

                calendarDays.appendChild(dayCell);
            }

            // Fill in only the current row with days from next month
            const currentCellCount = startingDay + monthLength;
            const cellsInLastRow = currentCellCount % 7;
            let emptyCellsToAdd = 0;
            
            if (cellsInLastRow > 0) {
                emptyCellsToAdd = 7 - cellsInLastRow;
            }
            
            for (let i = 0; i < emptyCellsToAdd; i++) {
                const emptyDay = document.createElement('div');
                emptyDay.className = 'border border-gray-800 bg-[#3A1616]';
                calendarDays.appendChild(emptyDay);
            }
            
            // Add a class to the calendar container to adjust its height
            const calendarContainer = calendarDays.parentElement;
            if (rowsNeeded === 5) {
                calendarContainer.style.height = '420px'; // Shorter for 5 rows
            } else {
                calendarContainer.style.height = '500px'; // Taller for 6 rows
            }
        }

        // Show event details for a specific date
        function showEventDetails(date) {
    const eventsForDay = events.filter(event => isSameDay(event.date, date));
    
    const container = document.getElementById('todayEvents');
    container.innerHTML = '';
    
    if (eventsForDay.length > 0) {
        eventsForDay.forEach(event => {
            const eventElement = document.createElement('div');
            eventElement.className = 'event-card';
            
            // Format the date in a more readable way
            const eventDate = formatDate(event.date);
            const dayName = eventDate.split(',')[0]; // e.g., "Thu" 
            const restOfDate = eventDate.split(',')[1].trim(); // e.g., "Mar 20, 2025"
            
            eventElement.innerHTML = `
                <div class="p-3">
                <div class="flex justify-between items-start mb-2">
                    <h3 class="event-title">${event.title}</h3>
                    <span class="event-date">${dayName}, ${restOfDate}</span>
                </div>
                <p class="event-description">${event.description}</p>
                </div>
            `;
            container.appendChild(eventElement);
        });
    } else {
        container.innerHTML = `
        <div class="empty-state">
            <div class="empty-state-icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-amber-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
            </svg>
            </div>
            <p class="text-sm text-gray-500">No events scheduled for ${formatDate(date).split(',')[0]}</p>
        </div>
        `;
    }
}
        // Initialize calendar and events
        renderCalendar(currentDate);
        displayEvents();

        // Add month navigation handlers
        prevMonthButton.addEventListener('click', () => {
            currentDate = new Date(currentDate.getFullYear(), currentDate.getMonth() - 1, 1);
            renderCalendar(currentDate);
        });

        nextMonthButton.addEventListener('click', () => {
            currentDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 1);
            renderCalendar(currentDate);
        });
    });
    </script>
</section>
    <section id="campusmap"  class="content-section py-4">
    <div class="section-heading text-center mb-5">
        <h1 class="display-5 fw-bold position-relative d-inline-block mb-0">
            <span class="gradient-text">CAMPUS BUILDINGS</span>
        </h1>
        <div class="animated-bar mx-auto mt-2 mb-3"></div>
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
                               <input type="text" id="search-input" class="search" placeholder="Enter room name" style="color: black;">
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
                                <input type="text" id="search" class="search" placeholder="Enter room name">
                                <button onclick="searchElement()" class="search-button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                            <div class="table-container">
                                <svg id="room-svg" viewBox="0 0 985 588" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="40.5" y="205.5" width="52" height="95" fill="#D9D9D9" stroke="black" />
                                    <rect x="220.5" y="205.5" width="53" height="95" fill="#D9D9D9" stroke="black" />
                                    <rect id="cit-5-a-b" x="167.5" y="205.5" width="52" height="95" fill="#D9D9D9" stroke="black" />
                                    <text id="stock-room" x="195" y="250" text-anchor="middle" font-size="12">
                                        STOCK
                                        <tspan dy="1.2em" dx="-44">ROOM</tspan>
                                    </text>
                                    <rect id="ctl-1-a" x="40.5" y="301.5" width="52" height="67" fill="#D9D9D9" stroke="black" />
                                    <text id="ctl-1-a-text" x="63" y="335" text-anchor="middle" font-size="12">CTL 1-A</text>
                                    <rect id="cit-3-b-rect" x="303.5" y="72.5" width="49" height="69" fill="#D9D9D9" stroke="black" />
                                    <text id="cit-3-b-text" x="328" y="105" text-anchor="middle" font-size="12">CIT 3-B</text>
                                    <rect id="cit-5-a-b-rect" x="353.5" y="72.5" width="53" height="69" fill="#D9D9D9" stroke="black" />
                                    <rect id="cit-5-a-b-combined" x="361.5" y="205.5" width="90" height="95" fill="#D9D9D9" stroke="black" />
                                    <text id="cit-5-a-b-text" x="406" y="250" text-anchor="middle" font-size="12">CIT 5-A & 5-B
                                        <tspan dy="1.2em" dx="-80">ELECTRICAL</tspan>
                                    </text>
                                    <rect id="etl-5" x="452.5" y="205.5" width="90" height="95" fill="#D9D9D9" stroke="black" />
                                    <text id="etl-5-text" x="497" y="250" text-anchor="middle" font-size="12">ETL 5</text>
                                    <rect id="cit-5-b-lec" x="543.5" y="205.5" width="90" height="95" fill="#D9D9D9" stroke="black" />
                                    <text id="cit-5-b-lec-text" x="588" y="250" text-anchor="middle" font-size="12">CIT 5-B LEC</text>
                                    <rect id="bodega" x="634.5" y="205.5" width="90" height="95" fill="#D9D9D9" stroke="black" />
                                    <text id="bodega-text" x="679" y="250" text-anchor="middle" font-size="12">BODEGA</text>
                                    <rect id="library" x="725.5" y="205.5" width="89" height="95" fill="#D9D9D9" stroke="black" />
                                    <text id="library-text" x="770" y="250" text-anchor="middle" font-size="12">LIBRARY</text>
                                    <rect id="chairperson-office" x="220.5" y="136.5" width="53" height="68" fill="#D9D9D9" stroke="black" />
                                    <text id="chairperson-office-text" x="250" y="170" text-anchor="middle" font-size="8">
                                        CHAIRPERSON
                                        <tspan dy="1.2em" dx="-44">OFFICE</tspan>
                                    </text>
                                    <rect id="d-o" x="40.5" y="369.5" width="52" height="68" fill="#D9D9D9" stroke="black" />
                                    <text id="d-o-text" x="63" y="405" text-anchor="middle" font-size="12">D.O.</text>
                                    <rect id="cr" x="40.5" y="438.5" width="52" height="69" fill="#D9D9D9" stroke="black" />
                                    <text id="cr-text" x="63" y="475" text-anchor="middle" font-size="12">CR</text>
                                    <rect id="cit-2-a" x="93.5" y="205.5" width="73" height="46" fill="#D9D9D9" stroke="black" />
                                    <text id="cit-2-a-text" x="130" y="230" text-anchor="middle" font-size="12">CIT 2-A</text>
                                    <path id="welding" d="M274 205H361V301H274V205Z" fill="#D9D9D9" />
                                    <text id="welding-text" x="317" y="250" text-anchor="middle" font-size="12">WELDING</text>
                                    <rect id="cit-3-a" x="220.5" y="72.5" width="82" height="69" fill="#D9D9D9" stroke="black" />
                                    <text id="cit-3-a-text" x="261" y="105" text-anchor="middle" font-size="12">CIT 3-A</text>
                                    <rect id="cit-2-b" x="93.5" y="252.5" width="73" height="48" fill="#D9D9D9" stroke="black" />
                                    <text id="cit-2-b-text" x="130" y="280" text-anchor="middle" font-size="12">CIT 2-B</text>
                                    <path id="pantry" d="M274 142H407V205H274V142Z" fill="#D9D9D9" />
                                    <text id="pantry-text" x="340" y="172" text-anchor="middle" font-size="12">PANTRY</text>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M405.629 205H407V142H405.629V205Z" fill="black" />
                                    <rect id="breaker" x="815.5" y="180.5" width="39" height="48" fill="#D9D9D9" stroke="black" />
                                    <text id="breaker-text" x="834" y="205" text-anchor="middle" font-size="8">BREAKER</text>
                                    <rect id="ctl-6" x="855.5" y="286.5" width="89" height="94" fill="#D9D9D9" stroke="black" />
                                    <text id="ctl-6-text" x="900" y="322" text-anchor="middle" font-size="12">CTL 6</text>
                                    <rect id="ctl-6-a-b" x="855.5" y="190.5" width="89" height="95" fill="#D9D9D9" stroke="black" />
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
                                <input type="text" id="search2" class="search" placeholder="Enter room name" aria-label="Search for a room">
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
                                    <rect id="stairs-rect" x="140.5" y="140.5" width="61" height="100" fill="#D9D9D9" stroke="#0D0D0D" />
                                    <text id="stairs-text" x="171" y="190" font-family="Arial" font-size="12" text-anchor="middle">STAIRS</text>

                                    <rect id="men-cr-rect" x="332.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D" />
                                    <text id="men-cr-text" x="370" y="190" font-family="Arial" font-size="12" text-anchor="middle">MALE CR</text>



                                    <rect id="female-cr-rect" x="473.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D" />
                                    <text id="female-cr-text" x="511" y="190" font-family="Arial" font-size="12" text-anchor="middle">FEMALE CR</text>

                                    <rect id="s-104-rect" x="620.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D" />
                                    <text id="s-104-text" x="650" y="190" font-family="Arial" font-size="12" text-anchor="middle">S-104</text>

                                    <rect id="s-106-rect" x="550" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D" />
                                    <text id="s-106-text" x="585" y="190" font-family="Arial" font-size="12" text-anchor="middle">S-106</text>

                                    <rect id="s-102-rect" x="755" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D" />
                                    <text id="s-102-text" x="780" y="190" font-family="Arial" font-size="12" text-anchor="middle">S-102</text>

                                    <rect id="s-103-rect" x="680.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D" />
                                    <text id="s-103-text" x="720" y="190" font-family="Arial" font-size="12" text-anchor="middle">S-103</text>

                                    <rect id="s-101-rect" x="890" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D" />
                                    <text id="s-101-text" x="930" y="190" font-family="Arial" font-size="12" text-anchor="middle">S-101</text>

                                    <rect id="male-cr-rect" x="820.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D" />
                                    <text id="male-cr-text" x="860" y="190" font-family="Arial" font-size="12" text-anchor="middle">MALE CR</text>

                                    <rect id="s-109-rect" x="202.5" y="140.5" width="64" height="65" fill="#D9D9D9" stroke="#0D0D0D" />
                                    <text id="s-109-text" x="230" y="170" font-family="Arial" font-size="12" text-anchor="middle">S-109</text>

                                    <rect id="pwd-cr-base-rect" x="408.5" y="140.5" width="64" height="53" fill="#D9D9D9" stroke="#0D0D0D" />
                                    <rect id="pwd-cr-rect" x="408.5" y="193.5" width="64" height="53" fill="#D9D9D9" stroke="#0D0D0D" />
                                    <text id="pwd-cr-text" x="440" y="220" font-family="Arial" font-size="12" text-anchor="middle">PWD CR</text>

                                    <rect id="stairs-2-rect" x="965" y="140.5" width="64" height="54" fill="#D9D9D9" stroke="#0D0D0D" />
                                    <text id="stairs-2-text" x="1000" y="170" font-family="Arial" font-size="12" text-anchor="middle">STAIRS</text>

                                    <mask id="path-18-inside-1_0_1" fill="white">
                                        <path d="M267 140H332V206H267V140Z" />
                                    </mask>

                                    <path d="M267 140H332V206H267V140Z" fill="#D9D9D9" />
                                    <path d="M267 141H332V139H267V141Z" fill="#0D0D0D" mask="url(#path-18-inside-1_0_1)" />

                                    <rect id="s-108-rect" x="202.5" y="206.5" width="64" height="65" fill="#D9D9D9" stroke="#0D0D0D" />
                                    <text id="s-108-text" x="230" y="240" font-family="Arial" font-size="12" text-anchor="middle">S-108</text>
                                </svg>
                                <!--floor 2-->
                                <svg id="room-svg-2" class="floor-svg" style="display:none;" width="1367" height="472" viewBox="0 0 1367 472" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect id="stairs-rect" x="140.5" y="140.5" width="61" height="84" fill="#D9D9D9" stroke="#0D0D0D" />
                                    <text id="stairs-text" x="150" y="182" font-family="Arial" font-size="12" fill="black">STAIRS</text>

                                    <rect id="male-cr-rect" x="332.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D" />
                                    <text id="male-cr-text" x="340" y="182" font-family="Arial" font-size="12" fill="black">MALE CR</text>

                                    <rect id="s-205-rect" x="570.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D" />
                                    <text id="s-205-text" x="600" y="182" font-family="Arial" font-size="12" fill="black">S-205</text>

                                    <rect id="s-206-rect" x="494.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D" />
                                    <text id="s-206-text" x="520" y="182" font-family="Arial" font-size="12" fill="black">S-206</text>

                                    <rect id="s-201-rect" x="1022.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D" />
                                    <text id="s-201-text" x="1050" y="182" font-family="Arial" font-size="12" fill="black">S-201</text>

                                    <rect id="s-204-rect" x="643.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D" />
                                    <text id="s-204-text" x="673" y="182" font-family="Arial" font-size="12" fill="black">S-204</text>

                                    <rect id="female-cr-rect" x="946.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D" />
                                    <text id="female-cr-text" x="950" y="182" font-family="Arial" font-size="12" fill="black">FEMALE CR</text>

                                    <rect id="s-202-rect" x="831.5" y="140.5" width="114" height="106" fill="#D9D9D9" stroke="#0D0D0D" />
                                    <text id="s-202-text" x="860" y="182" font-family="Arial" font-size="12" fill="black">S-202</text>

                                    <rect id="s-203-rect" x="716.5" y="140.5" width="114" height="106" fill="#D9D9D9" stroke="#0D0D0D" />
                                    <text id="s-203-text" x="745" y="182" font-family="Arial" font-size="12" fill="black">S-203</text>

                                    <rect id="s-208-rect" x="202.5" y="140.5" width="130" height="107" fill="#D9D9D9" stroke="#0D0D0D" />
                                    <text id="s-208-text" x="244" y="200" font-family="Arial" font-size="12" fill="black">S-208</text>

                                    <rect id="s-207-rect" x="408.5" y="140.5" width="85" height="106" fill="#D9D9D9" stroke="#0D0D0D" />
                                    <text id="s-207-text" x="435" y="182" font-family="Arial" font-size="12" fill="black">S-207</text>

                                    <rect id="stairs-2-rect" x="1098.5" y="140.5" width="64" height="54" fill="#D9D9D9" stroke="#0D0D0D" />
                                    <text id="stairs-2-text" x="1106" y="165" font-family="Arial" font-size="12" fill="black">STAIRS</text>
                                </svg>
                                <!--floor 3-->
                                <svg id="room-svg-3" class="floor-svg" style="display:none;" width="1367" height="472" viewBox="0 0 1367 472" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect id="stairs-1" x="140.5" y="140.5" width="61" height="84" fill="#D9D9D9" stroke="#0D0D0D" />
                                    <text id="stairs-1-text" x="150" y="182" font-family="Arial" font-size="12" fill="black">STAIRS</text>

                                    <rect id="male-cr-rect" x="332.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D" />
                                    <text id="male-cr-text" x="340" y="182" font-family="Arial" font-size="12" fill="black">S-307</text>

                                    <rect id="male-cr-2-rect" x="570.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D" />
                                    <text id="male-cr-2-text" x="580" y="182" font-family="Arial" font-size="12" fill="black">MALE CR</text>

                                    <rect id="female-cr-1-rect" x="494.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D" />
                                    <text id="female-cr-1-text" x="498" y="182" font-family="Arial" font-size="12" fill="black">FEMALE CR</text>

                                    <rect id="s-301-rect" x="1022.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D" />
                                    <text id="s-301-text" x="1050" y="182" font-family="Arial" font-size="12" fill="black">S-301</text>

                                    <rect id="s-305-rect" x="643.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D" />
                                    <text id="s-305-text" x="673" y="182" font-family="Arial" font-size="12" fill="black">S-305</text>

                                    <rect id="female-cr-2-rect" x="946.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D" />
                                    <text id="female-cr-2-text" x="950" y="182" font-family="8" fill="black">FACULTY ROOM</text>

                                    <rect id="s-303-rect" x="831.5" y="140.5" width="114" height="106" fill="#D9D9D9" stroke="#0D0D0D" />
                                    <text id="s-303-text" x="860" y="182" font-family="Arial" font-size="12" fill="black">S-303</text>

                                    <rect id="s-304-rect" x="716.5" y="140.5" width="114" height="106" fill="#D9D9D9" stroke="#0D0D0D" />
                                    <text id="s-304-text" x="745" y="182" font-family="Arial" font-size="12" fill="black">S-304</text>

                                    <rect id="uapsa-rect" x="202.5" y="140.5" width="130" height="107" fill="#D9D9D9" stroke="#0D0D0D" />
                                    <text id="uapsa-text" x="244" y="200" font-family="Arial" font-size="12" fill="black">UAPSA</text>

                                    <rect id="s-306-rect" x="408.5" y="140.5" width="85" height="106" fill="#D9D9D9" stroke="#0D0D0D" />
                                    <text id="s-306-text" x="435" y="182" font-family="Arial" font-size="12" fill="black">S-306</text>

                                    <rect id="stairs-2-rect" x="1098.5" y="140.5" width="64" height="54" fill="#D9D9D9" stroke="#0D0D0D" />
                                    <text id="stairs-2-text" x="1106" y="165" font-family="Arial" font-size="12" fill="black">STAIRS</text>
                                </svg>


                            </div>
                        </div>
                    </div>
                </div>

            </section>



    <script>
        // Restore your existing JavaScript functions
        function showFloorTable(floorId) {
            document.querySelectorAll('.floor-table').forEach(table => {
                table.style.display = 'none';
            });

            const selectedTable = document.getElementById(`floor-${floorId}`);
            if (selectedTable) {
                selectedTable.style.display = 'table';
                selectedTable.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }

        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tab-button");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        function searchAndHighlight() {
            var input = document.getElementById('search-input').value.toLowerCase();
            // Your existing search and highlight logic
        }
    </script>



            <section id="campusmap" class="content-section bg-light remove-padding-sm py-5">
            <div class="section-heading text-center mb-5">
        <h1 class="display-5 fw-bold position-relative d-inline-block mb-0">
            <span class="gradient-text">CAMPUS BUILDINGS</span>
        </h1>
        <div class="animated-bar mx-auto mt-2 mb-3"></div>
    </div>
                <!-- Tab Navigation -->
                <div class="tab-container">
                    <button class="tab-button active" data-tab="ccs">CCS</button>
                    <button class="tab-button" data-tab="cit">CIT</button>
                    <button class="tab-button" data-tab="cafa">CAFA</button>
                </div>

                <!-- Floor Map Section -->
                <div id="ccs" class="tab-content">
                    <div id="map">
                        <div class="map section-content-map">
                            <div class="dropdown">
                               <input type="text" id="search-input" class="search" placeholder="Enter room name" style="color: black;">
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

                <!-- CIT Building Floor Tables -->
                <div id="cit" class="tab-content" style="display: none;">
                    <div id="map">
                        <div class="map section-content-map">
                            <div class="dropdown">
                                <input type="text" id="search-input-cit" class="search" placeholder="Enter room name" style="color: black;">
                                <button onclick="searchAndHighlightCIT()" class="search-button">
                                    <i class="fa fa-search"></i>
                                </button>
                                <select id="dropdownMenu-cit" onchange="showFloorTableForBuilding('cit', this.value)">
                                    <option value="1" selected>1st Floor</option>
                                    <option value="2">2nd Floor</option>
                                    <option value="3">3rd Floor</option>
                                    <option value="4">4th Floor</option>
                                    <option value="5">5th Floor</option>
                                </select>
                            </div>
                            <div class="table-container">
                                <!-- CIT Floor 1 -->
                                <table class="floor-table" id="floor-cit-1" border="1">
                                    <tbody>
                                        <tr>
                                            <td class="floor-gray" colspan="2" id="cit-1" style="height: 100px;">STOCK ROOM</td>
                                            <td id="cit-2" class="floor-gray" rowspan="2" style="width: 120px;">CTL 1-A</td>
                                            <td id="cit-3" class="floor-gray" rowspan="2" style="width: 120px;">CIT 3-B</td>
                                            <td id="cit-4" class="floor-gray" colspan="2" rowspan="2">CIT 5-A & 5-B</td>
                                            <td id="cit-5" class="floor-gray" rowspan="2" style="width: 70px;">ETL 5</td>
                                            <td id="cit-6" class="floor-gray" rowspan="2" style="width: 70px;">CIT 5-B LEC</td>
                                            <td id="cit-7" class="floor-gray" colspan="2">BODEGA</td>
                                        </tr>
                                        <tr>
                                            <td id="cit-8" class="floor-gray" colspan="2" style="height: 50px;">LIBRARY</td>
                                            <td id="cit-9" class="floor-gray" colspan="2">CHAIRPERSON OFFICE</td>
                                        </tr>
                                        <tr>
                                            <td class="floor-gray" colspan="2" id="cit-10">D.O.</td>
                                            <td id="cit-11" class="floor-maroon" colspan="6" rowspan="4">GROUND FLOOR</td>
                                            <td id="cit-12" class="floor-gray" colspan="2">CR</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="floor-gray" id="cit-13">CIT 2-A</td>
                                            <td id="cit-14" class="floor-gray" colspan="2">WELDING</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="floor-gray" id="cit-15" style="height: 60px;">CIT 3-A</td>
                                            <td id="cit-16" class="floor-gray" colspan="2">PANTRY</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="floor-gray" id="cit-17" style="height: 50px;">CIT 2-B</td>
                                            <td id="cit-18" class="floor-gray" colspan="2">BREAKER</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="cafa" class="tab-content" style="display: none;">
                    <div id="map">
                        <div class="map section-content-map">
                            <div class="dropdown">
                                <input type="text" id="search-input-cafa" class="search" placeholder="Enter room name" style="color: black;">
                                <button onclick="searchAndHighlightCAFA()" class="search-button">
                                    <i class="fa fa-search"></i>
                                </button>
                                <select id="dropdownMenu-cafa" onchange="showFloorTableCAFA(this.value)">
                                    <option value="1" selected>1st Floor</option>
                                    <option value="2">2nd Floor</option>
                                    <option value="3">3rd Floor</option>
                                </select>
                            </div>
                            <div class="table-container">
                                <table class="floor-table" id="floor-cafa-1" border="1">
                                    <tbody>
                                        <tr>
                                            <td class="floor-gray" colspan="2" id="cafa-1" style="height: 100px;">STAIRS</td>
                                            <td id="cafa-2" class="floor-gray" rowspan="2" style="width: 120px;">MALE CR</td>
                                            <td id="cafa-3" class="floor-gray" rowspan="2" style="width: 120px;">FEMALE CR</td>
                                            <td id="cafa-4" class="floor-gray" colspan="2" rowspan="2">S-104</td>
                                            <td id="cafa-5" class="floor-gray" rowspan="2" style="width: 70px;">S-106</td>
                                            <td id="cafa-6" class="floor-gray" rowspan="2" style="width: 70px;">S-102</td>
                                            <td id="cafa-7" class="floor-gray" colspan="2">S-103</td>
                                        </tr>
                                        <tr>
                                            <td id="cafa-8" class="floor-gray" colspan="2" style="height: 50px;">S-101</td>
                                            <td id="cafa-9" class="floor-gray" colspan="2">MALE CR</td>
                                        </tr>
                                        <tr>
                                            <td class="floor-gray" colspan="2" id="cafa-10">S-109</td>
                                            <td id="cafa-11" class="floor-maroon" colspan="6" rowspan="4">GROUND FLOOR</td>
                                            <td id="cafa-12" class="floor-gray" colspan="2">PWD CR</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="floor-gray" id="cafa-13">STAIRS</td>
                                            <td id="cafa-14" class="floor-gray" colspan="2">S-108</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <section id="facultymembers" class="content-section py-4">
    <div class="section-content">
        <div class="section-heading text-center mb-5">
            <h1 class="display-5 fw-bold position-relative d-inline-block mb-0">
                <span class="gradient-text">FACULTY MEMBERS</span>
            </h1>
            <div class="animated-bar mx-auto mt-2 mb-3"></div>
        </div>

        <!-- Faculty Members -->
        <div class="level1">
            <?php foreach ($allDean as $head): ?>
                <div class="member" data-name="<?= htmlspecialchars($head['faculty_name']) ?>"
                    data-specialization="<?= htmlspecialchars($head['specialization']) ?>"
                    data-consultation="<?= htmlspecialchars($head['consultation_time']) ?>"
                    data-image="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>">
                    <img src="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>" alt="Dean">
                    <div class="member-info">
                        <p class="member-name"><?= htmlspecialchars($head['faculty_name']) ?></p>
                        <p class="member-department"><?= implode(", ", $head['departments']); ?></p>
                    </div>
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
                    <div class="member-info">
                        <p class="member-name"><?= htmlspecialchars($head['faculty_name']) ?></p>
                        <p class="member-department"><?= implode(", ", $head['departments']); ?></p>
                    </div>
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
                    <div class="member-info">
                        <p class="member-name"><?= htmlspecialchars($head['faculty_name']) ?></p>
                        <p class="member-department"><?= implode(", ", $head['departments']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Department Buttons -->
        <div class="fclty-div">
            <button type="button" class="button-faculty-btn active" data-tab="tab1">IT Department</button>
            <button type="button" class="button-faculty-btn" data-tab="tab2">IS Department</button>
            <button type="button" class="button-faculty-btn" data-tab="tab3">CS Department</button>
            <button type="button" class="button-faculty-btn" data-tab="tab4">MIT</button>
        </div>

        <!-- IT Department Tab -->
        <div id="tab1" class="org-chart active">
            <div class="section-content">
                <h3>IT CHAIRPERSON</h3>
                <div class="level2">
                    <?php foreach ($allItHeads as $head): ?>
                        <div class="member" data-name="<?= htmlspecialchars($head['faculty_name']) ?>"
                            data-specialization="<?= htmlspecialchars($head['specialization']) ?>"
                            data-consultation="<?= htmlspecialchars($head['consultation_time']) ?>"
                            data-image="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>">
                            <img src="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>" alt="Dean">
                            <div class="member-info">
                                <p class="member-name"><?= htmlspecialchars($head['faculty_name']) ?></p>
                                <p class="member-department"><?= implode(", ", $head['departments']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <h3>Faculty Members</h3>
                <div class="level3">
                    <?php foreach ($allIt as $faculty): ?>
                        <div class="member" data-name="<?= htmlspecialchars($faculty['faculty_name']) ?>"
                            data-specialization="<?= htmlspecialchars($faculty['specialization']) ?>"
                            data-consultation="<?= htmlspecialchars($faculty['consultation_time']) ?>"
                            data-image="uploaded/facultyUploaded/<?= htmlspecialchars($faculty['faculty_image']) ?>">
                            <img src="uploaded/facultyUploaded/<?= htmlspecialchars($faculty['faculty_image']) ?>" alt="Faculty Member">
                            <div class="member-info">
                                <p class="member-name"><?= htmlspecialchars($faculty['faculty_name']) ?></p>
                                <p class="member-department"><?= implode(", ", $faculty['departments']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- IS Department Tab -->
        <div id="tab2" class="org-chart">
            <div class="section-content">
                <h3>IS CHAIRPERSON</h3>
                <div class="level2">
                    <?php foreach ($allIsHeads as $head): ?>
                        <div class="member" data-name="<?= htmlspecialchars($head['faculty_name']) ?>"
                            data-specialization="<?= htmlspecialchars($head['specialization']) ?>"
                            data-consultation="<?= htmlspecialchars($head['consultation_time']) ?>"
                            data-image="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>">
                            <img src="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>" alt="Dean">
                            <div class="member-info">
                                <p class="member-name"><?= htmlspecialchars($head['faculty_name']) ?></p>
                                <p class="member-department"><?= implode(", ", $head['departments']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <h3>Faculty Members</h3>
                <div class="level3">
                    <?php foreach ($allIs as $faculty): ?>
                        <div class="member" data-name="<?= htmlspecialchars($faculty['faculty_name']) ?>"
                            data-specialization="<?= htmlspecialchars($faculty['specialization']) ?>"
                            data-consultation="<?= htmlspecialchars($faculty['consultation_time']) ?>"
                            data-image="uploaded/facultyUploaded/<?= htmlspecialchars($faculty['faculty_image']) ?>">
                            <img src="uploaded/facultyUploaded/<?= htmlspecialchars($faculty['faculty_image']) ?>" alt="Faculty Member">
                            <div class="member-info">
                                <p class="member-name"><?= htmlspecialchars($faculty['faculty_name']) ?></p>
                                <p class="member-department"><?= implode(", ", $faculty['departments']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- CS Department Tab -->
        <div id="tab3" class="org-chart">
            <div class="section-content">
                <h3>CS CHAIRPERSON</h3>
                <div class="level2">
                    <?php foreach ($allCsHeads as $head): ?>
                        <div class="member" data-name="<?= htmlspecialchars($head['faculty_name']) ?>"
                            data-specialization="<?= htmlspecialchars($head['specialization']) ?>"
                            data-consultation="<?= htmlspecialchars($head['consultation_time']) ?>"
                            data-image="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>">
                            <img src="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>" alt="Dean">
                            <div class="member-info">
                                <p class="member-name"><?= htmlspecialchars($head['faculty_name']) ?></p>
                                <p class="member-department"><?= implode(", ", $head['departments']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <h3>Faculty Members</h3>
                <div class="level3">
                    <?php foreach ($allCs as $faculty): ?>
                        <div class="member" data-name="<?= htmlspecialchars($faculty['faculty_name']) ?>"
                            data-specialization="<?= htmlspecialchars($faculty['specialization']) ?>"
                            data-consultation="<?= htmlspecialchars($faculty['consultation_time']) ?>"
                            data-image="uploaded/facultyUploaded/<?= htmlspecialchars($faculty['faculty_image']) ?>">
                            <img src="uploaded/facultyUploaded/<?= htmlspecialchars($faculty['faculty_image']) ?>" alt="Faculty Member">
                            <div class="member-info">
                                <p class="member-name"><?= htmlspecialchars($faculty['faculty_name']) ?></p>
                                <p class="member-department"><?= implode(", ", $faculty['departments']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- MIT Department Tab -->
        <div id="tab4" class="org-chart">
            <div class="section-content">
                <h3>MIT CHAIRPERSON</h3>
                <div class="level2">
                    <?php foreach ($allMitHeads as $head): ?>
                        <div class="member" data-name="<?= htmlspecialchars($head['faculty_name']) ?>"
                            data-specialization="<?= htmlspecialchars($head['specialization']) ?>"
                            data-consultation="<?= htmlspecialchars($head['consultation_time']) ?>"
                            data-image="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>">
                            <img src="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>" alt="Dean">
                            <div class="member-info">
                                <p class="member-name"><?= htmlspecialchars($head['faculty_name']) ?></p>
                                <p class="member-department"><?= implode(", ", $head['departments']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <h3>Faculty Members</h3>
                <div class="level3">
                    <?php foreach ($allMit as $faculty): ?>
                        <div class="member" data-name="<?= htmlspecialchars($faculty['faculty_name']) ?>"
                            data-specialization="<?= htmlspecialchars($faculty['specialization']) ?>"
                            data-consultation="<?= htmlspecialchars($faculty['consultation_time']) ?>"
                            data-image="uploaded/facultyUploaded/<?= htmlspecialchars($faculty['faculty_image']) ?>">
                            <img src="uploaded/facultyUploaded/<?= htmlspecialchars($faculty['faculty_image']) ?>" alt="Faculty Member">
                            <div class="member-info">
                                <p class="member-name"><?= htmlspecialchars($faculty['faculty_name']) ?></p>
                                <p class="member-department"><?= implode(", ", $faculty['departments']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Modal -->


    <style>
        /* Faculty Section Variables */
        #facultymembers {
            --maroon-dark: #3C1518;
            --maroon: #C33232;
            --gold: #E9CF8B;
            --light-gray: #EEEEEE;
            padding: 30px 0;
        }

        /* Gradient text for the heading */
        .gradient-text {
            background: linear-gradient(45deg, var(--maroon-dark), var(--maroon));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            display: inline-block;
        }

        /* Animated bar for the heading */
        .animated-bar {
            height: 4px;
            width: 80px;
            background: linear-gradient(to right, var(--maroon-dark), var(--maroon));
            border-radius: 2px;
        }

        /* Faculty Member Card Styling */
        #facultymembers .member {
            background-color: #3C1518;
            color: #fff;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            width: 100%;
            max-width: 350px;
            min-height: 90px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        #facultymembers .member:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        #facultymembers .member img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
            border: 2px solid #fff;
            flex-shrink: 0;
        }

        #facultymembers .member-info {
            flex: 1;
            overflow: hidden;
        }

        #facultymembers .member-name {
            margin: 0 0 5px 0;
            font-size: 16px;
            font-weight: 600;
            line-height: 1.2;
            color: #fff;
            white-space: normal;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #facultymembers .member-department {
            margin: 0;
            font-size: 14px;
            line-height: 1.3;
            color: rgba(255, 255, 255, 0.85);
            white-space: normal;
            overflow: hidden;
        }

        /* Department button styling */
        .fclty-div {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
            margin: 30px 0;
        }

        .button-faculty-btn {
            padding: 10px 20px;
            background-color: #3C1518;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .button-faculty-btn:hover {
            background-color: #701c24;
        }

        .button-faculty-btn.active {
            background-color: #C33232;
        }

        /* Section headings */
        #facultymembers h3 {
            color: #3C1518;
            margin: 30px 0 20px;
            text-align: center;
            font-size: 24px;
            font-weight: 600;
        }

        /* Layout for faculty members */
        .level1, .level2, .level3 {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-bottom: 30px;
        }

        /* Style for org-chart sections */
        .org-chart {
            display: none;
            margin-top: 20px;
        }

        .org-chart.active {
            display: block;
        }

        /* Backdrop styling */
        .backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            display: none;
        }

        /* Card styling */
        .custom-card {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            z-index: 1001;
            width: 90%;
            max-width: 400px;
            overflow: hidden;
        }

        .card-body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .rounded-circle {
            width: 150px !important;
            height: 150px !important;
            object-fit: cover;
            border-radius: 50% !important;
            margin: 0 auto 1rem;
            display: block;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: 3px solid #C33232;
        }

        #profileName {
            margin: 1rem 0;
            font-size: 1.5rem;
            font-weight: 700;
            color: #3C1518;
        }

        .text-muted {
            color: #6c757d !important;
            margin-bottom: 0.5rem;
            text-align: center;
            font-size: 1rem;
        }

        .specialization-value,
        .consultation-value {
            font-weight: 600;
            color: #3C1518;
        }

        /* Close button for modal */
        .card-body::after {
             content: "x"
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 24px;
            color: #C33232;
            cursor: pointer;
            font-weight: bold;
        }

        /* Animation for modal */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .card.show, .backdrop.show {
            display: block;
            animation: fadeIn 0.3s ease-out;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            #facultymembers .member {
                max-width: 100%;
            }
            
            .fclty-div {
                flex-direction: column;
                align-items: center;
            }
            
            .button-faculty-btn {
                width: 80%;
                margin-bottom: 5px;
            }
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Tab switching functionality
            const tabButtons = document.querySelectorAll('.button-faculty-btn');
            const tabContents = document.querySelectorAll('.org-chart');
            
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons and contents
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    tabContents.forEach(content => content.classList.remove('active'));
                    
                    // Add active class to clicked button
                    this.classList.add('active');
                    
                    // Show corresponding content
                    const tabId = this.getAttribute('data-tab');
                    document.getElementById(tabId).classList.add('active');
                });
            });
            
            // Profile modal functionality
            const members = document.querySelectorAll('.member');
            const profileCard = document.getElementById('profileCard');
            const backdrop = document.getElementById('backdrop');
            const profileImage = document.getElementById('profileImage');
            const profileName = document.getElementById('profileName');
            const specializationValue = document.querySelector('.specialization-value');
            const consultationValue = document.querySelector('.consultation-value');
            
            members.forEach(member => {
                member.addEventListener('click', function() {
                    // Set profile data
                    profileImage.src = this.getAttribute('data-image');
                    profileName.textContent = this.getAttribute('data-name');
                    specializationValue.textContent = this.getAttribute('data-specialization');
                    consultationValue.textContent = this.getAttribute('data-consultation');
                    
                    // Show modal
                    profileCard.style.display = 'block';
                    backdrop.style.display = 'block';
                    
                    // Add animation classes
                    profileCard.classList.add('show');
                    backdrop.classList.add('show');
                    
                    // Prevent body scrolling
                    document.body.style.overflow = 'hidden';
                });
            });
            
            // Close modal when clicking backdrop
            backdrop.addEventListener('click', closeModal);
            
            // Close modal when clicking the X (added in CSS as ::after)
            document.querySelector('.card-body').addEventListener('click', function(e) {
                // Calculate if the click is on the pseudo-element (close button)
                const rect = this.getBoundingClientRect();
                const isInCloseButtonArea = 
                    e.clientX > rect.right - 40 && 
                    e.clientX < rect.right && 
                    e.clientY > rect.top && 
                    e.clientY < rect.top + 40;
                    
                if (isInCloseButtonArea) {
                    closeModal();
                }
            });
            
            // Close modal function
            function closeModal() {
                profileCard.classList.remove('show');
                backdrop.classList.remove('show');
                
                // Allow slight delay for animation
                setTimeout(() => {
                    profileCard.style.display = 'none';
                    backdrop.style.display = 'none';
                    document.body.style.overflow = '';
                }, 300);
            }
            
            // Close modal with escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && profileCard.style.display === 'block') {
                    closeModal();
                }
            });
        });
    </script>
</section>

    <section id="campusorgs" class="content-section py-4">
    <div class="section-heading text-center mb-5">
        <h1 class="display-5 fw-bold position-relative d-inline-block mb-0">
            <span class="gradient-text">STUDENT ORGANIZATIONS</span>
        </h1>
        <div class="animated-bar mx-auto mt-2 mb-3"></div>
    </div>
    <div class="container-fluid px-4">
        <!-- Row of cards with grid layout -->
        <div class="row-container">
            <?php foreach ($allOrg as $row): ?>
                <div class="org-card-wrapper">
                    <div class="org-card">
                        <!-- Card Header -->
                        <div class="card-image-container">
                            <a href="#" class="d-block" data-bs-toggle="modal" data-bs-target="#newsModal" 
                            data-orgid="<?= htmlspecialchars($row['org_id']) ?>" 
                            data-title="<?= htmlspecialchars($row['org_name']) ?>" 
                            data-image="uploaded/orgUploaded/<?= htmlspecialchars($row['org_image']) ?>" 
                            data-profilephoto="uploaded/orgUploaded/<?= htmlspecialchars($row['org_image']) ?>" 
                            data-author="<?= htmlspecialchars($row['creator_name'] ?? $row['created_by_name'] ?? $row['org_member_name'] ?? 'Unknown Author') ?>">
                                <!-- Normal state (circle) -->
                                <div class="circle-image">
                                    <img src="uploaded/orgUploaded/<?= htmlspecialchars($row['org_image']) ?>" alt="<?= htmlspecialchars($row['org_name']) ?>" class="org-image">
                                </div>
                                
                                <!-- Hover state (box) -->
                                <div class="box-image">
                                    <img src="uploaded/orgUploaded/<?= htmlspecialchars($row['org_image']) ?>" alt="<?= htmlspecialchars($row['org_name']) ?>" class="org-image">
                                    <div class="overlay"></div>
                                </div>
                            </a>
                        </div>

                        <!-- Card Body -->
                        <div class="org-card-body">
                            <h5 class="org-card-title">
                                <?php 
                                    // Split the title into words
                                    $words = explode(' ', $row['org_name']);
                                    $formattedName = '';
                                    $lineLength = 0;

                                    // Loop through words, adding line breaks to avoid long lines
                                    foreach ($words as $word) {
                                        $formattedName .= htmlspecialchars($word) . ' ';
                                        $lineLength += strlen($word) + 1; // Account for the space

                                        // Add a line break if line exceeds a set character limit (e.g., 20 chars)
                                        if ($lineLength >= 20) { 
                                            $formattedName .= "\n";
                                            $lineLength = 0;
                                        }
                                    }

                                    echo nl2br($formattedName); // Display the formatted name with line breaks
                                ?>
                            </h5>
                            <div class="org-indicator d-flex align-items-center">
                                <div class="indicator bg-warning rounded me-2" style="width: 3px; height: 20px;"></div>
                                <small class="text-muted text-xs">Student Organization</small>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<style>
  /* Grid Layout */
.row-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 1.5rem;
    justify-content: center;
    padding: 0 1rem;
}

/* Card Wrapper */
.org-card-wrapper {
    width: 100%;
}

/* Card Styling */
.org-card {
    display: flex;
    flex-direction: column;
    width: 100%;
    height: 100%; 
    border: none;
    border-radius: 0.75rem;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    overflow: hidden;
    text-align: center;
    background-color: white;
}

/* Card Image Container */
.card-image-container {
    position: relative;
    padding: 1rem;
}

/* Circle Image (default) */
.circle-image {
    width: 150px;
    height: 150px;
    margin: 0 auto;
    border-radius: 50%;
    overflow: hidden;
    display: block;
}

.org-card:hover .circle-image {
    display: none;
}

/* Box Image (hover) */
.box-image {
    position: relative;
    width: 80%; /* Reduced from 100% to 80% */
    padding-top: 60%; /* Reduced from 75% to 60% */
    overflow: hidden;
    border-radius: 0.75rem;
    display: none;
    margin: 0 auto; /* Center the smaller box */
}

.org-card:hover .box-image {
    display: block;
}

/* Common image styling - UPDATED FOR PROPER FITTING */
.org-image {
    width: 100%;
    height: 100%;
    object-fit: contain; /* Changed from cover to contain */
}

/* For circle images specifically */
.circle-image .org-image {
    object-fit: contain; /* Ensures the image fits within the circle without cropping */
}

/* For box images on hover */
.box-image .org-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: contain; /* Ensures the image fits within the box without cropping */
}

/* Overlay */
.overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(to top, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0) 50%);
}

/* Card Body */
.org-card-body {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    text-align: center;
}

.org-card-title {
    font-weight: bold;
    margin-bottom: 0.5rem;
    font-size: 1rem;
    word-break: break-word;
    line-height: 1.4;
    color: #333;
}

/* Indicator styling */
.indicator {
    display: inline-block;
    width: 3px;
    height: 20px;
    margin-right: 0.5rem;
}

/* Ensure modal works properly */
.modal {
    z-index: 1050;
}

/* Fix modal backdrop z-index */
.modal-backdrop {
    z-index: 1040;
}

/* Control modal image size - UPDATED FOR PROPER FITTING */
.modal-body img {
    max-width: 100%;
    max-height: 80vh;
    object-fit: contain; /* Ensures image fits without cropping */
    margin: 0 auto;
    display: block;
}

/* Adjust profile image in modal */
.modal .rounded-circle {
    width: 100px !important;
    height: 100px !important;
    object-fit: contain; /* Changed from cover to contain */
    border-radius: 50% !important;
    margin: 0 auto;
    display: block;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .row-container {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
    }
}
</style>
<section id="faqs" class="content-section py-4">
    <div class="section-heading text-center mb-5">
        <h1 class="display-5 fw-bold position-relative d-inline-block mb-0">
            <span class="gradient-text">FREQUENTLY ASKED QUESTIONS</span>
        </h1>
        <div class="animated-bar mx-auto mt-2 mb-3"></div>
    </div>
    <div class="container-fluid mt-4">
        <!-- Full-width FAQ Section -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden mx-auto" style="max-width: 900px;">
            <!-- Search Header -->
            <div class="p-4 text-white" style="background: linear-gradient(to right, #7D0A0A, #C83E3E);">
                <h2 class="fs-4 fw-bold mb-1">How can we help you?</h2>
                <p class="text-sm opacity-80 mb-3">
                    Search our FAQ for answers to commonly asked questions
                </p>
                
                <!-- Search Bar -->
                <div class="position-relative">
                    <input
                        type="text"
                        id="faqSearch" 
                        placeholder="Search FAQs..."
                        class="form-control form-control-lg py-2 ps-5 rounded-pill"
                        style="background-color: white; color: #333;"
                        onkeyup="filterFAQs()"
                    >
                    <i class="fas fa-search position-absolute" style="left: 15px; top: 50%; transform: translateY(-50%); color: #7D0A0A;"></i>
                    <button class="btn position-absolute end-0 top-50 translate-middle-y me-2 rounded-circle text-muted border-0" onclick="clearSearch()" style="display: none;" id="clearSearchBtn">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
            <!-- FAQ Accordion -->
            <div class="p-3" style="max-height: 600px; overflow-y: auto;">
                <div class="accordion" id="faqsAccordion">
                    <?php if (!empty($showfaqs) && is_array($showfaqs)): ?>
                        <?php foreach ($showfaqs as $index => $faq): ?>
                            <div class="accordion-item mb-3 border rounded-lg shadow-sm overflow-hidden">
                                <h2 class="accordion-header">
                                    <button class="accordion-button <?php echo $index === 0 ? '' : 'collapsed'; ?> p-3" 
                                        type="button" 
                                        data-bs-toggle="collapse" 
                                        data-bs-target="#collapse<?php echo $index; ?>" 
                                        aria-expanded="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                                        aria-controls="collapse<?php echo $index; ?>">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3" style="width: 4px; height: 18px; background-color: #E3C47D; border-radius: 2px;"></div>
                                            <span><?php echo htmlspecialchars(strip_tags($faq['faqs_question'])); ?></span>
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapse<?php echo $index; ?>" class="accordion-collapse collapse <?php echo $index === 0 ? 'show' : ''; ?>" data-bs-parent="#faqsAccordion">
                                    <div class="accordion-body p-3" style="background-color: #f9f9f9;">
                                        <div class="ps-4 border-start border-2" style="border-color: #C83E3E;">
                                            <p><?php echo nl2br(htmlspecialchars(strip_tags($faq['faqs_answer']))); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- No FAQs found message -->
                        <div class="text-center py-5">
                            <div class="mx-auto mb-3" style="width: 60px; height: 60px; background-color: #fff8e8; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-question" style="font-size: 24px; color: #7D0A0A;"></i>
                            </div>
                            <h3 class="fs-5 fw-medium mb-2" style="color: #7D0A0A;">No FAQs available</h3>
                            <p class="text-muted">
                                Please check back later for updates.
                            </p>
                        </div>
                    <?php endif; ?>
                    
                    <!-- No Results Message (for search) -->
                    <div id="noResults" class="py-4 text-center" style="display: none;">
                        <div class="mx-auto mb-3" style="width: 60px; height: 60px; background-color: #fff8e8; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-search" style="font-size: 24px; color: #7D0A0A;"></i>
                        </div>
                        <h3 class="fs-5 fw-medium mb-2" style="color: #7D0A0A;">No matching questions found</h3>
                        <p class="text-muted">
                            Try different keywords or browse all FAQs
                        </p>
                        <button 
                            onclick="clearSearch()"
                            class="mt-2 px-4 py-2 text-white rounded-pill" 
                            style="background-color: #7D0A0A; border: none;"
                        >
                            Clear Search
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        /* Custom Scrollbar for FAQ Container */
        .accordion {
            scrollbar-width: thin;
            scrollbar-color: #ccc #f9f9f9;
        }
        
        .accordion::-webkit-scrollbar {
            width: 6px;
        }
        
        .accordion::-webkit-scrollbar-track {
            background: #f9f9f9;
            border-radius: 10px;
        }
        
        .accordion::-webkit-scrollbar-thumb {
            background-color: #ccc;
            border-radius: 10px;
        }
        
        /* Animations and transitions */
        .accordion-item {
            transition: transform 0.2s ease, box-shadow 0.2s ease, opacity 0.2s ease;
        }
        
        .accordion-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1) !important;
        }
        
        /* Button styling */
        .accordion-button:not(.collapsed) {
            background-color: #f8f8f8 !important;
            color: #7D0A0A !important;
            box-shadow: none !important;
        }
        
        .accordion-button:focus {
            box-shadow: none;
            border-color: rgba(125, 10, 10, 0.1);
        }
        
        /* Text color for maroon */
        .text-maroon {
            color: #7D0A0A;
        }
        
        /* Custom button hover effect */
        button.rounded-pill:hover {
            background-color: #C83E3E !important;
            transition: background-color 0.2s ease;
        }
    </style>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Step 1: Check if we should save FAQs to localStorage
            const faqContainer = document.getElementById('faqsAccordion');
            const faqItems = faqContainer?.querySelectorAll('.accordion-item');
            
            // If we have FAQs on the page, save them to localStorage
            if (faqItems && faqItems.length > 0) {
                const faqs = [];
                
                faqItems.forEach((item, index) => {
                    const question = item.querySelector('.accordion-button span')?.textContent.trim() || '';
                    const answer = item.querySelector('.accordion-body p')?.textContent.trim() || '';
                    
                    if (question && answer) {
                        faqs.push({
                            question: question,
                            answer: answer
                        });
                    }
                });
                
                // Save FAQs to localStorage
                if (faqs.length > 0) {
                    localStorage.setItem('faqs', JSON.stringify(faqs));
                    console.log('Saved FAQs:', faqs.length);
                }
            }
            
            // Step 2: Check if we need to restore FAQs
            // If we have no FAQ items but have cached FAQs
            const noFaqMessage = faqContainer?.querySelector('.text-center.py-5');
            
            if (((!faqItems || faqItems.length === 0) || noFaqMessage) && localStorage.getItem('faqs')) {
                try {
                    const faqs = JSON.parse(localStorage.getItem('faqs'));
                    
                    // Clear container
                    if (faqContainer) {
                        faqContainer.innerHTML = '';
                        
                        // Rebuild FAQs
                        faqs.forEach((faq, index) => {
                            faqContainer.innerHTML += `
                                <div class="accordion-item mb-3 border rounded-lg shadow-sm overflow-hidden">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button ${index === 0 ? '' : 'collapsed'} p-3" 
                                            type="button" 
                                            data-bs-toggle="collapse" 
                                            data-bs-target="#collapse${index}" 
                                            aria-expanded="${index === 0 ? 'true' : 'false'}"
                                            aria-controls="collapse${index}">
                                            <div class="d-flex align-items-center">
                                                <div class="me-3" style="width: 4px; height: 18px; background-color: #E3C47D; border-radius: 2px;"></div>
                                                <span>${faq.question}</span>
                                            </div>
                                        </button>
                                    </h2>
                                    <div id="collapse${index}" class="accordion-collapse collapse ${index === 0 ? 'show' : ''}" data-bs-parent="#faqsAccordion">
                                        <div class="accordion-body p-3" style="background-color: #f9f9f9;">
                                            <div class="ps-4 border-start border-2" style="border-color: #C83E3E;">
                                                <p>${faq.answer}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                        
                        console.log('Restored FAQs:', faqs.length);
                    }
                } catch (error) {
                    console.error('Error restoring FAQs:', error);
                }
            }
            
            // Add event listener for search input
            const searchInput = document.getElementById('faqSearch');
            const clearButton = document.getElementById('clearSearchBtn');
            
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    // Show clear button when text is entered
                    if (clearButton) {
                        clearButton.style.display = this.value.length > 0 ? 'block' : 'none';
                    }
                    
                    // Filter FAQs based on search input
                    filterFAQs();
                });
            }
        });
        
        function filterFAQs() {
            const searchTerm = document.getElementById('faqSearch')?.value.toLowerCase() || '';
            const accordionItems = document.querySelectorAll('.accordion-item');
            let foundItems = 0;
            
            accordionItems.forEach(item => {
                const questionText = item.querySelector('.accordion-button span')?.textContent.toLowerCase() || '';
                const answerText = item.querySelector('.accordion-body')?.textContent.toLowerCase() || '';
                
                if (questionText.includes(searchTerm) || answerText.includes(searchTerm)) {
                    item.style.display = 'block';
                    foundItems++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Show or hide the "no results" message
            const noResultsElement = document.getElementById('noResults');
            
            if (noResultsElement) {
                if (foundItems === 0 && searchTerm.length > 0) {
                    noResultsElement.style.display = 'block';
                } else {
                    noResultsElement.style.display = 'none';
                }
            }
        }
        
        function clearSearch() {
            const searchInput = document.getElementById('faqSearch');
            if (searchInput) {
                searchInput.value = '';
                filterFAQs();
                
                const clearButton = document.getElementById('clearSearchBtn');
                if (clearButton) {
                    clearButton.style.display = 'none';
                }
            }
        }
    </script>
</section>
<section id="feed"  class="content-section py-4">
<div class="section-heading text-center mb-5">
        <h1 class="display-5 fw-bold position-relative d-inline-block mb-0">
            <span class="gradient-text">FEEDBACKS</span>
        </h1>
        <div class="animated-bar mx-auto mt-2 mb-3"></div>
    </div>
    <div class="container-fluid px-4">
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <!-- Animated Stats Cards -->
                <div class="row mb-5 g-5">
                    <!-- Organization Feedbacks Card -->
                    <div class="col-md-5">
    <div class="stat-card h-100">
        <div class="stat-card-inner">
            <div class="stat-icon-container">
                <div class="stat-icon">
                    <i class="fas fa-comments"></i>
                </div>
            </div>
            <div class="stat-content">
                <h3>Organization Feedbacks</h3>
                <div class="counter-wrapper">
                    <span id="org-feedback-count" class="counter">
                        <?php 
                            // Direct database query instead of using $obj
                            include_once("path/to/connection.php"); // Adjust path as needed
                            $orgQuery = "SELECT COUNT(*) FROM org_feedback";
                            $orgCount = $connect->query($orgQuery)->fetchColumn() ?? 0;
                            echo $orgCount;
                        ?>
                    </span>
                    <span class="counter-suffix">+</span>
                </div>
                <p class="stat-description">Insights collected from our community</p>
            </div>
            <div class="stat-backdrop"></div>
        </div>
    </div>
</div>

<!-- Office Feedbacks Card -->
<div class="col-md-5">
    <div class="stat-card h-100">
        <div class="stat-card-inner">
            <div class="stat-icon-container alt">
                <div class="stat-icon">
                    <i class="fas fa-building"></i>
                </div>
            </div>
            <div class="stat-content">
                <h3>Office Feedbacks</h3>
                <div class="counter-wrapper">
                    <span id="office-feedback-count" class="counter">
                        <?php 
                            // Direct database query instead of using $obj
                            // No need to include connection.php again if it's already included above
                            $officeQuery = "SELECT COUNT(*) FROM office_feedback";
                            $officeCount = $connect->query($officeQuery)->fetchColumn() ?? 0;
                            echo $officeCount;
                        ?>
                    </span>
                    <span class="counter-suffix">+</span>
                </div>
                <p class="stat-description">Campus service evaluations submitted</p>
            </div>
            <div class="stat-backdrop alt"></div>
        </div>
    </div>
</div>
                
                <!-- Feedback Submission Card -->
                <div class="feedback-card mb-5">
                    <div class="card-decoration-1"></div>
                    <div class="card-decoration-2"></div>
                    
                    <div class="feedback-card-content">
                        <div class="row align-items-center">
                            <div class="col-lg-7">
                                <h2 class="feedback-card-title">Share Your Experience</h2>
                                <p class="feedback-card-text">
                                    Your feedback is invaluable to us. Help us improve our services by sharing your thoughts, suggestions, and experiences.
                                </p>
                                <ul class="feedback-benefits">
                                    <li><i class="fas fa-check-circle"></i> Help improve campus services</li>
                                    <li><i class="fas fa-check-circle"></i> Shape future programs</li>
                                    <li><i class="fas fa-check-circle"></i> Enhance student experience</li>
                                </ul>
                            </div>
                            <div class="col-lg-5 text-lg-end text-center mt-4 mt-lg-0">
                                <button class="submit-feedback-btn" data-bs-toggle="modal" data-bs-target="#feedbackModal">
                                    <span class="btn-text">Submit Feedback</span>
                                    <span class="btn-icon"><i class="fas fa-paper-plane"></i></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        /* Premium Design Styles */
        
        /* Typography & General */
        #feed {
            font-family: 'Poppins', 'Segoe UI', 'Arial', sans-serif;
            background: linear-gradient(to bottom, #f8f9fa, #ffffff);
            position: relative;
            overflow: hidden;
        }
        
        /* Animated Section Header */
        .gradient-text {
            background: linear-gradient(135deg, #7D0A0A, #C83E3E);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            letter-spacing: 1px;
        }
        
        .animated-bar {
            height: 4px;
            width: 380px;
            background: linear-gradient(to right, #E3C47D, #7D0A0A);
            border-radius: 2px;
            position: relative;
            overflow: hidden;
        }
        
        .animated-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            animation: shine 2s infinite;
        }
        
        @keyframes shine {
            100% {
                left: 100%;
            }
        }
        
        /* Stats Cards */
        .stat-card {
            perspective: 1000px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            background: white;
            transform-style: preserve-3d;
            transition: all 0.5s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
        
        .stat-card-inner {
            padding: 2.5rem 2rem;
            position: relative;
            height: 100%;
            z-index: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        
        .stat-backdrop {
            position: absolute;
            top: 0;
            right: 0;
            width: 60%;
            height: 100%;
            background: linear-gradient(135deg, transparent, rgba(125, 10, 10, 0.05));
            z-index: -1;
            clip-path: polygon(100% 0, 0% 100%, 100% 100%);
            transition: all 0.3s ease;
        }
        
        .stat-backdrop.alt {
            background: linear-gradient(135deg, transparent, rgba(227, 196, 125, 0.15));
        }
        
        .stat-card:hover .stat-backdrop {
            width: 70%;
        }
        
        .stat-icon-container {
            width: 70px;
            height: 70px;
            position: relative;
            margin-bottom: 1.5rem;
            border-radius: 16px;
            background-color: rgba(125, 10, 10, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 25px rgba(125, 10, 10, 0.15);
        }
        
        .stat-icon-container.alt {
            background-color: rgba(227, 196, 125, 0.2);
            box-shadow: 0 8px 25px rgba(227, 196, 125, 0.25);
        }
        
        .stat-icon {
            color: #7D0A0A;
            font-size: 1.75rem;
            transition: transform 0.3s ease;
        }
        
        .stat-icon-container.alt .stat-icon {
            color: #E3C47D;
        }
        
        .stat-card:hover .stat-icon {
            transform: scale(1.1);
        }
        
        .stat-content h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #343a40;
            margin-bottom: 1rem;
        }
        
        .counter-wrapper {
            display: flex;
            align-items: baseline;
        }
        
        .counter {
            font-size: 2.75rem;
            font-weight: 700;
            color: #7D0A0A;
            line-height: 1;
        }
        
        .stat-icon-container.alt + .stat-content .counter {
            color: #E3C47D;
        }
        
        .counter-suffix {
            font-size: 1.5rem;
            font-weight: 600;
            color: #7D0A0A;
            margin-left: 4px;
        }
        
        .stat-icon-container.alt + .stat-content .counter-suffix {
            color: #E3C47D;
        }
        
        .stat-description {
            font-size: 0.9rem;
            color: #6c757d;
            margin-top: 0.75rem;
        }
        
        /* Feedback Submission Card */
        .feedback-card {
            position: relative;
            border-radius: 16px;
            background: white;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .feedback-card:hover {
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.12);
        }
        
        .card-decoration-1 {
            position: absolute;
            height: 200px;
            width: 200px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(125, 10, 10, 0.1), rgba(125, 10, 10, 0.05));
            top: -100px;
            left: -100px;
            z-index: 0;
        }
        
        .card-decoration-2 {
            position: absolute;
            height: 150px;
            width: 150px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(227, 196, 125, 0.15), rgba(227, 196, 125, 0.05));
            bottom: -50px;
            right: -50px;
            z-index: 0;
        }
        
        .feedback-card-content {
            position: relative;
            z-index: 1;
            padding: 2.5rem;
        }
        
        .feedback-card-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #343a40;
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }
        
        .feedback-card-title::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 40px;
            height: 3px;
            background: linear-gradient(to right, #7D0A0A, #C83E3E);
            border-radius: 3px;
        }
        
        .feedback-card-text {
            color: #6c757d;
            font-size: 1.05rem;
            margin-bottom: 1.5rem;
            max-width: 600px;
        }
        
        .feedback-benefits {
            list-style: none;
            padding: 0;
            margin: 0 0 1.5rem 0;
        }
        
        .feedback-benefits li {
            color: #495057;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }
        
        .feedback-benefits li i {
            color: #7D0A0A;
            margin-right: 10px;
            font-size: 0.9rem;
        }
        
        .submit-feedback-btn {
            padding: 0.85rem 2rem;
            border-radius: 50px;
            background: linear-gradient(135deg, #7D0A0A, #C83E3E);
            color: white;
            font-weight: 600;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(125, 10, 10, 0.15);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        
        .submit-feedback-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #C83E3E, #7D0A0A);
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .submit-feedback-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(125, 10, 10, 0.2);
        }
        
        .submit-feedback-btn:hover::before {
            opacity: 1;
        }
        
        .btn-icon {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            transition: all 0.3s ease;
        }
        
        .submit-feedback-btn:hover .btn-icon {
            transform: rotate(15deg);
        }
        
        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .submit-feedback-btn {
                margin-top: 1rem;
            }
        }
        
        @media (max-width: 768px) {
            .stat-card-inner {
                padding: 2rem 1.5rem;
            }
            
            .feedback-card-content {
                padding: 2rem 1.5rem;
            }
            
            .counter {
                font-size: 2.25rem;
            }
        }
    </style>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Counter Animation
            function animateCounter(element, target, duration = 2000) {
                // Parse the target value (initial HTML content)
                target = parseInt(element.textContent.trim()) || 0;
                
                let start = 0;
                const increment = target / (duration / 16);
                const timer = setInterval(() => {
                    start += increment;
                    element.textContent = Math.floor(Math.min(start, target));
                    
                    if (start >= target) clearInterval(timer);
                }, 16);
            }
            
            // Initialize counters with real data
            const orgFeedbackCount = document.getElementById('org-feedback-count');
            const officeFeedbackCount = document.getElementById('office-feedback-count');
            
            // Start animations when elements are in viewport
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        if (entry.target.id === 'org-feedback-count') {
                            animateCounter(orgFeedbackCount);
                        } else if (entry.target.id === 'office-feedback-count') {
                            animateCounter(officeFeedbackCount);
                        }
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });
            
            if (orgFeedbackCount) observer.observe(orgFeedbackCount);
            if (officeFeedbackCount) observer.observe(officeFeedbackCount);
        });
    </script>
</section>
<section id="aboutus" class="content-section py-4">
    <div class="section-heading text-center mb-5">
        <h1 class="display-5 fw-bold position-relative d-inline-block mb-0">
            <span class="gradient-text">ABOUT US</span>
        </h1>
        <div class="animated-bar mx-auto mt-2 mb-3"></div>
    </div>
    
    <div class="container-fluid px-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- University Info Card -->
                <div class="about-card mb-5">
                    <div class="card-decoration-1"></div>
                    <div class="card-decoration-2"></div>
                    
                    <div class="about-card-content">
                        <div class="row align-items-center">
                            <div class="col-lg-5 mb-4 mb-lg-0">
                                <div class="campus-image-wrapper">
                                    <img src="img/C2SVTseUoAEJp42.jpg" alt="TSU San Isidro Campus Building" class="campus-image">
                                    <div class="image-overlay"></div>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="about-subtitle">Tarlac State University - San Isidro Campus</div>
                                <p class="about-description">
                                    Tarlac State University stands as a premier institution of higher learning in San Isidro, Tarlac. Our commitment to academic excellence, innovative research, and meaningful community service has established us as a leading educational institution in Central Luzon. We take pride in developing well-rounded graduates who are equipped to make significant contributions to society and drive positive change in their communities.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Strategic Directions Cards -->
                <div class="row mb-5 g-4">
                    <!-- Vision Card -->
                    <div class="col-md-4">
                        <div class="strategy-card h-100">
                            <div class="strategy-card-inner">
                                <div class="strategy-icon-container">
                                    <div class="strategy-icon">
                                        <i class="fas fa-eye"></i>
                                    </div>
                                </div>
                                <div class="strategy-content">
                                    <h3>Our Vision</h3>
                                    <p class="strategy-description">
                                        A globally competitive university recognized for excellence in sciences and emerging technologies.
                                    </p>
                                </div>
                                <div class="strategy-backdrop"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Mission Card -->
                    <div class="col-md-4">
                        <div class="strategy-card h-100">
                            <div class="strategy-card-inner">
                                <div class="strategy-icon-container alt">
                                    <div class="strategy-icon">
                                        <i class="fas fa-flag"></i>
                                    </div>
                                </div>
                                <div class="strategy-content">
                                    <h3>Our Mission</h3>
                                    <p class="strategy-description">
                                        TSU shall develop highly competitive and empowered human resources fostering responsive global education, future-proof research culture, inclusive and relevant extension programs, and sustainable production projects.
                                    </p>
                                </div>
                                <div class="strategy-backdrop alt"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Values Card -->
                    <div class="col-md-4">
                        <div class="strategy-card h-100">
                            <div class="strategy-card-inner">
                                <div class="strategy-icon-container values">
                                    <div class="strategy-icon">
                                        <i class="fas fa-heart"></i>
                                    </div>
                                </div>
                                <div class="strategy-content">
                                    <h3>Our Core Values</h3>
                                    <ul class="values-list">
                                        <li><span>Truth</span> in words, action and character</li>
                                        <li><span>Service</span> with excellence and compassion</li>
                                        <li><span>Unity</span> in diversity</li>
                                    </ul>
                                </div>
                                <div class="strategy-backdrop values"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Leadership Section with Single Row -->
                <div class="leadership-section mb-5">
                    <h2 class="leadership-heading">University Leadership</h2>
                    <div class="animated-bar mx-auto mt-2 mb-4"></div>
                    
                    <div class="leadership-row">
                        <div class="leader-card">
                            <div class="leader-image-container">
                                <img src="img/press.jpg" alt="TSU President" class="leader-image">
                                <div class="leader-overlay"></div>
                            </div>
                            <div class="leader-info">
                                <h4 class="leader-name">Dr. Arnold E. Velasco</h4>
                                <p class="leader-title">University President</p>
                            </div>
                        </div>
                        
                        <div class="leader-card">
                            <div class="leader-image-container">
                                <img src="img/v.press.jpg" alt="TSU Vice President" class="leader-image">
                                <div class="leader-overlay"></div>
                            </div>
                            <div class="leader-info">
                                <h4 class="leader-name">Dr. Grace N. David</h4>
                                <p class="leader-title">VP for Academic Affairs</p>
                            </div>
                        </div>
                        
                        <div class="leader-card">
                            <div class="leader-image-container">
                                <img src="img/vp.Ad.jpg" alt="VP for Administration" class="leader-image">
                                <div class="leader-overlay"></div>
                            </div>
                            <div class="leader-info">
                                <h4 class="leader-name">Atty. Wilmark J. Ramos</h4>
                                <p class="leader-title">VP for Administration</p>
                            </div>
                        </div>
                        
                        <div class="leader-card">
                            <div class="leader-image-container">
                                <img src="img/vp.res.jpg" alt="VP for Research & Extension" class="leader-image">
                                <div class="leader-overlay"></div>
                            </div>
                            <div class="leader-info">
                                <h4 class="leader-name">Dr. Erwin P. Lacanlale</h4>
                                <p class="leader-title">VP for Research & Extension</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        /* Typography & General */
        #aboutus {
            font-family: 'Poppins', 'Segoe UI', 'Arial', sans-serif;
            background: linear-gradient(to bottom, #f8f9fa, #ffffff);
            position: relative;
            overflow: hidden;
            padding-bottom: 3rem;
        }
        
        /* Animated Section Header */
        .gradient-text {
            background: linear-gradient(135deg, #7D0A0A, #C83E3E);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            letter-spacing: 1px;
        }
        
        .animated-bar {
            height: 4px;
            width: 80px;
            background: linear-gradient(to right, #7D0A0A, #E3C47D);
            border-radius: 2px;
            position: relative;
        }
        
        @keyframes shine {
            100% {
                left: 100%;
            }
        }
        
        /* About Card */
        .about-card {
            position: relative;
            border-radius: 16px;
            background: white;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .about-card:hover {
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.12);
        }
        
        .card-decoration-1 {
            position: absolute;
            height: 200px;
            width: 200px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(125, 10, 10, 0.1), rgba(125, 10, 10, 0.05));
            top: -100px;
            left: -100px;
            z-index: 0;
        }
        
        .card-decoration-2 {
            position: absolute;
            height: 150px;
            width: 150px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(227, 196, 125, 0.15), rgba(227, 196, 125, 0.05));
            bottom: -50px;
            right: -50px;
            z-index: 0;
        }
        
        .about-card-content {
            position: relative;
            z-index: 1;
            padding: 2.5rem;
        }
        
        .campus-image-wrapper {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
        
        .campus-image {
            width: 100%;
            height: auto;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to top, rgba(125, 10, 10, 0.4), transparent);
            opacity: 0.7;
            transition: opacity 0.3s ease;
        }
        
        .campus-image-wrapper:hover .campus-image {
            transform: scale(1.05);
        }
        
        .campus-image-wrapper:hover .image-overlay {
            opacity: 0.3;
        }
        
        .about-subtitle {
            font-size: 1.4rem;
            font-weight: 700;
            color: #7D0A0A;
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }
        
        .about-subtitle::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 40px;
            height: 3px;
            background: linear-gradient(to right, #7D0A0A, #E3C47D);
            border-radius: 3px;
        }
        
        .about-description {
            color: #6c757d;
            font-size: 1.05rem;
            line-height: 1.7;
        }
        
        /* Strategy Cards */
        .strategy-card {
            perspective: 1000px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            background: white;
            transform-style: preserve-3d;
            transition: all 0.5s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .strategy-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
        
        .strategy-card-inner {
            padding: 2.5rem 2rem;
            position: relative;
            height: 100%;
            z-index: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        
        .strategy-backdrop {
            position: absolute;
            top: 0;
            right: 0;
            width: 60%;
            height: 100%;
            background: linear-gradient(135deg, transparent, rgba(125, 10, 10, 0.05));
            z-index: -1;
            clip-path: polygon(100% 0, 0% 100%, 100% 100%);
            transition: all 0.3s ease;
        }
        
        .strategy-backdrop.alt {
            background: linear-gradient(135deg, transparent, rgba(227, 196, 125, 0.15));
        }
        
        .strategy-backdrop.values {
            background: linear-gradient(135deg, transparent, rgba(0, 128, 128, 0.08));
        }
        
        .strategy-card:hover .strategy-backdrop {
            width: 70%;
        }
        
        .strategy-icon-container {
            width: 70px;
            height: 70px;
            position: relative;
            margin-bottom: 1.5rem;
            border-radius: 16px;
            background-color: rgba(125, 10, 10, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 25px rgba(125, 10, 10, 0.15);
        }
        
        .strategy-icon-container.alt {
            background-color: rgba(227, 196, 125, 0.2);
            box-shadow: 0 8px 25px rgba(227, 196, 125, 0.25);
        }
        
        .strategy-icon-container.values {
            background-color: rgba(0, 128, 128, 0.1);
            box-shadow: 0 8px 25px rgba(0, 128, 128, 0.2);
        }
        
        .strategy-icon {
            color: #7D0A0A;
            font-size: 1.75rem;
            transition: transform 0.3s ease;
        }
        
        .strategy-icon-container.alt .strategy-icon {
            color: #E3C47D;
        }
        
        .strategy-icon-container.values .strategy-icon {
            color: #008080;
        }
        
        .strategy-card:hover .strategy-icon {
            transform: scale(1.1);
        }
        
        .strategy-content {
            flex: 1 1 auto;
        }
        
        .strategy-content h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #343a40;
            margin-bottom: 1rem;
        }
        
        .strategy-description {
            color: #6c757d;
            font-size: 0.95rem;
            line-height: 1.6;
        }
        
        .values-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .values-list li {
            margin-bottom: 0.75rem;
            color: #6c757d;
            font-size: 0.95rem;
            padding-left: 1.25rem;
            position: relative;
        }
        
        .values-list li:before {
            content: "•";
            color: #008080;
            font-weight: bold;
            position: absolute;
            left: 0;
        }
        
        .values-list li span {
            font-weight: 700;
            color: #008080;
        }
        
        /* Leadership Section in a Single Row */
        .leadership-section {
            padding: 2rem 0;
            margin-top: 1rem;
        }
        
        .leadership-heading {
            text-align: center;
            font-size: 1.75rem;
            font-weight: 700;
            color: #343a40;
            margin-bottom: 1rem;
        }
        
        .leadership-row {
            display: flex;
            flex-wrap: nowrap; /* No wrapping */
            justify-content: space-between; /* Equal spacing */
            align-items: flex-start;
            gap: 15px;
            width: 100%;
        }
        
        .leader-card {
            flex: 1; /* Equal width */
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            text-align: center; /* Center all content */
        }
        
        .leader-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .leader-image-container {
            position: relative;
            overflow: hidden;
            padding-top: 100%; /* Maintain aspect ratio (1:1) */
        }
        
        .leader-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .leader-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to top, rgba(125, 10, 10, 0.4), transparent);
            opacity: 0.7;
            transition: opacity 0.3s ease;
        }
        
        .leader-card:hover .leader-image {
            transform: scale(1.05);
        }
        
        .leader-card:hover .leader-overlay {
            opacity: 0.5;
        }
        
        .leader-info {
            padding: 1rem;
            text-align: center !important;
            background-color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }
        
        .leader-name {
            margin: 0 0 0.25rem;
            font-size: 0.95rem;
            font-weight: 600;
            color: #343a40;
            text-align: center !important;
            width: 100%;
            display: block;
        }
        
        .leader-title {
            margin: 0;
            font-size: 0.8rem;
            color: #7D0A0A;
            text-align: center !important;
            width: 100%;
            display: block;
        }
        
        /* Direct fix for title alignment */
        .vp-title,
        .university-president {
            text-align: center !important;
            width: 100% !important;
            display: block !important;
            margin: 0 auto !important;
        }
        
        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .about-card-content {
                padding: 1.5rem;
            }
            
            .strategy-card-inner {
                padding: 1.5rem;
            }
            
            .leadership-row {
                gap: 10px;
            }
        }
        
        @media (max-width: 768px) {
            .about-subtitle {
                font-size: 1.25rem;
            }
            
            .leader-name {
                font-size: 0.85rem;
            }
            
            .leader-title {
                font-size: 0.75rem;
            }
            
            .leader-info {
                padding: 0.75rem;
            }
        }
        
        @media (max-width: 576px) {
            .leadership-row {
                gap: 8px;
            }
            
            .leader-info {
                padding: 0.5rem;
            }
            
            .leader-name {
                font-size: 0.75rem;
            }
            
            .leader-title {
                font-size: 0.7rem;
            }
        }
    </style>
</section>

</div>
<!-- Modal -->
 
<div class="modal fade" id="newsModal" tabindex="-1" aria-labelledby="newsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content rounded-lg border-0 shadow">
            <!-- Modal Header -->
            <div class="modal-header bg-white border-0 py-3 sticky-top">
                <div class="d-flex align-items-center w-100">
                    <div class="d-flex align-items-center">
                        <button type="button" class="btn-close me-3" data-bs-dismiss="modal" aria-label="Close"></button>
                        <h5 class="modal-title mb-0 fw-bold" id="newsModalLabel" style="color:white;">Organization Feed</h5>
                    </div>
                    <div class="ms-auto"> 
  <div class="input-group"> 
    <input type="text" class="form-control rounded-pill bg-white border-0" id="announcementSearch" placeholder="Search in this organization..."> 
    <button class="btn btn-sm rounded-pill ms-2 border-0 bg-transparent" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false"> 
      <i class="fas fa-filter"></i> 
    </button> 
    <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="filterDropdown"> 
      <li><h6 class="dropdown-header">Date</h6></li> 
      <li><a class="dropdown-item date-filter" href="#" data-value="">Any Date</a></li> 
      <li><a class="dropdown-item date-filter" href="#" data-value="today">Today</a></li> 
      <li><a class="dropdown-item date-filter" href="#" data-value="week">This Week</a></li> 
      <li><a class="dropdown-item date-filter" href="#" data-value="month">This Month</a></li> 
      <li><hr class="dropdown-divider"></li> 
      <li><h6 class="dropdown-header">Category</h6></li> 
      <li><a class="dropdown-item category-filter" href="#" data-value="all">All Categories</a></li> 
      <li><a class="dropdown-item category-filter" href="#" data-value="announcement">Announcements</a></li> 
      <li><a class="dropdown-item category-filter" href="#" data-value="event">Events</a></li> 
      <li><a class="dropdown-item category-filter" href="#" data-value="news">News</a></li> 
      <li><hr class="dropdown-divider"></li> 
      <li><a class="dropdown-item" href="#" id="clearFilters"> 
        <i class="fas fa-times me-1"></i> Clear All Filters 
      </a></li> 
    </ul> 
  </div> 
  <input type="hidden" id="dateFilter" value=""> 
  <input type="hidden" id="categoryFilter" value="all"> 
</div>
                </div>

                
            </div>

            <!-- Modal Body with Scrollable Content -->
            <div class="modal-body p-0" style="max-height: 80vh; overflow-y: auto;">
                <!-- Organization Cover & Profile -->
                <div class="position-relative">
                    <div class="org-cover-photo position-relative">
                        <img src="img/C2SVTseUoAEJp42.jpg" id="orgCoverPhoto" class="w-100 object-fit-cover" style="height: 200px;" alt="Organization Cover">
                    </div>
                    
                    <!-- Profile layout with profile pic on far left -->
                    <div class="position-relative" style="margin-top: 20px;">
                        <!-- Profile section with picture on far left -->
                        <div class="d-flex align-items-center">
                            <!-- Profile Picture on far left -->
                            <div class="profile-picture rounded-circle border-4 border-white bg-white shadow-sm" style="width: 120px; height: 120px; overflow: hidden; position: relative; margin-left: 20px; margin-right: 15px; margin-top: -30px;">
                                <img src="/api/placeholder/400/400" id="orgProfilePhoto" class="w-100 h-100 object-fit-cover" alt="Organization Profile">
                            </div>
                            
                            <!-- Organization Info positioned to the right of profile pic -->
                            <div style="margin-left: 10px;">
                                <h3 class="fw-bold mb-1 text-dark" id="orgName" style="font-size: 1.8rem;">The Browser</h3>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-light text-danger me-2 rounded-pill px-2 py-1" style="font-size: 0.8rem;">Verified</span>
                                    <span class="text-muted" style="font-size: 0.9rem;">Student Organization</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Tabs -->
                <div class="px-4 border-bottom bg-white" style="margin-top: 15px;">
                    <ul class="nav nav-tabs border-0 flex-nowrap ">
                        <li class="nav-item">
                            <button class="nav-link active px-4 py-3 fw-semibold border-0 rounded-0 position-relative text-danger" id="announcements-tab" data-bs-toggle="tab" data-bs-target="#announcements">
                                Announcements
                                <span class="position-absolute bottom-0 start-0 end-0 bg-danger" style="height: 3px; border-radius: 3px 3px 0 0;"></span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link px-4 py-3 fw-semibold border-0 rounded-0 position-relative" id="members-tab" data-bs-toggle="tab" data-bs-target="#members">
                                Members
                                <span class="position-absolute bottom-0 start-0 end-0 bg-danger" style="height: 3px; border-radius: 3px 3px 0 0;"></span>
                            </button>
                        </li>
                    </ul>
                </div>
   <!-- Tab Content -->
   <div class="tab-content bg-light">
                    <!-- Announcements Tab -->
                    <div class="tab-pane fade show active p-4" id="announcements">
                        <div id="announcements-content" class="announcements-container">
                            <!-- Announcement Card 1 -->
                            <div class="card mb-3 border-0 shadow-sm hover-shadow transition">
                                <div class="card-body p-4">
                                    <div class="d-flex mb-3">
                                        <img src="/api/placeholder/50/50" class="rounded-circle me-3" style="width: 50px; height: 50px;" alt="Admin">
                                        <div>
                                            <h6 class="mb-0 fw-bold">Admin Name</h6>
                                            <p class="text-muted mb-0"><small>Posted on March 12, 2025</small></p>
                                        </div>
                                    </div>
                                    <h5 class="card-title fw-bold text-primary">Spring Festival Registration Open!</h5>
                                    <p class="card-text">Join us for our annual Spring Festival! This year's theme is "Bloom & Grow" featuring live music, food trucks, and interactive art installations. Register by March 20th to secure your spot.</p>
                                    <div class="mt-3 pt-3 border-top">
                                        <a href="#" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                            <i class="far fa-calendar-alt me-1"></i> RSVP
                                        </a>
                                        <a href="#" class="btn btn-sm btn-light rounded-pill ms-2 px-3">
                                            <i class="far fa-comment me-1"></i> Comment
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Announcement Card 2 -->
                            <div class="card mb-3 border-0 shadow-sm hover-shadow transition">
                                <div class="card-body p-4">
                                    <div class="d-flex mb-3">
                                        <img src="/api/placeholder/50/50" class="rounded-circle me-3" style="width: 50px; height: 50px;" alt="Admin">
                                        <div>
                                            <h6 class="mb-0 fw-bold">Admin Name</h6>
                                            <p class="text-muted mb-0"><small>Posted on March 10, 2025</small></p>
                                        </div>
                                    </div>
                                    <h5 class="card-title fw-bold text-primary">New Member Applications</h5>
                                    <p class="card-text">We're now accepting applications for new members! If you're passionate about our mission and want to be part of our community, submit your application by March 25th.</p>
                                    <div class="mt-3 pt-3 border-top">
                                        <a href="#" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                            <i class="fas fa-file-alt me-1"></i> Apply Now
                                        </a>
                                        <a href="#" class="btn btn-sm btn-light rounded-pill ms-2 px-3">
                                            <i class="far fa-comment me-1"></i> Comment
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Announcement Card 3 -->
                            <div class="card mb-3 border-0 shadow-sm hover-shadow transition">
                                <div class="card-body p-4">
                                    <div class="d-flex mb-3">
                                        <img src="/api/placeholder/50/50" class="rounded-circle me-3" style="width: 50px; height: 50px;" alt="Admin">
                                        <div>
                                            <h6 class="mb-0 fw-bold">Admin Name</h6>
                                            <p class="text-muted mb-0"><small>Posted on March 8, 2025</small></p>
                                        </div>
                                    </div>
                                    <h5 class="card-title fw-bold text-primary">Upcoming Workshop Series</h5>
                                    <p class="card-text">Our professional development workshop series begins next week! Topics include leadership skills, networking strategies, and industry insights from guest speakers.</p>
                                    <div class="mt-3 pt-3 border-top">
                                        <a href="#" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                            <i class="far fa-calendar-check me-1"></i> Register
                                        </a>
                                        <a href="#" class="btn btn-sm btn-light rounded-pill ms-2 px-3">
                                            <i class="far fa-comment me-1"></i> Comment
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Members Tab -->
                    <div class="tab-pane fade p-4" id="members">
                        <div class="row g-4">
                            <!-- Leadership Section -->
                            <div class="col-12 mb-2">
                                <h5 class="text-primary fw-bold mb-3">Leadership</h5>
                            </div>
                            
                            <!-- Member Card - President -->
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="card h-100 border-0 shadow-sm hover-shadow transition">
                                    <div class="card-body p-4 d-flex align-items-center">
                                        <img src="/api/placeholder/80/80" class="rounded-circle me-3 border border-3 border-primary p-1" style="width: 80px; height: 80px;" alt="President">
                                        <div>
                                            <h5 class="mb-1 fw-bold">Alex Johnson</h5>
                                            <p class="mb-1 text-primary fw-semibold"><small>President</small></p>
                                            <p class="mb-2 text-muted"><small>Since September 2024</small></p>
                                            <div class="d-flex">
                                                <a href="#" class="btn btn-sm btn-light rounded-circle me-1"><i class="fab fa-linkedin"></i></a>
                                                <a href="#" class="btn btn-sm btn-light rounded-circle"><i class="fas fa-envelope"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Member Card - Vice President -->
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="card h-100 border-0 shadow-sm hover-shadow transition">
                                    <div class="card-body p-4 d-flex align-items-center">
                                        <img src="/api/placeholder/80/80" class="rounded-circle me-3 border border-3 border-primary p-1" style="width: 80px; height: 80px;" alt="Vice President">
                                        <div>
                                            <h5 class="mb-1 fw-bold">Taylor Martinez</h5>
                                            <p class="mb-1 text-primary fw-semibold"><small>Vice President</small></p>
                                            <p class="mb-2 text-muted"><small>Since January 2025</small></p>
                                            <div class="d-flex">
                                                <a href="#" class="btn btn-sm btn-light rounded-circle me-1"><i class="fab fa-linkedin"></i></a>
                                                <a href="#" class="btn btn-sm btn-light rounded-circle"><i class="fas fa-envelope"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Member Card - Secretary -->
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="card h-100 border-0 shadow-sm hover-shadow transition">
                                    <div class="card-body p-4 d-flex align-items-center">
                                        <img src="/api/placeholder/80/80" class="rounded-circle me-3 border border-3 border-primary p-1" style="width: 80px; height: 80px;" alt="Secretary">
                                        <div>
                                            <h5 class="mb-1 fw-bold">Jordan Lee</h5>
                                            <p class="mb-1 text-primary fw-semibold"><small>Secretary</small></p>
                                            <p class="mb-2 text-muted"><small>Since October 2024</small></p>
                                            <div class="d-flex">
                                                <a href="#" class="btn btn-sm btn-light rounded-circle me-1"><i class="fab fa-linkedin"></i></a>
                                                <a href="#" class="btn btn-sm btn-light rounded-circle"><i class="fas fa-envelope"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- General Members Section -->
                            <div class="col-12 mt-4 mb-2">
                                <h5 class="text-primary fw-bold mb-3">General Members</h5>
                            </div>
                            
                            <!-- General Member Cards -->
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="card h-100 border-0 shadow-sm hover-shadow transition">
                                    <div class="card-body p-4 d-flex align-items-center">
                                        <img src="/api/placeholder/80/80" class="rounded-circle me-3" style="width: 80px; height: 80px;" alt="Member">
                                        <div>
                                            <h5 class="mb-1 fw-bold">Casey Morgan</h5>
                                            <p class="mb-1 text-muted"><small>Events Committee</small></p>
                                            <p class="mb-2 text-muted"><small>Since November 2024</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="card h-100 border-0 shadow-sm hover-shadow transition">
                                    <div class="card-body p-4 d-flex align-items-center">
                                        <img src="/api/placeholder/80/80" class="rounded-circle me-3" style="width: 80px; height: 80px;" alt="Member">
                                        <div>
                                            <h5 class="mb-1 fw-bold">Morgan Silva</h5>
                                            <p class="mb-1 text-muted"><small>Marketing Team</small></p>
                                            <p class="mb-2 text-muted"><small>Since December 2024</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="card h-100 border-0 shadow-sm hover-shadow transition">
                                    <div class="card-body p-4 d-flex align-items-center">
                                        <img src="/api/placeholder/80/80" class="rounded-circle me-3" style="width: 80px; height: 80px;" alt="Member">
                                        <div>
                                            <h5 class="mb-1 fw-bold">Jamie Williams</h5>
                                            <p class="mb-1 text-muted"><small>Outreach Coordinator</small></p>
                                            <p class="mb-2 text-muted"><small>Since February 2025</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Enhanced customizations */
:root {
    --maroon-dark: #7A0D0D;
    --maroon: #C33232;
    --primary: #C33232;
    --primary-dark: #7A0D0D;
    --gold: #E9CF8B;
    --light-gray: #EEEEEE;
}

.text-danger {
    color: var(--primary) !important;
}

.bg-danger {
    background-color: var(--primary) !important;
}

.text-primary {
    color: var(--primary) !important;
}

.bg-primary {
    background-color: var(--primary) !important;
}

.btn-primary {
    background-color: var(--primary);
    border-color: var(--primary);
}

.btn-primary:hover {
    background-color: var(--primary-dark);
    border-color: var(--primary-dark);
}

.btn-outline-primary {
    color: var(--primary);
    border-color: var(--primary);
}

.btn-outline-primary:hover {
    background-color: var(--primary);
    border-color: var(--primary);
    color: white;
}

.nav-tabs .nav-link {
    color: #65676B;
    font-weight: 600;
    transition: all 0.2s;
}

.nav-tabs .nav-link.active {
    color: var(--primary);
}

.nav-tabs .nav-link span {
    opacity: 0;
}

.nav-tabs .nav-link.active span {
    opacity: 1;
}

.modal-content {
    border-radius: 12px;
}

.rounded-circle {
    object-fit: cover;
}

.card {
    border-radius: 10px;
    transition: all 0.3s ease;
}

.hover-shadow:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
}

.transition {
    transition: all 0.3s ease;
}

.rounded-pill {
    border-radius: 50px !important;
}

.modal-body::-webkit-scrollbar {
    width: 8px;
}

.modal-body::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.modal-body::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 4px;
}

.modal-body::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>
<div id="backdrop" class="backdrop"></div>
    <div id="profileCard" class="card">
        <div class="card-body">
            <img id="profileImage" src="" alt="Profile Picture" class="rounded-circle">
            <h5 id="profileName">Name</h5>
            <p class="text-muted" id="profileSpecialization">Specialization: <span class="specialization-value"></span></p>
            <p class="text-muted" id="profileConsultationTime">Consultation Time: <span class="consultation-value"></span></p>
        </div>
    </div>
    <style>
        /* Progress Steps */
        .progress-steps {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 3rem;
            padding: 1.5rem;
            position: relative;
        }

        .progress-steps::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 15%;
            right: 15%;
            height: 2px;
            background: #e9ecef;
            z-index: 1;
        }

        .step-indicator {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #fff;
            border: 2px solid #dee2e6;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            font-weight: 500;
            position: relative;
            z-index: 2;
            transition: all 0.3s ease;
        }

        .step-indicator.active {
            background: #0d6efd;
            border-color: #0d6efd;
            color: #fff;
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.2);
        }

        /* Steps Content */
        .step {
            display: none;
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.3s ease;
        }

        .step.active {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        /* Feedback Category Cards */
        .feedback-category-card {
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 1.25rem;
            background: #fff;
            position: relative;
            overflow: hidden;
        }

        .feedback-category-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .feedback-category-card.selected {
            border-color: #0d6efd;
            background: #f8f9ff;
        }

        .feedback-category-card.selected::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            border-style: solid;
            border-width: 0 2rem 2rem 0;
            border-color: transparent #0d6efd transparent transparent;
        }

        /* Rating Groups */
        .rating-group {
            display: flex;
            justify-content: space-between;
            padding: 1.25rem;
            background: #fff;
            border-radius: 8px;
            margin: 0.75rem 0;
            border: 1px solid #e9ecef;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.03);
        }

        .rating-option {
            text-align: center;
            position: relative;
        }

        .rating-option input[type="radio"] {
            display: none;
        }

        .rating-option label {
            display: block;
            padding: 0.625rem 1.25rem;
            cursor: pointer;
            border-radius: 6px;
            transition: all 0.2s ease;
            font-size: 0.875rem;
            color: #495057;
            border: 1px solid transparent;
        }

        .rating-option input[type="radio"]:checked + label {
            background-color: #0d6efd;
            color: white;
            box-shadow: 0 2px 4px rgba(13, 110, 253, 0.2);
        }

        .rating-option:hover label {
            background-color: #f8f9fa;
        }

        /* Question Blocks */
        .question-block {
            margin-bottom: 2.5rem;
            padding: 1.5rem;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border: 1px solid #e9ecef;
            transition: box-shadow 0.3s ease;
        }

        .question-block:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        /* Modal Styles */
        .modal-body {
            max-height: 75vh;
            overflow-y: auto;
            padding: 1.5rem;
            scrollbar-width: thin;
            scrollbar-color: #cbd5e0 #f8f9fa;
        }

        .modal-body::-webkit-scrollbar {
            width: 6px;
        }

        .modal-body::-webkit-scrollbar-track {
            background: #f8f9fa;
        }

        .modal-body::-webkit-scrollbar-thumb {
            background-color: #cbd5e0;
            border-radius: 3px;
        }

        /* Focus States */
        .rating-option input[type="radio"]:focus + label {
            outline: 2px solid rgba(13, 110, 253, 0.5);
            outline-offset: 2px;
        }

        @media (max-width: 768px) {
            .progress-steps {
                gap: 1.5rem;
                padding: 1rem;
            }

            .rating-group {
                flex-direction: column;
                gap: 0.5rem;
            }

            .rating-option label {
                width: 100%;
            }
        }
        
        #officeQuestions {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        /* Headers */
        h4.text-center {
            font-size: 1.75rem;
            color: #2c3e50;
            margin-bottom: 2rem;
            text-align: center;
            font-weight: 600;
        }

        h5 {
            font-size: 1.25rem;
            color: #2c3e50;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e9ecef;
        }

        /* Form Layout */
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: -0.75rem;
        }

        .col-md-6, .col-12 {
            padding: 0.75rem;
        }

        .col-md-6 {
            flex: 0 0 50%;
            max-width: 50%;
        }

        .col-12 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        /* Form Elements */
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #4a5568;
        }

        .form-control, .form-select {
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #2d3748;
            background-color: #fff;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #4299e1;
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.15);
            outline: none;
        }

        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%234a5568' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1.25rem;
            padding-right: 2.5rem;
        }

        /* Radio Groups */
        .d-flex.gap-3 {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }
        #eventEvaluation .peer:checked + span {
    background-color: #3b82f6; /* blue-500 */
    color: white;
    border-color: #3b82f6;
}

#eventEvaluation .peer:checked:hover + span {
    background-color: #2563eb; /* blue-600 */
}

#eventEvaluation .peer:focus + span {
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2); /* blue-500 with opacity */
}

/* Hover effect for unselected buttons */
#eventEvaluation span:hover {
    background-color: #f8fafc;
    border-color: #3b82f6;
}

/* Active/pressed state */
#eventEvaluation span:active {
    background-color: #dbeafe; /* blue-100 */
}

/* Disabled state if needed */
#eventEvaluation .peer:disabled + span {
    background-color: #e5e7eb;
    color: #9ca3af;
    cursor: not-allowed;
    border-color: #d1d5db;
}

/* Additional styles for the radio button groups */
#eventEvaluation .flex.flex-wrap.gap-4 {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1rem;
}

/* Ensure consistent spacing between button groups */
#eventEvaluation .mb-6 {
    margin-bottom: 1.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
}

/* Style for the last button group to remove bottom border */
#eventEvaluation .mb-6:last-child {
    border-bottom: none;
}
        .form-check-input {
            width: 1.25rem;
            height: 1.25rem;
            margin: 0;
        }

        .form-check-label {
            font-size: 1rem;
            color: #4a5568;
        }

        /* Rating Questions */
        .rating-question {
            background: #f8fafc;
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            border: 1px solid #e2e8f0;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .rating-question:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .rating-question p {
            font-size: 1.1rem;
            color: #2d3748;
            margin-bottom: 1rem;
        }

        .rating-question p.text-muted {
            font-size: 0.95rem;
            color: #718096;
            font-style: italic;
        }

        /* Rating Options */
        .rating-question .d-flex.gap-3 {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            justify-content: space-between;
            flex-wrap: nowrap;
        }

        .rating-question .form-check {
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 0.5rem;
            border-radius: 6px;
            transition: background-color 0.2s ease;
        }

        .rating-question .form-check:hover {
            background-color: #f7fafc;
        }

        .rating-question .form-check-input {
            margin-bottom: 0.25rem;
        }

        /* Text Description */
        .text-muted.mb-3 {
            background: #f8fafc;
            padding: 1rem;
            border-radius: 8px;
            margin: 1rem 0;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* Citizen's Charter Section */
        .mb-4 {
            margin-bottom: 2rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .col-md-6 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .rating-question .d-flex.gap-3 {
                flex-wrap: wrap;
                gap: 0.5rem !important;
            }

            .rating-question .form-check {
                flex: 0 0 calc(33.333% - 0.5rem);
            }

            #officeQuestions {
                padding: 1rem;
                margin: 1rem;
            }
        }

        @media (max-width: 480px) {
            .rating-question .form-check {
                flex: 0 0 calc(50% - 0.5rem);
            }
        }

        /* Additional Enhancements */
        .form-section {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .required-field::after {
            content: "*";
            color: #e53e3e;
            margin-left: 4px;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .rating-question {
            animation: fadeIn 0.3s ease-out;
        }
        /* Fix for the feedback modal footer */
#feedbackModal .modal-content {
  display: flex;
  flex-direction: column;
  height: auto;
  max-height: 90vh;
}

#feedbackModal .modal-body {
  flex: 1 1 auto;
  overflow-y: auto;
  max-height: calc(90vh - 150px); /* Adjust based on your header and footer heights */
}

#feedbackModal .modal-footer {
  flex: 0 0 auto;
  padding: 1rem;
  border-top: 1px solid #dee2e6;
}
    </style>

<div class="modal fade" id="feedbackModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h3 class="modal-title">Share Your Feedback</h3>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
            
                <div class="progress-steps">
                    <div class="step-indicator active">1</div>
                    <div class="step-indicator">2</div>
                    <div class="step-indicator">3</div>
                </div> 

            <!-- Modal Body -->
            <div class="modal-body">
                <form id="feedbackForm">
                    <!-- Step 1: Category Selection -->
                    <div class="step active" id="step1">
                        <h4 class="text-center mb-4">What would you like to give feedback about?</h4>
                        <div class="d-flex justify-content-center gap-4">
                            <div class="card feedback-category-card" data-category="office">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Office Processes</h5>
                                    <p class="card-text">Administrative and school-related processes</p>
                                    <input type="radio" name="feedback_category" value="office" class="btn-check" id="officeBtn">
                                    <label class="btn btn-outline-primary w-100" for="officeBtn">Select</label>
                                </div>
                            </div>
                            <div class="card feedback-category-card" data-category="org">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Student Organizations</h5>
                                    <p class="card-text">Feedback for student organizations</p>
                                    <input type="radio" name="feedback_category" value="org" class="btn-check" id="orgBtn">
                                    <label class="btn btn-outline-primary w-100" for="orgBtn">Select</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Category-Specific Questions -->
                    <div class="step" id="step2">

                    <div class="csm-intro mb-4" id="csmIntro" style="display: none;">
    <div class="alert alert-info p-5">
        <h4 class="alert-heading mb-3">HELP US SERVE YOU BETTER!</h4>
        <p class="mb-3">
            This Client Satisfaction Measurement (CSM) Tool aims to track the customer experience of TSU's clients. Your answers will help this office provide a better service. Personal information shared will be kept confidential.
        </p>
        
        <p class="text-muted fst-italic mb-0">
            Ang Client Satisfaction Measurement (CSM) Tool na ito ay magsisilbing gabayan at karanasan ng customer ng mga kliyente ng TSU. Ang iyong mga sagot ay makakatulong sa opisina na mapabuti ang serbisyo na magagamit na impormasyon na ibinahagi ay pananatilihing pribado.
        </p>
    </div>
</div>

                        <!-- Office Processes Questions -->


                        <div id="officeQuestions" style="display: none;">
                            <h4 class="text-center mb-4">Campus Office Processes Evaluation</h4>
                            
                            <!-- Basic Information -->
                            <div class="form-section">
                                <h2 class="section-title">Basic Information</h2>
                                <div class="form-row">
                                <div class="form-group">
    <label class="form-label">Client Type<span class="required">*</span>
        <div class="tagalog">Uri ng kliyente</div>
    </label>
    <select class="form-control" name="client_type" >
        <option value="">Select client type...</option>
        <option value="internal">Internal (Empleyado ng TSU)</option>
        <option value="student">Student (Estudyante)</option>
        <option value="business">Business (Negosyo/Negosyante)</option>
        <option value="government">Government Agency (Ahensya ng Pamahalaan)</option>
    </select>
</div>
                                    <div class="form-group">
                                        <label class="form-label">Date<span class="required">*</span>
                                            <div class="tagalog">Petsa</div>
                                        </label>
                                        <input type="date" class="form-control" name="date" >
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="form-label">Age<span class="required">*</span>
                                            <div class="tagalog">Edad</div>
                                        </label>
                                        <input type="number" class="form-control" name="age" >
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Sex<span class="required">*</span>
                                            <div class="tagalog">Kasarian</div>
                                        </label>
                                        <div class="radio-group">
                                            <label class="radio-label">
                                                <input type="radio" name="sex" value="male" >
                                                Male (Lalake)
                                            </label>
                                            <label class="radio-label">
                                                <input type="radio" name="sex" value="female">
                                                Female (Babae)
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Office that rendered the service(s)<span class="required">*</span>
                                        <div class="tagalog">Opisinang nagbigay serbisyo</div>
                                    </label>
                                    <input type="text" class="form-control" name="office" >
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Service Availed<span class="required">*</span>
                                        <div class="tagalog">Serbisyong naipagkaloob</div>
                                    </label>
                                    <input type="text" class="form-control" name="service" >
                                </div>
                            </div>


                            <!-- Citizen's Charter Awareness -->
                            <div class="form-section">
    <h2 class="section-title">Citizen's Charter Awareness</h2>
    
    <!-- CC1 -->
    <div class="form-group">
        <p class="form-label">CC1: Which of the following best describes your awareness of a CC?<span class="required">*</span></p>
        <div class="radio-group" style="flex-direction: column; gap: 0.75rem;">
            <label class="radio-label">
                <input type="radio" name="cc_awareness" value="aware_saw" >
                1. I know what a CC is and I saw this office's CC.
            </label>
            <label class="radio-label">
                <input type="radio" name="cc_awareness" value="aware_not_saw">
                2. I know what a CC is but I did NOT see this office's CC.
            </label>
            <label class="radio-label">
                <input type="radio" name="cc_awareness" value="learned">
                3. I learned of the CC only when I saw this office's CC.
            </label>
            <label class="radio-label">
                <input type="radio" name="cc_awareness" value="unaware">
                4. I do not know what a CC is and I did not see one in this office.
            </label>
        </div>
    </div>

    <!-- CC2 -->
    <div class="form-group">
        <p class="form-label">CC2: If aware of CC, would you say that the CC of this office was...<span class="required">*</span></p>
        <div class="tagalog">(Kung may kamalayan ka tungkol sa CC, sasabihin mo ba na ang CC ng opisina na ito ay...)</div>
        <div class="radio-group" style="flex-direction: column; gap: 0.75rem;">
            <label class="radio-label">
                <input type="radio" name="cc_visibility" value="easy" >
                1. Easy to see (Madaling makita)
            </label>
            <label class="radio-label">
                <input type="radio" name="cc_visibility" value="somewhat_easy">
                2. Somewhat easy to see (Medyo madaling makita)
            </label>
            <label class="radio-label">
                <input type="radio" name="cc_visibility" value="difficult">
                3. Difficult to see (Mahirap hanapin)
            </label>
            <label class="radio-label">
                <input type="radio" name="cc_visibility" value="not_visible">
                4. Not visible at all (Hindi nakikita)
            </label>
            <label class="radio-label">
                <input type="radio" name="cc_visibility" value="na">
                5. N/A (Hindi naaangkop)
            </label>
        </div>
    </div>

    <!-- CC3 -->
    <div class="form-group">
        <p class="form-label">CC3: If aware of CC (answered codes 1-3 in CC1), how much did the CC help you in your transaction?<span class="required">*</span></p>
        <div class="tagalog">(Kung may kamalayan at nakita mo ang CC sa iyong transaksiyon?)</div>
        <div class="radio-group" style="flex-direction: column; gap: 0.75rem;">
            <label class="radio-label">
                <input type="radio" name="cc_helpfulness" value="helped_very_much">
                1. Helped very much (Nakatulong nang husto)
            </label>
            <label class="radio-label">
                <input type="radio" name="cc_helpfulness" value="somewhat_helped">
                2. Somewhat helped (Medyo nakatulong)
            </label>
            <label class="radio-label">
                <input type="radio" name="cc_helpfulness" value="did_not_help">
                3. Did not help (Walang naitulong)
            </label>
            <label class="radio-label">
                <input type="radio" name="cc_helpfulness" value="na">
                4. N/A (Hindi naaangkop)
            </label>
        </div>
    </div>
</div>

            <!-- Service Quality Rating Section -->
            <div class="form-section">
                <h2 class="section-title">Service Quality Rating</h2>
                
                <div class="rating-scale">
                    <div class="rating-scale-title">Rating Scale:</div>
                    <div class="rating-scale-grid">
                        <div>1 - Strongly Disagree</div>
                        <div>2 - Disagree</div>
                        <div>3 - Neither Agree nor Disagree</div>
                        <div>4 - Agree</div>
                        <div>5 - Strongly Agree</div>
                        <div>N/A - Not Applicable</div>
                    </div>
                </div>

                <div class="rating-questions">
                    <!-- SQD0 -->
                    <div class="rating-question">
                        <div class="form-label">SQD0: I am satisfied with the service that I availed.<span class="required">*</span></div>
                        <div class="tagalog">Nasiyahan ako sa serbisyo na aking natanggap sa napuntahan na opisina.</div>
                        <div class="rating-options">
    <label class="radio-label"><input type="radio" name="sqd0" value="1" >1</label>
    <label class="radio-label"><input type="radio" name="sqd0" value="2">2</label>
    <label class="radio-label"><input type="radio" name="sqd0" value="3">3</label>
    <label class="radio-label"><input type="radio" name="sqd0" value="4">4</label>
    <label class="radio-label"><input type="radio" name="sqd0" value="5">5</label>
    <label class="radio-label"><input type="radio" name="sqd0" value="na">N/A</label>
</div>
                    </div>

                    <!-- SQD1 -->
                    <div class="rating-question">
                        <div class="form-label">SQD1: I spent a reasonable amount of time for my transaction.<span class="required">*</span></div>
                        <div class="tagalog">Makatwiran ang oras na aking ginugol para sa aking transaksyon.</div>
                        <div class="rating-options">
    <label class="radio-label"><input type="radio" name="sqd1" value="1" >1</label>
    <label class="radio-label"><input type="radio" name="sqd1" value="2">2</label>
    <label class="radio-label"><input type="radio" name="sqd1" value="3">3</label>
    <label class="radio-label"><input type="radio" name="sqd1" value="4">4</label>
    <label class="radio-label"><input type="radio" name="sqd1" value="5">5</label>
    <label class="radio-label"><input type="radio" name="sqd1" value="na">N/A</label>
</div>
                    </div>

                    <!-- SQD2 -->
                    <div class="rating-question">
                        <div class="form-label">SQD2: The office followed the transaction's requirements and steps based on the information provided in their Citizens Charter.<span class="required">*</span></div>
                        <div class="tagalog">Tinugunan ng opisina ang aking transakyon alinsunod sa kanilang Citizen's Charter.</div>
                        <div class="rating-options">
    <label class="radio-label"><input type="radio" name="sqd2" value="1">1</label>
    <label class="radio-label"><input type="radio" name="sqd2" value="2">2</label>
    <label class="radio-label"><input type="radio" name="sqd2" value="3">3</label>
    <label class="radio-label"><input type="radio" name="sqd2" value="4">4</label>
    <label class="radio-label"><input type="radio" name="sqd2" value="5">5</label>
    <label class="radio-label"><input type="radio" name="sqd2" value="na">N/A</label>
</div>
                    </div>

                    <!-- SQD3 -->
                    <div class="rating-question">
                        <div class="form-label">SQD3: The steps (including payment) I needed to do for my transaction were easy and simple.<span class="required">*</span></div>
                        <div class="tagalog">Ang mga hakbang (kabilang ang pagbabayad) na kailangan kong gawin para sa aking transaksyon ay madali at simple.</div>
                        <div class="rating-options">
    <label class="radio-label"><input type="radio" name="sqd3" value="1" >1</label>
    <label class="radio-label"><input type="radio" name="sqd3" value="2">2</label>
    <label class="radio-label"><input type="radio" name="sqd3" value="3">3</label>
    <label class="radio-label"><input type="radio" name="sqd3" value="4">4</label>
    <label class="radio-label"><input type="radio" name="sqd3" value="5">5</label>
    <label class="radio-label"><input type="radio" name="sqd3" value="na">N/A</label>
</div>
                    </div>

                    <!-- SQD4 -->
                    <div class="rating-question">
                        <div class="form-label">SQD4: I easily found information about my transaction from the office or its website.<span class="required">*</span></div>
                        <div class="tagalog">Ang mga kailangang impormasyon tungkol sa aking transaksyon ay kaagad kong nakita sa opisina o sa TSU website.</div>
                        <div class="rating-options">
    <label class="radio-label"><input type="radio" name="sqd4" value="1" >1</label>
    <label class="radio-label"><input type="radio" name="sqd4" value="2">2</label>
    <label class="radio-label"><input type="radio" name="sqd4" value="3">3</label>
    <label class="radio-label"><input type="radio" name="sqd4" value="4">4</label>
    <label class="radio-label"><input type="radio" name="sqd4" value="5">5</label>
    <label class="radio-label"><input type="radio" name="sqd4" value="na">N/A</label>
</div>
                    </div>

                    <!-- SQD5 -->
                    <div class="rating-question">
                        <div class="form-label">SQD5: The amount I paid for my transaction is value for money.<span class="required">*</span></div>
                        <div class="tagalog">Ang halagang ibinayad ay akma sa serbisyong natamo.</div>
                        <div class="rating-options">
    <label class="radio-label"><input type="radio" name="sqd5" value="1" >1</label>
    <label class="radio-label"><input type="radio" name="sqd5" value="2">2</label>
    <label class="radio-label"><input type="radio" name="sqd5" value="3">3</label>
    <label class="radio-label"><input type="radio" name="sqd5" value="4">4</label>
    <label class="radio-label"><input type="radio" name="sqd5" value="5">5</label>
    <label class="radio-label"><input type="radio" name="sqd5" value="na">N/A</label>
</div>
                    </div>

                    <!-- SQD6 -->
                    <div class="rating-question">
                        <div class="form-label">SQD6: I am confident my online transaction was secure.<span class="required">*</span></div>
                        <div class="tagalog">Pakiramdam ko ay patas ang opisina sa lahat, o "walang palakasan", sa aking transaksyon.</div>
                        <div class="rating-options">
    <label class="radio-label"><input type="radio" name="sqd6" value="1" >1</label>
    <label class="radio-label"><input type="radio" name="sqd6" value="2">2</label>
    <label class="radio-label"><input type="radio" name="sqd6" value="3">3</label>
    <label class="radio-label"><input type="radio" name="sqd6" value="4">4</label>
    <label class="radio-label"><input type="radio" name="sqd6" value="5">5</label>
    <label class="radio-label"><input type="radio" name="sqd6" value="na">N/A</label>
</div>
                    </div>

                    <!-- SQD7 -->
                    <div class="rating-question">
                        <div class="form-label">SQD7: The Office's online support was available, and (if asked) questions online support was quick to respond.<span class="required">*</span></div>
                        <div class="tagalog">Magalang akong trinato ng mga tauhan, at (kung sakali ako ay humingi ng tulong) alam ko na sila ay handang tumulong sa akin.</div>
                        <div class="rating-options">
                            <label class="radio-label"><input type="radio" name="sqd7" value="1" >1</label>
                            <label class="radio-label"><input type="radio" name="sqd7" value="2">2</label>
                            <label class="radio-label"><input type="radio" name="sqd7" value="3">3</label>
                            <label class="radio-label"><input type="radio" name="sqd7" value="4">4</label>
                            <label class="radio-label"><input type="radio" name="sqd7" value="5">5</label>
                            <label class="radio-label"><input type="radio" name="sqd7" value="na">N/A</label>
                        </div>
                    </div>

                    <!-- SQD8 -->
                    <div class="rating-question">
                        <div class="form-label">SQD8: I got what I needed from the government office, or (if denied) denial of request was sufficiently explained to me.<span class="required">*</span></div>
                        <div class="tagalog">Nakuha ko ang kinakailangan ko mula sa tanggapan ng gobyerno, kung tinanggihan man, ito ay sapat na ipinaliwanag sa akin.</div>
                        <div class="rating-options">
    <label class="radio-label"><input type="radio" name="sqd8" value="1" >1</label>
    <label class="radio-label"><input type="radio" name="sqd8" value="2">2</label>
    <label class="radio-label"><input type="radio" name="sqd8" value="3">3</label>
    <label class="radio-label"><input type="radio" name="sqd8" value="4">4</label>
    <label class="radio-label"><input type="radio" name="sqd8" value="5">5</label>
    <label class="radio-label"><input type="radio" name="sqd8" value="na">N/A</label>
</div>
                    </div>
                </div>
                            </div>
                        </div>

                          <!-- Student Organizations Questions -->
                            <div id="orgQuestions" style="display: none;">
                                <h4 class="text-center mb-4">Student Organization Evaluation</h4>
                                
                                <div class="form-group mb-4">
                                    <label class="form-label">Select Organization</label>
                                    <select class="form-select" name="organization">
                                        <option value="">Choose an organization...</option>
                                    </select>
                                </div>

                                <div class="form-group mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="evaluateEvent" name="evaluate_event">
                                        <label class="form-check-label" for="evaluateEvent">
                                            I want to evaluate a specific event by this organization
                                        </label>
                                    </div>
                                </div>
                            
                                                            <!-- Question 1: Event Quality -->
                                <div class="question-block">
                                    <h5>1. Event Quality</h5>
                                    <p class="text-muted">How engaging and well-organized were the events?</p>
                                    <div class="rating-group">
                                        <div class="rating-option">
                                            <input type="radio" name="event_quality" id="eq1" value="1">
                                            <label for="eq1">1<br>Poor</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="event_quality" id="eq2" value="2">
                                            <label for="eq2">2<br>Fair</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="event_quality" id="eq3" value="3">
                                            <label for="eq3">3<br>Good</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="event_quality" id="eq4" value="4">
                                            <label for="eq4">4<br>Very Good</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="event_quality" id="eq5" value="5">
                                            <label for="eq5">5<br>Excellent</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 2: Communication -->
                                <div class="question-block">
                                    <h5>2. Communication</h5>
                                    <p class="text-muted"><p class="text-muted">How effective was the organization in communicating event details and announcements?</p>
                                    <div class="rating-group">
                                        <div class="rating-option">
                                            <input type="radio" name="org_communication" id="orgcom1" value="1">
                                            <label for="orgcom1">1<br>Poor</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="org_communication" id="orgcom2" value="2">
                                            <label for="orgcom2">2<br>Fair</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="org_communication" id="orgcom3" value="3">
                                            <label for="orgcom3">3<br>Good</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="org_communication" id="orgcom4" value="4">
                                            <label for="orgcom4">4<br>Very Good</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="org_communication" id="orgcom5" value="5">
                                            <label for="orgcom5">5<br>Excellent</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 3: Inclusivity -->
                                <div class="question-block">
                                    <h5>3. Inclusivity</h5>
                                    <p class="text-muted">How welcoming and inclusive was the organization to all members?</p>
                                    <div class="rating-group">
                                        <div class="rating-option">
                                            <input type="radio" name="inclusivity" id="inc1" value="1">
                                            <label for="inc1">1<br>Poor</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="inclusivity" id="inc2" value="2">
                                            <label for="inc2">2<br>Fair</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="inclusivity" id="inc3" value="3">
                                            <label for="inc3">3<br>Good</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="inclusivity" id="inc4" value="4">
                                            <label for="inc4">4<br>Very Good</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="inclusivity" id="inc5" value="5">
                                            <label for="inc5">5<br>Excellent</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 4: Leadership -->
                                <div class="question-block">
                                    <h5>4. Leadership</h5>
                                    <p class="text-muted">How effective and approachable was the leadership team?</p>
                                    <div class="rating-group">
                                        <div class="rating-option">
                                            <input type="radio" name="leadership" id="lead1" value="1">
                                            <label for="lead1">1<br>Poor</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="leadership" id="lead2" value="2">
                                            <label for="lead2">2<br>Fair</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="leadership" id="lead3" value="3">
                                            <label for="lead3">3<br>Good</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="leadership" id="lead4" value="4">
                                            <label for="lead4">4<br>Very Good</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="leadership" id="lead5" value="5">
                                            <label for="lead5">5<br>Excellent</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 5: Skill Development -->
                                <div class="question-block">
                                    <h5>5. Skill Development</h5>
                                    <p class="text-muted">How well did the organization provide opportunities for personal growth?</p>
                                    <div class="rating-group">
                                        <div class="rating-option">
                                            <input type="radio" name="skill_dev" id="skill1" value="1">
                                            <label for="skill1">1<br>Poor</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="skill_dev" id="skill2" value="2">
                                            <label for="skill2">2<br>Fair</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="skill_dev" id="skill3" value="3">
                                            <label for="skill3">3<br>Good</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="skill_dev" id="skill4" value="4">
                                            <label for="skill4">4<br>Very Good</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="skill_dev" id="skill5" value="5">
                                            <label for="skill5">5<br>Excellent</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Question 6: Impact -->
                                <div class="question-block">
                                    <h5>6. Impact</h5>
                                    <p class="text-muted">How much did the organization positively contribute to your campus experience?</p>
                                    <div class="rating-group">
                                        <div class="rating-option">
                                            <input type="radio" name="impact" id="imp1" value="1">
                                            <label for="imp1">1<br>Poor</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="impact" id="imp2" value="2">
                                            <label for="imp2">2<br>Fair</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="impact" id="imp3" value="3">
                                            <label for="imp3">3<br>Good</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="impact" id="imp4" value="4">
                                            <label for="imp4">4<br>Very Good</label>
                                        </div>
                                        <div class="rating-option">
                                            <input type="radio" name="impact" id="imp5" value="5">
                                            <label for="imp5">5<br>Excellent</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
    <!-- Event Evaluation Section -->
    <div id="eventEvaluation" style="display:none;"class="bg-white rounded-lg shadow-lg p-6 max-w-4xl mx-auto">
    <h5 class="text-2xl font-semibold text-gray-800 mb-6">Event Evaluation Form</h5>
    
    <!-- Activity Details Section -->
    <div class="space-y-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Activity Title</label>
                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" name="activity_title">
            </div>
            
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Date</label>
                <input type="date" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" name="activity_date">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Venue</label>
                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" name="venue">
            </div>
            
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Student Organization</label>
                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" name="student_org">
            </div>
        </div>

        <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">Position</label>
            <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" name="position">
        </div>
    </div>


    <!-- Online Activity Ratings -->
    <div class="mb-8">
        <label class="block text-lg font-medium text-gray-800 mb-4">1. Online Activity Ratings</label>
        
        <!-- Pre-event communication -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-3">Pre-event communication</label>
            <div class="flex flex-wrap gap-4">
                <label class="inline-flex items-center">
                    <input type="radio" name="communication_rating" value="excellent" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Excellent</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="communication_rating" value="very_satisfactory" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Very Satisfactory</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="communication_rating" value="satisfactory" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Satisfactory</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="communication_rating" value="needs_improvement" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Needs Improvement</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="communication_rating" value="poor" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Poor</span>
                </label>
            </div>
        </div>

        <!-- Video quality -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-3">Video quality of the activity broadcast</label>
            <div class="flex flex-wrap gap-4">
                <label class="inline-flex items-center">
                    <input type="radio" name="video_quality" value="excellent" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Excellent</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="video_quality" value="very_satisfactory" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Very Satisfactory</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="video_quality" value="satisfactory" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Satisfactory</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="video_quality" value="needs_improvement" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Needs Improvement</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="video_quality" value="poor" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Poor</span>
                </label>
            </div>
        </div>

        <!-- Audio quality -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-3">Audio quality of the activity broadcast</label>
            <div class="flex flex-wrap gap-4">
                <label class="inline-flex items-center">
                    <input type="radio" name="audio_quality" value="excellent" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Excellent</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="audio_quality" value="very_satisfactory" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Very Satisfactory</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="audio_quality" value="satisfactory" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Satisfactory</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="audio_quality" value="needs_improvement" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Needs Improvement</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="audio_quality" value="poor" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Poor</span>
                </label>
            </div>
        </div>
    </div>

    <!-- Resource Person Evaluation -->
    <div class="mb-8">
        <label class="block text-lg font-medium text-gray-800 mb-4">2. Resource Person Evaluation</label>
        
        <!-- Mastery -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-3">Mastery of the subject matter</label>
            <div class="flex flex-wrap gap-4">
                <label class="inline-flex items-center">
                    <input type="radio" name="mastery_rating" value="excellent" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Excellent</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="mastery_rating" value="very_satisfactory" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Very Satisfactory</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="mastery_rating" value="satisfactory" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Satisfactory</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="mastery_rating" value="needs_improvement" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Needs Improvement</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="mastery_rating" value="poor" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Poor</span>
                </label>
            </div>
        </div>

        <!-- Time Management -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-3">Time management</label>
            <div class="flex flex-wrap gap-4">
                <label class="inline-flex items-center">
                    <input type="radio" name="time_management" value="excellent" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Excellent</span></label>
                <label class="inline-flex items-center">
                    <input type="radio" name="time_management" value="very_satisfactory" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Very Satisfactory</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="time_management" value="satisfactory" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Satisfactory</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="time_management" value="needs_improvement" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Needs Improvement</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="time_management" value="poor" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Poor</span>
                </label>
            </div>
        </div>

        <!-- Learning Methodologies -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-3">Appropriateness of learning methodologies</label>
            <div class="flex flex-wrap gap-4">
                <label class="inline-flex items-center">
                    <input type="radio" name="methodologies" value="excellent" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Excellent</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="methodologies" value="very_satisfactory" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Very Satisfactory</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="methodologies" value="satisfactory" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Satisfactory</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="methodologies" value="needs_improvement" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Needs Improvement</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="methodologies" value="poor" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Poor</span>
                </label>
            </div>
        </div>

        <!-- Professional Conduct -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-3">Professional conduct</label>
            <div class="flex flex-wrap gap-4">
                <label class="inline-flex items-center">
                    <input type="radio" name="conduct" value="excellent" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Excellent</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="conduct" value="very_satisfactory" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Very Satisfactory</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="conduct" value="satisfactory" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Satisfactory</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="conduct" value="needs_improvement" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Needs Improvement</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="conduct" value="poor" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Poor</span>
                </label>
            </div>
        </div>
    </div>

    <!-- Activity Relevance Questions -->
    <div class="mb-8">
        <label class="block text-lg font-medium text-gray-800 mb-4">3. Activity Relevance</label>
        
        <!-- Topic Informativeness -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-3">I find the topic of the activity informative</label>
            <div class="flex flex-wrap gap-4">
                <label class="inline-flex items-center">
                    <input type="radio" name="topic_informative" value="strongly_agree" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Strongly Agree</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="topic_informative" value="agree" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Agree</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="topic_informative" value="undecided" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Undecided</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="topic_informative" value="disagree" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Disagree</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="topic_informative" value="strongly_disagree" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Strongly Disagree</span>
                </label>
            </div>
        </div>

        <!-- Activity Usefulness -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-3">The activity is relevant or useful</label>
            <div class="flex flex-wrap gap-4">
                <label class="inline-flex items-center">
                    <input type="radio" name="activity_relevance" value="strongly_agree" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Strongly Agree</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="activity_relevance" value="agree" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Agree</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="activity_relevance" value="undecided" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Undecided</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="activity_relevance" value="disagree" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Disagree</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="activity_relevance" value="strongly_disagree" class="sr-only peer">
                    <span class="px-4 py-2 rounded-full border border-gray-300 cursor-pointer peer-checked:bg-blue-500 peer-checked:text-white hover:bg-gray-50">Strongly Disagree</span>
                </label>
            </div>
        </div>
    </div>

    <!-- Comments and Suggestions -->
    <div class="mb-8">
        <label class="block text-lg font-medium text-gray-800 mb-4">4. Comments and Suggestions</label>
        <div class="space-y-4">
            <label class="block text-sm font-medium text-gray-700">We highly appreciate your comments and suggestions to help us improve the activity</label>
            <textarea class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500" name="comments_suggestions" rows="4" placeholder="Share your thoughts on how we can improve..."></textarea>
        </div>
    </div>
</div>
</div>

                        <!-- Step 3: Additional Information -->
                        <div class="step" id="step3">
                            <h4 class="text-center mb-4">Additional Information</h4>
                            
                            <div class="mb-4">
                                <label class="form-label">What improvements would you suggest?</label>
                                <textarea class="form-control" name="improvements" rows="4" placeholder="Share your thoughts on how we can improve..."></textarea>
                            </div>

                            <div class="row">
                            <div class="col-md-6 mb-3">
                            <label class="form-label">Email (Optional)</label>
                            <input class="form-control" 
                                name="email" 
                                placeholder="your@email.com">
                        </div>
                                                        
                        <div class="col-md-6 mb-3">
                                    <label class="form-label">Name (Optional)</label>
                                    <input type="text" class="form-control" name="name" placeholder="Your Name">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="prevBtn" disabled>Previous</button>
                    <button type="button" class="btn btn-primary" id="nextBtn">Next</button>
                    <button type="submit" class="btn btn-success" id="submitBtn" form="feedbackForm" style="display:none;">Submit Feedback</button>
                </div>
            </div>
        </div>
    </div>
    
 
    
 
        </div>

        <div class="page-loader">
  <div class="loader-content">
    <div class="loader-spinner"></div>
    <div class="loader-text" style="margin-top: 15px; font-family: 'Arial', sans-serif; font-weight: bold; color: #7D0A0A;">
      Loading Campus Kiosk...
    </div>
  </div>
</div>

<!-- Script to handle page loader -->
<script>
  window.addEventListener('load', function() {
    // When the page is fully loaded, wait a bit and then fade out the loader
    setTimeout(function() {
      const loader = document.querySelector('.page-loader');
      if (loader) {
        loader.classList.add('loaded');
        
        // Remove the loader after animation completes
        setTimeout(function() {
          loader.style.display = 'none';
        }, 500);
      }
    }, 500); // Display loader for at least 500ms
  });
</script>
        <script>
            window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')
        </script>

        <!-- Popper.js and Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0-alpha1/js/bootstrap.bundle.min.js"></script>



        <!-- SweetAlert2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


        <!-- Custom JS and Plugins -->
        <script src="js/simple-animations.js"></script>
        <script src="js/vendor/bootstrap.min.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>
        <script>
        document.addEventListener("DOMContentLoaded", function () {
    // Tab functionality
    const tabButtons = document.querySelectorAll(".button-faculty-btn");
    const tabs = document.querySelectorAll(".org-chart");

    tabButtons.forEach(button => {
        button.addEventListener("click", function () {
            const tabId = this.getAttribute("data-tab");

            // Remove active class from all buttons and hide all tabs
            tabButtons.forEach(btn => btn.classList.remove("active"));
            tabs.forEach(tab => tab.style.display = "none");

            // Add active class to the clicked button and show the associated tab
            this.classList.add("active");
            document.getElementById(tabId).style.display = "block";
        });
    });

    // Show "Tab 1" (IT Department) and mark the corresponding button as active
    if (tabButtons.length > 0 && tabs.length > 0) {
        tabButtons[0].classList.add("active"); // Activate the first button
        tabs.forEach(tab => tab.style.display = "none"); // Hide all tabs
        tabs[0].style.display = "block"; // Show the first tab
    }

    // Modal functionality
    const profileCard = document.getElementById("profileCard");
    const backdrop = document.getElementById("backdrop");

    document.querySelectorAll(".member").forEach(member => {
        member.addEventListener("click", function () {
            // Set profile details based on clicked member
            document.getElementById("profileImage").src = this.getAttribute("data-image");
            document.getElementById("profileName").textContent = this.getAttribute("data-name");
            document.getElementById("profileSpecialization").querySelector(".specialization-value").textContent = this.getAttribute("data-specialization");
            document.getElementById("profileConsultationTime").querySelector(".consultation-value").textContent = this.getAttribute("data-consultation");

            // Show the profile modal and backdrop
            profileCard.style.display = "block";
            backdrop.style.display = "block";
        });
    });

    // Close the modal when clicking outside (on the backdrop)
    backdrop.addEventListener("click", function () {
        profileCard.style.display = "none";
        backdrop.style.display = "none";
    });
});

</script>
<script>// Function to handle setting the rating (optional, if you need it for other purposes)
document.addEventListener('DOMContentLoaded', function() {
    // Element references
    const feedbackForm = document.getElementById('feedbackForm');
    const steps = document.querySelectorAll('.step');
    const indicators = document.querySelectorAll('.step-indicator');
    const nextBtn = document.getElementById('nextBtn');
    const prevBtn = document.getElementById('prevBtn');
    const submitBtn = document.getElementById('submitBtn');
    const organizationSelect = document.querySelector('select[name="organization"]');
    const evaluateEventCheckbox = document.getElementById('evaluateEvent');
    const eventEvaluation = document.getElementById('eventEvaluation');
    let currentStep = 0;


if (organizationSelect) {
    // Fetch organizations when the page loads
    fetch('ajax/fetch_organizations.php')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.organizations) {
                // Clear existing options
                organizationSelect.innerHTML = '<option value="">Choose an organization...</option>';
                
                // Add organizations to dropdown
                data.organizations.forEach(org => {
                    const option = document.createElement('option');
                    option.value = org.org_id;
                    option.textContent = org.org_name;
                    organizationSelect.appendChild(option);
                });
            } else {
                console.error('Error loading organizations:', data.message);
                organizationSelect.innerHTML = '<option value="">Error loading organizations</option>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            organizationSelect.innerHTML = '<option value="">Error loading organizations</option>';
        });
}
    // Rating conversion maps
    const ratingMap = {
        'excellent': 5,
        'very_satisfactory': 4,
        'satisfactory': 3,
        'needs_improvement': 2,
        'poor': 1
    };

    const agreementMap = {
        'strongly_agree': 5,
        'agree': 4,
        'undecided': 3,
        'disagree': 2,
        'strongly_disagree': 1
    };

    // Helper functions
    function convertRatingToNumber(rating) {
        return ratingMap[rating] || null;
    }

    function convertAgreementToNumber(rating) {
        return agreementMap[rating] || null;
    }

    // Category selection handler
  // Modify your existing category selection handler
document.querySelectorAll('input[name="feedback_category"]').forEach(input => {
    input.addEventListener('change', function() {
        const category = this.value;
        const officeQuestions = document.getElementById('officeQuestions');
        const orgQuestions = document.getElementById('orgQuestions');
        const csmIntro = document.getElementById('csmIntro');
        
        if (category === 'office') {
            officeQuestions.style.display = 'block';
            orgQuestions.style.display = 'none';
            if (eventEvaluation) eventEvaluation.style.display = 'none';
            // Show the CSM intro for office category
            if (csmIntro) csmIntro.style.display = 'block';
        } else if (category === 'org') {
            officeQuestions.style.display = 'none';
            orgQuestions.style.display = 'block';
            // Hide the CSM intro for org category
            if (csmIntro) csmIntro.style.display = 'none';
        }
    });
});

    // Event evaluation checkbox handler
    if (evaluateEventCheckbox) {
        evaluateEventCheckbox.addEventListener('change', function() {
            if (eventEvaluation) {
                eventEvaluation.style.display = this.checked ? 'block' : 'none';
            }
        });
    }

    // Validation functions
    function validateOfficeForm() {
    const requiredFields = [
        { name: 'client_type', label: 'Client Type', type: 'select' },
        { name: 'date', label: 'Date', type: 'date' },
        { name: 'age', label: 'Age', type: 'number' },
        { name: 'sex', label: 'Sex', type: 'radio' },
        { name: 'office', label: 'Office', type: 'text' },
        { name: 'service', label: 'Service', type: 'text' },
        { name: 'cc_awareness', label: 'CC Awareness', type: 'radio' },
        { name: 'cc_visibility', label: 'CC Visibility', type: 'radio' },
        { name: 'cc_helpfulness', label: 'CC Helpfulness', type: 'radio' }
    ];

    for (const field of requiredFields) {
        const element = field.type === 'radio' 
            ? document.querySelector(`input[name="${field.name}"]:checked`)
            : document.querySelector(`[name="${field.name}"]`);
            
        const value = field.type === 'radio' 
            ? element?.value
            : element?.value?.trim();

        if (!value) {
            alert(`Please ${field.type === 'select' ? 'select' : 'enter'} ${field.label}`);
            element?.focus();
            return false;
        }
    }

    // Validate SQD ratings
    for (let i = 0; i <= 8; i++) {
        if (!document.querySelector(`input[name="sqd${i}"]:checked`)) {
            alert(`Please provide a rating for SQD${i}`);
            return false;
        }
    }

    return true;
}
    function validateEventEvaluation() {
    const evaluateEventChecked = document.getElementById('evaluateEvent').checked;
    
    if (!evaluateEventChecked) {
        return true; // Skip validation if event evaluation is not checked
    }

    const requiredFields = [
        'activity_title',
        'activity_date',
        'venue',
        'student_org'
    ];

    for (const fieldName of requiredFields) {
        const field = document.querySelector(`[name="${fieldName}"]`);
        const value = field?.value?.trim();
        
        if (!value) {
            alert(`Please fill in ${fieldName.replace('_', ' ')}`);
            field?.focus();
            return false;
        }
    }

    const ratingFields = [
        'communication_rating',
        'video_quality',
        'audio_quality',
        'mastery_rating',
        'time_management',
        'methodologies',
        'conduct',
        'topic_informative',
        'activity_relevance'
    ];

    for (const fieldName of ratingFields) {
        if (!document.querySelector(`input[name="${fieldName}"]:checked`)) {
            alert(`Please provide a rating for ${fieldName.replace('_', ' ')}`);
            return false;
        }
    }

    return true;
}
    // Form submission handler
    if (feedbackForm) {
    feedbackForm.addEventListener('submit', function(event) {
        event.preventDefault();
        
        // Validate current step
        if (!validateCurrentStep()) {
            return;
        }

        const formData = new FormData(this);
        const feedbackCategory = formData.get('feedback_category');
        
        submitBtn.disabled = true;

        // Process organization feedback
        if (feedbackCategory === 'org') {
            // Convert org ratings to numbers
            const orgRatings = [
                'event_quality',
                'org_communication',
                'inclusivity',
                'leadership',
                'skill_dev',
                'impact'
            ];

            orgRatings.forEach(field => {
                const rating = formData.get(field);
                if (rating) {
                    formData.set(field, parseInt(rating));
                }
            });

            // Check if event evaluation is enabled
            const evaluateEventChecked = document.getElementById('evaluateEvent').checked;
            formData.set('evaluate_event', evaluateEventChecked ? '1' : '0');

            // Handle event evaluation if checked
            if (evaluateEventChecked) {
                // Convert ratings using rating map
                const eventRatings = [
                    'communication_rating',
                    'video_quality',
                    'audio_quality',
                    'mastery_rating',
                    'time_management',
                    'methodologies',
                    'conduct'
                ];

                eventRatings.forEach(field => {
                    const rating = formData.get(field);
                    if (rating) {
                        formData.set(field, convertRatingToNumber(rating));
                    }
                });

                // Convert agreement ratings
                const agreementFields = [
                    'topic_informative',
                    'activity_relevance'
                ];

                agreementFields.forEach(field => {
                    const rating = formData.get(field);
                    if (rating) {
                        formData.set(field, convertAgreementToNumber(rating));
                    }
                });

                // Ensure all required event fields are included
                const eventRequiredFields = [
                    'activity_title',
                    'activity_date',
                    'venue',
                    'student_org'
                ];

                eventRequiredFields.forEach(field => {
                    const value = formData.get(field);
                    if (!value) {
                        console.error(`Missing required event field: ${field}`);
                    }
                });
            }
        }

        // Submit form data
        fetch('ajax/submit_feedback.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => {
                    console.error('Server response:', text);
                    throw new Error('Server responded with an error');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert('Thank you for your feedback!');
                resetForm();
                const modal = document.getElementById('feedbackModal');
                if (modal && typeof bootstrap !== 'undefined') {
                    const bsModal = bootstrap.Modal.getInstance(modal);
                    if (bsModal) bsModal.hide();
                }
            } else {
                throw new Error(data.message || 'Error submitting feedback');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while submitting your feedback. Please try again.');
        })
        .finally(() => {
            submitBtn.disabled = false;
        });
    });
}
    // Step validation
    function validateCurrentStep() {
        if (currentStep === 0) {
            const categorySelected = document.querySelector('input[name="feedback_category"]:checked');
            if (!categorySelected) {
                alert('Please select a feedback category');
                return false;
            }
            return true;
        }
        
        if (currentStep === 1) {
            const category = document.querySelector('input[name="feedback_category"]:checked').value;
            
            if (category === 'office') {
                return validateOfficeForm();
            } else if (category === 'org') {
                return validateOrgForm() && validateEventEvaluation();
            }
        }

        return true;
    }
    function validateOrgForm() {
    const requiredFields = [
        { name: 'organization', label: 'Organization', type: 'select' },
    ];

    for (const field of requiredFields) {
        const element = field.type === 'radio' 
            ? document.querySelector(`input[name="${field.name}"]:checked`)
            : document.querySelector(`[name="${field.name}"]`);
            
        const value = field.type === 'radio' 
            ? element?.value
            : element?.value?.trim();

        if (!value) {
            alert(`Please ${field.type === 'select' ? 'select' : 'enter'} ${field.label}`);
            element?.focus();
            return false;
        }
    }

    // Validate organization ratings
    const orgRatings = [
        'event_quality',
        'org_communication',
        'inclusivity',
        'leadership',
        'skill_dev',
        'impact'
    ];

    for (const rating of orgRatings) {
        if (!document.querySelector(`input[name="${rating}"]:checked`)) {
            alert(`Please provide a rating for ${rating.replace('_', ' ')}`);
            return false;
        }
    }

    return true;
}

    // Navigation and step management
    function updateSteps() {
        steps.forEach((step, index) => {
            step.classList.toggle('active', index === currentStep);
            step.style.display = index === currentStep ? 'block' : 'none';
        });
        
        indicators.forEach((indicator, index) => {
            indicator.classList.toggle('active', index <= currentStep);
        });
        
        prevBtn.disabled = currentStep === 0;
        nextBtn.style.display = currentStep === steps.length - 1 ? 'none' : 'block';
        submitBtn.style.display = currentStep === steps.length - 1 ? 'block' : 'none';
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', function() {
            if (!validateCurrentStep()) {
                return;
            }
            
            if (currentStep < steps.length - 1) {
                currentStep++;
                updateSteps();
            }
        });
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', function() {
            if (currentStep > 0) {
                currentStep--;
                updateSteps();
            }
        });
    }

    // Form reset
    function resetForm() {
        if (feedbackForm) {
            feedbackForm.reset();
            currentStep = 0;
            updateSteps();

            // Reset display states
            const displays = {
                'officeQuestions': 'none',
                'orgQuestions': 'none',
                'eventEvaluation': 'none'
            };

            Object.entries(displays).forEach(([id, display]) => {
                const element = document.getElementById(id);
                if (element) element.style.display = display;
            });
        }
    }

    // Initialize on load
    updateSteps();
});
function updateFeedbackCounts() {
  fetch('ajax/get_feedback_counts.php')
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        // Update with the correct element IDs from your HTML
        document.getElementById('org-feedback-count').textContent = data.org_count || 0;
        document.getElementById('office-feedback-count').textContent = data.office_count || 0;
      } else {
        console.error('Error in feedback response:', data.error);
      }
    })
    .catch(error => {
      console.error('Error fetching feedback counts:', error);
      // Update with fallback values if fetch fails
      document.getElementById('org-feedback-count').textContent = '0';
      document.getElementById('office-feedback-count').textContent = '0';
    });
}

// Update counts initially and every 30 seconds
document.addEventListener('DOMContentLoaded', function() {
  updateFeedbackCounts();
  setInterval(updateFeedbackCounts, 30000);
});
    </script>
    <script>
    var scrollTimeout;
            $(window).scroll(function (event) {
        clearTimeout(scrollTimeout); // Clear any previous timeout
        scrollTimeout = setTimeout(function () {
            hasScrolled(); // Call hasScrolled after a delay to avoid multiple triggers
        }, 250); // Adjust delay as necessary
    });

    function hasScrolled() {
        var st = $(this).scrollTop();

        // Make sure they scroll more than delta
        if (Math.abs(lastScrollTop - st) <= delta) return;

        // If they scrolled down and are past the navbar, add class .nav-up.
        if (st > lastScrollTop && st > navbarHeight) {
            $('header').removeClass('nav-down').addClass('nav-up');
        } else {
            // If they scrolled up
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
    if (dropdownMenu) {
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
    }

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
                    console.error("Response Text:", xhr.responseText); // Log the raw response
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
   
$(document).ready(function () {
    // Global variables to store state
    let allAnnouncements = [];
    let currentProfilePhoto = '';
    let currentAuthorName = '';
    
    // When the modal is shown, ensure that we fetch announcements
    $('#newsModal').on('show.bs.modal', function (e) {
        var orgId = $(e.relatedTarget).data('orgid');
        var title = $(e.relatedTarget).data('title');
        var imageSrc = $(e.relatedTarget).data('image');
        var profilePhoto = $(e.relatedTarget).data('profilephoto');
        var authorName = $(e.relatedTarget).data('author');

        console.log("Organization ID (Announcements):", orgId);

        // Update organization name and profile photo in the modal
        $('#orgName').text(title);
        $('#orgProfilePhoto').attr('src', profilePhoto);
        
        // Set org_id for both tabs
        $('#announcements-tab').data('orgid', orgId);
        $('#members-tab').data('orgid', orgId);

        // Fetch announcements if orgId is valid
        if (orgId) {
            fetchAnnouncements(orgId, profilePhoto, authorName);
        } else {
            console.error("Invalid orgId in modal");
        }
        
        // Clear filters when modal is opened
        resetFiltersUI();
    });

    // When the Members tab is clicked, fetch members dynamically based on org_id
    $('#members-tab').on('click', function () {
        var orgId = $(this).data('orgid'); // Get orgId from members tab button

        if (orgId) {
            console.log("Fetching members for org ID:", orgId);
            fetchMembers(orgId);
        } else {
            console.error("Invalid orgId for fetching members");
            $('#members').html('<p class="text-danger">Invalid organization ID.</p>');
        }
    });
    
    // Fetch announcements from server
    function fetchAnnouncements(orgId, profilePhoto, authorName) {
        const filters = {
            org_id: orgId,
            search: $('#announcementSearch').val(),
            category: $('#categoryFilter').val(),
            date_from: $('#dateFilter').val()
        };

        console.log('Sending filters to server:', filters);
        
        // Store these for later use
        currentProfilePhoto = profilePhoto;
        currentAuthorName = authorName;

        $.ajax({
            url: 'ajax/fetch_announcement.php',
            type: 'POST',
            dataType: 'json',
            data: filters,
            success: function(response) {
                if (response.status === 'error') {
                    $('#announcements-content').html(`<p class="text-danger">${response.message}</p>`);
                    return;
                }
                
                allAnnouncements = response.announcements;
                console.log('Received announcements:', allAnnouncements);
                console.log('Applied filters:', response.filters_applied);
                
                renderAnnouncementsContent({ announcements: allAnnouncements });
            },
            error: function(xhr, status, error) {
                console.error('Fetch error:', error);
                console.error('Server response:', xhr.responseText);
                $('#announcements-content').html('<p class="text-danger">Error loading announcements</p>');
            }
        });
    }
    
    // Fetch members function
    function fetchMembers(orgId) {
        // Implement your members fetching logic here
        console.log("Fetching members for organization ID:", orgId);
        // Example AJAX call - update with your actual endpoint
        $.ajax({
            url: 'ajax/fetch_members.php',
            type: 'POST',
            dataType: 'json',
            data: { org_id: orgId },
            success: function(response) {
                // Process member data
                console.log("Member data received:", response);
                // Render members tab content
            },
            error: function(xhr, status, error) {
                console.error("Error fetching members:", error);
                $('#members').html('<p class="text-danger">Error loading members</p>');
            }
        });
    }
    
    // Main filtering function
    function filterAnnouncements() {
        const searchTerm = $('#announcementSearch').val().toLowerCase().trim();
        const dateFilter = $('#dateFilter').val();
        const categoryFilter = $('#categoryFilter').val();

        console.log('Starting filter with:', { searchTerm, dateFilter, categoryFilter });

        // Make sure allAnnouncements is defined and accessible
        if (!allAnnouncements || !Array.isArray(allAnnouncements)) {
            console.error('allAnnouncements is not defined or not an array');
            return [];
        }

        const filtered = allAnnouncements.filter(announcement => {
            // Search filter - make sure all properties exist before accessing them
            const searchableText = [
                announcement.announcement_title || '',
                announcement.announcement_details || '',
                announcement.creator_name || '',
                announcement.author_name || ''
            ].join(' ').toLowerCase();
            
            const matchesSearch = !searchTerm || searchableText.includes(searchTerm);
            
            // Date filter - improved date handling
            let matchesDate = true;
            if (dateFilter) {
                if (dateFilter === 'today') {
                    // Today filter
                    const today = new Date();
                    const announcementDate = new Date(announcement.created_at);
                    matchesDate = 
                        announcementDate.getDate() === today.getDate() &&
                        announcementDate.getMonth() === today.getMonth() &&
                        announcementDate.getFullYear() === today.getFullYear();
                } 
                else if (dateFilter === 'week') {
                    // This week filter
                    const today = new Date();
                    const oneWeekAgo = new Date();
                    oneWeekAgo.setDate(today.getDate() - 7);
                    const announcementDate = new Date(announcement.created_at);
                    matchesDate = announcementDate >= oneWeekAgo && announcementDate <= today;
                }
                else if (dateFilter === 'month') {
                    // This month filter
                    const today = new Date();
                    const oneMonthAgo = new Date();
                    oneMonthAgo.setMonth(today.getMonth() - 1);
                    const announcementDate = new Date(announcement.created_at);
                    matchesDate = announcementDate >= oneMonthAgo && announcementDate <= today;
                }
                else {
                    // Specific date
                    const announcementDate = new Date(announcement.created_at);
                    const filterDate = new Date(dateFilter);
                    matchesDate = 
                        announcementDate.getDate() === filterDate.getDate() &&
                        announcementDate.getMonth() === filterDate.getMonth() &&
                        announcementDate.getFullYear() === filterDate.getFullYear();
                }
            }
            
            // Category filter
            let matchesCategory = true;
            if (categoryFilter && categoryFilter !== 'all') {
                // Make sure to handle null or undefined category
                const announcementCategory = (announcement.category || '').toLowerCase();
                const filterCategoryLower = categoryFilter.toLowerCase();
                
                matchesCategory = announcementCategory === filterCategoryLower;
                
                // Debug log for category matching
                console.log('Checking announcement category:', {
                    id: announcement.announcement_id,
                    title: announcement.announcement_title,
                    category: announcementCategory,
                    filterCategory: filterCategoryLower,
                    matches: announcementCategory === filterCategoryLower
                });
            }

            const result = matchesSearch && matchesDate && matchesCategory;
            
            return result;
        });

        console.log('Filter results:', {
            totalAnnouncements: allAnnouncements.length,
            filteredCount: filtered.length,
            appliedFilters: {
                search: searchTerm,
                date: dateFilter,
                category: categoryFilter
            }
        });

        return filtered;
    }
    
    // Reset filters UI function
    function resetFiltersUI() {
        // Reset input fields
        $('#announcementSearch').val('');
        $('#dateFilter').val('');
        $('#categoryFilter').val('all');
        
        // Reset active classes on filter dropdowns
        $('.date-filter, .category-filter').removeClass('active');
        $('.date-filter[data-value=""], .category-filter[data-value="all"]').addClass('active');
    }
    
    // Clear filters function
    function clearFilters() {
        console.log('Clearing filters');
        
        // Reset UI
        resetFiltersUI();
        
        // Fetch fresh data from server
        const orgId = $('#announcements-tab').data('orgid');
        if (orgId) {
            fetchAnnouncements(orgId, currentProfilePhoto, currentAuthorName);
        } else {
            // If we can't fetch new data, use existing announcements
            renderAnnouncementsContent({ announcements: allAnnouncements });
        }
    }
    
    // Render announcements content
    function renderAnnouncementsContent(response) {
        const announcements = response.announcements || [];
        
        if (announcements.length === 0) {
            $('#announcements-content').html(renderEmptyState());
            return;
        }

        const content = `
            <div class="list-group">
                ${announcements.map(announcement => renderAnnouncementItem(announcement)).join('')}
            </div>`;
        
        $('#announcements-content').html(content);
    }
    
    // Render empty state
    function renderEmptyState() {
        return `
            <div class="text-center py-8">
                <div class="custom-alert">
                    <i class="bi bi-info-circle me-2" style="font-size: 2rem;"></i>
                    <p class="h4 mb-0">No announcements available at the moment.</p>
                </div>
            </div>`;
    }
    
    // Render announcement item
    function renderAnnouncementItem(announcement) {
        const categoryBadgeClass = getCategoryBadgeClass(announcement.category);
        const formattedDate = formatRelativeTime(new Date(announcement.created_at));
        const displayName = announcement.author_name || announcement.creator_name || 'Unknown Author';

        return `
            <div class="list-group-item bg-white rounded-lg shadow-sm p-4 mb-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="d-flex align-items-center">
                        <img src="${announcement.org_image ? 'uploaded/orgUploaded/' + announcement.org_image : 'default-profile.jpg'}" 
                            alt="Profile" 
                            class="rounded-circle border border-primary" 
                            style="width: 50px; height: 50px;">
                        <div class="ms-3">
                            <h5 class="mb-1">${displayName}</h5>
                            <small class="text-muted">${announcement.org_name || 'Unknown Organization'}</small>
                        </div>
                    </div>
                    <span class="badge ${categoryBadgeClass}">${announcement.category}</span>
                </div>
                <h4 class="mb-3">${announcement.announcement_title}</h4>
                <div class="announcement-content mb-3">
                    ${announcement.announcement_details}
                </div>
                ${renderAnnouncementImages(announcement)}
                <small class="text-muted">${formattedDate}</small>
            </div>`;
    }
    
    // Render announcement images
    function renderAnnouncementImages(announcement) {
        console.log('Rendering images for announcement:', announcement);
        console.log('Raw images:', announcement.images);

        if (!announcement.images) {
            console.log('No images found for announcement');
            return '';
        }

        // If the images are a string (comma-separated), convert to array
        const images = typeof announcement.images === 'string' 
            ? announcement.images.split(',').filter(img => img.trim() !== '')
            : Array.isArray(announcement.images) 
                ? announcement.images
                : [];

        console.log('Processed images array:', images);

        if (!images || images.length === 0) {
            console.log('No valid images after processing');
            return '';
        }

        // Create a carousel for multiple images
        const carouselId = `carousel-${announcement.announcement_id}`;
        console.log('Creating carousel with ID:', carouselId);

        const carouselItems = images.map((image, index) => {
            const imagePath = image.trim();
            console.log(`Processing image ${index + 1}:`, imagePath);
            return `
                <div class="carousel-item ${index === 0 ? 'active' : ''}" data-bs-interval="false">
                    <img src="uploaded/annUploaded/${imagePath}" 
                        class="d-block w-100 rounded" 
                        alt="Announcement Image ${index + 1}"
                        style="max-height: 400px; object-fit: contain;"
                        onerror="this.onerror=null; this.src='default-image.jpg'; console.error('Failed to load image:', this.src);">
                </div>
            `;
        }).join('');

        return `
            <div id="${carouselId}" class="carousel slide mb-3" data-bs-ride="carousel">
                <div class="carousel-inner">
                    ${carouselItems}
                </div>
                ${images.length > 1 ? `
                    <button class="carousel-control-prev" type="button" data-bs-target="#${carouselId}" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#${carouselId}" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                ` : ''}
                ${images.length > 1 ? `
                    <ol class="carousel-indicators">
                        ${images.map((_, index) => `
                            <li data-bs-target="#${carouselId}" 
                                data-bs-slide-to="${index}" 
                                class="${index === 0 ? 'active' : ''}">
                            </li>
                        `).join('')}
                    </ol>
                ` : ''}
            </div>`;
    }
    
    // Helper function to get badge class based on category
    function getCategoryBadgeClass(category) {
        if (!category) return 'bg-secondary';
        
        const categoryLower = category.toLowerCase();
        const classes = {
            'academic': 'bg-primary',
            'event': 'bg-success',
            'announcement': 'bg-info',
            'news': 'bg-warning',
            'org': 'bg-info',
            'general': 'bg-secondary'
        };
        return classes[categoryLower] || 'bg-secondary';
    }
    
    // Format relative time function
    function formatRelativeTime(date) {
        const now = new Date();
        const seconds = Math.floor((now - date) / 1000);

        if (seconds < 60) return seconds < 30 ? "just now" : seconds + " seconds ago";
        
        const minutes = Math.floor(seconds / 60);
        if (minutes < 60) return minutes + " minute" + (minutes > 1 ? "s" : "") + " ago";

        const hours = Math.floor(minutes / 60);
        if (hours < 24) return hours + " hour" + (hours > 1 ? "s" : "") + " ago";

        const days = Math.floor(hours / 24);
        if (days < 30) return days + " day" + (days > 1 ? "s" : "") + " ago";

        const months = Math.floor(days / 30);
        if (months < 12) return months + " month" + (months > 1 ? "s" : "") + " ago";

        const years = Math.floor(months / 12);
        return years + " year" + (years > 1 ? "s" : "") + " ago";
    }
    
    // EVENT LISTENERS
    // ---------------
    
    // Search input event listener
    $('#announcementSearch').on('input', function() {
        console.log('Search input changed:', $(this).val());
        const filtered = filterAnnouncements();
        renderAnnouncementsContent({ announcements: filtered });
    });
    
    // Date filter dropdown items
    $('.date-filter').on('click', function(e) {
        e.preventDefault();
        const value = $(this).data('value');
        console.log('Date filter clicked:', value);
        
        // Update hidden input value
        $('#dateFilter').val(value);
        
        // Update UI to show selected filter
        $('.date-filter').removeClass('active');
        $(this).addClass('active');
        
        // Apply filters
        const filtered = filterAnnouncements();
        renderAnnouncementsContent({ announcements: filtered });
    });
    
    // Category filter dropdown items
    $('.category-filter').on('click', function(e) {
        e.preventDefault();
        const value = $(this).data('value');
        console.log('Category filter clicked:', value);
        
        // Update hidden input value
        $('#categoryFilter').val(value);
        
        // Update UI to show selected filter
        $('.category-filter').removeClass('active');
        $(this).addClass('active');
        
        // Apply filters
        const filtered = filterAnnouncements();
        renderAnnouncementsContent({ announcements: filtered });
    });
    
    // Clear filters button
    $('#clearFilters').on('click', function(e) {
        e.preventDefault();
        console.log('Clear filters clicked');
        clearFilters();
    });
   function fetchMembers(orgId) {
    $.ajax({
        url: 'ajax/fetch_members.php',
        type: 'POST',
        dataType: 'json',
        data: { org_id: orgId },
        success: function (response) {
            if (response.error) {
                $('#members').html(`
                    <div class="text-red-600 p-4 text-center">
                        ${response.error}
                    </div>`
                );
                return;
            }
            renderMembersContent(response.members);
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error:', status, error);
            $('#members').html(`
                <div class="text-red-600 p-4 text-center">
                    An error occurred while fetching members. Please try again later.
                </div>`
            );
        }
    });
}
function renderMembersContent(members) {
            let membersContent = '<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">';
            
            if (members && members.length > 0) {
                members.forEach(function (member) {
                    membersContent += `
                        <div class="group">
                            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl">
                                <div class="relative">
                                    <div class="aspect-square" style="height: 250px;">
                                        <img src="uploaded/orgUploaded/${member.member_img}" 
                                            alt="${member.name}" 
                                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                                            onerror="this.src='path/to/default-avatar.jpg'">
                                    </div>
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                </div>
                                <div class="p-6 text-center">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-1 group-hover:text-blue-600 transition-colors duration-300">
                                        ${member.name}
                                    </h3>
                                    <p class="text-sm text-blue-600 font-medium">
                                        ${member.position}
                                    </p>
                                </div>
                            </div>
                        </div>`;
                });
            } else {
                membersContent = `
                    <div class="flex items-center justify-center p-8 col-span-full">
                        <div class="bg-amber-50 text-amber-800 px-6 py-4 rounded-lg flex items-center gap-3">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <span class="text-lg font-medium">No members found</span>
                        </div>
                    </div>`;
            }

            membersContent += '</div>';
            $('#members').html(membersContent);
        }
    function initializeCarousels() {
        $('.carousel').each(function() {
            new bootstrap.Carousel(this);
        });
    }   // Trigger the "Members" tab on click
        $('#members-tab').on('click', function () {
            // This will activate the 'members' tab when clicked
            $('#myTabs a[href="#members"]').tab('show');
        });

        // Trigger the "Announcements" tab on click
        $('#announcements-tab').on('click', function () {
            // This will activate the 'announcements' tab when clicked
            $('#myTabs a[href="#announcements"]').tab('show');
        });

                    // Remove only the color style from inline style attributes, leaving other styles and tags intact
// Remove only the color style from inline style attributes, leaving other styles and tags intact
function removeColorTags(content) {
    // Remove inline color styles while keeping other styles
    content = content.replace(/style="([^"]*?)\bcolor\s*:\s*[^;]+;?([^"]*?)"/g, (match, p1, p2) => {
        const remainingStyles = `${p1.trim()} ${p2.trim()}`.trim();
        return remainingStyles ? `style="${remainingStyles}"` : '';
    });



    // Apply a default color if no inline color is present
    content = content.replace(/<p(.*?)>/gi, '<p$1 style="color: black;">');
    content = content.replace(/<span(.*?)>/gi, '<span$1 style="color: black;">');

    return content;
}



                function formatRelativeTime(date) {
                    const now = new Date();
                    const seconds = Math.floor((now - date) / 1000);

                    if (seconds < 60) return seconds < 30 ? "just now" : seconds + " seconds ago";
                    
                    const minutes = Math.floor(seconds / 60);
                    if (minutes < 60) return minutes + " minute" + (minutes > 1 ? "s" : "") + " ago";

                    const hours = Math.floor(minutes / 60);
                    if (hours < 24) return hours + " hour" + (hours > 1 ? "s" : "") + " ago";

                    const days = Math.floor(hours / 24);
                    if (days < 30) return days + " day" + (days > 1 ? "s" : "") + " ago";

                    const months = Math.floor(days / 30);
                    if (months < 12) return months + " month" + (months > 1 ? "s" : "") + " ago";

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

// Fix modal layout issues
function adjustModalLayout() {
  const modal = document.getElementById('feedbackModal');
  if (modal) {
    const modalContent = modal.querySelector('.modal-content');
    const modalBody = modal.querySelector('.modal-body');
    const modalHeader = modal.querySelector('.modal-header');
    const modalFooter = modal.querySelector('.modal-footer');
    const progressSteps = modal.querySelector('.progress-steps');
    
    if (modalContent && modalBody) {
      // Reset any inline styles that might be causing issues
      modalContent.style.height = '';
      modalBody.style.maxHeight = `calc(90vh - ${modalHeader.offsetHeight + modalFooter.offsetHeight + progressSteps.offsetHeight}px)`;
    }
  }
}
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
});

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

    function openTab(event, tabName) {
        // Hide all tab contents
    // Select all .tab-content elements only within the #campusmap section
    const campusMapTabContents = document.querySelectorAll('#campusmap .tab-content');
    campusMapTabContents.forEach(content => {
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
    } function formatTimeAgo(dateString) {
        const created = new Date(dateString);
        const now = new Date();
        const diffInHours = Math.floor((now - created) / (1000 * 60 * 60));
        
        if (diffInHours >= 24) {
            return created.toLocaleDateString();
        } else if (diffInHours > 0) {
            return `${diffInHours} hours ago`;
        } else {
            const diffInMinutes = Math.floor((now - created) / (1000 * 60));
            return diffInMinutes > 0 ? `${diffInMinutes} minutes ago` : 'just now';
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('announcements-container');

        // Clear the container before appending new announcements
        container.innerHTML = '';

        const announcements = <?php echo json_encode($allAnnouncement); ?>;

        console.log("Announcements data:", announcements); // Log the data

        if (Array.isArray(announcements)) {
            // Sort announcements by created_at date in descending order (latest first)
            const sortedAnnouncements = announcements.sort((a, b) => {
                return new Date(b.created_at) - new Date(a.created_at);
            });

            sortedAnnouncements.forEach((announcement) => {
                console.log("Creating carousel for announcement:", announcement); // Log each announcement
                const carousel = createCarousel(announcement.announcement_images);
                container.appendChild(createAnnouncementDiv(announcement, carousel));
            });
        } else {
            container.innerHTML = `
                <div class="announcement-card">
                    <div class="card-content">
                        <div class="announcement-text">
                            ${announcements}
                        </div>
                    </div>
                </div>
            `;
        }
    });function createCarousel(images) {
        const container = document.createElement('div');
        container.className = 'carousel slide relative overflow-hidden';
        container.setAttribute('data-bs-ride', 'carousel');
        
        // Set a unique ID for each carousel to enable navigation buttons to work
        const carouselId = 'carousel-' + Math.floor(Math.random() * 1000); // Unique ID for each carousel
        container.setAttribute('id', carouselId); // Assign unique ID to the container

        const inner = document.createElement('div');
        inner.className = 'carousel-inner relative w-full';

        images.forEach((image, index) => {
            const item = document.createElement('div');
            item.className = 'carousel-item ' + (index === 0 ? 'active' : '');

            const img = document.createElement('img');
            img.src = `uploaded/annUploaded/${image}`;
            img.className = 'd-block w-full object-cover max-h-64 rounded-lg shadow-lg'; // Fixed height with cover for cropping
            img.style.objectFit = 'contain'; // Ensure the image is fully visible (no cropping)
            img.style.height = '300px'; // Fixed height, adjust as necessary
            img.alt = 'Announcement Image';

            item.appendChild(img);
            inner.appendChild(item);
        });

        // Previous Button (Black background)
        const prevButton = document.createElement('button');
        prevButton.className = 'carousel-control-prev absolute top-1/2 left-0 z-10 bg-black text-white p-2 rounded-full transform -translate-y-1/2';
        prevButton.setAttribute('type', 'button');
        prevButton.setAttribute('data-bs-target', `#${carouselId}`); // Use the unique ID
        prevButton.setAttribute('data-bs-slide', 'prev');

        const prevIcon = document.createElement('span');
        prevIcon.className = 'carousel-control-prev-icon';
        prevButton.appendChild(prevIcon);

        // Next Button (Black background)
        const nextButton = document.createElement('button');
        nextButton.className = 'carousel-control-next absolute top-1/2 right-0 z-10 bg-black text-white p-2 rounded-full transform -translate-y-1/2';
        nextButton.setAttribute('type', 'button');
        nextButton.setAttribute('data-bs-target', `#${carouselId}`); // Use the unique ID
        nextButton.setAttribute('data-bs-slide', 'next');

        const nextIcon = document.createElement('span');
        nextIcon.className = 'carousel-control-next-icon';
        nextButton.appendChild(nextIcon);

        // Append inner carousel and buttons
        container.appendChild(inner);
        container.appendChild(prevButton);
        container.appendChild(nextButton);

        // Initialize the carousel using Bootstrap's JavaScript with automatic sliding every 3 seconds
        const bootstrapCarousel = new bootstrap.Carousel(container, {
            interval: 3000 // Set to 2000 milliseconds (2 seconds)
        });

        return container;
    }


    function createAnnouncementDiv(announcement, carousel) {
        const div = document.createElement('div');
        div.className = 'announcement-item bg-white rounded-lg shadow-lg p-6 space-y-4 hover:shadow-xl transition-shadow duration-300';

        const title = document.createElement('h2');
        title.textContent = `${announcement.org_name} - ${announcement.creator_name}`;
        title.className = 'text-2xl font-bold text-gray-800';
        div.appendChild(title);

        const orgImage = document.createElement('img');
        orgImage.src = `uploaded/orgUploaded/${announcement.org_image}`;
        orgImage.alt = 'Organization Image';
        orgImage.className = 'w-16 h-16 rounded-full object-cover';
        div.appendChild(orgImage);

        const announcementDetails = document.createElement('p');
        announcementDetails.textContent = announcement.announcement_details;
        announcementDetails.className = 'text-gray-600 text-sm';
        div.appendChild(announcementDetails);

        const timeAgo = document.createElement('span');
        timeAgo.className = 'text-xs text-gray-500';
        timeAgo.textContent = formatTimeAgo(announcement.created_at);
        div.appendChild(timeAgo);

        div.appendChild(carousel);

        return div;
    }

    function toggleDetails(link) {
        const textElement = link.previousElementSibling;
        const isExpanded = !textElement.classList.contains('truncated');
        
        textElement.classList.toggle('truncated');
        link.textContent = isExpanded ? 'See more...' : 'See less...';
    }


    </script>

    <script>
    // Format relative time
    function formatRelativeTime(date) {
        const now = new Date();
        const seconds = Math.floor((now - date) / 1000);

        if (seconds < 60) return seconds < 30 ? "just now" : seconds + " seconds ago";
        
        const minutes = Math.floor(seconds / 60);
        if (minutes < 60) return minutes + " minute" + (minutes > 1 ? "s" : "") + " ago";

        const hours = Math.floor(minutes / 60);
        if (hours < 24) return hours + " hour" + (hours > 1 ? "s" : "") + " ago";

        const days = Math.floor(hours / 24);
        if (days < 30) return days + " day" + (days > 1 ? "s" : "") + " ago";

        const months = Math.floor(days / 30);
        if (months < 12) return months + " month" + (months > 1 ? "s" : "") + " ago";

        const years = Math.floor(months / 12);
        return years + " year" + (years > 1 ? "s" : "") + " ago";
    }

    // Convert PHP time to JS Date object and format it
    document.addEventListener('DOMContentLoaded', function () {
        const announcementTimes = <?php echo json_encode(array_column($allAnnouncement, 'created_at')); ?>;
        announcementTimes.forEach((timestamp, index) => {
            const date = new Date(timestamp);
            const relativeTime = formatRelativeTime(date);
            document.getElementById(`time-<?php echo $announcement['announcement_id']; ?>`).textContent = relativeTime;
        });
    });
    </script>
    <script>
    let currentImageSet = [];
    let currentImageIndex = 0;
    let currentAnnouncementId = null;

    function openModal(imgElement, announcementId) {
        const modal = document.getElementById('imageModal');
        const modalImg = modal.querySelector('.modal-img');
        const carousel = document.getElementById(`carousel-${announcementId}`);
        
        currentImageSet = Array.from(carousel.querySelectorAll('.carousel-item img')).map(img => img.src);
        currentAnnouncementId = announcementId;
        currentImageIndex = parseInt(imgElement.closest('.carousel-item').dataset.imageIndex);
        
        modal.style.display = 'block';
        modalImg.src = imgElement.src;
        updateModalNavigation();
        
        // Disable body scroll when modal is open
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('imageModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    function changeImage(direction) {
        currentImageIndex += direction;
        if (currentImageIndex >= currentImageSet.length) currentImageIndex = 0;
        if (currentImageIndex < 0) currentImageIndex = currentImageSet.length - 1;
        
        const modalImg = document.querySelector('.modal-img');
        modalImg.src = currentImageSet[currentImageIndex];
        
        const carousel = document.getElementById(`carousel-${currentAnnouncementId}`);
        if (carousel) {
            const carouselInstance = bootstrap.Carousel.getInstance(carousel);
            if (carouselInstance) {
                carouselInstance.to(currentImageIndex);
            }
        }
        
        updateModalNavigation();
    }

    function updateModalNavigation() {
        const prevBtn = document.querySelector('.modal-prev');
        const nextBtn = document.querySelector('.modal-next');
        
        if (currentImageSet.length <= 1) {
            prevBtn.style.display = 'none';
            nextBtn.style.display = 'none';
        } else {
            prevBtn.style.display = 'flex';
            nextBtn.style.display = 'flex';
        }
    }

    // Event Listeners
    document.querySelector('.close-modal').onclick = closeModal;
    document.querySelector('.modal-prev').onclick = () => changeImage(-1);
    document.querySelector('.modal-next').onclick = () => changeImage(1);

    document.getElementById('imageModal').onclick = function(e) {
        if (e.target === this) closeModal();
    };

    document.addEventListener('keydown', function(e) {
        if (document.getElementById('imageModal').style.display === 'none') return;
        
        if (e.key === 'Escape') closeModal();
        if (e.key === 'ArrowLeft') changeImage(-1);
        if (e.key === 'ArrowRight') changeImage(1);
    });

    // Toggle announcement details
    function toggleDetails(announcementId) {
        const textElement = document.getElementById(`text-${announcementId}`);
        textElement.classList.toggle('truncate-text');
        const button = textElement.nextElementSibling;
        button.textContent = textElement.classList.contains('truncate-text') ? 'See more...' : 'See less';
    }

    
// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
  // Modify the existing nav-link click handlers
  const navLinks = document.querySelectorAll('.nav-link, .navbar-nav .nav-link');
  
  navLinks.forEach(link => {
    // First remove any existing handlers to prevent duplicates
    const oldClone = link.cloneNode(true);
    link.parentNode.replaceChild(oldClone, link);
    
    // Add our improved click handler
    oldClone.addEventListener('click', function(e) {
      e.preventDefault();
      
      // Get the target section id from the href attribute
      const targetId = this.getAttribute('href');
      
      // Only proceed if it's a section link
      if (targetId && targetId.startsWith('#') && targetId.length > 1) {
        const targetSection = document.querySelector(targetId);
        
        if (targetSection) {
          // Add animation class to the clicked link
          this.classList.add('nav-link-clicked');
          
          // Remove the class after animation completes
          setTimeout(() => {
            this.classList.remove('nav-link-clicked');
          }, 500);
          
          // Smooth scroll to the target section
          window.scrollTo({
            top: targetSection.offsetTop - 70, // Adjust for fixed headers
            behavior: 'smooth'
          });
          
          // Update the browser history so back/forward navigation works
          history.pushState(null, null, targetId);
          
          // THIS IS THE KEY ADDITION - Reinitialize the target section's animations
          setTimeout(() => {
            // Reset the section to initial state
            targetSection.style.opacity = '0';
            targetSection.style.transform = 'translateY(30px)';
            
            // Force a reflow
            void targetSection.offsetWidth;
            
            // Trigger reanimation
            targetSection.style.opacity = '1';
            targetSection.style.transform = 'translateY(0)';
            
            // Reset and reinitialize child elements
            const animatableElements = targetSection.querySelectorAll('.section-heading, h3, .card, .member, .announcement-item, .floor-table, .stat-card, .strategy-card');
            
            animatableElements.forEach((element, index) => {
              // Reset to initial state
              element.style.opacity = '0';
              element.style.transform = 'translateY(20px)';
              
              // Force a reflow
              void element.offsetWidth;
              
              // Retrigger animation with staggered timing
              setTimeout(() => {
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
              }, 100 + (index * 50));
            });
            
            // Reinitialize specific section animations based on the target
            switch(targetId) {
              case '#announcements':
                initializeAnnouncementItems();
                break;
              case '#schoolcalendar':
                initializeCalendarSection();
                break;
              case '#campusmap':
                initializeCampusMapSection();
                break;
              case '#facultymembers':
                initializeFacultySection();
                break;
              case '#campusorgs':
                initializeCampusOrgsSection();
                break;
              case '#faqs':
                initializeFAQsSection();
                break;
              case '#feed':
                initializeFeedbackSection();
                break;
              case '#aboutus':
                initializeAboutSection();
                break;
            }
          }, 600);
        }
      }
    });
  });
  
  // Simple re-initialization functions for each section
  function initializeAnnouncementItems() {
    const items = document.querySelectorAll('.announcement-item');
    items.forEach((item, index) => {
      item.style.opacity = '0';
      item.style.transform = 'translateY(30px)';
      
      setTimeout(() => {
        item.style.opacity = '1';
        item.style.transform = 'translateY(0)';
      }, 100 + (index * 150));
    });
  }
  
  function initializeCalendarSection() {
    const calendarView = document.querySelector('[id^="calendarDays"]');
    if (calendarView) {
      calendarView.style.opacity = '0';
      calendarView.style.transform = 'scale(0.95)';
      
      setTimeout(() => {
        calendarView.style.opacity = '1';
        calendarView.style.transform = 'scale(1)';
        
        const dayCells = calendarView.querySelectorAll('div');
        dayCells.forEach((cell, index) => {
          cell.style.opacity = '0';
          cell.style.transform = 'scale(0.8)';
          
          setTimeout(() => {
            cell.style.opacity = '1';
            cell.style.transform = 'scale(1)';
          }, 300 + (index * 20));
        });
      }, 300);
    }
  }
  
  function initializeCampusMapSection() {
    const mapContainer = document.querySelector('#campusmap .table-container');
    if (mapContainer) {
      mapContainer.style.opacity = '0';
      mapContainer.style.transform = 'scale(0.95)';
      
      setTimeout(() => {
        mapContainer.style.opacity = '1';
        mapContainer.style.transform = 'scale(1)';
        
        const cells = document.querySelectorAll('.floor-table td');
        cells.forEach((cell, index) => {
          cell.style.opacity = '0';
          cell.style.transform = 'scale(0.9)';
          
          setTimeout(() => {
            cell.style.opacity = '1';
            cell.style.transform = 'scale(1)';
          }, 500 + (index * 10));
        });
      }, 300);
    }
  }
  
  function initializeFacultySection() {
    const members = document.querySelectorAll('.member');
    members.forEach((member, index) => {
      member.style.opacity = '0';
      member.style.transform = 'scale(0.8)';
      
      setTimeout(() => {
        member.style.opacity = '1';
        member.style.transform = 'scale(1)';
      }, 300 + (index * 50));
    });
  }
  
  function initializeCampusOrgsSection() {
    const cards = document.querySelectorAll('#campusorgs .card');
    cards.forEach((card, index) => {
      card.style.opacity = '0';
      card.style.transform = 'translateY(30px)';
      
      setTimeout(() => {
        card.style.opacity = '1';
        card.style.transform = 'translateY(0)';
      }, 300 + (index * 50));
    });
  }
  
  function initializeFAQsSection() {
    const items = document.querySelectorAll('#faqs .accordion-item');
    items.forEach((item, index) => {
      item.style.opacity = '0';
      item.style.transform = 'translateY(20px)';
      
      setTimeout(() => {
        item.style.opacity = '1';
        item.style.transform = 'translateY(0)';
      }, 300 + (index * 100));
    });
  }
  
  function initializeFeedbackSection() {
    const cards = document.querySelectorAll('#feed .stat-card, #feed .feedback-card');
    cards.forEach((card, index) => {
      card.style.opacity = '0';
      card.style.transform = index < cards.length - 1 ? 'translateY(40px)' : 'scale(0.95)';
      
      setTimeout(() => {
        card.style.opacity = '1';
        card.style.transform = index < cards.length - 1 ? 'translateY(0)' : 'scale(1)';
      }, 300 + (index * 150));
    });
  }
  
  function initializeAboutSection() {
    const elements = document.querySelectorAll('#aboutus .about-card, #aboutus .strategy-card');
    elements.forEach((element, index) => {
      element.style.opacity = '0';
      element.style.transform = 'translateY(30px)';
      
      setTimeout(() => {
        element.style.opacity = '1';
        element.style.transform = 'translateY(0)';
      }, 300 + (index * 150));
    });
  }
});

    </script>

    </body>

    </html> 
