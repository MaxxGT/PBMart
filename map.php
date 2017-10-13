<!DOCTYPE html>
<html>
  <head>
    <style>
      #map-canvas {
        width: 500px;
        height: 400px;
      }
    </style>
    <script src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.4344930836423!2d110.32188365445053!3d1.5090879947468454!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31fb09ef42bc4309%3A0x7ae6bfc407a73c9b!2sJalan+Ketitir%2C+Everbright+Estate%2C+93250+Kuching%2C+Sarawak!5e0!3m2!1sen!2smy!4v1431589523150" width="400" height="300" frameborder="0" style="border:0"></script>
    <script>
      function initialize() {
        var mapCanvas = document.getElementById('map-canvas');
        var mapOptions = {
          center: new google.maps.LatLng(44.5403, -78.5463),
          zoom: 8,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(mapCanvas, mapOptions)
      }
      google.maps.event.addDomListener(window, 'load', initialize);
    </script>
  </head>
  <body>
    <div id="map-canvas"></div>
  </body>
</html>