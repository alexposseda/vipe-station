<?php

echo "\n  Enter robot email: default(robotogrsol@gmail.com) ";
$robotEmail = trim(fgets(STDIN));
if (empty($robotEmail)) {
    $robotEmail = 'robotogrsol@gmail.com';
}

$useFileTransport = 1;
echo "\n  Use FileTransport [y/n] ";
$answer = trim(fgets(STDIN));
if (!strncasecmp($answer, 'y', 1)) {
    $flag = true;
    $useFileTransport = 0;
}

if ($flag) {
    echo "\n  Host: default(smtp.gmail.com)";
    $host = trim(fgets(STDIN));
    if (empty($host))
        $host = 'smtp.gmail.com';

    while (empty($user)) {
        echo "\n  Username: ";
        $user = trim(fgets(STDIN));
        if (!empty($user)) {
            continue;
        }
        printError("username must not be empty");
    }
    while (empty($pass)) {
        echo "\n  Password: ";
        $pass = trim(fgets(STDIN));
        if (!empty($pass)) {
            continue;
        }
        printError("password must not be empty");
    }
    echo "\n  Port: default(587) ";
    $port = trim(fgets(STDIN));
    if (empty($port))
        $port = '587';
    echo "\n  Encryption: default(tls) ";
    $encryption = trim(fgets(STDIN));
    if (empty($encryption)) {
        $encryption = 'tls';
    }
    //todo проверить почту на работоспособность
    if (1) {
        $file = fopen(dirname(dirname(__DIR__)) . '/common/config/mailConfig.php', 'w');
        $content = '<?php $mailSetting' . " = [
        'host'=>'$host',
        'user'=>'$user',
        'pass'=>'$pass',
        'port'=>'$port',
        'robot'=>'$robotEmail',
        'fileTransport'=>$useFileTransport,
        'encryption' => '$encryption',
        ];";
        if (!fwrite($file, $content)) {
            printError("Error saving");
            fclose($file);
            exit(2);
        }
        fclose($file);
    }
} else {
    $file = fopen(dirname(dirname(__DIR__)) . '/common/config/mailConfig.php', 'w');
    $content = '<?php $mailSetting' . "=['robot'=>'$robotEmail', 'fileTransport'=>$useFileTransport];";
    if (!fwrite($file, $content)) {
        printError("Error saving");
        fclose($file);
        exit(2);
    }
    fclose($file);
}

