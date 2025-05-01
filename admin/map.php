<?php include_once ('assets/header.php');

if (!isset($_SESSION['atype'])) {
    // If the session is not set, redirect to the login page
    header("Location: index.php");
    exit;
}

$account_type = $_SESSION['atype'];
if ($account_type != '0' && $account_type != '1' && $account_type != '2' && $account_type != '3') {
    // Destroy the session if the account type is invalid
    session_destroy();
    // Redirect to the login page
    header("Location: index.php");
    exit;
}
?><!DOCTYPE html>
<html lang="en">


<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Campus Kiosk Admin
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
    name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
<!-- Replace your current Tailwind link with this -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.1/dist/tailwind.min.css" rel="stylesheet">
  <link href="assets/css/css.css" rel="stylesheet" />
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
</head>

<body class=""><div class="wrapper ">
<?php include 'assets/includes/navbar.php'; ?>
      <!-- End Navbar -->
        <div class="content">
        <section id="campusmap" class="content-section py-4">
    <div class="section-heading text-center mb-5">
        <h1 class="display-5 fw-bold position-relative d-inline-block mb-0">
            <span class="gradient-text">CAMPUS BUILDINGS</span>
        </h1>
        <div class="animated-bar mx-auto mt-2 mb-3"></div>
    </div>
    
    <style>
/* Isolated styles for campus map section that won't be affected by Bootstrap */
#campusmap {
    --primary-color: #3b82f6;
    --hover-color: #4B5563; /* Dark gray for hover color */
    --light-gray: #f3f4f6;
    --gray-hover: #e5e7eb;
}

/* Force the building buttons to display correctly */
#campusmap .building-btn {
    flex: 1;
    padding: 0.75rem 1rem;
    font-weight: bold;
    border: none;
    transition: all 0.3s ease;
    cursor: pointer;
    text-align: center;
}

#campusmap .building-btn.bg-blue-600,
#campusmap .tab-btn.bg-blue-600 {
    background-color: var(--primary-color) !important;
    color: white !important;
}

#campusmap .building-btn.bg-gray-100,
#campusmap .tab-btn.bg-gray-100 {
    background-color: var(--light-gray) !important;
    color: #333 !important;
}

#campusmap .building-btn.hover\:bg-gray-200:hover,
#campusmap .tab-btn.hover\:bg-gray-200:hover {
    background-color: var(--gray-hover) !important;
}

/* Make sure SVGs and containers display properly */
#campusmap .floor-plan {
    background-color: white;
    padding: 1.5rem;
    border-radius: 0.5rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    display: none;
}

#campusmap .floor-plan.block {
    display: block !important;
}

#campusmap .floor-plan.hidden {
    display: none !important;
}

#campusmap .building-container {
    display: none;
}

#campusmap .building-container.block {
    display: block !important;
}

#campusmap .building-container.hidden {
    display: none !important;
}

/* SVG element styles */
#campusmap svg {
    width: 100%;
    height: auto;
    max-width: 1520px;
    margin: 0 auto;
}

#campusmap .cursor-pointer {
    cursor: pointer !important;
}

#campusmap .hover\:fill-blue-200:hover {
    fill: var(--hover-color) !important;
}

/* Layout utilities */
#campusmap .flex {
    display: flex !important;
}

#campusmap .mb-6 {
    margin-bottom: 1.5rem !important;
}

#campusmap .w-full {
    width: 100% !important;
}

#campusmap .h-auto {
    height: auto !important;
}

#campusmap .rounded-lg {
    border-radius: 0.5rem !important;
}

#campusmap .shadow {
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
}

#campusmap .overflow-hidden {
    overflow: hidden !important;
}

#campusmap .p-6 {
    padding: 1.5rem !important;
}
</style>
<div class="flex mb-4 gap-2">
            <button onclick="showBuilding('ccs')" class="building-btn flex-1 py-3 font-semibold text-center bg-gray-200 hover:bg-gray-300 rounded-md transition-colors" data-building="ccs">CCS Building</button>
            <button onclick="showBuilding('cit')" class="building-btn flex-1 py-3 font-semibold text-center bg-gray-200 hover:bg-gray-300 rounded-md transition-colors" data-building="cit">CIT Building</button>
            <button onclick="showBuilding('cafa')" class="building-btn flex-1 py-3 font-semibold text-center bg-gray-200 hover:bg-gray-300 rounded-md transition-colors" data-building="cafa">CAFA Building</button>
        </div>
        
        <!-- Search Bar and Floor Dropdown Side by Side -->

<div class="flex gap-2 mb-6">
    <!-- Redesigned Search Bar -->
    <div class="relative flex-grow">
        <input 
            id="roomSearch" 
            type="text" 
            class="w-full px-3 py-2 pl-8 border border-gray-300 rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
            placeholder="Search for a room..."
        >
        <!-- Inline SVG Search Icon -->
        <svg 
            class="absolute left-2 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" 
            fill="none" 
            stroke="currentColor" 
            viewBox="0 0 24 24" 
            xmlns="http://www.w3.org/2000/svg"
        >
            <path 
                stroke-linecap="round" 
                stroke-linejoin="round" 
                stroke-width="2" 
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
            ></path>
        </svg>
    </div>
    
    <!-- Redesigned Floor Dropdown -->
    <div class="relative w-40">
        <select 
            id="floorSelect" 
            class="w-full appearance-none px-3 py-2 border border-gray-300 rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
        >
            <option value="1">Floor 1</option>
            <option value="2">Floor 2</option>
            <option value="3">Floor 3</option>
            <option value="4">Floor 4</option>
            <option value="5">Floor 5</option>
        </select>
        <!-- Inline SVG Dropdown Icon -->
        <svg 
            class="absolute right-2 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" 
            fill="none" 
            stroke="currentColor" 
            viewBox="0 0 24 24" 
            xmlns="http://www.w3.org/2000/svg"
        >
            <path 
                stroke-linecap="round" 
                stroke-linejoin="round" 
                stroke-width="2" 
                d="M19 9l-7 7-7-7"
            ></path>
        </svg>
    </div>
</div>

            <!-- CCS Floor Plans -->
           <!-- CCS Floor 1 (Ground Floor) -->
