<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>

    <!-- Custom Css -->
    <link rel="stylesheet" href="css/profile.css">

    <!-- FontAwesome 5 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
</head>
<body>
    <!-- Navbar top -->
    <div class="navbar-top">
        <div class="title">
            <h1>Profile</h1>
        </div>

        <!-- Navbar -->
        <ul>
            <li>
                <a href="index.html" >
                    <i class="fa fa-sign-out-alt fa-2x"></i>
                </a>
            </li>
        </ul>
        <script>
            function close_window() {
                if(confirm("Are you sure about that ?"))
                    window.close();
            }
        </script>
        <!-- End -->
    </div>
    <!-- End -->

<?php
require_once "pass.php";


if(isset($_GET["var"])){
    
    $con=new mysqli($ho_na,$user, $pass, $db_na);
    if($con->connect_error) die("Conncting error".$con->connect_error);
    $id=$_GET["var"];   //id of the teacher
    result($con, $id);

    $con->close();
}
function result($c, $id)
{
    $que="SELECT * FROM `tblteacher` WHERE `ID`='$id'";
    $re=$c->query($que);
    $res=$re->fetch_array(MYSQLI_ASSOC);
    shows($res);
    $re->close();
}

function shows($res)
{
    $img=imag($res["Picture"]);
    echo '    <!-- Sidenav -->
    <div class="sidenav">
        <div class="profile">
            <img src='.$img.' alt="" width="100" height="100">

            <div class="name">
                '.$res["Name"].'
            </div>
            <div class="job">
                Teacher
            </div>
        </div>

        <div class="sidenav-url">
            <div class="url">
                <a href="#profile" class="active">Profile</a>
                <hr align="center">
            </div>
            <div class="url">
                <hr align="center">
            </div>
        </div>
    </div>
    <!-- End -->';

    echo '<!-- Main -->
    <div class="main">
        <h2>IDENTITY</h2>
        <div class="card">
            <div class="card-body">
                <i class="fa fa-pen fa-xs edit"></i>
                <table>
                    <tbody>
                        <tr>
                            <td class="header">Name</td>
                            <td>:</td>
                            <td>'.$res["Name"].'</td>
                        </tr>
                        <tr>
                            <td class="header">Email</td>
                            <td>:</td>
                            <td>'.$res["Email"].'</td>
                        </tr>
                        <tr>
                            <td class="header">Address</td>
                            <td>:</td>
                            <td>'.$res["Address"].'</td>
                        </tr>
                        <tr>
                            <td class="header">Phone no.</td>
                            <td>:</td>
                            <td>'.$res["MobileNumber"].'</td>
                        </tr>
                        <tr>
                            <td class="header">Qualification</td>
                            <td>:</td>
                            <td>'.$res["Qualifications"].'</td>
                        </tr>
                        <tr>
                            <td class="header">Experience</td>
                            <td>:</td>
                            <td>'.$res["teachingExp"].' year</td>
                        </tr>
                        <tr>
                            <td class="header">Subject</td>
                            <td>:</td>
                            <td>'.$res["TeacherSub"].'</td>
                        </tr>
                        <tr>
                            <td class="header">Description</td>
                            <td>:</td>
                            <td>'.$res["description"].'</td>
                        </tr>
                        <tr>
                            <td class="header">Visibility</td>
                            <td>:</td>
                            <td>'.visib($res["isPublic"]).'</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- End -->
    ';
}

function imag($name)
{
    return "../teacher/images/".$name;
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