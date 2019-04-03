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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.4/css/bulma.min.css">
  <link href="website/static/css/jquery.dm-uploader.min.css" rel="stylesheet">
  <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <style>

    body {
       color: #4a4a4a;
       font-size: 13px;
       font-weight: 400;
       line-height: 1.5;
     }

     a {
       color: #4a4a4a;
       cursor: pointer;
       text-decoration: none;
     }

     .button {
       font-size: 13px;
     }

     .section.is-header {
       padding: 15px;
     }

     .notification{
       padding: 9px;
     }

     ::selection {
       background-color: #666;
       color: #fff
     }

     .navbar-item:hover {
       text-decoration: underline;
       text-underline-position: under;
     }

     #image-box {
       height: 800px;
       width: 100%;
     }

     #image-iframe {
       height: 100%;
       width: 100%;
     }

     #current-page {
       text-decoration: underline;
       text-underline-position: under;
     }
   </style>

  <script type="text/javascript">
  function uploadingBar() {
  document.getElementById("upload-file-button").className = "button is-success is-loading";
  }
  </script>
</head>

<body>

<!-- HEADER -->
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


<!-- MAIN BODY -->
  <section class="section">
    <div class="container">
      <div class="columns">

        <!-- FIRST COLUMN -->
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
                    <input class="file-input" type="file" name="fileToUpload" accept="image/*" data-multiple-caption="{count} files selected" multiple>
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
                  <span class="button">Transparent Pixels</span>
                  <span class="button">Vector Based</span>
                </div>
              </div>

              <!-- Image Uploading Button -->
              <div class="content">
                <button class="button is-fullwidth" type="submit" onclick="uploadingBar()" id="upload-file-button">Upload selected image(s)</button>
              </div>
            </form>
          </div>


          <!-- Download Images -->
          <div class="content">
            <form method="get" action="website/static/images/visual-cryptography-shares.zip">
              <button class="button is-fullwidth" type="submit" <?php if(!$_SESSION["uploadCompleted"]){echo "disabled";} ?>>Download Shares</button>
            </form>
          </div>

        </div>

        <!-- SECOND COLUMN -->
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

  <!-- FOOTER -->
  <section class="section is-footer">
  </section>



  <script src="website/static/js/custom-file-input.js"></script>

</body>

</html>
