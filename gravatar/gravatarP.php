<?php

include 'clases.php';
$eMail = $_POST['eMail'];
$defImg = 'http://eldesafio5mildolares.files.wordpress.com/2010/10/cara-triste.jpg';
$avatar = new Gravatar($eMail, $defImg);
$avatar->setSize(90);
$avatar->setRating('G');
$avatar->setExtra('alt="gravatar"');


echo "$eMail<br>";
echo $avatar->toHTML();
?>
