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
    case 'fetch_user':
        fetch_user($db,$username, $password);
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

  $thisusername = isset($_GET["username"]) ? $_GET["username"] : die();
  $thispass = base64_encode(isset($_GET["password"]) ? $_GET["password"] : die();

    $query =
         "
         SELECT username, password FROM User
         WHERE username = "$thisusername"
         AND password = "$thispass";
		     ";

    $result = mysqli_query($db,$query);
    if(!$result)
    {
      $user_res = array(
        "status" => false,
        "message" => "Invalid login credentials!",
      );
    }

    else{
      $row = mysql_fetch_assoc($result);
      $user_res = array(
        "status" => true,
        "username" => $row["username"],
        "pass" => $row["password"],
        "message" => "Successful, you're in!"
      );
    }

    print_r (json_encode($user_res));
}

?>
