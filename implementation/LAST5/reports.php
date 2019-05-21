<?php
include ('ChromePhp.php');
include("config.php");
session_start();
$project_id = $_SESSION['project_id'];
$func_name  = mysqli_real_escape_string($db, $_POST['func_name'] );


switch($func_name)
{
    case 'fetch_projectCount':
        fetch_projectCount($db,$_SESSION['user_id']);
        break;
    case 'fetch_teamCount':
        fetch_teamCount($db,$_SESSION['user_id']);
        break;
        
        case 'fetch_greatestProject':
        fetch_greatestProject($db);
        break;

    default:
        echo "-1";
}




function fetch_greatestProject($db)
{
    $sql=mysqli_query
        ($db,
         "
            SELECT max(user_count) as count from( select COUNT(*) AS user_count from MemberOf group by project_id) as t;
		"
        );
    if($sql){
        $row=mysqli_fetch_assoc($sql);
        echo $row['count'];
        
    }else{
        echo 0;
    }
}




function fetch_teamCount($db, $user_id)
{
    $sql=mysqli_query
        ($db,
         "
            SELECT COUNT(*) AS count FROM Contributes WHERE user_id=$user_id GROUP BY team_id;
		"
        );
    if($sql){
        $row=mysqli_fetch_assoc($sql);
        echo $row['count'];
        
    }else{
        echo 0;
    }
}


function fetch_projectCount($db,$user_id)
{
    $sql=mysqli_query
        ($db,
         "
            SELECT COUNT(*) AS count FROM MemberOf WHERE user_id=$user_id GROUP BY project_id;
		"
        );
    if($sql){
        $row=mysqli_fetch_assoc($sql);
        echo $row['count'];
        
    }else{
        echo 0;
    }
    
        
}






?>