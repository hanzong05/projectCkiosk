<?php
include_once ("class/mainClass.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$obj = new mainClass();
$allAnnouncement = $obj->show_announcement2();
$allIt = $obj->show_allIt(1);            // IT members or data for some purpose
$allItHeads = $obj->show_allItHeads(10);  // IT heads data
$allCs = $obj->show_allcs(3);            // CS members or data
$allCsHeads = $obj->show_allCsHeads(12);  // CS heads data
$allIs = $obj->show_allis(2);            // IS members or data
$allIsHeads = $obj->show_allIsHeads(11);  // IS heads data
$allMit = $obj->show_allmit(13);         // MIT members or data
$allMitHeads = $obj->show_allMitHeads(13);
$showfaqs = $obj->show_allFAQS();
$allOrg = $obj->show_org();

$allEvent = $obj->show_eventsByMonth();

?>
<!DOCTYPE html>
<html>

<head><meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>Campus Kiosk</title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">

<!-- Tailwind CSS -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.2.4/dist/tailwind.min.css" rel="stylesheet">

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
    <style>/* Make sure the text doesn't overflow */
.feedback-section * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
}

.feedback-section {
    background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
    min-height: 100vh;
    padding: 2rem;
}

.feedback-section .feedback-container {
    max-width: 1200px;
    margin: 0 auto;
}

.feedback-section .header {
    text-align: center;
    margin-bottom: 3rem;
    padding: 2rem;
}

.feedback-section .header h1 {
    font-size: 3rem;
    color: #1f2937;
    margin-bottom: 1rem;
    animation: fadeIn 0.8s ease-out;
}

.feedback-section .header p {
    color: #4b5563;
    font-size: 1.2rem;
}

.feedback-section .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.feedback-section .stat-card {
    background: white;
    padding: 1.5rem;
    border-radius: 1rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    display: flex;
    align-items: center;
    transition: transform 0.2s ease;
}

.feedback-section .stat-card:hover {
    transform: translateY(-5px);
}

.feedback-section .stat-icon {
    width: 48px;
    height: 48px;
    background: #e0e7ff;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
}

.feedback-section .stat-info h3 {
    color: #4b5563;
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
}

.feedback-section .stat-info p {
    color: #1f2937;
    font-size: 1.5rem;
    font-weight: bold;
}

.feedback-section .main-card {
    background: white;
    border-radius: 1.5rem;
    padding: 2rem;
    box-shadow: 0 10px 15px rgba(0, 0, 0, 0.05);
}

