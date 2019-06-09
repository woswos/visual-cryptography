<!DOCTYPE html>
<html lang = "en">

   <head>
      <meta charset = "utf-8">
      <meta http-equiv="refresh" content="2">
   </head>

   <body>
     Sesson id:
     <pre>
       <?php print_r($this->session->session_id); ?>
     </pre>

     IP:
     <pre>
       <?php print_r($_SERVER['REMOTE_ADDR']); ?>
     </pre>

    <pre>
      <?php print_r($this->session->all_userdata()); ?>
    </pre>

   </body>

</html>
