<?php
include ('ChromePhp.php');
include("config.php");
session_start();

$func_name  = mysqli_real_escape_string($db, $_POST['func_name'] );

switch($func_name)
{
    
    case 'fetch_privileged':
        echo $_SESSION['privileged'];
        break;
    case 'set_session':
        set_session($_POST['key'],$_POST['value']);
        break;
        //board page
    case 'fetch_project':
        fetch_project($db,$_SESSION['user_id']);
        break;
    case 'delete_project':
        delete_project($db,$_POST['project_id']);
        break;
    case 'add_project':
        add_project($db,$_POST['name'],$_POST['description'],$_SESSION['user_id']);
        break;
    default:
        echo "-1";
}






function set_session($key, $value)
{
    $_SESSION[$key] = $value;
}




//board page
function fetch_project($db,  $user_id)
{
    
    $dbdata = array();

    $sql=mysqli_query
        ($db,
         "
			SELECT * FROM (SELECT project_id, description, name FROM Project) AS P NATURAL JOIN MemberOf WHERE user_id =$user_id; 

		"
        );
    ChromePhp::log($sql);
    while($row=mysqli_fetch_assoc($sql))
    {
        $dbdata[]=$row;
    }
    echo json_encode($dbdata);
}

function delete_project($db,  $project_id)
{
    ChromePhp::log($project_id);
    $sql=mysqli_query
        ($db,
         "
			DELETE FROM Project
			WHERE project_id=$project_id;
		"
        );
}

function add_project($db,$name,$description, $user_id)
{
    $sql=mysqli_query
        ($db,
         "
            INSERT INTO Project (name, description, start_date, end_date,user_id,status) 
            VALUES ('$name', '$description', CURDATE(),CURDATE(),$user_id,'new');
		"
        );
    $lastid = mysqli_insert_id($db);
     $sql=mysqli_query
        ($db,
         "
            INSERT INTO MemberOf (user_id, project_id) 
            VALUES ($user_id, $lastid);
		"
        );
}


?>