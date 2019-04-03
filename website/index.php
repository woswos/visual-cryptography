<?php

// Start the session
session_start();

if(!isset($_SESSION["uploadCompleted"])){
  $_SESSION["uploadCompleted"] = false;
  $_SESSION["uploadError"] = false;
}

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
  <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>

  <!-- Include JQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

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
            <h3>Please choose the image that you want to encrypt</h3>
          </div>

          <!-- File upload -->
          <div class="content">
            <form action="website/upload.php" method="post" enctype="multipart/form-data">
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

              <!-- Encryption Options -->
              <div class="content">
                <div class="buttons">
                  <span class="button" onclick='toggleButton("transparent-pixels-button")' id="transparent-pixels-button">Transparent Pixels</span>
                  <span class="button" onclick='toggleButton("vector-based-button")' id="vector-based-button">Vector Based</span>
                </div>
              </div>

              <!-- Image Uploading Button -->
              <div class="content">
                <p>Upload and processing might take a while, please wait and don't refresh the page</p>
                <button class="button is-fullwidth" type="submit" onclick="uploadingBar()" id="upload-file-button">Upload selected image(s)</button>
              </div>
            </form>
          </div>


          <!-- Download Images Button -->
          <div class="content">
            <form method="get" action="website/static/images/visual-cryptography-shares.zip">
              <button class="button is-fullwidth" type="submit" <?php if(!$_SESSION["uploadCompleted"]){echo "disabled" ;} ?> >Download Shares</button>
            </form>
          </div>

        </div>

        <!------------------->
        <!-- SECOND COLUMN -->
        <!------------------->
        <div class="column is-two-thirds">

          <!-- Image dragging playground box -->
          <div class="box" id="image-box">

            <!-- Image dragging playground itself -->
            <iframe src="website/drag-images.php" id="image-iframe"></iframe>

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
  <!-- Needed for the file input form customization -->
  <script src="website/static/js/custom-file-input.js"></script>

  <!-- Needed for turning submit button into loading button -->
  <script type="text/javascript">
    function uploadingBar() {
      document.getElementById("upload-file-button").className = "button is-fullwidth is-success is-loading";
    }
  </script>

  <!-- Needed for toggling buttons when pressed -->
  <script type="text/javascript">
    function toggleButton(buttonId) {
      if (document.getElementById(buttonId).className=="button"){
          document.getElementById(buttonId).className="button is-info";

          $.ajax({
              type: "GET",
              url: 'website/session-update.php',
              data: {clickedButtonId: buttonId, status: "1"},
              success: function(data){
                  //alert(data);
              }
          });

      }else if(document.getElementById(buttonId).className=="button is-info"){
          document.getElementById(buttonId).className="button";

          $.ajax({
              type: "GET",
              url: 'website/session-update.php',
              data: {clickedButtonId: buttonId, status: "0"},
              success: function(data){
                  //alert(data);
              }
          });

      }
    }
  </script>

  <!-- Browser check -->
  <script type="text/javascript">
  var ua = navigator.userAgent.toLowerCase();
    if (ua.indexOf('safari') != -1) {
      if (ua.indexOf('chrome') > -1) {
        //alert("1") // Chrome
      } else {
        alert("This page is not optimized for safari browser, please use chrome browser") // Safari
      }
    }
  </script>

</body>

</html>
