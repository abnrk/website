<?php
define("ENGINE","google");
$engines = [
  "google" => "https://www.google.com/search?",
  "yahoo" => "https://search.yahoo.com/search?",
  "bing" => "https://www.bing.com/search?",
  "duckduckgo" => "https://duckduckgo.com/?q",
];
$opts = [
  "http" => [
    "header" => "User-Agent: Opera/9.80 (J2ME/MIDP; Opera Mini/8.0; U; en) Presto/2.12.423 Version/12.16",
  ]
];
$context = stream_context_create($opts);
$data = file_get_contents($engines[ENGINE] . $_SERVER["QUERY_STRING"],false,$context);
$data = str_replace("href=\"/search", "href=\"/search.php", $data);
$data = str_replace('href="https://search.yahoo.com/search','href="/search.php',$data);
$data = str_replace('action="https://search.yahoo.com/search','action="/search.php',$data);
$data = str_replace('https:\/\/search.yahoo.com\/search','\/search.php',$data);
$data = str_replace("href=\"/?sa", "href=\"/google.php?sa", $data);
//$data = str_replace("href=\"/url", "href=\"/url.php", $data);
$data = preg_replace('/\/url\?q=(.*?)&amp;sa.*?"/','$1"',$data);
$data = preg_replace_callback('/https:\/\/r.search.yahoo.com\/.*?RU=(.*?)\/.*?"/',fn($m) => urldecode($m[1]).'"',$data);
$data = preg_replace('/;_yl[a-z]=[0-9a-zA-Z-._]*/',"",$data);
$data = preg_replace('/<div data-ved="[0-9a-zA-Z_-]*">.*AI Overview.*?<\/span><\/div><\/div><\/div>/',"",$data);
echo $data;
?>
