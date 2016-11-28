<?php
$flag = false;
echo "\n  Change application Name default(My Yii Application) [y/n] ";
$answer = trim(fgets(STDIN));
if (!strncasecmp($answer, 'y', 1)) {
    $flag = true;
}
$appSeting = $root . '/common/config/appSeting.php';
$content = "<?php return[";
if ($flag) {
    while (empty($appName)) {
        echo "\n  Enter new appName: ";
        $appName = trim(fgets(STDIN));
        if (!empty($appName)) {
            $content .= "'name' => '$appName',";
            continue;
        }
        printError("Name must not be empty");
    }
}
$content .= "];";

$file = fopen($appSeting, 'w');
if (!fwrite($file, $content)) {
    printError("Error saving");
    fclose($file);
    exit(2);
}
fclose($file);