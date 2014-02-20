<?ob_start();?>

<!DOCTYPE html>



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

    $displayName = $me['displayName'];
    $img = $me['image']['url'];
    $gplus = $me['url'];
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
?>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
        <meta charset="utf-8">
        <title>Itinera Beta - Solve Problem with your neighbors </title>
        <meta name="generator" content="itinera" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/template.css" />
        <link rel="stylesheet" href="css/form.css" />
        <link rel="icon" href="css/logo-fav.png" type="image/x-icon"/>
	<meta property="og:image" content="http://itinera.fictionteam.com/css/back2.jpg" />
	<meta property="og:title" content="Itinera - Solve Problems With Your neighbors" />
	<meta property="og:description" content="Post Problems you face in your daily life !" />




        <!--[if lt IE 9]>
          <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
      









        <!-- CSS code from Bootply.com editor -->
        
        <style type="text/css">
            @import url(http://fonts.googleapis.com/css?family=Antic+Slab);
            @import url(http://fonts.googleapis.com/css?family=Loved+by+the+King);


html,body {
  height:100%;
}

h1 {
  font-family: 'Antic Slab', serif;
  font-size:80px;
  color:#DDCCEE;
}

#googleMap{
width:800px;
height:400px;

position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 70%;
    background: rgb(0,0,0); /* Old browsers */
    background: -moz-linear-gradient(top,  rgba(0,0,0,1) 0%, rgba(44,83,158,1) 48%, rgba(0,0,0,1) 100%); /* FF3.6+ */
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(0,0,0,1)), color-stop(48%,rgba(44,83,158,1)), color-stop(100%,rgba(0,0,0,1))); /* Chrome,Safari4+ */
    background: -webkit-linear-gradient(top,  rgba(0,0,0,1) 0%,rgba(44,83,158,1) 48%,rgba(0,0,0,1) 100%); /* Chrome10+,Safari5.1+ */
    background: -o-linear-gradient(top,  rgba(0,0,0,1) 0%,rgba(44,83,158,1) 48%,rgba(0,0,0,1) 100%); /* Opera 11.10+ */
    background: -ms-linear-gradient(top,  rgba(0,0,0,1) 0%,rgba(44,83,158,1) 48%,rgba(0,0,0,1) 100%); /* IE10+ */
    background: linear-gradient(to bottom,  rgba(0,0,0,1) 0%,rgba(44,83,158,1) 48%,rgba(0,0,0,1) 100%); /* W3C */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#000000', endColorstr='#000000',GradientType=0 ); /* IE6-9 */
    -moz-box-shadow:inset 0px 1px 5px 0px #ffffff;
    -webkit-box-shadow:inset 0px 1px 5px 0px #ffffff;
    box-shadow:inset 0px 1px 5px 0px #ffffff;
    -moz-border-radius:10px;
    -webkit-border-radius:10px;
    border-radius:10px;
    -webkit-animation-name: bluePulse;
    -webkit-animation-duration: 2s;
    -webkit-animation-iteration-count: infinite;




}

.lead {
	color:#DDCCEE;
}


/* Custom container */
.container-full {
  margin: 0 auto;
  width: 100%;
  min-height:100%;
  color:#eee;
  overflow:hidden;
   background: url('css/back2.jpg') no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}

.container-full a {
  color:#efefef;
  text-decoration:none;
}

.v-center {
  margin-top:7%;
}
.video-container {
    position: relative;
    padding-bottom: 56.25%;
    padding-top: 30px; height: 0; overflow: hidden;

}
 
.video-container iframe,
.video-container object,
.video-container embed {
    
}

        </style>
    </head>
    
    <!-- HTML code from Bootply.com editor -->
    
    <body  >