<div id="ccs-floor-1" class="floor-plan bg-white p-6 rounded-lg shadow block">
    <svg width="1520" height="1104" viewBox="0 0 1520 1104" class="w-full h-auto">
        <!-- Ground Floor Layout -->
        <rect width="1440" height="1024" transform="translate(40 40)" fill="#D9D9D9"/>
        
        <!-- Left Side -->
        <rect id="CCS-F1-B1" class="cursor-pointer hover:fill-blue-200" x="40.5" y="40.5" width="288" height="160" fill="#D8D8D8" stroke="#101010"/>
        <rect id="CCS-F1-B2" class="cursor-pointer hover:fill-blue-200" x="40.5" y="201.5" width="288" height="93" fill="#D9D9D9" stroke="black"/>
        <rect id="CCS-F1-B3" class="cursor-pointer hover:fill-blue-200" x="40.5" y="295.5" width="288" height="254" fill="#D9D9D9" stroke="black"/>
        <rect id="CCS-F1-B4" class="cursor-pointer hover:fill-blue-200" x="40.5" y="550.5" width="288" height="253" fill="#D9D9D9" stroke="black"/>
        <rect id="CCS-F1-B5" class="cursor-pointer hover:fill-blue-200" x="40.5" y="804.5" width="288" height="126" fill="#D9D9D9" stroke="black"/>
        <rect id="CCS-F1-B6" class="cursor-pointer hover:fill-blue-200" x="40.5" y="931.5" width="288" height="132" fill="#D9D9D9" stroke="black"/>
        
        <!-- Center -->
        <rect id="CCS-F1-B7" class="cursor-pointer hover:fill-blue-200" x="329.5" y="295.5" width="861" height="768" fill="#D9D9D9" stroke="black"/>
        <rect id="CCS-F1-B8" class="cursor-pointer hover:fill-blue-200" x="329.5" y="40.5" width="161" height="254" fill="#D9D9D9" stroke="black"/>
        <rect id="CCS-F1-B9" class="cursor-pointer hover:fill-blue-200" x="491.5" y="40.5" width="162" height="254" fill="#D9D9D9" stroke="black"/>
        <rect id="CCS-F1-B10" class="cursor-pointer hover:fill-blue-200" x="654.5" y="40.5" width="297" height="254" fill="#D9D9D9" stroke="black"/>
        <rect id="CCS-F1-B11" class="cursor-pointer hover:fill-blue-200" x="952.5" y="40.5" width="121" height="254" fill="#D9D9D9" stroke="black"/>
        <rect id="CCS-F1-B12" class="cursor-pointer hover:fill-blue-200" x="1074.5" y="40.5" width="116" height="254" fill="#D9D9D9" stroke="black"/>
        
        <!-- Right Side -->
        <rect id="CCS-F1-B13" class="cursor-pointer hover:fill-blue-200" x="1191.5" y="40.5" width="288" height="160" fill="#D8D8D8" stroke="#101010"/>
        <rect id="CCS-F1-B14" class="cursor-pointer hover:fill-blue-200" x="1191.5" y="201.5" width="288" height="93" fill="#D9D9D9" stroke="black"/>
        <rect id="CCS-F1-B15" class="cursor-pointer hover:fill-blue-200" x="1191.5" y="295.5" width="288" height="254" fill="#D9D9D9" stroke="black"/>
        <rect id="CCS-F1-B16" class="cursor-pointer hover:fill-blue-200" x="1191.5" y="550.5" width="288" height="253" fill="#D9D9D9" stroke="black"/>
        <rect id="CCS-F1-B17" class="cursor-pointer hover:fill-blue-200" x="1191.5" y="804.5" width="288" height="126" fill="#D9D9D9" stroke="black"/>
        <rect id="CCS-F1-B18" class="cursor-pointer hover:fill-blue-200" x="1191.5" y="931.5" width="288" height="132" fill="#D9D9D9" stroke="black"/>

        <!-- Floor Label -->
    </svg>
