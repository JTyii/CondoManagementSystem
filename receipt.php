<!DOCTYPE html>
<html>
<head>
    <title>Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ea;
            padding: 20px;
        }
        .receipt-box {
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 400px;
            width: 100%;
            border-radius: 10px;
            margin: auto;
        }
        h1 {
            font-size: 28px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        a {
            text-decoration: none;
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="receipt-box">
        <h1>Receipt</h1>
        <table>
            <tr>
                <th>Field</th>
                <th>Value</th>
            </tr>
            <?php
            session_start();
            $resident_id = isset($_SESSION['resident_id']) ? $_SESSION['resident_id'] : '';
            
            include 'dbConn.php';

            $connection = new mysqli($host, $user, $password, $database);

            if ($connection->connect_error) {
                die("Connection failed: " . $connection->connect_error);
            }

            // Retrieve data from tables
            $sql_receipt = "SELECT type, amount FROM receipt_table WHERE resident_id = $resident_id ORDER BY receipt_id DESC LIMIT 1";
            $result_receipt = $connection->query($sql_receipt);
            $row_receipt = $result_receipt->fetch_assoc();

            $sql_billing = "SELECT release_date FROM admin_billingtable WHERE resident_id = $resident_id";
            $result_billing = $connection->query($sql_billing);
            $row_billing = $result_billing->fetch_assoc();

            $sql_due = "SELECT payment_date FROM receipt_table WHERE resident_id = $resident_id";
            $result_due = $connection->query($sql_due);
            $row_due = $result_due->fetch_assoc();


            // Display the retrieved data in rows of a table
            displayTableRow('Resident ID', $resident_id);
            displayTableRow('Payment towards', $row_receipt['type']);
            displayTableRow('Release Date', $row_billing['release_date']);
            displayTableRow('Payment Date', $row_due['payment_date']);
            displayTableRow('Amount', $row_receipt['amount']);
            
            $connection->close();

            function displayTableRow($label, $value) {
                echo "<tr>";
                echo "<td><strong>$label:</strong></td>";
                echo "<td>$value</td>";
                echo "</tr>";
            }
            ?>
        </table>
        <p><a href="index.php">Back to Main Page</p>
    </div>
</body>
</html>
