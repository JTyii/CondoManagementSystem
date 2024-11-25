<!DOCTYPE html>
<html>
<head>
    <title>Transaction History</title>
    <script src="https://kit.fontawesome.com/4e1d1789bb.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-image: url(img/bg.jpg);
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            background-size: cover;
        }

        .navigate {
            position:fixed;
            margin-top: 30px;
            margin-right: 87%;
            display: inline-block;
            padding: 10px 20px;
            width:auto;
            background-color: #fff;
            color: #1e90ff;
            border: 2px solid #1e90ff;
            border-radius: 20px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .navigate:hover {
            background-color: #1e90ff;
            color: #fff;
        }

        .receipts-table {
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 10px;
            margin: auto;
            max-width: 800px; /* Adjust the maximum width as needed */
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            border-bottom: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .wallet-table {
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 10px;
            margin: 20px auto; /* Add some margin for separation */
            max-width: 800px;
        }

    </style>
</head>
<body>
<div class="navigate-button">
        <a href="index.php" class="navigate"><i class="fa-solid fa-left-long"></i><br>Main Menu</a>
    </div>
<div class="wallet-table">
        <h1>User Wallet Information</h1>
        <table>
            <tr>
                <th>Resident ID</th>
                <th>Phone Number</th>
                <th>Amount</th>
            </tr>
            <?php
            session_start();
            include 'dbConn.php';

            $connection = new mysqli($host, $user, $password, $database);

            if ($connection->connect_error) {
                die("Connection failed: " . $connection->connect_error);
            }

            $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

            // Get resident_id using a query
            $resident_id_query = "SELECT resident_id from usertable WHERE username = '$username'";
            $resident_id_result = $connection->query($resident_id_query);
            if ($resident_id_result->num_rows > 0) {
                $resident_data = $resident_id_result->fetch_assoc();
                $resident_id = $resident_data['resident_id'];
            } else {
                $resident_id = -1; // Set a default value if no resident found
            }

            // Query user_wallet table
            $wallet_query = "SELECT resident_id, phone_no, amount FROM user_wallettable WHERE resident_id = ?";
            $stmt_wallet = $connection->prepare($wallet_query);
            $stmt_wallet->bind_param("i", $resident_id);
            $stmt_wallet->execute();
            $result_wallet = $stmt_wallet->get_result();

            if ($result_wallet->num_rows > 0) {
                while ($row_wallet = $result_wallet->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row_wallet['resident_id']}</td>";
                    echo "<td>{$row_wallet['phone_no']}</td>";
                    echo "<td>{$row_wallet['amount']}</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No wallet information found for this resident.</td></tr>";
            }
            ?>
        </table>
    </div>
    <div class="receipts-table">
        <h1>Transaction History</h1>
        <table>
            <tr>
                <th>Receipt ID</th>
                <th>Amount</th>
                <th>Payment Date</th>
                <th>Payment Towards</th>
            </tr>
            <?php
            include 'dbConn.php';

            $connection = new mysqli($host, $user, $password, $database);

            if ($connection->connect_error) {
                die("Connection failed: " . $connection->connect_error);
            }

            $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

            // Get resident_id using a query
            $resident_id_query = "SELECT resident_id from usertable WHERE username = '$username'";
            $resident_id_result = $connection->query($resident_id_query);
            if ($resident_id_result->num_rows > 0) {
                $resident_data = $resident_id_result->fetch_assoc();
                $resident_id = $resident_data['resident_id'];
            } else {
                $resident_id = -1; // Set a default value if no resident found
            }
           
            // Use prepared statement for the main query
            $sql = "SELECT receipt_id, amount, payment_date, type FROM receipt_table WHERE resident_id = ?";
            $stmt = $connection->prepare($sql);
            $stmt->bind_param("i", $resident_id); // Bind the resident_id as an integer
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['receipt_id']}</td>";
                    echo "<td>{$row['amount']}</td>";
                    echo "<td>{$row['payment_date']}</td>";
                    echo "<td>{$row['type']}</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No receipts found for this resident.</td></tr>";
            }

            $stmt->close();
            $connection->close();
            ?>
        </table>
    </div>
</body>
</html>
