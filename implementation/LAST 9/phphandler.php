<?php
    include ('ChromePhp.php');
    include("config.php");
    session_start();
    $project_id = $_SESSION['project_id'];
    $user_id = $_SESSION['user_id'];
    $func_name = mysqli_real_escape_string($db, $_POST['func_name'] );

    switch($func_name)
    {
        case 'add_issue':
          add_issue($db, $_POST['name'], $_POST['status'],
          $_POST['priority'], $_POST['note'], $project_id, $user_id);
          break;
        case 'inspect_issue_card':
          inspect_issue_card($db, $_POST['issue_id']);
          break;
        case 'attach_issue_tag':
          attach_issue_tag($db);
          break;
		    case 'resolve_issue':
          //inspect_issue_card($db, $_POST['issue_id']);
          resolve_issue($db, $_POST['issue_id']);
          break;

        case 'delete_issue':
          delete_issue($db, $user_id);
          break;

          //RELEASE PAGE
        case 'create_release_card':
          create_release_card($db, $_POST['name'], $_POST['version'],
          $_POST['url'], $_POST['note'], $user_id, $project_id);
          break;
        case 'inspect_release_card':
            inspect_release_card($db, $_POST['release_id']);
            break;

        default:
          echo "-1";
    }

    function add_issue( $db, $name, $status, $priority, $note, $project_id, $user_id){
        $addQuery = "INSERT INTO Issue( name, status, start_date, end_date, priority, note, project_id, user_id)
        VALUES('$name', '$status', CURDATE(), 'NULL', '$priority', '$note', '$project_id', '$user_id')";
        mysqli_query($db, $addQuery);
    }

    function inspect_issue_card($db, $issue_id){
        $dbdata = array();

        $inspectQuery =  mysqli_query
        ($db,
          "
          SELECT * FROM Issue WHERE issue_id = '$issue_id';
          "
        );

        while($row = mysqli_fetch_assoc($inspectQuery))
        {
            $dbdata[]=$row;
        }
        echo json_encode($dbdata);
    }

    function attach_issue_tag($db){

    }

    function resolve_issue($db, $issue_id){
      $resolveQuery =  mysqli_query
      ($db,
        "
        UPDATE Issue SET status='Solved' where issue_id='$issue_id';
        "
      );
    }

    function delete_issue($db, $user_id){

    }

    function create_release_card( $db, $name, $version, $url, $note, $user_id, $project_id ){
        $createRCQuery = "INSERT INTO Releases( name, start_date, end_date, version, url, note, user_id, project_id)
        VALUES('$name', CURDATE(), 'NULL', '$version', '$url', '$note', '$user_id', '$project_id')";
        mysqli_query($db, $createRCQuery);
    }

    function inspect_release_card($db, $release_id){
      $dbdataRelease = array();

      $inspectReleaseQuery =  mysqli_query
      ($db,
        "
        SELECT * FROM Releases WHERE release_id = '$release_id';
        "
      );

      while($row = mysqli_fetch_assoc($inspectReleaseQuery))
      {
          $dbdataRelease[]=$row;
      }
      echo json_encode($dbdataRelease);
    }

 ?>
