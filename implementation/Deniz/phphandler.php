<?php
    include ('ChromePhp.php');
    include("config.php");
    session_start();
    $_SESSION['project_id'] = 1; //this is mock id
    $_SESSION['user_id'] = 1; //this is mock id
    $project_id = $_SESSION['project_id'];
    $user_id = $_SESSION['user_id'];
    $func_name = mysqli_real_escape_string($db, $_POST['func_name'] );

    switch($func_name)
    {
        case 'add_issue':
          add_issue($db, $_POST['name'], $_POST['status'],
          $_POST['priority'], $_POST['note'], $project_id, $user_id);
          break;
        case 'attach_issue_tag':
          attach_issue_tag($db);
          break;
		    case 'resolve_issue':
          resolve_issue($db, $user_id);
          break;

        case 'delete_issue':
          resolve_issue($db, $user_id);
          break;

        default:
          echo "-1";
    }

    function add_issue( $db, $name, $status, $priority, $note, $project_id, $user_id){
        ChromePhp::log("HEHEHEHE");
        $addQuery = "INSERT INTO Issue( name, status, start_date, end_date, priority, note, project_id, user_id)
        VALUES('$name', '$status', CURDATE(), 'NULL', '$priority', '$note', '$project_id', '$user_id')";
        mysqli_query($db, $addQuery);
    }

    function attach_issue_tag($db){

    }

    function resolve_issue($db, $issue_id, $status){


    }

    function delete_issue($db, $user_id){

    }

 ?>
