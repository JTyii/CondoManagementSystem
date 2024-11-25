<?php
// Start or resume the session
session_start();

// Include the dbConn.php file to establish the database connection
require_once 'dbConn.php';

// Assuming the database connection is established in dbConn.php

// Function to get the user's wallet amount
function getUserWalletAmount($connection, $resident_id) {
    $wallet_amount = 0;
    $sql_wallet = "SELECT amount FROM user_wallettable WHERE resident_id = '$resident_id'";
    $result_wallet = $connection->query($sql_wallet);
    if ($result_wallet->num_rows > 0) {
        $row_wallet = $result_wallet->fetch_assoc();
        $wallet_amount = $row_wallet["amount"];
    }
    return $wallet_amount;
}
// Function to insert payment details into receipt_table
function insertPaymentIntoReceiptTable($connection, $resident_id, $payment_amount, $payment_description) {
    $sql_insert = "INSERT INTO receipt_table (resident_id, amount, payment_date, type) VALUES ('$resident_id', '$payment_amount', NOW(), '$payment_description')";
    $connection->query($sql_insert);
}

if (isset($_SESSION['resident_id'])) {
    $resident_id = $_SESSION['resident_id'];

    $notification_table = "notifications_user_" . $resident_id;

    $sql = "SELECT resident_id, type, amount, release_date, due_date FROM admin_billingtable WHERE resident_id = '$resident_id'";
    $result = $connection->query($sql);

    $sql_total = "SELECT SUM(amount) AS total_amount FROM admin_billingtable WHERE resident_id = '$resident_id'";
    $result_total = $connection->query($sql_total);
    $row_total = $result_total->fetch_assoc();
    $total_amount = $row_total["total_amount"];

    if ($total_amount == 0) {
        header("Location: receipt.php");
        exit();
    }

    $wallet_amount = getUserWalletAmount($connection, $resident_id);
    $disable_pay_now = ($wallet_amount < $total_amount);
} else {
    header("Location: UserWalletveri.php");
    exit();
}


if (isset($_POST['pay_now'])) {
    if ($wallet_amount >= $total_amount) {
        $sql_deduct = "UPDATE user_wallettable SET amount = amount - $total_amount WHERE resident_id = '$resident_id'";
        $connection->query($sql_deduct);

        $sql_notif = "INSERT into $notification_table (notification) VALUES ('Payment Successful')";
        $connection->query($sql_notif);

        $sql_reset = "UPDATE admin_billingtable SET amount = 0 WHERE resident_id = '$resident_id'";
        $connection->query($sql_reset);

        // Fetch the 'type' value from the admin_billingtable
        $type_sql = "SELECT type FROM admin_billingtable WHERE resident_id = '$resident_id'";
        $result_type = $connection->query($type_sql);
        $row_type = $result_type->fetch_assoc();
        $payment_description = $row_type["type"];



        // Check for duplicate entry before inserting
        $sql_check_duplicate = "SELECT resident_id FROM receipt_table WHERE resident_id = '$resident_id'";
        insertPaymentIntoReceiptTable($connection, $resident_id, $total_amount, $payment_description);

        echo "<script>alert('Payment successful!');</script>";
        echo "<script>location.reload();</script>";
    } else {
        echo "<script>
                if (confirm('Insufficient balance in wallet. Do you want to top up?')) {
                    window.location.href = 'usertopup.php';
                } else {
                    window.location.href = 'main.php';
                }
            </script>";
        echo "<script>
                if (confirm('Insufficient balance in wallet. Do you want to top up?')) {
                    window.location.href = 'usertopup.php';
                } else {
                    window.location.href = 'main.php';
                }
            </script>";
    }
}

$connection->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        body {
            background-color: #f0f8ea;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            height: 100vh;
            margin: 0;
            animation: moveUp 1s ease-in-out;
        }
        .invoice-box {
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 400px;
            width: 100%;
            text-align: center;
            line-height: 1.6;
            border-radius: 10px;
            margin-top: 40px;
            animation: fadeIn 1s ease-in-out;
        }
        .invoice-item {
            margin-bottom: 15px;
        }
        .invoice-item strong {
            font-weight: bold;
        }
        .form-container {
            margin-top: 20px;
        }
        .form-item {
            margin-right: 10px;
            font-size: 20px;
            color: #ffffff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            cursor: pointer;
        }
        .form-item:hover {
            background-color: #004f8e;
        }
        .form-item:disabled {
            background-color: #b0c3d9;
            cursor: not-allowed;
        }
        h1 {
            font-size: 36px;
            margin-bottom: 20px;
        }
        p {
            font-size: 20px;
            margin: 0;
        }
        @keyframes moveUp {
            from {
                margin-top: 100px;
                opacity: 0;
            }
            to {
                margin-top: 40px;
                opacity: 1;
            }
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</head>
<body>
<div class="invoice-box">
    <h1 style="font-weight: bold;">Invoice</h1>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $resident_id = $row["resident_id"];
            $type = $row["type"];
            $amount = $row["amount"];
            $release_date = isset($row["release_date"]) ? new DateTime($row["release_date"]) : null;
            $due_date = isset($row["due_date"]) ? new DateTime($row["due_date"]) : null;

            echo '<div class="invoice-item">';
            echo "<p class='invoice-item'><strong>Resident id:</strong> $resident_id</p>";
            // Modify this line to directly use the $type variable
            echo "<p class='invoice-item'><strong>Payment towards:</strong> $type</p>";
            echo "<p class='invoice-item'><strong>Amount:</strong> $amount</p>";

                if ($release_date !== null) {
                    echo "<p class='invoice-item'><strong>Release Date:</strong> " . $release_date->format("Y-m-d") . "</p>";
                }

                if ($due_date !== null) {
                    echo "<p class='invoice-item'><strong>Due Date:</strong> " . $due_date->format("Y-m-d") . "</p>";
                }

                echo "<hr>";
                echo '</div>';
            }
        } else {
            echo "<p>No data available</p>";
        }
        ?>
        <div class="form-container">
            <form method="post">
                <input type="submit" name="top_up" formaction="usertopup.php" value="Top Up" class="form-item">
                <?php if (!$disable_pay_now) { ?>
                    <input type="submit" name="pay_now" value="Pay Now" class="form-item">
                <?php } else { ?>
                    <input type="submit" name="pay_now" value="Pay Now" class="form-item" disabled>
                <?php } ?>
            </form>
        </div>
    </div>
</body>
</html>
