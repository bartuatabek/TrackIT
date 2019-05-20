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
        new_user($db,$username, $name, $email, $password);
        break;

    default:
        echo "-1";
}

function set_session($key, $value)
{
    $_SESSION[$key] = $value;
}

function new_user($db,$username, $name, $email, $password)
{
    $username = $_POST["username"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = base64_encode($_POST["password"]);
    $confirmpass = $_POST["confirmpass"];
    $user_id = uniqid();

    $query_privileged =
        "
        INSERT INTO PrivilegedUser(user_id) VALUES ("$user_id");
        ";

    $query_standard =
        "
        INSERT INTO StandardUser(user_id) VALUES ("$user_id");
        ";

    $answer = $_POST["user_type"];
    if ($answer == "standard") {
        $row = mysql_fetch_assoc($query_standard);
    }
    else {
        $row = mysql_fetch_assoc($query_privileged);
    }

    $query_signup =
         "
         INSERT INTO User(name, username, password, e-mail)
         VALUES ("$name","$username", "$password", "$email");
		     ";

    $result = mysqli_query($db,$query_signup);
    if(!$result)
    {
      $user_res = array(
        "status" => false,
        "message" => "You're already in!",
      );
    }

    else{
      $row = mysql_fetch_assoc($result);
      $user_res = array(
        "status" => true,
        "name" => $name,
        "username" => $username,
        "email" => $email,
        "password" => $password,
        "message" => "Successful, you're in!"
      );
    }

    print_r (json_encode($user_res));
}

if (isset($_REQUEST['signup'])) {
    new_user();
  }

?>
