<?php 
require_once ('includes/DB.php'); 

function Redirect_to($New_Location){
    header("Location:".$New_Location);
    exit;
}

function CheckAdminUserNameExist($UserName){
    global $ConnectingDB;
    $sql = "SELECT username FROM admins WHERE username=:userName";
    $stmt =$ConnectingDB->prepare($sql);
    $stmt->bindValue(':userName',$UserName);
    $stmt->execute();
    $Result =$stmt->rowCount();
    if($Result==1){
        return true;
    }else{
        return false;
    }

}

function CheckUserNameExist($UserName){
    global $ConnectingDB;
    $sql = "SELECT username FROM users WHERE username=:userName";
    $stmt =$ConnectingDB->prepare($sql);
    $stmt->bindValue(':userName',$UserName);
    $stmt->execute();
    $Result =$stmt->rowCount();
    if($Result==1){
        return true;
    }else{
        return false;
    }

}

function CheckUserEmailExist($Email){
    global $ConnectingDB;
    $sql = "SELECT email FROM users WHERE email=:userEmail";
    $stmt =$ConnectingDB->prepare($sql);
    $stmt->bindValue(':userEmail',$Email);
    $stmt->execute();
    $Result =$stmt->rowCount();
    if($Result==1){
        return true;
    }else{
        return false;
    }

}

function Admin_Login_Attempt($UserName,$Password){
      global $ConnectingDB;
      $sql = "SELECT * FROM admins WHERE username=:userName AND password=:passWord LIMIT 1"; 
      $stmt = $ConnectingDB->prepare($sql);
      $stmt->bindValue(':userName',$UserName);
      $stmt->bindValue(':passWord',$Password);
      $stmt->execute();

      $Result = $stmt->rowCount();
      if ($Result==1){
        return $Found_Account=$stmt->fetch();
        
      }else{
        return null;

    }
}

function User_Login_Attempt($UserName,$Password){
    global $ConnectingDB;
    $sql = "SELECT * FROM users WHERE username=:userName AND password=:passWord LIMIT 1"; 
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':userName',$UserName);
    $stmt->bindValue(':passWord',$Password);
    $stmt->execute();

    $Result = $stmt->rowCount();
    if ($Result==1){
      return $Found_Account=$stmt->fetch();
      
    }else{
      return null;

  }
}

function Confirm_Admin_Login(){
    if (isset($_SESSION["UserId"])){

    } else {
        $_SESSION["ErrorMessage"]="Login Required";
        Redirect_to("AdminLogin.php");
    }
}
 
function Confirm_User_Login(){
    if (isset($_SESSION["UserId"])){

    } else {
        $_SESSION["ErrorMessage"]="Login Required";
        Redirect_to("UserLogin.php");
    }
}

?>