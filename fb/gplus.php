<?php
require_once 'Google_Client.php';
require_once 'Google_PlusService.php';
session_start();

$client = new Google_Client();
$client->setApplicationName("Google+ PHP Starter Application");

$client->setClientId('55845591562.apps.googleusercontent.com');
$client->setClientSecret('J-l4j5yxhVsCfrfRHVy1x8IF');
$client->setRedirectUri('http://itinera.fictionteam.com');
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
  print "Your Profile: <pre>" . print_r($me, true) . "</pre>";

  $params = array('maxResults' => 100);
  $activities = $plus->activities->listActivities('me', 'public', $params);
  print "Your Activities: <pre>" . print_r($activities, true) . "</pre>";
  
  $params = array(
    'orderBy' => 'best',
    'maxResults' => '20',
  );
  $results = $plus->activities->search('Google+ API', $params);
  foreach($results['items'] as $result) {
    print "Search Result: <pre>{$result['object']['content']}</pre>\n";
  }

  // The access token may have been updated lazily.
  $_SESSION['token'] = $client->getAccessToken();
} else {
  $state = mt_rand();
  $client->setState($state);
  $_SESSION['state'] = $state;

  $authUrl = $client->createAuthUrl();
  print "<a class='login' href='$authUrl'>Connect Me!</a>";
}
