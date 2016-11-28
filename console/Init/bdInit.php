<?php

$flag = false;
echo "\n  Data base config [y/n] ";
$answer = trim(fgets(STDIN));
if (!strncasecmp($answer, 'y', 1)) {
    $flag = true;
}
if ($flag) {
    $dbConfig = $root . '/common/config/main-db.php';
    $content = "<?php return[";

    $content .= "'components' => [
        'db' => [";
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
    $content .= "'dsn' => 'mysql:host=$dbHost; dbname=$dbName', ";
    while (empty($dbUsername)) {
        echo "\n  Enter DB-username: ";
        $dbUsername = trim(fgets(STDIN));
        if (!empty($dbUsername)) {
            continue;
        }
        printError("$dbUsername is not empty. Please enter DB-username");
    }
    $content .= "'username' => '$dbUsername', ";
    echo "\n  Enter DB-password: ";
    $dbPassword = trim(fgets(STDIN));
    $content .= "'password' => '$dbPassword', ";

    echo "\n  Enter DB-tablePrefix: ";
    $dbTablePrefix = trim(fgets(STDIN));
    $content .= "'tablePrefix' => '$dbTablePrefix', ";
    $content .= "]]];";

    $connection = @new Mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

    if ($connection->connect_error) {
        printError("Error DB Setting (' . $connection->connect_errno . ') '. $connection->connect_error");
        exit(2);
    } else {
        $file = fopen($dbConfig, 'w');
        if (!fwrite($file, $content)) {
            printError("Error saving");
            fclose($file);
            exit(2);
        }
        fclose($file);
    }
}