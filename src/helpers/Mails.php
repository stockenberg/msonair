<?php
/**
 * Created by PhpStorm.
 * User: mstoc
 * Date: 03.10.2016
 * Time: 16:00
 */

namespace src\helpers;


use src\core\User;
use src\helpers\Helper;
use PHPMailer\PHPMailer\PHPMailer;
use src\model\Coupon;

class Mails extends Helper
{

    public static $gender = ["male" => "Lieber", "female" => "Liebe"];


    public static function forgotPassword($data)
    {
        $mail = new PHPMailer;
        $mail->CharSet = "UTF-8";

        $mail->setFrom('info@musiclessonsonair.de', 'Musiclessons On Air');
        $mail->addAddress($data["user_email"]);                      // Name is optional
        //$mail->addBCC('info@musiclessonsonair.de');

        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->IsSMTP();
        $mail->Host = SSL_HOST;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Username = SSL_USERNAME;
        $mail->Password = SSL_PASS;
        $mail->Port = SSL_PORT;                                  // Set email format to HTML


        $mail->Subject = 'Setze dein Passwort zurück.';
        $mail->Body = '' . self::$gender[$data["user_gender"]] . ' ' . $data["user_firstname"] . ',<br /><br />
        Du hast einen Link angefordert, um dein Passwort zurückzusetzen..
           <br /><br />
        Bitte lege über folgenden Link dein neues Passwort fest: <a href="' . __SCRIPT__ . '?p=firstlogin&token=' . $data["user_password"] . '">Passwort festlegen</a>
        <br /><br />
        Wenn du dein Passwort zurück gesetzt hast, kannst du dich wie gewohnt einloggen.<br /><br />
        
        Herzliche Grüße<br />
        Dein Team von Musiclessons On Air 
        ';

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }

    public static function sendContact($data)
    {
        $mail = new PHPMailer;
        $mail->CharSet = "UTF-8";

        $mail->setFrom($data["contactMail"]);
        $mail->addAddress($data["info@musiclessonsonair.de"]);                      // Name is optional

        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->IsSMTP();
        $mail->Host = SSL_HOST;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Username = SSL_USERNAME;
        $mail->Password = SSL_PASS;
        $mail->Port = SSL_PORT;                                  // Set email format to HTML

        $mail->Subject = 'Nachricht aus dem Kontaktformular - Musiclessons On Air';
        $mail->Body = $data["contactMessage"];
        $mail->AltBody = $data["contactMessage"];

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }

    public static function couponPayed(\src\objects\Coupon $coupon, $pdf, $pdf_name, $coupon_pdf, $coupon_pdf_name)
    {
        $mail = new PHPMailer;
        $mail->CharSet = "UTF-8";

        $mail->setFrom('info@musiclessonsonair.de', 'Musiclessons On Air');
        $mail->addAddress($coupon->email);                      // Name is optional
        $mail->addAddress('info@musiclessonsonair.de');

        if ($pdf !== null) {
            $mail->addAttachment($pdf, $pdf_name);    // Optional name
        }
        $mail->addAttachment($coupon_pdf, $coupon_pdf_name);    // Optional name
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->IsSMTP();
        $mail->Host = SSL_HOST;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Username = SSL_USERNAME;
        $mail->Password = SSL_PASS;
        $mail->Port = SSL_PORT;                                  // Set email format to HTML

        $mail->Subject = 'Gutschein';
        $mail->Body = '
        ' . self::$gender[$coupon->gender] . ' ' . $coupon->firstname . ', <br /><br />
deine Zahlung wurde auf unserem Konto verbucht. Vielen Dank!
<br /><br />
Im Anhang findest du den Gutschein von Musiclessons On Air als PDF-Dokument. Um ihn einzulösen, 
registriere dich bitte auf <a href="https://www.musiclessonsonair.de">www.musiclessonsonair.de</a>. 
Anschließend kannst du auf "Gutscheincode einlösen" klicken und den Code aus dem PDF-Dokument eingeben.
<br /><br />
Solltest du Fragen haben, zögere nicht, uns eine E-Mail an info@musiclessonsonair.de zu senden.
In unseren <a href="https://' . __SERVERNAME__ . __BASE__ . '?p=faq">FAQ</a> findest du außerdem Antworten auf einige häufig gestellte Fragen.
<br /><br />
Melde dich auch bei unserem Newsletter an, um keine Sonderangebote und Neuigkeiten rund
um die Musiclessons On Air zu verpassen. <a href="www.musiclessonsonair.de/news">www.musiclessonsonair.de/news</a>
<br /><br />
Herzliche Grüße<br />
Dein Team von Musiclessons On Air

        ';
        $mail->AltBody = ' ' . self::$gender[$coupon->gender] . ' ' . $coupon->firstname . ', 
deine Zahlung wurde auf unserem Konto verbucht. Vielen Dank!

Im Anhang findest du den Gutschein von Musiclessons On Air als PDF-Dokument. Um ihn einzulösen, registriere dich bitte auf www.musiclessonsonair.de. Anschließend kannst du auf "Gutscheincode einlösen" klicken und den Code aus dem PDF-Dokument eingeben.

Solltest du Fragen haben, zögere nicht, uns eine E-Mail an info@musiclessonsonair.de zu senden.
In unseren FAQ findest du außerdem Antworten auf einige häufig gestellte Fragen.

Melde dich auch bei unserem Newsletter an, um keine Sonderangebote und Neuigkeiten rund
um die Musiclessons On Air zu verpassen. <a href="www.musiclessonsonair.de/news">www.musiclessonsonair.de/news</a>

Herzliche Grüße
Dein Team von Musiclessons On Air  
        ';

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }

    public static function PaymentRecievedMailCoupon(User $data)
    {

        $mail = new PHPMailer;
        $mail->CharSet = "UTF-8";

        $mail->setFrom('info@musiclessonsonair.de', 'Musiclessons On Air');
        $mail->addAddress($data->getEmail());                      // Name is optional
        //$mail->addBCC('info@musiclessonsonair.de');

        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->IsSMTP();
        $mail->Host = SSL_HOST;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Username = SSL_USERNAME;
        $mail->Password = SSL_PASS;
        $mail->Port = SSL_PORT;                                  // Set email format to HTML

        $mail->Subject = 'Dein Gutschein wurde eingelöst.';
        $mail->Body = '' . self::$gender[$data->getGender()] . ' ' . $data->getFirstname() . ',<br /><br />
        Dein Coupon wurde erfolgreich eingelöst. Vielen Dank!
           <br /><br />
        Nun kann es losgehen.<br />
        Dein Benutzername ist: ' . $data->getUsername() . ' <br />
        Bitte lege über diesen Link dein Passwort fest: <a href="' . __SCRIPT__ . '?p=firstlogin&token=' . $data->getPassword() . '">Passwort festlegen</a>
        <br /><br />
        In deinem Login-Bereich werden dir im Kalender die verfügbaren Zeiten deines Dozenten angezeigt. Dort kannst du den, für dich passenden, Termin
        auswählen. Im Anschluss daran erhältst du eine E-Mail mit der Terminbestätigung.
        <br /><br />
        Im Login-Bereich findest du unter „Unterrichtsraum“ den Link zur Unterrichtsstunde. Diesen
        wählst du einfach zum Zeitpunkt des Unterrichts aus, klickst auf „Unterricht starten“ und es wird
        automatisch eine Verbindung zu deinem Dozenten aufgebaut.
        <br /><br />
        Bitte beachte, dass die von uns verwendete Software nur unter den Browsern Mozilla Firefox,
        Google Chrome und Opera funktioniert. Unter <a href="https://' . __SERVERNAME__ . __BASE__ . '?p=technik">Musiclessonsonair - Technik</a> findest du eine
        detaillierte Installationsanleitung für die Browser und viele weitere Informationen.
        <br /><br />
        Solltest du Fragen haben, zögere nicht, uns eine E-Mail an info@musiclessonsonair.de zu senden.
        In unseren <a href="https://' . __SERVERNAME__ . __BASE__ . '?p=faq">FAQ</a> findest du außerdem Antworten auf einige häufig gestellte Fragen.
        <br /><br />
        Herzliche Grüße<br />
        Dein Team von Musiclessons On Air 
        ';
        $mail->AltBody = '' . self::$gender[$data->getGender()] . '  ' . $data->getFirstname() . ',
                    deine Zahlung wurde auf unserem Konto verbucht. Vielen Dank!

                    Nun kann es losgehen.
                    Dein Benutzername ist: ' . $data->getUsername() . '
                    Bitte lege über diesen Link dein Passwort fest: ' . __SCRIPT__ . '?p=firstlogin&token=' . $data->getPassword() . '
                    
                    In deinem Login-Bereich kannst du im Kalender zunächst einen Dozenten auswählen. Dann werden
                    dir die verfügbaren Zeiten des Dozenten angezeigt. Dort kannst du den für dich passenden Termin
                    auswählen. Im Anschluss daran erhältst du eine E-Mail mit der Terminbestätigung.
                    
                    Im Login-Bereich findest du unter „Unterrichtsraum“ den Link zur Unterrichtsstunde. Diesen
                    wählst du einfach zum Zeitpunkt des Unterrichts aus, klickst auf „Unterricht starten“ und es wird
                    automatisch eine Verbindung zu deinem Dozenten aufgebaut.
                    
                    Bitte beachte, dass die von uns verwendete Software nur unter den Browsern Mozilla Firefox,
                    Google Chrome und Opera funktioniert. Unter www.musiclessonsonair.de/public/?p=technik findest du eine
                    detaillierte Installationsanleitung für die Browser und viele weitere Informationen.
                    
                    Solltest du Fragen haben, zögere nicht, uns eine E-Mail an info@musiclessonsonair.de zu senden.
                    In unseren FAQ findest du außerdem Antworten auf einige häufig gestellte Fragen.
                    
                    Herzliche Grüße
                    Dein Team von Musiclessons On Air     
        ';

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }

