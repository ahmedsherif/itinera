<?ob_start();
?>

<!DOCTYPE html>

	 <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css" rel="stylesheet">
	<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
        <meta charset="utf-8">
        <title>Itinera Beta - Solve Problem with your neighboors </title>
        <meta name="generator" content="itinera" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css" rel="stylesheet">
        <link rel="icon" href="css/logo-fav.png" type="image/x-icon"/>
	<link rel="stylesheet" href="css/template.css" />

 <style type="text/css">
.alert-box {
    color:#555;
    border-radius:10px;
    font-family:Tahoma,Geneva,Arial,sans-serif;font-size:11px;
    padding:10px 10px 10px 36px;
    margin:10px;
}

.alert-box span {
    font-weight:bold;
    text-transform:uppercase;
}

.error {
    background:#ffecec url('images/error.png') no-repeat 10px 50%;
    border:1px solid #f5aca6;
}
.success {
    background:#e9ffd9 url('images/success.png') no-repeat 10px 50%;
    border:1px solid #a6ca8a;
}
.warning {
    background:#fff8c4 url('images/warning.png') no-repeat 10px 50%;
    border:1px solid #f2c779;
}
.notice {
    background:#e3f7fc url('images/notice.png') no-repeat 10px 50%;
    border:1px solid #8ed9f6;
}

}





</style>


<?php


require_once 'connect.php';
require_once 'Google_Client.php';
require_once 'Google_PlusService.php';
session_start();

$client = new Google_Client();
$client->setApplicationName("Itinera-App");

//Visit https://code.google.com/apis/console?api=plus to generate your
//client id, client secret, and to register your redirect uri.
$client->setClientId('55845591562.apps.googleusercontent.com');
$client->setClientSecret('J-l4j5yxhVsCfrfRHVy1x8IF');
$client->setRedirectUri('http://fictionteam.com/fb/');
$client->setDeveloperKey('AIzaSyCNDNQn7A9M2COPaW1NOYpZEoaiXCNibZ4');
$plus = new Google_PlusService($client);

if (isset($_GET['logout'])) {
    unset($_SESSION['token']);
}

if (isset($_GET['code'])) {
    if (strval($_SESSION['state']) !== strval($_GET['state'])) {
        die("The session state did not match.");
    }
    $client->authenticate();
    $_SESSION['token'] = $client->getAccessToken();
    $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
    header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['token'])) {
    $client->setAccessToken($_SESSION['token']);
}

if ($client->getAccessToken()) {
    $me = $plus->people->get('me');

    $displayName = $me['displayName'];
    $img = $me['image']['url'];
    $gplus = $me['url'];
    $pimg = '<img src='.$img.' class="img-circle">';
//////////////////////////////////////////////////////////////////////
    // The access token may have been updated lazily.
    $_SESSION['token'] = $client->getAccessToken();
} else {
    $state = mt_rand();
    $client->setState($state);
    $_SESSION['state'] = $state;

    $authUrl = $client->createAuthUrl();
header('Location:'.$authUrl);
}
?>




<?
if(isset($_POST['submit'])){

if(empty($_POST['problem']) === true || empty($_POST['desc']) === true || empty($_POST['youtube']) === true){

echo '<div class="alert-box error"><span><strong>Error:</strong> </span>You missed something in the form.</div>';
}
else{
$img = $img;

$Name = mysql_real_escape_string($displayName);

$gplus = $gplus;

$problem = mysql_real_escape_string($_POST['problem']);



$description = mysql_real_escape_string($_POST['desc']);

$youtube = $_POST['youtube'];
if (strpos($youtube,'youtube') === false) {
    echo '<div class="alert-box error"><span>Youtube Url: </span>something wrong with youtube url :).</div>';
    echo '<meta http-equiv="refresh" content="0; url=http://'.$_SERVER['HTTP_HOST'].'" />';
	exit;
}

$youtube = str_replace('http://www.youtube.com/watch?v=','',$youtube);



$now = new DateTime();
$date =  $now->format('Y-m-d H:i:s');    // MySQL datetime format

$add=mysql_query("INSERT INTO posts (date, problem, video, url, pic, name, content)
VALUES
('$date','$problem','$youtube','$gplus','$img','$Name','$description')");
if($add){

echo '<div class="alert-box success"><span>success: </span>Your problem successfully added :).</div>';
echo '<meta http-equiv="refresh" content="0; url=http://'.$_SERVER['HTTP_HOST'].'" />';

}

else{

echo mysql_error();

}



}




}



?>



