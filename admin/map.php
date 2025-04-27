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
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@latest/dist/tailwind.min.css" rel="stylesheet">
  <link href="assets/css/css.css" rel="stylesheet" />
  <style>
        /* Room highlight effect */
    .room-highlight {
        fill: #fca5a5 !important; /* Light red highlight */
        stroke: #b91c1c !important; /* Darker red outline */
        stroke-width: 2px !important; /* Thicker outline */
        filter: drop-shadow(0 0 5px rgba(220, 38, 38, 0.5));
        animation: pulse-highlight 1.5s infinite;
    }

    /* Pulse animation for highlighted rooms */
    @keyframes pulse-highlight {
        0% { opacity: 0.7; }
        50% { opacity: 1; }
        100% { opacity: 0.7; }
    }

    /* Enhanced transitions */
    .cursor-pointer {
        transition: fill 0.3s ease, stroke 0.3s ease, filter 0.3s ease;
    }
    
    /* Building and floor container transitions */
    .building-container, .floor-plan {
        transition: opacity 0.2s ease;
    }
    
    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #991b1b;
        border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #7f1d1d;
    }
    </style>
</head>

<body class=""><div class="wrapper ">
<?php include 'assets/includes/navbar.php'; ?>
      <!-- End Navbar -->
        <div class="content">
        <section id="campusmap" class="content-section py-4">
    <div class="section-heading text-center mb-5">
        
        <div class="animated-bar mx-auto mt-2 mb-3"></div>
    </div>
    
    <style>
