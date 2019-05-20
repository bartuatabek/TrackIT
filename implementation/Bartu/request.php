<?php
include("config.php");
session_start();

$_SESSION['project_id'] = 1; //this is mock id
$_SESSION['user_id'] = 1; //this is mock id
$project_id = $_SESSION['project_id'];
$func_name = mysqli_real_escape_string($connection, $_POST['func_name'] );

switch($func_name) {
    case 'remove_privilage':
        remove_privilage($connection, $_POST['user_id']);
        break;
		case 'add_privilage':
        add_privilage($connection, $_POST['user_id']);
        break;
    default:
        echo "-1";
}

function remove_privilage($connection, $user_id) {
	  $del_query = "DELETE FROM PrivilegedUser WHERE user_id='$user_id'";  
		$insert_query = "INSERT INTO StandardUser (user_id) VALUES ('$user_id')";
		mysqli_query($connection, $del_query);
		mysqli_query($connection, $insert_query);
}

function add_privilage($connection, $user_id) {
	  $del_query = "DELETE FROM StandardUser WHERE user_id='$user_id'";  
		$insert_query = "INSERT INTO PrivilegedUser (user_id) VALUES ('$user_id')";
		mysqli_query($connection, $del_query);
		mysqli_query($connection, $insert_query);
}
?>