    public static function PaymentRecievedMailPP($data, $pdf, $pdf_name)
    {

        $mail = new PHPMailer;
        $mail->CharSet = "UTF-8";

        $mail->setFrom('info@musiclessonsonair.de', 'Musiclessons On Air');
        $mail->addAddress($data["email"]);                      // Name is optional
        //$mail->addBCC('info@musiclessonsonair.de');

        $mail->addAttachment($pdf, $pdf_name);    // Optional name
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->IsSMTP();
        $mail->Host = SSL_HOST;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Username = SSL_USERNAME;
        $mail->Password = SSL_PASS;
        $mail->Port = SSL_PORT;                                  // Set email format to HTML

        $mail->Subject = 'Deine Zahlung ist eingegangen';
        $mail->Body = '' . self::$gender[$data["gender"]] . ' ' . $data["firstname"] . ',
        deine Zahlung wurde auf unserem Konto verbucht. Vielen Dank!
           <br /><br />
        Nun kann es losgehen.<br />
        Dein Benutzername ist: ' . $data["username"] . ' <br />
        Bitte lege über diesen Link dein Passwort fest: <a href="' . __SCRIPT__ . '?p=firstlogin&token=' . $data["token"] . '">Passwort festlegen</a>
        <br /><br />
        In deinem Login-Bereich kannst du im Kalender zunächst einen Dozenten auswählen. Dann werden
        dir die verfügbaren Zeiten des Dozenten angezeigt. Dort kannst du den für dich passenden Termin
        auswählen. Im Anschluss daran erhältst du eine E-Mail mit der Terminbestätigung.
        <br /><br />
        Im Login-Bereich findest du unter „Unterrichtsraum“ den Link zur Unterrichtsstunde. Diesen
        wählst du einfach zum Zeitpunkt des Unterrichts aus, klickst auf „Unterricht starten“ und es wird
        automatisch eine Verbindung zu deinem Dozenten aufgebaut.
        <br /><br />
        Bitte beachte, dass die von uns verwendete Software nur unter den Browsern Mozilla Firefox,
        Google Chrome und Opera funktioniert. Unter <a href="https://' . __SERVERNAME__ . __BASE__ . '?p=technik">Musiclessonsonair - Technik</a> findest du eine
        detaillierte Installationsanleitung für die Browser und viele weitere Informationen.
        <br /><br />
        Solltest du Fragen haben, zögere nicht, uns eine E-Mail an info@musiclessonsonair.de zu senden.
        In unseren <a href="https://' . __SERVERNAME__ . __BASE__ . '?p=faq">FAQ</a> findest du außerdem Antworten auf einige häufig gestellte Fragen.
        <br /><br />
        Herzliche Grüße<br />
        Dein Team von Musiclessons On Air 
        ';
        $mail->AltBody = '' . self::$gender[$data["gender"]] . '  ' . $data["firstname"] . ',
                    deine Zahlung wurde auf unserem Konto verbucht. Vielen Dank!

                    Nun kann es losgehen.
                    Dein Benutzername ist: ' . $data["username"] . '
                    Bitte lege über diesen Link dein Passwort fest: ' . __SCRIPT__ . '?p=firstlogin&token=' . $data["token"] . '
                    
                    In deinem Login-Bereich kannst du im Kalender zunächst einen Dozenten auswählen. Dann werden
                    dir die verfügbaren Zeiten des Dozenten angezeigt. Dort kannst du den für dich passenden Termin
                    auswählen. Im Anschluss daran erhältst du eine E-Mail mit der Terminbestätigung.
                    
                    Im Login-Bereich findest du unter „Unterrichtsraum“ den Link zur Unterrichtsstunde. Diesen
                    wählst du einfach zum Zeitpunkt des Unterrichts aus, klickst auf „Unterricht starten“ und es wird
                    automatisch eine Verbindung zu deinem Dozenten aufgebaut.
                    
                    Bitte beachte, dass die von uns verwendete Software nur unter den Browsern Mozilla Firefox,
                    Google Chrome und Opera funktioniert. Unter <a href="https://' . __SERVERNAME__ . __BASE__ . '?p=technik">Musiclessonsonair - Technik</a> findest du eine
                    detaillierte Installationsanleitung für die Browser und viele weitere Informationen.
                    
                    Solltest du Fragen haben, zögere nicht, uns eine E-Mail an info@musiclessonsonair.de zu senden.
                    In unseren FAQ findest du außerdem Antworten auf einige häufig gestellte Fragen.
                    
                    Herzliche Grüße
                    Dein Team von Musiclessons On Air     
        ';

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }

    /**
     * @param User $data
     * @param $pdf
     * @param $pdf_name
     */
    public static function upgraded(User $data, $pdf, $pdf_name)
    {
        $mail = new PHPMailer;
        $mail->CharSet = "UTF-8";

        $mail->setFrom('info@musiclessonsonair.de', 'Musiclessons On Air');
        $mail->addAddress($data->getEmail());                      // Name is optional
        //$mail->addBCC('info@musiclessonsonair.de');

        $mail->addAttachment($pdf, $pdf_name);    // Optional name
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->IsSMTP();
        $mail->Host = SSL_HOST;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Username = SSL_USERNAME;
        $mail->Password = SSL_PASS;
        $mail->Port = SSL_PORT;                                  // Set email format to HTML

        $mail->Subject = 'Weitere Stunden erfolgreich freigeschalten.';
        $mail->Body = '' . self::$gender[$data->getGender()] . ' ' . $data->getFirstname() . ',
        deine Zahlung wurde auf unserem Konto verbucht. Vielen Dank!
        <br /><br />
        Du hast jetzt Zugriff auf die von dir gebuchten Liveunterrichte.
        <br /><br />
        Bitte beachte, dass die von uns verwendete Software nur unter den Browsern Mozilla Firefox,
        Google Chrome und Opera funktioniert. Unter <a href="https://' . __SERVERNAME__ . __BASE__ . '?p=technik">Musiclessonsonair - Technik</a> findest du eine
        detaillierte Installationsanleitung für die Browser und viele weitere Informationen.
        <br /><br />
        Solltest du Fragen haben, zögere nicht, uns eine E-Mail an info@musiclessonsonair.de zu senden.
        In unseren <a href="https://' . __SERVERNAME__ . __BASE__ . '?p=faq">FAQ</a> findest du außerdem Antworten auf einige häufig gestellte Fragen.
        <br /><br />
        Herzliche Grüße<br />
        Dein Team von Musiclessons On Air 
        ';
        $mail->AltBody = '' . self::$gender[$data->getGender()] . ' ' . $data->getFirstname() . ',
                    deine Zahlung wurde auf unserem Konto verbucht. Vielen Dank!

                    Du hast jetzt Zugriff auf die von dir gebuchten Liveunterrichte.
                    
                    Bitte beachte, dass die von uns verwendete Software nur unter den Browsern Mozilla Firefox,
                    Google Chrome und Opera funktioniert. Unter <a href="https://' . __SERVERNAME__ . __BASE__ . '?p=technik">Musiclessonsonair - Technik</a> findest du eine
                    detaillierte Installationsanleitung für die Browser und viele weitere Informationen.
                    
                    Solltest du Fragen haben, zögere nicht, uns eine E-Mail an info@musiclessonsonair.de zu senden.
                    In unseren FAQ findest du außerdem Antworten auf einige häufig gestellte Fragen.
                    
                    Herzliche Grüße
                    Dein Team von Musiclessons On Air     
        ';

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }

