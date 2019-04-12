<?php

// Start the session
session_start();

if(!isset($_SESSION["uploadCompleted"])){
  $_SESSION["uploadCompleted"] = false;
  $_SESSION["exportCompleted"] = false;
  $_SESSION["uploadError"] = false;
  $_SESSION['contrast-slider'] = "10";
  $_SESSION['brightness-slider'] = "10";
}

$_SESSION['transparent-pixels-button'] = false;
$_SESSION['vector-based-button'] = false;
$_SESSION['circle-based-button'] = false;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width">

  <title>Visual Cryptography</title>

  <!-- Include Bulma CSS Framework -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.4/css/bulma.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-extensions@6/dist/css/bulma-extensions.min.css">

  <!-- Include Custom CSS File -->
  <link rel="stylesheet" href="website/static/css/style.css">

</head>

<body>

  <!------------>
  <!-- HEADER -->
  <!------------>
  <section class="section is-header">
    <div class="container">
      <nav class="navbar">

        <div class="navbar-brand">
          <span class="navbar-item">
            <a class="is-link is-active" href="https://jgthms.com/" target="_blank" rel="nofollow" id="current-page">
              Home
            </a>
          </span>
          <span class="navbar-item">
            <a class="is-link is-link" href="https://jgthms.com/freelance-designer-developer-london" target="_blank" rel="nofollow">
              About Me
            </a>
          </span>
          <span class="navbar-item">
            <a class="is-link is-link" href="http://www.ntsi.info/?/about_ntsi/" target="_blank" rel="nofollow">
              About NTSI Lab
            </a>
          </span>
          <span class="navbar-item is-github">
            <a href="https://github.com/woswos" target="_blank" rel="nofollow">
              GitHub
            </a>
          </span>
        </div>
    </div>
  </section>

  <!--------------->
  <!-- MAIN BODY -->
  <!--------------->
  <section class="section">
    <div class="container">
      <div class="columns">

        <!------------------>
        <!-- FIRST COLUMN -->
        <!------------------>
        <div class="column">

          <!-- Info text -->
          <div class="content">
            <h4>Please choose the image that you want to encrypt</h4>
          </div>

          <!-- File upload -->
          <div class="content">
            <form action="website/upload.php" method="post" enctype="multipart/form-data" id="preview-download-form">
              <div class="content">
                <div class="file">
                  <label class="file-label">
                    <input class="file-input" type="file" name="fileToUpload" accept="image/*" data-multiple-caption="{count} files selected" multiple="multiple">
                    <span class="file-cta">
                      <span class="file-icon">
                        <i class="fas fa-upload"></i>
                      </span>
                      <span class="file-label" for="file" id="uploaded-file-label">
                        Choose image(s) to upload
                      </span>
                    </span>
                  </label>
                </div>
              </div>

              <!-- Contrast Asjusting Button -->
              <div class="content">
                <p>Increase Contrast by (%)</p>
                <input id="contrast-slider" name="contrast-slider" class="slider has-output is-fullwidth" min="0" max="100" value="<?php echo $_SESSION["contrast-slider"]; ?>" step="1" type="range">
                <output for="contrast-slider"><?php echo $_SESSION["contrast-slider"]; ?></output>
              </div>

              <!-- Brightness Asjusting Button -->
              <div class="content">
                <p>Increase Brightness by (%)</p>
                <input id="brightness-slider" name="brightness-slider" class="slider has-output is-fullwidth" min="0" max="100" value="<?php echo $_SESSION["brightness-slider"]; ?>" step="1" type="range">
                <output for="brightness-slider"><?php echo $_SESSION["brightness-slider"]; ?></output>
              </div>


              <!-- Image Uploading Button -->
              <div class="content">
                <p>Upload and processing might take a while, please wait and don't refresh the page</p>
                <button class="button is-fullwidth" type="submit" onclick='uploadingBar("upload-file-button")' id="upload-file-button">Preview</button>
              </div>
            </form>
          </div>


          <!-- File download -->
          <!--<form action="website/encrypt-full.php" method="post" enctype="multipart/form-data" target="_blank" id="file-download-form">-->

            <!-- Encryption Options -->
            <div class="content">
              <p>Select encryption options and download the full sized image</p>
              <p>Processing the image might take a few minutes based on your selections, please wait</p>
              <div class="buttons">
                <span class="button" onclick='toggleButton("transparent-pixels-button")' id="transparent-pixels-button" <?php if(!$_SESSION["uploadCompleted"]){echo "disabled" ;} ?> >Transparent Pixels</span>
                <span class="button" onclick='toggleButton("circle-pixels-button")' id="circle-pixels-button" <?php if(!$_SESSION["uploadCompleted"]){echo "disabled" ;} ?> >Circle Pixels</span>
                <span class="button" onclick='toggleButton("vector-based-button")' id="vector-based-button" <?php if(!$_SESSION["uploadCompleted"]){echo "disabled" ;} ?> >Vector Based</span>
              </div>
            </div>

            <!-- Download Images Button -->
            <div class="content">
                <button class="button is-fullwidth" type="submit" id="download-file-button" onclick='uploadingBar("download-file-button"); processFiles("download-file-button");' <?php if(!$_SESSION["uploadCompleted"]){echo "disabled" ;} ?> ><i class="fas fa-download"></i>&nbsp;&nbsp;Process & Download</button>
            </div>

          <!--</form>-->


        </div>

        <!------------------->
        <!-- SECOND COLUMN -->
        <!------------------->
        <div class="column is-two-thirds">

          <!-- Image dragging playground box -->
          <div class="box" id="image-box">

            <!-- Image dragging playground itself -->
            <iframe src="website/drag-images.php" id="image-iframe" scrolling="no" seamless="seamless"></iframe>

            <!--
            <div class="notification">
              <button class="delete"></button>
              You can drag images with your mouse to check how they overlay
            </div>
            -->

          </div>
        </div>
      </div>
  </section>

  <!------------>
  <!-- FOOTER -->
  <!------------>
  <section class="section is-footer">
  </section>


  <!--------------------->
  <!-- JavaScript Files-->
  <!--------------------->
  <!-- Include JQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <!--Fontawesome -->
  <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>

  <!-- Needed for the file input form customization -->
  <script src="website/static/js/custom-file-input.js"></script>

  <!-- Needed for turning submit button into loading button -->
  <!-- Needed for toggling buttons when pressed -->
  <!-- Needed for processing uploaded files when corresponding button is pressed -->
  <script src="website/static/js/button-actions.js"></script>

  <!-- Browser check -->
  <script src="website/static/js/browser-check.js"></script>

  <!-- Code for updating slider values instantly check -->
  <script src="website/static/js/slider.js"></script>

</body>

</html>
