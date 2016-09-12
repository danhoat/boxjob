function initialise() {
    myLatlng = new google.maps.LatLng(10.8230989,106.6296638);
    mapOptions = {
        zoom: 5,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
    }
    geocoder = new google.maps.Geocoder();
    infoWindow = new google.maps.InfoWindow;
    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

    xmlUrl = "http://mrdoctor.vn/job/wp-content/markers.xml";

    loadMarkers();

}
function downloadUrl(url,callback) {
    var request = window.ActiveXObject ?
         new ActiveXObject('Microsoft.XMLHTTP') :
         new XMLHttpRequest;

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            //request.onreadystatechange = doNothing;
            callback(request, request.status);
        }
    };

    request.open('GET', url, true);
    request.send(null);
}
function loadMarkers() {
    map.markers = map.markers || []
    downloadUrl(xmlUrl, function(data) {
        var xml = data.responseXML;
        markers = xml.documentElement.getElementsByTagName("marker");
        console.log(markers);
        for (var i = 0; i < markers.length; i++) {
            var name = markers[i].getAttribute("post_title");
            var permalink = markers[i].getAttribute("permalink");
            name = '<a href="'+permalink+'">'+name+'</a>';
            var marker_image = markers[i].getAttribute('markerimage');
            var id = markers[i].getAttribute("id");
            var address = markers[i].getAttribute("address1")+"<br />"+markers[i].getAttribute("address2")+"<br />"+markers[i].getAttribute("address3")+"<br />"+markers[i].getAttribute("postcode");
            var image = {
              url: marker_image,
              size: new google.maps.Size(71, 132),
              origin: new google.maps.Point(0, 0),
              scaledSize: new google.maps.Size(71, 132)
            };
            var point = new google.maps.LatLng(
                parseFloat(markers[i].getAttribute("lat")),
                parseFloat(markers[i].getAttribute("lng")));
            var html = "<div class='infowindow'><b>" + name + "</b> <br/>" + address+'<br/></div>';
            var marker = new google.maps.Marker({
              map: map,
              position: point,
              title: name
            });
            createMarker(point, html);
        }
    });
}
function createMarker(latlng, html){
   var marker = new google.maps.Marker({
      map: map,
      position: latlng,
      title: name
   });

   // This event expects a click on a marker
   // When this event is fired the infowindow content is created
   // and the infowindow is opened
   google.maps.event.addListener(marker, 'click', function() {
      // including content to the infowindow
      infoWindow.setContent(html);

      // opening the infowindow in the current map and at the current marker location
      infoWindow.open(map, marker);
   });
}
google.maps.event.addDomListener(window, 'load', initialise);