    /**
     * @param User $data
     * @param $pdf
     * @param $pdf_name
     */
    public static function upgradeNeedsConfirmation(User $data, $pdf, $pdf_name)
    {
        $mail = new PHPMailer;
        $mail->CharSet = "UTF-8";

        $mail->setFrom('info@musiclessonsonair.de', 'Musiclessons On Air');
        $mail->addAddress($data->getEmail());                      // Name is optional
        //$mail->addBCC('info@musiclessonsonair.de');

        $mail->addAttachment($pdf, $pdf_name);    // Optional name
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->IsSMTP();
        $mail->Host = SSL_HOST;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Username = SSL_USERNAME;
        $mail->Password = SSL_PASS;
        $mail->Port = SSL_PORT;                                  // Set email format to HTML

        $mail->Subject = 'Zahlungseingang wird überprüft.';
        $mail->Body = '' . self::$gender[$data->getGender()] . ' ' . $data->getFirstname() . ',<br /><br />
        Deine Bestellung ist eingegangen und wird geprüft. <br />
        Sobald deine Zahlung eingegangen ist, wird dein gebuchtes Kontingent freigeschaltet.
        <br /><br />
        Bitte beachte, dass die von uns verwendete Software nur unter den Browsern Mozilla Firefox,
        Google Chrome und Opera funktioniert. Unter <a href="https://' . __SERVERNAME__ . __BASE__ . '?p=technik">Musiclessonsonair - Technik</a> findest du eine
        detaillierte Installationsanleitung für die Browser und viele weitere Informationen.
        <br /><br />
        Solltest du Fragen haben, zögere nicht, uns eine E-Mail an info@musiclessonsonair.de zu senden.
        In unseren <a href="https://' . __SERVERNAME__ . __BASE__ . '?p=faq">FAQ</a> findest du außerdem Antworten auf einige häufig gestellte Fragen.
        <br /><br />
        Herzliche Grüße<br />
        Dein Team von Musiclessons On Air 
        ';
        $mail->AltBody = '' . self::$gender[$data->getGender()] . ' ' . $data->getFirstname() . ',
                     Deine Bestellung ist eingegangen und wird geprüft. 
                     Sobald deine Zahlung eingegangen ist, wird dein gebuchtes Kontingent freigeschaltet.
                    
                    Bitte beachte, dass die von uns verwendete Software nur unter den Browsern Mozilla Firefox,
                    Google Chrome und Opera funktioniert. Unter <a href="https://' . __SERVERNAME__ . __BASE__ . '?p=technik">Musiclessonsonair - Technik</a> findest du eine
                    detaillierte Installationsanleitung für die Browser und viele weitere Informationen.
                    
                    Solltest du Fragen haben, zögere nicht, uns eine E-Mail an info@musiclessonsonair.de zu senden.
                    In unseren FAQ findest du außerdem Antworten auf einige häufig gestellte Fragen.
                    
                    Herzliche Grüße
                    Dein Team von Musiclessons On Air     
        ';

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
        self::newPrepaidInc($data);
    }


    public static function PaymentRecievedMail($data, $pdf, $pdf_name)
    {

        $mail = new PHPMailer;
        $mail->CharSet = "UTF-8";

        $mail->setFrom('info@musiclessonsonair.de', 'Musiclessons On Air');
        $mail->addAddress($data["email"]);                      // Name is optional
        //$mail->addBCC('info@musiclessonsonair.de');

        $mail->addAttachment($pdf, $pdf_name);    // Optional name
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->IsSMTP();
        $mail->Host = SSL_HOST;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Username = SSL_USERNAME;
        $mail->Password = SSL_PASS;
        $mail->Port = SSL_PORT;                                  // Set email format to HTML

        $mail->Subject = 'Deine Zahlung ist eingegangen';
        $mail->Body = '' . self::$gender[$data["gender"]] . ' ' . $data["firstname"] . ',
        deine Zahlung wurde auf unserem Konto verbucht. Vielen Dank!
           <br /><br />
        Nun kann es losgehen.<br />
        In deinem Login-Bereich kannst du im Kalender zunächst einen Dozenten auswählen. Dann werden
        dir die verfügbaren Zeiten des Dozenten angezeigt. Dort kannst du den für dich passenden Termin
        auswählen. Im Anschluss daran erhältst du eine E-Mail mit der Terminbestätigung.
        <br /><br />
        Im Login-Bereich findest du unter „Unterrichtsraum“ den Link zur Unterrichtsstunde. Diesen
        wählst du einfach zum Zeitpunkt des Unterrichts aus, klickst auf „Unterricht starten“ und es wird
        automatisch eine Verbindung zu deinem Dozenten aufgebaut.
        <br /><br />
        Bitte beachte, dass die von uns verwendete Software nur unter den Browsern Mozilla Firefox,
        Google Chrome und Opera funktioniert. Unter <a href="https://' . __SERVERNAME__ . __BASE__ . '?p=technik">Musiclessonsonair - Technik</a> findest du eine
        detaillierte Installationsanleitung für die Browser und viele weitere Informationen.
        <br /><br />
        Solltest du Fragen haben, zögere nicht, uns eine E-Mail an info@musiclessonsonair.de zu senden.
        In unseren <a href="https://' . __SERVERNAME__ . __BASE__ . '?p=faq">FAQ</a> findest du außerdem Antworten auf einige häufig gestellte Fragen.
        <br /><br />
        Herzliche Grüße<br />
        Dein Team von Musiclessons On Air 
        ';
        $mail->AltBody = '' . self::$gender[$data["gender"]] . '  ' . $data["firstname"] . ',
                    deine Zahlung wurde auf unserem Konto verbucht. Vielen Dank!

                    Nun kann es losgehen.
                    
                    In deinem Login-Bereich kannst du im Kalender zunächst einen Dozenten auswählen. Dann werden
                    dir die verfügbaren Zeiten des Dozenten angezeigt. Dort kannst du den für dich passenden Termin
                    auswählen. Im Anschluss daran erhältst du eine E-Mail mit der Terminbestätigung.
                    
                    Im Login-Bereich findest du unter „Unterrichtsraum“ den Link zur Unterrichtsstunde. Diesen
                    wählst du einfach zum Zeitpunkt des Unterrichts aus, klickst auf „Unterricht starten“ und es wird
                    automatisch eine Verbindung zu deinem Dozenten aufgebaut.
                    
                    Bitte beachte, dass die von uns verwendete Software nur unter den Browsern Mozilla Firefox,
                    Google Chrome und Opera funktioniert. Unter <a href="https://' . __SERVERNAME__ . __BASE__ . '?p=technik">Musiclessonsonair - Technik</a> findest du eine
                    detaillierte Installationsanleitung für die Browser und viele weitere Informationen.
                    
                    Solltest du Fragen haben, zögere nicht, uns eine E-Mail an info@musiclessonsonair.de zu senden.
                    In unseren FAQ findest du außerdem Antworten auf einige häufig gestellte Fragen.
                    
                    Herzliche Grüße
                    Dein Team von Musiclessons On Air     
        ';

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }

