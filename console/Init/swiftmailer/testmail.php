<?php
    require_once 'lib/swift_required.php';

    $transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
                                    ->setUsername('robotogrsol')
                                    ->setPassword('987123654');
    $mailer = Swift_Mailer::newInstance($transport);

    $message = Swift_Message::newInstance('Wonderful Subject')
                            ->setFrom(array('robot@test.name' => 'robot'))
                            ->setTo(array('alexposseda@gmail.com'))
                            ->setBody('Here is the message itself');
    $result = $mailer->send($message);

    echo $result;