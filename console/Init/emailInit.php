<?php

echo "\n  Enter robot email: default(robotogrsol@gmail.com) ";
$robotEmail = trim(fgets(STDIN));
if (empty($robotEmail)) {
    $robotEmail = 'robotogrsol@gmail.com';
}

$paramsEmail = $root . '/common/config/params-email.php';
$file = fopen($paramsEmail, 'w');
if (!fwrite($file, "<?php return[ 'robotEmail' => '$robotEmail', ];")) {
    printError("Error saving");
    fclose($file);
    exit(2);
}
fclose($file);

$mailConfig = $root . '/common/config/main-email.php';
$content = "<?php return[";

$useFileTransport = 1;
echo "\n  Use FileTransport [y/n] ";
$answer = trim(fgets(STDIN));
if (!strncasecmp($answer, 'y', 1)) {
    $flag = true;
    $useFileTransport = 0;
}
$content .= "'components' => ['mailer'=>['useFileTransport' => $useFileTransport,";

if ($flag) {
    $transport = '[';
    echo "\n  Host: default(smtp.gmail.com)";
    $host = trim(fgets(STDIN));
    if (empty($host)) {
        $host = 'smtp.gmail.com';
    }
    $transport .= "'host' => '$host',";

    while (empty($user)) {
        echo "\n  Username: ";
        $user = trim(fgets(STDIN));
        if (!empty($user)) {
            continue;
        }
        printError("username must not be empty");
    }
    $transport .= "'username' => '$user',";

    while (empty($pass)) {
        echo "\n  Password: ";
        $pass = trim(fgets(STDIN));
        if (!empty($pass)) {
            continue;
        }
        printError("password must not be empty");
    }
    $transport .= "'password' => '$pass',";

    echo "\n  Port: default(587) ";
    $port = trim(fgets(STDIN));
    if (empty($port)) {
        $port = '587';
    }
    $transport .= "'port' => '$port',";

    echo "\n  Encryption: default(tls) ";
    $encryption = trim(fgets(STDIN));
    if (empty($encryption)) {
        $encryption = 'tls';
    }
    $transport .= "'encryption' => '$encryption',";
    $transport .= '],';

    $content .= "'transport' => $transport ]";

    $to = '';
    while (empty($to)) {
        echo "\n  Куда отправить тестовое письмо? ";
        $to = trim(fgets(STDIN));
        if (empty($to)) {
            printError('emailTo must be not empty');
        }
    }

    try {
        require_once 'swiftmailer/lib/swift_required.php';

        $transport = Swift_SmtpTransport::newInstance($host, $port, $encryption)
            ->setUsername($user)
            ->setPassword($pass);
        $mailer = Swift_Mailer::newInstance($transport);

        $message = Swift_Message::newInstance('Check send mail')
            ->setFrom(array($robotEmail))
            ->setTo(array($to))
            ->setBody('Check send mail');
        $result = $mailer->send($message);
        if (!$result) {
            printError("SMPT config not valid");
        }
    } catch (\Exception $e) {
        printError($e);
    }

}

$content .= '],];';


$file = fopen($mailConfig, 'w');
if (!fwrite($file, $content)) {
    printError("Error saving");
    fclose($file);
    exit(2);
}
fclose($file);