	public static function notifyAdminNewLecturer($data)
	{

		$mail = new PHPMailer;
		$mail->CharSet = "UTF-8";

		$mail->setFrom('info@musiclessonsonair.de', 'Musiclessons On Air');
		$mail->addAddress('info@musiclessonsonair.de');                      // Name is optional

		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->IsSMTP();
		$mail->Host = SSL_HOST;
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = "ssl";
		$mail->Username = SSL_USERNAME;
		$mail->Password = SSL_PASS;
		$mail->Port = SSL_PORT;                                  // Set email format to HTML

		$mail->Subject = 'Dein Dozentenzugang zur Musiclessons On Air';
		$mail->Body = 'Hallo ' . $data["user_firstname"] . ',
        <br /><br />
        wir haben soeben einen Dozentenaccount für dich eingerichtet.
           <br /><br />
        Nun kann es losgehen.<br />
        Dein Benutzername ist: ' . $data["user_username"] . ' <br />
        Bitte lege über diesen Link dein Passwort fest: <a href="' . __SCRIPT__ . '?p=firstlogin&token=' . $data["token"] . '">Passwort festlegen</a>
        <br /><br />
        Herzliche Grüße<br />
        Dein Team von Musiclessons On Air 
        ';
		$mail->AltBody = 'Hallo ' . Helper::translateGender($data["user_gender"]) . ' ' . $data["user_firstname"] . ',
                        Wir haben soeben einen Dozentenaccount für dich eingerichtet.
    
                        Nun kann es losgehen.
                        Dein Benutzername ist: ' . $data["user_username"] . '
                        Bitte lege über dein Link dein Passwort fest: ' . __SCRIPT__ . '?p=firstlogin&token=' . $data["token"] . '
                        
                        Herzliche Grüße
                        Dein Team von Musiclessons On Air     
        ';

		if (!$mail->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		}
    }

    public static function newLecturer($data)
    {

        $mail = new PHPMailer;
        $mail->CharSet = "UTF-8";

        $mail->setFrom('info@musiclessonsonair.de', 'Musiclessons On Air');
        $mail->addAddress($data["user_email"]);                      // Name is optional
        $mail->addBCC('info@musiclessonsonair.de');

        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->IsSMTP();
        $mail->Host = SSL_HOST;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Username = SSL_USERNAME;
        $mail->Password = SSL_PASS;
        $mail->Port = SSL_PORT;                                  // Set email format to HTML

        $mail->Subject = 'Dein Dozentenzugang zur Musiclessons On Air';
        $mail->Body = 'Hallo ' . $data["user_firstname"] . ',
        <br /><br />
        wir haben soeben einen Dozentenaccount für dich eingerichtet.
           <br /><br />
        Nun kann es losgehen.<br />
        Dein Benutzername ist: ' . $data["user_username"] . ' <br />
        Bitte lege über diesen Link dein Passwort fest: <a href="' . __SCRIPT__ . '?p=firstlogin&token=' . $data["token"] . '">Passwort festlegen</a>
        <br /><br />
        Herzliche Grüße<br />
        Dein Team von Musiclessons On Air 
        ';
        $mail->AltBody = 'Hallo ' . Helper::translateGender($data["user_gender"]) . ' ' . $data["user_firstname"] . ',
                        Wir haben soeben einen Dozentenaccount für dich eingerichtet.
    
                        Nun kann es losgehen.
                        Dein Benutzername ist: ' . $data["user_username"] . '
                        Bitte lege über dein Link dein Passwort fest: ' . __SCRIPT__ . '?p=firstlogin&token=' . $data["token"] . '
                        
                        Herzliche Grüße
                        Dein Team von Musiclessons On Air     
        ';

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }

