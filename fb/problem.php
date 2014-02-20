<?ob_start();?>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
        <meta charset="utf-8">
        <title>Itinera Beta - Solve Problem with your neighbors </title>
        <meta name="generator" content="itinera" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/template.css" />
        <link rel="icon" href="css/logo-fav.png" type="image/x-icon"/>
	<meta property="og:image" content="http://itinera.fictionteam.com/css/back2.jpg" />
	<meta property="og:title" content="Itinera - Solve Problems With Your neighbors" />
	<meta property="og:description" content="Post Problems you see in daily life !" />
<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>





<style type="text/css">

            @import url(http://fonts.googleapis.com/css?family=Loved+by+the+King);


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


</head>

<?php

require_once 'Google_Client.php';
require_once 'Google_PlusService.php';
session_start();

$client = new Google_Client();
$client->setApplicationName("Itinera-App");

//Visit https://code.google.com/apis/console?api=plus to generate your
//client id, client secret, and to register your redirect uri.
$client->setClientId('55845591562.apps.googleusercontent.com');
$client->setClientSecret('J-l4j5yxhVsCfrfRHVy1x8IF');
$client->setRedirectUri('http://itinera.fictionteam.com/');
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

    $dname = $me['displayName'];
    $img = $me['image']['url'];
    $plus = $me['url'];
    $pimg = '<img src='.$img.' class="img-circle">';
    $country = $me['placesLived'][0]['value'];
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



$link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];



require_once 'connect.php';

$id = intval($_GET['id']);

$id = mysql_real_escape_string($id);


//Add Comment Solution 

if(isset($_POST['comment'])){

$solution = $_POST['solution'];

$solution = mysql_real_escape_string($solution);
if (strpos($solution,'meta') === true) {

$solution = str_replace('meta','Hack Attempt',$solution);
}
if(empty($solution) === true){
echo '<div class="alert-box error"><span><strong>Error:</strong> </span>Something went wrong , maybe you missed something .</div>';

}else{


$rank = 0;
$add=mysql_query("INSERT INTO comments (id, name, gplus, country, rank, pic, comment)
VALUES
('$id','$dname','$plus','$country','$rank','$img','$solution')");

if($add){

echo '<div class="alert-box success"><span>success: </span>Thanks For sharing solutions :) </div>';
echo '<meta http-equiv="refresh" content="0"/>';

}

else{

echo mysql_error();

}



}


}

if(!id){

echo '<div class="alert-box error"><span><strong>Error:</strong> </span>Something went wrong , maybe you get the wrong page.</div>';


}

else{

$problem = mysql_query("SELECT * FROM posts where id = '$id'");

while($data = mysql_fetch_array($problem)){
  $pic = $data['pic'];
$date = $data['date'];
$content = $data['content'];
$name = $data['name'];
$youtube = $data['video'];
$gplus = $data['url'];
$problem = $data['problem'];
$long = $data['longitude'];
$lat = $data['latitude'];
echo '
<div class="panel panel-default">
           <div class="panel-heading"><span class="pull-left"><img class="img-circle" src="'.$pic.'"></span><a href="problem.php?id='.$id.'" class="pull-right"></a> <h4><a href="'.$gplus.'">'.$name.'</a></h4>'.$problem.'</div>
   			<div class="panel-body">
<div class="pull-left"><span class="label label-success">Problem Date: '.$date.'</span></div><br/>
                       <iframe style="border-radius:20px;" src="http://www.youtube.com/embed/'.$youtube.'?autoplay=0&controls=0&showinfo=0&rel=0" frameborder="0" width="560" height="315"></iframe>
              <div class="clearfix"></div>'.$content.'
              <hr>
              <ul class="list-unstyled"><li>
<a href="http://'.$_SERVER['HTTP_HOST'].'"> Back </a>
</li></ul>
            </div>
         </div>';
echo '
<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style ">
<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
<a class="addthis_button_tweet"></a>
<a class="addthis_button_pinterest_pinit" pi:pinit:layout="horizontal"></a>
<a class="addthis_counter addthis_pill_style"></a>
<a class=""><g:plusone></g:plusone></a>
</div>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-528b971b73f190ae"></script>
<!-- AddThis Button END -->';


$query = mysql_query("SELECT * FROM comments where id = '$id'");

while($comment = mysql_fetch_array($query)){
$content = $comment['comment'];
$content = str_replace('\r\n','',$content);
$content = mysql_real_escape_string($content);
$name = $comment['name'];
$pls = $comment['gplus'];
$country = $comment['country'];
$rank = $comment['rank'];
$fb_img = $comment['pic'];
$now = new DateTime();
$date =  $now->format('Y-m-d H:i:s');

echo '<div class="well pull-left" style="width:70%;"> 
             <form class="form">
<table>
		<tr><td><img class="img-circle" src="'.$fb_img.'"></td>
		<td><a href="'.$pls.'"><h4>'.$name.'</h4></a></td></tr></table>
		<td></td><td><h6>'.$country.'<h6></td></tr>
		<tr><td><span class="label label-success">Solution Posted : '.$date.'</span></td></tr>

		<div class="well">'.$content.'</div>
              </div>
            </form>
          </div>';

}


echo '<div class="well pull-left" style="width:40%;font-family: \'Loved by the King\', cursive;"> 
             <form class="form " action="" method="POST">
              <h4>Post Solution</h4>
	 	      <table>
		<tr>
			<td><img class="img-circle" src="'.$img.'"></td>
</tr>
		<td>Name :</td><td>'.$dname.'</td>
		<td></td>
</tr>



</table>
   
	      <textarea rows="4" cols="50" class="form-control" placeholder="Explain your solution here " name="solution"></textarea> <br>
                <span class="input-group-btn">
		<input type="submit" class="btn btn-lg btn-primary pull-right" name="comment" value="POST"></span>
            </form>
          </div><br>';


exit;
        
 
}


}

?>


