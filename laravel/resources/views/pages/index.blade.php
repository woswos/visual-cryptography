@extends('layouts/app')

@section('content')
  <section class="section">
      <div class="container">

        <div class="content">
          <h4>A Novel Visual Cryptography Tool</h4>
        </div>

        <div class="columns">

          <!-- First Column -->
          <div class="column">

            <div class="content">
              <h5>What is visual cryptography?</h5>
              <p>
                Visual cryptography is a cryptographic technique which allows visual information (pictures, text, etc.)
                to be encrypted in such a way that the decrypted information appears as a visual image.
                Visual cryptography can be used to protect biometric templates in which decryption does not require any
                complex computations. [<a href="https://en.wikipedia.org/wiki/Visual_cryptography" target="_blank">Source</a>]
              </p>

              <h5>Why this tool?</h5>
              <p>
                As high-speed computers become cheaper and ubiquitous to individuals with malicious intentions,
                available digital encryption techniques become inadequate to protect information. Consequently,
                information security became an indispensable subject to address when storing data.  Thus, new
                types of encryption techniques such as visual cryptography should be integrated into existing
                encryption techniques to improve security. Visual cryptography is the art and science of encoding
                visual information into image shares in separate layers to form intricate patterns. Encoded
                information is only revealed when all layers are stacked together in a specific orientation. While
                previous research focuses only on integrity of the original encoded information, our research also
                focuses on how information is represented in created layers. Commonly, generated layers contain
                random white noise patterns and suffer from not providing any meaningful information for viewers.
                However, generating layers in a way they contain useful information and meaningful patterns
                enhance security of the data stored because 3rd parties cannot even realize that layers are shares
                of the encrypted data. To address this problem, we developed a software tool that allows individuals
                to encrypt visual information while producing aesthetically pleasing image shares in each generated
                layer. Generated layers can be used to store data more securely as well as in kinetic installations
                to hide visuals from the audience until the image share layers align in the pre-planned orientations.
                Kinetic installations utilize physical position of viewer and artwork to display different visual
                elements. Therefore, visual encryption is useful for displaying different visuals when physical
                layers are dynamically separated and stacked. Results show that our software tool can be used to
                encrypt visual information aesthetically to further increase security and used in such installations
                for augmenting the experience.
              </p>

            </div>

            <div class="content">
              <b>Keywords:</b> Visual Cryptography, Software Tool, Kinetic Installations
            </div>

          </div>


          <!-- Second Column -->
          <div class="column">

            <div class="content">
              We have developed different optimized versions of this tool for different purposes.
              You can play with already encrypted images below before testing different versions.
              Try moving images with your mouse or press "a" on your keyboard to perfectly align
              two images.
            </div>

            <!-- Image dragging playground box -->
            <div class="box" id="home-image-box">

              <!-- Image dragging playground itself -->
              <iframe src="{{ $drag_images_url }}" id="image-iframe" scrolling="no" seamless="seamless"></iframe>

              <!--
              <div class="notification">
                <button class="delete"></button>
                You can drag images with your mouse to check how they overlay
              </div>
              -->

            </div>
          </div>

    </section>

@endsection
