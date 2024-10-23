<?php
$username = "root";
$password = "";

try {
    $connect = new PDO("mysql:host=localhost;dbname=ckiosk", $username, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Fetch room data from database, including floor_id
    $stmt = $connect->query("SELECT room_id, room_name, floor_id FROM room_tbl"); // Added floor_id
    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Data</title>
    <style>
        /* Add your CSS styles here */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h1>Room Data</h1>
<table>
    <thead>
        <tr>
            <th>Room ID</th>
            <th>Room Name</th>
            <th>Floor ID</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($rooms as $room): ?>
            <tr>
                <td><?php echo htmlspecialchars($room['room_id']); ?></td>
                <td><?php echo htmlspecialchars($room['room_name']); ?></td>
                <td><?php echo htmlspecialchars($room['floor_id']); ?></td> <!-- This will now work -->
                <td>
                    <button onclick="editRoom(<?php echo $room['room_id']; ?>)">Edit</button>
                    <button onclick="copyRoom(<?php echo $room['room_id']; ?>)">Copy</button>
                    <button onclick="deleteRoom(<?php echo $room['room_id']; ?>)">Delete</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    function editRoom(id) {
        alert("Edit room ID: " + id);
    }

    function copyRoom(id) {
        alert("Copy room ID: " + id);
    }

    function deleteRoom(id) {
        if (confirm("Are you sure you want to delete room ID: " + id + "?")) {
            alert("Deleted room ID: " + id);
        }
    }
</script>

</body>
</html>