</div>

            <div id="ccs-floor-2" class="floor-plan bg-white p-6 rounded-lg shadow hidden">
                <svg width="1520" height="1104" viewBox="0 0 1520 1104" class="w-full h-auto">
                    <!-- 2nd Floor Layout -->
                    <rect width="1440" height="1024" transform="translate(40 40)" fill="#D9D9D9"/>
                    
                    <!-- Left Side -->
                    <rect id="CCS-F2-B1" class="cursor-pointer hover:fill-blue-200" x="40.5" y="40.5" width="288" height="160" fill="#D8D8D8" stroke="#101010"/>
                    <rect id="CCS-F2-B2" class="cursor-pointer hover:fill-blue-200" x="40.5" y="201.5" width="288" height="93" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F2-B3" class="cursor-pointer hover:fill-blue-200" x="40.5" y="295.5" width="288" height="254" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F2-B4" class="cursor-pointer hover:fill-blue-200" x="40.5" y="550.5" width="288" height="254" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F2-B5" class="cursor-pointer hover:fill-blue-200" x="40.5" y="805.5" width="288" height="124" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F2-B6" class="cursor-pointer hover:fill-blue-200" x="40.5" y="930.5" width="288" height="133" fill="#D9D9D9" stroke="black"/>
                    
                    <!-- Center Area with 4 blocks -->
                    <rect id="CCS-F2-B7" class="cursor-pointer hover:fill-blue-200" x="329.5" y="40.5" width="139" height="254" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F2-B8" class="cursor-pointer hover:fill-blue-200" x="469.5" y="40.5" width="139" height="254" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F2-B9" class="cursor-pointer hover:fill-blue-200" x="609.5" y="40.5" width="141" height="254" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F2-B10" class="cursor-pointer hover:fill-blue-200" x="751.5" y="40.5" width="140" height="254" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F2-B11" class="cursor-pointer hover:fill-blue-200" x="892.5" y="40.5" width="298" height="252" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F2-B12" class="cursor-pointer hover:fill-blue-200" x="329.5" y="295.5" width="861" height="768" fill="#D9D9D9" stroke="black"/>
                    
                    <!-- Right Side -->
                    <rect id="CCS-F2-B13" class="cursor-pointer hover:fill-blue-200" x="1191.5" y="40.5" width="288" height="160" fill="#D8D8D8" stroke="#101010"/>
                    <rect id="CCS-F2-B14" class="cursor-pointer hover:fill-blue-200" x="1191.5" y="201.5" width="288" height="93" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F2-B15" class="cursor-pointer hover:fill-blue-200" x="1191.5" y="295.5" width="288" height="254" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F2-B16" class="cursor-pointer hover:fill-blue-200" x="1191.5" y="550.5" width="288" height="254" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F2-B17" class="cursor-pointer hover:fill-blue-200" x="1191.5" y="805.5" width="288" height="124" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F2-B18" class="cursor-pointer hover:fill-blue-200" x="1191.5" y="930.5" width="288" height="133" fill="#D9D9D9" stroke="black"/>
                    
                    <!-- Floor Label -->
                </svg>
            </div>

            <div id="ccs-floor-3" class="floor-plan bg-white p-6 rounded-lg shadow hidden">
                <svg width="1520" height="1104" viewBox="0 0 1520 1104" class="w-full h-auto">
                    <!-- 3rd Floor Layout -->
                    <rect width="1440" height="1024" transform="translate(40 40)" fill="#D9D9D9"/>
                    
                    <!-- Use the same layout as Floor 2 but with different IDs -->
                    <rect id="CCS-F3-B1" class="cursor-pointer hover:fill-blue-200" x="40.5" y="40.5" width="288" height="160" fill="#D8D8D8" stroke="#101010"/>
                    <rect id="CCS-F3-B2" class="cursor-pointer hover:fill-blue-200" x="40.5" y="201.5" width="288" height="93" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F3-B3" class="cursor-pointer hover:fill-blue-200" x="40.5" y="295.5" width="288" height="254" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F3-B4" class="cursor-pointer hover:fill-blue-200" x="40.5" y="550.5" width="288" height="254" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F3-B5" class="cursor-pointer hover:fill-blue-200" x="40.5" y="805.5" width="288" height="124" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F3-B6" class="cursor-pointer hover:fill-blue-200" x="40.5" y="930.5" width="288" height="133" fill="#D9D9D9" stroke="black"/>
                    
                    <!-- Center Area -->
                    <rect id="CCS-F3-B7" class="cursor-pointer hover:fill-blue-200" x="329.5" y="40.5" width="139" height="254" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F3-B8" class="cursor-pointer hover:fill-blue-200" x="469.5" y="40.5" width="139" height="254" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F3-B9" class="cursor-pointer hover:fill-blue-200" x="609.5" y="40.5" width="141" height="254" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F3-B10" class="cursor-pointer hover:fill-blue-200" x="751.5" y="40.5" width="140" height="254" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F3-B11" class="cursor-pointer hover:fill-blue-200" x="892.5" y="40.5" width="298" height="252" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F3-B12" class="cursor-pointer hover:fill-blue-200" x="329.5" y="295.5" width="861" height="768" fill="#D9D9D9" stroke="black"/>
                    
                    <!-- Right Side -->
                    <rect id="CCS-F3-B13" class="cursor-pointer hover:fill-blue-200" x="1191.5" y="40.5" width="288" height="160" fill="#D8D8D8" stroke="#101010"/>
                    <rect id="CCS-F3-B14" class="cursor-pointer hover:fill-blue-200" x="1191.5" y="201.5" width="288" height="93" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F3-B15" class="cursor-pointer hover:fill-blue-200" x="1191.5" y="295.5" width="288" height="254" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F3-B16" class="cursor-pointer hover:fill-blue-200" x="1191.5" y="550.5" width="288" height="254" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F3-B17" class="cursor-pointer hover:fill-blue-200" x="1191.5" y="805.5" width="288" height="124" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F3-B18" class="cursor-pointer hover:fill-blue-200" x="1191.5" y="930.5" width="288" height="133" fill="#D9D9D9" stroke="black"/>
                    
                    <!-- Floor Label -->
                </svg>
            </div>

            <div id="ccs-floor-4" class="floor-plan bg-white p-6 rounded-lg shadow hidden">
                <svg width="1520" height="1104" viewBox="0 0 1520 1104" class="w-full h-auto">
                    <!-- 4th Floor Layout - Updated with your specific SVG -->
                    <rect width="1440" height="1024" transform="translate(40 40)" fill="#D9D9D9"/>
                    
                    <!-- Left Side -->
                    <rect id="CCS-F4-B1" class="cursor-pointer hover:fill-blue-200" x="40.5" y="40.5" width="288" height="160" fill="#D8D8D8" stroke="#101010"/>
                    <rect id="CCS-F4-B2" class="cursor-pointer hover:fill-blue-200" x="40.5" y="201.5" width="288" height="93" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F4-B3" class="cursor-pointer hover:fill-blue-200" x="40.5" y="295.5" width="288" height="254" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F4-B4" class="cursor-pointer hover:fill-blue-200" x="40.5" y="550.5" width="288" height="254" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F4-B5" class="cursor-pointer hover:fill-blue-200" x="40.5" y="805.5" width="288" height="124" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F4-B6" class="cursor-pointer hover:fill-blue-200" x="40.5" y="930.5" width="288" height="133" fill="#D9D9D9" stroke="black"/>
                    
                    <!-- Center Area with 5 blocks -->
                    <rect id="CCS-F4-B7" class="cursor-pointer hover:fill-blue-200" x="329.5" y="40.5" width="139" height="254" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F4-B8" class="cursor-pointer hover:fill-blue-200" x="469.5" y="40.5" width="139" height="254" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F4-B9" class="cursor-pointer hover:fill-blue-200" x="609.5" y="40.5" width="141" height="254" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F4-B10" class="cursor-pointer hover:fill-blue-200" x="751.5" y="40.5" width="140" height="254" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F4-B11" class="cursor-pointer hover:fill-blue-200" x="892.5" y="40.5" width="298" height="254" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F4-B12" class="cursor-pointer hover:fill-blue-200" x="329.5" y="295.5" width="861" height="768" fill="#D9D9D9" stroke="black"/>
                    
                    <!-- Right Side -->
                    <rect id="CCS-F4-B13" class="cursor-pointer hover:fill-blue-200" x="1191.5" y="40.5" width="288" height="160" fill="#D8D8D8" stroke="#101010"/>
                    <rect id="CCS-F4-B14" class="cursor-pointer hover:fill-blue-200" x="1191.5" y="201.5" width="288" height="93" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F4-B15" class="cursor-pointer hover:fill-blue-200" x="1191.5" y="295.5" width="288" height="254" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F4-B16" class="cursor-pointer hover:fill-blue-200" x="1191.5" y="550.5" width="288" height="254" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F4-B17" class="cursor-pointer hover:fill-blue-200" x="1191.5" y="805.5" width="288" height="124" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F4-B18" class="cursor-pointer hover:fill-blue-200" x="1191.5" y="930.5" width="288" height="133" fill="#D9D9D9" stroke="black"/>
                    
                    <!-- Floor Label -->
                </svg>
            </div>

            <div id="ccs-floor-5" class="floor-plan bg-white p-6 rounded-lg shadow hidden">
                <svg width="1520" height="1104" viewBox="0 0 1520 1104" class="w-full h-auto">
                    <!-- 5th Floor Layout -->
                    <rect width="1440" height="1024" transform="translate(40 40)" fill="#D9D9D9"/>
                    
                    <!-- Using similar layout with different IDs -->
                    <rect id="CCS-F5-B1" class="cursor-pointer hover:fill-blue-200" x="40.5" y="40.5" width="288" height="160" fill="#D8D8D8" stroke="#101010"/>
                    <rect id="CCS-F5-B2" class="cursor-pointer hover:fill-blue-200" x="40.5" y="201.5" width="288" height="93" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F5-B3" class="cursor-pointer hover:fill-blue-200" x="40.5" y="295.5" width="288" height="254" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F5-B4" class="cursor-pointer hover:fill-blue-200" x="40.5" y="550.5" width="288" height="254" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F5-B5" class="cursor-pointer hover:fill-blue-200" x="40.5" y="805.5" width="288" height="124" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F5-B6" class="cursor-pointer hover:fill-blue-200" x="40.5" y="930.5" width="288" height="133" fill="#D9D9D9" stroke="black"/>
                    
                    <rect id="CCS-F5-B7" class="cursor-pointer hover:fill-blue-200" x="329.5" y="40.5" width="861" height="254" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F5-B8" class="cursor-pointer hover:fill-blue-200" x="329.5" y="295.5" width="861" height="768" fill="#D9D9D9" stroke="black"/>
                    
                    <rect id="CCS-F5-B9" class="cursor-pointer hover:fill-blue-200" x="1191.5" y="40.5" width="288" height="160" fill="#D8D8D8" stroke="#101010"/>
                    <rect id="CCS-F5-B10" class="cursor-pointer hover:fill-blue-200" x="1191.5" y="201.5" width="288" height="93" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F5-B11" class="cursor-pointer hover:fill-blue-200" x="1191.5" y="295.5" width="288" height="509" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F5-B12" class="cursor-pointer hover:fill-blue-200" x="1191.5" y="805.5" width="288" height="124" fill="#D9D9D9" stroke="black"/>
                    <rect id="CCS-F5-B13" class="cursor-pointer hover:fill-blue-200" x="1191.5" y="930.5" width="288" height="133" fill="#D9D9D9" stroke="black"/>
                    
                    <!-- Floor Label -->
                </svg>
            </div>
        </div>

        <div id="cit-building" class="building-container hidden">
            <!-- Modified: Only showing Floor 1 for CIT -->
            <div id="cit-floor-1" class="floor-plan bg-white p-6 rounded-lg shadow block">
                <svg width="1521" height="1104" viewBox="0 0 1521 1104" class="w-full h-auto">
                    <!-- CIT Floor 1 Layout using the provided SVG -->
                    <rect width="1440" height="1024" transform="translate(40 40)" fill="#D9D9D9"/>
                    
                    <!-- Rooms -->
                    <rect id="CIT-F1-B1" class="cursor-pointer hover:fill-blue-200" x="40.5" y="902.5" width="99" height="161" fill="#D9D9D9" stroke="black"/>
                    <rect id="CIT-F1-B2" class="cursor-pointer hover:fill-blue-200" x="40.5" y="740.5" width="99" height="161" fill="#D9D9D9" stroke="black"/>
                    <rect id="CIT-F1-B3" class="cursor-pointer hover:fill-blue-200" x="40.5" y="573.5" width="99" height="166" fill="#D9D9D9" stroke="black"/>
                    <rect id="CIT-F1-B4" class="cursor-pointer hover:fill-blue-200" x="355.5" y="40.5" width="127" height="166" fill="#D9D9D9" stroke="black"/>
                    <rect id="CIT-F1-B5" class="cursor-pointer hover:fill-blue-200" x="40.5" y="357.5" width="99" height="215" fill="#D9D9D9" stroke="black"/>
                    <rect id="CIT-F1-B6" class="cursor-pointer hover:fill-blue-200" x="256.5" y="357.5" width="98" height="215" fill="#D9D9D9" stroke="black"/>
                    <path id="CIT-F1-B7" class="cursor-pointer hover:fill-blue-200" d="M559.5 40.5V206.5H483.5V40.5H559.5Z" fill="#D9D9D9" stroke="black"/>
                    <path id="CIT-F1-B8" class="cursor-pointer hover:fill-blue-200" d="M644.5 40.5V206.5H560.5V40.5H644.5Z" fill="#D9D9D9" stroke="black"/>
                    <rect id="CIT-F1-B9" class="cursor-pointer hover:fill-blue-200" x="355.5" y="357.5" width="98" height="215" fill="#D9D9D9" stroke="black"/>
                    <rect id="CIT-F1-B10" class="cursor-pointer hover:fill-blue-200" x="453.5" y="356.5" width="138" height="217" fill="#D9D9D9" stroke="black"/>
                    <rect id="CIT-F1-B11" class="cursor-pointer hover:fill-blue-200" x="590.5" y="356.5" width="139" height="217" fill="#D9D9D9" stroke="black"/>
                    <rect id="CIT-F1-B12" class="cursor-pointer hover:fill-blue-200" x="728.5" y="356.5" width="138" height="217" fill="#D9D9D9" stroke="black"/>
                    <rect id="CIT-F1-B13" class="cursor-pointer hover:fill-blue-200" x="865.5" y="356.5" width="135" height="217" fill="#D9D9D9" stroke="black"/>
                    <rect id="CIT-F1-B14" class="cursor-pointer hover:fill-blue-200" x="999.5" y="356.5" width="138" height="217" fill="#D9D9D9" stroke="black"/>
                    <rect id="CIT-F1-B15" class="cursor-pointer hover:fill-blue-200" x="1342.5" y="356.5" width="138" height="217" fill="#D9D9D9" stroke="black"/>
                    <rect id="CIT-F1-B16" class="cursor-pointer hover:fill-blue-200" x="1342.5" y="572.5" width="138" height="213" fill="#D9D9D9" stroke="black"/>
                    <rect id="CIT-F1-B17" class="cursor-pointer hover:fill-blue-200" x="1136.5" y="356.5" width="139" height="217" fill="#D9D9D9" stroke="black"/>
                    <rect id="CIT-F1-B18" class="cursor-pointer hover:fill-blue-200" x="355.5" y="207.5" width="98" height="149" fill="#D9D9D9" stroke="black"/>
                    <rect id="CIT-F1-B19" class="cursor-pointer hover:fill-blue-200" x="1275.5" y="300.5" width="67" height="77" fill="#D9D9D9" stroke="black"/>
                    <rect id="CIT-F1-B20" class="cursor-pointer hover:fill-blue-200" x="454.5" y="207.5" width="190" height="149" fill="#D9D9D9" stroke="black"/>
                    <rect id="CIT-F1-B21" class="cursor-pointer hover:fill-blue-200" x="140.5" y="357.5" width="115" height="108" fill="#D9D9D9" stroke="black"/>
                    <rect id="CIT-F1-B22" class="cursor-pointer hover:fill-blue-200" x="140.5" y="466.5" width="115" height="106" fill="#D9D9D9" stroke="black"/>
                    
                    <!-- Floor Label -->
                </svg>
            </div>
        </div>

        <div id="cafa-building" class="building-container hidden">
            <!-- Floor Navigation Tabs for CAFA -->
            <div class="flex mb-6 bg-white rounded-lg shadow overflow-hidden">
                <button onclick="showFloor('cafa', 1)" class="tab-btn flex-1 py-3 px-4 font-bold transition-colors bg-blue-600 text-white" data-floor="1">Floor 1</button>
                <button onclick="showFloor('cafa', 2)" class="tab-btn flex-1 py-3 px-4 font-bold transition-colors bg-gray-100 hover:bg-gray-200" data-floor="2">Floor 2</button>
                <button onclick="showFloor('cafa', 3)" class="tab-btn flex-1 py-3 px-4 font-bold transition-colors bg-gray-100 hover:bg-gray-200" data-floor="3">Floor 3</button>
            </div>
            
            <!-- CAFA Floor 1 Layout from paste-11.txt -->
            <div id="cafa-floor-1" class="floor-plan bg-white p-6 rounded-lg shadow block">
                <svg width="1520" height="1104" viewBox="0 0 1520 1104" class="w-full h-auto">
                    <rect width="1440" height="1024" transform="translate(40 40)" fill="#D9D9D9"/>
                    
                    <!-- Using the SVG layout from paste-11.txt -->
                    <rect id="CAFA-F1-B1" class="cursor-pointer hover:fill-blue-200" x="40.5" y="454.5" width="74" height="126" fill="#D9D9D9" stroke="#0A0A0A"/>
                    <rect id="CAFA-F1-B2" class="cursor-pointer hover:fill-blue-200" x="115.5" y="454.5" width="95" height="109" fill="#D9D9D9" stroke="#0A0A0A"/>
                    <rect id="CAFA-F1-B3" class="cursor-pointer hover:fill-blue-200" x="211.5" y="454.5" width="103" height="109" fill="#D9D9D9" stroke="#0A0A0A"/>
                    <rect id="CAFA-F1-B4" class="cursor-pointer hover:fill-blue-200" x="315.5" y="454.5" width="101" height="152" fill="#D9D9D9" stroke="#0A0A0A"/>
                    <rect id="CAFA-F1-B5" class="cursor-pointer hover:fill-blue-200" x="417.5" y="454.5" width="97" height="83" fill="#D9D9D9" stroke="#0A0A0A"/>
                    <rect id="CAFA-F1-B6" class="cursor-pointer hover:fill-blue-200" x="417.5" y="538.5" width="97" height="68" fill="#D9D9D9" stroke="#0A0A0A"/>
                    <rect id="CAFA-F1-B7" class="cursor-pointer hover:fill-blue-200" x="515.5" y="454.5" width="104" height="152" fill="#D9D9D9" stroke="#0A0A0A"/>
                    <rect id="CAFA-F1-B8" class="cursor-pointer hover:fill-blue-200" x="615.5" y="454.5" width="105" height="152" fill="#D9D9D9" stroke="#0A0A0A"/>
                    <rect id="CAFA-F1-B9" class="cursor-pointer hover:fill-blue-200" x="715.5" y="454.5" width="105" height="152" fill="#D9D9D9" stroke="#0A0A0A"/>
                    <rect id="CAFA-F1-B10" class="cursor-pointer hover:fill-blue-200" x="821.5" y="454.5" width="101" height="152" fill="#D9D9D9" stroke="#0A0A0A"/>
                    <rect id="CAFA-F1-B11" class="cursor-pointer hover:fill-blue-200" x="923.5" y="454.5" width="105" height="152" fill="#D9D9D9" stroke="#0A0A0A"/>
                    <rect id="CAFA-F1-B12" class="cursor-pointer hover:fill-blue-200" x="1026.5" y="454.5" width="102" height="152" fill="#D9D9D9" stroke="#0A0A0A"/>
                    <rect id="CAFA-F1-B13" class="cursor-pointer hover:fill-blue-200" x="1126.5" y="454.5" width="101" height="152" fill="#D9D9D9" stroke="#0A0A0A"/>
                    <rect id="CAFA-F1-B14" class="cursor-pointer hover:fill-blue-200" x="1228.5" y="454.5" width="105" height="152" fill="#D9D9D9" stroke="#0A0A0A"/>
                    <rect id="CAFA-F1-B15" class="cursor-pointer hover:fill-blue-200" x="1334.5" y="454.5" width="145" height="109" fill="#D9D9D9" stroke="#0A0A0A"/>
                    <rect id="CAFA-F1-B16" class="cursor-pointer hover:fill-blue-200" x="115.5" y="564.5" width="95" height="86" fill="#D9D9D9" stroke="#0A0A0A"/>
                    
                    <!-- Floor Label -->
                </svg>
            </div>
            
            <!-- CAFA Floor 2 Layout from paste-12.txt -->
            <div id="cafa-floor-2" class="floor-plan bg-white p-6 rounded-lg shadow hidden">
                <svg width="1520" height="1104" viewBox="0 0 1520 1104" class="w-full h-auto">
                    <rect width="1440" height="1024" transform="translate(40 40)" fill="#D9D9D9"/>
                    
                    <!-- Using the SVG layout from paste-12.txt -->
                    <rect id="CAFA-F2-B1" class="cursor-pointer hover:fill-blue-200" x="40.5" y="454.5" width="74" height="135" fill="#D9D9D9" stroke="#0A0A0A"/>
                    <rect id="CAFA-F2-B2" class="cursor-pointer hover:fill-blue-200" x="115.5" y="454.5" width="200" height="163" fill="#D9D9D9" stroke="#0A0A0A"/>
                    <rect id="CAFA-F2-B3" class="cursor-pointer hover:fill-blue-200" x="316.5" y="454.5" width="104" height="163" fill="#D9D9D9" stroke="#0A0A0A"/>
                    <rect id="CAFA-F2-B4" class="cursor-pointer hover:fill-blue-200" x="421.5" y="454.5" width="147" height="163" fill="#D9D9D9" stroke="#0A0A0A"/>
                    <rect id="CAFA-F2-B5" class="cursor-pointer hover:fill-blue-200" x="570.5" y="454.5" width="105" height="163" fill="#D9D9D9" stroke="#0A0A0A"/>
                    <rect id="CAFA-F2-B6" class="cursor-pointer hover:fill-blue-200" x="676.5" y="454.5" width="106" height="163" fill="#D9D9D9" stroke="#0A0A0A"/>
                    <rect id="CAFA-F2-B7" class="cursor-pointer hover:fill-blue-200" x="783.5" y="454.5" width="101" height="163" fill="#D9D9D9" stroke="#0A0A0A"/>
                    <rect id="CAFA-F2-B8" class="cursor-pointer hover:fill-blue-200" x="885.5" y="454.5" width="150" height="163" fill="#D9D9D9" stroke="#0A0A0A"/>
                    <rect id="CAFA-F2-B9" class="cursor-pointer hover:fill-blue-200" x="1033.5" y="454.5" width="131" height="163" fill="#D9D9D9" stroke="#0A0A0A"/>
                    <rect id="CAFA-F2-B10" class="cursor-pointer hover:fill-blue-200" x="1165.5" y="454.5" width="106" height="163" fill="#D9D9D9" stroke="#0A0A0A"/>
                    <rect id="CAFA-F2-B11" class="cursor-pointer hover:fill-blue-200" x="1272.5" y="454.5" width="102" height="163" fill="#D9D9D9" stroke="#0A0A0A"/>
                    <rect id="CAFA-F2-B12" class="cursor-pointer hover:fill-blue-200" x="1375.5" y="454.5" width="104" height="95" fill="#D9D9D9" stroke="#0A0A0A"/>
                    
                    <!-- Floor Label -->
                </svg>
            </div>
            
            <!-- CAFA Floor 3 Layout from paste-13.txt -->
            <div id="cafa-floor-3" class="floor-plan bg-white p-6 rounded-lg shadow hidden">
                <svg width="1520" height="1104" viewBox="0 0 1520 1104" class="w-full h-auto">
                    <rect width="1440" height="1024" transform="translate(40 40)" fill="#D9D9D9"/>
                    
                    <!-- Using the SVG layout from paste-13.txt -->
                    <rect id="CAFA-F3-B1" class="cursor-pointer hover:fill-blue-200" x="40.5" y="455.5" width="74" height="134" fill="#D9D9D9" stroke="#0A0A0A"/>
                    <rect id="CAFA-F3-B2" class="cursor-pointer hover:fill-blue-200" x="115.5" y="455.5" width="200" height="162" fill="#D9D9D9" stroke="#0A0A0A"/>
                    <rect id="CAFA-F3-B3" class="cursor-pointer hover:fill-blue-200" x="316.5" y="455.5" width="104" height="162" fill="#D9D9D9" stroke="#0A0A0A"/>
                    <rect id="CAFA-F3-B4" class="cursor-pointer hover:fill-blue-200" x="421.5" y="455.5" width="147" height="162" fill="#D9D9D9" stroke="#0A0A0A"/>
                    <rect id="CAFA-F3-B5" class="cursor-pointer hover:fill-blue-200" x="570.5" y="455.5" width="105" height="162" fill="#D9D9D9" stroke="#0A0A0A"/>
                    <rect id="CAFA-F3-B6" class="cursor-pointer hover:fill-blue-200" x="676.5" y="455.5" width="106" height="162" fill="#D9D9D9" stroke="#0A0A0A"/>
                    <rect id="CAFA-F3-B7" class="cursor-pointer hover:fill-blue-200" x="783.5" y="455.5" width="102" height="162" fill="#D9D9D9" stroke="#0A0A0A"/>
                    <rect id="CAFA-F3-B8" class="cursor-pointer hover:fill-blue-200" x="886.5" y="455.5" width="149" height="162" fill="#D9D9D9" stroke="#0A0A0A"/>
                    <rect id="CAFA-F3-B9" class="cursor-pointer hover:fill-blue-200" x="1032.5" y="455.5" width="132" height="162" fill="#D9D9D9" stroke="#0A0A0A"/>
                    <rect id="CAFA-F3-B10" class="cursor-pointer hover:fill-blue-200" x="1165.5" y="455.5" width="105" height="162" fill="#D9D9D9" stroke="#0A0A0A"/>
                    <rect id="CAFA-F3-B11" class="cursor-pointer hover:fill-blue-200" x="1271.5" y="455.5" width="104" height="162" fill="#D9D9D9" stroke="#0A0A0A"/>
                    <rect id="CAFA-F3-B12" class="cursor-pointer hover:fill-blue-200" x="1376.5" y="455.5" width="103" height="94" fill="#D9D9D9" stroke="#0A0A0A"/>
                    
                    <!-- Floor Label -->
                </svg>
            </div>
        </div>
        <script>
