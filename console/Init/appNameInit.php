<?php
$mainLocal = $root . $params['env'] . '/common/config/main-local.php';
$content = file($mainLocal);

$flag = false;
echo "\n  Change application Name default(My Yii Application) [y/n] ";
$answer = trim(fgets(STDIN));
if (!strncasecmp($answer, 'y', 1)) {
    $flag = true;
}
if ($flag) {
    while (empty($appName)) {
        echo "\n  Enter new appName: ";
        $appName = trim(fgets(STDIN));
        if (!empty($appName)) {
            array_slice($content, 2, 0, "'name'=>'$appName',");
            continue;
        }
        printError("Name must not be empty");
    }

//    $file = fopen(dirname(dirname(__DIR__)) . '/common/config/appSetting.php', 'w');
    $file = fopen($mainLocal, 'w');
    $content = implode("\n", $content);
    if (!fwrite($file, $content)) {
        printError("Error saving");
        fclose($file);
        exit(2);
    }
    fclose($file);
}
