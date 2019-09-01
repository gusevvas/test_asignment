<?php 


define('DB_SERVER', 'localhost:3306');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'user');
$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
require_once('user.php');
session_start(); 
$us=new User();
$us->username=$_POST['username'];
if($_SERVER["REQUEST_METHOD"] == "POST") {
   $myusername = mysqli_real_escape_string($db,$_POST['username']);
   $mypassword = mysqli_real_escape_string($db,$_POST['password']); 
   $sql = "SELECT id FROM users WHERE username = '$myusername' and password = '$mypassword'";
   $result = mysqli_query($db,$sql);
   while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
      $_SESSION['user_id']=$row['id'];
   }
   $sql2 = "SELECT money,user_money_limit,bonusPoints FROM users WHERE username = '$myusername'";
   $limitsQ="SELECT money_upper_limit, money_lower_limit, bonus_lower_limit, bonus_upper_limit, bonus_coefficient,maximum_item_amount FROM settings";
   $result2 = mysqli_query($db,$sql2);
   $limitsR=mysqli_query($db, $limitsQ);
   while($rows = mysqli_fetch_array($result2,MYSQLI_ASSOC)){
      $us->money=$rows['money'];
      $_SESSION["user_money_limit"]=$rows['user_money_limit'];
      $_SESSION['bonusPoints'] =$rows['bonusPoints'];
   }

   while($rows1 = mysqli_fetch_array($limitsR,MYSQLI_ASSOC)){

      $_SESSION['money_upper_limit']=$rows1['money_upper_limit'];
      $_SESSION['money_lower_limit']=$rows1['money_lower_limit'];
      $_SESSION['bonus_lower_limit']=$rows1['bonus_lower_limit'];
      $_SESSION['bonus_upper_limit']=$rows1['bonus_upper_limit'];
      $_SESSION['bonus_coefficient']=$rows1['bonus_coefficient'];
      $_SESSION['maximum_item_amount']=$rows1['maximum_item_amount'];
   }

   $bonusQ="SELECT * FROM bonus";
   $bonusR= mysqli_query($db,$bonusQ);
   $_SESSION['bonusCount']=mysqli_num_rows($bonusR);
   $n=1; 
   while($rows3 = mysqli_fetch_array($bonusR,MYSQLI_ASSOC)){

      $_SESSION['bonus_id'.$n]=$rows3['id']; 
      $_SESSION['bonus_name'.$n]=$rows3['bonus_name']; 
      $_SESSION['bonus_type'.$n]=$rows3['bonus_type']; 
      $n=$n+1;
   }
   $count = mysqli_num_rows($result);

   if($count == 1) {
      $_SESSION['username'] = $myusername;
      $_SESSION['money']=$us->money;


      header("location: account.php");
   }else {
      echo "Your Login Name or Password is invalid";
   }
}
?>