// Room data cache - will store fetched data to avoid multiple API calls
let roomDataCache = null;

// Function to show the selected building
function showBuilding(buildingId) {
    console.log("Showing building:", buildingId);
    
    // Hide all building containers
    document.querySelectorAll('.building-container').forEach(container => {
        container.classList.add('hidden');
        container.classList.remove('block');
    });
    
    // Show the selected building container
    const selectedBuilding = document.getElementById(`${buildingId}-building`);
    if (selectedBuilding) {
        selectedBuilding.classList.remove('hidden');
        selectedBuilding.classList.add('block');
    } else {
        console.error(`Building element not found: ${buildingId}-building`);
    }
    
    // Update building tab styling
    document.querySelectorAll('.building-btn').forEach(btn => {
        if (btn.getAttribute('data-building') === buildingId) {
            btn.classList.remove('bg-gray-100', 'hover:bg-gray-200');
            btn.classList.add('bg-blue-600', 'text-white');
        } else {
            btn.classList.remove('bg-blue-600', 'text-white');
            btn.classList.add('bg-gray-100', 'hover:bg-gray-200');
        }
    });
    
    // For CIT we only show floor 1
    if (buildingId === 'cit') {
        // Show the first floor
        showFloor('cit', 1);
    } else if (buildingId === 'ccs') {
        showFloor('ccs', 1);
    } else if (buildingId === 'cafa') {
        showFloor('cafa', 1);
    }
}