        self::notifyAdminNewLecturer($data);
    }

    public static function passwordChanged($data)
    {

        $mail = new PHPMailer;
        $mail->CharSet = "UTF-8";
        $mail->setFrom('info@musiclessonsonair.de', 'Musiclessons On Air');
        $mail->addAddress($data[0]["user_email"]);                      // Name is optional

        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->IsSMTP();
        $mail->Host = SSL_HOST;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Username = SSL_USERNAME;
        $mail->Password = SSL_PASS;
        $mail->Port = SSL_PORT;                                  // Set email format to HTML

        $mail->Subject = 'Dein Passwort wurde geändert';
        $mail->Body = '' . self::$gender[$data[0]["user_gender"]] . ' ' . $data[0]["user_firstname"] . ',<br /><br />
        du hast dein Passwort am ' . date("d.m.Y", time()) . ' um ' . date("H:i", time()) . ' Uhr erfolgreich geändert.
           <br /><br />
        Herzliche Grüße<br />
        Dein Team von Musiclessons On Air
        ';
        $mail->AltBody = '' . self::$gender[$data[0]["user_gender"]] . ' ' . $data[0]["user_firstname"] . ',
        
        du hast dein Passwort am ' . date("d.m.Y", time()) . ' um ' . date("H:i", time()) . ' Uhr erfolgreich geändert.   
        Herzliche Grüße
        Dein Team von Musiclessons On Air         ';

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }

    public static function paymentDone($data)
    {
        $mail = new PHPMailer;
        $mail->CharSet = "UTF-8";

        $mail->setFrom('info@musiclessonsonair.de', 'Musiclessons On Air');
        $mail->addAddress($data["user_email"]);                      // Name is optional
        $mail->addBCC('info@musiclessonsonair.de');

        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->IsSMTP();
        $mail->Host = SSL_HOST;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Username = SSL_USERNAME;
        $mail->Password = SSL_PASS;
        $mail->Port = SSL_PORT;                                  // Set email format to HTML

        $mail->Subject = 'Deine Zahlung ist eingegangen';
        $mail->Body = '' . self::$gender[$data["user_gender"]] . ' ' . $data["user_firstname"] . ',<br /><br />
        deine Zahlung wurde auf unserem Konto verbucht. Vielen Dank!
           <br />
        Nun kann es losgehen.<br />
        <br />
        In deinem Login-Bereich kannst du im Kalender zunächst einen Dozenten auswählen. Dann werden
        dir die verfügbaren Zeiten des Dozenten angezeigt. Dort kannst du den für dich passenden Termin
        auswählen. Im Anschluss daran erhältst du eine E-Mail mit der Terminbestätigung.
        <br /><br />
        Im Login-Bereich findest du unter „Unterrichtsraum“ den Link zur Unterrichtsstunde. Diesen
        Klicke einfach zum Zeitpunkt der Unterrichtsstunde an und es wird
        automatisch eine Verbindung zu deinem Dozenten aufgebaut.
        <br /><br />
        Bitte beachte, dass die von uns verwendete Software nur unter den Browsern Mozilla Firefox,
        Google Chrome und Opera funktioniert. Unter <a href="https://' . __SERVERNAME__ . __BASE__ . '?p=technik">Musiclessonsonair - Technik</a> findest du eine
        detaillierte Installationsanleitung für die Browser und viele weitere Informationen.
        <br /><br />
        Solltest du Fragen haben, zögere nicht, uns eine E-Mail an info@musiclessonsonair.de zu senden.
        In unseren <a href="https://' . __SERVERNAME__ . __BASE__ . '?p=faq">FAQ</a> findest du außerdem Antworten auf einige häufig gestellte Fragen.
        <br /><br />
        Herzliche Grüße<br />
        Dein Team von Musiclessons On Air 
        ';
        $mail->AltBody = '' . self::$gender[$data["user_gender"]] . ' ' . $data["user_firstname"] . ',
                    deine Zahlung wurde auf unserem Konto verbucht. Vielen Dank!

                    Nun kann es losgehen.
                    Dein Benutzername ist: ' . $data["user_username"] . '
                    Bitte lege über diesen Link dein Passwort fest: ' . __SCRIPT__ . '?p=firstlogin&token=' . $data["user_username"] . '
                    
                    In deinem Login-Bereich kannst du im Kalender zunächst einen Dozenten auswählen. Dann werden
                    dir die verfügbaren Zeiten des Dozenten angezeigt. Dort kannst du den für dich passenden Termin
                    auswählen. Im Anschluss daran erhältst du eine E-Mail mit der Terminbestätigung.
                    
                     Im Login-Bereich findest du unter „Unterrichtsraum“ den Link zur Unterrichtsstunde. Diesen
                    Klicke einfach zum Zeitpunkt der Unterrichtsstunde an und es wird
                    automatisch eine Verbindung zu deinem Dozenten aufgebaut.
                                
                    Bitte beachte, dass die von uns verwendete Software nur unter den Browsern Mozilla Firefox,
                    Google Chrome und Opera funktioniert. Unter <a href="https://' . __SERVERNAME__ . __BASE__ . '?p=technik">Musiclessonsonair - Technik</a> findest du eine
                    detaillierte Installationsanleitung für die Browser und viele weitere Informationen.
                    
                    Solltest du Fragen haben, zögere nicht, uns eine E-Mail an info@musiclessonsonair.de zu senden.
                    In unseren FAQ findest du außerdem Antworten auf einige häufig gestellte Fragen.
                    
                    Herzliche Grüße
                    Dein Team von Musiclessons On Air     
        ';
        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }

    public static function lessonIsUnsetTeacher($user, $event, $dozent)
    {
        $mail = new PHPMailer;
        $mail->CharSet = "UTF-8";

        $mail->setFrom('info@musiclessonsonair.de', 'Musiclessons On Air');
        $mail->addAddress($dozent["user_email"]);                      // Name is optional
        $mail->addBCC('info@musiclessonsonair.de');

        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->IsSMTP();
        $mail->Host = SSL_HOST;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Username = SSL_USERNAME;
        $mail->Password = SSL_PASS;
        $mail->Port = SSL_PORT;                                  // Set email format to HTML

        $mail->Subject = 'Dein Unterrichtstermin wurde rückgängig gemacht';
        $mail->Body = 'Hallo ' . $dozent["user_firstname"] . ',
                    <br /><br />
                    ' . $user["user_firstname"] . ' ' . $user["user_lastname"] . ' hat die Unterrichtsbuchung bei dir am ' . date("d.m.Y",
                strtotime($event["calendar_event_start"])) . ' um ' . date("H:i",
                strtotime($event["calendar_event_start"])) . ' rückgängig gemacht.
                    <br /><br />
                    In deinem persönlichen Login-Bereich findest du unter „Unterrichtsraum“ eine Übersicht über die anstehenden Unterrichtsstunden.
                    <br /><br />
                    Herzliche Grüße<br />
                    Dein Team von Musiclessons On Air ';

        $mail->AltBody = 'Hallo ' . $dozent["user_firstname"] . ',
                   
                    ' . $user["user_firstname"] . ' ' . $user["user_lastname"] . ' hat die Unterrichtsbuchung bei dir am ' . date("d.m.Y",
                strtotime($event["calendar_event_start"])) . ' um ' . date("H:i",
                strtotime($event["calendar_event_start"])) . ' rückgängig gemacht.
                    
                    In deinem persönlichen Login-Bereich findest du unter „Unterrichtsraum“ eine Übersicht über die anstehenden Unterrichtsstunden.
                    
                    Herzliche Grüße
                    Dein Team von Musiclessons On Air ';

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }

    public static function lessonIsSetTeacher($user, $event, $dozent)
    {
        $mail = new PHPMailer;
        $mail->CharSet = "UTF-8";

        $mail->setFrom('info@musiclessonsonair.de', 'Musiclessons On Air');
        $mail->addAddress($dozent["user_email"]);                      // Name is optional
        $mail->addBCC('info@musiclessonsonair.de');

        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->IsSMTP();
        $mail->Host = SSL_HOST;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Username = SSL_USERNAME;
        $mail->Password = SSL_PASS;
        $mail->Port = SSL_PORT;                                  // Set email format to HTML

        $mail->Subject = 'Du wurdest gebucht.';
        $mail->Body = 'Hallo ' . $dozent["user_firstname"] . ',
                    <br /><br />
                    ' . $user["user_firstname"] . ' ' . $user["user_lastname"] . ' hat eine Stunde bei dir gebucht. Euer Unterricht findet am ' . date("d.m.Y",
                strtotime($event["calendar_event_start"])) . ' um ' . date("H:i",
                strtotime($event["calendar_event_start"])) . ' Uhr statt.
                    <br /><br />
                    In deinem persönlichen Login-Bereich findest du unter „Unterrichtsraum“ den Link zu eurem Unterrichtsraum. Klicke einfach den entsprechenden Link an. Anschließend wirst du automatisch mit dem Schüler verbunden, sobald er ebenfalls den Unterricht startet. 
                    <br /><br />
                   Über den gleichen Link kannst du auch vorab bereits testen, ob deine Kamera von der Software erkannt wird. Hierzu erlaube bitte der Software bei entsprechenden Abfrage den Zugriff auf Kamera und Mikrofon. Wenn du dich anschließend selbst auf dem Bildschirm über deine Kamera sehen kannst, funktioniert die Technik und dem Unterricht bei Musiclessons On Air steht nichts mehr im Weg. 
                    <br /><br />
                    Herzliche Grüße<br />
                    Dein Team von Musiclessons On Air ';

        $mail->AltBody = 'Hallo ' . $dozent["user_firstname"] . ',
                    
                    bald geht es los.
                    Dein Unterricht mit ' . $user["user_firstname"] . ' ' . $user["user_lastname"] . ' findet am ' . date("d.m.Y",
                strtotime($event["calendar_event_start"])) . ' um ' . date("H:i",
                strtotime($event["calendar_event_start"])) . ' Uhr statt.
                    
                    In deinem persönlichen Login-Bereich findest du unter „Unterrichtsraum“ den Link zu deiner
                    Unterrichtsstunde. Klicke einfach den entsprechenden Link an.
                    Anschließend wirst du automatisch mit deinem Dozenten verbunden, sobald er ebenfalls
                    den Unterricht startet.
                    
                    Über den gleichen Link kannst du auch vorab bereits testen, ob deine Kamera von der Software
                    erkannt wird. Hierzu erlaube bitte der Software bei entsprechenden Abfrage den Zugriff auf
                    Kamera und Mikrofon. Wenn du dich anschließend selbst auf dem Bildschirm über deine Kamera
                    sehen kannst, funktioniert die Technik und deinem Unterricht bei Musiclessons On Air steht nichts
                    mehr im Weg.
                    
                    Solltest du Fragen haben, zögere nicht, uns eine E-Mail an info@musiclessonsonair.de zu senden.
                    In unseren FAQ findest du außerdem Antworten auf einige häufig gestellte Fragen.
                    
                    Herzliche Grüße
                    Dein Team der Musiclessons On Air
        ';

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }

    public static function lessonsEmpty(User $user)
    {
        $mail = new PHPMailer;
        $mail->CharSet = "UTF-8";

        $mail->setFrom('info@musiclessonsonair.de', 'Musiclessons On Air');
        $mail->addAddress($user->getEmail());                      // Name is optional

        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->IsSMTP();
        $mail->Host = SSL_HOST;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Username = SSL_USERNAME;
        $mail->Password = SSL_PASS;
        $mail->Port = SSL_PORT;                                  // Set email format to HTML

        $mail->Subject = 'Lernen Sie weiter';
        $mail->Body = '' . self::$gender[$user->getGender()] . ' ' . $user->getLastname() . ',
                    <br /><br />
                    leider ist dein gebuchtes Unterrichtskontingent nun erschöpft.
                    <br /><br />
                    Wir würden uns sehr freuen, wenn du auch weiterhin bei Musiclessons On Air Musikunterricht
                    nimmst. Unsere flexiblen und günstigen Angebote findest du unter
                    www.musiclessonsonair.de/pakete.
                    <br /><br />
                    Melde dich auch bei unserem Newsletter an, um keine Sonderangebote und Neuigkeiten rund
                    um die Musiclessons On Air zu verpassen. www.musiclessonsonair.de/news
                    <br /><br />
                    Wir hoffen, dir hat der Unterricht bei Musiclessons On Air gefallen.
                    Wir sind stets bemüht, uns noch weiter zu verbessern, und freuen uns über Lob, Kritik und
                    Anregungen von deiner Seite. Schicke uns gern jederzeit eine E-Mail mit deinem Feedback an
                    info@musiclessonsonair.de.
                    <br /><br />
                    Herzliche Grüße<br />
                    Dein Team von Musiclessons On Air';

        $mail->AltBody = '' . self::$gender[$user->getGender()] . ' ' . $user->getLastname() . ',
                   
                   leider ist dein gebuchtes Unterrichtskontingent nun erschöpft.
       
                    Wir würden uns sehr freuen, wenn du auch weiterhin bei Musiclessons On Air Musikunterricht
                    nehmen. Unsere flexiblen und günstigen Angebote findest du unter
                    www.musiclessonsonair.de/pakete.
     
                    Melde dich auch bei unserem Newsletter an, um keine Sonderangebote und Neuigkeiten rund
                    um die Musiclessons On Air zu verpassen. www.musiclessonsonair.de/news
              
                    Wir hoffen, dir hat der Unterricht bei Musiclessons On Air gefallen.
                    Wir sind stets bemüht, uns noch weiter zu verbessern, und freuen uns über Lob, Kritik und
                    Anregungen von deiner Seite. Schicke uns gern jederzeit eine E-Mail mit deinem Feedback an
                    info@musiclessonsonair.de.
          
                    Herzliche Grüße
                    Dein Team von Musiclessons On Air\';
        ';

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }


    public static function lessonIsSet($user, $event, $dozent)
    {
        $mail = new PHPMailer;
        $mail->CharSet = "UTF-8";

        $mail->setFrom('info@musiclessonsonair.de', 'Musiclessons On Air');
        $mail->addAddress($user["user_email"]);                      // Name is optional
        $mail->addBCC('info@musiclessonsonair.de');

        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->IsSMTP();
        $mail->Host = SSL_HOST;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Username = SSL_USERNAME;
        $mail->Password = SSL_PASS;
        $mail->Port = SSL_PORT;                                  // Set email format to HTML

        $mail->Subject = 'Dein Unterrichtstermin wurde vereinbart';
        $mail->Body = '' . self::$gender[$user["user_gender"]] . ' ' . $user["user_firstname"] . ',
                    <br /><br />
                    bald geht es los.
                    Dein Unterricht mit ' . $event["calendar_event_user_name"] . ' findet am ' . date("d.m.Y",
                strtotime($event["calendar_event_start"])) . ' um ' . date("H:i",
                strtotime($event["calendar_event_start"])) . ' Uhr statt.
                    <br /><br />
                    In deinem persönlichen Login-Bereich findest du unter „Unterrichtsraum“ den Link zu deiner
                    Unterrichtsstunde. Klicke einfach den entsprechenden Link an.
                    Anschließend wirst du automatisch mit deinem Dozenten verbunden, sobald er ebenfalls
                    den Unterricht startet.
                    <br /><br />
                    Über den gleichen Link kannst du auch vorab bereits testen, ob deine Kamera von der Software
                    erkannt wird. Hierzu erlaube bitte der Software bei entsprechenden Abfrage den Zugriff auf
                    Kamera und Mikrofon. Wenn du dich anschließend selbst auf dem Bildschirm über deine Kamera
                    sehen kannst, funktioniert die Technik und deinem Unterricht bei Musiclessons On Air steht nichts
                    mehr im Weg.
                    <br /><br />
                    Solltest du Fragen haben, zögere nicht, uns eine E-Mail an info@musiclessonsonair.de zu senden.
                    In unseren <a href="https://' . __SERVERNAME__ . __BASE__ . '?p=faq">FAQ</a> findest du außerdem Antworten auf einige häufig gestellte Fragen.
                    <br /><br />
                    Herzliche Grüße<br />
                    Dein Team von Musiclessons On Air ';

        $mail->AltBody = '' . self::$gender[$user["user_gender"]] . ' ' . $user["user_firstname"] . ',
                    
                    bald geht es los.
                    Dein Unterricht mit ' . $event["calendar_event_user_name"] . ' findet am ' . date("d.m.Y",
                strtotime($event["calendar_event_start"])) . ' um ' . date("H:i",
                strtotime($event["calendar_event_start"])) . ' Uhr statt.
                    
                    In deinem persönlichen Login-Bereich findest du unter „Unterrichtsraum“ den Link zu deiner
                    Unterrichtsstunde. Klicke einfach den entsprechenden Link an.
                    Anschließend wirst du automatisch mit deinem Dozenten verbunden, sobald er ebenfalls
                    den Unterricht startet.
                    
                    Über den gleichen Link kannst du auch vorab bereits testen, ob deine Kamera von der Software
                    erkannt wird. Hierzu erlaube bitte der Software bei entsprechenden Abfrage den Zugriff auf
                    Kamera und Mikrofon. Wenn du dich anschließend selbst auf dem Bildschirm über deine Kamera
                    sehen kannst, funktioniert die Technik und deinem Unterricht bei Musiclessons On Air steht nichts
                    mehr im Weg.
                    
                    Solltest du Fragen haben, zögere nicht, uns eine E-Mail an info@musiclessonsonair.de zu senden.
                    In unseren FAQ findest du außerdem Antworten auf einige häufig gestellte Fragen.
                    
                    Herzliche Grüße
                    Dein Team von Musiclessons On Air
        ';

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }

    public static function lessonIsUnset($user, $event, $dozent)
    {
        $mail = new PHPMailer;
        $mail->CharSet = "UTF-8";

        $mail->setFrom('info@musiclessonsonair.de', 'Musiclessons On Air');
        $mail->addAddress($user["user_email"]);                      // Name is optional
        $mail->addBCC('info@musiclessonsonair.de');

        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->IsSMTP();
        $mail->Host = SSL_HOST;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Username = SSL_USERNAME;
        $mail->Password = SSL_PASS;
        $mail->Port = SSL_PORT;                                  // Set email format to HTML

        $mail->Subject = 'Dein Unterrichtstermin wurde rückgängig gemacht';
        $mail->Body = '' . self::$gender[$user["user_gender"]] . ' ' . $user["user_firstname"] . ',
                    <br /><br />
                    du hast deine Terminauswahl bei ' . $event["calendar_event_user_name"] . ' am ' . date("d.m.Y",
                strtotime($event["calendar_event_start"])) . ' um ' . date("H:i",
                strtotime($event["calendar_event_start"])) . ' Uhr wieder gelöscht. 
                    <br /><br />
                    Einen neuen Termin kannst du jederzeit in deinem persönlichen Login-Bereich über den Kalender vereinbaren. Anschließend findest du unter „Unterrichtsraum“ den Link zur Unterrichtsstunde.

                    <br /><br />
                    Solltest du Fragen haben, zögere nicht, uns eine E-Mail an info@musiclessonsonair.de zu senden. In unseren FAQ findest du außerdem Antworten auf einige häufig gestellte Fragen. 

                    <br /><br />
                    Herzliche Grüße<br />
                    Dein Team von Musiclessons On Air ';

        $mail->AltBody = '' . self::$gender[$user["user_gender"]] . ' ' . $user["user_firstname"] . ',
                    
                    bald geht es los.
                    Dein Unterricht mit ' . $event["calendar_event_user_name"] . ' findet am ' . date("d.m.Y",
                strtotime($event["calendar_event_start"])) . ' um ' . date("H:i",
                strtotime($event["calendar_event_start"])) . ' Uhr statt.
                    
                    In deinem persönlichen Login-Bereich findest du unter „Unterrichtsraum“ den Link zu deiner
                    Unterrichtsstunde. Klicke einfach den entsprechenden Link an.
                    Anschließend wirst du automatisch mit deinem Dozenten verbunden, sobald er ebenfalls
                    den Unterricht startet.
                    
                    Über den gleichen Link kannst du auch vorab bereits testen, ob deine Kamera von der Software
                    erkannt wird. Hierzu erlaube bitte der Software bei entsprechenden Abfrage den Zugriff auf
                    Kamera und Mikrofon. Wenn du dich anschließend selbst auf dem Bildschirm über deine Kamera
                    sehen kannst, funktioniert die Technik und deinem Unterricht bei Musiclessons On Air steht nichts
                    mehr im Weg.
                    
                    Solltest du Fragen haben, zögere nicht, uns eine E-Mail an info@musiclessonsonair.de zu senden.
                    In unseren FAQ findest du außerdem Antworten auf einige häufig gestellte Fragen.
                    
                    Herzliche Grüße
                    Dein Team von Musiclessons On Air
        ';

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }

    public static function newPaypalInc(User $user)
    {
        $mail = new PHPMailer;
        $mail->CharSet = "UTF-8";

        $mail->setFrom('info@musiclessonsonair.de', 'MSONAIR Benachrichtigungssystem');
        $mail->addAddress("info@musiclessonsonair.de");                      // Name is optional

        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->IsSMTP();
        $mail->Host = SSL_HOST;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Username = SSL_USERNAME;
        $mail->Password = SSL_PASS;
        $mail->Port = SSL_PORT;                                  // Set email format to HTML

        $mail->Subject = 'Eine neue Paypal Zahlung bei Musiclessons On Air';
        $mail->Body = "Eine neue PaypalZahlung ist eingegangen. 
        <br /><br />
        Vorname: " . $user->getFirstname() . " <br />
        Nachname: " . $user->getLastname() . " <br />
        E-Mail-Adresse: " . $user->getEmail() . " <br />
        Benutzername: " . $user->getUsername() . " <br />
        ";
        $mail->AltBody = "Eine neue Paypal Zahlung ist eingegangen. 
        
        Vorname: " . $user->getFirstname() . " 
        Nachname: " . $user->getLastname() . " 
        E-Mail-Adresse: " . $user->getEmail() . " 
        Benutzername: " . $user->getUsername() . " 
        ";

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }

    public static function newPrepaidInc(User $user)
    {
        $mail = new PHPMailer;
        $mail->CharSet = "UTF-8";

        $mail->setFrom('info@musiclessonsonair.de', 'MSONAIR Benachrichtigungssystem');
        $mail->addAddress("info@musiclessonsonair.de");                      // Name is optional

        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->IsSMTP();
        $mail->Host = SSL_HOST;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Username = SSL_USERNAME;
        $mail->Password = SSL_PASS;
        $mail->Port = SSL_PORT;                                  // Set email format to HTML

        $mail->Subject = 'Eine neue Vorkassezahlung bei Musiclessons On Air';
        $mail->Body = "Eine neue Vorkassezahlung ist eingegangen. 
        <br /><br />
        Vorname: " . $user->getFirstname() ?? '' . " <br />
        Nachname: " . $user->getLastname() ?? '' . " <br />
        E-Mail-Adresse: " . $user->getEmail() ?? '' . " <br />
        Benutzername: " . $user->getUsername() ?? ''. " <br />
        ";
        $mail->AltBody = "Eine neue Vorkassezahlung ist eingegangen. 
        
        Vorname: " . $user->getFirstname() ?? '' . " 
        Nachname: " . $user->getLastname() ?? '' . " 
        E-Mail-Adresse: " . $user->getEmail() ?? '' . " 
        Benutzername: " . $user->getUsername() ?? '' . " 
        ";

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }

    public static function newPrepaidIncoming($data)
    {
        $mail = new PHPMailer;
        $mail->CharSet = "UTF-8";

        $mail->setFrom('info@musiclessonsonair.de', 'MSONAIR Benachrichtigungssystem');
        $mail->addAddress("info@musiclessonsonair.de");                      // Name is optional

        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->IsSMTP();
        $mail->Host = SSL_HOST;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Username = SSL_USERNAME;
        $mail->Password = SSL_PASS;
        $mail->Port = SSL_PORT;                                  // Set email format to HTML

        $mail->Subject = 'Eine neue Vorkassezahlung bei Musiclessons On Air';
        $mail->Body = "Eine neue Vorkassezahlung ist eingegangen. 
        <br /><br />
        Vorname: " . $data['firstname'] . " <br />
        Nachname: " . $data['lastname'] . " <br />
        E-Mail-Adresse: " . $data['email'] . " <br />
        Benutzername: " . $data['username'] . " <br />
        Paketname: " . $data['package'][0]["package_name"] . " <br />
        Paketpreis: " . $data['package'][0]["package_price"] . " <br />
        ";
        $mail->AltBody = "Eine neue Vorkassezahlung ist eingegangen. 
        
        Vorname: " . $data['firstname'] . " 
        Nachname: " . $data['lastname'] . " 
        E-Mail-Adresse: " . $data['email'] . " 
        Benutzername: " . $data['username'] . " 
        Paketname: " . $data['package'][0]["package_name"] . " 
        Paketpreis: " . $data['package'][0]["package_price"] . " 
        ";

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }

    public static function PaypalSofortCouponMail($data, $pdf, $pdf_name)
    {
        $mail = new PHPMailer;
        $mail->CharSet = "UTF-8";

        $mail->setFrom('info@musiclessonsonair.de', 'Musiclessons On Air');
        $mail->addAddress($data["email"]);                      // Name is optional

        //$mail->addBCC('MStockenberg@googlemail.com');

        $mail->addAttachment($pdf, $pdf_name);    // Optional name
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->IsSMTP();
        $mail->Host = SSL_HOST;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Username = SSL_USERNAME;
        $mail->Password = SSL_PASS;
        $mail->Port = SSL_PORT;                                  // Set email format to HTML

        $mail->Subject = 'Buchung eines Gutscheins';
        $mail->Body = '' . self::$gender[$data["gender"]] . ' ' . $data["firstname"] . ', <br /><br />
        wir freuen uns, dass du einen Gutschein bei Musiclessons On Air gebucht hast.
        <br /><br />
Sobald deine Zahlung auf unserem Konto eingegangen ist, senden wir dir den Gutschein per E-Mail
zu.
<br /><br />
Solltest du Fragen haben, zögere nicht, uns eine E-Mail an info@musiclessonsonair.de zu senden.
In unseren <a href="https://' . __SERVERNAME__ . __BASE__ . '?p=faq">FAQ</a> findest du außerdem Antworten auf einige häufig gestellte Fragen.
<br /><br />
Herzliche Grüße <br />
Dein Team von Musiclessons On Air
';
        $mail->AltBody = 'wir freuen uns, dass du einen Gutschein bei Musiclessons On Air gebucht hast.

Sobald deine Zahlung auf unserem Konto eingegangen ist, senden wir dir den Gutschein per E-Mail
zu.

Solltest du Fragen haben, zögere nicht, uns eine E-Mail an info@musiclessonsonair.de zu senden.
In unseren <a href="https://' . __SERVERNAME__ . __BASE__ . '?p=faq">FAQ</a> findest du außerdem Antworten auf einige häufig gestellte Fragen.

Herzliche Grüße
Dein Team von Musiclessons On Air';

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }

        self::sendCouponPaypalSofortMailtoAdmin($data);

    }

    public static function PrepaidCouponMail(\src\objects\Coupon $coupon, $pdf, $pdf_name)
    {
        $mail = new PHPMailer;
        $mail->CharSet = "UTF-8";

        $mail->setFrom('info@musiclessonsonair.de', 'Musiclessons On Air');
        $mail->addAddress($coupon->email);                      // Name is optional

        //$mail->addBCC('MStockenberg@googlemail.com');

        $mail->addAttachment($pdf, $pdf_name);    // Optional name
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->IsSMTP();
        $mail->Host = SSL_HOST;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Username = SSL_USERNAME;
        $mail->Password = SSL_PASS;
        $mail->Port = SSL_PORT;                                  // Set email format to HTML

        $mail->Subject = 'Buchung eines Gutscheins';
        $mail->Body = '' . self::$gender[$coupon->gender ?? "male"] . ' ' . $coupon->firstname . ', <br /><br />
        wir freuen uns, dass du einen Gutschein bei Musiclessons On Air gebucht hast.
        <br /><br />
Sobald deine Zahlung auf unserem Konto eingegangen ist, senden wir dir den Gutschein per E-Mail
zu.
<br /><br />
Solltest du Fragen haben, zögere nicht, uns eine E-Mail an info@musiclessonsonair.de zu senden.
In unseren <a href="https://' . __SERVERNAME__ . __BASE__ . '?p=faq">FAQ</a> findest du außerdem Antworten auf einige häufig gestellte Fragen.
<br /><br />
Herzliche Grüße <br />
Dein Team von Musiclessons On Air
';
        $mail->AltBody = 'wir freuen uns, dass du einen Gutschein bei Musiclessons On Air gebucht hast.

Sobald deine Zahlung auf unserem Konto eingegangen ist, senden wir dir den Gutschein per E-Mail
zu.

Solltest du Fragen haben, zögere nicht, uns eine E-Mail an info@musiclessonsonair.de zu senden.
In unseren <a href="https://' . __SERVERNAME__ . __BASE__ . '?p=faq">FAQ</a> findest du außerdem Antworten auf einige häufig gestellte Fragen.

Herzliche Grüße
Dein Team von Musiclessons On Air';

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }

        self::sendCouponPrepaidMailtoAdmin($coupon);

    }

    private static function sendCouponPaypalSofortMailtoAdmin($data)
    {

        $mail = new PHPMailer;
        $mail->CharSet = "UTF-8";

        $mail->setFrom('info@musiclessonsonair.de', 'MSONAIR Benachrichtigungssystem');
        $mail->addAddress("info@musiclessonsonair.de");                      // Name is optional

        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->IsSMTP();
        $mail->Host = SSL_HOST;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Username = SSL_USERNAME;
        $mail->Password = SSL_PASS;
        $mail->Port = SSL_PORT;                                  // Set email format to HTML

        $mail->Subject = 'Gutschein - neue Paypal / Sofortüberweisung';
        $mail->Body = 'Hallo, <br />
        Es wurde soeben ein neuer Gutschein per Paypal / Sofortüberweisung gebucht <br /><br />
        Kunde: ' . $data["firstname"] . ' ' . $data["firstname"] . ';<br />
        Adresse: ' . $data["street"] . ' ' . $data["postcode"] . '<br /> ' . $data["city"] . '<br />
        Email: ' . $data["email"] . '<br />
        Gutschein: ' . $data["package"][0]["package_name"] . '<br />
        Preis: ' . $data["package"][0]["package_price"] . '<br />
                        
';
        $mail->AltBody = 'Hallo, 
        Es wurde soeben ein neuer Gutschein per Paypal / Sofortüberweisung gebucht 
        Kunde: ' . $data["firstname"] . ' ' . $data["firstname"] . ';
        Adresse: ' . $data["street"] . ' ' . $data["postcode"] . ' ' . $data["city"] . '
        Email: ' . $data["email"] . '
        Gutschein: ' . $data["package"][0]["package_name"] . '
        Preis: ' . $data["package"][0]["package_price"] . '';

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }

    private static function sendCouponPrepaidMailtoAdmin(\src\objects\Coupon $data)
    {

        $mail = new PHPMailer;
        $mail->CharSet = "UTF-8";

        $mail->setFrom('info@musiclessonsonair.de', 'MSONAIR Benachrichtigungssystem');
        $mail->addAddress("info@musiclessonsonair.de");                      // Name is optional

        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->IsSMTP();
        $mail->Host = SSL_HOST;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Username = SSL_USERNAME;
        $mail->Password = SSL_PASS;
        $mail->Port = SSL_PORT;                                  // Set email format to HTML

        $mail->Subject = 'Gutschein - neue Vorkassebuchung';
        $mail->Body = 'Hallo, <br />
        Es wurde soeben ein neuer Gutschein per Vorkassezahlung gebucht <br /><br />
        Kunde: ' . $data->firstname . ' ' . $data->lastname . ';<br />
        Adresse: ' . $data->street . ' ' . $data->postcode . '<br /> ' . $data->city . '<br />
        Email: ' . $data->email . '<br />
      
                        
';
        $mail->AltBody = 'Hallo, 
         Es wurde soeben ein neuer Gutschein per Vorkassezahlung gebucht
        Kunde: ' . $data->firstname . ' ' . $data->lastname . ';
        Adresse: ' . $data->street . ' ' . $data->postcode . '
        ' . $data->city . '
        Email: ' . $data->email . '
        ';

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }

    /**
     * @param User $user
     * @param $pdf
     * @param $pdf_name
     */
    public static function PrepaidPaymentMail(User $user, $pdf, $pdf_name)
    {
        $mail = new PHPMailer;
        $mail->CharSet = "UTF-8";

        $mail->setFrom('info@musiclessonsonair.de', 'Musiclessons On Air');
        $mail->addAddress($user->getEmail());                      // Name is optional
        //$mail->addBCC('info@musiclessonsonair.de');

        $mail->addAttachment($pdf, $pdf_name);    // Optional name
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->IsSMTP();
        $mail->Host = SSL_HOST;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Username = SSL_USERNAME;
        $mail->Password = SSL_PASS;
        $mail->Port = SSL_PORT;                                  // Set email format to HTML

        $mail->Subject = 'Vielen Dank für Deine Buchung';
        $mail->Body = '' . self::$gender[$user->getGender()] . ' ' . $user->getFirstname() . ',
                        <br /><br />
                        vielen Dank für deine Anmeldung bei Musiclessons On Air.<br /><br />
                        
                        Dein Benutzername ist: ' . $user->getUsername() . ' <br />
                        Bitte lege über diesen Link dein Passwort fest: <a href="' . __SCRIPT__ . '?p=firstlogin&token=' . $user->getPassword() . '">Passwort festlegen</a>
                        <br /><br />
                        Sofort nach Zahlungseingang stehen dir die gebuchten Stundenkontingente in deinem Login-
                        Bereich zur Verfügung.
                        <br /><br />
                        Anbei erhältst du deine Rechnung als PDF-Dokument.<br>
                        Solltest du Fragen haben, zögere nicht, uns eine E-Mail an <a href="mailto:info@musiclessonsonair.de">info@musiclessonsonair.de</a> zu senden.
                        In unseren <a href="https://' . __SERVERNAME__ . __BASE__ . '?p=faq">FAQ</a> findest du außerdem Antworten auf einige häufig gestellte Fragen.
                        <br /><br />
                        Herzliche Grüße<br />
                        Dein Team von Musiclessons On Air';
        $mail->AltBody = '' . self::$gender[$user->getGender()] . ' ' . $user->getFirstname() . ',
                        
                        vielen Dank für deine Anmeldung bei Musiclessons On Air.
                        
                        Dein Benutzername ist: ' . $user->getUsername() . '
                        Bitte lege über diesen Link dein Passwort fest: ' . __SCRIPT__ . '?p=firstlogin&token=' . $user->getPassword() . '
                        
                        Sofort nach Zahlungseingang stehen dir die gebuchten Stundenkontingente in deinem Login-
                        Bereich zur Verfügung.
                        
                        Anbei erhältst du deine Rechnung als PDF-Dokument.
                        Solltest du Fragen haben, zögere nicht, uns eine E-Mail an info@musiclessonsonair.de zu senden.
                        In unseren FAQ findest du außerdem Antworten auf einige häufig gestellte Fragen.
                        
                        Herzliche Grüße
                        Dein Team von Musiclessons On Air';

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }

        self::newPrepaidInc($user);

    }
}