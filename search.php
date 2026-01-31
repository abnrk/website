<html>
  <head>
    <?php
    $search = urlencode($_GET["q"]);
    if(isset($_GET['tbm'])){
      if (htmlspecialchars($_GET["tbm"]) == 'isch') {
        $mode = 'img';
      }
      }else{
        $mode = 'all';
      }
    ?>
    <!-- <title><?php echo $search . ' - PHP Proxy'?></title> -->
  </head>
  <body>
    <?php
    $opts = [
     "http" => [
       "header" => "User-Agent: Opera/9.80 (J2ME/MIDP; Opera Mini/8.0; U; en) Presto/2.12.423 Version/12.16",
     ]
    ];
    $context = stream_context_create($opts);
    if ($mode == 'all') {
      if (isset($_GET['start'])) {
          $data = file_get_contents('https://www.google.com/search?q=' . $search . "&start=" . $_GET['start'],false,$context);
      } else {
          $data = file_get_contents('https://www.google.com/search?q=' . $search,false,$context);
      }
      $data = str_replace("href=\"/search", "href=\"/search.php", $data);
      $data = str_replace("href=\"/?sa", "href=\"/google.php?sa", $data);
      $data = str_replace("href=\"/url", "href=\"/url.php", $data);
    } elseif ($mode == 'img') {
      if (isset($_GET['start'])) {
          $data = file_get_contents('https://www.google.com/search?q=' . $search . '&tbm=isch' . "&start=" . $_GET['start'],false,$context);
      } else {
          $data = file_get_contents('https://www.google.com/search?q=' . $search . '&tbm=isch',false,$context);
      }
      $data = str_replace("href=\"/search", "href=\"/search.php", $data);
      $data = str_replace("href=\"/?sa", "href=\"/google.php?sa", $data);
      $data = str_replace("href=\"/url", "href=\"/url.php", $data);
    }
    $data = preg_replace('/<div data-ved="[0-9a-zA-Z]*">.*AI Overview[ -~]*<\/span><\/div><\/div><\/div>/',"",$data);
    echo $data;
    ?>
  </body>
</html>