// Function to show the selected floor for a specific building
function showFloor(buildingId, floorNumber) {
    console.log("Showing floor:", buildingId, floorNumber);
    
    // Hide all floor plans for this building
    document.querySelectorAll(`#${buildingId}-building .floor-plan`).forEach(plan => {
        plan.classList.add('hidden');
        plan.classList.remove('block');
    });
    
    // Show the selected floor plan
    const selectedFloor = document.getElementById(`${buildingId}-floor-${floorNumber}`);
    if (selectedFloor) {
        selectedFloor.classList.remove('hidden');
        selectedFloor.classList.add('block');
    } else {
        console.error(`Floor element not found: ${buildingId}-floor-${floorNumber}`);
    }
    
    // Update floor tab styling (only for the active building)
    document.querySelectorAll(`#${buildingId}-building .tab-btn`).forEach(btn => {
        if (parseInt(btn.getAttribute('data-floor')) === floorNumber) {
            btn.classList.remove('bg-gray-100', 'hover:bg-gray-200');
            btn.classList.add('bg-blue-600', 'text-white');
        } else {
            btn.classList.remove('bg-blue-600', 'text-white');
            btn.classList.add('bg-gray-100', 'hover:bg-gray-200');
        }
    });
    
    // Add room labels to the visible floor
    addRoomLabelsToFloor(buildingId, floorNumber);
}

