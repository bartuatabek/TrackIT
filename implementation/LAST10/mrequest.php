<?php
include("config.php");
include 'ChromePhp.php';
session_start();

$project_id = $_SESSION['project_id'];
$func_name = mysqli_real_escape_string($db, $_POST['func_name']);

switch($func_name) {
		case 'user_cred':
				user_cred($db, $_SESSION['user_id']);
				break;
    case 'remove_privilage':
        remove_privilage($db, $_POST['user_id']);
        break;
		case 'add_privilage':
        add_privilage($db, $_POST['user_id']);
        break;
		case 'fetch_lists':
        fetch_lists($db, $_SESSION['board_id']);
        break;
		case 'fetch_cards':
        fetch_cards($db, $_POST['list_id'], $_SESSION['user_id']);
        break;
		case 'add_lists':
        add_lists($db, $_POST['title'], $_SESSION['board_id']);
        break;
		case 'remove_lists':
        remove_lists($db, $_POST['list_id'], $_SESSION['board_id']);
        break;
		case 'add_comment':
				add_comment($db, $_SESSION['user_id'], $project_id, $_POST['card_id'], $_POST['comment']);
				break;
		case 'fetch_comments':
				fetch_comments($db, $_SESSION['user_id'], $project_id, $_POST['card_id']);
				break;
		case 'create_archive':
				create_archive($db);
				break;
		case 'is_archived':
				is_archived($db, $_SESSION['user_id'], $project_id, $_POST['card_id']);
				break;
		case 'archive_card':
        archive_card($db, $_SESSION['user_id'], $project_id, $_POST['card_id']);
        break;
		case 'unarchive_card':
        unarchive_card($db, $_SESSION['user_id'], $project_id, $_POST['card_id']);
        break;
		case 'change_card_list':
        change_card_list($db, $_POST['list_id'], $_POST['card_id'], $_SESSION['user_id']);
        break;
		case 'add_card':
        add_card($db, $_POST['title'], $_POST['description'],$_SESSION['user_id'],$_POST['list_id']);
        break;
    case 'show_card':
        show_card($db, $_POST['card_id']);
        break;
		case 'fetch_assignedusers':
        fetch_assignedusers($db, $_POST['card_id']);
        break;
    case 'assign_user':
        assign_user($db, $_POST['card_id'],$_POST['user_id']);
        break;
    case 'delete_card':
        delete_card($db, $_POST['card_id']);
        break;
        
         case 'fetch_commentname':
        fetch_commentname($db, $_POST['card_id']);
        break;
    default:
        echo "-1";
}

function user_cred($db, $user_id) {
	$sql = "SELECT name FROM User WHERE user_id='$user_id'"; 
	$result = mysqli_query($db, $sql);
	$value = mysqli_fetch_object($result);
	$name = $value->name;
	echo json_encode($name);
}

function remove_privilage($db, $user_id) {
	  $del_query = "DELETE FROM PrivilegedUser WHERE user_id='$user_id'";  
		$insert_query = "INSERT INTO StandardUser (user_id) VALUES ('$user_id')";
		mysqli_query($db, $del_query);
		mysqli_query($db, $insert_query);
}

function add_privilage($db, $user_id) {
	  $del_query = "DELETE FROM StandardUser WHERE user_id='$user_id'";  
		$insert_query = "INSERT INTO PrivilegedUser (user_id) VALUES ('$user_id')";
		mysqli_query($db, $del_query);
		mysqli_query($db, $insert_query);
}

function fetch_lists($db, $board_id) {
    ChromePhp::log($board_id);
	$dbdata = array();
	$sql = "SELECT list_id, title FROM Lists WHERE board_id='$board_id' ORDER BY list_id ASC";
	$result = mysqli_query($db, $sql);
	
	while($row=mysqli_fetch_assoc($result)) {
        $dbdata[]=$row;
  }
  echo json_encode($dbdata);
}

function fetch_cards($db, $list_id, $user_id) {
	$dbdata = array();
	$sql = "SELECT card_id, title FROM Cards WHERE list_id='$list_id'";
	$result = mysqli_query($db, $sql);
	
	while($row=mysqli_fetch_assoc($result)) {
        $dbdata[]=$row;
    }
    echo json_encode($dbdata);
}

function add_lists($db, $title, $board_id) {
	$insert_query = "INSERT INTO Lists (title, board_id) VALUES ('$title', '$board_id')";
	mysqli_query($db, $insert_query);
}

function remove_lists($db, $list_id, $board_id) {
	$del_query = "DELETE FROM Lists WHERE list_id='$list_id' AND board_id='$board_id'";  
	mysqli_query($db, $del_query);
}

