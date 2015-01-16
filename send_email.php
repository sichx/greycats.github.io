<?php

// Debugging functions
function d($a = null){
    dd($a);
    die;
}
function dd($a = null){
    echo '<pre>';
    var_dump($a);
    echo '</pre>';
}

require_once 'vendor/autoload.php';


$subject    = 'Contact details from iLabs';
$from       = 'postmaster@interactivelabs.co';
$fromName   = 'ILabs';
$host       = 'smtp.mailgun.org';
$password   = '2e4f1326316e740da1ebd5be47406546';
$to         = 'hello@interactivelabs.co';

$data       = $_POST;
$response   = array(
    'status'    => 'error',
    'message'   => ''
);

if ( isset($data['submit']) ) {
    if ( !isset($data['email']) || !isset($data['fullname']) || !isset($data['phone'])|| !isset($data['message']) ) {
        $response['message'] = 'Please fill required fields';
    }

    ob_start();
    include 'email.tpl';
    $message = ob_get_contents();
    ob_clean();

    $mail = new PHPMailer;

    $mail->isSMTP();
    $mail->Host = $host;
    $mail->SMTPAuth = true;
    $mail->Username = $from;
    $mail->Password = $password;
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->From     = $from;
    $mail->FromName = $fromName;
    $mail->addAddress( $to );

    $mail->isHTML(true);

    $mail->Subject = $subject;
    $mail->Body    = $message;

    if ($mail->send()) {
        $response['status']  = 'ok';
        $response['message'] = 'Email was successfully submitted';
    } else {
        $response['message'] = $mail->ErrorInfo;
    }
} else {
    $response['message'] = 'You should submit form';
}

die(  json_encode($response) );