/* Isolated styles for campus map section that won't be affected by Bootstrap */
#campusmap {
    --primary-color: #b91c1c;
    --hover-color: #4B5563; /* Dark gray for hover color */
    --light-gray: #f3f4f6;
    --gray-hover: #e5e7eb;
}
.room-highlight {
        fill: #fca5a5 !important; /* Light red highlight */
        stroke: #b91c1c !important; /* Darker red outline */
        stroke-width: 2px !important; /* Thicker outline */
        filter: drop-shadow(0 0 5px rgba(220, 38, 38, 0.5));
        animation: pulse-highlight 1.5s infinite;
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
    <div class="flex mb-6 bg-white rounded-lg shadow overflow-hidden">
            <button onclick="showBuilding('ccs')" class="building-btn flex-1 py-3 px-4 font-bold transition-colors bg-blue-600 text-white" data-building="ccs">CCS Building</button>
            <button onclick="showBuilding('cit')" class="building-btn flex-1 py-3 px-4 font-bold transition-colors bg-gray-100 hover:bg-gray-200" data-building="cit">CIT Building</button>
            <button onclick="showBuilding('cafa')" class="building-btn flex-1 py-3 px-4 font-bold transition-colors bg-gray-100 hover:bg-gray-200" data-building="cafa">CAFA Building</button>
        </div>

        <!-- Buildings Container -->
      <!-- Search Bar and Floor Dropdown Side by Side -->
      <div class="flex gap-2 mb-6">
            <!-- Search Bar (left) -->
            <div class="relative flex-grow">
                <input id="roomSearch" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md bg-white focus:outline-none focus:ring-1 focus:ring-red-800 focus:border-red-800" placeholder="Search for a room...">
                <!-- Search Icon Button -->
                <button class="absolute right-0 top-0 h-full px-2 bg-gray-200 hover:bg-gray-300 border-l border-gray-300 rounded-r-md">
    <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="4" cy="4" r="3" stroke="#666666" stroke-width="1"/>
        <line x1="6.5" y1="6.5" x2="9" y2="9" stroke="#666666" stroke-width="1"/>
    </svg>
</button>
            </div>
            
            <!-- Floor Dropdown (right) with dropdown icon -->
            <div class="relative w-64">
                <select id="floorSelect" class="w-full appearance-none px-3 py-2 border border-gray-300 rounded-md bg-white focus:outline-none focus:ring-1 focus:ring-red-800 focus:border-red-800">
                    <option value="1">Floor 1</option>
                    <option value="2">Floor 2</option>
                    <option value="3">Floor 3</option>
                    <option value="4">Floor 4</option>
                    <option value="5">Floor 5</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-gray-600 bg-gray-200 border-l border-gray-300 h-full rounded-r-md">
    <svg width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M1 1L5 5L9 1" stroke="#666666" stroke-width="1"/>
    </svg>
</div>
            </div>
        </div>

            <!-- CCS Floor Plans -->
           <!-- CCS Floor 1 (Ground Floor) --><div id="ccs-building" class="building-container block">
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
        </svg>
    </div>
</div>
        <script>
// Room data cache - will store fetched data to avoid multiple API calls
let roomDataCache = null;

// Function to clear all room highlights
function clearHighlights() {
    document.querySelectorAll('.room-highlight').forEach(el => {
        el.classList.remove('room-highlight');
    });
}

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

    // Reset the floor dropdown to 1
    const floorSelect = document.getElementById('floorSelect');
    if (floorSelect) {
        floorSelect.value = "1";
    }
    
    // Clear any search highlights
    clearHighlights();
    
    // Clear the search input
    const searchInput = document.getElementById('roomSearch');
    if (searchInput) {
        searchInput.value = '';
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
    
    // Update floor dropdown if it's not already on the right value
    const floorSelect = document.getElementById('floorSelect');
    if (floorSelect && floorSelect.value !== floorNumber.toString()) {
        floorSelect.value = floorNumber.toString();
    }
    
    // Add room labels to the visible floor
    addRoomLabelsToFloor(buildingId, floorNumber);
    
    // Clear any existing search highlighting
    clearHighlights();
}

// Function to search for rooms
// Function to search for rooms
function searchRooms() {
    const searchTerm = document.getElementById('roomSearch').value.trim().toLowerCase();
    
    // If search term is empty, clear highlights and return
    if (!searchTerm) {
        clearHighlights();
        return;
    }
    
    // Get the active building
    const activeBuilding = document.querySelector('.building-container:not(.hidden)');
    if (!activeBuilding) return;
    
    // Get the active building ID
    const buildingId = activeBuilding.id.split('-')[0];
    
    // Get the active floor
    const activeFloor = activeBuilding.querySelector('.floor-plan:not(.hidden)');
    if (!activeFloor) return;
    
    // Get all room elements in the active floor
    const roomElements = activeFloor.querySelectorAll('.cursor-pointer');
    
    // Clear previous highlights
    clearHighlights();
    
    // Flag to track if any matches were found
    let matchFound = false;
    
    // First try to match room elements by their ID or labels
    roomElements.forEach(room => {
        const roomId = room.id ? room.id.toLowerCase() : '';
        
        // Get the room label associated with this room - safely access textContent
        const roomLabel = activeFloor.querySelector(`text.room-label[data-room-id="${roomId}"]`);
        const labelText = roomLabel && roomLabel.textContent ? roomLabel.textContent.toLowerCase() : '';
        
        // Check if room data exists in cache - safely access properties
        const roomInfo = roomDataCache && roomDataCache[roomId] ? roomDataCache[roomId] : null;
        const roomName = roomInfo && roomInfo.name ? roomInfo.name.toLowerCase() : '';
        const roomDesc = roomInfo && roomInfo.description ? roomInfo.description.toLowerCase() : '';
        
        // Check if the search term is in any of these fields
        if (roomId.includes(searchTerm) || 
            labelText.includes(searchTerm) || 
            roomName.includes(searchTerm) || 
            roomDesc.includes(searchTerm)) {
            
            // Add highlight class
            room.classList.add('room-highlight');
            matchFound = true;
            
            // Scroll element into view
            room.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
    
    // If no results found and room data cache exists, search within cached room data
    if (!matchFound && roomDataCache) {
        const floorNumber = document.getElementById('floorSelect').value;
        const floorPrefix = `${buildingId.toUpperCase()}-F${floorNumber}-`;
        
        // Search through all rooms in cache
        Object.keys(roomDataCache).forEach(roomId => {
            // Only consider rooms on the current floor
            if (roomId.startsWith(floorPrefix)) {
                const roomData = roomDataCache[roomId];
                // Safely access properties
                const roomName = roomData && roomData.name ? roomData.name.toLowerCase() : '';
                const roomDesc = roomData && roomData.description ? roomData.description.toLowerCase() : '';
                
                if (roomName.includes(searchTerm) || roomDesc.includes(searchTerm)) {
                    // Find the room element by ID
                    const roomElement = activeFloor.querySelector(`#${roomId}`);
                    if (roomElement) {
                        roomElement.classList.add('room-highlight');
                        matchFound = true;
                        
                        // Scroll to this element
                        roomElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }
            }
        });
    }
    
    // Show notification if no matches found
    if (!matchFound && searchTerm) {
        alert(`No rooms matching "${searchTerm}" found on the current floor.`);
    }
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

// Function for showing room details in modal
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

// Function to set up room click handlers
function setupRoomClicks() {
    // Get all room elements in all SVGs
    const roomElements = document.querySelectorAll('[id^="CCS-"], [id^="CIT-"], [id^="CAFA-"]');
    
    // Add click handler to each room
    roomElements.forEach(room => {
        // Remove any existing click handlers first to avoid duplicates
        room.removeEventListener('click', roomClickHandler);
        
        // Add the click handler
        room.addEventListener('click', roomClickHandler);
    });
}

// Room click handler function
function roomClickHandler() {
    const roomId = this.id;
    showRoomDetails(roomId);
}

// Add style for room highlighting
function addHighlightStyle() {
    const style = document.createElement('style');
    style.textContent = `
    .room-highlight {
        fill: #93c5fd !important; /* Light blue highlight */
        stroke: #2563eb !important; /* Darker blue outline */
        stroke-width: 2px !important;
        filter: drop-shadow(0 0 5px rgba(37, 99, 235, 0.5));
        animation: pulse-highlight 1.5s infinite;
    }

    @keyframes pulse-highlight {
        0% { opacity: 0.7; }
        50% { opacity: 1; }
        100% { opacity: 0.7; }
    }

    .cursor-pointer {
        transition: fill 0.3s ease, stroke 0.3s ease, filter 0.3s ease;
    }
    `;
    document.head.appendChild(style);
}

// Initialize all event handlers
function initializeEventHandlers() {
    // Setup search input for Enter key
    const searchInput = document.getElementById('roomSearch');
    if (searchInput) {
        // Remove existing event listeners first
        const newSearchInput = searchInput.cloneNode(true);
        searchInput.parentNode.replaceChild(newSearchInput, searchInput);
        
        // Add new event listener
        newSearchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchRooms();
            }
        });
    }
    
    // Setup search button
    const searchButton = document.querySelector('button[onclick="searchRooms()"]');
    if (searchButton) {
        // Replace the inline onclick with an event listener
        searchButton.removeAttribute('onclick');
        const newSearchButton = searchButton.cloneNode(true);
        searchButton.parentNode.replaceChild(newSearchButton, searchButton);
        newSearchButton.addEventListener('click', searchRooms);
    }
    
    // Setup floor select dropdown
    const floorSelect = document.getElementById('floorSelect');
    if (floorSelect) {
        // Remove existing event listeners
        const newFloorSelect = floorSelect.cloneNode(true);
        floorSelect.parentNode.replaceChild(newFloorSelect, floorSelect);
        
        // Add new event listener
        newFloorSelect.addEventListener('change', function() {
            const activeBuilding = document.querySelector('.building-container:not(.hidden)');
            if (!activeBuilding) return;
            
            const buildingId = activeBuilding.id.split('-')[0];
            const floorNumber = parseInt(this.value);
            
            showFloor(buildingId, floorNumber);
        });
    }
    
    // Setup building buttons
    document.querySelectorAll('.building-btn').forEach(btn => {
        // Get the building ID from the data attribute
        const buildingId = btn.getAttribute('data-building');
        
        // Remove the inline onclick attribute
        btn.removeAttribute('onclick');
        
        // Add event listener
        btn.addEventListener('click', function() {
            showBuilding(buildingId);
        });
    });
    
    // Setup floor tab buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        // Get the building and floor from the button
        const buildingId = btn.closest('.building-container').id.split('-')[0];
        const floorNumber = parseInt(btn.getAttribute('data-floor'));
        
        // Remove the inline onclick attribute
        btn.removeAttribute('onclick');
        
        // Add event listener
        btn.addEventListener('click', function() {
            showFloor(buildingId, floorNumber);
        });
    });
    
    // Setup modal buttons
    const switchToEditBtn = document.getElementById('switchToEditBtn');
    if (switchToEditBtn) {
        switchToEditBtn.removeAttribute('onclick');
        switchToEditBtn.addEventListener('click', switchToEditMode);
    }
    
    const cancelEditBtn = document.getElementById('cancelEditBtn');
    if (cancelEditBtn) {
        cancelEditBtn.removeAttribute('onclick');
        cancelEditBtn.addEventListener('click', switchToViewMode);
    }
    
    const saveRoomBtn = document.getElementById('saveRoomBtn');
    if (saveRoomBtn) {
        saveRoomBtn.removeAttribute('onclick');
        saveRoomBtn.addEventListener('click', saveRoomDetails);
    }
}

// Document ready function - everything starts here
document.addEventListener('DOMContentLoaded', function() {
    console.log("Campus map initializing...");
    
    // Add highlight style to the document
    addHighlightStyle();
    
    // Initialize all event handlers
    initializeEventHandlers();
    
    // Setup room clicks for all rooms
    setupRoomClicks();
    
    // Prefetch room data for faster searching
    fetchRoomData().then(data => {
        console.log("Room data prefetched for faster searching");
    });
    
    // Show CCS building by default
    showBuilding('ccs');
});
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