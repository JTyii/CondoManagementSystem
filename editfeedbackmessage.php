<?php
include('dbConn.php');

if (isset($_GET['edit_id1'])) {
    $message_id = $_GET['edit_id1'];
    $query = "SELECT * FROM user_contactustable WHERE `message` = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "s", $message_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if a matching record is found
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Handle form submission
        if (isset($_POST['update_message'])) {
            $new_message = $_POST['message'];
            $update_query = "UPDATE user_contactustable SET `message` = ? WHERE `message` = ?";
            $stmt = mysqli_prepare($connection, $update_query);
            mysqli_stmt_bind_param($stmt, "ss", $new_message, $message_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            header("Location: viewfeedbackmessage.php"); // Redirect back to the viewfeedbackmessage.php page after updating
            exit();
        }
    } else {
        // If no matching record found, redirect to viewfeedbackmessage.php or show an error message
        header("Location: viewfeedbackmessage.php");
        exit();
    }
    mysqli_stmt_close($stmt);
} else {
    // If edit_id1 is not set, redirect to viewfeedbackmessage.php or show an error message
    header("Location: viewfeedbackmessage.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Feedback Message</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Signika+Negative&display=swap" rel="stylesheet">
</head>
<style>
    .background-image {
        background-image: url(img/background-color.jpg);
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-position: center;
        background-size: cover;
    }

    .container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        margin-top: 50px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-size: 18px;
        font-weight: bold;
    }

    .form-group input[type="text"] {
        width: 100%;
        padding: 8px;
        font-size: 16px;
        border-radius: 4px;
        border: 1px solid #ccc;
    }

    .form-group button {
        padding: 10px 20px;
        font-size: 18px;
        background-color: #4CAF50;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .form-group button:hover {
        background-color: #45a049;
    }
</style>
<body class="background-image">
    <header>

    </header>
    <main>
        <div class="container">
        <h1>Edit Feedback Message</h1>
    <form method="post">
        <label for="message">Feedback Message:</label>
        <input type="text" id="message" name="message" value="<?php echo htmlspecialchars($row['message']); ?>" required>
        <button type="submit" name="update_message">Update</button>
    </form>
        </div>
    </main>
</body>
</html>
