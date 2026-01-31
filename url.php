<?php
$url = htmlspecialchars($_GET["q"]);
header('Location: ' . $url);
exit;
?>
