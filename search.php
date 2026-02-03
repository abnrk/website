<?php
define("ENGINE","google");
define("YAHOO_UI_MODE",2); // 1 = new ui, 2 = old ui
$engines = [
  "google" => "https://www.google.com/search?",
  "yahoo" => "https://search.yahoo.com/search?",
  "bing" => "https://www.bing.com/search?",
  "duckduckgo" => "https://duckduckgo.com/?",
];
if(YAHOO_UI_MODE == 2) {
  $engines["yahoo"] = "https://search.yahoo.com/yhs/search?";
}
if(ENGINE != "google") {
  $user_agent = "Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko";
}
if(ENGINE == "google" || str_contains($_SERVER["HTTP_USER_AGENT"],"Mobile")) {
  $user_agent = "Opera/9.80 (J2ME/MIDP; Opera Mini/8.0; U; en) Presto/2.12.423 Version/12.16";
}
if(ENGINE == "bing") {
  //$user_agent = "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; Trident/4.0)";
  $user_agent = "Mozilla/4.0 (compatible; MSIE 7.0; Windows CE; IEMobile 7.11)";
}
$opts = [
  "http" => [
    "header" => "User-Agent: " . $user_agent,
  ]
];
$context = stream_context_create($opts);
$data = file_get_contents($engines[ENGINE] . $_SERVER["QUERY_STRING"],false,$context);
if(ENGINE == "google") {
  $data = substr_replace($data,'<link rel="icon" href="google.ico"/>',strpos($data,"<head>")+strlen("<head>"),0);
  $data = str_replace("href=\"/search", "href=\"/search.php", $data);
  $data = str_replace("href=\"/?sa", "href=\"/google.php?sa", $data);
  //$data = str_replace("href=\"/url", "href=\"/url.php", $data);
  $data = preg_replace('/\/url\?q=(.*?)&amp;sa.*?"/','$1"',$data);
  $data = preg_replace('/<div data-ved="[0-9a-zA-Z_-]*">.*AI Overview.*?<\/span><\/div><\/div><\/div>/',"",$data);
}
if(ENGINE == "bing") {
}
if(ENGINE == "yahoo") {
  $data = str_replace('href="https://search.yahoo.com/search','href="/search.php',$data);
  $data = str_replace('action="https://search.yahoo.com/search','action="/search.php',$data);
  $data = str_replace('https:\/\/search.yahoo.com\/search','\/search.php',$data);
  $data = preg_replace_callback('/https:\/\/r.search.yahoo.com\/.*?RU=(.*?)\/.*?"/',fn($m) => urldecode($m[1]).'"',$data);
  $data = preg_replace('/;_yl[a-z]=[0-9a-zA-Z-._]*/',"",$data);
}
if(ENGINE == "duckduckgo") {
  $data = str_replace('action="/html/','action="/search.php',$data);
}
echo $data;
?>
