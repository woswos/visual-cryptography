<section class="section">
    <div class="container">
      <div class="columns">

        <!------------------>
        <!-- FIRST COLUMN -->
        <!------------------>
        <div class="column">

          <!-- Info text -->
          <div class="content">
            <h4>Please upload the image that you want to encrypt</h4>
          </div>

          <form action="https://<?php echo base_url ('uploader'); ?>" enctype="multipart/form-data" class="dropzone" id="image-upload" method="POST">
          </form>


        </div>

        <!------------------->
        <!-- SECOND COLUMN -->
        <!------------------->
        <div class="column is-two-thirds">

          <!-- Image dragging playground box -->
          <div class="box" id="image-box">

            <!-- Image dragging playground itself -->
            <iframe src="https://<?php echo base_url ('drag_images'); ?>" id="image-iframe" scrolling="no" seamless="seamless"></iframe>

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
