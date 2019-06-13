{!! Form::open([ 'route' => [ 'dropzone.upload' ], 'files' => true, 'class' => 'dropzone needsclick dz-clickable','id'=>"dropzone"]) !!}
{!! Form::close() !!}

<script type="text/javascript">
  Dropzone.options.dropzone = {
      autoProcessQueue : true,
      maxFiles: 1,
      acceptedFiles: ".jpeg,.jpg,.png,.gif",
      init : function() {

          myDropzone = this;

          // Prevent users from adding a second file
          this.on("addedfiles", function(files) {
            //console.log(files.length + ' files added');
            myDropzone.removeEventListeners();
          });

          // Restore initial message when queue has been completed
          this.on("success", function(files) {
            var settings = document.getElementById ( "settings" ) ;
            settings.style.visibility = "visible" ;

            var checkFileConverted = function() {
              console.log('Started converting');
              console.time("Conversion_duration");
              $.get('{{ route('processDropzoneUpload') }}', function(data) {
                if (data == '1') {
                    console.log('Finished converting');
                    console.timeEnd("Conversion_duration");
                    alert(data);
                } else {
                    console.log('Error occured');
                    console.log(data);
                }
              });
            };

            checkFileConverted();

            //location.reload();
          });

      }
  };


</script>
