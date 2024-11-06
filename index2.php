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
       
    </style>
</head>
<body>


<div class="page-content">
<section id="campusmap" class="content-section ">
            <div class="section-heading text-center borderYellow">
                <h1><br><em>CAMPUS MAP</em></h1>
            </div>
            <div id="map" >
                <div class="map section-content-map">
                <div class="dropdown">
    <input type="text" id="search" placeholder="Enter room name" aria-label="Search for a room">
    <button onclick="searchElement()" class="search-button" aria-label="Search">
        <i class="fa fa-search"></i>
    </button>
    <select id="dropdown" aria-label="Select floor" onchange="showFloor(this.value)">
        <option value="1" selected>1st Floor</option>
        <option value="2">2nd Floor</option>
        <option value="3">3rd Floor</option>
    </select>
</div>

            <div class="table-container">
         <!--floor 1-->
         <svg id="room-svg-1" class="floor-svg" viewBox="0 0 1200 300" fill="none" xmlns="http://www.w3.org/2000/svg">
         <rect id="stairs-rect" x="140.5" y="140.5" width="61" height="100" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="stairs-text" x="171" y="190" font-family="Arial" font-size="12" text-anchor="middle">STAIRS</text>
    
    <rect id="men-cr-rect" x="332.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="men-cr-text" x="370" y="190" font-family="Arial" font-size="12" text-anchor="middle">MEN CR</text>
    

    
    <rect id="female-cr-rect" x="473.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="female-cr-text" x="511" y="190" font-family="Arial" font-size="12" text-anchor="middle">FEMALE CR</text>
    
    <rect id="s-104-rect" x="698.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="s-104-text" x="736" y="190" font-family="Arial" font-size="12" text-anchor="middle">S-104</text>
    
    <rect id="s-106-rect" x="622.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="s-106-text" x="660" y="190" font-family="Arial" font-size="12" text-anchor="middle">S-106</text>
    
    <rect id="s-102-rect" x="850.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="s-102-text" x="888" y="190" font-family="Arial" font-size="12" text-anchor="middle">S-102</text>
    
    <rect id="s-103-rect" x="774.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="s-103-text" x="812" y="190" font-family="Arial" font-size="12" text-anchor="middle">S-103</text>
    
    <rect id="block-9-rect" x="999.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="block-9-text" x="1037" y="190" font-family="Arial" font-size="12" text-anchor="middle">Block 9</text>
    
    <rect id="male-cr-rect" x="923.5" y="140.5" width="75" height="106" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="male-cr-text" x="961" y="190" font-family="Arial" font-size="12" text-anchor="middle">MALE CR</text>
    
    <rect id="s-109-rect" x="202.5" y="140.5" width="64" height="65" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="s-109-text" x="230" y="170" font-family="Arial" font-size="12" text-anchor="middle">S-109</text>

    <rect id="pwd-cr-base-rect" x="408.5" y="140.5" width="64" height="53" fill="#D9D9D9" stroke="#0D0D0D"/>
    <rect id="pwd-cr-rect" x="408.5" y="193.5" width="64" height="53" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="pwd-cr-text" x="440" y="220" font-family="Arial" font-size="12" text-anchor="middle">PWD CR</text>
    
    <rect id="stairs-2-rect" x="1075.5" y="140.5" width="64" height="54" fill="#D9D9D9" stroke="#0D0D0D"/>
    <text id="stairs-2-text" x="1107" y="170" font-family="Arial" font-size="12" text-anchor="middle">STAIRS</text>
    
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
        </section>
    
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
function searchElement() {
    const searchInput = document.getElementById("search").value.toLowerCase();
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

</body>
</html>
