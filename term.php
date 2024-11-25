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
    <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Signika+Negative&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/text.css">
    <script
  src="https://kit.fontawesome.com/4e1d1789bb.js"
  crossorigin="anonymous"
></script>
    <title>Term of Service</title>
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
            <h2>Term of Service</h2>
        </div>
    </div>
    <div class="container">
        <p>
            *Terms of Service Agreement for BEEKINI Condominium Management Website*<br><br>
            This Terms of Service Agreement ("Agreement") is entered into as of [date] ("Effective Date") between [Your Company Name], a [Your State or Country] corporation, with its principal place of business at [Your Address] ("Provider" or "we" or "us" or "our"), and the users ("User" or "you" or "your") of the BEEKINI Condominium Management Website ("Website").<br><br>
            By accessing and using the BEEKINI Condominium Management Website, you agree to be bound by the terms and conditions set forth in this Agreement. If you do not agree with these terms, you may not access or use the Website.<br><br>
            *1. Purpose of the Website:*<br><br>
            The BEEKINI Condominium Management Website is designed to provide condominium management services, including but not limited to, online communication tools, document sharing, maintenance requests, and financial tracking for the residents and management of the BEEKINI Condominium.<br><br>
            *2. User Registration:*<br><br>
            2.1 In order to access certain features of the Website, you may be required to register and create an account. You agree to provide accurate, current, and complete information during the registration process and to keep your account information updated.<br><br>
            2.2 You are responsible for maintaining the confidentiality of your account login credentials, and you agree not to disclose them to any third party. You are fully responsible for all activities that occur under your account.<br><br>
            *3. Acceptable Use:*<br><br>
            3.1 You agree to use the Website only for lawful purposes and in a manner consistent with all applicable laws and regulations. You shall not use the Website in a way that could harm the reputation of BEEKINI Condominium or its residents.<br><br>
            3.2 You agree not to upload, post, transmit, or otherwise make available any content that is unlawful, harmful, threatening, abusive, harassing, defamatory, obscene, or otherwise objectionable.<br><br>
            *4. Intellectual Property:*<br><br>
            4.1 The Website and its contents, including but not limited to text, graphics, logos, images, audio clips, video clips, data compilations, and software, are the property of BEEKINI Condominium or its licensors and are protected by copyright and other intellectual property laws.<br><br>
            4.2 You may not reproduce, distribute, modify, display, perform, publish, license, create derivative works from, or sell any content from the Website without the express written permission of the copyright owner.<br><br>
            *5. Privacy Policy:*<br><br>
            5.1 The collection and use of your personal information on the Website are governed by our Privacy Policy [provide link to Privacy Policy]. By using the Website, you consent to the practices described in the Privacy Policy.<br><br>
            *6. Limitation of Liability:*<br><br>
            6.1 The Website and its content are provided on an "as-is" and "as-available" basis without warranties of any kind, whether express or implied.<br><br>
            6.2 We shall not be liable for any direct, indirect, incidental, special, consequential, or exemplary damages resulting from the use or inability to use the Website, including but not limited to damages for loss of profits, goodwill, data, or other intangible losses.<br><br>
            *7. Modifications to the Agreement:*<br><br>
            We reserve the right to modify this Agreement at any time. Any changes will be effective upon posting the revised Agreement on the Website. Your continued use of the Website after such modifications constitutes your acceptance of the updated Agreement.<br><br>
            *8. Termination:*<br><br>
            We may terminate or suspend your access to the Website at any time, without notice, for any reason, or no reason, including if we believe that you have violated this Agreement.<br><br>
            *9. Governing Law:*<br><br>
            This Agreement shall be governed by and construed in accordance with the laws of [Your State or Country], without regard to its conflicts of laws principles.<br><br>
            *10. Entire Agreement:*<br><br>
            This Agreement constitutes the entire understanding and agreement between you and us concerning the subject matter hereof and supersedes all prior and contemporaneous agreements, whether oral or written.<br><br>
            By accessing and using the BEEKINI Condominium Management Website, you acknowledge that you have read, understood, and agree to be bound by this Terms of Service Agreement.
        </p>
    </div>
    <div class="footer">
      <div class="footer-content">
        <p>&copy; 2023 BEEKINEE. All rights reserved. </p>
      </div>
      <div class="footer-content1">
        <a href="license.php">License</a>
        <a href="term.php">Term of Service</a>
        <a href="privacypolicy.php">Privacy Policy</a>
      </div>
    </div>

</body>
</html>