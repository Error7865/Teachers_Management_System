
<?php
require "pass.php";

if (isset($_POST["add"])) {     //if add button clicked on dashboard page
    echo '<html>
    <head>
      <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
      <meta name="viewport" content="width=device-width, initial-scale=1" />
      <style>
        @import url(css/index.css);
      </style>
      <title>Subject</title>
    </head>
    <body>
      <div class="main">
        <form class="form1" method="post" action="update.php">
        <input class="pass" type="text" align="center" placeholder="Subject name" name="sub">
      <input type="submit" class="submit" align="center" value="Log in" name="karo">   
       </form>         
    </div>
    </body>
</html>';
}

elseif (isset($_POST["karo"])) {
    $con=new mysqli($ho_na, $user, $pass, $db_na);
    if ($con->connect_error) die("Connecting error".$con->connect_error);
    $val=get($con, "sub");
    //insert($con, $val);
    
    //redir("dashboard.html");
    $ma=check($con, $val);
    if($ma==0){
      insert($con, $val);

      //redir("dashboard.html");

    }
    else{
      session_start();
      $_SESSION["0"]='exits';
    //  session_destroy();
      
    }
    redir("dashboard.html");
}

function get($c, $str)
{
  return $c->real_escape_string(htmlentities($_POST[$str]));
}

function check($c, $val)
{
  $que="SELECT `Subject` from tblsubjects";
  $re=$c->query($que);
  $num=mysqli_num_rows($re);
  $match=0;
  for ($i=0; $i <$num; $i++) { 
    $res=$re->fetch_array(MYSQLI_NUM);
    if (strtolower($val)==strtolower($res[0])) {
      $match=1;
      break;
    }
  }
  return $match;    //1 means it present and 0 means it not present

}

function insert($c, $var)
{
  $qu="INSERT INTO tblsubjects (`Subject`) VALUES('$var')";
  $re=$c->query($qu);
}

function redir($url){
  header("Location: ".$url);
  die();
}
?>