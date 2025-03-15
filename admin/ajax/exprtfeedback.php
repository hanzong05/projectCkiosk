<?php
/**
 * Feedback Data Excel Export
 * This script exports the Citizens Charter questions and Service Quality Dimensions
 * data to an Excel file with proper formatting.
 */
include_once('../../class/connection.php');
include_once('../../class/mainClass.php');

// Get filters from request
$dateFilter = isset($_GET['date']) ? $_GET['date'] : 'all';
$orgFilter = isset($_GET['org']) ? $_GET['org'] : 'all';
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

$account_type = isset($_SESSION['atype']) ? $_SESSION['atype'] : '0';

try {
    // Set headers for Excel download
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="feedback_summary.xls"');
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
            <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000" ss:Bold="1"/>
            <Interior ss:Color="#D9E1F2" ss:Pattern="Solid"/>
        </Style>
        <Style ss:ID="TableHeaderStyle">
            <Alignment ss:Horizontal="Left" ss:Vertical="Center"/>
            <Borders>
                <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
                <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
                <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
                <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
            </Borders>
            <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000" ss:Bold="1"/>
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
        <Style ss:ID="QuestionCellStyle">
            <Alignment ss:Vertical="Center" ss:WrapText="1"/>
            <Borders>
                <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
                <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
                <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
                <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
            </Borders>
            <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000" ss:Bold="1"/>
        </Style>
        <Style ss:ID="SubItemCellStyle">
            <Alignment ss:Vertical="Center" ss:WrapText="1"/>
            <Borders>
                <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
                <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
                <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
                <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
            </Borders>
            <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"/>
        </Style>
        <Style ss:ID="TitleStyle">
            <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
            <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="14" ss:Color="#000000" ss:Bold="1"/>
        </Style>
        <Style ss:ID="SectionHeaderStyle">
            <Alignment ss:Horizontal="Left" ss:Vertical="Center"/>
            <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="12" ss:Color="#000000" ss:Bold="1"/>
            <Interior ss:Color="#D9E1F2" ss:Pattern="Solid"/>
        </Style>
        <Style ss:ID="GoodRatingStyle">
            <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
            <Borders>
                <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
                <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
                <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
                <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
            </Borders>
            <Interior ss:Color="#C6E0B4" ss:Pattern="Solid"/>
        </Style>
        <Style ss:ID="FairRatingStyle">
            <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
            <Borders>
                <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
                <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
                <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
                <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
            </Borders>
            <Interior ss:Color="#FFE699" ss:Pattern="Solid"/>
        </Style>
        <Style ss:ID="PoorRatingStyle">
            <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
            <Borders>
                <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
                <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
                <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
                <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
            </Borders>
            <Interior ss:Color="#F8CBAD" ss:Pattern="Solid"/>
        </Style>
        <Style ss:ID="NumericCellStyle">
            <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
            <Borders>
                <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
                <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
                <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
                <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
            </Borders>
            <NumberFormat ss:Format="0"/>
        </Style>
        <Style ss:ID="PercentageCellStyle">
            <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
            <Borders>
                <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
                <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
                <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
                <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D0D7E5"/>
            </Borders>
            <NumberFormat ss:Format="0.00\%"/>
        </Style>
    </Styles>' . "\n";
    
    // Add Worksheet for the feedback summary data
    echo '<Worksheet ss:Name="Feedback Summary">' . "\n";
    
    // Add worksheet options
    echo '<WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
            <PageSetup>
                <Layout x:Orientation="Portrait"/>
                <Header x:Margin="0.3"/>
                <Footer x:Margin="0.3"/>
                <PageMargins x:Bottom="0.75" x:Left="0.7" x:Right="0.7" x:Top="0.75"/>
            </PageSetup>
            <Print>
                <ValidPrinterInfo/>
                <PaperSizeIndex>9</PaperSizeIndex>
                <Scale>100</Scale>
                <HorizontalResolution>600</HorizontalResolution>
                <VerticalResolution>600</VerticalResolution>
            </Print>
            <Selected/>
            <ProtectObjects>False</ProtectObjects>
            <ProtectScenarios>False</ProtectScenarios>
        </WorksheetOptions>' . "\n";
    
    // Begin table
    echo '<Table ss:ExpandedColumnCount="8" x:FullColumns="1" x:FullRows="1" ss:DefaultColumnWidth="65" ss:DefaultRowHeight="15">' . "\n";
    
    // Define column widths
    echo '<Column ss:Width="250"/>' . "\n"; // Question column
    echo '<Column ss:Width="100"/>' . "\n"; // Responses
    echo '<Column ss:Width="100"/>' . "\n"; // Percentage
    echo '<Column ss:Width="20"/>' . "\n";  // Spacer
    echo '<Column ss:Width="250"/>' . "\n"; // SQD
    echo '<Column ss:Width="100"/>' . "\n"; // Responses 
    echo '<Column ss:Width="100"/>' . "\n"; // Percentage
    echo '<Column ss:Width="100"/>' . "\n"; // Overall

    // Title Row
    echo '<Row ss:Height="30">' . "\n";
    echo '<Cell ss:MergeAcross="7" ss:StyleID="TitleStyle"><Data ss:Type="String">Feedback Summary Report</Data></Cell>' . "\n";
    echo '</Row>' . "\n";
    
    // Empty row for spacing
    echo '<Row ss:Height="10"></Row>' . "\n";
    
    // CC Questions section header
    echo '<Row ss:Height="25">' . "\n";
    echo '<Cell ss:MergeAcross="2" ss:StyleID="SectionHeaderStyle"><Data ss:Type="String">Citizen\'s Charter (CC) Questions</Data></Cell>' . "\n";
    echo '</Row>' . "\n";
    
    // Headers for CC section
    echo '<Row ss:Height="20">' . "\n";
    echo '<Cell ss:StyleID="TableHeaderStyle"><Data ss:Type="String">Question</Data></Cell>' . "\n";
    echo '<Cell ss:StyleID="TableHeaderStyle"><Data ss:Type="String">Responses</Data></Cell>' . "\n";
    echo '<Cell ss:StyleID="TableHeaderStyle"><Data ss:Type="String">Percentage</Data></Cell>' . "\n";
    echo '</Row>' . "\n";
    
    // Add CC1 - Awareness
    echo '<Row ss:Height="20">' . "\n";
    echo '<Cell ss:StyleID="QuestionCellStyle"><Data ss:Type="String">CC1: Which of the following best describes your awareness of a CC?</Data></Cell>' . "\n";
    echo '</Row>' . "\n";
    
    // CC1 responses
    $cc1_responses = [
        ['awareness' => 'aware_not_saw', 'label' => 'Aware but did not see', 'total' => 1, 'percentage' => 20.00],
        ['awareness' => 'aware_saw', 'label' => 'Aware and saw', 'total' => 1, 'percentage' => 20.00],
        ['awareness' => 'learned', 'label' => 'Learned during visit', 'total' => 2, 'percentage' => 40.00],
        ['awareness' => 'unaware', 'label' => 'Unaware', 'total' => 1, 'percentage' => 20.00]
    ];
    
    foreach ($cc1_responses as $response) {
        echo '<Row>' . "\n";
        echo '<Cell ss:StyleID="SubItemCellStyle"><Data ss:Type="String">' . htmlspecialchars($response['label']) . '</Data></Cell>' . "\n";
        echo '<Cell ss:StyleID="NumericCellStyle"><Data ss:Type="Number">' . $response['total'] . '</Data></Cell>' . "\n";
        echo '<Cell ss:StyleID="PercentageCellStyle"><Data ss:Type="Number">' . $response['percentage'] . '</Data></Cell>' . "\n";
        echo '</Row>' . "\n";
    }
    
    // Empty row for spacing
    echo '<Row ss:Height="10"></Row>' . "\n";
    
    // Add CC2 - Visibility
    echo '<Row ss:Height="20">' . "\n";
    echo '<Cell ss:StyleID="QuestionCellStyle"><Data ss:Type="String">CC2: If aware of CC, would you say that the CC of this office was:</Data></Cell>' . "\n";
    echo '</Row>' . "\n";
    
    // CC2 responses
    $cc2_responses = [
        ['visibility' => 'not_specified', 'label' => 'Not specified', 'total' => 4, 'percentage' => 80.00],
        ['visibility' => 'easy', 'label' => 'Easy to find', 'total' => 1, 'percentage' => 20.00]
    ];
    
    foreach ($cc2_responses as $response) {
        echo '<Row>' . "\n";
        echo '<Cell ss:StyleID="SubItemCellStyle"><Data ss:Type="String">' . htmlspecialchars($response['label']) . '</Data></Cell>' . "\n";
        echo '<Cell ss:StyleID="NumericCellStyle"><Data ss:Type="Number">' . $response['total'] . '</Data></Cell>' . "\n";
        echo '<Cell ss:StyleID="PercentageCellStyle"><Data ss:Type="Number">' . $response['percentage'] . '</Data></Cell>' . "\n";
        echo '</Row>' . "\n";
    }
    
    // Empty row for spacing
    echo '<Row ss:Height="10"></Row>' . "\n";
    
    // Add CC3 - Helpfulness
    echo '<Row ss:Height="20">' . "\n";
    echo '<Cell ss:StyleID="QuestionCellStyle"><Data ss:Type="String">CC3: If aware of CC, How much did the CC help you in your transaction?</Data></Cell>' . "\n";
    echo '</Row>' . "\n";
    
    // CC3 responses
    $cc3_responses = [
        ['helpfulness' => 'not_specified', 'label' => 'Not specified', 'total' => 4, 'percentage' => 80.00],
        ['helpfulness' => 'helped_very_much', 'label' => 'Helped very much', 'total' => 1, 'percentage' => 20.00]
    ];
    
    foreach ($cc3_responses as $response) {
        echo '<Row>' . "\n";
        echo '<Cell ss:StyleID="SubItemCellStyle"><Data ss:Type="String">' . htmlspecialchars($response['label']) . '</Data></Cell>' . "\n";
        echo '<Cell ss:StyleID="NumericCellStyle"><Data ss:Type="Number">' . $response['total'] . '</Data></Cell>' . "\n";
        echo '<Cell ss:StyleID="PercentageCellStyle"><Data ss:Type="Number">' . $response['percentage'] . '</Data></Cell>' . "\n";
        echo '</Row>' . "\n";
    }
    
    // Empty row for spacing
    echo '<Row ss:Height="20"></Row>' . "\n";
    
    // SQD section header
    echo '<Row ss:Height="25">' . "\n";
    echo '<Cell ss:MergeAcross="7" ss:StyleID="SectionHeaderStyle"><Data ss:Type="String">Service Quality Dimensions (SQD)</Data></Cell>' . "\n";
    echo '</Row>' . "\n";
    
    // Headers for SQD section
    echo '<Row ss:Height="20">' . "\n";
    echo '<Cell ss:StyleID="TableHeaderStyle"><Data ss:Type="String">SQD</Data></Cell>' . "\n";
    echo '<Cell ss:StyleID="TableHeaderStyle"><Data ss:Type="String">Service Quality Dimensions (SQD)</Data></Cell>' . "\n";
    echo '<Cell ss:MergeAcross="1" ss:StyleID="TableHeaderStyle"><Data ss:Type="String">Strongly Disagree</Data></Cell>' . "\n";
    echo '<Cell ss:StyleID="TableHeaderStyle"><Data ss:Type="String">Disagree</Data></Cell>' . "\n";
    echo '<Cell ss:StyleID="TableHeaderStyle"><Data ss:Type="String">Neither Agree nor Disagree</Data></Cell>' . "\n";
    echo '<Cell ss:StyleID="TableHeaderStyle"><Data ss:Type="String">Agree</Data></Cell>' . "\n";
    echo '<Cell ss:StyleID="TableHeaderStyle"><Data ss:Type="String">Strongly Agree</Data></Cell>' . "\n";
    echo '<Cell ss:StyleID="TableHeaderStyle"><Data ss:Type="String">N/A</Data></Cell>' . "\n";
    echo '<Cell ss:StyleID="TableHeaderStyle"><Data ss:Type="String">Total Responses</Data></Cell>' . "\n";
    echo '<Cell ss:StyleID="TableHeaderStyle"><Data ss:Type="String">Overall</Data></Cell>' . "\n";
    echo '</Row>' . "\n";
    
    // SQD data
    $sqd_data = [
        [
            'code' => 'SQD0',
            'description' => 'I am satisfied with the service that I availed.',
            'counts' => [0, 0, 2, 2, 1, 0],
            'total' => 5,
            'overall' => 60.00
        ],
        [
            'code' => 'SQD1',
            'description' => 'I spent a reasonable amount of time for my transaction.',
            'counts' => [0, 0, 1, 1, 2, 0],
            'total' => 5,
            'overall' => 60.00
        ],
        [
            'code' => 'SQD2',
            'description' => 'The office followed the transaction\'s requirements and steps.',
            'counts' => [0, 0, 1, 3, 1, 0],
            'total' => 5,
            'overall' => 80.00
        ],
        [
            'code' => 'SQD3',
            'description' => 'The steps were easy and simple.',
            'counts' => [0, 0, 0, 3, 2, 0],
            'total' => 5,
            'overall' => 100.00
        ],
        [
            'code' => 'SQD4',
            'description' => 'I easily found information about my transaction.',
            'counts' => [0, 0, 0, 3, 2, 0],
            'total' => 5,
            'overall' => 100.00
        ],
        [
            'code' => 'SQD5',
            'description' => 'I paid the correct amount of fees.',
            'counts' => [0, 0, 1, 1, 3, 0],
            'total' => 5,
            'overall' => 80.00
        ],
        [
            'code' => 'SQD6',
            'description' => 'I feel the office was fair to everyone.',
            'counts' => [0, 0, 2, 1, 2, 0],
            'total' => 5,
            'overall' => 60.00
        ],
        [
            'code' => 'SQD7',
            'description' => 'I was treated courteously by the staff.',
            'counts' => [0, 0, 1, 2, 2, 0],
            'total' => 5,
            'overall' => 80.00
        ],
        [
            'code' => 'SQD8',
            'description' => 'I got what I needed from the office.',
            'counts' => [0, 0, 0, 0, 4, 0],
            'total' => 5,
            'overall' => 80.00
        ]
    ];
    
    // Total counts for each response level
    $total_strongly_disagree = 0;
    $total_disagree = 0;
    $total_neutral = 0;
    $total_agree = 0;
    $total_strongly_agree = 0;
    $total_na = 0;
    $total_responses = 0;
    
    // Output each SQD row
    foreach ($sqd_data as $sqd) {
        echo '<Row ss:Height="20">' . "\n";
        echo '<Cell ss:StyleID="DataCellStyle"><Data ss:Type="String">' . $sqd['code'] . '</Data></Cell>' . "\n";
        echo '<Cell ss:StyleID="DataCellStyle"><Data ss:Type="String">' . htmlspecialchars($sqd['description']) . '</Data></Cell>' . "\n";
        echo '<Cell ss:StyleID="NumericCellStyle"><Data ss:Type="Number">' . $sqd['counts'][0] . '</Data></Cell>' . "\n";
        echo '<Cell ss:StyleID="NumericCellStyle"><Data ss:Type="Number">' . $sqd['counts'][1] . '</Data></Cell>' . "\n";
        echo '<Cell ss:StyleID="NumericCellStyle"><Data ss:Type="Number">' . $sqd['counts'][2] . '</Data></Cell>' . "\n";
        echo '<Cell ss:StyleID="NumericCellStyle"><Data ss:Type="Number">' . $sqd['counts'][3] . '</Data></Cell>' . "\n";
        echo '<Cell ss:StyleID="NumericCellStyle"><Data ss:Type="Number">' . $sqd['counts'][4] . '</Data></Cell>' . "\n";
        echo '<Cell ss:StyleID="NumericCellStyle"><Data ss:Type="Number">' . $sqd['counts'][5] . '</Data></Cell>' . "\n";
        echo '<Cell ss:StyleID="NumericCellStyle"><Data ss:Type="Number">' . $sqd['total'] . '</Data></Cell>' . "\n";
        
        // Determine cell style based on overall percentage
        $styleID = ($sqd['overall'] >= 80) ? "GoodRatingStyle" : (($sqd['overall'] >= 60) ? "FairRatingStyle" : "PoorRatingStyle");
        echo '<Cell ss:StyleID="' . $styleID . '"><Data ss:Type="Number">' . $sqd['overall'] . '</Data></Cell>' . "\n";
        echo '</Row>' . "\n";
        
        // Accumulate totals
        $total_strongly_disagree += $sqd['counts'][0];
        $total_disagree += $sqd['counts'][1];
        $total_neutral += $sqd['counts'][2];
        $total_agree += $sqd['counts'][3];
        $total_strongly_agree += $sqd['counts'][4];
        $total_na += $sqd['counts'][5];
        $total_responses += $sqd['total'];
    }
    
    // Calculate overall percentage
    $overall_percentage = ($total_agree + $total_strongly_agree) / ($total_responses - $total_na) * 100;
    
    // Output the Overall Rating row
    echo '<Row ss:Height="25">' . "\n";
    echo '<Cell ss:StyleID="QuestionCellStyle"><Data ss:Type="String">Overall Rating</Data></Cell>' . "\n";
    echo '<Cell ss:StyleID="DataCellStyle"><Data ss:Type="String"></Data></Cell>' . "\n";
    echo '<Cell ss:StyleID="NumericCellStyle"><Data ss:Type="Number">' . $total_strongly_disagree . '</Data></Cell>' . "\n";
    echo '<Cell ss:StyleID="NumericCellStyle"><Data ss:Type="Number">' . $total_disagree . '</Data></Cell>' . "\n";
    echo '<Cell ss:StyleID="NumericCellStyle"><Data ss:Type="Number">' . $total_neutral . '</Data></Cell>' . "\n";
    echo '<Cell ss:StyleID="NumericCellStyle"><Data ss:Type="Number">' . $total_agree . '</Data></Cell>' . "\n";
    echo '<Cell ss:StyleID="NumericCellStyle"><Data ss:Type="Number">' . $total_strongly_agree . '</Data></Cell>' . "\n";
    echo '<Cell ss:StyleID="NumericCellStyle"><Data ss:Type="Number">' . $total_na . '</Data></Cell>' . "\n";
    echo '<Cell ss:StyleID="NumericCellStyle"><Data ss:Type="Number">' . $total_responses . '</Data></Cell>' . "\n";
    
    // Determine overall style
    $overallStyleID = ($overall_percentage >= 80) ? "GoodRatingStyle" : (($overall_percentage >= 60) ? "FairRatingStyle" : "PoorRatingStyle");
    echo '<Cell ss:StyleID="' . $overallStyleID . '"><Data ss:Type="Number">' . round($overall_percentage, 2) . '</Data></Cell>' . "\n";
    echo '</Row>' . "\n";
    
    // Add Rating Legend row
    echo '<Row ss:Height="25">' . "\n";
    echo '<Cell ss:MergeAcross="9" ss:StyleID="QuestionCellStyle"><Data ss:Type="String">Rating: ';
    
    // Determine the rating text
    if ($overall_percentage >= 95) {
        echo "Excellent";
    } else if ($overall_percentage >= 90) {
        echo "Very Satisfactory";
    } else if ($overall_percentage >= 85) {
        echo "Satisfactory";
    } else if ($overall_percentage >= 80) {
        echo "Fair";
    } else {
        echo "Poor";
    }
    
    echo '</Data></Cell>' . "\n";
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