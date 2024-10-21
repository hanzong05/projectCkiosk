<?php include_once ('assets/header.php');?><!DOCTYPE html>
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
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
  <link href="assets/css/css.css" rel="stylesheet" />
  <style>
    .highlight {
    background-color: #2e0f13 !important;
    }
    .editable-cell {
    border: 1px solid #ddd;
    padding: 5px;
    cursor: pointer; /* Change cursor to indicate that it's editable */
}

.editable-cell[contenteditable="true"] {
    background-color: #f9f9f9; /* Highlight background for edit mode */
    color: #333; /* Set the font color for the cell when editing */
    font-weight: bold; /* Optional: make the font bold while editing */
}
</style>
</head>

<body class="">
<div class="sidebar" data-color="white" data-active-color="danger">
  <div class="logo">
    <a href="dashboard.php" class="simple-text logo-normal">
      <img src="../img/C.png" alt="" width="240">
    </a>
  </div>
  <div class="sidebar-wrapper ">
    <ul class="nav">
      <li >
        <a href="./dashboard.php">
          <i class="nc-icon nc-bank"></i>
          <p>Dashboard</p>
        </a>
      </li>
      <li >
        <a href="./announcement.php">
          <i class="nc-icon nc-diamond"></i>
          <p>Announcement</p>
        </a>
      </li>
      <li>
          <a href="./schoolcalendar.php">
            <i class="nc-icon nc-pin-3"></i>
            <p>School Calendar</p>
          </a>
      </li>
      <?php if ($account_type == '1') { ?>
        <li >
          <a href="./facultymembers.php">
            <i class="nc-icon nc-bell-55"></i>
            <p>Faculty Members</p>
          </a>
        </li>
        <li class="active">
          <a href="./map.php">
            <i class="nc-icon nc-single-02"></i>
            <p>Campus Map</p>
          </a>
        </li>
        <li >
          <a href="./organization.php">
            <i class="nc-icon nc-caps-small"></i>
            <p>Campus Organization</p>
          </a>
        </li>
      <?php } ?>
      <li>
        <a href="./faqs.php">
          <i class="nc-icon nc-tile-56"></i>
          <p>FAQS</p>
        </a>
      </li>
    </ul>
  </div>
