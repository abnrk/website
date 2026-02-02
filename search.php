<?php
$opts = [
  "http" => [
    "header" => "User-Agent: Opera/9.80 (J2ME/MIDP; Opera Mini/8.0; U; en) Presto/2.12.423 Version/12.16",
  ]
];
$context = stream_context_create($opts);
$data = file_get_contents('https://www.google.com/search?' . $_SERVER["QUERY_STRING"],false,$context);
$data = str_replace("href=\"/search", "href=\"/search.php", $data);
$data = str_replace("href=\"/?sa", "href=\"/google.php?sa", $data);
//$data = str_replace("href=\"/url", "href=\"/url.php", $data);
$data = preg_replace('/\/url\?q=(.*?)&amp;sa.*?"/','$1"',$data);
$data = preg_replace('/<div data-ved="[0-9a-zA-Z_-]*">.*AI Overview.*?<\/span><\/div><\/div><\/div>/',"",$data);
echo $data;
?>