.feedback-section .card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.feedback-section .submit-btn {
    background: #4f46e5;
    color: white;
    border: none;
    padding: 1rem 2rem;
    border-radius: 0.75rem;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.feedback-section .submit-btn:hover {
    background: #4338ca;
    transform: scale(1.05);
}

.feedback-section .feedback-list {
    max-height: 500px;
    overflow-y: auto;
    margin-bottom: 2rem;
}

.feedback-section .feedback-item {
    background: #f9fafb;
    padding: 1.5rem;
    border-radius: 1rem;
    margin-bottom: 1rem;
    transition: all 0.2s ease;
}

.feedback-section .feedback-item:hover {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

.feedback-section .feedback-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.feedback-section .user-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.feedback-section .avatar {
    width: 40px;
    height: 40px;
    background: #e0e7ff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: #4f46e5;
}

.feedback-section .rating {
    color: #eab308;
    font-size: 1.2rem;
}

.feedback-section .feedback-content {
    color: #4b5563;
    line-height: 1.6;
}

.feedback-section .footer {
    border-top: 1px solid #e5e7eb;
    margin-top: 2rem;
    padding-top: 2rem;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
    text-align: center;
}

.feedback-section .footer-stat h4 {
    color: #4b5563;
    margin-bottom: 0.5rem;
}

.feedback-section .footer-stat p {
    font-size: 1.5rem;
    font-weight: bold;
    color: #4f46e5;
}

.feedback-section @keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Scrollbar Styling */
.feedback-section .feedback-list::-webkit-scrollbar {
    width: 8px;
}

.feedback-section .feedback-list::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.feedback-section .feedback-list::-webkit-scrollbar-thumb {
    background: #c7c7c7;
    border-radius: 4px;
}

.feedback-section .feedback-list::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

@media (max-width: 768px) {
    .feedback-section .stats-grid {
        grid-template-columns: 1fr;
    }

    .feedback-section .footer {
        grid-template-columns: 1fr;
    }

    .feedback-section .header h1 {
        font-size: 2rem;
    }
}

.event-details {
    word-wrap: break-word;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Responsive adjustments for the event grid and cards */
@media (max-width: 1024px) {
    .event-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 16px;
    }
    
    .event-card {
        padding: 16px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .event-date {
        font-size: 1.2rem;
        font-weight: bold;
        margin-bottom: 12px;
    }

    .event-details {
        font-size: 0.9rem;
    }

    .event-section h4 {
        font-size: 1.4rem;
        margin-bottom: 20px;
    }
}

@media (max-width: 768px) {
    .event-date {
        font-size: 1rem;
    }

    .event-details {
        font-size: 0.85rem;
    }

    .event-section h4 {
        font-size: 1.2rem;
    }

    .tabs-content {
        padding: 16px;
    }
}

@media (max-width: 480px) {
    .event-date {
        font-size: 1rem;
    }

    .event-details {
        font-size: 0.8rem;
    }

    .event-card {
        padding: 12px;
    }
}

       .content-line {
    width: 100%; /* Adjust the width of the line (can be modified) */
    margin: 10px auto; /* Center the line and add space around it */
}
        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .modal-header {
            background: linear-gradient(135deg, #6366f1, #b8b5bd);
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 1.5rem;
        }

        .modal-title {
            font-weight: 600;
            margin: 0;
        }

        .progress-steps {
            display: flex;
            justify-content: center;
            padding: 1.5rem 0;
            background-color: #f8f9fa;
        }

        .step-indicator {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 1rem;
            position: relative;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .step-indicator.active {
            background-color: #6366f1;
            color: white;
        }

        .step-indicator:not(:last-child)::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 3px;
            background-color: #e9ecef;
            right: -100%;
            top: 50%;
            transform: translateY(-50%);
        }

        .emoji-rating {
            display: flex;
            justify-content: space-around;
            padding: 2rem 0;
        }

        .emoji-select {
            font-size: 2.5rem;
            cursor: pointer;
            transition: transform 0.2s;
            opacity: 0.5;
        }

        .emoji-select:hover {
            transform: scale(1.2);
            opacity: 1;
        }

        .emoji-select.selected {
            opacity: 1;
            transform: scale(1.1);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 500;
            color: #4b5563;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border-radius: 8px;
            padding: 0.75rem;
            border: 1px solid #e5e7eb;
        }

        .form-control:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .radio-group {
            display: grid;
            gap: 0.75rem;
            padding: 0.5rem 0;
        }

        .radio-option {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            border-radius: 8px;
            background-color: #f8f9fa;
            cursor: pointer;
            transition: all 0.2s;
        }

        .radio-option:hover {
            background-color: #e9ecef;
        }

        .radio-option input {
            margin-right: 0.75rem;
        }

        .step {
            display: none;
            animation: fadeIn 0.5s ease;
        }

        .step.active {
            display: block;
        }

        .modal-footer {
            border-top: 1px solid #e5e7eb;
            padding: 1.25rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-primary {
            background-color: #6366f1;
            border-color: #6366f1;
        }

        .btn-primary:hover {
            background-color: #4f46e5;
            border-color: #4f46e5;
        }

        .btn-success {
            background-color: #10b981;
            border-color: #10b981;
        }

        .btn-success:hover {
            background-color: #059669;
            border-color: #059669;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    <style> .image-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.9);
    z-index: 1000;
    overflow: hidden;
}

.modal-img {
    max-width: 90%;
    max-height: 90vh;
    object-fit: contain;
    border-radius: 4px;
}

.close-modal {
    position: absolute;
    top: 15px;
    right: 25px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
    z-index: 1001;
}

.close-modal:hover {
    color: #fef08a;
}

.modal-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    padding: 16px;
    color: white;
    font-weight: bold;
    font-size: 24px;
    cursor: pointer;
    background-color: rgba(0, 0, 0, 0.5);
    border-radius: 50%;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background-color 0.3s ease;
}

.modal-nav:hover {
    background-color: rgba(0, 0, 0, 0.8);
}

.modal-prev { left: 20px; }
.modal-next { right: 20px; }

.carousel-item img {
    cursor: pointer;
    transition: opacity 0.3s ease;
}

.carousel-item img:hover {
    opacity: 0.9;
}
.page-header {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    padding: 4rem 0;
    margin-bottom: 3rem;
    position: relative;
    overflow: hidden;
    text-align: center;
    color: white;
}
/* Announcement Container Colors and Styling */
.outer-announcement-container {
    background: linear-gradient(to bottom, #fefce8, #fff);
    border: 1px solid #fef08a;
}

.announcement-container {
    background-color: #fef08a;
    border: 1px solid;
    max-height: 700px; /* Adjust this value as needed */
    overflow-y: auto;
}


/* Carousel Container Styling */
.carousel-container {
    position: relative;
    height: max-content;
    width: 100%;
    max-width: 100%;
    height: auto;
    margin: 1rem 0;
    background-color: #fafafa;
    border-radius: 0.5rem;
}

/* Carousel Image Styling */
.carousel-item {
    width: 100%;
    max-height: 100%;
    height: auto;
}

.carousel-item img {
    width: 100%;
    height: 400px;
    object-fit: cover;
    border-radius: 0.5rem;
}

/* Carousel Controls */
.carousel-control-prev,
.carousel-control-next {
    width: 40px;
    height: 40px;
    background-color: rgba(0, 0, 0, 0.5);
    border-radius: 50%;
    top: 50%;
    transform: translateY(-50%);
}

.carousel-control-prev:hover,
.carousel-control-next:hover {
    background-color: rgba(0, 0, 0, 0.7);
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
    width: 20px;
    height: 20px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .carousel-container {
        height: 250px;
    }
    
    .carousel-item {
        height: 250px;
    }
}

@media (max-width: 480px) {
    .carousel-container {
        height: 200px;
    }
    
    .carousel-item {
        height: 200px;
    }
}

/* Enhanced announcement content styling */
.announcement-content {
    background-color: white;
    padding: 1rem;
    border-radius: 0.5rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.announcement-content p {
    color: #4b5563;
    line-height: 1.5;
}

/* Organization header enhanced styling */
.announcement-header {
    background-color: white;
    padding: 1rem;
    border-radius: 0.5rem 0.5rem 0 0;
    border-bottom: 2px solid #fef08a;
}

.announcement-header h3 {
    color: #854d0e;
}

.announcement-header p {
    color: #92400e;
}
/* Announcement Header Styling */
.announcement-header {
    display: flex;
    align-items: center;
    margin-bottom: 1.5rem; /* Adjusted for better spacing */
}

/* Organization Image Styling */
.org-image {
    width: 3.5rem; /* 56px */
    height: 3.5rem; /* 56px */
    border-radius: 50%;
    object-fit: cover;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Spacing between the image and the text */
.announcement-header .ml-6 { /* Increased margin-left for more space */
    margin-left: 1.5rem; /* 24px */
}

/* Text Styling */
.announcement-header h3 {
    font-size: 1.125rem; /* 18px */
    color: #333; /* Darker color for better readability */
    font-weight: 600;
    margin-bottom: 0.25rem; /* Small space below the name */
}

.announcement-header p {
    font-size: 0.875rem; /* 14px */
    color: #6B7280; /* Light gray */
    margin-top: 0.25rem;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .org-image {
        width: 3rem; /* 48px */
        height: 3rem; /* 48px */
    }

    .announcement-header h3 {
        font-size: 1rem; /* 16px */
    }

    .announcement-header p {
        font-size: 0.75rem; /* 12px */
    }
}


.page-header h1 {
    font-size: 2.5rem;
    font-weight: 700;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
}

.page-header p {
    font-size: 1rem;
    font-weight: 500;
    color: rgba(255, 255, 255, 0.75);
}

/* Announcement Cards */
.announcement-card {
    background: #2e0f13;
    border-radius: 1rem;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    margin-bottom: 2rem;
    overflow: hidden;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.announcement-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 16px 30px rgba(0, 0, 0, 0.2);
}

/* Header Section */
.card-header {
    padding: 1.5rem;
    border-bottom: 2px solid #f3f4f6;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.org-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.header-content h3 {
    margin: 0;
    color: #333;
    font-weight: 600;
    font-size: 1.2rem;
}

.header-meta {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #777;
    font-size: 0.9rem;
    margin-top: 0.25rem;
}.carousel-wrapper {
    position: relative;
    background: #2e0f13;
    border-radius: 1rem;
    padding: 1rem;
}



.carousel-control-prev, .carousel-control-next {
    background: rgba(0, 0, 0, 0.3);
    border-radius: 50%;
    width: 40px;
    height: 40px;
    top: 50%;
    transform: translateY(-50%);
    margin: 0 1rem;
}

/* Content Section */
.announcement-content {
    padding: 1.5rem;
    background: #fafafa;
    border-radius: 1rem;
}

.announcement-text {
    color: #555;
    line-height: 1.6;
    margin-bottom: 1.5rem;
    font-size: 1rem;
}

/* Truncate Text */
.truncate-text {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Read More Button */
.read-more-btn {
    color: #f59e0b;
    font-weight: 600;
    cursor: pointer;
    transition: color 0.3s ease;
    border: none;
    background: none;
    padding: 0;
    font-size: 1rem;
}

.read-more-btn:hover {
    color: #d97706;
}

/* Footer Section */
.card-footer {
    padding: 1rem 1.5rem;
    border-top: 2px solid #f3f4f6;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.timestamp {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #888;
    font-size: 0.9rem;
}

.timestamp svg {
    width: 16px;
    height: 16px;
    opacity: 0.7;
}

/* Interaction Buttons */
.interaction-buttons {
    display: flex;
    gap: 1rem;
}

.interaction-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #777;
    font-size: 0.9rem;
    cursor: pointer;
    transition: color 0.3s ease;
}

.interaction-btn:hover {
    color: #f59e0b;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: #fff;
    border-radius: 1rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.empty-state svg {
    width: 64px;
    height: 64px;
    color: #d1d5db;
    margin-bottom: 1.5rem;
}

/* Media Queries */
@media (max-width: 768px) {
    .announcement-card {
        margin: 1rem;
    }

    .carousel-item img {
        height: 300px;
    }

    .card-header {
        padding: 1rem;
    }

    .announcement-content {
        padding: 1rem;
    }
}

    </style>
</head>

<body>


    <nav class="navbar navbar-expand-lg navbar-light bg-light d-lg-none">
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
include_once("class/connection.php");

function getAllAnnouncements($connection) {
    $query = "
        SELECT a.*, 
            u.users_username AS author_name, 
            COALESCE(c.users_username, o.username, 'Unknown Creator') AS creator_name, 
            org.org_name, 
            org.org_image,
            GROUP_CONCAT(ai.image_path) AS announcement_images
        FROM announcement_tbl a 
        LEFT JOIN users_tbl u ON a.announcement_creator = u.users_id 
        LEFT JOIN users_tbl c ON a.created_by = c.users_id  
        LEFT JOIN orgmembers_tbl o ON a.created_by = o.id  
        LEFT JOIN organization_tbl org ON u.users_org = org.org_id  
        LEFT JOIN announcement_images ai ON a.announcement_id = ai.announcement_id
        WHERE a.is_archived = 0
        GROUP BY a.announcement_id
        ORDER BY a.created_at DESC  -- Order by the creation date (latest first)
    ";

    try {
        $statement = $connection->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as &$row) {
            $row['org_image'] = !empty($row['org_image']) ? htmlspecialchars($row['org_image'], ENT_QUOTES, 'UTF-8') : 'default_org_image.jpg';
            $row['announcement_images'] = !empty($row['announcement_images']) ? explode(',', $row['announcement_images']) : [];
            $row['creator_name'] = !empty($row['creator_name']) ? htmlspecialchars($row['creator_name'], ENT_QUOTES, 'UTF-8') : 'Unknown Creator';
            $row['org_name'] = !empty($row['org_name']) ? htmlspecialchars($row['org_name'], ENT_QUOTES, 'UTF-8') : 'Unknown Organization';
            $row['announcement_details'] = $row['announcement_details'] ?? '';
        }

        return $result;
    } catch (PDOException $e) {
        return "Error: " . $e->getMessage();
    }
}

$allAnnouncement = getAllAnnouncements($connect);
?>

<section id="announcement"class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-yellow-600 mb-2">
            <span class="relative">
                <span class="absolute inset-0 transform translate-x-1 translate-y-1 bg-yellow-200 rounded"></span>
                <span class="relative">ANNOUNCEMENTS</span>
            </span>
        </h1>
        <p class="text-gray-600 text-sm">Stay updated with the latest news and events</p>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="image-modal" style="display: none;">
        <span class="close-modal">&times;</span>
        <div class="modal-content">
            <img class="modal-img" src="" alt="Full size image">
            <button class="modal-nav modal-prev">&lt;</button>
            <button class="modal-nav modal-next">&gt;</button>
        </div>
    </div>

    <!-- Announcement Container -->
    <div class="outer-announcement-container max-w-lg mx-auto px-4 py-4  rounded-lg shadow-md">
        <div class="announcement-container mx-auto max-w-sm bg-gray-50 p-4 bg-[#2e0f13] rounded-md shadow">
            <div class="grid grid-cols-1 gap-4">
                <?php if (empty($allAnnouncement)): ?>
                    <div class="empty-state col-span-full text-center">
                        <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <h3 class="mt-2 text-xs font-medium text-gray-900">No announcements</h3>
                        <p class="mt-1 text-xs text-gray-500">Please check back later.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($allAnnouncement as $announcement): ?>
                        <div class="announcement-item bg-white rounded-lg shadow-sm p-4 mb-4">
                            <!-- Organization Header -->
                            <div class="announcement-header flex items-center mb-4">
                                <img src="/ckiosk/uploaded/orgUploaded/<?php echo htmlspecialchars($announcement['org_image']); ?>" 
                                     alt="<?php echo htmlspecialchars($announcement['org_name']); ?>" 
                                     class="org-image w-14 h-14 md:w-16 md:h-16 lg:w-20 lg:h-20 rounded-full object-cover">
                                <div class="ml-6">
                                    <h3 class="font-semibold text-lg text-gray-800"><?php echo htmlspecialchars($announcement['org_name']); ?></h3>
                                    <p class="text-sm text-gray-500">Posted by <?php echo htmlspecialchars($announcement['creator_name']); ?></p>
                                </div>
                            </div>

                            <!-- Carousel/Images -->
                            <?php if (!empty($announcement['announcement_images'])): ?>
                                <div class="carousel-container mb-4">
                                    <div id="carousel-<?php echo $announcement['announcement_id']; ?>" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            <?php foreach ($announcement['announcement_images'] as $index => $image): ?>
                                                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>" 
                                                     data-image-index="<?php echo $index; ?>">
                                                    <img src="uploaded/annUploaded/<?php echo htmlspecialchars($image); ?>" 
                                                         alt="Announcement image"
                                                         onclick="openModal(this, <?php echo $announcement['announcement_id']; ?>)"
                                                         class="cursor-pointer hover:opacity-90 transition-opacity">
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <?php if (count($announcement['announcement_images']) > 1): ?>
                                            <button class="carousel-control-prev" type="button" 
                                                    data-bs-target="#carousel-<?php echo $announcement['announcement_id']; ?>" 
                                                    data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            </button>
                                            <button class="carousel-control-next" type="button" 
                                                    data-bs-target="#carousel-<?php echo $announcement['announcement_id']; ?>" 
                                                    data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Announcement Content -->
                            <div class="announcement-content">
                                <p class="text-gray-600 text-sm mb-2 truncate-text" id="text-<?php echo $announcement['announcement_id']; ?>">
                                   <?php echo nl2br(htmlspecialchars(strip_tags($announcement['announcement_details']))); ?>
                                </p>
                                <?php if (strlen($announcement['announcement_details']) > 150): ?>
                                    <button onclick="toggleDetails(<?php echo $announcement['announcement_id']; ?>)" 
                                            class="text-yellow-600 hover:text-yellow-700 text-xs font-medium">
                                        See more...
                                    </button>
                                <?php endif; ?>
                                <div class="flex justify-between items-center mt-2">
                                    <span class="text-xs text-gray-500" id="time-<?php echo $announcement['announcement_id']; ?>">
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                const timeElement = document.getElementById("time-<?php echo $announcement['announcement_id']; ?>");
                                                const createdAt = "<?php echo $announcement['created_at']; ?>"; // PHP Date Format

                                                timeElement.textContent = formatRelativeTime(createdAt);
                                            });

                                            function formatRelativeTime(dateString) {
                                                const now = new Date();
                                                const date = new Date(dateString);
                                                const diffInSeconds = Math.floor((now - date) / 1000);
                                                const diffInMinutes = Math.floor(diffInSeconds / 60);
                                                const diffInHours = Math.floor(diffInMinutes / 60);
                                                const diffInDays = Math.floor(diffInHours / 24);

                                                if (diffInSeconds < 60) return `${diffInSeconds} seconds ago`;
                                                if (diffInMinutes < 60) return `${diffInMinutes} minutes ago`;
                                                if (diffInHours < 24) return `${diffInHours} hours ago`;
                                                return `${diffInDays} days ago`;
                                            }
                                        </script>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>


<section id="schoolcalendar" class="content-section">
    <div class="section-heading text-center borderYellow">
        <h1><em>SCHOOL CALENDAR</em></h1>
    </div>
    <div class="section-content">
        <div class="tabs-content w-full bg-gray-50 p-8 mx-auto">
            <div class="wrapper calendar-wrapper max-w-lg mx-auto">
                <section class="tabgroup">
                    <ul>
                        <?php 
                        $today = date('Y-m-d');  // Format today's date
                        $todayEvents = [];
                        $upcomingEvents = [];

                        foreach ($allEvent as $month => $events) {
                            foreach ($events as $event) {
                                if (isset($event['calendar_start_date'], $event['calendar_id'], $event['calendar_details'])) {
                                    $eventDate = new DateTime($event['calendar_start_date']);
                                    $eventFormatted = $eventDate->format('Y-m-d');  // Ensure it's only the date part

                                    // Check if the event is today or upcoming
                                    if ($eventFormatted === $today) {
                                        $todayEvents[] = $event;
                                    } elseif ($eventFormatted > $today) {
                                        $upcomingEvents[] = $event;
                                    }
                                }
                            }
                        }

                        // Display today's events
                        if (!empty($todayEvents)) {
                            echo '<li class="event-section">';
                            echo '<h4>Happening Today</h4>';
                            echo '<div class="event-grid">';
                            foreach ($todayEvents as $event) {
                                $date = new DateTime($event['calendar_start_date']);
                                echo '<div class="event-card">';
                                echo '<div class="event-date">';
                                echo $date->format('M d, Y');
                                echo '</div>';

                                // Adding a horizontal line or extra space
                                echo '<hr class="my-4">';
                                
                                echo '<div class="event-details">';
                                echo htmlspecialchars(strip_tags($event['calendar_details'] ?? 'No details available'));
                                echo '</div>';
                                echo '</div>';
                            }
                            echo '</div>';
                            echo '</li>';
                        }

                        // Display upcoming events
                        if (!empty($upcomingEvents)) {
                            echo '<li class="event-section">';
                            echo '<h4>Upcoming Events</h4>';
                            echo '<div class="event-grid">';
                            foreach ($upcomingEvents as $event) {
                                $date = new DateTime($event['calendar_start_date']);
                                echo '<div class="event-card">';
                                echo '<div class="event-date">';
                                echo $date->format('M d, Y');
                                echo '</div>';

                                // Adding a horizontal line or extra space
                            
                                
                                echo '<div class="event-details">';
                             
                                echo htmlspecialchars(strip_tags($event['calendar_details'] ?? 'No details available'));
                                echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                echo '<hr class="my-4 content-line">';  
                                echo '</div>';
                                
                                echo '</div>';
                            }
                            echo '</div>';
                            echo '</li>';
                        }

                        // If no events are found
                        if (empty($todayEvents) && empty($upcomingEvents)) {
                            echo '<li>';
                            echo '<div class="no-events">';
                            echo '<h4>No Events Happening Today or Upcoming</h4>';
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
                            <input type="text" id="search-input" class="search" placeholder="Enter room name">
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
                                <text id="female-cr-2-text" x="950" y="182" font-family="Arial" font-size="8" fill="black">FACULTY ROOM</text>

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

            <!-- IT Department Tab -->
            <div id="tab1" class="org-chart">
                <div class="section-content">
                    <!-- Campus Heads -->
                    <h3>Campus Heads</h3>
                    <div class="level2">
                        <?php foreach ($allItHeads as $head): ?>
                            <div class="member" data-name="<?= htmlspecialchars($head['faculty_name']) ?>" 
                                 data-specialization="<?= htmlspecialchars($head['specialization']) ?>" 
                                 data-consultation="<?= htmlspecialchars($head['consultation_time']) ?>" 
                                 data-image="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>">
                                <img src="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>" alt="Dean">
                                <p><strong><?= htmlspecialchars($head['faculty_name']) ?></strong><br>
                                    <?= implode(", ", $head['departments']); // Show all departments ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Faculty Members -->
                    <h3>Faculty Members</h3>
                    <div class="level3">
                        <?php foreach ($allIt as $faculty): ?>
                            <div class="member" data-name="<?= htmlspecialchars($faculty['faculty_name']) ?>" 
                                 data-specialization="<?= htmlspecialchars($faculty['specialization']) ?>" 
                                 data-consultation="<?= htmlspecialchars($faculty['consultation_time']) ?>" 
                                 data-image="uploaded/facultyUploaded/<?= htmlspecialchars($faculty['faculty_image']) ?>">
                                <img src="uploaded/facultyUploaded/<?= htmlspecialchars($faculty['faculty_image']) ?>" alt="Faculty Member">
                                <p><strong><?= htmlspecialchars($faculty['faculty_name']) ?></strong><br>
                                    <?= implode(", ", $faculty['departments']); // Show all departments ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- IS Department Tab -->
            <div id="tab2" class="org-chart">
                <div class="section-content">
                    <!-- Campus Heads -->
                    <h3>Campus Heads</h3>
                    <div class="level2">
                        <?php foreach ($allIsHeads as $head): ?>
                            <div class="member" data-name="<?= htmlspecialchars($head['faculty_name']) ?>" 
                                 data-specialization="<?= htmlspecialchars($head['specialization']) ?>" 
                                 data-consultation="<?= htmlspecialchars($head['consultation_time']) ?>" 
                                 data-image="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>">
                                <img src="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>" alt="Dean">
                                <p><strong><?= htmlspecialchars($head['faculty_name']) ?></strong><br>
                                    <?= implode(", ", $head['departments']); // Show all departments ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Faculty Members -->
                    <h3>Faculty Members</h3>
                    <div class="level3">
                        <?php foreach ($allIs as $faculty): ?>
                            <div class="member" data-name="<?= htmlspecialchars($faculty['faculty_name']) ?>" 
                                 data-specialization="<?= htmlspecialchars($faculty['specialization']) ?>" 
                                 data-consultation="<?= htmlspecialchars($faculty['consultation_time']) ?>" 
                                 data-image="uploaded/facultyUploaded/<?= htmlspecialchars($faculty['faculty_image']) ?>">
                                <img src="uploaded/facultyUploaded/<?= htmlspecialchars($faculty['faculty_image']) ?>" alt="Faculty Member">
                                <p><strong><?= htmlspecialchars($faculty['faculty_name']) ?></strong><br>
                                    <?= implode(", ", $faculty['departments']); // Show all departments ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- CS Department Tab -->
            <div id="tab3" class="org-chart">
                <div class="section-content">
                    <!-- Campus Heads -->
                    <h3>Campus Heads</h3>
                    <div class="level2">
                        <?php foreach ($allCsHeads as $head): ?>
                            <div class="member" data-name="<?= htmlspecialchars($head['faculty_name']) ?>" 
                                 data-specialization="<?= htmlspecialchars($head['specialization']) ?>" 
                                 data-consultation="<?= htmlspecialchars($head['consultation_time']) ?>" 
                                 data-image="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>">
                                <img src="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>" alt="Dean">
                                <p><strong><?= htmlspecialchars($head['faculty_name']) ?></strong><br>
                                    <?= implode(", ", $head['departments']); // Show all departments ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Faculty Members -->
                    <h3>Faculty Members</h3>
                    <div class="level3">
                        <?php foreach ($allCs as $faculty): ?>
                            <div class="member" data-name="<?= htmlspecialchars($faculty['faculty_name']) ?>" 
                                 data-specialization="<?= htmlspecialchars($faculty['specialization']) ?>" 
                                 data-consultation="<?= htmlspecialchars($faculty['consultation_time']) ?>" 
                                 data-image="uploaded/facultyUploaded/<?= htmlspecialchars($faculty['faculty_image']) ?>">
                                <img src="uploaded/facultyUploaded/<?= htmlspecialchars($faculty['faculty_image']) ?>" alt="Faculty Member">
                                <p><strong><?= htmlspecialchars($faculty['faculty_name']) ?></strong><br>
                                    <?= implode(", ", $faculty['departments']); // Show all departments ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- MIT Department Tab -->
            <div id="tab4" class="org-chart">
                <div class="section-content">
                    <!-- Campus Heads -->
                    <h3>Campus Heads</h3>
                    <div class="level2">
                        <?php foreach ($allMitHeads as $head): ?>
                            <div class="member" data-name="<?= htmlspecialchars($head['faculty_name']) ?>" 
                                 data-specialization="<?= htmlspecialchars($head['specialization']) ?>" 
                                 data-consultation="<?= htmlspecialchars($head['consultation_time']) ?>" 
                                 data-image="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>">
                                <img src="uploaded/facultyUploaded/<?= htmlspecialchars($head['faculty_image']) ?>" alt="Dean">
                                <p><strong><?= htmlspecialchars($head['faculty_name']) ?></strong><br>
                                    <?= implode(", ", $head['departments']); // Show all departments ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Faculty Members -->
                    <h3>Faculty Members</h3>
                    <div class="level3">
                        <?php foreach ($allMit as $faculty): ?>
                            <div class="member" data-name="<?= htmlspecialchars($faculty['faculty_name']) ?>" 
                                 data-specialization="<?= htmlspecialchars($faculty['specialization']) ?>" 
                                 data-consultation="<?= htmlspecialchars($faculty['consultation_time']) ?>" 
                                 data-image="uploaded/facultyUploaded/<?= htmlspecialchars($faculty['faculty_image']) ?>">
                                <img src="uploaded/facultyUploaded/<?= htmlspecialchars($faculty['faculty_image']) ?>" alt="Faculty Member">
                                <p><strong><?= htmlspecialchars($faculty['faculty_name']) ?></strong><br>
                                    <?= implode(", ", $faculty['departments']); // Show all departments ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>

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
</section>




        <section id="campusorgs" class="content-section bg-gray-50">
            <div class="section-heading text-center borderYellow">
                <h1 class="pt-16 pb-8">
                    <em class="text-4xl font-bold text-gray-800">CAMPUS ORGS</em>
                </h1>
                <div class="w-24 h-1 bg-yellow-400 mx-auto mb-12"></div>
            </div>

            <div class="container-fluid px-4">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                    <?php 
        $counter = 0; // Initialize a counter variable
        foreach ($allOrg as $row): ?>
                    <div class="col">
                        <div class="card h-100 border-0 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300">
                            <!-- Card Header -->
                            <div class="card-header position-relative p-0">
                                <a href="#" class="d-block" data-bs-toggle="modal" data-bs-target="#newsModal" data-orgid="<?= htmlspecialchars($row['org_id']) ?>" data-title="<?= htmlspecialchars($row['org_name']) ?>" data-image="uploaded/orgUploaded/<?= htmlspecialchars($row['org_image']) ?>" data-profilephoto="uploaded/orgUploaded/<?= htmlspecialchars($row['org_image']) ?>" data-author="<?= htmlspecialchars($row['org_name']) ?>">

                                    <!-- Card Image -->
                                    <div class="aspect-ratio-box position-relative overflow-hidden rounded-top-xl">
                                        <img src="uploaded/orgUploaded/<?= htmlspecialchars($row['org_image']) ?>" alt="<?= htmlspecialchars($row['org_name']) ?>" class="w-100 h-100 object-fit-cover transform-hover scale-hover">

                                        <!-- Overlay -->
                                        <div class="card-overlay position-absolute start-0 end-0 bottom-0 h-100 d-flex flex-column justify-content-end p-3 bg-gradient-dark opacity-0">
                                            <div class="text-white p-2 rounded bg-black bg-opacity-20 backdrop-blur-sm">
                                                <span class="d-inline-block bg-warning text-dark rounded-pill px-3 py-1 text-sm fw-medium">
                                                    View Details
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- Card Body -->
                            <div class="card-body p-3">
                                <h5 class="card-title mb-2 fw-bold text-dark fs-6 text-truncate">
                                    <?= htmlspecialchars($row['org_name']) ?>
                                </h5>
                                <div class="d-flex align-items-center">
                                    <div class="indicator bg-warning rounded me-2" style="width: 3px; height: 20px;"></div>
                                    <small class="text-muted text-xs">Campus Organization</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php 
        $counter++; // Increment the counter
        
        // Add row div after every 4 items
        if ($counter % 4 == 0): ?>
                </div>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                    <?php endif; ?>
                    <?php endforeach; ?>
                </div>

        </section>



        <section class="feedback-section bg-light py-5">   
    <div class="section-heading text-center borderYellow">
        <h1 class="pt-16 pb-8">
            <em class="text-4xl font-bold text-gray-800">FEED BACKS</em>
        </h1>
        <div class="w-24 h-1 bg-yellow-400 mx-auto mb-12"></div>
    </div>  
    <br>  
    <div class="feedback-container">
    
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">📝</div>
                <div class="stat-info">
                    <h3>Total Feedback</h3>
                    <p id="total-feedback">0</p>
                </div>
            </div>
            <div class="stat-card">
    <div class="stat-icon" id="average-rating-emoji">⭐</div> <!-- Dynamically updated emoji -->
    <div class="stat-info">
        <h3>Average Rating</h3>
        <p id="average-rating">0.0</p>
    </div>
</div>

        
        </div>

        <div class="main-card">
            <div class="card-header">
                <button class="submit-btn" data-bs-toggle="modal" data-bs-target="#feedbackModal">
                    ✉️ Submit Feedback
                </button>
            </div>

            <div class="feedback-list" id="feedback-list">
                <!-- Feedback items will be dynamically added here -->
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
    <div class="modal fade" id="newsModal" tabindex="-1" aria-labelledby="newsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newsModalLabel">Organization Feed</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="feedTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="announcements-tab" data-bs-toggle="tab" data-bs-target="#announcements" type="button" role="tab" aria-controls="announcements" aria-selected="true">
                                Announcements
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="members-tab" data-bs-toggle="tab" data-bs-target="#members" type="button" role="tab" aria-controls="members" aria-selected="false">
                                Members
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content" id="newsFeedContent">
                        <!-- Content will be dynamically loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Feedback Modal -->
<div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Share Your Feedback</h3>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="progress-steps">
                <div class="step-indicator active">1</div>
                <div class="step-indicator">2</div>
                <div class="step-indicator">3</div>
            </div>

            <div class="modal-body">
                <form id="feedbackForm" enctype="multipart/form-data">
                    <div class="step active" id="step1">
                        <h4 class="text-center mb-4">How would you rate your experience?</h4>
                        <div class="emoji-rating">
                            <span class="emoji-select" data-value="1" title="Very Dissatisfied" onclick="setRating(1)">😠</span>
                            <span class="emoji-select" data-value="2" title="Dissatisfied" onclick="setRating(2)">😞</span>
                            <span class="emoji-select" data-value="3" title="Neutral" onclick="setRating(3)">😐</span>
                            <span class="emoji-select" data-value="4" title="Satisfied" onclick="setRating(4)">😊</span>
                            <span class="emoji-select" data-value="5" title="Very Satisfied" onclick="setRating(5)">😍</span>
                        </div>
                        <input type="hidden" id="rating" name="rating">
                    </div>

                    <div class="step" id="step2">
                        <div class="form-group">
                            <label class="form-label">Email address *</label>
                            <input type="email" id="email" class="form-control" name="email" required placeholder="Enter your email">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Name (optional)</label>
                            <input type="text" id="name" class="form-control" name="name" placeholder="Enter your name">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Course *</label>
                            <div class="radio-group">
                                <label class="radio-option">
                                    <input type="radio" name="college" value="is" required>
                                    Information Systems
                                </label>
                                <label class="radio-option">
                                    <input type="radio" name="college" value="it">
                                    Information Technology
                                </label>
                                <label class="radio-option">
                                    <input type="radio" name="college" value="cs">
                                    Computer Science
                                </label>
                                <label class="radio-option">
                                    <input type="radio" name="college" value="other">
                                    Other / From Other College
                                </label>
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <label class="form-label">Year Level *</label>
                            <div class="radio-group">
                                <label class="radio-option">
                                    <input type="radio" name="year" value="1" required>
                                    1st Year
                                </label>
                                <label class="radio-option">
                                    <input type="radio" name="year" value="2">
                                    2nd Year
                                </label>
                                <label class="radio-option">
                                    <input type="radio" name="year" value="3">
                                    3rd Year
                                </label>
                                <label class="radio-option">
                                    <input type="radio" name="year" value="4">
                                    4th Year
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="step" id="step3">
                        <div class="form-group">
                            <label class="form-label">Attach Screenshot (optional)</label>
                            <input type="file" id="image" class="form-control" name="image" accept="image/*">
                        </div>

                        <div class="form-group mb-0">
                            <label class="form-label">Additional Comments</label>
                            <textarea id="feedback" class="form-control" name="feedback" rows="4" placeholder="Share your thoughts with us..."></textarea>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="previousBtn" disabled>Previous</button>
                <button type="button" class="btn btn-primary" id="nextBtn">Next</button>
                <!-- Changed to a submit button -->
                <button type="submit" class="btn btn-success" id="submitBtn" form="feedbackForm" style="display:none;">Submit Feedback</button>
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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0-alpha1/js/bootstrap.bundle.min.js"></script>



    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


    <!-- Custom JS and Plugins -->
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>
    <script>
    // Wait for the DOM to load before attaching the event listeners
    document.addEventListener('DOMContentLoaded', function() {
        // Get all the tab buttons
        const tabButtons = document.querySelectorAll('.button-faculty-btn');
        
        // Get all the tab content sections
        const tabContent = document.querySelectorAll('.org-chart');

        // Function to show the active tab and hide the others
        function showTab(tabName) {
            // Hide all tabs
            tabContent.forEach(tab => {
                tab.style.display = 'none';
            });

            // Remove the 'active' class from all buttons
            tabButtons.forEach(button => {
                button.classList.remove('active');
            });

            // Show the selected tab
            document.getElementById(tabName).style.display = 'block';
            
            // Add 'active' class to the clicked button
            const activeButton = document.querySelector(`[data-tab="${tabName}"]`);
            if (activeButton) {
                activeButton.classList.add('active');
            }
        }

        // Initially show the first tab (tab1)
        showTab('tab1');

        // Add click event listeners to each tab button
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Get the tab name (tab1, tab2, etc.) from the button's data-tab attribute
                const tabName = button.getAttribute('data-tab');
                showTab(tabName);
            });
        });
    });
</script>
<script>


// Function to handle setting the rating (optional, if you need it for other purposes)
function setRating(rating) {
    console.log("Setting rating to:", rating); // Log the rating being set
    document.querySelectorAll('.emoji-select').forEach(emoji => emoji.classList.remove('selected'));
    const selectedEmoji = document.querySelector(`.emoji-select[data-value="${rating}"]`);
    if (selectedEmoji) {
        selectedEmoji.classList.add('selected');
        selectedRating = rating;
        document.getElementById('rating').value = selectedRating; // Update hidden input
    }
}document.addEventListener('DOMContentLoaded', function() {
    console.log("DOM fully loaded and parsed.");

    // Select emoji options for rating
    document.querySelectorAll('.emoji-select').forEach(item => {
        item.addEventListener('click', function() {
            console.log("Emoji selected:", this.getAttribute('data-value'));
            document.querySelectorAll('.emoji-select').forEach(emoji => emoji.classList.remove('selected'));
            this.classList.add('selected');
            selectedRating = this.getAttribute('data-value');
            document.getElementById('rating').value = selectedRating; // Update hidden input
        });
    });

    // Multi-step form variables
    const steps = document.querySelectorAll('.step');
    const indicators = document.querySelectorAll('.step-indicator');
    const nextBtn = document.getElementById('nextBtn');
    const prevBtn = document.getElementById('previousBtn');
    const submitBtn = document.getElementById('submitBtn');
    const feedbackForm = document.getElementById('feedbackForm');
    let currentStep = 0;
    let selectedRating = null; // Store selected rating

    // Update steps in the multi-step form
    function updateSteps() {
        console.log("Updating steps:", currentStep);
        steps.forEach((step, index) => step.classList.toggle('active', index === currentStep));
        indicators.forEach((indicator, index) => indicator.classList.toggle('active', index <= currentStep));
        prevBtn.disabled = currentStep === 0;
        nextBtn.style.display = currentStep === steps.length - 1 ? 'none' : 'block';
        submitBtn.style.display = currentStep === steps.length - 1 ? 'block' : 'none';
    }

    // Multi-step form navigation
    nextBtn.addEventListener('click', () => {
        console.log("Next button clicked. Current step:", currentStep);
        if (currentStep < steps.length - 1) {
            currentStep++;
            updateSteps();
        }
    });

    prevBtn.addEventListener('click', () => {
        console.log("Previous button clicked. Current step:", currentStep);
        if (currentStep > 0) {
            currentStep--;
            updateSteps();
        }
    });

    // Handle feedback form submission
    feedbackForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission
        console.log("Form submission initiated");

        const feedbackInput = document.getElementById('feedback').value.trim();
        const emailInput = document.getElementById('email').value.trim();
        const nameInput = document.getElementById('name').value.trim();

        const collegeInput = document.querySelector('input[name="college"]:checked');
        const collegeValue = collegeInput ? collegeInput.value : '';

        const yearInput = document.querySelector('input[name="year"]:checked');
        const yearValue = yearInput ? yearInput.value : '';

        const imageInput = document.getElementById('image').files[0];

        // Check if required fields are filled
        if (feedbackInput && selectedRating && collegeValue && yearValue) {
            console.log("All fields validated. Preparing to send data...");

            const formData = new FormData();
            formData.append('rating', selectedRating);
            formData.append('feedback', feedbackInput);
            formData.append('email', emailInput);
            formData.append('name', nameInput);
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
            fetch('ajax/submit_Feedback.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                console.log("Response received:", response);
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                Swal.close();
                if (data.success) {
                    console.log("Feedback successfully submitted:", data);
                    Toast.fire({
                        icon: 'success',
                        title: 'Feedback submitted successfully!'
                    }).then(() => {
                        location.reload(); // Reload the page after success
                    });
                } else {
                    console.error('Submission failed:', data.message);
                    Toast.fire({
                        icon: 'error',
                        title: data.message || 'An error occurred while submitting your feedback.'
                    });
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                Swal.close();
                Toast.fire({
                    icon: 'error',
                    title: 'An unexpected error occurred while submitting your feedback. Please try again later.'
                });
            });

            // Close modal after submission
            const modal = bootstrap.Modal.getInstance(document.getElementById('feedbackModal'));
            modal.hide();
        } else {
            console.log("Form validation failed.");
            alert('Please select a rating and provide feedback.');
        }
    });

    // Initial steps view update
    updateSteps();

    // Toast configuration
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });
});
document.addEventListener("DOMContentLoaded", loadFeedback);