<script
        src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCNDNQn7A9M2COPaW1NOYpZEoaiXCNibZ4&sensor=true">
    </script>

    <script>
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                map.setCenter(initialLocation);
            });
        }
        var map;
        var myCenter=new google.maps.LatLng(29.99300228455108,31.256103515625);

        function initialize()
        {
            geocoder = new google.maps.Geocoder();

            var mapProp = {
                center:myCenter,
                zoom:9,
                mapTypeId:google.maps.MapTypeId.HYBRID
            };

            map = new google.maps.Map(document.getElementById("googleMap"),mapProp);

            google.maps.event.addListener(map, 'click', function(event) {
                placeMarker(event.latLng);

            });
        }


        function placeMarker(location) {
            var marker = new google.maps.Marker({
                position: location,
                map: map,
                icon: 'stylesheets/marker.png',
                animation:google.maps.Animation.BOUNCE
            });
            var infowindow = new google.maps.InfoWindow({
                content: '<section class="form-horizontal"><form action="check.php" method="POST">'+
                '<?php echo $pimg;?>'+
                '<table>'+
                '<tr><td width="200px">Name:</td>'+
                ' <td><?php echo $displayName;?>'+
                '</td></tr>'+
                '<tr><td>G+:</td>'+
                '<td><url><?php echo $gplus;?></url>'+
                '</td></tr>'+
                '<tr><td>Problem Name:</td> <td><input type="text" class="say" name="problem">'+
                '</td></tr>'+
                '<tr><td><a href="#" class="source"></a></td> '+
		'<tr><td>Problem Description</td>'+
		'<td><textarea class="say" name="desc"> Describe the problem here ... </textarea></td></td>'+
		'<tr><td>Youtube url </td>'+
		'<td><input type="text" class="say" placeholder="Youtube url" name="youtube"></td></tr>'+
		'<td><input type="submit" value="POST" class="source" name="submit" '+
		'style="color:red;font-family: \'Loved by the King\', cursive;">'+
		'</td></tr>'+
                '</form>'+
		
                '<link href=\'http://fonts.googleapis.com/css?family=Loved+by+the+King\'+ 				' +
                'rel=\'stylesheet\' type=\'text/css\'>'+
                '</section>'
            });
            infowindow.open(map,marker);
        }

        //Geo-Code Location For City ,
        function codeAddress() {
            var address = document.getElementById('address').value;
            geocoder.geocode( { 'address': address}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    map.setCenter(results[0].geometry.location);
                    var marker = new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location
                    });
                } else {
                    alert('Geocode was not successful for the following reason: ' + status);
                }
            });
        } // End Of GeoCode Location of city .

        google.maps.event.addDomListener(window, 'load', initialize);


    </script>

        
<div class="container-full">
    <div class="row">
        <div class="col-lg-12 text-center v-center">

            <br class="">
            <br class="">
            <br class=""><div class="video-container">
 
        <div id="googleMap"></div>
	
          

</div> <div id="top_menu">
<table><tr>
<td><img src="<?=$img;?>" class="img-circle"></td>
<td><h3><a href="<?=$gplus;?>"><?echo $displayName;?></a></h3></td>
</tr>
<tr><td><?echo $country;?></td>
</table>
            <input id="address" type="text" value="<?='City,'.$country;?>">
            <input type="submit" value="check" class="btn btn-success" onclick="codeAddress()">
                <a href="#" class="dropdown-toggle" style ="float:left;" data-toggle="dropdown"><div class="glyphicon glyphicon-bell"></div></a>
                <ul class="dropdown-menu">
                  <li><a href="#"><span class="label label-info pull-right">0</span><? echo "Notification for ".$country." is not available now <br/> ";?></a>
		<li><a href="#"><span class="label label-info pull-right">0</span> No organization participated in solving problem yet <br> </li>
</li>

                </ul>

</div>
		
                

                </div>

                </div>
            </form>
        </div>
    </div>
    <!-- /row -->
   <!-- /container full -->
<div class="panel panel-default" >
<?
require_once 'connect.php';
$posts = mysql_query("SELECT * FROM posts ");
while($data = mysql_fetch_array($posts)){
 

$pic = $data['pic'];
$date = $data['date'];
$content = $data['content'];
$name = $data['name'];
$youtube = $data['video'];
$gplus = $data['url'];
$id = $data['id'];
$problem = $data['problem'];
$long = $data['longitude'];
$lat = $data['latitude'];

echo '
<div class="panel panel-default">
           <div class="panel-heading"><span class="pull-left"><img class="img-circle" src="'.$pic.'"></span><a href="problem.php?id='.$id.'" class="pull-right">View all</a> <h4><a href="'.$gplus.'">'.$name.'</a></h4>'.$problem.'</div>
   			<div class="panel-body">
<div class="pull-left"><span class="label label-success">Problem Date: '.$date.'</span></div><br/>
                       <iframe style="border-radius:20px;"src="http://www.youtube.com/embed/'.$youtube.'?autoplay=0&controls=0&showinfo=0&rel=0" frameborder="0" width="560" height="315"></iframe>
              <div class="clearfix"></div>
              <hr>
              <ul class="list-unstyled"><li>

<a class="btn btn-info pull-left" style="width:10%;" href="problem.php?id='.$id.'">Discussion</a>
</li></ul>
            </div>
         </div>';
}



               
   
?>

<br class="">
            <p class="btn btn-primary center-block pull-right" style="font-family: 'Loved by the King', cursive;color=#800000;">
Developed With Love For Google Cloud Developer Challenge 2013 :)</p>
            <br class="">




    
        
        <script type='text/javascript' src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>


        <script type='text/javascript' src="http://netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>



        
        <!-- JavaScript jQuery code from Bootply.com editor -->
        
        <script type='text/javascript'>
        
        $(document).ready(function() {
        
            
        
        });
        
        </script>
        
    </body>
</html>
