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
