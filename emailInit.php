<?php

echo "\n Enter robot email: default(robotogrsol@gmail.com) ";
$robotEmail = trim(fgets(STDIN));
if(empty($robotEmail)){
    $robotEmail = 'robotogrsol@gmail.com';
}
