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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
  <link href="assets/css/css.css" rel="stylesheet" />
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
.table-container {
    width: 100%;
    overflow-x: auto;
}

.table-container {
    width: 100%; /* Full width of the parent */
    overflow-x: auto; /* Enable horizontal scrolling if needed */
    display: flex; /* Enable flex properties for centering */
    justify-content: center; /* Center the SVG */
}

#room-svg, #room-svg-1,#room-svg-2,#room-svg-3   {
    height: 100%; /* Maintain the aspect ratio */
    min-height:450px;
    max-height:auto;
}


</style>
</head>

<body class=""><div class="wrapper ">
    <!-- sweetalert start-->
    <?= isset($log_msg) ? $log_msg : '' ?>
    <!-- sweetalert end -->
    <div class="sidebar" data-color="white" data-active-color="danger">
        <div class="logo">
            <a href="dashboard.php" class="simple-text logo-normal">
                <img src="../img/C.png" alt="" width="240">
            </a>
        </div>
        <div class="sidebar-wrapper ">
            <?php if ($account_type != '0') { ?>
                <ul class="nav">
                    <li>
                        <a href="./dashboard.php">
                            <i class="fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li>
                        <a href="./announcement.php">
                            <i class="fas fa-bullhorn"></i>
                            <p>Announcement</p>
                        </a>
                    </li>
                    <li >
                        <a href="./schoolcalendar.php">
                            <i class="fas fa-calendar-alt"></i>
                            <p>School Calendar</p>
                        </a>
                    </li>
                    <?php if ($account_type == '1') { ?>
                        <li>
                            <a href="./facultymembers.php">
                                <i class="fas fa-chalkboard-teacher"></i>
                                <p>Faculty Members</p>
                            </a>
                        </li>
                        <li class="active">
                            <a href="./map.php">
                                <i class="fas fa-map-marker-alt"></i>
                                <p>Campus Map</p>
                            </a>
                        </li>
                        <li>
                            <a href="./organization.php">
                                <i class="fas fa-users"></i>
                                <p>Campus Organization</p>
                            </a>
                        </li>
                        <li>
                            <a href="./audit.php">
                                <i class="fas fa-file-alt"></i>
                                <p>Audit Trails</p>
                            </a>
                        </li>
                    <?php } ?>
                    <li>
                        <a href="./faqs.php">
                            <i class="fas fa-question-circle"></i>
                            <p>FAQS</p>
                        </a>
                    </li>
                </ul>
            <?php } ?>
            <?php if ($account_type == '0') { ?>
                <ul class="nav">
                    <li>
                        <a href="./dashboard.php">
                            <i class="fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li>
                        <a href="./ratings.php">
                            <i class="fas fa-star"></i>
                            <p>Ratings</p>
                        </a>
                    </li>
                </ul>
            <?php } ?>
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
          <!-- Tab Navigation -->
    <div class="tab-container">
    <button class="tab-button active" onclick="openTab(event, 'ccs')">CCS</button>
    <button class="tab-button" onclick="openTab(event, 'cit')">CIT</button>
    <button class="tab-button" onclick="openTab(event, 'cafa')">CAFA</button>
    </div>

    <!-- Floor Map Section -->
    <div id="ccs" class="tab-content">
        <div id="map">
            <div class="map ">
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
                    <table table class="floor-table fixed-table"  id="floor-1" border="1">
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
            <div id="cit" class="tab-content" style="display: none; " >
    <div id="map">
        <div class="map">
            <div class="dropdown">
                <input type="text" id="search" class="search" placeholder="Enter room name">
                <button onclick="searchElement()" class="search-button">
                    <i class="fa fa-search"></i>
                </button>
            </div>
            <div class="table-container " >
                <svg id="room-svg" viewBox="0 0 985 588" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect id="stock-room" x="40.5" y="205.5" width="52" height="95" fill="#D9D9D9" stroke="black"/>
                    <rect id="cit-3-b" x="220.5" y="205.5" width="53" height="95" fill="#D9D9D9" stroke="black"/>
                    <rect id="cit-5-a-b" x="167.5" y="205.5" width="52" height="95" fill="#D9D9D9" stroke="black"/>
                    <text id="stock-text" x="195" y="250" text-anchor="middle" font-size="12">
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
        <div class="map">
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
</body>

</html>