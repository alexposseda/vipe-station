<?php
    function arrayToString($arr){
        $str = '[';
        foreach($arr as $key => $value){
            $str .= "'".$key."' => ";
            if(is_array($value)){
                $str .= arrayToString($value);
            }else{
                $str .= (is_numeric($value)) ? $value.',' : "'".$value."',";
            }
        }
        $str .= '],';

        return $str;
    }

    function addDataToParams($key, $value){
        $params = include ROOT_DIR.'/common/config/params-local.php';
        $params[$key] = $value;

        $file = fopen(ROOT_DIR.'/common/config/params-local.php', 'w');
        $content = "<?php \n\treturn ".substr(arrayToString($params), 0, -1).';';
        if(!fwrite($file, $content)){
            printError("Error saving");
            fclose($file);
            exit(2);
        }
        fclose($file);

        echo formatMessage("\n Param  ".$key." was added!", ['fg-green', 'bold']);
    }

    function getCustomSetting(){
        return include CUSTOM_SETTING;
    }

    function setCustomSetting($settingName){
        global $customSetting;
        $file = fopen(CUSTOM_SETTING, 'w');
        $content = "<?php \n\treturn ".substr(arrayToString($customSetting), 0, -1).';';
        if(!fwrite($file, $content)){
            printError("Error saving");
            fclose($file);
            exit(2);
        }
        fclose($file);

        echo formatMessage("\n Setting for ".$settingName." was successful saved!", ['fg-green', 'bold']);
    }

    function showInputSetting($data, $settingName){
        echo "\n Your setting for ".formatMessage($settingName, [
                'fg-yellow',
                'bold'
            ]).": \n ";
        foreach($data as $key => $value){
            echo formatMessage($key, ['fg-green']).' => '.$value."\n ";
        }

        echo formatMessage("\n Do you confirm these settings?", ['fg-blue'])." [yes|no]: ";
        $answer = trim(fgets(STDIN));
        if(strncasecmp($answer, 'y', 1)){
            return false;
        }

        return true;
    }

    function checkDbSetting($data){
        echo "\n Trying to connect to DB.....";
        try{
            $db = @new PDO($data['dsn'], $data['username'], $data['password']);
            echo "\n Connection established!\n";

            return true;
        }catch(PDOException $e){
            printError('Connection failed!');
            printError($e->getMessage());

            return false;
        }
    }

    function checkEmailSetting($data, $sender){
        echo " Enter target Email: ";
        $targetEmail = trim(fgets(STDIN));
        if(empty($targetEmail)){
            $targetEmail = $sender;
        }
        require_once ROOT_DIR.'/vendor/swiftmailer/swiftmailer/lib/swift_required.php';

        $transport = Swift_SmtpTransport::newInstance($data['host'], $data['port']);
        $transport->setUsername($data['username'])
                  ->setPassword($data['password'])
                  ->setEncryption($data['encryption']);

        $mailer = Swift_Mailer::newInstance($transport);

        $message = Swift_Message::newInstance('trying sent email')
                                ->setFrom([$sender => substr($data['username'], 0, strpos($data['username'], '@'))])
                                ->setTo($targetEmail)
                                ->setBody('this is a test email!');

        try{
            $mailer->send($message);
            return true;
        }catch(\Exception $e){
            printError($e->getMessage());
            return false;
        }
    }

    function setAppName(&$setting){
        echo formatMessage("\n Change application Name?", ['fg-blue'])." [yes|no]: ";
        $answer = trim(fgets(STDIN));
        if(strncasecmp($answer, 'y', 1)){
            return false;
        }
        echo "\n Enter Application Name: ";
        $appName = trim(fgets(STDIN));
        if(!empty($appName)){
            $setting['name'] = $appName;
            setCustomSetting('AppName');
        }
    }

    function setDbSetting(&$setting){
        echo formatMessage("\n Set custom DB config?", ['fg-blue'])." [yes|no]: ";
        $answer = trim(fgets(STDIN));
        if(strncasecmp($answer, 'y', 1)){
            return false;
        }
        $data = [];
        echo " Enter ".formatMessage('DB HOST', [
                'fg-yellow',
                'bold'
            ]).": ";
        $host = trim(fgets(STDIN));
        echo " Enter ".formatMessage('DB USER', [
                'fg-yellow',
                'bold'
            ]).": ";
        $data['username'] = trim(fgets(STDIN));
        echo " Enter ".formatMessage('DB PASSWORD', [
                'fg-yellow',
                'bold'
            ]).": ";
        $data['password'] = trim(fgets(STDIN));
        echo " Enter ".formatMessage('DB NAME', [
                'fg-yellow',
                'bold'
            ]).": ";
        $db_name = trim(fgets(STDIN));
        echo " Enter ".formatMessage('TABLE PREFIX', [
                'fg-yellow',
                'bold'
            ]).": ";
        $data['tablePrefix'] = trim(fgets(STDIN));
        if(!empty($host) and !empty($db_name)){
            $data['dsn'] = 'mysql:host='.$host.'; dbname='.$db_name;
        }

        foreach($data as $key => $value){
            if(!empty($value)){
                $setting['components']['db'][$key] = $value;
            }
        }

        if(showInputSetting($data, 'DataBase') and checkDbSetting($data)){
            setCustomSetting('DataBase');
        }else{
            setDbSetting($setting);
        }
    }

    function setEmailSetting(&$setting){
        echo formatMessage("\n Set custom Email config?", ['fg-blue'])." [yes|no]: ";
        $answer = trim(fgets(STDIN));
        if(strncasecmp($answer, 'y', 1)){
            return false;
        }
        echo "\n Enter robot Email: ";
        $robotEmail = trim(fgets(STDIN));
        if(!empty($robotEmail)){
            addDataToParams('robotEmail', $robotEmail);
        }

        echo formatMessage("\n Use file transport?", ['fg-blue'])." [yes|no]: ";
        $answer = trim(fgets(STDIN));
        if(strncasecmp($answer, 'n', 1)){
            return false;
        }
        $setting['components']['mailer']['useFileTransport'] = 0;
        $data = [];
        echo " Enter ".formatMessage('HOST', [
                'fg-yellow',
                'bold'
            ]).": ";
        $data['host'] = trim(fgets(STDIN));
        echo " Enter ".formatMessage('USER', [
                'fg-yellow',
                'bold'
            ]).": ";
        $data['username'] = trim(fgets(STDIN));
        echo " Enter ".formatMessage('PASSWORD', [
                'fg-yellow',
                'bold'
            ]).": ";
        $data['password'] = trim(fgets(STDIN));
        echo " Enter ".formatMessage('PORT', [
                'fg-yellow',
                'bold'
            ]).": ";
        $data['port'] = trim(fgets(STDIN));
        echo " Enter ".formatMessage('ENCRYPTION', [
                'fg-yellow',
                'bold'
            ]).": ";
        $data['encryption'] = trim(fgets(STDIN));

        foreach($data as $key => $value){
            if(!empty($value)){
                $setting['components']['mailer']['transport'][$key] = $value;
            }
        }

        if(showInputSetting($data, 'Email') and checkEmailSetting($data, $robotEmail)){
            setCustomSetting('Email');
        }else{
            setEmailSetting($setting);
        }
    }

    $customSetting = getCustomSetting();
