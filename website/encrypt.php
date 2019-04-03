<?php
// Start the session
session_start();

$command = 'source /home/bsimsekc/virtualenv/public__html_visual-cryptography/3.7/bin/activate && cd /home/bsimsekc/public_html/visual-cryptography/dithercrypt && python3 dithercrypt.py ';
$args = 'encrypt2 /home/bsimsekc/public_html/visual-cryptography/website/'.$_SESSION["target_file"].' /home/bsimsekc/public_html/visual-cryptography/website/static/images/output1.png /home/bsimsekc/public_html/visual-cryptography/website/static/images/output2.png';
$output = shell_exec($command.$args);
//echo $command.$args;
//echo "<br>";
//cho $output;

// zipping
$command = 'cd /home/bsimsekc/public_html/visual-cryptography/website/static/images/ && ';
$args = 'zip -FSr visual-cryptography-shares.zip output1.png output2.png '.$_SESSION["uploaded_file_name"];
$output = shell_exec($command.$args);
?>
