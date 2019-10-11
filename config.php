<?php
   include('dbconnect.php');
   session_start();
   
   $user_check = $_SESSION['userLogin'];
   
   $ses_sql = mysqli_query($db,"select email from user_info where email = '$user_check' ");
   
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   
   $login_session = $row['username'];
   
   if(!isset($_SESSION['login_user'])){
      header("location:login.php");
      die();
   }
?>