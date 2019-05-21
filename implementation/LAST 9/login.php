<?php
include ('ChromePhp.php');
include ("config.php");
session_start();

$func_name = mysqli_real_escape_string($db, $_POST["func_name"] );

ChromePhp::log("sdasdas");

switch($func_name)
{
    case 'set_session':
        set_session($_POST["key"],$_POST["value"]);
        break;
    case 'fetch_user':
        fetch_user($db,$_POST["username"], $_POST["password"]);
        break;

    default:
        echo "-1";
}

function set_session($key, $value)
{
    $_SESSION[$key] = $value;
}

function fetch_user($db,$thisusername, $thispass)
{

$dbdata = array();
    $query =
         "
         SELECT user_id FROM User
         WHERE username = '$thisusername'
         AND password = '$thispass';
		     ";

    $result = mysqli_query($db,$query);
    
    while($row=mysqli_fetch_assoc($result))
    {
        $user_id = $row['user_id'];
        $query =
         "
         SELECT * FROM PrivilegedUser
         WHERE user_id = '$user_id';
         ";
        
    $results = mysqli_query($db,$query);
        
        if(mysqli_num_rows($results) == 0){
            $_SESSION['privileged'] = 0;
        }
        else{
            $_SESSION['privileged'] = 1;
        }
        
        $dbdata[]=$row;
    }
    
    echo json_encode($dbdata);
}

?>
