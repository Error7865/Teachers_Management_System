<?php

include 'pass.php';


if (isset($_POST['sub'])){
    $con=new mysqli($ho_na,$user, $pass, $db_na);
    if($con->connect_error) die("Conncting error".$con->connect_error);
    $name=get($con, "name");
    $pass=encry(get($con, "pass"));

    check($con,$name, $pass);
    

    $con->close();
    
    
}

function check($con, $user_na, $user_pas){
    $que="SELECT name, password FROM admin";
    $res=$con->query($que);
    if(!$res) die("Executing error ".$con->error);
    $ac_res=$res->fetch_array(MYSQLI_ASSOC);
    $name=$ac_res["name"];
    $pass=$ac_res["password"];
    if ($name==$user_na && $pass==$user_pas) {      //if password matched then it redirect dashbord.html page
        redir("dashboard.html");
    }
    else {  //if not matched then it redirect index.html page with an alert
        alert();
    }
}

function alert(){
    session_start();
    $_SESSION['fu']='2';
    redir("index.html");

}

function encry($su){
    return hash("ripemd128",$su);
}
function get($con, $var){
    return $con->real_escape_string(htmlentities($_POST[$var]));
}

function redir($url){
    header("Location: ".$url);
    die();
}
?>