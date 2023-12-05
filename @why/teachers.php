<?php
require "pass.php";

if(isset($_POST["list"])){
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <style>@import url(css/tlist.css);</style>
    </head>
    <body>
       <form action="search.php" method="post">
        <div class="search-box">
            <input type="text" placeholder=" " name="sonam"/><span></span>
            <!--Bewafa hai-->
        </div>
        </form>
    <script src="css/tlist.js"></script>
    <div id="con">
    <table>
        <tr id="head">

        <th>Name</th>
        <th>Email</th>
        <th>Visibility</th>
        <th>Save<th>
        </tr>';
    show_tlist($ho_na, $user, $pass, $db_na);



    echo '</body>
    </html';
}


function show_tlist($ho_na, $user, $pass, $db_na){
    $con=new mysqli($ho_na, $user, $pass, $db_na);
    if($con->connect_error) die("Connecting error ".$con->connect_error);
    $que="SELECT ID,Name, Email, isPublic FROM tblteacher";
    $re=$con->query($que);
    if(!$re) die("Executing error ".$con->error);
    while (1) {
        $res=$re->fetch_array(MYSQLI_ASSOC);
        if (is_null($res)) {
            break;
        }
        else{
            $url=urll($res["ID"]);
            echo '<tr>
            <td align="center"><a href='.$url.'>'.$res["Name"].'</a></td>
            <td align="center"><a href='.$url.'>'.$res["Email"].'</a></td>
            <td align="center">
            <form action="save.php" method="post">
            <select name="visible">
            <option value="0">Private</option>
            <option value="1">Public</option>
            </select></td>
            <td align="center">
            <button name="Save_sub">Save</button>
            <input type="hidden" name="bd" value='.$res["ID"].'>
            </form></td>
        </tr>';            
        }
    }

    $con->close();
}

function urll($va)
{
    $str="profile.php?var=".$va;
    return $str;
}

function visib($var)
{
    if ($var==0) {

        return "Private";
    }
    else {
        return "Public";
    }
}
?>