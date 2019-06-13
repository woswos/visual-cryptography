@extends('layouts/app')

@section('content')
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

        <div class="content">
          @php
          $request->session()->put('fileUploaded', False);
          $request->session()->put('fileConverted', False);
          @endphp

          @include('partials/dropzone')
        </div>

        <div class="content" style="visibility: hidden" id="settings">
          <h4>Please wait, shares are being created for the image you have uploaded</h4>
          <progress class="progress is-medium is-dark" max="100">45%</progress>
        </div>

      </div>

      <!------------------->
      <!-- SECOND COLUMN -->
      <!------------------->
      <div class="column is-two-thirds">

        <!-- Image dragging playground box -->
        <div class="box" id="image-box">

          <!-- Image dragging playground itself -->
          <iframe src="" id="image-iframe" scrolling="no" seamless="seamless"></iframe>

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

@endsection
