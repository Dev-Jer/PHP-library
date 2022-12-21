<?php  
  require_once ('includes/DB.php'); 
  require_once ('includes/Functions.php'); 
  require_once ('includes/Sessions.php');
   
  Confirm_User_Login();
?>

<?php

 //getting existing user data
 $UserId = $_SESSION["UserId"];
 global $ConnectingDB;
 $sql = "SELECT * FROM users WHERE id='$UserId'";
 $stmt = $ConnectingDB->query($sql);
 while ($DataRows = $stmt->fetch()){
     $ExistingFullName = $DataRows['fullname'];
     $ExistingUserName = $DataRows['username'];
     $ExistingUserEmail = $DataRows['email'];
     $ExistingUserGender = $DataRows['gender'];
     $ExistingUserAddress = $DataRows['address'];
     $ExistingUserImage = $DataRows['userimage'];
     $ExistingUserBio = $DataRows['bio'];
 }

  if(isset($_POST["Submit"])){
    $UserFullName = $_POST["FullName"];
    $UserName = $_POST["UserName"];
    $UserEmail = $_POST["Email"];
    $UserGender = $_POST["Gender"];
    $UserAddress = $_POST["UserAddress"];
    $UserImage = $_FILES["UserImage"]["name"];
    $Target     = "profileupload/".basename($_FILES["UserImage"]["name"]);
    $UserBio = $_POST["UserBio"];
    //varification of adding book
    if(empty($UserFullName)||empty($UserName)||empty($UserEmail)){
      $_SESSION["ErrorMessage"]= "Fullname, Username and Email cannot be empty";
      Redirect_to("MyProfile.php");
    }elseif (strlen($UserFullName) <= 2) {
      $_SESSION["ErrorMessage"]= "Full Name should be more than two (2) characters";    
      Redirect_to("MyProfile.php");
    }elseif (strlen($UserFullName) > 29) {
      $_SESSION["ErrorMessage"]= "Full Name should be less than 30 character";
      Redirect_to("MyProfile.php");
    }elseif (strlen($UserName) <= 2) {
        $_SESSION["ErrorMessage"]= "User Name should be more than two (2) characters";    
        Redirect_to("MyProfile.php");
      }elseif (strlen($UserName) > 29) {
        $_SESSION["ErrorMessage"]= "User Name should be less than 30 character";
        Redirect_to("MyProfile.php");
    }elseif (strlen($UserBio) > 499) {
        $_SESSION["ErrorMessage"]= "User Bio Too Long";
        Redirect_to("MyProfile.php");        
    }else{     
      //=========================
      //query to executed if validation was successful
      global $ConnectingDB;
      if (!empty($_FILES["UserImage"]["name"])) {
        $sql = "UPDATE users 
                SET fullname='$UserFullName', username='$UserName', email='$UserEmail', gender='$UserGender', address='$UserAddress', userimage='$UserImage', bio='$UserBio' 
                WHERE id='$UserId'";
      }else{
        $sql = "UPDATE users 
                SET fullname='$UserFullName', username='$UserName', email='$UserEmail', gender='$UserGender', address='$UserAddress', bio='$UserBio' 
                WHERE id='$UserId'";
      }
      $Execute = $ConnectingDB->query($sql);
      move_uploaded_file($_FILES["UserImage"]["tmp_name"],$Target);

      if ($Execute) {
        $_SESSION["SuccessMessage"]="Profile Updated Successfully";
      Redirect_to("MyProfile.php");
      }else {
        $_SESSION["ErrorMessage"]="Something went wrong";
      Redirect_to("MyProfile.php");
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
    <title>My Profile</title>
</head>
<body style="background: linear-gradient(to right, #000000, #222831);">
    
    <!-- start of navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow" style="background:#393E46;">
        <div class="container">
          <a class="navbar-brand" href="#">Origin Library</a>         
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link active" href="MyProfile.php">My Profile</a>
              </li>                
              <li class="nav-item">
                <a class="nav-link" href="UserHome.php">Home</a>
              </li> 
            </ul>            
          </div>
          <!-- list for aligning items to the right of the navbar -->
          <ul class="navbar-nav">            
            <li class="nav-item"><a href="UserLogout.php" class="nav-link">Logout</a></li>  
            <li class="nav-item"><a class="nav-link disabled">WELCOME USER: <?php echo strtoupper($_SESSION["UserName"]); ?></a></li>          
          </ul>
          <!-- ------------  -->
        </div>
      </nav>
    <!-- end of navbar -->
    
    <!-- START OF HEADER -->

      <header class="text-white py-4 bg-dark">
        <div class="container">
            <div class="row">
                <h1><i class="fa-solid fa-user-gear" style="color:#00FFF5;"></i> <?php echo $ExistingFullName ?></h1>
            </div>
        </div>
      </header>

    <!-- END OF HEADER -->

    <!-- MAIN CONTENT START -->
    <section class="container py-2 mb-4">

    <div class="row">
        <!-- left side start -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header" style="background:#E2DCC8 ;">
                    <h3><?php echo $ExistingUserName ?></h3>
                </div>
                <div class="card-body mb">
                    <img src="profileupload/<?php echo $ExistingUserImage; ?>" style="height:275px; width:270px; max-height:275px; max-width:270px;"  alt="">
                    <div class="">
                    <h5 class="card-subtitle mb-2 mt-2">Bio:</h5>
                    <?php echo $ExistingUserBio  ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- left side end -->

        <!-- right side start -->
        <div class="col-md-6">
          <!-- error message call -->
          <?php 
          echo ErrorMessage();
          echo SuccessMessage();
          ?>
        <form class="" action="MyProfile.php" method="post" enctype="multipart/form-data">
            <div class="card  bg-secondary">
                <div class="card-header" style="color:#ffe5b4;" >
                    <h3>Edit Profile</h3>
                </div>
                <div class="card-body" style="background:#F3EFE0;">
                    <div class="form-group mb-4">
                        <input class="form-control" type="text" name="FullName" id="FullName" placeholder="Full Name" value="<?php echo $ExistingFullName ?>">
                    </div> 
                    <div class="form-group mb-4">
                        <input class="form-control" type="text" name="UserName" id="UserName" placeholder="User Name" value="<?php echo $ExistingUserName  ?>">
                    </div>
                    <div class="form-group mb-4">
                        <input class="form-control" type="email" name="Email" id="Email" placeholder="Email" value="<?php echo $ExistingUserEmail  ?>">
                    </div> 
                    <div class="form-group mb-4">
                        <select class="form-select" id="Gender" name="Gender">
                            <?php 
                            //fetching gender from users table also displaying the chosen gender
                            global $ConnectingDB; 
                            $sql = "SELECT gender FROM users";
                            $stmt = $ConnectingDB->query($sql);
                            while ($DataRows = $stmt->fetch()) {
                                $UserGender = $DataRows["gender"];                               
                            }                       
                            ?>
                            <option selected hidden><?php echo $UserGender ?></option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Prefer Not To Say">Prefer Not To Say</option>
                            
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <input class="form-control" type="text" name="UserAddress" id="UserAddress" placeholder="Address" value="<?php echo $ExistingUserAddress ?>">
                    </div>  
                    <div class="form-group mb-4">
                        <div class="input-group">
                            <input type="file" class="form-control" name="UserImage" id="ImageSelect" accept="image/png,image/jpeg,image/jpg">
                            <label class="input-group-text" for="ImageSelect">Update Photo</label>
                        </div>
                    </div>
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="Bio" id="floatingTextarea2" name="UserBio" style="height: 100px"><?php echo $ExistingUserBio; ?></textarea>
                        <label for="floatingTextarea2">Bio</label>
                    </div>
                    <div class="row">
                      <div class="d-grid gap-2 col-lg-6" style="padding:12px;">
                        <a href="UserHome.php" class="btn btn-success" type="button"><i class="fa-solid fa-arrow-left-long"></i> Back</a>                        
                      </div>
                      <div class="d-grid gap-2 col-lg-6 btn" style="padding:12px;">
                        <button class="btn btn-warning" type="submit" name="Submit"><i class="fa-solid fa-arrow-up-right-from-square"></i> Update Profile</button>                        
                      </div>
                    </div>                 
                </div>
            </div>
        </form>
        </div>
    </div>
 
    </section>
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