<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Simple markers</title>
    <style>
      html, body, #map-canvas {
        height: 100%;
		width: 100%;
        margin: 0px;
        padding: 0px
      }
    </style>
   
  
  </head>
  <body>
  <?php
  function mapsearch()
{
  $arr1=array(23,20,22,32,42,12,4,21,3,2);
  $arr2=array(2,24,32,12,8,7,3,1,4,2);
  
  $arrlength=count($arr1);
  
  $text="
<script src='https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true'></script>
	<script>
	var myCenter=new google.maps.LatLng(27, 30);
	var arrays = new Array();
	var arrays2 = new Array();
	var arrays3 = new Array();
function initialize()
{
var mapProp = {
    center:myCenter,
    zoom: 4,
    draggable: true,
    scrollwheel: false,
    mapTypeId:google.maps.MapTypeId.ROADMAP
};

var map=new google.maps.Map(document.getElementById('map-canvas'),mapProp);
";
for($i=0;$i<$arrlength;$i++){
$text.=
"	arrays[$i]=new google.maps.LatLng($arr1[$i], $arr2[$i]);
	arrays2[$i]=new google.maps.Marker({
    position:arrays[$i],
    url: 'https://badgov.com.nu/report/$arr1[$i]/$arr2[$i]',
    animation:google.maps.Animation.DROP
	});
	
	google.maps.event.addListener(arrays2[$i], 'click', function() {window.location.href = arrays2[$i].url;});
	arrays2[$i].setMap(map);
";}

$text.="}
google.maps.event.addDomListener(window, 'load', initialize);
	</script>";
	
echo $text;
	}
	
	
	
	mapsearch();
	?>

    <div id="map-canvas"></div>
  </body>
</html>