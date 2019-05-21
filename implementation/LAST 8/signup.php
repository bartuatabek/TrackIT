<?php
include ("ChromePhp.php");
include ("config.php");
session_start();

$func_name  = mysqli_real_escape_string($db, $_POST["func_name"] );

switch($func_name)
{
    case 'set_session':
        set_session($_POST["key"],$_POST["value"]);
        break;
    case 'new_user':
        new_user($db,$_POST["username"], $_POST["name"], $_POST["email"], $_POST["password"],$_POST["user_type"]);
        break;

    default:
        echo "-1";
}

function set_session($key, $value)
{
    $_SESSION[$key] = $value;
}

function new_user($db,$username, $name, $email, $password,$user_type)
{
    
    $query_signup =
         "
         INSERT INTO User(name, username, password, email)
         VALUES ('$name','$username', '$password', '$email');
         ";

    $result = mysqli_query($db,$query_signup);
    
    $lastid = mysqli_insert_id($db);
    
    $query_type = "";
    if($user_type == 1){
        $query_type =
        "
        INSERT INTO PrivilegedUser(user_id) VALUES ('$lastid');
        ";
    }
    else{
        $query_type="
            INSERT INTO StandardUser(user_id) VALUES ('$lastid');
        ";
    }
    $result = mysqli_query($db,$query_type);
    
    
}
?>
