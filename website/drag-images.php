<?php
// Start the session
session_start();

if($_SESSION["uploadCompleted"]){
  $fileName = "output";
} else {
  $fileName = "default";
}

list($width, $height) = getimagesize("static/images/".$fileName."1.png");

if ($width > 500) {
    $ratio = 1/($width/500);
    $width = 500;
    $height = $height*$ratio;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width">

    <style>
    #output1 {
      background-image: url("static/images/<?PHP echo $fileName; ?>1.png?key=<?php echo time(); ?>");
      position: absolute;
      top: 0px;
      left: 0px;
      height: <?php echo $height; ?>px;
      width: <?php echo $width; ?>px;
      background-size: <?php echo $width; ?>px <?php echo $height; ?>px;
    }

    #output2 {
      background-image: url("static/images/<?PHP echo $fileName; ?>2.png?key=<?php echo time(); ?>");
      position: absolute;
      top: 25px;
      left: 25px;
      height: <?php echo $height; ?>px;
      width: <?php echo $width; ?>px;
      background-size: <?php echo $width; ?>px <?php echo $height; ?>px;
    }
   </style>

</head>
<body>
      <div id="output1"></div>
      <br>
      <div id="output2"></div>
  <script src="static/js/dragndrop.js"></script>
</body>
</html>
