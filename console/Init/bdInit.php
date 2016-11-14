<?php

$flag = false;
echo "\n  Data base config [y/n] ";
$answer = trim(fgets(STDIN));
if (!strncasecmp($answer, 'y', 1)) {
    $flag = true;
}
if ($flag) {
    echo "\n  Enter DB-Host: default(localhost) ";
    $dbHost = trim(fgets(STDIN));
    if (empty($dbHost)) {
        $dbHost = 'localhost';
    }
    while (empty($dbName)) {
        echo "\n  Enter DB-Name: ";
        $dbName = trim(fgets(STDIN));
        if (!empty($dbName)) {
            continue;
        }
        printError("$dbName is not empty. Please enter DB-Name");
    }
    while (empty($dbUsername)) {
        echo "\n  Enter DB-username: ";
        $dbUsername = trim(fgets(STDIN));
        if (!empty($dbUsername)) {
            continue;
        }
        printError("$dbUsername is not empty. Please enter DB-username");
    }
    echo "\n  Enter DB-password: ";
    $dbPassword = trim(fgets(STDIN));

    echo "\n  Enter DB-tablePrefix: ";
    $dbTablePrefix = trim(fgets(STDIN));

    if (!mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName)) {
        printError("Wrong DB setting");
        exit(2);
    } else {
        $connection = @new Mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
        if ($connection->connect_error) {
            printError("Error DB Setting (' . $connection->connect_errno . ') '. $connection->connect_error");
            exit(2);
        } else {
            $file = fopen(dirname(dirname(__DIR__)) . '/common/config/db.php', 'w');
            if (!fwrite($file, '<?php $dbSetting' . "=['host'=>'$dbHost','name'=>'$dbName','user'=>'$dbUsername','pass'=>'$dbPassword','tablePrefix'=>'$dbTablePrefix'];")) {
                printError("Error saving");
                fclose($file);
                exit(2);
            }
            fclose($file);
        }
    }
}