<?php
// Include config file
require_once "../config.php";

// Check if the reservation_id parameter is set in the URL
if (isset($_GET['id'])) {
    // Get the reservation_id from the URL and sanitize it
    $reservation_id = intval($_GET['id']);

    // Prepare the DELETE query for the reservation
    $deleteReservationSQL = "DELETE FROM Reservations WHERE reservation_id = ?";
    
    if ($stmt = mysqli_prepare($link, $deleteReservationSQL)) {
        mysqli_stmt_bind_param($stmt, "i", $reservation_id);
        
        if (mysqli_stmt_execute($stmt)) {
            // Successfully deleted, redirect back to reservation panel
            header("Location: ../panel/reservation-panel.php");
            exit();
        } else {
            // Error occurred during deletion
            echo "Error deleting reservation: " . mysqli_stmt_error($stmt);
        }
        
        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Error preparing the statement
        echo "Error preparing statement: " . mysqli_error($link);
    }

    // Close the database connection
    mysqli_close($link);
} else {
    // If no reservation ID is provided
    echo "No reservation ID provided.";
}
?>