// Function to fetch room data from the database - only fetch once
async function fetchRoomData() {
    // If we already have the data cached, return it immediately
    if (roomDataCache) {
        return roomDataCache;
    }
    
    try {
        // Make the fetch request to your API
        const response = await fetch('./ajax/fetch_rooms.php');
        
        if (!response.ok) {
            throw new Error(`Network response was not ok: ${response.status}`);
        }
        
        const data = await response.json();
        console.log("Room data fetched successfully:", data);
        
        // Cache the data for future use
        roomDataCache = data;
        return data;
    } catch (error) {
        console.error('Error fetching room data:', error);
        // Return mock data for demo purposes
        return getMockRoomData();
    }
}

// Function to provide mock room data when API call fails
function getMockRoomData() {
    // This is a mock function that returns sample data
    const mockData = {};
    
    // Generate mock room names for CCS Building
    for (let floor = 1; floor <= 5; floor++) {
        for (let room = 1; room <= 18; room++) {
            const roomId = `CCS-F${floor}-B${room}`;
            mockData[roomId] = {
                id: roomId,
                name: `Room ${floor}${room.toString().padStart(2, '0')}`,
                description: `Sample room on floor ${floor}`
            };
        }
    }
    
    // Generate mock room names for CIT Building
    for (let room = 1; room <= 22; room++) {
        const roomId = `CIT-F1-B${room}`;
        mockData[roomId] = {
            id: roomId,
            name: `Lab ${room.toString().padStart(2, '0')}`,
            description: `CIT Lab room`
        };
    }
    
    // Generate mock room names for CAFA Building
    for (let floor = 1; floor <= 3; floor++) {
        for (let room = 1; room <= 16; room++) {
            const roomId = `CAFA-F${floor}-B${room}`;
            mockData[roomId] = {
                id: roomId,
                name: `Studio ${floor}${room.toString().padStart(2, '0')}`,
                description: `CAFA studio on floor ${floor}`
            };
        }
    }
    
    console.log("Using mock room data:", mockData);
    return mockData;
}

// Function to add room labels specifically to a floor
async function addRoomLabelsToFloor(buildingId, floorNumber) {
    try {
        // First fetch room data from database (or use cache)
        const roomData = await fetchRoomData();
        
        if (!roomData || Object.keys(roomData).length === 0) {
            console.error("No room data received from database.");
            return;
        }
        
        // Get the SVG element for this specific floor
        const floorElement = document.getElementById(`${buildingId}-floor-${floorNumber}`);
        if (!floorElement) {
            console.error(`Floor element not found: ${buildingId}-floor-${floorNumber}`);
            return;
        }
        
        const svg = floorElement.querySelector('svg');
        if (!svg) {
            console.error(`SVG not found in floor: ${buildingId}-floor-${floorNumber}`);
            return;
        }
        
        console.log(`Adding labels to ${buildingId} floor ${floorNumber}`);
        
        // First, remove any existing labels to avoid duplicates
        const existingLabels = svg.querySelectorAll('text.room-label');
        existingLabels.forEach(label => label.remove());
        
        // Get all room elements in this SVG
        const roomElements = svg.querySelectorAll(`[id^="${buildingId.toUpperCase()}-F${floorNumber}-"]`);
        console.log(`Found ${roomElements.length} room elements in ${buildingId} floor ${floorNumber}`);
        
        // Add labels to each room
        roomElements.forEach(room => {
            const roomId = room.id;
            
            // Check if we have data for this room
            if (roomData[roomId]) {
                const rect = room.getBBox();
                
                // Create text element
                const text = document.createElementNS('http://www.w3.org/2000/svg', 'text');
                
                // Set text position
                text.setAttribute('x', rect.x + rect.width / 2);
                text.setAttribute('y', rect.y + rect.height / 2);
                
                // Set text style
                text.setAttribute('text-anchor', 'middle');
                text.setAttribute('dominant-baseline', 'middle');
                text.setAttribute('font-family', 'Arial, sans-serif');
                text.setAttribute('font-size', '14px');
                text.setAttribute('font-weight', 'bold');
                text.setAttribute('fill', '#333333');
                text.setAttribute('pointer-events', 'none');
                text.setAttribute('class', 'room-label'); // Add class for easy selection
                text.setAttribute('data-room-id', roomId); // Add data attribute for identification
                
                // Set room name from database
                text.textContent = roomData[roomId].name;
                
                // Add text element to SVG
                svg.appendChild(text);
                
                console.log(`Added label "${text.textContent}" to room ${roomId}`);
            } else {
                console.warn(`No data found for room ${roomId}`);
            }
        });
    } catch (error) {
        console.error("Error adding room labels:", error);
    }
}

