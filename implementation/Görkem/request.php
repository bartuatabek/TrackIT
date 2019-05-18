<?php
    include("config.php");
    session_start();
    $_SESSION['project_id'] = 1; //this is mock id
    $_SESSION['user_id'] = 1; //this is mock id
    $project_id = $_SESSION['project_id'];
	$func_name  = mysqli_real_escape_string($db, $_POST['func_name'] );
	

	switch($func_name)
	{
		case 'add_team'	:
			  add_team($db, $_POST['team_name'], $_POST['team_description']);
        case 'fetch_team':
			  fetch_team($db);
        case 'fetch_project':
			  fetch_project($db,$project_id);
			  break;
		default:
			  echo "-1";
	}
	

	function add_team($db,$name, $description)
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
	}

    function fetch_team($db)
	{
		$sql=mysqli_query
		($db,
        "
			SELECT 	ogr_adi
			FROM 	sinif 
			WHERE 	project_id	='$project_id';
		"
        );
	 
		while($row=mysqli_fetch_assoc($sql))
		{
			echo $row['ogr_adi'];
		}
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
?>