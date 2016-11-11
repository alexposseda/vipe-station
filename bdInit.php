<?php

echo "\n Enter DB-Host: default(localhost) ";
$dbHost = trim(fgets(STDIN));
if (empty($dbHost)) {
    $dbHost = 'localhost';
}
echo "\n Enter DB-Name: ";
$dbName = trim(fgets(STDIN));
if (empty($dbName)) {
    echo "\n  $dbName is not empty. Please enter DB-Name\n";
    exit(2);
}
echo "\n Enter DB-username: ";
$dbUsername = trim(fgets(STDIN));
if (empty($dbUsername)) {
    echo "\n  $dbUsername is not empty. Please enter DB-username\n";
    exit(2);
}
echo "\n Enter DB-password: ";
$dbPassword = trim(fgets(STDIN));

echo "\n Enter DB-tablePrefix: ";
$dbTablePrefix = trim(fgets(STDIN));

if (!mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName)) {
    echo 'Wrong DB setting';
    exit(2);
} else {

    $connection = @new Mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
    if ($connection->connect_error) {
        echo "Error DB Setting (' . $connection->connect_errno . ') '. $connection->connect_error";
        exit(2);
    } else {
        $file = fopen(__DIR__ . '/common/config/db.php', 'w');
        if (!fwrite($file, '<?php $dbSetting' . "=['host'=>'$dbHost','name'=>'$dbName','user'=>'$dbUsername','pass'=>'$dbPassword','tablePrefix'=>'$dbTablePrefix'];")) {
            echo "Error saving";
        }
    }

}