async function showRoomDetails(roomId) {
    try {
        // Fetch room data
        const roomData = await fetchRoomData();
        
        // Get the specific room details
        const room = roomData[roomId];
        
        if (!room) {
            Swal.fire({
                title: "Error!",
                text: "Room details not found.",
                icon: "error"
            });
            return;
        }

        // Populate view mode
        document.getElementById('viewRoomId').textContent = roomId;
        document.getElementById('viewRoomName').textContent = room.name || 'N/A';
        document.getElementById('viewRoomDescription').textContent = room.description || 'No description available';

        // Populate edit mode inputs
        document.getElementById('editRoomId').value = roomId;
        document.getElementById('editRoomName').value = room.name || '';
        document.getElementById('editRoomDescription').value = room.description || '';

        // Show the modal
        $('#roomDetailsModal').modal('show');

        // Ensure view mode is active
        switchToViewMode();
    } catch (error) {
        console.error('Error fetching room details:', error);
        Swal.fire({
            title: "Error!",
            text: "Failed to load room details.",
            icon: "error"
        });
    }
}

// Switch to edit mode
function switchToEditMode() {
    // Hide view mode
    document.getElementById('roomViewMode').style.display = 'none';
    
    // Show edit mode
    document.getElementById('roomEditMode').style.display = 'block';
    
    // Toggle buttons
    document.getElementById('switchToEditBtn').style.display = 'none';
    document.getElementById('cancelEditBtn').style.display = 'inline-block';
    document.getElementById('saveRoomBtn').style.display = 'inline-block';
    
    // Update modal title
    document.getElementById('roomDetailsModalTitle').textContent = 'Edit Room Details';
}

// Switch back to view mode
function switchToViewMode() {
    // Show view mode
    document.getElementById('roomViewMode').style.display = 'block';
    
    // Hide edit mode
    document.getElementById('roomEditMode').style.display = 'none';
    
    // Toggle buttons
    document.getElementById('switchToEditBtn').style.display = 'inline-block';
    document.getElementById('cancelEditBtn').style.display = 'none';
    document.getElementById('saveRoomBtn').style.display = 'none';
    
    // Update modal title
    document.getElementById('roomDetailsModalTitle').textContent = 'Room Details';
}

// Function to save room details
function saveRoomDetails() {
    // Get form values
    const roomId = document.getElementById('editRoomId').value;
    const roomName = document.getElementById('editRoomName').value;
    const roomDescription = document.getElementById('editRoomDescription').value;

    // Show SweetAlert confirmation
    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to save these room details?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, save it!",
        cancelButtonText: "No, cancel!"
    }).then((result) => {
        if (result.isConfirmed) {
            // Create form data
            const formData = new FormData();
            formData.append('room_id', roomId);
            formData.append('room_name', roomName);
            formData.append('room_description', roomDescription);

            // Send AJAX request
            fetch('./ajax/update_room.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                console.log("Raw Response Data:", data);

                try {
                    const result = JSON.parse(data);
                    console.log("Parsed JSON Data:", result);

                    if (result.success) {
                        // Update view mode with new details
                        document.getElementById('viewRoomName').textContent = roomName;
                        document.getElementById('viewRoomDescription').textContent = roomDescription;

                        // Switch back to view mode
                        switchToViewMode();
                        
                        Swal.fire({
                            title: "Success!",
                            text: result.message,
                            icon: "success"
                        }).then(() => {
                            // Update room labels and cache
                            updateRoomLabel(roomId, roomName);
                            
                            // Update cached room data if exists
                            if (roomDataCache && roomDataCache[roomId]) {
                                roomDataCache[roomId].name = roomName;
                                roomDataCache[roomId].description = roomDescription;
                            }
                        });
                    } else {
                        // Show error notification
                        Swal.fire({
                            title: "Error!",
                            text: result.message,
                            icon: "error"
                        });
                    }
                } catch (error) {
                    console.error("Error parsing JSON:", error);
                    Swal.fire({
                        title: "Error!",
                        text: "An error occurred while processing the response.",
                        icon: "error"
                    });
                }
            })
            .catch(error => {
                console.error("Fetch Error:", error);
                Swal.fire({
                    title: "Error!",
                    text: "An error occurred while saving room details.",
                    icon: "error"
                });
            });
        }
    });
}

// Modify setupRoomClicks to use new showRoomDetails function
function setupRoomClicks() {
    // Get all room elements in all SVGs
    const roomElements = document.querySelectorAll('[id^="CCS-"], [id^="CIT-"], [id^="CAFA-"]');
    
    // Add click handler to each room
    roomElements.forEach(room => {
        room.addEventListener('click', function() {
            const roomId = this.id;
            showRoomDetails(roomId);
        });
    });
}
// Function to save room details
async function saveRoomDetails() {
    const roomId = document.getElementById('editRoomId').value;
    const roomName = document.getElementById('editRoomName').value;
    const roomDescription = document.getElementById('editRoomDescription').value;

    try {
        const response = await fetch('./ajax/update_room.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `room_id=${encodeURIComponent(roomId)}&room_name=${encodeURIComponent(roomName)}&room_description=${encodeURIComponent(roomDescription)}`
        });

        if (!response.ok) {
            throw new Error('Failed to update room details');
        }

        const result = await response.json();

        if (result.success) {
            // Update room labels on the page
            updateRoomLabel(roomId, roomName);
            
            // Update cached room data if exists
            if (roomDataCache && roomDataCache[roomId]) {
                roomDataCache[roomId].name = roomName;
                roomDataCache[roomId].description = roomDescription;
            }
            
            // Hide the modal using Bootstrap's modal method
            $('#roomEditModal').modal('hide');

            // Show a success notification using Bootstrap's toast or notify
            $.notify({
                message: 'Room details updated successfully!'
            },{
                type: 'success',
                placement: {
                    from: "top",
                    align: "right"
                }
            });
        } else {
            throw new Error(result.message || 'Failed to update room details');
        }
    } catch (error) {
        console.error('Error updating room:', error);
        
        // Show error notification
        $.notify({
            message: 'Failed to update room details. Please try again.'
        },{
            type: 'danger',
            placement: {
                from: "top",
                align: "right"
            }
        });
    }
}

