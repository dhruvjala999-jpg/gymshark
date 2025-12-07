<?php
include("connection.php");
header('Content-Type: application/json');

$sql = "SELECT * FROM supplements";
$result = $conn->query($sql);

$supplements = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $supplements[] = $row;
    }
}

echo json_encode($supplements);
$conn->close();
?>