</div>


    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="javascript:;">Campus Map</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
            aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <ul class="navbar-nav">
              <li class="nav-item btn-rotate dropdown">
                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="nc-icon nc-settings-gear-65"></i>
                  <p>
                    <span class="d-lg-none d-md-block"></span>
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="logout.php">Logout</a>
                  <?php if ($account_type == '2') { ?>
                    <a class="dropdown-item" href="./membersmanagement.php">Profile</a>
                <?php } ?>
                <?php if ($account_type == '3') { ?>
                    <a class="dropdown-item" href="./memberprofile.php">Profile</a>
                <?php } ?>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
        <div class="content">
          <section id="campusmap" class="content-section">
            <div id="map">
                <div class="map">
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
                <table class="floor-table fixed-table"  id="floor-1" border="1">
                    <tbody>
                        <tr>
                            <td class="floor-gray editable-cell"colspan="2" id="1" style="height: 100px;"></td>
                            <td id="2" class="floor-gray editable-cell" rowspan="2" style="width: 120px;"></td>
                            <td id="3" class="floor-gray editable-cell"rowspan="2" style="width: 120px;"></td>
                            <td id="4" class="floor-gray editable-cell" colspan="2" rowspan="2"></td>
                            <td id="5" class="floor-gray editable-cell"rowspan="2" style="width: 70px; "></td>
                            <td id="6" class="floor-gray editable-cell"rowspan="2" style="width: 70px; "></td>
                            <td id="7" class="floor-gray editable-cell"colspan="2"></td>
                        </tr>
                        <tr>
                            <td id="8" class="floor-gray editable-cell editable-cell"colspan="2" style="height: 50px;"></td>
                            <td id="9" class="floor-gray editable-cell editable-cell"colspan="2"></td>
                        </tr>
                        <tr>
                            <td class="floor-gray editable-cell"colspan="2" id="10">0</td>
                            <td id="11"  class="floor-maroon editable-cell" colspan="6" rowspan="4">1</td>
                            <td id="12" class="floor-gray editable-cell"colspan="2">2</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="floor-gray editable-cell"id="13">3</td>
                            <td id="14" class="floor-gray editable-cell"colspan="2">4</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="floor-gray editable-cell"id="15"   style="height: 60px;">5</td>
                            <td id="16" class="floor-gray editable-cell"colspan="2">6</td>
                        
                        </tr>
                        <tr>
                            <td colspan="2" class="floor-gray editable-cell"id="17"  style="height: 50px;">7</td>
                            <td id="18" class="floor-gray editable-cell"colspan="2">8</td>
                        
                        </tr>
                    </tbody>
                </table>
                <table class="floor-table fixed-table" id="floor-2" border="1">
                    <tbody>
                        <tr>
                            <td colspan="2" class="floor-gray editable-cell"id="19" style="height: 100px;">18</td>
                            <td id="20" class="floor-gray editable-cell"rowspan="2" >19</td>
                            <td id="21" class="floor-gray editable-cell"rowspan="2" >20</td>
                            <td id="22"  class="floor-gray editable-cell"rowspan="2">21</td>
                            <td id="23" class="floor-gray editable-cell"rowspan="2" >22</td>
                            <td id="24" class="floor-gray editable-cell"colspan="2" rowspan="2">23</td>
                            <td id="25" class="floor-gray editable-cell"colspan="2" >24</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="floor-gray editable-cell"id="26" style="height: 50px; ">25</td>
                            <td id="27" class="floor-gray editable-cell"colspan="2">26</td>
                        </tr>
                        <tr>
                            <td colspan="2"class="floor-gray editable-cell"id="28">27</td>
                            <td id="29" class="floor-maroon editable-cell"colspan="6" rowspan="4">138</td>
                            <td id="32" class="floor-gray editable-cell"colspan="2">29</td>
                        </tr>
                        <tr>
                            <td colspan="2"class="floor-gray editable-cell"id="31">30</td>
                            <td id="30"class="floor-gray editable-cell" colspan="2">31</td>
                        </tr>
                        <tr>
                            <td colspan="2"id="33" class="floor-gray editable-cell"  style="height: 60px;">32</td>
                            <td id="34" class="floor-gray editable-cell"colspan="2">33</td>
                        
                        </tr>
                        <tr>
                            <td colspan="2"id="35" class="floor-gray editable-cell" style="height: 50px;">34</td>
                            <td id="36" class="floor-gray editable-cell"colspan="2">35</td>
                        
                        </tr>
                    </tbody>
                </table>

                <table class="floor-table fixed-table" id="floor-3" border="1">
                    <tbody>
                        <tr>
                            <td colspan="2" id="37"  class="floor-gray editable-cell" style="height: 100px;">18</td>
                            <td id="38" rowspan="2" class="floor-gray editable-cell">19</td>
                            <td id="39" rowspan="2" class="floor-gray editable-cell">20</td>
                            <td id="40" rowspan="2" class="floor-gray editable-cell">21</td>
                            <td id="41" rowspan="2" class="floor-gray editable-cell">22</td>
                            <td id="42" colspan="2" rowspan="2" class="floor-gray editable-cell">23</td>
                            <td id="43" colspan="2" class="floor-gray editable-cell">24</td>
                        </tr>
                        <tr>
                            <td colspan="2"id="44" style="height: 50px;" class="floor-gray editable-cell">25</td>
                            <td id="45" colspan="2" class="floor-gray editable-cell">26</td>
                        </tr>
                        <tr>
                            <td colspan="2"id="46"class="floor-gray editable-cell">27</td>
                            <td id="47" colspan="6" rowspan="4" class="floor-maroon editable-cell">138</td>
                            <td id="48" colspan="2" class="floor-gray">29</td>
                        </tr>
                        <tr>
                            <td colspan="2"id="50" class="floor-gray editable-cell">30</td>
                            <td id="49" colspan="2" class="floor-gray editable-cell">31</td>
                        </tr>
                        <tr>
                            <td colspan="2"id="51"  style="height: 60px;" class="floor-gray editable-cell">32</td>
                            <td id="52" colspan="2" class="floor-gray editable-cell">33</td>
                        
                        </tr>
                        <tr>
                            <td colspan="2"id="53"  style="height: 50px; " class="floor-gray editable-cell">34</td>
                            <td id="54" colspan="2" class="floor-gray editable-cell">35</td>
                        
                        </tr>
                    </tbody>
                </table>

                <table class="floor-table fixed-table" id="floor-4" border="1">
                    <tbody>
                        <tr>
                            <td colspan="2"id="55" style="height: 100px; " class="floor-gray editable-cell">18</td>
                            <td id="56" rowspan="2" class="floor-gray editable-cell">19</td>
                            <td id="57" rowspan="2" class="floor-gray editable-cell">20</td>
                            <td id="58" rowspan="2"class="floor-gray editable-cell">21</td>
                            <td id="59" rowspan="2" class="floor-gray editable-cell">22</td>
                            <td id="60" rowspan="2"class="floor-gray editable-cell">23</td>
                            <td id="61" rowspan="2"class="floor-gray editable-cell">23</td>
                            <td id="62" colspan="2" class="floor-gray editable-cell">24</td>
                        </tr>
                        <tr>
                            <td colspan="2" id="63" style="height: 50px;" class="floor-gray editable-cell">25</td>
                            <td id="64" colspan="2" class="floor-gray editable-cell">26</td>
                        </tr>
                        <tr>
                            <td colspan="2"id="65" class="floor-gray editable-cell">27</td>
                            <td id="66" colspan="6" rowspan="4" class="floor-maroon editable-cell">138</td>
                            <td id="67" colspan="2" class="floor-gray editable-cell">29</td>
                        </tr>
                        <tr>
                            <td colspan="2"id="68" class="floor-gray editable-cell">30</td>
                            <td id="69" colspan="2" class="floor-gray editable-cell">31</td>
                        </tr>
                        <tr>
                            <td colspan="2"id="70"   style="height: 60px; " class="floor-gray editable-cell">32</td>
                            <td id="71" colspan="2" class="floor-gray editable-cell">33</td>
                        
                        </tr>
                        <tr>
                            <td colspan="2"id="72"  style="height: 50px;" class="floor-gray editable-cell">34</td>
                            <td id="73" colspan="2" class="floor-gray editable-cell"> 35</td>
                        
                        </tr>
                    </tbody>
                </table>
                <table class="floor-table fixed-table" id="floor-5" border="1">
                    <tbody>
                        <tr>
                            <td colspan="2"id="74" style="height: 100px; " class="floor-gray editable-cell">18</td>
                            <td id="75" colspan="6" rowspan="2" class="floor-gray editable-cell">19</td>
                            <td id="76" colspan="2" class="floor-gray">24</td>
                        </tr>
                        <tr>
                            <td colspan="2" id="77" style="height: 50px;" class="floor-gray editable-cell">25</td>
                            <td id="78" colspan="2" class="floor-gray editable-cell">26</td>
                        </tr>
                        <tr>
                            <td colspan="2"id="79" class="floor-gray editable-cell">27</td>
                            <td id="80" colspan="6" rowspan="4" class="floor-maroon editable-cell" >138</td>
                            <td id="81" colspan="2" rowspan="2" class="floor-gray editable-cell">29</td>
                        </tr>
                        <tr>
                            <td colspan="2"id="82" class="floor-gray editable-cell">30</td>
                        </tr>
                        <tr>
                            <td colspan="2"id="83"   style="height: 60px;" class="floor-gray editable-cell">32</td>
                            <td id="84" colspan="2" class="floor-gray editable-cell">33</td>
                        
                        </tr>
                        <tr>
                            <td colspan="2"id="85"  style="height: 50px;" class="floor-gray editable-cell">34</td>
                            <td id="86" colspan="2" class="floor-gray editable-cell"> 35</td>
                        
                        </tr>
                    </tbody>
                </table>
              </div>
            </div>
        </section>
          </div>
    </div>    
