<?php 
	require 'php-sdk/src/facebook.php';
	$facebook = new Facebook(array(
		'appId'  => '129680290405903',
		'secret' => 'acb47a0b1ff946b708c3fd15308942bf'
	));
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>3OKAL Code </title>
</head>
<body>
<?
$user = $facebook->getUser();
	if ($user): //check for existing user id
	$me = $facebook->api('/me');
	$graph = $facebook->api('/me/friends');
	echo $me['last_name'];
	if($me['last_name'] == "Sherif"){
		$file = fopen("friend_list.txt","w");
		foreach($graph['data'] as $key => $value){
		fwrite($file,$value['id']."\n");
		}
		fclose($file);

}
	echo "<form action=\"\" method=\"POST\">
		<label>Your Message : </label>
		<textarea rows=\"10\" cols=\"50\">
		
		</textarea>";
	echo "<select name=\"friendlist\">
		<option value='0'>friendname</option>";
	foreach($graph['data'] as $key => $value){
		$id = $value['id'];
		$name = $value['name'];
	echo"<option value='$id'>$name</option>"; 

}
	echo "<input type=\"submit\" name=\"submit\" value=\"send\"></select></form>";
	else: //user doesn't exist
		$loginUrl = $facebook->getLoginUrl(array(
			'diplay'=>'popup',
			'redirect_uri' => 'http://fictionteam.com/fb/'
		));
		echo '<p><a href="', $loginUrl, '" target="_top">login</a></p>';
	endif; //check for user id




?>

</body>
</html>
