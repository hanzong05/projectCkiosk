<?php
$username = "root";
$password = "";

try {
    $connect = new PDO("mysql:host=localhost;dbname=ckiosk", $username, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Fetch room data from database
    $stmt = $connect->query("SELECT room_id, room_name FROM rooms");
    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Define coordinates for rooms
    $coordinates = [
        19 => ['x' => 140.5, 'y' => 140.5, 'width' => 95, 'height' => 63],
        20 => ['x' => 140.5, 'y' => 204.5, 'width' => 95, 'height' => 30],
        21 => ['x' => 630.5, 'y' => 140.5, 'width' => 95, 'height' => 63],
        // Add more coordinates mapping the room IDs with positions here...
    ];

    header('Content-Type: image/svg+xml');
    echo '<svg width="866" height="581" viewBox="0 0 866 581" fill="none" xmlns="http://www.w3.org/2000/svg">';

    foreach ($rooms as $room) {
        $roomId = $room['room_id'];
        $roomName = $room['room_name'];

        // Check if the room has coordinates in the SVG
        if (isset($coordinates[$roomId])) {
            $x = $coordinates[$roomId]['x'];
            $y = $coordinates[$roomId]['y'];
            $width = $coordinates[$roomId]['width'];
            $height = $coordinates[$roomId]['height'];

            // Generate rectangle for the room
            echo "<rect x='$x' y='$y' width='$width' height='$height' fill='#D9D9D9' stroke='black' />";
            // Add text (room name) inside the rectangle
            echo "<text x='" . ($x + $width / 2) . "' y='" . ($y + $height / 2) . "' font-family='Arial' font-size='12' text-anchor='middle' alignment-baseline='middle'>$roomName</text>";
        }
    }

    echo '</svg>';

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