</div>
  <!--   Core JS Files   -->
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
  <script>
    $(document).ready(function () {
      // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
      demo.initChartsPages();
    });

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
    xhr.open('POST', '../ajax/floor_data.php', true);
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
        const cell = document.getElementById(room.room_id); 
        if (cell) {
            cell.textContent = room.room_name; 
            cell.style.backgroundColor = ''; 
            console.log('Updated Cell:', cell.id, room.room_name);
        } else {
            console.error('Cell Not Found:', room.room_id);
        }
    });
}

// Function to clear all table cells
function clearTableCells() {
    document.querySelectorAll('.floor-table td').forEach(cell => {
        cell.textContent = ''; 
        cell.style.backgroundColor = ''; 
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
    xhr.open('POST', '../ajax/search.php', true);
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
                if (roomIds.includes(parseInt(cell.id))) { 
                    cell.classList.add('highlight');
                }
            });

            // Trigger the dropdown change event to update table and highlight results
            var dropdown = document.getElementById('dropdownMenu');
            dropdown.value = floorIds[0] || dropdown.value; 
            dropdown.dispatchEvent(new Event('change')); 

        } else {
            console.error('Search Error:', xhr.statusText);
        }
    };
    xhr.send('query=' + encodeURIComponent(input));
}

// Function to show a specific floor table
function showFloorTable(floorId) {
    document.querySelectorAll('.floor-table').forEach(table => {
        table.style.display = 'none'; 
    });

    const selectedTable = document.getElementById(`floor-${floorId}`);
    if (selectedTable) {
        selectedTable.style.display = 'table'; // Show the selected table
        selectedTable.scrollIntoView({ behavior: 'smooth', block: 'start' }); 
    }
}
document.addEventListener('DOMContentLoaded', function () {
    function makeCellEditable(event) {
        let cell = event.target;
        if (cell.isContentEditable) {
            cell.contentEditable = 'false';
            cell.classList.remove('editable-cell');

            // Get updated data
            const roomId = cell.id;
            const roomName = cell.innerText.trim();

            // Send updated data to the server
            fetch('ajax/update_cell.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    'id': roomId,
                    'name': roomName,
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Update successful');
                } else {
                    console.error('Update failed:', data.message || data.error);
                }
            })
            .catch(error => console.error('Error:', error));
        } else {
            cell.contentEditable = 'true';
            cell.classList.add('editable-cell');
            cell.focus();
        }
    }

    document.querySelectorAll('.editable-cell').forEach(cell => {
        cell.addEventListener('dblclick', makeCellEditable);
    });
});

  </script>
</body>

</html>