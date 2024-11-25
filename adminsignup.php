<!DOCTYPE html>
<html>
  <head>
    <title>Admin Signup Page</title>
    <link rel="stylesheet" type="text/css" href="css/adminsignup.css" />
    <script
      src="https://kit.fontawesome.com/4e1d1789bb.js"
      crossorigin="anonymous"
    ></script>
  </head>
  <body>
    <nav>
      <ul>
        <li>
          <a href="index.php"><i class="fa-solid fa-home"></i></a>
        </li>
        <li><a href="">Maintenance Requests</a></li>
        <li><a href="">Payments</a></li>
        <li><a href="">Communication</a></li>
        <li><a href="">Facilities & Events</a></li>
        <li><a href="">Parking & Visitors</a></li>
        <div class="user">
          <a href=""><i class="fa-solid fa-user"></i></a>
          <text>Username</text>
        </div>
      </ul>
    </nav>

    <div class="container"> 
      <h1>Admin Sign Up</h1>
      <form action="admin_signup.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required />

        <label for="firstname">First Name:</label>
        <input type="text" id="firstname" name="firstname" required />

        <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" name="lastname" required />

        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" required />

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required />

        <label for="confirm_password">Confirm Password:</label>
        <input
          type="password"
          id="confirm_password"
          name="confirm_password"
          required
        />

        <input type="submit" value="Sign Up" />
      </form>
    </div>
  </body>
</html>
