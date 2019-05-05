<?php
if(session_id() == '' || !isset($_SESSION)) { session_start(); }

//avoid apache to kill the php running
ignore_user_abort(true);

$transparent = $_SESSION['transparent-pixels-button'];
$vector = $_SESSION['vector-based-button'];
$pixelType = $_SESSION['pixel-type'];
$pixelSamplingFreg_arg = $_SESSION['pixel-sampling-frequency'];
$pixelSize_arg = $_SESSION['pixel-size'];

$command = 'source /home/bsimsekc/virtualenv/public__html_visual-cryptography/3.7/bin/activate && cd /home/bsimsekc/public_html/visual-cryptography/dithercrypt && python3 dithercrypt.py';
$args = 'encrypt2 /home/bsimsekc/public_html/visual-cryptography/website/'.$_SESSION["target_file"].' /home/bsimsekc/public_html/visual-cryptography/website/static/images/output1.png /home/bsimsekc/public_html/visual-cryptography/website/static/images/output2.png';

if($transparent == true){
  $transparency_arg = "transparency=true";
} else {
  $transparency_arg = "transparency=false";
}

$brightness_arg = (100-$_SESSION['brightness-slider'])/100;
$contrast_arg = (100-$_SESSION['contrast-slider'])/100;

shell_exec($command." ".$args." ".$transparency_arg." ".$brightness_arg." ".$contrast_arg);


if($vector == true){

  if($pixelType == "circle"){
    $pixelType_arg = "shape=rectangle";
  } else if($pixelType == "triangle"){
    $pixelType_arg = "shape=triangle";
  } else {
    $pixelType_arg = "shape=rectangle";
  }

  // Convert to svg
  $command = 'source /home/bsimsekc/virtualenv/public__html_visual-cryptography/3.7/bin/activate && cd /home/bsimsekc/public_html/visual-cryptography/dithercrypt && python pixel-to-svg.py';

  // For output image 1
  $args = '/home/bsimsekc/public_html/visual-cryptography/website/static/images/output1.png /home/bsimsekc/public_html/visual-cryptography/website/static/images/output1.svg';
  shell_exec($command." ".$args." ".$transparency_arg." ".$pixelType_arg." ".$pixelSize_arg." ".$pixelSamplingFreg_arg);

$_SESSION['args'] = $command." ".$args." ".$transparency_arg." ".$pixelType_arg." ".$pixelSize_arg." ".$pixelSamplingFreg_arg;

  // For output image 2
  $args = '/home/bsimsekc/public_html/visual-cryptography/website/static/images/output2.png /home/bsimsekc/public_html/visual-cryptography/website/static/images/output2.svg';
  shell_exec($command." ".$args." ".$transparency_arg." ".$pixelType_arg." ".$pixelSize_arg." ".$pixelSamplingFreg_arg);

  $args = 'zip -FSr visual-cryptography-shares.zip output1.png output1.svg output2.png output2.svg '.$_SESSION["uploaded_file_name"];
} else {
  $args = 'zip -FSr visual-cryptography-shares.zip output1.png output2.png '.$_SESSION["uploaded_file_name"];
}

// zipping
$command = 'cd /home/bsimsekc/public_html/visual-cryptography/website/static/images/ && ';
shell_exec($command.$args);

?>
