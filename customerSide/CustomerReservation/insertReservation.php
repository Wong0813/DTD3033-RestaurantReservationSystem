<?php
// insertReservation.php
require_once '../config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = $_POST["customer_name"];
    $reservation_time = $_POST["reservation_time"];
    $reservation_date = $_POST["reservation_date"];
    $special_request = $_POST["special_request"];
    $head_count = $_POST['head_count_right'] ?? 1;

    // Generate a unique numeric ID within INT range
    $reservation_id = rand(100000, 99999999); // 6-8 digits, safe for INT column

    // Insert into Reservations table
    $stmt = mysqli_prepare($link, "INSERT INTO Reservations (reservation_id, customer_name, reservation_time, reservation_date, head_count, special_request) VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "isssis", $reservation_id, $customer_name, $reservation_time, $reservation_date, $head_count, $special_request);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['customer_name'] = $customer_name;
        header("Location: reservePage.php?reservation=success&reservation_id=$reservation_id");
        exit();
    } else {
        echo "Error inserting reservation: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($link);
}
?>