// Function to update room label in the SVG
function updateRoomLabel(roomId, newName) {
    // Find all SVGs in the document
    const svgs = document.querySelectorAll('svg');
    
    svgs.forEach(svg => {
        // Find the room element with the specific ID
        const roomElement = svg.querySelector(`[id="${roomId}"]`);
        
        if (roomElement) {
            // Find or create the room label
            let roomLabel = svg.querySelector(`text.room-label[data-room-id="${roomId}"]`);
            
            if (!roomLabel) {
                // If label doesn't exist, create it
                const rect = roomElement.getBBox();
                roomLabel = document.createElementNS('http://www.w3.org/2000/svg', 'text');
                roomLabel.setAttribute('x', rect.x + rect.width / 2);
                roomLabel.setAttribute('y', rect.y + rect.height / 2);
                roomLabel.setAttribute('text-anchor', 'middle');
                roomLabel.setAttribute('dominant-baseline', 'middle');
                roomLabel.setAttribute('font-family', 'Arial, sans-serif');
                roomLabel.setAttribute('font-size', '14px');
                roomLabel.setAttribute('font-weight', 'bold');
                roomLabel.setAttribute('fill', '#333333');
                roomLabel.setAttribute('pointer-events', 'none');
                roomLabel.setAttribute('class', 'room-label');
                roomLabel.setAttribute('data-room-id', roomId);
                
                svg.appendChild(roomLabel);
            }
            
            // Update label text
            roomLabel.textContent = newName;
        }
    });
}

// Wait for page to load, then initialize everything
document.addEventListener('DOMContentLoaded', function() {
    console.log("Campus map initializing...");
    
    // Setup room clicks for all rooms
    setupRoomClicks();
    
    // Setup event listeners for modal using jQuery
    $('#saveRoomBtn').on('click', saveRoomDetails);
    
    // Show CCS building by default
    showBuilding('ccs');
});// Function to save room details
function saveRoomDetails() {
    // Get form values
    const roomId = document.getElementById('editRoomId').value;
    const roomName = document.getElementById('editRoomName').value;
    const roomDescription = document.getElementById('editRoomDescription').value;

    // Show SweetAlert confirmation
    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to save these room details?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, save it!",
        cancelButtonText: "No, cancel!"
    }).then((result) => {
        if (result.isConfirmed) {
            // Create form data
            const formData = new FormData();
            formData.append('room_id', roomId);
            formData.append('room_name', roomName);
            formData.append('room_description', roomDescription);

            // Send AJAX request
            fetch('./ajax/update_room.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                console.log("Raw Response Data:", data);

                try {
                    const result = JSON.parse(data);
                    console.log("Parsed JSON Data:", result);

                    if (result.success) {
                        // Successful update
                        $('#roomEditModal').modal('hide');
                        
                        Swal.fire({
                            title: "Success!",
                            text: result.message,
                            icon: "success"
                        }).then(() => {
                            // Update room labels and cache
                            updateRoomLabel(roomId, roomName);
                            
                            // Update cached room data if exists
                            if (roomDataCache && roomDataCache[roomId]) {
                                roomDataCache[roomId].name = roomName;
                                roomDataCache[roomId].description = roomDescription;
                            }
                        });
                    } else {
                        // Show error notification
                        Swal.fire({
                            title: "Error!",
                            text: result.message,
                            icon: "error"
                        });
                    }
                } catch (error) {
                    console.error("Error parsing JSON:", error);
                    Swal.fire({
                        title: "Error!",
                        text: "An error occurred while processing the response.",
                        icon: "error"
                    });
                }
            })
            .catch(error => {
                console.error("Fetch Error:", error);
                Swal.fire({
                    title: "Error!",
                    text: "An error occurred while saving room details.",
                    icon: "error"
                });
            });
        }
    });
}

</script>
</section>
<!-- Room Edit Modal with Bootstrap Styling -->
<!-- Room Details Modal with Bootstrap Styling -->
<style>
#roomDetailsModal .modal-header {
  background: linear-gradient(135deg, #7D0A0A, #C83E3E);
  color: white;
  padding: 15px;
  border-bottom: none;
}

#roomDetailsModal .modal-body {
  padding: 25px;
  max-height: 75vh;
  overflow-y: auto;
  scrollbar-width: thin;
  scrollbar-color: #cbd5e0 #f8f9fa;
}

#roomDetailsModal .modal-footer {
  background-color: #f8f9fa;
  border-top: 1px solid #e9ecef;
  background: linear-gradient(135deg, #962626, #b03a3a);
  padding: 15px;
}

#roomDetailsModal .modal-footer .btn {
  margin-left: 10px;
}
</style>

<!-- Room Details Modal with Updated Design -->
<div class="modal fade" id="roomDetailsModal" tabindex="-1" role="dialog" aria-labelledby="roomDetailsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="roomDetailsModalTitle">Room Details</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- View Mode -->
        <div id="roomViewMode">
          <div class="form-group">
            <label class="font-weight-bold">Room ID</label>
            <p id="viewRoomId" class="form-control-plaintext"></p>
          </div>
          <div class="form-group">
            <label class="font-weight-bold">Room Name</label>
            <p id="viewRoomName" class="form-control-plaintext"></p>
          </div>
          <div class="form-group">
            <label class="font-weight-bold">Room Description</label>
            <p id="viewRoomDescription" class="form-control-plaintext text-muted"></p>
          </div>
        </div>

        <!-- Edit Mode (Initially Hidden) -->
        <div id="roomEditMode" style="display:none;">
          <input type="hidden" id="editRoomId" name="room_id">
                    
          <div class="form-group">
            <label for="editRoomName" class="font-weight-bold">Room Name</label>
            <input type="text" id="editRoomName" name="room_name" class="form-control" placeholder="Enter room name">
          </div>
                    
          <div class="form-group">
            <label for="editRoomDescription" class="font-weight-bold">Room Description</label>
            <textarea id="editRoomDescription" name="room_description" class="form-control" rows="4" placeholder="Enter room description"></textarea>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
        <div>
          <!-- Edit Button (Only in View Mode) -->
          <button type="button" class="btn btn-light" id="switchToEditBtn" onclick="switchToEditMode()">
            <i class="fas fa-edit"></i> Edit
          </button>
          <!-- Cancel Button (Only in Edit Mode) -->
          <button type="button" class="btn btn-secondary" id="cancelEditBtn" onclick="switchToViewMode()" style="display:none;">
            Cancel
          </button>
          <!-- Save Button (Only in Edit Mode) -->
          <button type="button" class="btn btn-danger" id="saveRoomBtn" onclick="saveRoomDetails()" style="display:none;">
            Save Changes
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
          </div>
    </div>    
</div>
<style>
#roomDetailsModal .modal-header {
  background: linear-gradient(135deg, #7D0A0A, #C83E3E);
  color: white;
  padding: 15px;
  border-bottom: none;
}

#roomDetailsModal .modal-body {
  padding: 25px;
  max-height: 75vh;
  overflow-y: auto;
  scrollbar-width: thin;
  scrollbar-color: #cbd5e0 #f8f9fa;
}

#roomDetailsModal .modal-footer {
  background-color: #f8f9fa;
  border-top: 1px solid #e9ecef;
  background: linear-gradient(135deg, #962626, #b03a3a);
  padding: 15px;
}

#roomDetailsModal .modal-footer .btn {
  margin-left: 10px;
}
</style>
  <!--   Core JS Files   --><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="assets/js/core/jquery.min.js"></script>
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chart JS -->
  <script src="assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="assets/js/paper-dashboard.min.js?v=2.0.1" type="text/javascript"></script>
  <!-- Paper Dashboard DEMO methods, don't include it in your project! -->
  <script src="assets/demo/demo.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/perfect-scrollbar@1.5.0/dist/perfect-scrollbar.min.js"></script>
  <script src="assets/js/paper-dashboard.min.js?v=2.0.1"></script>
   

</body>

</html>