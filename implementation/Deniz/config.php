<?php
    define('DB_SERVER', '139.179.11.31');
    define('DB_USERNAME', 'd.yuksel');
    define('DB_PASSWORD', 'Z6ylCbe3');
    define('DB_DATABASE', 'd_yuksel');
    $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    mysqli_query($db,'SET CHARACTER SET utf8' );
?>
