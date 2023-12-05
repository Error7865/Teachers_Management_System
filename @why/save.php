<?php
require_once "pass.php";

if (isset($_POST["Save_sub"])) {
    $con=new mysqli($ho_na, $user, $pass, $db_na);
    if($con->connect_error) die("Connecting error ".$con->connect_error);
    $val=get($con, "bd");       //id of the teacher
    $visi=get($con, "visible");
    binod($con, $val, $visi);
    $con->close();
}

function binod($c, $id, $visi)
{
    $que="UPDATE tblteacher SET isPublic='$visi' WHERE ID ='$id'";
    $re=$c->query($que);
    if(!$re) die("Executing error ".$con->error);
    redir("dashboard.html");
}

function redir($url)
{
    header("Location: ".$url);
}

function get($c, $var)
{
    return $c->real_escape_string(htmlentities($_POST[$var]));
}
?>