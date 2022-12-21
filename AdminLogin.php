<?php 
  require_once ('includes/DB.php'); 
  require_once ('includes/Functions.php'); 
  require_once ('includes/Sessions.php'); 
?>
<?php

  if (isset($_POST["Submit"])) {
    $UserName = $_POST["Username"];
    $Password = $_POST["Password"];
    
    if (empty($UserName)||empty($Password)) {
      $_SESSION["ErrorMessage"]= "All field must be filled out.";
      Redirect_to("AdminLogin.php");
    }else{ 
      $Found_Account = Admin_Login_Attempt($UserName,$Password);   
      if($Found_Account) {
        $_SESSION["UserId"]=$Found_Account["id"];
        $_SESSION["UserName"]=$Found_Account["username"];
        $_SESSION["SuccessMessage"]= "Welcome ".$_SESSION["UserName"];
        Redirect_to("Dashboard.php");
      }else{
        $_SESSION["ErrorMessage"]="Incorrect Username or Password";
        Redirect_to("AdminLogin.php");
      }
    }
  }

?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- font awesome link for icons -->
    <script src="https://kit.fontawesome.com/871a1b0612.js" crossorigin="anonymous"></script>
    <!-- bootstrap link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Admin Login</title>
</head>
<body style="background: linear-gradient(to right, #000000, #222831);">
    
    <!-- start of navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow" style="background:#393E46;">
        <div class="container">
          <a class="navbar-brand" href="index.php">Origin Library</a>         
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">  
            <li class="nav-item">
                  <a class="nav-link " href="index.php">Home</a>
            </li>           
            </ul>                        
          </div>
            <ul class="navbar-nav">
              <li>
                <a class="nav-link " href="UserLogin.php">User Login</a>
              </li>
              <li>
              <a class="nav-link " href="UserRegistration.php">User Registration</a>
              </li>
            </ul>
        </div>
      </nav>
    <!-- end of navbar -->

    <!-- MAIN CONTENT START -->
    <div class="container">
      <div class="row ">
          <div class="col-6 offset-3">
            <div class=" justify-content-center align-items-center" style="padding-top:25vh" >
                  <?php 
                    echo ErrorMessage();
                    echo SuccessMessage();
                  ?>
              <form class="shadow p-3 text-black" style="background:#F3EFE0" action="#" method="post">
                    
                  <h4 class="display-6  ">Admin Login</h4><br>
                  
                  <div class="mb-3">
                      <label class="form-label">Username</label>
                      <input type="text" class="form-control" name="Username">                             
                  </div>                              
                  <div class="mb-3">
                      <label class="form-label">Password</label>
                      <input type="Password" class="form-control" name="Password">
                  </div>        
                  
                  <button type="submit" class="btn btn-primary" name="Submit">Login</button> 
                  <a class="btn btn-info" href="index.php" role="button">Back</a>
              </form>
            </div>
          </div>
      </div>
    </div>
    <!-- MAIN CONTENT END -->

    <!-- starting of footer -->
      <footer class="bg-dark text-white fixed-bottom pt-3">
        <div class="container">
            <div class="row">
                <div class="col">
                <p class="lead text-center" style="font-size:15px ;"> &copy; 2022 All rights reserved</p>
                </div>
            </div>
        </div>
      </footer>
    <!-- ending of footer -->


    <!-- bundle link for bootstrap dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <!-- script for bootstrap 5.1.3 from the separate section -->
    <!-- NB: not certain if these links below are needed since ive added the bundle-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>