
<?php 
  require_once ('includes/DB.php'); 
  require_once ('includes/Functions.php'); 
  require_once ('includes/Sessions.php'); 
  
?>

<?php 

  if(isset($_POST["Submit"])){
    $FullName = $_POST["FullName"];
    $UserName = $_POST["UserName"];
    $Email = $_POST["Email"];
    $Gender = $_POST["Gender"];
    $Address = $_POST["Address"];
    $Password = $_POST["Password"];
    $ConfirmPassword = $_POST["ConfirmPassword"];
    $UserImage = $_FILES["UserImage"]["name"];
    $Target = "profileupload/".basename($_FILES["UserImage"]["name"]);
   //form varification

    if(empty($FullName)||empty($UserName)||empty($Email)||empty($Gender)||empty($Password)||empty($ConfirmPassword)){
    $_SESSION["ErrorMessage"]= "All fields must be filled";
    Redirect_to("UserRegistration.php");
    }elseif (strlen($UserName) < 3) {
    $_SESSION["ErrorMessage"]= "Username Too Short";
    Redirect_to("UserRegistration.php");
    }elseif (strlen($UserName) > 19) {
        $_SESSION["ErrorMessage"]= "Username Too Long";
        Redirect_to("UserRegistration.php");
    }elseif (strlen($Password) < 4) {
      $_SESSION["ErrorMessage"]= "Password Too Short";    
      Redirect_to("UserRegistration.php");
    }elseif (strlen($Password) > 19) {
      $_SESSION["ErrorMessage"]= "Password Too Long";
      Redirect_to("UserRegistration.php");
    }elseif ($Password !== $ConfirmPassword) {
      $_SESSION["ErrorMessage"]= "Both Password should match";
      Redirect_to("UserRegistration.php");
    }
    elseif (CheckUserNameExist($UserName)) {
      $_SESSION["ErrorMessage"]= "Username Exist";
      Redirect_to("UserRegistration.php");
    }
    elseif (CheckUserEmailExist($Email)) {
      $_SESSION["ErrorMessage"]= "Email Exist";
      Redirect_to("UserRegistration.php");
    }
    else{
        //query to executed if validation was successful
      global $ConnectingDB;
      $sql = "INSERT INTO users(fullname, username, email, gender, address, password, userimage)";
      $sql .= "VALUES(:userFullName,:userName,:userEmail,:userGender,:userAddress,:userPassword,:userImage)";
      $stmt = $ConnectingDB->prepare($sql);
      $stmt->bindValue(':userFullName',$FullName);
      $stmt->bindValue(':userName',$UserName);
      $stmt->bindValue(':userEmail',$Email);
      $stmt->bindValue(':userGender',$Gender);
      $stmt->bindValue(':userAddress',$Address);
      $stmt->bindValue(':userPassword',$Password);
      $stmt->bindValue(':userImage',$UserImage);
      $Execute=$stmt->execute();
      move_uploaded_file($_FILES["UserImage"]["tmp_name"],$Target);
      
      if ($Execute) {
        $_SESSION["SuccessMessage"]="User Registration Successful";
      Redirect_to("UserRegistration.php");
      }else {
        $_SESSION["ErrorMessage"]="Error in Operation";
      Redirect_to("UserRegistration.php");
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
    <title>User Registration</title>
</head>
<body style="background: linear-gradient(to right, #000000, #222831);">
    
    <!-- start of navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow" style="background:#393E46;">
        <div class="container">
          <a class="navbar-brand" href="index.php">Origin Library</a>         
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link active" href="index.php">Home</a>
              </li>
            </ul>            
          </div>
          <!-- list for aligning items to the right of the navbar -->
          <ul class="navbar-nav">            
            <li class="nav-item"><a href="UserLogin.php" class="nav-link">Login</a></li>
            <li class="nav-item"><a href="UserRegistration.php" class="nav-link">Register</a></li>            
          </ul>          
        </div>
      </nav>
    <!-- end of navbar -->    

    <!-- MAIN CONTENT START -->
    
      
    
    
    <div class="d-flex justify-content-center align-items-center" style="padding-top:5vh">
        <!-- error message call -->
        
      <form class="shadow p-3 text-black"
        style="background:#F3EFE0"              
        method="post"
        enctype="multipart/form-data"
        action="UserRegistration.php">
        <?php 
        echo ErrorMessage();
        echo SuccessMessage();
        ?>
      <h4 class="display-6">Create Account</h4><br>           

      <div class="mb-3" style="padding: top 10px;">
      
          <!-- <label class="form-label">Full Name</label> -->
          <input type="text" 
                 class="form-control"
                 name="FullName"
                 placeholder="Full Name">
                 
      </div>
      <div class="mb-3">
          <!-- <label class="form-label">Username</label> -->
          <input type="text" 
                 class="form-control"
                 name="UserName"
                 placeholder="User Name">
                 
      </div>
      <div class="mb-3">
          <!-- <label require class="form-label">Email</label> -->
          <input type="email" 
                 class="form-control"
                 name="Email"
                 placeholder="Email">
                 
      </div>
      <div class="mb-3">
          <!-- <label class="form-label">Gender</label> -->
              <select class="form-select" name="Gender">
                  <option value="" disabled hidden selected >Gender</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                  <option value="Prefer Not To Say">Prefer Not To Say</option>
              </select>
      </div>
      <div class="mb-3">
          <!-- <label class="form-label">Address</label> -->
          <input type="text"
                 class="form-control"
                 name="Address"
                 placeholder="Address">
                 <div class="form-text" style="color:#810CA8; font-weight:600;">Optional.</div>
      </div>
      <div class="mb-3">
          <!-- <label class="form-label">Password</label> -->
          <input type="password" 
                 class="form-control"
                 name="Password"
                 placeholder="Password">
                 
      </div>
      <div class="mb-3">
          <!-- <label class="form-label">Confirm Password</label> -->
          <input type="password" 
                 class="form-control"
                 name="ConfirmPassword"
                 placeholder="Confirm Password">
      </div>
      <div class="input-group mb-3">
          <input type="file" class="form-control" name="UserImage" accept="image/png,image/jpeg,image/jpg">
          <label class="input-group-text">Upload</label>
      </div>

      <button type="submit" name="Submit" class="btn btn-primary">Sign Up</button>
      <a href="UserLogin.php" class="link-secondary" style="text-decoration:none; font-size: 17px; padding-left:5px">Login</a>
     
  </form>
  
</div>
    <!-- MAIN CONTENT END -->

    <!-- starting of footer -->
    <br>
    <br>
      <footer class="bg-dark text-white fixed-bottom pt-3">
        <div class="container">
            <div class="row">
                <div class="col">
                <p class="lead text-center " style="font-size:15px ;"> &copy; 2022 All rights reserved</p>
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