function loadFeedback() {
    fetch('ajax/fetch_feedback.php')
    .then(response => response.text()) // Fetch as text first to check response
    .then(data => {
        try {
            const jsonData = JSON.parse(data); // Try parsing as JSON
            console.log(jsonData); // Log the parsed JSON data

            if (jsonData.error) {
                console.error("Error loading feedback:", jsonData.error);
                return;
            }

            // Function to map rating to emoji
            const getEmojiForRating = (rating) => {
                switch (rating) {
                    case 5: return '😁';
                    case 4: return '🙂';
                    case 3: return '😐';
                    case 2: return '🙁';
                    case 1: return '😞';
                    default: return '❓'; // Default in case there's an invalid rating
                }
            };

            // Set the total feedback count
            document.getElementById("total-feedback").textContent = jsonData.total_feedback;

            // Set the average rating and emoji
            const averageRating = jsonData.average_rating;

            // Round the average rating to 1 decimal place
            const roundedRating = averageRating.toFixed(1); // Example: rounding to 1 decimal place

            document.getElementById("average-rating").textContent = roundedRating;
            document.getElementById("average-rating-emoji").textContent = getEmojiForRating(Math.round(averageRating));

            const feedbackContainer = document.getElementById("feedback-list");
            feedbackContainer.innerHTML = "";

            jsonData.feedbacks.forEach(feedback => {
                const feedbackItem = document.createElement("div");
                feedbackItem.className = "feedback-item";

                // Create the feedback item with dynamic emoji for rating
                feedbackItem.innerHTML = `
                    <div class="feedback-header">
                        <div class="user-info">
                            <div class="avatar">${feedback.name.charAt(0)}</div>
                            <div>
                                <h3>${feedback.name}</h3>
                                <small>${feedback.email || ''}</small>
                            </div>
                        </div>
                        <div class="rating">${getEmojiForRating(feedback.rating)}</div>
                    </div>
                    <div class="feedback-content">
                        ${feedback.feedback_text}
                    </div>
                `;
                feedbackContainer.appendChild(feedbackItem);
            });
        } catch (error) {
            console.error("Response is not valid JSON. Response received:", data);
        }
    })
    .catch(error => console.error("Error fetching feedback:", error));
}

