<?php
// Start the session
session_start();

$command = 'source /home/bsimsekc/virtualenv/public__html_visual-cryptography/3.7/bin/activate && cd /home/bsimsekc/public_html/visual-cryptography/dithercrypt && python3 dithercrypt.py';
$args = 'encrypt2 /home/bsimsekc/public_html/visual-cryptography/website/'.$_SESSION["target_file"].' /home/bsimsekc/public_html/visual-cryptography/website/static/images/output_preview_1.png /home/bsimsekc/public_html/visual-cryptography/website/static/images/output_preview_2.png';

$transparency_arg = "transparency=true";
$brightness_arg = (100-$_SESSION['brightness-slider'])/100;
$contrast_arg = (100-$_SESSION['contrast-slider'])/100;

shell_exec($command." ".$args." ".$transparency_arg." ".$brightness_arg." ".$contrast_arg);

?>
