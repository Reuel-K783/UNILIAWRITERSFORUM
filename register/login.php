

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_POST['submit'])){
  include "conn.php";

  $name = mysqli_real_escape_string($conn, $_POST['name']);
   
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  


  $sql = "SELECT * FROM users WHERE name = '$name' OR email = '$name'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

  if($row){
    if (password_verify($password, $row["password"])) {
      (header("Location: http://localhost:8080/GitHub/UNILIAWRITERSFORUM/dashboard/dashboard.php"));  
      
      exit;
    
    } else {
      // Invalid credentials
      echo '<script>
              alert("invalid credentals");
              window.location.href = "login.html";
            </script>';
    }
  } else {
    echo '<script>
            alert("User does not exist");
            window.location.href = "signup.html";
          </script>';
  }
}
?>


