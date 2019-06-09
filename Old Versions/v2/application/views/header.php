<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width">

  <title>Visual Cryptography | <?php echo $title; ?></title>

  <!-- Include Bulma CSS Framework -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.4/css/bulma.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-extensions@6/dist/css/bulma-extensions.min.css">

  <!-- Include Custom CSS File -->
  <link rel="stylesheet" href="public/css/style.css?key=<?php echo time(); ?>">

  <!-- Include DropZone CSS File -->
  <link rel="stylesheet" href="public/css/dropzone.css?key=<?php echo time(); ?>">

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
            <a class="is-link" href="<?php echo base_url ('home'); ?>" rel="nofollow" <?php if($title=="Home"){echo "id='current-page'";} ?>>
              Home
            </a>
          </span>
          <span class="navbar-item">
            <a class="is-link" href="<?php echo base_url ('app_v1'); ?>" rel="nofollow" <?php if($title=="App v1"){echo "id='current-page'";} ?>>
              Version 1
            </a>
          </span>
          <span class="navbar-item">
            <a class="is-link" href="<?php echo base_url ('app_v2'); ?>" rel="nofollow" <?php if($title=="App v2"){echo "id='current-page'";} ?>>
              Version 2
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
