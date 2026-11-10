<?php
session_start(); // Ensure session is started
?>
<?php include '../inc/dashHeader.php'; ?>

<?php
require_once '../config.php';

$reservationStatus = $_GET['reservation'] ?? null;
$message = '';
if ($reservationStatus === 'success') {
    $message = "Reservation successful";
}
$head_count = $_GET['head_count'] ?? 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Reservation</title>    
<style>
    .wrapper { 
        width: 1300px; 
        padding-left: 200px; 
        padding-top: 80px;  
    }
    .form-group label {
        font-weight: bold;
    }
    .form-control {
        width: 200px;
        padding: 5px;
    }
    .datetime-row {
        display: flex;
        gap: 10px;
        align-items: center;
    }
    .headcount-row label {
        display: block;
        margin-bottom: 5px;
    }
</style>
</head>
<body>
<div class="wrapper">
    <h3>Enter Time</h3>
    
    <!-- LEFT COLUMN: Enter Date, Time, Head Count -->
    <div id="Search Table">
        <form id="reservation-form-left" class="ht-600 w-50" onsubmit="return false;">
            <div class="form-group">
                <label for="reservation_date">Select Date</label><br>
                <input class="form-control" type="date" id="reservation_date" name="reservation_date" required><br>
            </div>
            
            <div class="form-group"> 
                <label for="reservation_time">Select Time</label>
                <select name="reservation_time" id="reservation_time" class="form-control" required>
                    <option value="" selected disabled>Select a Time</option>
                    <?php
                    for ($hour = 10; $hour <= 20; $hour++) {
                        $time = sprintf('%02d:00:00', $hour);
                        echo "<option value='$time'>$time</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Head count selection -->
            <div class="form-group headcount-row">
                <label for="head_count">Head Count</label>
                <select name="head_count" id="head_count" class="form-control" required>
                    <?php
                    for ($i=1; $i<=10; $i++) {
                        $selected = ($head_count == $i) ? "selected" : "";
                        echo "<option value='$i' $selected>$i</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Set Time Button -->
            <div class="form-group mt-2">
                <button type="button" id="set_time_btn" class="btn btn-dark">Set Time</button>
            </div>
        </form>
    </div>

    <!-- RIGHT COLUMN: Make the Reservation -->
    <div id="insert-reservation-into-table"><br>
        <h3>Make the Reservation</h3>
        
        <form id="reservation-form-right" method="POST" action="insertReservation.php" class="ht-600 w-50">
            
            <div class="form-group">
                <label for="customer_name">Customer Name</label><br>
                <input type="text" id="customer_name" name="customer_name" class="form-control" required placeholder="Johnny Hatsoff"><br>
            </div>
            
            <?php
            $defaultReservationDate = '';
            $defaultReservationTime = '';
            $defaultHeadCount = 1;
            ?>
            
            <div class="form-group datetime-row">
                <label for="reservation_date_right">Date & Time</label>
                <input type="date" id="reservation_date_right" name="reservation_date" value="<?= $defaultReservationDate ?>" readonly required>
                <input type="time" id="reservation_time_right" name="reservation_time" value="<?= $defaultReservationTime ?>" readonly required>
            </div>
            <br>

            <div class="form-group headcount-row">
                <label for="head_count_right">Number of People</label>
                <input type="number" id="head_count_right" name="head_count" class="form-control" value="<?= $defaultHeadCount ?>" readonly required>
            </div>
            <br>
            
            <div class="form-group">
                <label for="special_request">Special request:</label><br>
                <input type="text" id="special_request" name="special_request" class="form-control" placeholder="One baby chair"><br>
            </div>
            
            <div class="form-group mt-2">
                <input type="submit" name="submit" class="btn btn-dark" value="Make Reservation">
            </div>                        
        </form>
    </div>
</div>

<script>
    const leftDate = document.getElementById("reservation_date");
    const leftTime = document.getElementById("reservation_time");
    const leftHead = document.getElementById("head_count");

    const rightDate = document.getElementById("reservation_date_right");
    const rightTime = document.getElementById("reservation_time_right");
    const rightHead = document.getElementById("head_count_right");

    const setTimeBtn = document.getElementById("set_time_btn");

    setTimeBtn.addEventListener("click", () => {
        // 复制左边选择的日期、时间、人数到右边表单
        rightDate.value = leftDate.value;
        rightTime.value = leftTime.value;
        rightHead.value = leftHead.value;
    });
</script>
</body>
</html>
