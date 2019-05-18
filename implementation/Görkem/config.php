<?php
    define('DB_SERVER', '139.179.11.31');
    define('DB_USERNAME', 'gorkem.erturk');
    define('DB_PASSWORD', '41Gp3cPk');
    define('DB_DATABASE', 'gorkem_erturk');
    $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
    if (mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    mysqli_query($db,'SET CHARACTER SET utf8' );
?>