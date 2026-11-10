<?php
// reservation.php
require_once '../config.php';
session_start();

$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $customer_name    = $_POST["customer_name"]    ?? '';
    $reservation_time = $_POST["reservation_time"] ?? '';
    $reservation_date = $_POST["reservation_date"] ?? '';
    $special_request  = $_POST["special_request"]  ?? '';
    $head_count       = $_POST["head_count"]       ?? 1;


    if ($customer_name && $reservation_time && $reservation_date) {

    
        $reservation_id = time(); 

        $insert_query = "
            INSERT INTO reservations
            (reservation_id, customer_name, reservation_time, reservation_date, head_count, special_request)
            VALUES
            ('$reservation_id', '$customer_name', '$reservation_time', '$reservation_date', '$head_count', '$special_request')
        ";

        if (mysqli_query($link, $insert_query)) {
            $_SESSION['customer_name'] = $customer_name;
            $success = true;
        }
    }
}
?>

<?php
$iconClass = $success ? 'fa-check-circle' : 'fa-times-circle';
$cardClass = $success ? 'alert-success' : 'alert-danger';
$bgColor   = $success ? "#D4F4DD" : "#FFA7A7";
$message   = $success ? "Reservation Created Successfully!" : "Reservation Failed!";
?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
    <style>
        body {
            text-align: center;
            padding: 40px 0;
            background: #EBF0F5;
        }
        h1 {
            font-family: "Nunito Sans", sans-serif;
            font-weight: 900;
            font-size: 40px;
            margin-bottom: 10px;
            color: #88B04B;
        }
        p {
            font-family: "Nunito Sans", sans-serif;
            font-size: 20px;
            color: #404F5E;
        }
        .card {
            background: <?php echo $bgColor; ?>;
            padding: 60px;
            border-radius: 6px;
            box-shadow: 0 2px 3px #C8D0D8;
            display: inline-block;
            margin: 0 auto;
        }
        .checkmark {
            font-size: 100px;
            line-height: 200px;
            color: <?php echo $success ? '#5DBE6F' : '#F25454'; ?>;
        }
    </style>
</head>
<body>

<div class="card <?php echo $cardClass; ?>">
    <div style="border-radius:200px;height:200px;width:200px;background:#F8FAF5;margin:0 auto;">
        <div class="checkmark">
            <?php echo $success ? '✓' : '✘'; ?>
        </div>
    </div>
    <h1><?php echo $success ? 'Success' : 'Error'; ?></h1>
    <p><?php echo $message; ?></p>
</div>

<div style="margin-top:20px;">
    Redirecting back in <span id="countdown">3</span>
</div>

<script>
    let i = 3;
    const countdown = document.getElementById("countdown");

    const timer = setInterval(() => {
        i--;
        countdown.textContent = i;
        if (i <= 0) {
            clearInterval(timer);
            window.location.href = "../panel/reservation-panel.php";
        }
    }, 1000);
</script>

</body>
</html>
