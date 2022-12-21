
<?php 
  require_once ('includes/DB.php'); 
  require_once ('includes/Functions.php'); 
  require_once ('includes/Sessions.php'); 
  Confirm_User_Login();
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
    <title>Full View</title>
</head>
<body style="background: linear-gradient(to right, #000000, #222831);">
    
    <!-- start of navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow" style="background:#393E46;">
        <div class="container">
          <a class="navbar-brand" href="UserHome.php">Origin Library</a>         
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link active" href="MyProfile.php">My Profile</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="UserHome.php">Books</a>
              </li>
                                                      
            </ul> 
            <ul class="navbar-nav px-3">                 
                    <form action="UserHome.php">
                        <div class="input-group ">
                            <input type="text" class="form-control" name="Search" placeholder="Search book here">
                            <button class="btn btn-info" name="SearchButton">Go</button>
                            
                        </div>
                    </form>                  
              </ul>            
          </div>
          <!-- list for aligning items to the right of the navbar -->
          <ul class="navbar-nav ml-auto">            
            <li class="nav-item"><a href="#" class="nav-link">Logout</a></li>
            <li class="nav-item"><a class="nav-link disabled">WELCOME USER: <?php echo strtoupper($_SESSION["UserName"]); ?></a></li>                       
          </ul>
          <!-- ------------  -->
        </div>
      </nav>
    <!-- end of navbar -->
    
    <!-- START OF HEADER -->
    
     

    <!-- END OF HEADER -->

    <!-- MAIN CONTENT START -->    
    <div class="container">
        <div class="row">
            <?php 
            global $ConnectingDB;   
            //sql query to display only search items that was searched
            if(isset($_GET["SearchButton"])){
                $Search = $_GET["Search"];   
                $sql = "SELECT * FROM book 
                WHERE author LIKE :search 
                OR title LIKE :search 
                OR category LIKE :search";   
                $stmt = $ConnectingDB->prepare($sql);
                $stmt->bindValue(':search','%'.$Search.'%');
                $stmt->execute();
                
            } 
            //default display when no items were searched           
            else{
                $BookIdFromURL = $_GET["id"];
                $sql = "SELECT * FROM book  WHERE  id= '$BookIdFromURL'";
                $stmt = $ConnectingDB->query($sql);
            }            
            while ($DataRows = $stmt->fetch()){
                $BookId = $DataRows["id"];
                $BookTitle = $DataRows["title"];
                $BookAuthor = $DataRows["author"];
                $BookCategory = $DataRows["category"];
                $BookImage = $DataRows["bookimage"];
                $BookContent = $DataRows["content"]; 
               
             ?>            
            
    <div class="Contianer" >
        <div class="row mt-5">
            <div class="col-lg-6 offset-lg-3">
                <h2 class="my-3 text-white">Origin Library - Poems and Short Stories</h2>               

                <div class="card mb-5">
                    <img src="bookimages/<?php echo $BookImage ?>" style="max-height:450px;" class="card-img-top"/>
                    <div class="card-body"  style="background:#F8EDE3;">
                        <h4 class="card-title"><?php echo $BookTitle?></h4> 
                        <h4 class="lead">Author: <?php echo $BookAuthor ?></h4>                       
                        <hr>
                        <p class="card-text"><?php echo $BookContent ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
                
             <?php } ?>        
        </div>
    </div>
    <!-- MAIN CONTENT END -->

    <!-- starting of footer -->
      <footer class="bg-dark text-white pt-3">
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