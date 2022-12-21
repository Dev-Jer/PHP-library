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
    <title>Home</title>
</head>
<body style="background: linear-gradient(to right, #000000, #222831);">
    
    <!-- start of navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow" style="background:#393E46;">
        <div class="container">
          <a class="navbar-brand" href="#">Origin Library</a>         
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">              
              <!-- -------------- -->
            </ul>            
          </div>
          <!-- list for aligning items to the right of the navbar -->
          <ul class="navbar-nav">            
            <<li class="nav-item"><a href="#" class="nav-link">Login</a></li>            
          </ul>
          <!-- ------------  -->
        </div>
      </nav>
    <!-- end of navbar -->
    

    <!-- MAIN CONTENT START -->
    <div class="container" style="margin-top: 20px; ">
   
   <div class="p-2 mb-3 rounded-3 container" style="margin-top: 17rem;  width:50rem">


           <div class="row align-items-center" >

           <div class="col-md-6">

               <div class="h-100 p-5 text-white bg-dark rounded-3">

                   <h2>Admin Login</h2>                   
                   <a href="AdminLogin.php" class="btn btn-outline-info">Admin Login</a>

               </div>

           </div>

           <div class="col-md-6">

               <div class="h-100 p-5 bg-light border rounded-3">

                   <h2>User Login</h2>                  

                   <a href="UserLogin.php" class="btn btn-outline-secondary">User Login</a>

                   <a href="UserRegister.php" class="btn btn-primary">User Sign Up</a>

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