window.onload = loadFeedback;


</script>
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
<script> // Accordion Button Toggle Icon
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

// Hide Header on Scroll Down (Debounced)
let scrollTimeout;
var lastScrollTop = 0;
var delta = 5;
var navbarHeight = $('header').outerHeight();

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
$(document).ready(function() {
                    $('#newsModal').on('show.bs.modal', function (e) {
                    
                    var orgId = $(e.relatedTarget).data('orgid'); // Ensure this is accessing the correct element
                    var title = $(e.relatedTarget).data('title');
                    var imageSrc = $(e.relatedTarget).data('image');
                    var profilePhoto = $(e.relatedTarget).data('profilephoto');
                    var authorName = $(e.relatedTarget).data('author');

                    // Check if orgId is retrieved successfully
                    console.log("Organization ID:", orgId); // Debugging line

                    // Initial fetch for announcements
                    fetchAnnouncements(orgId, profilePhoto, authorName);
                    fetchMembers(orgId);
                });

            function fetchAnnouncements(orgId, profilePhoto, authorName) {
                $.ajax({
                    url: 'ajax/fetch_announcement.php',
                    type: 'POST',
                    dataType: 'json',
                    data: { org_id: orgId },
                    success: function (response) {
                        if (response.error) {
                            $('#newsFeedContent').html('<p class="text-danger">' + response.error + '</p>');
                            return;
                        }

                        var content = `
                            <div class="tab-pane fade show active" id="announcements" role="tabpanel" aria-labelledby="announcements-tab">
                                <div class="news-feed-item">
                                    <div class="d-flex align-items-center mb-4">
                                        <img src="${profilePhoto}" alt="Profile Photo" class="profile-photo rounded-circle me-3">
                                        <h5 class="mb-0 me-3">${authorName}</h5>
                                       <button type="button" class="show-members-btn" data-orgid="${orgId}" style="display:none">
                                            Show Members    
                                        </button>

                                    </div>`;

                        if (response.announcements && response.announcements.length > 0) {
                            content += '<div class="announcement-details">';
                            response.announcements.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

                            response.announcements.forEach(function (announcement) {
                                var timeAgo = formatRelativeTime(new Date(announcement.created_at));
                                var sanitizedDetails = removeColorTags(announcement.announcement_details);
                                var creatorName = announcement.creator_name || 'Unknown Creator';

                                content += `
                                    <div class="announcement-item-bg p-4 mb-4 rounded">
                                        <div class="d-flex align-items-center mb-2">
                                            <small class="announcement-date">
                                                <i class="bi bi-clock"></i> ${timeAgo} by ${creatorName}
                                            </small>
                                        </div>
                                        <p class="mb-3">${sanitizedDetails}</p>
                                        ${announcement.announcement_image ? 
                                            `<img src="uploaded/annUploaded/${announcement.announcement_image}" 
                                             class="announcement-image img-fluid">` : ''}
                                    </div>`;
                            });
                            content += '</div>';
                        } else {
                           content += `
                                <div class="flex flex-col items-center justify-center p-8 space-y-4 text-center bg-gray-50 rounded-lg border border-gray-100">
                                <div class="p-4 bg-gray-100 rounded-full">
                                    <!-- Font Awesome 'Bullhorn' icon for announcements -->
                                    <i class="fas fa-bullhorn w-12 h-12 text-white"></i>
                                </div>

                                <div class="space-y-2">
                                    <h3 class="text-lg font-semibold text-white">
                                    No Announcements Found
                                    </h3>
                                    <p class="text-sm text-white max-w-sm">
                                    There are currently no announcements available. Check back later for updates.
                                    </p>
                                </div>
                                </div>`;

                        }

                        content += `</div></div>
                            <div class="tab-pane fade" id="members" role="tabpanel" aria-labelledby="members-tab">
                                <!-- Members content will be loaded here -->
                            </div>`;

                        $('#newsFeedContent').html(content);
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                        $('#newsFeedContent').html(
                            '<p class="text-danger">An error occurred while fetching announcements. Please try again later.</p>'
                        );
                    }
                });
            }

            $(document).on('click', '#members-tab', function () {
                    var orgId = $('.show-members-btn').data('orgid'); // Use any visible element with orgId if necessary
                    if (!orgId) {
                        console.error("Invalid orgId in #members-tab click event:", orgId);
                        $('#members').html('<p class="text-danger">Invalid organization ID.</p>');
                        return;
                    }
                    fetchMembers(orgId);
                });

            function fetchMembers(orgId) {
                console.log("Fetching announcements for org ID:", orgId); // Debugging line
                $.ajax({
                    url: 'ajax/fetch_members.php',
                    type: 'POST',
                    dataType: 'json',
                    data: { org_id: orgId },
                    success: function (response) {
                        if (response.error) {
                            $('#members').html('<p class="text-danger">' + response.error + '</p>');
                            return;
                        }
                        var membersContent = '<div class="row g-4">';
                        if (response.members && response.members.length > 0) {
    response.members.forEach(function (member) {
        membersContent += `
            <div class="col-md-3">
                <div class="card border-0 bg-white h-100">
                    <div class="position-relative aspect-ratio-1x1">
                        <img src="uploaded/orgUploaded/${member.member_img}" 
                             alt="${member.name}" 
                             class="w-100"
                             style="aspect-ratio: 1/1; object-fit: cover;"
                             onerror="this.src='path/to/default-avatar.jpg'">
                    </div>
                    <div class="card-body text-center p-4">
                        <h5 class="card-title mb-1" style="font-size: 12px; font-weight: 500;">
                            ${member.name}
                        </h5>
                        <p class="card-text text-primary mb-3" style="font-size: 10px;">
                           ${member.position}
                        </p>
                    </div>
                </div>
            </div>`;
    });
} else {           membersContent += `
<div class="flex flex-col items-center justify-center p-8 space-y-4 text-center bg-gray-50 rounded-lg border border-gray-100">
  <div class="p-4 bg-gray-100 rounded-full">
    <!-- Font Awesome 'User X' icon -->
    <i class="fas fa-user-slash w-12 h-12 text-white"></i>
  </div>

  <div class="space-y-2">
    <h3 class="text-lg font-semibold text-white">
      No Members Found
    </h3>
    <p class="text-sm text-gray-500 max-w-sm">
      We couldn't find any members matching your criteria. Try adjusting your search or filters.
    </p>
  </div>

  <button class="px-4 py-2 text-sm font-medium text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded-md transition-colors">
    Clear Filters
  </button>
</div>`;


                        }

                        membersContent += '</div>';
                        $('#members').html(membersContent);
                    },
                    error: function (xhr, status, error) {
            console.error('AJAX Error:', status, error);
            $('#newsFeedContent').html(
                '<p class="text-danger">An error occurred while fetching announcements. Please try again later.</p>'
            );
        }
                });
            }

            function removeColorTags(content) {
                return content
                    .replace(/<font[^>]*>/g, '')
                    .replace(/<\/font>/g, '')
                    .replace(/style="[^"]*color:[^;"]*;?"/g, '');
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
</script>

</body>

</html>