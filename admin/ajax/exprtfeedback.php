<?php
include_once('../../class/connection.php');
include_once('../../class/mainClass.php');

// Get filters from request
$dateFilter = isset($_GET['date']) ? $_GET['date'] : 'all';
$orgFilter = isset($_GET['org']) ? $_GET['org'] : 'all';
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Check if session exists, and get account_type from it
$account_type = isset($_SESSION['account_type']) ? $_SESSION['account_type'] : '0'; // Default to '0' if not set

try {
    // Determine feedback type
    $feedback_type = ($account_type == '0') ? 'office' : 'organization';
    
    // Build query based on feedback type
    if ($feedback_type == 'office') {
        // Office feedback query - Same as original
        $sql = "SELECT 
            id,
            name,
            email,
            feedback_date as created_at,
            sqd0_satisfaction,
            sqd1_time,
            sqd2_requirements,
            sqd3_steps,
            sqd4_information,
            sqd5_value,
            sqd6_security,
            sqd7_support,
            sqd8_outcome,
            cc_awareness,
            cc_visibility,
            cc_helpfulness,
            improvements
        FROM office_feedback";
        
        // Add date filter if needed - Same as original
        if ($dateFilter != 'all') {
            $date_clause = "";
            $today = date('Y-m-d');
            
            switch($dateFilter) {
                case 'today':
                    $date_clause = "feedback_date >= '$today 00:00:00' AND feedback_date <= '$today 23:59:59'";
                    break;
                case 'week':
                    $week_start = date('Y-m-d', strtotime('this week'));
                    $week_end = date('Y-m-d', strtotime('this week +6 days'));
                    $date_clause = "feedback_date >= '$week_start 00:00:00' AND feedback_date <= '$week_end 23:59:59'";
                    break;
                case 'month':
                    $month_start = date('Y-m-01');
                    $month_end = date('Y-m-t');
                    $date_clause = "feedback_date >= '$month_start 00:00:00' AND feedback_date <= '$month_end 23:59:59'";
                    break;
            }
            
            if ($date_clause) {
                $sql .= " WHERE $date_clause";
            }
        }
        
        // Add search term if provided - Same as original
        if ($searchTerm) {
            $sql .= ($dateFilter != 'all') ? " AND" : " WHERE";
            $sql .= " (name LIKE :search OR email LIKE :search OR improvements LIKE :search)";
        }
        
        $sql .= " ORDER BY feedback_date DESC";
        
        $stmt = $connect->prepare($sql);
        
        if ($searchTerm) {
            $searchParam = "%$searchTerm%";
            $stmt->bindParam(':search', $searchParam);
        }
        
    } else {
        // Organization feedback query - Same as original
        $sql = "SELECT of.*, o.org_name
                FROM org_feedback of
                LEFT JOIN organization_tbl o ON of.org_id = o.org_id";
        
        $conditions = [];
        $org_id = null; // Initialize org_id to avoid undefined variable
        
        // Add organization filter if needed - Same as original
        if ($account_type != '4' || ($account_type == '4' && $orgFilter != 'all')) {
            if ($account_type != '4') {
                // Get user's organization
                if ($account_type == '2') {
                    $orgSql = "SELECT users_org FROM users_tbl WHERE users_id = :user_id";
                    $orgStmt = $connect->prepare($orgSql);
                    $orgStmt->execute([':user_id' => $_SESSION['id']]);
                    $org = $orgStmt->fetch(PDO::FETCH_ASSOC);
                    $org_id = $org['users_org'];
                } else if ($account_type == '3') {
                    $orgSql = "SELECT org_type FROM orgmembers_tbl WHERE id = :user_id AND is_active = 1";
                    $orgStmt = $connect->prepare($orgSql);
                    $orgStmt->execute([':user_id' => $_SESSION['id']]);
                    $org = $orgStmt->fetch(PDO::FETCH_ASSOC);
                    $org_id = $org['org_type'];
                }
                
                if (isset($org_id)) {
                    $conditions[] = "of.org_id = :org_id";
                }
            } else if ($orgFilter != 'all') {
                $org_id = $orgFilter;
                $conditions[] = "of.org_id = :org_id";
            }
        }
        
        // Add date filter if needed - Same as original
        if ($dateFilter != 'all') {
            $today = date('Y-m-d');
            
            switch($dateFilter) {
                case 'today':
                    $conditions[] = "of.created_at >= '$today 00:00:00' AND of.created_at <= '$today 23:59:59'";
                    break;
                case 'week':
                    $week_start = date('Y-m-d', strtotime('this week'));
                    $week_end = date('Y-m-d', strtotime('this week +6 days'));
                    $conditions[] = "of.created_at >= '$week_start 00:00:00' AND of.created_at <= '$week_end 23:59:59'";
                    break;
                case 'month':
                    $month_start = date('Y-m-01');
                    $month_end = date('Y-m-t');
                    $conditions[] = "of.created_at >= '$month_start 00:00:00' AND of.created_at <= '$month_end 23:59:59'";
                    break;
            }
        }
        
        // Add search term if provided - Same as original
        if ($searchTerm) {
            $conditions[] = "(of.name LIKE :search OR of.email LIKE :search OR of.improvements LIKE :search OR o.org_name LIKE :search)";
        }
        
        // Add WHERE clause if there are conditions - Same as original
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        
        $sql .= " ORDER BY of.created_at DESC";
        
        $stmt = $connect->prepare($sql);
        
        // Bind parameters - Same as original
        if (isset($org_id) && in_array("of.org_id = :org_id", $conditions)) {
            $stmt->bindParam(':org_id', $org_id);
        }
        
        if ($searchTerm) {
            $searchParam = "%$searchTerm%";
            $stmt->bindParam(':search', $searchParam);
        }
    }
    
    $stmt->execute();
    $feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get Citizen's Charter statistics if office feedback type - Same as original
    $cc_stats = [];
    if ($feedback_type == 'office') {
        // Define date range based on filter
        $start_date = date('Y-m-d', strtotime('-6 months'));
        $end_date = date('Y-m-d');
        
        if ($dateFilter != 'all') {
            $today = date('Y-m-d');
            
            switch($dateFilter) {
                case 'today':
                    $start_date = $today;
                    $end_date = $today;
                    break;
                case 'week':
                    $start_date = date('Y-m-d', strtotime('monday this week'));
                    $end_date = date('Y-m-d', strtotime('sunday this week'));
                    break;
                case 'month':
                    $start_date = date('Y-m-d', strtotime('first day of this month'));
                    $end_date = date('Y-m-d', strtotime('last day of this month'));
                    break;
            }
        }
        
        // CC1 - Awareness Query - Same as original
        $cc1_sql = "SELECT 
            cc_awareness,
            COUNT(*) as total,
            (COUNT(*) * 100.0 / (SELECT COUNT(*) FROM office_feedback WHERE feedback_date BETWEEN :start_date1 AND :end_date1)) as percentage
        FROM office_feedback 
        WHERE feedback_date BETWEEN :start_date2 AND :end_date2
        GROUP BY cc_awareness";

        $cc1_stmt = $connect->prepare($cc1_sql);
        $cc1_stmt->bindParam(':start_date1', $start_date);
        $cc1_stmt->bindParam(':end_date1', $end_date);
        $cc1_stmt->bindParam(':start_date2', $start_date);
        $cc1_stmt->bindParam(':end_date2', $end_date);
        $cc1_stmt->execute();
        $cc1_results = $cc1_stmt->fetchAll(PDO::FETCH_ASSOC);
        $cc_stats['awareness'] = $cc1_results;

        // CC2 - Visibility Query - Same as original
        $cc2_sql = "SELECT 
            cc_visibility,
            COUNT(*) as total,
            (COUNT(*) * 100.0 / (SELECT COUNT(*) FROM office_feedback WHERE feedback_date BETWEEN :start_date1 AND :end_date1)) as percentage
        FROM office_feedback 
        WHERE feedback_date BETWEEN :start_date2 AND :end_date2
        GROUP BY cc_visibility";

        $cc2_stmt = $connect->prepare($cc2_sql);
        $cc2_stmt->bindParam(':start_date1', $start_date);
        $cc2_stmt->bindParam(':end_date1', $end_date);
        $cc2_stmt->bindParam(':start_date2', $start_date);
        $cc2_stmt->bindParam(':end_date2', $end_date);
        $cc2_stmt->execute();
        $cc2_results = $cc2_stmt->fetchAll(PDO::FETCH_ASSOC);
        $cc_stats['visibility'] = $cc2_results;

        // CC3 - Helpfulness Query - Same as original
        $cc3_sql = "SELECT 
            cc_helpfulness,
            COUNT(*) as total,
            (COUNT(*) * 100.0 / (SELECT COUNT(*) FROM office_feedback WHERE feedback_date BETWEEN :start_date1 AND :end_date1)) as percentage
        FROM office_feedback 
        WHERE feedback_date BETWEEN :start_date2 AND :end_date2
        GROUP BY cc_helpfulness";

        $cc3_stmt = $connect->prepare($cc3_sql);
        $cc3_stmt->bindParam(':start_date1', $start_date);
        $cc3_stmt->bindParam(':end_date1', $end_date);
        $cc3_stmt->bindParam(':start_date2', $start_date);
        $cc3_stmt->bindParam(':end_date2', $end_date);
        $cc3_stmt->execute();
        $cc3_results = $cc3_stmt->fetchAll(PDO::FETCH_ASSOC);
        $cc_stats['helpfulness'] = $cc3_results;
    }
    
    // Set headers for Excel download
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="feedback_data.xls"');
    header('Cache-Control: max-age=0');
    
    // Create Excel file content with enhanced styling
    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    echo '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" 
                xmlns:x="urn:schemas-microsoft-com:office:excel" 
                xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet" 
                xmlns:html="http://www.w3.org/TR/REC-html40">' . "\n";
    
    // Add styles section
    echo '<Styles>
        <Style ss:ID="Default" ss:Name="Normal">
            <Alignment ss:Vertical="Bottom"/>
            <Borders/>
            <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"/>
            <Interior/>
            <NumberFormat/>
            <Protection/>
        </Style>
        <Style ss:ID="HeaderStyle">
            <Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/>
            <Borders>
                <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
                <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
                <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
                <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
            </Borders>
            <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#FFFFFF" ss:Bold="1"/>
            <Interior ss:Color="#4472C4" ss:Pattern="Solid"/>
        </Style>
        <Style ss:ID="SectionHeaderStyle">
            <Alignment ss:Horizontal="Left" ss:Vertical="Center"/>
            <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="14" ss:Color="#000000" ss:Bold="1"/>
            <Interior ss:Color="#D9E1F2" ss:Pattern="Solid"/>
        </Style>
        <Style ss:ID="DataCellStyle">
            <Alignment ss:Vertical="Center" ss:WrapText="1"/>
            <Borders>
                <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
                <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
                <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
                <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
            </Borders>
        </Style>
        <Style ss:ID="AlternatingRowStyle">
            <Alignment ss:Vertical="Center" ss:WrapText="1"/>
            <Borders>
                <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
                <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
                <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
                <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
            </Borders>
            <Interior ss:Color="#F2F2F2" ss:Pattern="Solid"/>
        </Style>
        <Style ss:ID="HighRatingStyle">
            <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
            <Borders>
                <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
                <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
                <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
                <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
            </Borders>
            <Interior ss:Color="#C6E0B4" ss:Pattern="Solid"/>
        </Style>
        <Style ss:ID="MediumRatingStyle">
            <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
            <Borders>
                <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
                <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
                <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
                <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
            </Borders>
            <Interior ss:Color="#FFE699" ss:Pattern="Solid"/>
        </Style>
        <Style ss:ID="LowRatingStyle">
            <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
            <Borders>
                <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
                <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
                <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
                <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
            </Borders>
            <Interior ss:Color="#F8CBAD" ss:Pattern="Solid"/>
        </Style>
        <Style ss:ID="ChartTitleStyle">
            <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
            <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="14" ss:Color="#000000" ss:Bold="1"/>
            <Interior ss:Color="#4472C4" ss:Pattern="Solid"/>
        </Style>
        <Style ss:ID="PercentageStyle">
            <NumberFormat ss:Format="0.00\%"/>
        </Style>
    </Styles>' . "\n";
    
    // First worksheet - Individual Feedback Data
    echo '<Worksheet ss:Name="Feedback Data">' . "\n";
    
    // Add worksheet options for better display
    echo '<WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
            <PageSetup>
                <Layout x:Orientation="Landscape"/>
                <Header x:Margin="0.3"/>
                <Footer x:Margin="0.3"/>
                <PageMargins x:Bottom="0.75" x:Left="0.7" x:Right="0.7" x:Top="0.75"/>
            </PageSetup>
            <FitToPage/>
            <Print>
                <FitHeight>0</FitHeight>
                <FitWidth>1</FitWidth>
                <ValidPrinterInfo/>
                <PaperSizeIndex>9</PaperSizeIndex>
                <Scale>100</Scale>
                <HorizontalResolution>600</HorizontalResolution>
                <VerticalResolution>600</VerticalResolution>
            </Print>
            <Selected/>
            <FreezePanes/>
            <FrozenNoSplit/>
            <SplitHorizontal>1</SplitHorizontal>
            <TopRowBottomPane>1</TopRowBottomPane>
            <ActivePane>2</ActivePane>
            <Panes>
                <Pane>
                    <Number>3</Number>
                </Pane>
                <Pane>
                    <Number>2</Number>
                    <ActiveRow>0</ActiveRow>
                </Pane>
            </Panes>
            <ProtectObjects>False</ProtectObjects>
            <ProtectScenarios>False</ProtectScenarios>
        </WorksheetOptions>' . "\n";
    
    // Set column widths for better readability
    echo '<Table ss:ExpandedColumnCount="20" x:FullColumns="1" x:FullRows="1" ss:DefaultColumnWidth="65" ss:DefaultRowHeight="15">' . "\n";
    
    // Define column widths
    if ($feedback_type == 'organization') {
        echo '<Column ss:Width="150"/>' . "\n"; // Organization
    }
    echo '<Column ss:Width="120"/>' . "\n"; // Name
    echo '<Column ss:Width="180"/>' . "\n"; // Email
    echo '<Column ss:Width="120"/>' . "\n"; // Date
    
    // Rating columns width
    $rating_columns = $feedback_type == 'office' ? 9 : 4;
    for ($i = 0; $i < $rating_columns; $i++) {
        echo '<Column ss:Width="65"/>' . "\n";
    }
    
    // CC columns if office feedback
    if ($feedback_type == 'office') {
        echo '<Column ss:Width="100"/>' . "\n"; // CC Awareness
        echo '<Column ss:Width="100"/>' . "\n"; // CC Visibility  
        echo '<Column ss:Width="100"/>' . "\n"; // CC Helpfulness
    }
    
    echo '<Column ss:Width="250"/>' . "\n"; // Improvements
    
    // Add title and date of export
    echo '<Row ss:Height="30">' . "\n";
    echo '<Cell ss:MergeAcross="' . ($feedback_type == 'office' ? '13' : '8') . '" ss:StyleID="ChartTitleStyle"><Data ss:Type="String">' . 
        ($feedback_type == 'office' ? 'Office Feedback Report' : 'Organization Feedback Report') . 
        ' - Generated ' . date('Y-m-d H:i:s') . '</Data></Cell>' . "\n";
    echo '</Row>' . "\n";
    
    // Empty row for spacing
    echo '<Row></Row>' . "\n";
    
    // Header row
    echo '<Row ss:Height="35">' . "\n";
    if ($feedback_type == 'organization') {
        echo '<Cell ss:StyleID="HeaderStyle"><Data ss:Type="String">Organization</Data></Cell>' . "\n";
    }
    echo '<Cell ss:StyleID="HeaderStyle"><Data ss:Type="String">Name</Data></Cell>' . "\n";
    echo '<Cell ss:StyleID="HeaderStyle"><Data ss:Type="String">Email</Data></Cell>' . "\n";
    echo '<Cell ss:StyleID="HeaderStyle"><Data ss:Type="String">Date</Data></Cell>' . "\n";
    
    if ($feedback_type == 'office') {
        $headers = ['Satisfaction', 'Time', 'Requirements', 'Steps', 'Information', 'Value', 'Security', 'Support', 'Outcome'];
        foreach ($headers as $header) {
            echo '<Cell ss:StyleID="HeaderStyle"><Data ss:Type="String">' . $header . '</Data></Cell>' . "\n";
        }
        
        // Add Citizen's Charter headers for office feedback
        echo '<Cell ss:StyleID="HeaderStyle"><Data ss:Type="String">CC Awareness</Data></Cell>' . "\n";
        echo '<Cell ss:StyleID="HeaderStyle"><Data ss:Type="String">CC Visibility</Data></Cell>' . "\n";
        echo '<Cell ss:StyleID="HeaderStyle"><Data ss:Type="String">CC Helpfulness</Data></Cell>' . "\n";
    } else {
        $headers = ['Event Quality', 'Communication', 'Inclusivity', 'Leadership'];
        foreach ($headers as $header) {
            echo '<Cell ss:StyleID="HeaderStyle"><Data ss:Type="String">' . $header . '</Data></Cell>' . "\n";
        }
    }
    
    echo '<Cell ss:StyleID="HeaderStyle"><Data ss:Type="String">Improvements</Data></Cell>' . "\n";
    echo '</Row>' . "\n";
    
    // Data rows with alternating row styles
    $rowCount = 0;
    foreach ($feedbacks as $feedback) {
        $rowStyle = ($rowCount % 2 == 0) ? "DataCellStyle" : "AlternatingRowStyle";
        $rowCount++;
        
        echo '<Row ss:Height="30">' . "\n";
        
        if ($feedback_type == 'organization') {
            echo '<Cell ss:StyleID="' . $rowStyle . '"><Data ss:Type="String">' . htmlspecialchars($feedback['org_name'] ?? '') . '</Data></Cell>' . "\n";
        }
        
        echo '<Cell ss:StyleID="' . $rowStyle . '"><Data ss:Type="String">' . htmlspecialchars($feedback['name'] ?? 'Anonymous') . '</Data></Cell>' . "\n";
        echo '<Cell ss:StyleID="' . $rowStyle . '"><Data ss:Type="String">' . htmlspecialchars($feedback['email'] ?? '') . '</Data></Cell>' . "\n";
        
        $date = $feedback_type == 'office' ? $feedback['created_at'] : $feedback['created_at'];
        echo '<Cell ss:StyleID="' . $rowStyle . '"><Data ss:Type="String">' . htmlspecialchars($date) . '</Data></Cell>' . "\n";
        
        if ($feedback_type == 'office') {
            $rating_keys = ['sqd0_satisfaction', 'sqd1_time', 'sqd2_requirements', 'sqd3_steps', 'sqd4_information', 
                            'sqd5_value', 'sqd6_security', 'sqd7_support', 'sqd8_outcome'];
                            
            foreach ($rating_keys as $key) {
                $rating = isset($feedback[$key]) ? $feedback[$key] : '';
                // Color-code rating cells based on value
                $ratingStyle = $rowStyle;
                if ($rating !== '') {
                    if ($rating >= 4) {
                        $ratingStyle = "HighRatingStyle";
                    } else if ($rating >= 2.5) {
                        $ratingStyle = "MediumRatingStyle";
                    } else {
                        $ratingStyle = "LowRatingStyle";
                    }
                }
                echo '<Cell ss:StyleID="' . $ratingStyle . '"><Data ss:Type="Number">' . $rating . '</Data></Cell>' . "\n";
            }
            
            // Add Citizen's Charter data
            echo '<Cell ss:StyleID="' . $rowStyle . '"><Data ss:Type="String">' . htmlspecialchars($feedback['cc_awareness'] ?? '') . '</Data></Cell>' . "\n";
            echo '<Cell ss:StyleID="' . $rowStyle . '"><Data ss:Type="String">' . htmlspecialchars($feedback['cc_visibility'] ?? '') . '</Data></Cell>' . "\n";
            echo '<Cell ss:StyleID="' . $rowStyle . '"><Data ss:Type="String">' . htmlspecialchars($feedback['cc_helpfulness'] ?? '') . '</Data></Cell>' . "\n";
        } else {
            $rating_keys = ['event_quality_rating', 'communication_rating', 'inclusivity_rating', 'leadership_rating'];
            
            foreach ($rating_keys as $key) {
                $rating = isset($feedback[$key]) ? $feedback[$key] : '';
                // Color-code rating cells based on value
                $ratingStyle = $rowStyle;
                if ($rating !== '') {
                    if ($rating >= 4) {
                        $ratingStyle = "HighRatingStyle";
                    } else if ($rating >= 2.5) {
                        $ratingStyle = "MediumRatingStyle";
                    } else {
                        $ratingStyle = "LowRatingStyle";
                    }
                }
                echo '<Cell ss:StyleID="' . $ratingStyle . '"><Data ss:Type="Number">' . $rating . '</Data></Cell>' . "\n";
            }
        }
        
        echo '<Cell ss:StyleID="' . $rowStyle . '"><Data ss:Type="String">' . htmlspecialchars($feedback['improvements'] ?? '') . '</Data></Cell>' . "\n";
        echo '</Row>' . "\n";
    }
    
    echo '</Table>' . "\n";
    echo '</Worksheet>' . "\n";
    
    // Add Citizen's Charter Summary worksheet for office feedback with improved styling
    if ($feedback_type == 'office' && !empty($cc_stats)) {
        echo '<Worksheet ss:Name="Citizens Charter Summary">' . "\n";
        
        // Add worksheet options
        echo '<WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
                <PageSetup>
                    <Layout x:Orientation="Portrait"/>
                    <Header x:Margin="0.3"/>
                    <Footer x:Margin="0.3"/>
                    <PageMargins x:Bottom="0.75" x:Left="0.7" x:Right="0.7" x:Top="0.75"/>
                </PageSetup>
                <Selected/>
                <ProtectObjects>False</ProtectObjects>
                <ProtectScenarios>False</ProtectScenarios>
            </WorksheetOptions>' . "\n";
        
        echo '<Table ss:ExpandedColumnCount="10" x:FullColumns="1" x:FullRows="1" ss:DefaultColumnWidth="65" ss:DefaultRowHeight="15">' . "\n";
        
        // Define column widths for summary sheet
        echo '<Column ss:Width="150"/>' . "\n"; // Response
        echo '<Column ss:Width="80"/>' . "\n";  // Total
        echo '<Column ss:Width="100"/>' . "\n"; // Percentage
        
        // Main title
        echo '<Row ss:Height="40">' . "\n";
        echo '<Cell ss:MergeAcross="5" ss:StyleID="ChartTitleStyle"><Data ss:Type="String">Citizens Charter Summary Report</Data></Cell>' . "\n";
        echo '</Row>' . "\n";
        
        // Empty row for spacing
        echo '<Row></Row>' . "\n";
        
        // CC Awareness Section with improved header
        echo '<Row ss:Height="30">' . "\n";
        echo '<Cell ss:MergeAcross="5" ss:StyleID="SectionHeaderStyle"><Data ss:Type="String">Citizens Charter Awareness</Data></Cell>' . "\n";
        echo '</Row>' . "\n";
        
        echo '<Row ss:Height="25">' . "\n";
        echo '<Cell ss:StyleID="HeaderStyle"><Data ss:Type="String">Response</Data></Cell>' . "\n";
        echo '<Cell ss:StyleID="HeaderStyle"><Data ss:Type="String">Total</Data></Cell>' . "\n";
        echo '<Cell ss:StyleID="HeaderStyle"><Data ss:Type="String">Percentage</Data></Cell>' . "\n";
        echo '</Row>' . "\n";
        
        $rowCount = 0;
        foreach ($cc_stats['awareness'] as $awareness) {
            $rowStyle = ($rowCount % 2 == 0) ? "DataCellStyle" : "AlternatingRowStyle";
            $rowCount++;
            echo '<Row>' . "\n";
            echo '<Cell ss:StyleID="' . $rowStyle . '"><Data ss:Type="String">' . htmlspecialchars($awareness['cc_awareness']) . '</Data></Cell>' . "\n";
echo '<Cell ss:StyleID="' . $rowStyle . '"><Data ss:Type="Number">' . $awareness['total'] . '</Data></Cell>' . "\n";
echo '<Cell ss:StyleID="' . $rowStyle . '" ss:Formula="=B' . ($rowCount + 4) . '/SUM(B5:B' . (count($cc_stats['awareness']) + 4) . ')*100"><Data ss:Type="Number">' . round($awareness['percentage'], 2) . '</Data></Cell>' . "\n";
echo '</Row>' . "\n";
}

// Empty row for spacing
echo '<Row></Row>' . "\n";

// CC Visibility Section
echo '<Row ss:Height="30">' . "\n";
echo '<Cell ss:MergeAcross="5" ss:StyleID="SectionHeaderStyle"><Data ss:Type="String">Citizens Charter Visibility</Data></Cell>' . "\n";
echo '</Row>' . "\n";

echo '<Row ss:Height="25">' . "\n";
echo '<Cell ss:StyleID="HeaderStyle"><Data ss:Type="String">Response</Data></Cell>' . "\n";
echo '<Cell ss:StyleID="HeaderStyle"><Data ss:Type="String">Total</Data></Cell>' . "\n";
echo '<Cell ss:StyleID="HeaderStyle"><Data ss:Type="String">Percentage</Data></Cell>' . "\n";
echo '</Row>' . "\n";

$rowCount = 0;
foreach ($cc_stats['visibility'] as $visibility) {
    $rowStyle = ($rowCount % 2 == 0) ? "DataCellStyle" : "AlternatingRowStyle";
    $rowCount++;
    echo '<Row>' . "\n";
    echo '<Cell ss:StyleID="' . $rowStyle . '"><Data ss:Type="String">' . htmlspecialchars($visibility['cc_visibility']) . '</Data></Cell>' . "\n";
    echo '<Cell ss:StyleID="' . $rowStyle . '"><Data ss:Type="Number">' . $visibility['total'] . '</Data></Cell>' . "\n";
    echo '<Cell ss:StyleID="' . $rowStyle . '" ss:Formula="=B' . ($rowCount + $baseRow) . '/SUM(B' . ($baseRow + 1) . ':B' . ($baseRow + count($cc_stats['visibility'])) . ')*100"><Data ss:Type="Number">' . round($visibility['percentage'], 2) . '</Data></Cell>' . "\n";
    echo '</Row>' . "\n";
}

// Empty row for spacing
echo '<Row></Row>' . "\n";

// CC Helpfulness Section
echo '<Row ss:Height="30">' . "\n";
echo '<Cell ss:MergeAcross="5" ss:StyleID="SectionHeaderStyle"><Data ss:Type="String">Citizens Charter Helpfulness</Data></Cell>' . "\n";
echo '</Row>' . "\n";

echo '<Row ss:Height="25">' . "\n";
echo '<Cell ss:StyleID="HeaderStyle"><Data ss:Type="String">Response</Data></Cell>' . "\n";
echo '<Cell ss:StyleID="HeaderStyle"><Data ss:Type="String">Total</Data></Cell>' . "\n";
echo '<Cell ss:StyleID="HeaderStyle"><Data ss:Type="String">Percentage</Data></Cell>' . "\n";
echo '</Row>' . "\n";

$rowCount = 0;
foreach ($cc_stats['helpfulness'] as $helpfulness) {
    $rowStyle = ($rowCount % 2 == 0) ? "DataCellStyle" : "AlternatingRowStyle";
    $rowCount++;
    echo '<Row>' . "\n";
    echo '<Cell ss:StyleID="' . $rowStyle . '"><Data ss:Type="String">' . htmlspecialchars($helpfulness['cc_helpfulness']) . '</Data></Cell>' . "\n";
    echo '<Cell ss:StyleID="' . $rowStyle . '"><Data ss:Type="Number">' . $helpfulness['total'] . '</Data></Cell>' . "\n";
    echo '<Cell ss:StyleID="' . $rowStyle . '" ss:Formula="=B' . ($rowCount + $baseRow) . '/SUM(B' . ($baseRow + 1) . ':B' . ($baseRow + count($cc_stats['helpfulness'])) . ')*100"><Data ss:Type="Number">' . round($helpfulness['percentage'], 2) . '</Data></Cell>' . "\n";
    echo '</Row>' . "\n";
}

echo '</Table>' . "\n";
echo '</Worksheet>' . "\n";
}

// Add Summary Statistics Worksheet
echo '<Worksheet ss:Name="Summary Statistics">' . "\n";
echo '<WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
        <PageSetup>
            <Layout x:Orientation="Portrait"/>
            <Header x:Margin="0.3"/>
            <Footer x:Margin="0.3"/>
            <PageMargins x:Bottom="0.75" x:Left="0.7" x:Right="0.7" x:Top="0.75"/>
        </PageSetup>
        <Selected/>
        <ProtectObjects>False</ProtectObjects>
        <ProtectScenarios>False</ProtectScenarios>
    </WorksheetOptions>' . "\n";

echo '<Table ss:ExpandedColumnCount="10" x:FullColumns="1" x:FullRows="1" ss:DefaultColumnWidth="65" ss:DefaultRowHeight="15">' . "\n";

// Define column widths for statistics
echo '<Column ss:Width="200"/>' . "\n"; // Metric
echo '<Column ss:Width="100"/>' . "\n"; // Value

// Main title with date filter info
$dateFilterText = "All Time";
if ($dateFilter != 'all') {
    switch($dateFilter) {
        case 'today':
            $dateFilterText = "Today (" . date('Y-m-d') . ")";
            break;
        case 'week':
            $dateFilterText = "This Week (" . date('Y-m-d', strtotime('monday this week')) . " to " . date('Y-m-d', strtotime('sunday this week')) . ")";
            break;
        case 'month':
            $dateFilterText = "This Month (" . date('Y-m-d', strtotime('first day of this month')) . " to " . date('Y-m-d', strtotime('last day of this month')) . ")";
            break;
    }
}

echo '<Row ss:Height="40">' . "\n";
echo '<Cell ss:MergeAcross="5" ss:StyleID="ChartTitleStyle"><Data ss:Type="String">Feedback Summary Statistics - ' . $dateFilterText . '</Data></Cell>' . "\n";
echo '</Row>' . "\n";

// Empty row for spacing
echo '<Row></Row>' . "\n";

// General Statistics Section
echo '<Row ss:Height="30">' . "\n";
echo '<Cell ss:MergeAcross="5" ss:StyleID="SectionHeaderStyle"><Data ss:Type="String">General Statistics</Data></Cell>' . "\n";
echo '</Row>' . "\n";

// Calculate general statistics
$totalResponses = count($feedbacks);
$averageRatings = [];

if ($feedback_type == 'office') {
    $rating_keys = ['sqd0_satisfaction', 'sqd1_time', 'sqd2_requirements', 'sqd3_steps', 'sqd4_information', 
                    'sqd5_value', 'sqd6_security', 'sqd7_support', 'sqd8_outcome'];
    $rating_labels = ['Overall Satisfaction', 'Processing Time', 'Requirements', 'Steps/Procedure', 'Information', 
                      'Fees/Value', 'Security/Safety', 'Support/Assistance', 'Outcome/Result'];
} else {
    $rating_keys = ['event_quality_rating', 'communication_rating', 'inclusivity_rating', 'leadership_rating'];
    $rating_labels = ['Event Quality', 'Communication', 'Inclusivity', 'Leadership'];
}

// Calculate average ratings
foreach ($rating_keys as $index => $key) {
    $total = 0;
    $count = 0;
    foreach ($feedbacks as $feedback) {
        if (isset($feedback[$key]) && $feedback[$key] > 0) {
            $total += $feedback[$key];
            $count++;
        }
    }
    $averageRatings[$rating_labels[$index]] = $count > 0 ? round($total / $count, 2) : 0;
}

// Add header for statistics table
echo '<Row ss:Height="25">' . "\n";
echo '<Cell ss:StyleID="HeaderStyle"><Data ss:Type="String">Metric</Data></Cell>' . "\n";
echo '<Cell ss:StyleID="HeaderStyle"><Data ss:Type="String">Value</Data></Cell>' . "\n";
echo '</Row>' . "\n";

// Total responses
echo '<Row>' . "\n";
echo '<Cell ss:StyleID="DataCellStyle"><Data ss:Type="String">Total Responses</Data></Cell>' . "\n";
echo '<Cell ss:StyleID="DataCellStyle"><Data ss:Type="Number">' . $totalResponses . '</Data></Cell>' . "\n";
echo '</Row>' . "\n";

// Add average ratings
$rowCount = 0;
foreach ($averageRatings as $label => $avg) {
    $rowStyle = ($rowCount % 2 == 0) ? "DataCellStyle" : "AlternatingRowStyle";
    $rowCount++;
    
    // Determine rating style based on average
    $ratingStyle = "DataCellStyle";
    if ($avg >= 4) {
        $ratingStyle = "HighRatingStyle";
    } else if ($avg >= 2.5) {
        $ratingStyle = "MediumRatingStyle";
    } else if ($avg > 0) {
        $ratingStyle = "LowRatingStyle";
    }
    
    echo '<Row>' . "\n";
    echo '<Cell ss:StyleID="' . $rowStyle . '"><Data ss:Type="String">Average ' . $label . '</Data></Cell>' . "\n";
    echo '<Cell ss:StyleID="' . $ratingStyle . '"><Data ss:Type="Number">' . $avg . '</Data></Cell>' . "\n";
    echo '</Row>' . "\n";
}

// Add a legend section
echo '<Row></Row>' . "\n";
echo '<Row ss:Height="30">' . "\n";
echo '<Cell ss:MergeAcross="5" ss:StyleID="SectionHeaderStyle"><Data ss:Type="String">Rating Legend</Data></Cell>' . "\n";
echo '</Row>' . "\n";

echo '<Row>' . "\n";
echo '<Cell ss:StyleID="DataCellStyle"><Data ss:Type="String">High Rating (4-5)</Data></Cell>' . "\n";
echo '<Cell ss:StyleID="HighRatingStyle"><Data ss:Type="String"></Data></Cell>' . "\n";
echo '</Row>' . "\n";

echo '<Row>' . "\n";
echo '<Cell ss:StyleID="DataCellStyle"><Data ss:Type="String">Medium Rating (2.5-3.9)</Data></Cell>' . "\n";
echo '<Cell ss:StyleID="MediumRatingStyle"><Data ss:Type="String"></Data></Cell>' . "\n";
echo '</Row>' . "\n";

echo '<Row>' . "\n";
echo '<Cell ss:StyleID="DataCellStyle"><Data ss:Type="String">Low Rating (1-2.4)</Data></Cell>' . "\n";
echo '<Cell ss:StyleID="LowRatingStyle"><Data ss:Type="String"></Data></Cell>' . "\n";
echo '</Row>' . "\n";

echo '</Table>' . "\n";
echo '</Worksheet>' . "\n";

echo '</Workbook>';

} catch (PDOException $e) {
    // Log error and output a simple error message
    error_log('Database Error: ' . $e->getMessage());
    header('Content-Type: text/plain');
    echo 'An error occurred while generating the report. Please try again later.';
    exit;
}
?>