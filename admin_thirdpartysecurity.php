<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Third Party Repairment</title>
    <script src="https://kit.fontawesome.com/4e1d1789bb.js" crossorigin="anonymous"></script>
</head>
<style>
    html, body {
      font-family: Arial, sans-serif;
      padding: 0;
      margin: 0;
      height: 100%;
      font-size: 1.3em;
    }

    .background-image{
      background-image: url(img/adminbg.png);
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-position: center;
    background-size: cover;
    background-size: 100%;
    }
    nav {
    position: above;
    top: 0;
    width: 100%;
    z-index: 999;
  }

  header {
        background-color: #1033a6;
        color: #fff;
        padding: 20px;
    }

    header h1 {
        margin: 0;
        display: flex;
        align-items: center;
    }

    nav {
        display: flex;
        align-items: center;
    }

    nav ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        align-items: center;
    }

    nav li {
        margin-left: 30px;
    }

    nav a {
        text-decoration: none;
        color: #fff;
        font-weight: bold;
        font-size: 18px;
        transition: color 0.3s ease;
    }

    nav a:hover {
        color: #1e90ff;
    }

    .logout {
        margin-left: auto;
    }

    .logout a {
        text-decoration: none;
        color: #fff;
        font-size: 18px;
        transition: color 0.3s ease;
    }

    .logout a:hover {
        color: red;
    }

  .tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: aqua;
  text-align: center;
}

.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}

.btn {
  background-color: gray;
  border: none;
  color: white;
  padding: 12px 16px;
  font-size: 50px;
  cursor: pointer;
  border-radius: 5px;
}

/* Darker background on mouse-over */
.btn:hover {
  background-color: aqua;
}

.column {
  float: left;
  width: 33.33%;
  padding: 5px;
}

/* Clearfix (clear floats) */
.row::after {
  content: "";
  clear: both;
  display: table;
}

footer {
        position: fixed;
        bottom: 0;
        width: 100%;
        background-color: #1033a6;
        color: #fff;
        padding: 10px;
        text-align: center;
    }

    footer p {
        margin: 0;
    }
