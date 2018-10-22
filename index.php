<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Local Host</title>
  <meta name="description" content="">
  <meta name="author" content="Thomas Wright / Phobos Technologies LLC">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600|Teko" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="localhost.css">
  <link rel="icon" type="image/png" href="images/favicon.png">
</head>

<body>
  <div class="">
    <h4>Local Host</h4>
    <nav>
      <?PHP
        // read apache2.conf into $apache2conf
        if(file_exists('/etc/apache2/apache2.conf')){
          if(!is_readable('/etc/apache2/apache2.conf')) echo "apache2.conf is NOT readable<br>";
          if(!($apache2conf = file_get_contents('/etc/apache2/apache2.conf'))) echo "Could not retrieve the contents of apache2.conf";
        }else echo "File does not exist<br>";

        // search for VirtualHost names
        function GetVHServerName($apache2config,$portNumber){
          $count=0;
          // search for VirtualHost tags
          preg_match_all("/<VirtualHost\s\*:$portNumber>([a-zA-Z0-9\.\s\/\$\{}_\R]*)<\/VirtualHost>/",$apache2config,$matches);
          // for each VR tag, extract the server names and put them in an array
          foreach($matches[1] as $val){
            preg_match("/ServerName\s([a-zA-Z0-9\.]*)/",$val,$matches2);
            $serverNames[$count]=$matches2[1];
            $count++;
          }
          return $serverNames;
        }

        $serverNames = GetVHServerName($apache2conf,80);
        // echo each server name into an anchor tag
        foreach($serverNames as $srvname){
          echo "<a href=\"http://$srvname\" target=\"_BLANK\">$srvname</a><br>";
        }
      ?>
    </nav>
  </div>
</body>
</html>
