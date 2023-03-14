<?php
// Include the database configuration file
require_once 'config.php';

// Check if the verification code has been submitted
if (isset($_POST['verification_code'])) {
      $verification_code = $_POST['verification_code'];

      // Check if the verification code is correct and hasn't expired
      $query = "SELECT * FROM user WHERE verification_code = '$verification_code'";
      $result = mysqli_query($conn, $query);
      $row = mysqli_fetch_assoc($result);

      if ($row && $row['expires_at'] > date('Y-m-d H:i:s')) {
            // Verification successful
            header("Location: verification_successful.php");
            // Remove the database entry for the user
            $email = $row['email'];
            $query = "DELETE FROM user WHERE email = '$email'";
            mysqli_query($conn, $query);
      } else if ($row) {
            // Verification code has expired
            echo '<p>Verification code has expired. Please try again.</p>';

            // Remove the database entry for the expired verification code
            $email = $row['email'];
            $query = "DELETE FROM user WHERE email = '$email'";
            mysqli_query($conn, $query);
      } else {
            // Verification failed
            echo '<p>Verification failed. Please check your verification code and try again.</p>';
      }
}
?>
<!DOCTYPE html>
<html>

<head>
      <title>User Validation App</title>
      <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
      <div class="container">
            <h1>User Validation App</h1>
            <form method="post" action="">
                  <div class="form-group">
                        <label for="verification_code">Verification Code:</label>
                        <input type="text" id="verification_code" name="verification_code" required>
                  </div>
                  <div class="form-group">
                        <button type="submit">Verify</button>
                  </div>
            </form>
      </div>
</body>

</html>