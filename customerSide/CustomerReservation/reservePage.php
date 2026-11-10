<?php
require_once '../config.php';
session_start();

// Reservation status message
$reservationStatus = $_GET['reservation'] ?? null;
if ($reservationStatus === 'success') {
    echo '<script>
        alert("Table Successfully Reserved!");
        window.location.href = "../home/home.php#hero";
    </script>';
}

// Default values
$defaultReservationDate = '';
$defaultReservationTime = '';
$defaultHeadCount = 1;

if (isset($_GET['reservation_date'])) $defaultReservationDate = $_GET['reservation_date'];
if (isset($_GET['reservation_time'])) $defaultReservationTime = $_GET['reservation_time'];
if (isset($_GET['head_count'])) $defaultHeadCount = $_GET['head_count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Customer Reservation</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
    body {
        font-family: 'Montserrat', sans-serif;
        background: linear-gradient(to bottom, #252a34, #1b1e27);
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        margin:0;
    }

    .reserve-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 30px;
        max-width: 900px;
        width: 100%;
        padding: 20px;
    }

    .column {
        flex: 1 1 350px;
    }

    .card {
        background-color: #2c313c;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.4);
    }

    .card h2 {
        color: #f5f5f5;
        margin-bottom: 20px;
        text-align:center;
    }

    label {
        font-weight: bold;
        color: #f5f5f5;
    }

    .form-control {
        background-color: #3a3f4c;
        border: none;
        color: #f5f5f5;
    }

    .form-control:focus {
        background-color: #3a3f4c;
        color: #f5f5f5;
        box-shadow: none;
        border-color: #888;
    }

    /* readonly input dark background */
    input[readonly] {
        background-color: #3a3f4c !important;
        color: #f5f5f5 !important;
    }

    .btn-primary {
        background-color: #1abc9c;
        border: none;
        width: 100%;
        font-weight: bold;
    }

    .btn-primary:hover {
        background-color: #16a085;
    }

    h1.nav-title {
        text-align: center;
        font-family: Copperplate, sans-serif;
        color: #ffffff;
        margin-bottom: 30px;
        letter-spacing: 2px;
    }

    .datetime-row, .headcount-row {
        display: flex;
        gap: 10px;
    }

    /* Adjust width of select in headcount */
    .headcount-row select {
        width: 100px;
    }
</style>
</head>
<body>

<div class="container reserve-container">
    <h1 class="nav-title">---UPSI'S RESTAURANT---</h1>

    <!-- LEFT COLUMN: Reserve Time -->
    <div class="column">
        <div class="card">
            <h2>Select Time</h2>
            <form method="GET" action="">
                <div class="form-group">
                    <label for="reservation_date">Date</label>
                    <input type="date" class="form-control" id="reservation_date" name="reservation_date" value="<?= htmlspecialchars($defaultReservationDate) ?>" required>
                </div>

                <div class="form-group">
                    <label for="reservation_time">Time</label>
                    <select name="reservation_time" id="reservation_time" class="form-control" required>
                        <option value="" disabled>Select Time</option>
                        <?php
                        for ($hour = 10; $hour <= 20; $hour++) {
                            $time = sprintf('%02d:00:00', $hour);
                            $selected = ($defaultReservationTime == $time) ? "selected" : "";
                            echo "<option value='$time' $selected>$time</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="head_count">Number of People</label>
                    <select name="head_count" id="head_count" class="form-control" required>
                        <?php
                        for ($i=1; $i<=10; $i++) {
                            $selected = ($defaultHeadCount == $i) ? "selected" : "";
                            echo "<option value='$i' $selected>$i</option>";
                        }
                        ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Enter</button>
            </form>
        </div>
    </div>

    <!-- RIGHT COLUMN: Make Reservation -->
    <div class="column">
        <div class="card">
            <h2>Make Reservation</h2>
            <form method="POST" action="insertReservation.php">
                <div class="form-group">
                    <label for="customer_name">Customer Name</label>
                    <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                </div>

                <div class="form-group">
                    <label>Reservation Date & Time</label>
                    <div class="datetime-row">
                        <input type="date" class="form-control" name="reservation_date" id="reservation_date_right" value="<?= htmlspecialchars($defaultReservationDate) ?>" readonly required>
                        <input type="time" class="form-control" name="reservation_time" id="reservation_time_right" value="<?= htmlspecialchars($defaultReservationTime) ?>" readonly required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Head Count</label>
                    <input type="number" class="form-control" name="head_count_right" id="head_count_right" value="<?= htmlspecialchars($defaultHeadCount) ?>" readonly required>
                </div>

                <div class="form-group">
                    <label for="special_request">Special Request</label>
                    <textarea class="form-control" id="special_request" name="special_request"></textarea>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Make Reservation</button>
            </form>
        </div>
    </div>
</div>

<script>
    // Sync left to right form
    const leftDate = document.getElementById('reservation_date');
    const leftTime = document.getElementById('reservation_time');
    const leftHead = document.getElementById('head_count');

    const rightDate = document.getElementById('reservation_date_right');
    const rightTime = document.getElementById('reservation_time_right');
    const rightHead = document.getElementById('head_count_right');

    leftDate.addEventListener('change', () => rightDate.value = leftDate.value);
    leftTime.addEventListener('change', () => rightTime.value = leftTime.value);
    leftHead.addEventListener('change', () => rightHead.value = leftHead.value);
</script>

</body>
</html>
