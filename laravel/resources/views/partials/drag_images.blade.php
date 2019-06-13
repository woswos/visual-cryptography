<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width">

    <style>
    #output1 {
      background-image: url("{{ asset('images/default_1.png') }}");
      position: absolute;
      top: 0px;
      left: 0px;
      height: 300px;
      width: 300px;
      background-size: 300px 300px;
    }

    #output2 {
      background-image: url("{{ asset('images/default_2.png') }}");
      position: absolute;
      top: 25px;
      left: 25px;
      height: 300px;
      width: 300px;
      background-size: 300px 300px;
    }
   </style>

</head>
<body>
      <div id="output1"></div>
      <br>
      <div id="output2"></div>
  <script src="{{ asset('js/dragndrop.js') }}"></script>
</body>
</html>
