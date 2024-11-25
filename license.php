<?php
include "dbConn.php";

session_start();
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="css/text.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Signika+Negative&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/4e1d1789bb.js" crossorigin="anonymous"></script>
    <title>License</title>
</head>
<body>
  <style>
    body{
      background-image: url(img/bg.jpg);
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-position: center;
  background-size: cover;
    }
    </style>
<nav>
    <ul>
      <li class= "house"><a href="index.php"><i class="fas fa-home"></i></a></li>
      <li><a href="maintenancereq.php" class="dropbtn">Maintenance</a></li>
      <li><a href="UserWalletVeri.php">Payments</a></li>
      <li><a href="chat.php">Community Chat</a></li>
      <li><a href="facilities&event.php">Facilities & Events</a></li>
      <li><a href="visitormanagement.php">Parking & Visitors</a></li>
      <li><a href="contactus.php">Contact Us</a></li>
      <div class="user">
      <a href ="notification.php"><i class="fa-solid fa-envelope"></i></a>
        <a href="edituserprofile.php"><i class="fas fa-user"></i></a>
        <?php echo "<text>$username</text>"; ?>
  </div>
    </ul>
  </nav>
    <br>
    <br>
    <div class="maintitle">
        <div class = "title1">
            <h2>License</h2>
        </div>
    </div>
    <div class="container">
    Website License Agreement

This Website License Agreement ("Agreement") is entered into as of [date] ("Effective Date") between [Your Company Name], a [Your State or Country] corporation, with its principal place of business at [Your Address] ("Licensor" or "we" or "us" or "our"), and the users ("Licensee" or "you" or "your") of the BEEKINI Condominium Management Website ("Website").

1. Grant of License:

Subject to the terms and conditions of this Agreement, Licensor grants Licensee a limited, non-exclusive, non-transferable, revocable license to access and use the BEEKINI Condominium Management Website and its content for personal, non-commercial purposes.

2. Restrictions on Use:

2.1 Licensee shall not sublicense, sell, rent, lease, distribute, transmit, or otherwise exploit the Website or its content in any unauthorized manner.

2.2 Licensee shall not modify, adapt, translate, reverse engineer, decompile, disassemble, or create derivative works based on the Website or its content, except as expressly permitted by law.

2.3 Licensee shall not remove or alter any copyright, trademark, or other proprietary notices from the Website or its content.

3. Intellectual Property:

3.1 All intellectual property rights in the Website and its content, including but not limited to copyrights, trademarks, patents, and trade secrets, are and shall remain the exclusive property of Licensor or its licensors.

3.2 Licensee acknowledges and agrees that the use of the Website does not grant Licensee any ownership rights in the Website or its content.

4. Updates and Modifications:

Licensor reserves the right to update, modify, or discontinue the Website or its content at any time without notice. Licensee agrees that Licensor shall not be liable for any such updates, modifications, or discontinuation.

5. Termination:

5.1 This License Agreement is effective until terminated. Licensee may terminate this Agreement by ceasing to use the Website and destroying all copies of the Website and its content in Licensee's possession or control.

5.2 Licensor may terminate this Agreement and the license granted hereunder at any time without notice if Licensee breaches any provision of this Agreement.

6. Limitation of Liability:

6.1 Licensor shall not be liable for any direct, indirect, incidental, special, consequential, or exemplary damages arising out of or in connection with the use or inability to use the Website or its content.

6.2 Licensee agrees to indemnify, defend, and hold harmless Licensor and its officers, directors, employees, and agents from and against any and all claims, liabilities, damages, losses, costs, and expenses (including reasonable attorney's fees) arising out of or in connection with Licensee's use of the Website or its content.

7. Governing Law:

This Agreement shall be governed by and construed in accordance with the laws of [Your State or Country], without regard to its conflicts of laws principles.

8. Entire Agreement:

This Agreement constitutes the entire understanding and agreement between Licensee and Licensor concerning the subject matter hereof and supersedes all prior and contemporaneous agreements, whether oral or written.

By accessing and using the BEEKINI Condominium Management Website, you acknowledge that you have read, understood, and agree to be bound by this Website License Agreement.

    </div>
    <footer>
        <div class="footer">
          <div class="footer-content">
            <p>&copy; 2023 BEEKINEE. All rights reserved.</p>
          </div>
          <div class="footer-content1">
            &emsp;<a href="license.php">License</a>&emsp; 
            <a href="term.php">Term of Service</a>&emsp;
            <a href="privacypolicy.php">Privacy Policy</a>
          </div>
        </div>
</footer>
</body>
</html>