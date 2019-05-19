<?php
include ('ChromePhp.php');
include("config.php");
session_start();
$_SESSION['project_id'] = 1; //this is mock id
$_SESSION['user_id'] = 1; //this is mock id
$_SESSION['privileged'] = 1; //this is mock id
$project_id = $_SESSION['project_id'];
$func_name  = mysqli_real_escape_string($db, $_POST['func_name'] );


switch($func_name)
{
    case 'fetch_privileged':
        echo $_SESSION['privileged'];
        break;
    case 'set_session':
        set_session($_POST['key'],$_POST['value']);
        break;
        //team page
    case 'add_team'	:
        add_team($db, $_POST['team_name'], $_POST['team_description'], $project_id);
        break;
    case 'fetch_team':
        fetch_team($db,$project_id);
        break;
    case 'fetch_project':
        fetch_project($db,$project_id);
        break;
    case 'fetch_pparticipants':
        fetch_pparticipants($db,$project_id);
        break;
    case 'fetch_tparticipants':
        fetch_tparticipants($db,$_POST['team_id']);
        break;
    case 'delete_team':
        delete_team($db,$_POST['team_id']);
        break;
    case 'add_userToTeam':
        add_userToTeam($db,$_POST['team_id'], $_POST['user_id'],$project_id);
        break;
    case 'fetch_users':
        fetch_users($db);
        break;
    case 'add_userToProject':
        add_userToProject($db,$_POST['user_id'],$project_id);
        break;
    case 'fetch_userByName':
        fetch_userByName($db,$_POST['name']);
        break;
    case 'delete_userFromTeam':
        delete_userFromTeam($db,$_POST['user_id'],$_POST['team_id']);
        break;
    case 'delete_userFromProject':
        delete_userFromProject($db,$_POST['user_id'],$project_id);
        break;

        //board page
    case 'fetch_board':
        fetch_board($db,$_SESSION['team_id']);
        break;
    case 'delete_board':
        delete_board($db,$_POST['board_id']);
        break;
    case 'add_board':
        add_board($db,$_POST['name'],$_POST['description'],$_SESSION['team_id'],$_SESSION['user_id']);
        break;



    default:
        echo "-1";
}






function set_session($key, $value)
{
    $_SESSION[$key] = $value;
}

function add_team($db,$name, $description, $project_id)
{
    $name = mysqli_real_escape_string($db, $name );
    $description = mysqli_real_escape_string($db, $description );

    $sql=mysqli_query
        ($db,
         "
            INSERT INTO Team (name, description, formation_date) 
            VALUES ('$name', '$description', CURDATE());
		"
        );

    $lastid = mysqli_insert_id($db);
    $sql=mysqli_query
        ($db,
         "
            INSERT INTO Retains (project_id, team_id) 
            VALUES ($project_id, $lastid);
		"
        );
}


function add_userToTeam($db,$team_id, $user_id,$project_id)
{
    $sql=mysqli_query
        ($db,
         "
            INSERT INTO Contributes (user_id, team_id) 
            VALUES ($user_id, $team_id);
		"
        );
    $sql=mysqli_query
        ($db,
         "
            INSERT INTO MemberOf (user_id, project_id) 
            VALUES ($user_id, $project_id);
		"
        );
}


function add_userToProject($db,$user_id,$project_id)
{
    $sql=mysqli_query
        ($db,
         "
            INSERT INTO MemberOf (user_id, project_id) 
            VALUES ($user_id, $project_id);
		"
        );
}


function fetch_team($db,$project_id)
{
    $dbdata = array();

    $sql=mysqli_query
        ($db,
         "
			SELECT 	T.description, T.name, T.team_id
			FROM 	Retains NATURAL JOIN Team AS T 
			WHERE 	project_id	='$project_id';
		"
        );

    while($row=mysqli_fetch_assoc($sql))
    {
        $dbdata[]=$row;
    }
    echo json_encode($dbdata);
}
function delete_userFromTeam($db,$user_id,$team_id)
{
    $sql=mysqli_query
        ($db,
         "
			DELETE FROM Contributes
			WHERE team_id='$team_id' AND user_id=$user_id;
		"
        );
}
function delete_userFromProject($db,$user_id,$project_id)
{

    $sql=mysqli_query
        ($db,
         "
            DELETE FROM Contributes
			WHERE team_id IN (SELECT team_id FROM Retains 
            WHERE project_id =$project_id) AND user_id=$user_id;

		"
        );

    $sql=mysqli_query
        ($db,
         "
			DELETE FROM MemberOf
			WHERE project_id='$project_id' AND user_id=$user_id;
		"
        );
}
function fetch_userByName($db,$name)
{
    $dbdata = array();

    $sql=mysqli_query
        ($db,
         "
			SELECT 	name, user_id
			FROM 	User
			WHERE 	name='$name';
		"
        );

    while($row=mysqli_fetch_assoc($sql))
    {
        $dbdata[]=$row;
    }
    echo json_encode($dbdata);
}

function fetch_pparticipants($db,  $project_id)
{
    $dbdata = array();

    $sql=mysqli_query
        ($db,
         "
			SELECT 	U.name, U.user_id
			FROM 	MemberOf NATURAL JOIN User AS U
			WHERE 	project_id	='$project_id';
		"
        );

    while($row=mysqli_fetch_assoc($sql))
    {
        $dbdata[]=$row;
    }
    echo json_encode($dbdata);
}

function fetch_tparticipants($db,  $team_id)
{
    $dbdata = array();

    $sql=mysqli_query
        ($db,
         "
			SELECT 	U.name, U.user_id
			FROM 	Contributes NATURAL JOIN User AS U
			WHERE 	team_id	='$team_id';
		"
        );

    while($row=mysqli_fetch_assoc($sql))
    {
        $dbdata[]=$row;
    }
    echo json_encode($dbdata);
}



function fetch_users($db)
{
    $dbdata = array();

    $sql=mysqli_query
        ($db,
         "
			SELECT name, user_id
			FROM User
		"
        );

    while($row=mysqli_fetch_assoc($sql))
    {
        $dbdata[]=$row;
    }
    echo json_encode($dbdata);
}



function delete_team($db,  $team_id)
{
    $sql=mysqli_query
        ($db,
         "
			DELETE FROM Team
			WHERE team_id='$team_id';
		"
        );
}

function fetch_project($db,  $project_id)
{
    $dbdata = array();

    $sql=mysqli_query
        ($db,
         "
			SELECT 	*
			FROM 	Project 
			WHERE 	project_id	='$project_id';
		"
        );

    while($row=mysqli_fetch_assoc($sql))
    {
        $dbdata[]=$row;
    }
    echo json_encode($dbdata);
}


//board page
function fetch_board($db,  $team_id)
{
    $dbdata = array();

    $sql=mysqli_query
        ($db,
         "
			SELECT 	board_id, description, name
			FROM 	Board 
			WHERE 	team_id	=$team_id;
		"
        );

    while($row=mysqli_fetch_assoc($sql))
    {
        $dbdata[]=$row;
    }
    echo json_encode($dbdata);
}
function delete_board($db,  $board_id)
{
    $sql=mysqli_query
        ($db,
         "
			DELETE FROM Board
			WHERE board_id='$board_id';
		"
        );
}

function add_board($db,$name,$description, $team_id, $user_id)
{
    $sql=mysqli_query
        ($db,
         "
            INSERT INTO Board (name, description, create_date, team_id, user_id) 
            VALUES ('$name', '$description', CURDATE(),$team_id,$user_id);
		"
        );
}


?>