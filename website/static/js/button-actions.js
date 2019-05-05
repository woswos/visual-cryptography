function uploadingBar(buttonId) {
  document.getElementById(buttonId).className = "button is-fullwidth is-success is-loading";
}

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

function processFiles(buttonId) {
       $.ajax({
           type: "POST",
           url: 'website/process.php',
           timeout: 120000,
           success: function(data){
               document.getElementById(buttonId).className = "button is-fullwidth";

               $.ajax({
                  url: 'website/static/images/visual-cryptography-shares.zip',
                  method: 'GET',
                  xhrFields: {
                      responseType: 'blob'
                  },
                  success: function (data) {
                      var a = document.createElement('a');
                      var url = window.URL.createObjectURL(data);
                      a.href = url;
                      a.download = 'visual-cryptography-shares.zip';
                      a.click();
                      window.URL.revokeObjectURL(url);
                  }
               });

           },
          fail: function(xhr, textStatus, errorThrown){
             alert('Request failed, probably file size is too big');
          }
       });

}
