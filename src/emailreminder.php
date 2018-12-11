<?php
/**
 * Created by PhpStorm.
 * User: workstation
 * Date: 23.03.17
 * Time: 11:15
 */
include "config/config.php";
include "vendor/autoload.php";

$db = new PDO( 'mysql:host=' . __HOST__ . ';dbname=' . __DB__ . '', __USER__, __PASS__,
    array(
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_WARNING,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    )
);


$SQL = "SELECT * FROM msonair_users WHERE user_status = 2 AND user_skill = 2";
$stmt = $db->prepare($SQL);
$stmt->execute();

$res = $stmt->fetchAll(PDO::FETCH_ASSOC);



foreach ($res as $k => $user) :

    $mail = new \PHPMailer\PHPMailer\PHPMailer();

    $mail->CharSet = "UTF-8";

    $mail->setFrom('info@musiclessonsonair.de', 'Musiclessons On Air');
    $mail->addAddress($user["user_email"]);                      // Name is optional
    //$mail->addBCC('info@musiclessonsonair.de');

    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = 'Bitte trage neue Termine ein';
    $mail->Body = " Hallo {$user["user_firstname"]}<br/><br/>
                    bitte denke daran, neue verfügbare Termine bei Musiclessons On Air einzutragen.
                    <br/>
                    <br/>
                    Herzliche Grüße<br />
                    das System von Musiclessons On Air";

    if (!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }else{
        echo $mail->Body;
        echo "<br /><br /> Mail an {$user["user_firstname"]} wurde versandt <br />";
    }

endforeach;
