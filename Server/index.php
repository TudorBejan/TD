<em>    <!DOCTYPE html >
    <head>
    <!--<meta http-equiv="refresh" content="3">-->
    <style type="text/css">
        html { height: 100% }
        body { height: 100%; margin: 0; padding: 0 }
        #map_canvas { height: 100% }
    </style>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>TAXI Application</title>
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCqohZaLWoRfFciv0oG-ZFfe2Y-_5vk2yg&sensor=false"></script>
    <script type="text/javascript">
    //<![CDATA[
    var map;
    
    var markersArray = [];
    var markerArray= [];
    var markers=[];
    var markers2;
	
    var latS;
    var lngS;
	
    var myEvent = new CustomEvent('update', {});
	
    var customIcons = {
      0: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_blue.png',
        shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
      },
      1: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_red.png',
        shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
      }
    };
    
    function load() {
		intitialize();
		constantUpdate();
    }
	
	function intitialize(){
		map = new google.maps.Map(document.getElementById("map"), {
			center: new google.maps.LatLng(45.74906936394455, 21.230144500732422),
			zoom: 14,
			mapTypeId: 'roadmap'
      	});
        
		var infoWindow = new google.maps.InfoWindow;
		  
		google.maps.event.addListener(map, 'click', function(event) {
			addMarkerS(event.latLng);
		});
		
		
      
      // Change this depending on the name of your PHP file
      
		  downloadUrl("genxml.php", function(data) {
			var xml = data.responseXML;
			markers = xml.documentElement.getElementsByTagName("marker");
			for (var i = 0; i < markers.length; i++) {
			  var id = markers[i].getAttribute("id");
			  var busy = markers[i].getAttribute("busy");
			  var nr_masina = markers[i].getAttribute("nr_masina");
			  var point = new google.maps.LatLng(
				  parseFloat(markers[i].getAttribute("lat")),
				  parseFloat(markers[i].getAttribute("lng")));
			  var html = "<b>Nr. masina: " + nr_masina + "</b> <br/>";
			  var icon = customIcons[busy] || {};
			  markerArray[i] = new google.maps.Marker({
				map: map,
				position: point,
				icon: icon.icon,
				title: id,
				shadow: icon.shadow
			  });
			  bindInfoWindow(markerArray[i], map, infoWindow, html);
			}
		  });
		  
		//google.maps.addEventListener('update',function(){
			//alert("event");},false);  
		
			// Trigger it!
		
	}
	
	function constantUpdate(){
		downloadUrl("genxml.php", function(data) {
			var xml2 = data.responseXML;
			markers2 = xml2.documentElement.getElementsByTagName("marker");
			for (var i = 0; i < markers2.length; i++) 
			{
				var icon = customIcons[markers2[i].getAttribute("busy")] || {};
				changeMarkerPosition(markerArray[i],markers2[i].getAttribute("lat"),markers2[i].getAttribute("lng"),icon);
			}	
		});
		setTimeout("constantUpdate()", 1000);
	}
	
    function changeMarkerPosition(marker,lat,lng,icon){
		var latlng2 = new google.maps.LatLng(parseFloat(lat),parseFloat(lng),true);
		marker.setPosition(latlng2);
		marker.setIcon(icon.icon);
		//map.panTo(latlng2);
	}
	
    function getParams() {
        var idx = window.location.search.indexOf('?');
        var params = new Array();
        if (idx != -1) {
            var pairs = window.location.search.substring(idx+1, window.location.search.length).split('&');
            for (var i=0; i<pairs.length; i++) {
                nameVal = pairs[i].split('=');
                params[nameVal[0]] = nameVal[1];
            }
        }
        return params;
    }
    
    
    function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
    }
    
    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;
    
      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request, request.status);
        }
      };
    
      request.open('GET', url, true);
      request.send(null);
    }
    
    function doNothing() {}
    
    function addMarkerS(location) {
      marker = new google.maps.Marker({
        position: location,
        icon: 'yellow_MarkerN.png',
        map: map
      });
      
      
      markersArray.push(marker);
     
      
      //document.write("intra aici");
      
      google.maps.event.addListener(marker, 'dblclick', function() {
        if(confirm("Are you sure that you want to delete this new marker?") == true)
        {
            this.setMap(null);
            
            google.maps.event.clearListeners(map, 'click');
            
            google.maps.event.addListener(map, 'click', function(event) {
                addMarkerS(event.latLng);
            });
        }
            
      });
      
      google.maps.event.clearListeners(map, 'click');
      
      google.maps.event.addListener(map, 'click', function(event) {
        addMarkerD(event.latLng);
      });
      
      latS=location.lat();
      lngS=location.lng();
       
    }
    
    function addMarkerD(location) {
      marker = new google.maps.Marker({
        position: location,
        icon: 'yellow_MarkerN.png',
        map: map
      });
      markersArray.push(marker);
      
      //alert("intra aici");
      
      google.maps.event.clearListeners(map, 'click');
      
      google.maps.event.addListener(marker, 'click', function() 
      {
        var contentString = '<div id="content">' +
                            '<div id="siteNotice">' +
                            '</div>' +
                            '<h3 id="firstHeading" class="firstHeading">Trimite comanda</h3>' +
                            '<div id="bodyContent">' +
                            '<form name="formularIncImg" method="post" action="pune_comanda.php">' +
                            '<p>LatS: <input name="LatS" value="'+latS+'" /></p>' +
                            '<p>LngS: <input name="LngS" value="'+lngS+'" /></p>' +
                            '<p>LatD: <input name="LatD" value="'+this.getPosition().lat()+'" /></p>' +
                            '<p>LngD: <input name="LngD" value="'+this.getPosition().lng()+'" /></p>' +
                            '<p align="center"><INPUT type="submit" name="trimit" value="OK"></p>' +
                            '</form>' +
                            '</div>' +
                            '</div>';
    
        var infowindow = new google.maps.InfoWindow(
        {
            content: contentString
        });
        
        infowindow.open(map,this);
      });
      
      google.maps.event.addListener(marker	, 'dblclick', function() {
        if(confirm("Are you sure that you want to delete this new marker?") == true)
        {
            this.setMap(null);
            
            google.maps.event.addListener(map, 'click', function(event) {
                addMarkerD(event.latLng);
            });
        }
      });  
    }
    function sleep(milliseconds) {
        var start = new Date().getTime();
        for (var i = 0; i < 1e7; i++) {
            if ((new Date().getTime() - start) > milliseconds){
                break;
            }
        }
    }
    
    </script>
    
    </head>
    
    <body onload="load()">
    <div id="map" style="width:100%; height:100%;"></div>
    
    </body>
    
    </html></em>