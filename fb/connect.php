<?php

$link = mysql_connect('localhost', 'user', 'password');
if (!$link) {
    die('Not connected : ' . mysql_error());
}

// make the current db
$db_selected = mysql_select_db('itinera', $link);
if (!$db_selected) {
    die ('Can\'t use foo : ' . mysql_error());
}
?>