</style>
<body class="background-image">
<header>
<nav>
            <h1>Admin</h1>
            <ul>
                <li><a href="admin_main.php"><i class="fa-solid fa-home"></i></a></li>
                <li><a href="viewsecuritypersonnel.php">Security</a></li>
                <li><a href="admin_thirdpartysecurity.php">Third Party Services</a></li>
                <li><a href="admin_chat.php">Chat</a></li>
                <li><a href="viewfeedbackmessage.php">Feedbacks</a></li>
                <li><a href="admin_managereservationtickets.php">Reservations</a></li>
                <li><a href="admin_createevents.php">Events</a></li>
                <li><a href="admin_sendnoti.php">Notifications</a></li>
                <li><a href="admin_announcement.php">Announcements</a></li>
                <li><a href="visitorhistory.php">Visitors</a></li>
                <div class="logout">
                    <li><a href="login.php">Logout&emsp;<i class="fa-solid fa-right-from-bracket"></i></a></li>
                </div>
                <li><a href="editadminprofile.php"><i class="fa-solid fa-user-pen"></i></a></li>
            </ul>
        </nav>
    </header>
        
        <div class="tab">
          <button class="tablinks" onclick="openCity(event, 'London')">House</button>
          <button class="tablinks" onclick="openCity(event, 'Paris')">Personal</button>
          <button class="tablinks" onclick="openCity(event, 'Tokyo')">Company</button>
        </div>
        
        <div id="London" class="tabcontent">
          <h3>Home System & Security</h3>
          <div class="row">
          <div class="column">
          <button class="btn"><a href="https://www.ipcctv.my/"><img src="img/cctv.png" width="60px" height="60px"></i></button></a>
          <p>CCTV</p>
          </div>
          <div class="column">
          <button class="btn"><a href="http://www.smartlockmalaysia.com/product/security-door-smart-lock/"><img src="img/smart-door.png" width="60px" height="60px"></a></button>
          <p>Smart Lock</p>
          </div>
          <div class="column">
         <button class="btn"><a href="https://www.secomsmart.com.my/"><img src="img/alarm.png" width="60px" height="60px"></a></button>
         <p>Alarm Security</p>
          </div>
          <div class="column">
            <button class="btn"><a href="https://www.smarthome2u.my/"><img src="img/smart-home.png" width="60px" height="60px"></a></button>
            <p>Smart Home</p>
             </div>
             <div class="column">
                <button class="btn"><a href="https://drair.com.my/"><img src="img/aircond.png" width="60px" height="60px"></i></button></a>
                <p>Aircond Services</p>
                </div>
                <div class="column">
                <button class="btn"><a href="https://doublecarecleaning.com.my/"><img src="img/cleaning.png" width="60px" height="60px"></a></button>
                <p>Cleaning Services</p>
                </div>
                <div class="column">
               <button class="btn"><a href="https://www.rentokil.com/my/pest-control-services"><img src="img/pest.png" width="60px" height="60px"></a></button>
               <p>Pest Control Services</p>
                </div>
          </div>
          </div>
        
        <div id="Paris" class="tabcontent">
          <h3>Utilities & Services</h3>
          <div class="row">
            <div class="column">
            <button class="btn"><a href="https://www.mytnb.com.my/"><img src="img/bill.png" width="60px" height="60px"></i></button></a>
            <p>myTNB</p>
            </div>
            <div class="column">
            <button class="btn"><a href="https://unifi.com.my/myunifi"><img src="img/wifi-signal.png" width="60px" height="60px"></a></button>
            <p>myUnifi</p>
            </div>
            <div class="column">
           <button class="btn"><a href="https://crisportal.airselangor.com/pay/?lang=en"><img src="img/water.png" width="60px" height="60px"></a></button>
           <p>Water Bills</p>
            </div>
            <div class="column">
              <button class="btn"><a href="https://www.touchngo.com.my/"><img src="img/digital-wallet.png" width="60px" height="60px"></a></button>
              <p>TnG eWallet</p>
               </div>
               <div class="column">
                  <button class="btn"><a href="https://www.kwsp.gov.my/"><img src="img/epf.png" width="60px" height="60px"></i></button></a>
                  <p>EPF</p>
                  </div>
        </div>
        </div>
        
        <div id="Tokyo" class="tabcontent">
            <h3>Security & Office Management</h3>
            <div class="row">
              <div class="column">
              <button class="btn"><a href="https://www.zkteco.com.my/security-inspection-walk-through-metal-detector"><img src="img/metal-detector.png" width="60px" height="60px"></i></button></a>
              <p>Entrance Metal Detector</p>
              </div>
              <div class="column">
              <button class="btn"><a href="https://www.nedapsecurity.com/insight/biometric-access-control/"><img src="img/fingerprint.png" width="60px" height="60px"></a></button>
              <p>Biometrical Authentication</p>
              </div>
              <div class="column">
             <button class="btn"><a href="https://www.icloud.com/"><img src="img/icloud.png" width="60px" height="60px"></a></button>
             <p>Icloud</p>
              </div>
              <div class="column">
                <button class="btn"><a href="https://www.mydelux.com.my/"><img src="img/gate.png" width="60px" height="60px"></a></button>
                <p>AutoGate System</p>
                 </div>
                 <div class="column">
                    <button class="btn"><a href="https://parkingmgt.com/"><img src="img/electric-car.png" width="60px" height="60px"></i></button></a>
                    <p>Parking Management</p>
                    </div>
        </div>
        </div>
        <footer>
        <p>&copy; 2023 BEEKINEE Admin. All rights reserved.</p>
    </footer>
        <script>
        function openCity(evt, cityName) {
          var i, tabcontent, tablinks;
          tabcontent = document.getElementsByClassName("tabcontent");
          for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
          }
          tablinks = document.getElementsByClassName("tablinks");
          for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
          }
          document.getElementById(cityName).style.display = "block";
          evt.currentTarget.className += " active";
        }
        </script>
</body>
</html>
