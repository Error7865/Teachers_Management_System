<?php
require_once "pass.php";

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
    </div>
   </form>
<script src="css/tlist.js"></script>';

if(empty($_POST["sonam"])){         //search field empty

    nothing();
    
}
else{           //search something
    echo '<div id="con">
    <table>
        <tr id="head">

        <th>Name</th>
        <th>Email</th>
        <th>Visibility</th>
        <th>Save<th>
        </tr>';

    $con=new mysqli($ho_na, $user, $pass, $db_na);
    if($con->connect_error) die("Connecting error ".$con->connect_error);
    $sea=get($con, "sonam");        //searched value
    hold($con, $sea);
    $con->close();
}
echo "</body>
</html>";


function hold($con,$sea)
{
    $pri=0;     //it hold the up variable value of shows function
    $que="SELECT ID, Name, Email, isPublic FROM tblteacher WHERE Name LIKE '$sea'";
    $pri=shows($con, $que);     //first search query performed based on name    
    if($pri==0){
        $que="SELECT ID, Name, Email, isPublic FROM tblteacher WHERE TeacherSub LIKE '$sea'";
        $pri=shows($con, $que); //second query perform  based on subject name    
        if($pri==0){
            $que="SELECT ID, Name, Email, isPublic FROM tblteacher WHERE Email LIKE '$sea'";
            $pri=shows($con, $que); //3rd query perform  based on Email
            if($pri==0){
                $pub=0;
                if(strtolower($sea)=="public")
                    $pub=1;
                $que="SELECT ID, Name, Email, isPublic FROM tblteacher WHERE isPublic LIKE '$pub'";
                $pri=shows($con, $que); //4rd query perform  based on visibility
                if($pri==0)
                    nothing();
            }
                
        }
    }
}
function redir($url)
{
    header("Location : ".$url);
}

function get($con, $var){
    return $con->real_escape_string(htmlentities($_POST[$var]));
}

function nothing()          //It called when nothing found
{
    echo '<div><h4>No result found.</h4></div>';
}


function shows($con,$que){       //show the searching result based on name
//    $que="SELECT ID, Name, Email, isPublic FROM tblteacher WHERE Name LIKE '$va'";
    $up=0;  //if found any result then it will be update
    $re=$con->query($que);
    if(!$re) die("Executing error ".$con->error);
    while (1) {
        $res=$re->fetch_array(MYSQLI_ASSOC);
        if (is_null($res)) {
            break;        
        }
        else{
            $up=1;          //it means the result was printed not need to execute next queries
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
    return $up;
}


function urll($va)      //generate the url for the profile page
{
    $str="profile.php?var=".$va;
    return $str;
}

function visib($var)        //return visiblity of teacher records
{
    if ($var==0) {

        return "Private";
    }
    else {
        return "Public";
    }
}
?>