// TODO
function add_comment($db, $user_id, $project_id, $card_id, $comment) {
	$insert_actions = "INSERT INTO Actions (user_id, project_id, card_id) VALUES ('$user_id', '$project_id', '$card_id')";
	mysqli_query($db, $insert_actions);
	$lastid = mysqli_insert_id($db);

    
	$insert_comment = "INSERT INTO Comment (item_id, comment) VALUES ('$lastid', '$comment')";
	mysqli_query($db, $insert_comment);
}

// TODO
function fetch_comments($db, $user_id, $project_id, $card_id) {
    
	$dbdata = array();
	$sql = "SELECT item_id FROM Actions WHERE project_id=$project_id AND card_id=$card_id";
	$result = mysqli_query($db, $sql);
    
    while($row=mysqli_fetch_assoc($result))
    {
        $item_id = $row['item_id'];
        $fetch_comments = "SELECT comment FROM Comment WHERE item_id='$item_id'";
        
        $results = mysqli_query($db,$fetch_comments);
        
            $new = mysqli_fetch_assoc($results);
        if($new != null)
            $dbdata[]=$new;
    }
    echo json_encode($dbdata);
}

function create_archive($db) {
	$sql = "SELECT list_id FROM Lists";
	$result = mysqli_query($db, $sql);
	
	if($result-> num_rows == 0) {
		$title = 'Archive';
		$board_id = $_SESSION['board_id'];
		add_lists($db, $title, $board_id);
	}
}

function is_archived($db, $user_id, $project_id, $card_id) {
	$sql = "SELECT archive_id FROM Archive NATURAL JOIN Actions WHERE user_id='$user_id' AND project_id='$project_id' AND card_id='$card_id'";
	$result = mysqli_query($db, $sql);
	
	if($result-> num_rows == 0) {
		archive_card($db, $user_id, $project_id, $card_id);
	}else{
		unarchive_card($db, $user_id, $project_id, $card_id);
	}
}

// TODO
function archive_card($db, $user_id, $project_id, $card_id) {
	$insert_actions = "INSERT INTO Actions (user_id, project_id, card_id) VALUES ('$user_id', '$project_id', '$card_id')";
	mysqli_query($db, $insert_actions);
	$lastid = mysqli_insert_id($db);
	
    ChromePhp::log('last:'. $lastid);
	$sql2 = "SELECT list_id FROM Cards WHERE card_id='$card_id'";
	$result = mysqli_query($db, $sql2);
	$value = mysqli_fetch_assoc($result);
	$list_id = $value['list_id'];
	ChromePhp::log('list:'. $list_id);
	$insert_archive = "INSERT INTO Archive (archived_date, archive_id, item_id) VALUES (CURDATE(), $list_id, $lastid);";
	mysqli_query($db, $insert_archive);
	change_card_list($db, 1, $card_id, $user_id);
}

// TODO
function unarchive_card($db, $user_id, $project_id, $card_id) {
//	$sql = "SELECT archive_id FROM Archive NATURAL JOIN Actions WHERE user_id='$user_id' AND project_id='$project_id' AND card_id='$card_id'";
//	$result = mysqli_query($db, $sql);
//	$value = mysqli_fetch_assoc($result);
//	$archive_id = $value->archive_id;
//	
//	$delete_actions = "DELETE FROM Actions WHERE user_id='$user_id' AND project_id='$project_id' AND card_id='$card_id'";
//	mysqli_query($db, $delete_actions);
//	change_card_list($db, $archive_id, $card_id, $user_id);
}

function change_card_list($db, $list_id, $card_id, $user_id) {
	$sql = "UPDATE Cards SET list_id='$list_id' WHERE card_id='$card_id' AND user_id='$user_id'";
	mysqli_query($db, $sql);
}

function add_card($db, $title, $description,$user_id,$list_id) {
        $sql=mysqli_query
        ($db,
         "
            INSERT INTO Cards (title, description, status,start_date,user_id,list_id) 
            VALUES ('$title', '$description', 'new',CURDATE(),$user_id,$list_id);
		"
        );
}

function show_card($db,$card_id) {
    $dbdata = array();

    $sql=mysqli_query
        ($db,
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

function fetch_assignedusers($db,$card_id) {
    $dbdata = array();

    $sql=mysqli_query
        ($db,
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

function assign_user($db,$card_id,$user_id) {
    $sql=mysqli_query
        ($db,
         "
            INSERT INTO AssignsCard (card_id, user_id) 
            VALUES ($card_id,$user_id);
		"
        );
}

function delete_card($db,$card_id) {
    $sql=mysqli_query
        ($db,
         "
            DELETE FROM Cards
			WHERE card_id='$card_id';
		"
        );
}
function fetch_commentname($db, $card_id){
    $dbdata = array();

    $sql=mysqli_query
        ($db,
         "
			select user_id, name from Actions natural join (select card_id from Cards) as C natural join Comment natural join User where card_id = $card_id;
		"
        );

    while($row=mysqli_fetch_assoc($sql))
    {
        $dbdata[]=$row;
    }
    echo json_encode($dbdata);
}
?>