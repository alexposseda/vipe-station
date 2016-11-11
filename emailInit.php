<?php

echo "\n Enter robot email: default(robotogrsol@gmail.com) ";
$robotEmail = trim(fgets(STDIN));
if (empty($robotEmail)) {
    $robotEmail = 'robotogrsol@gmail.com';
}

echo "\n Use FileTransport [y/n]";
$answer = trim(fgets(STDIN));
if (strncasecmp($answer, 'y', 1)) {
    $flag = false;
}

if ($flag) {
    echo "\n Host: default(smtp.gmail.com)";
    $host = trim(fgets(STDIN));
    if (empty($host))
        $host = 'smtp.gmail.com';

    while (empty($user)) {
        echo "\n Username: ";
        $user = trim(fgets(STDIN));
        if (!empty($user)) {
            echo "username must not be empty";
            continue;
        }
    }
    while (empty($pass)) {
        echo "\n Username: ";
        $pass = trim(fgets(STDIN));
        if (!empty($pass)) {
            echo "username must not be empty";
            continue;
        }
    }
    $port = trim(fgets(STDIN));
    if (empty($port))
        $port = '587';
}

if (1) {
    $file = fopen(__DIR__ . '/common/config/mailConfig.php', 'w');

    if (!fwrite($file, '<?php $mailSetting' . "=['host'=>'$host','user'=>'$user','pass'=>'$pass','port'=>'$port'];")) {
        echo "Error saving";
    }

}