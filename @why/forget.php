<?php
include_once "pass.php";


echo '<html>

<head>
  <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <style>
    @import url(css/index.css);
  </style>
  <title>Log in</title>
</head>
<body>';
if(isset($_POST['done']))
{
    $con=new mysqli($ho_na, $user, $pass, $db_na);
    if($con->connect_error) die("Connecting error".$con->connect_error);
    $name=get($con, "name");// Admin name
    $code=get($con, "code");// code
   // $npass=encry(get($con, "npass"));
    //$cpass=encry(get($con, "cpass"));
    //echo $cpass;
    check($con, $name, $code);

    $con->close();
}
elseif (isset($_POST['change_done'])) {
    $con=new mysqli($ho_na,$user,$pass,$db_na);
    if($con->connect_error) die("Conecting error".$con->connect_error);
    $adname=get($con, "name");  //admin name
    $npass=get($con, "npass");  //new password
    $cpass=get($con,"cpass");   //confirm password will be update
    if ($npass==$cpass) {   //two password same then it set
        update($con, encry($npass), $adname);           //Here you are write from here
    }
    else{       //else refresh page
        echo '<script>alert("Please enter same password there")</script>';
        call();     //show all input fields
    }
    $con->close();
}

function update($c,$pss, $name)     // it will update the password and redirect login page
{   //echo $pass;
    $que="UPDATE admin SET password='$pss' WHERE name='$name'";
    $re=$c->query($que);
    redir("index.html");
    

}
function check($c, $n, $co){     // check the admin name and code was right or not
    $que="SELECT name, code FROM admin";
    $res=$c->query($que);
    if(!$res) die("Executing error ".$c->error);
    $or_res=$res->fetch_array(MYSQLI_ASSOC);
    if($n == $or_res["name"] && $co == $or_res["code"]){        //name and code are matched
        call(); //it print the password input 
        /*if(isset($_POST['done'])){
            echo "It's work.";
        }*/

    }
    else{
        alert();        //password not matched and redirect to the forget.html page
    }
}

function call()
{
    echo '
        <div class="main">
          <p class="sign" align="center">Welcome !</p>
          <form class="form1" method="post" action="forget.php">
        
      <input class="un " type="text" align="center" placeholder="Admin name" name="name">
      <input class="pass" type="password" align="center" placeholder="New Password" name="npass">
      <input class="pass" type="password" align="center" placeholder="Confirm Password" name="cpass">
      <input type="submit" class="submit" align="center" value="Done" name="change_done">
            
       </form>         
    </div>';
}
function alert(){
    session_start();
    $_SESSION['fu']='2';
    redir("forget.html");

}

function get($con, $var){       //sanitize the input
    return $con->real_escape_string(htmlentities($_POST[$var]));
}

function encry($su){
    return hash("ripemd128",$su);
}

function redir($url){
    header("Location: ".$url);
    die();
}


echo '</body>
</html';
?>