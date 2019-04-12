<?php
// Start the session
session_start();

$transparent = $_SESSION['transparent-pixels-button'];
$vector = $_SESSION['vector-based-button'];


$command = 'source /home/bsimsekc/virtualenv/public__html_visual-cryptography/3.7/bin/activate && cd /home/bsimsekc/public_html/visual-cryptography/dithercrypt && python3 dithercrypt.py ';

$args = 'encrypt2 /home/bsimsekc/public_html/visual-cryptography/website/'.$_SESSION["target_file"].' /home/bsimsekc/public_html/visual-cryptography/website/static/images/output1.png /home/bsimsekc/public_html/visual-cryptography/website/static/images/output2.png ';

if($transparent == true){
  $transparency_arg = "transparency=true";
} else {
  $transparency_arg = "transparency=false";
}

$output = shell_exec($command.$args.$transparency_arg);
//echo $command.$args;
//echo "<br>";
//cho $output;

// zipping
$command = 'cd /home/bsimsekc/public_html/visual-cryptography/website/static/images/ && ';
$args = 'zip -FSr visual-cryptography-shares.zip output1.png output2.png '.$_SESSION["uploaded_file_name"];
$output = shell_exec($command.$args);

// Downloader
header('Content-Type: application/download');
header('Content-Disposition: attachment; filename="visual-cryptography-shares.zip"');
header("Content-Length: " . filesize("static/images/visual-cryptography-shares.zip"));

$fp = fopen("static/images/visual-cryptography-shares.zip", "r");
fpassthru($fp);
fclose($fp);

?>
