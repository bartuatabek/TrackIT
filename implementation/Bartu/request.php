<?php
include("config.php");
session_start();

$_SESSION['project_id'] = 1; //this is mock id
$_SESSION['user_id'] = 1; //this is mock id
$_SESSION['board_id'] = 1; //this is mock id
$project_id = $_SESSION['project_id'];
$func_name = mysqli_real_escape_string($connection, $_POST['func_name']);

switch($func_name) {
    case 'remove_privilage':
        remove_privilage($connection, $_POST['user_id']);
        break;
		case 'add_privilage':
        add_privilage($connection, $_POST['user_id']);
        break;
		case 'fetch_lists':
        fetch_lists($connection, $_SESSION['board_id']);
        break;
		case 'fetch_cards':
        fetch_cards($connection, $_POST['list_id'], $_SESSION['user_id']);
        break;
		case 'add_lists':
        add_lists($connection, $_POST['title'], $_SESSION['board_id']);
        break;
		case 'remove_lists':
        remove_lists($connection, $_POST['list_id'], $_SESSION['board_id']);
        break;
		case 'create_archive':
				create_archive($connection);
				break;
		case 'is_archived':
				is_archived($connection, $_SESSION['user_id'], $project_id, $_POST['card_id']);
				break;
		case 'archive_card':
        archive_card($connection, $_SESSION['user_id'], $project_id, $_POST['card_id']);
        break;
		case 'unarchive_card':
        unarchive_card($connection, $_SESSION['user_id'], $project_id, $_POST['card_id']);
        break;
		case 'change_card_list':
        change_card_list($connection, $_POST['list_id'], $_POST['card_id'], $_SESSION['user_id']);
        break;
		case 'add_card':
        add_card($connection, $_POST['title'], $_POST['description'],$_SESSION['user_id'],$_POST['list_id']);
        break;
    case 'show_card':
        show_card($connection, $_POST['card_id']);
        break;
		case 'fetch_assignedusers':
        fetch_assignedusers($connection, $_POST['card_id']);
        break;
    case 'assign_user':
        assign_user($connection, $_POST['card_id'],$_POST['user_id']);
        break;
    case 'delete_card':
        delete_card($connection, $_POST['card_id']);
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

function fetch_lists($connection, $board_id) {
	$dbdata = array();
	$sql = "SELECT list_id, title FROM Lists WHERE board_id='$board_id' ORDER BY list_id ASC";
	$result = mysqli_query($connection, $sql);
	
	while($row=mysqli_fetch_assoc($result)) {
        $dbdata[]=$row;
    }
    echo json_encode($dbdata);
}

function fetch_cards($connection, $list_id, $user_id) {
	$dbdata = array();
	$sql = "SELECT card_id, title FROM Cards WHERE list_id='$list_id' AND user_id='$user_id'";
	$result = mysqli_query($connection, $sql);
	
	while($row=mysqli_fetch_assoc($result)) {
        $dbdata[]=$row;
    }
    echo json_encode($dbdata);
}

function add_lists($connection, $title, $board_id) {
	$insert_query = "INSERT INTO Lists (title, board_id) VALUES ('$title', '$board_id')";
	mysqli_query($connection, $insert_query);
}

function remove_lists($connection, $list_id, $board_id) {
	$del_query = "DELETE FROM Lists WHERE list_id='$list_id' AND board_id='$board_id'";  
	mysqli_query($connection, $del_query);
}

function create_archive($connection) {
	$sql = "SELECT list_id FROM Lists";
	$result = mysqli_query($connection, $sql);
	
	if($result-> num_rows == 0) {
		$title = 'Archive';
		$board_id = $_SESSION['board_id'];
		add_lists($connection, $title, $board_id);
	}
}

function is_archived($connection, $user_id, $project_id, $card_id) {
	$sql = "SELECT archive_id FROM Archive NATURAL JOIN Actions WHERE user_id='$user_id' AND project_id='$project_id' AND card_id='$card_id'";
	$result = mysqli_query($connection, $sql);
	
	if($result-> num_rows == 0) {
		archive_card($connection, $user_id, $project_id, $card_id);
	}else{
		unarchive_card($connection, $user_id, $project_id, $card_id);
	}
}

function archive_card($connection, $user_id, $project_id, $card_id) {
	$insert_actions = "INSERT INTO Actions (user_id, project_id, card_id) VALUES ('$user_id', '$project_id', '$card_id')";
	mysqli_query($connection, $insert_actions);
	
	$sql = "SELECT item_id FROM Actions WHERE user_id='$user_id' AND project_id='$project_id' AND card_id='$card_id'";
	$result = mysqli_query($connection, $sql);
	$value = mysqli_fetch_assoc($result);
	$item_id =$value['item_id'];
	$insert_archive = "INSERT INTO Archive (archived_date, item_id) VALUES (CURDATE(), '$item_id')";
	mysqli_query($connection, $insert_archive);
	change_card_list($connection, 1, $card_id, $user_id);
}

function unarchive_card($connection, $user_id, $project_id, $card_id) {
	$sql = "SELECT archive_id FROM Archive NATURAL JOIN Actions WHERE user_id='$user_id' AND project_id='$project_id' AND card_id='$card_id'";
	$result = mysqli_query($connection, $sql);
	$value = mysqli_fetch_assoc($result);
	$archive_id =$value['archive_id'];
	
	$delete_actions = "DELETE FROM Actions WHERE user_id='$user_id' AND project_id='$project_id' AND card_id='$card_id'";
	mysqli_query($connection, $delete_actions);
	change_card_list($connection, $archive_id, $card_id, $user_id);
}

function change_card_list($connection, $list_id, $card_id, $user_id) {
	$sql = "UPDATE Cards SET list_id='$list_id' WHERE card_id='$card_id' AND user_id='$user_id'";
	mysqli_query($connection, $sql);
}

function add_card($connection, $title, $description,$user_id,$list_id) {
        $sql=mysqli_query
        ($connection,
         "
            INSERT INTO Cards (title, description, status,start_date,user_id,list_id) 
            VALUES ('$title', '$description', 'new',CURDATE(),$user_id,$list_id);
		"
        );
}

function show_card($connection,$card_id) {
    $dbdata = array();

    $sql=mysqli_query
        ($connection,
         "
			SELECT 	description, title
			FROM 	Cards
			WHERE 	card_id	=$card_id;
		"
        );

    while($row=mysqli_fetch_assoc($sql))
    {
        $dbdata[]=$row;
    }
    echo json_encode($dbdata);
}

function fetch_assignedusers($connection,$card_id) {
    $dbdata = array();

    $sql=mysqli_query
        ($connection,
         "
			SELECT 	name, user_id
			FROM 	AssignsCard NATURAL JOIN User
			WHERE 	card_id	=$card_id;
		"
        );

    while($row=mysqli_fetch_assoc($sql))
    {
        $dbdata[]=$row;
    }
    echo json_encode($dbdata);
}

function assign_user($connection,$card_id,$user_id) {
    $sql=mysqli_query
        ($connection,
         "
            INSERT INTO AssignsCard (card_id, user_id) 
            VALUES ($card_id,$user_id);
		"
        );
}

function delete_card($connection,$card_id) {
    $sql=mysqli_query
        ($connection,
         "
            DELETE FROM Cards
			WHERE card_id='$card_id';
		"
        );
}
?>