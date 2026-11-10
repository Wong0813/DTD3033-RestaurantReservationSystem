<?php
session_start();
require_once '../posBackend/checkIfLoggedIn.php';
include '../inc/dashHeader.php';
?>

<style>
    .wrapper{ width: 60%; padding-left: 200px; padding-top: 20px }
</style>

<div class="wrapper">
    <div class="container-fluid pt-5 pl-600">
        <div class="row">
            <div class="m-50">

                <div class="mt-5 mb-3">
                    <h2 class="pull-left">Membership Details</h2>
                    <a href="../customerCrud/createCust.php" class="btn btn-outline-dark">
                        <i class="fa fa-plus"></i> Add Membership
                    </a>
                </div>

                <div class="mb-3">
                    <form method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="search" class="form-control"
                                       placeholder="Enter Member ID or Name">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-dark">Search</button>
                            </div>
                            <div class="col text-right">
                                <a href="customer-panel.php" class="btn btn-light">Show All</a>
                            </div>
                        </div>
                    </form>
                </div>

                <?php
                require_once "../config.php";

                if (!empty($_POST['search'])) {
                    $search = mysqli_real_escape_string($link, $_POST['search']);
                    $sql = "
                        SELECT *
                        FROM Memberships M
                        INNER JOIN Accounts A ON M.account_id = A.account_id
                        WHERE M.member_name LIKE '%$search%'
                           OR M.member_id LIKE '%$search%'
                        ORDER BY M.member_id
                    ";
                } else {
                    $sql = "
                        SELECT *
                        FROM Memberships M
                        INNER JOIN Accounts A ON M.account_id = A.account_id
                        ORDER BY M.member_id
                    ";
                }

                if ($result = mysqli_query($link, $sql)) {
                    if (mysqli_num_rows($result) > 0) {

                        echo '<table class="table table-bordered table-striped">';
                        echo '<thead>
                                <tr>
                                    <th style="width:7em;">Member ID</th>
                                    <th>Member Name</th>
                                    <th style="width:7em;">Points</th>
                                    <th>Account ID</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Password</th>
                                    <th style="width:5em;">Delete</th>
                                </tr>
                              </thead><tbody>';

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>{$row['member_id']}</td>";
                            echo "<td>{$row['member_name']}</td>";
                            echo "<td>{$row['points']}</td>";
                            echo "<td>{$row['account_id']}</td>";
                            echo "<td>{$row['email']}</td>";
                            echo "<td>{$row['phone_number']}</td>";
                            echo "<td>" . $row['password'] . "</td>";
                            echo "<td>
                                    <a href='../customerCrud/deleteCustomer.php?id={$row['member_id']}'
                                       onclick=\"return confirm('Are you sure you want to delete this member?')\">
                                       <span class='fa fa-trash text-black'></span>
                                    </a>
                                  </td>";
                            echo "</tr>";
                        }

                        echo "</tbody></table>";
                        mysqli_free_result($result);

                    } else {
                        echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                    }
                } else {
                    echo "Database error.";
                }

                mysqli_close($link);
                ?>

            </div>
        </div>
    </div>
</div>

<?php include '../inc/dashFooter.php'; ?>
