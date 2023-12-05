<?php
include "pass.php";

if (isset($_POST['done'])) {
    $con=new mysqli($ho_na, $user, $pass, $db_na);
    if ($con->connect_error) {
        die("Connnecting error ".$con->connect_error);
    }

    $npass=get($con, "n_pass");
    $cpass=get($con, "c_pass");
    
    if ($npass == $cpass) {
        
    }
    else {
        alert();
    }

    $con->close();

}

public function update($c)
{
    $que="SELECT password from "
}

function alert(){
    session_start();
    $_SESSION['fu']='2';
    redir("forget.html");

}

public function encry($var)
{
    return hash("ripemd128", $var);
}

function get($c, $var)
{
    return $c->real_escape_string(htmlentities($_POST[$var]));
}
?>