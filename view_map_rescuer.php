<html>

<?php

include 'check_session.php';

include 'menu_rescuer.html';


?>

<head>

<link rel = "stylesheet" href = "http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css"/>

<script src = "http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>

<link rel="stylesheet" href="mystyle.css">


</head>


<body>

<div id = 'map' style = "width: 100%; height: 80%"> </div>

<div id = 'map2' style = "width: 100%; height: 80%"> </div>



<br>

<table border='1' id="mytable">

<tr>

<td>

<div id = "upd">

Shop Name: <input type = "text" id ="shop_name"> 

<button id='btn' onclick="get_updated_location()">Search For Shops</button>

</div>

</td>

<td>

<div id ="upd2"> 

Category Name: <input type = "text" id ="cat_name"> 

<button id='btn' onclick="get_updated_location_cat()">Search For Shops</button>

 

</td>

</div>

</tr>

</table>

</br>

<script>

var greenIcon = new L.Icon({
  iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
  iconSize: [25, 41],
  iconAnchor: [12, 41],
  popupAnchor: [1, -34],
  shadowSize: [41, 41]
});

//to eikonidio gia ton kokkino marker pou antiproswpevei to telos tis diadromis 
var redIcon = new L.Icon({
  iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
  iconSize: [25, 41],
  iconAnchor: [12, 41],
  popupAnchor: [1, -34],
  shadowSize: [41, 41]
});

//sinarti i opoia pairnei san orisma 2 zevgi (lat,lng) kai 

//epistrefei tin diafora rou se metra 
function getDistance(lat1, lon1, lat2, lon2) 
    {
      var R = 6371;
	  
	  //i diafora twn lat se aktinia
      var dLat = toRad(lat2-lat1);
	  
	  //i diafora twn lon se aktinia
      var dLon = toRad(lon2-lon1);
	  
	  //to lat1 se aktinia
      var lat1 = toRad(lat1);
	  
	  //to lat2 se aktinia
      var lat2 = toRad(lat2);
       
	  //mathimatikos typos 
      var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
        Math.sin(dLon/2) * Math.sin(dLon/2) * Math.cos(lat1) * Math.cos(lat2); 
      var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
	  
	  //i apostasi se xiliometra
      var d = R * c;
	  
	  //epistrefetai i apostasi se metra 
      return d*1000;
    }

    //sinartisi i opoia pairnei san orisma mia timi kai epistrefi to apotelesma tis se aktinia
    function toRad(Value) 
    {
        return Value * Math.PI / 180;
    }





function getLocation() {
					
					if (navigator.geolocation) {
						navigator.geolocation.getCurrentPosition(initialize_map);
					} 
					else {
						
						console.log("ERRORRRRR");
						
						}
						}
						
function get_updated_location() {
					
					if (navigator.geolocation) {
						navigator.geolocation.getCurrentPosition(update_map);
					} 
					else {
						
						console.log("ERRORRRRR");
						
						}
						}						

function get_updated_location_cat() {
					
					if (navigator.geolocation) {
						navigator.geolocation.getCurrentPosition(update_map_cat);
					} 
					else {
						
						console.log("ERRORRRRR");
						
						}
						}	

function initialize_map(position) {


    document.getElementById('map2').style.display = "none";
	
	document.getElementById('new_search').style.display = "none";

					
							var mapOptions = {
					center: [position.coords.latitude, position.coords.longitude],
					zoom: 15
					}
					

					var map = new L.map('map', mapOptions);	

					var layer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
         
					map.addLayer(layer);	

					var marker = new L.Marker([position.coords.latitude, position.coords.longitude]);
					   
					   marker.bindPopup("You are here!!!");
					   
					   marker.addTo(map);
					   
					   marker.openPopup();
					   
					   
   //tis plirofories twn katastimatwn, kai tha dimiourgountai oi katalliloi markers panw ston xarti 
 
 //tha xrisimopoihsoume xmlhttprequest object 
 
				var xhttp = new XMLHttpRequest();
   
				xhttp.onreadystatechange = function() {
    
				if (this.readyState == 4 && this.status == 200) {
      
			//to json array to opoio exei epistrafei san apotelesma, egine pleon javascript array
			var mypoints = JSON.parse(xhttp.responseText);
	   
	   	   
			for(var i=0;i<mypoints.length;i++)
	   
			{
				   if (mypoints[i][5] =="No active offer")
				   
				   {

					var marker = new L.Marker([mypoints[i][3], mypoints[i][4]], {icon:redIcon});
					
					marker.addTo(map);
					
					}
					
					else
					
					{
					    var marker = new L.Marker([mypoints[i][3], mypoints[i][4]], {icon:greenIcon});
					
					marker.addTo(map);
					
					}
					
				    var mydist= getDistance(position.coords.latitude,position.coords.longitude,mypoints[i][3],mypoints[i][4]);
			  
			  
				if(mydist<500)
			  
				{
			  
					marker.bindPopup("Name:"+ mypoints[i][1] + "<br><br>"  +  mypoints[i][5]  +"<br><br>" + "<a href = 'add_offer.php?shop_id="+mypoints[i][0]+"'>"+"Add offer!!!</a>" + "<br><br>" + "<a  target = '_blank' href = 'rate_offers.php?shop_id="+mypoints[i][0]+"'>"+"Rate Offers!!!</a>");
			  
		  
	   
				}

			  
			 
			  
			  else
			  
			  {
			  
			    marker.bindPopup("Name:"+ mypoints[i][1] + "<br><br>" + mypoints[i][5]);

			  
			  
			  }


			   
		}
			  
	 
	   
	      
	   }
    
};
xhttp.open("GET", "info_points.php", true);
xhttp.send();
 
					   
			}
			
			
function update_map(position)

{

      document.getElementById('map').style.display = "none";
	  
	  document.getElementById('map2').style.display = "block";
	  
	  document.getElementById('mytable').style.display = "none";
	  

	  
	  document.getElementById('new_search').style.display = "block";



     
					
					//prosthetoume to vasiko layer to opoio periexei tin apeikonisi tou xarti 
					//map.addLayer(layer);



  		var mapOptions = {
					center: [position.coords.latitude, position.coords.longitude],
					zoom: 15
					}
					
  
					

					var map = new L.map('map2', mapOptions);	
					
					map.invalidateSize();

					
					
					

					var layer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
         
					map.addLayer(layer);	

					var marker = new L.Marker([position.coords.latitude, position.coords.longitude]);
					   
					   marker.bindPopup("You are here!!!");
					   
					   marker.addTo(map);
					   
					   marker.openPopup();



  var shop_name = document.getElementById("shop_name").value;
  
 
 
    var xhttp = new XMLHttpRequest();

     xhttp.onreadystatechange = function() {
    
	if (this.readyState == 4 && this.status == 200) 
	
	{

        var mypoints = JSON.parse(xhttp.responseText);
	
	
	    for(var i=0;i<mypoints.length;i++)
	   
			{
				   if (mypoints[i][5] =="No active offer")
				   
				   {

					var marker = new L.Marker([mypoints[i][3], mypoints[i][4]], {icon:redIcon});
					
					marker.addTo(map);
					
					}
					
					else
					
					{
					    var marker = new L.Marker([mypoints[i][3], mypoints[i][4]], {icon:greenIcon});
					
					marker.addTo(map);
					
					}
					
				    var mydist= getDistance(position.coords.latitude,position.coords.longitude,mypoints[i][3],mypoints[i][4]);
			  
			  
				if(mydist<500)
			  
				{
			  
					marker.bindPopup("Name:"+ mypoints[i][1] + "<br><br>"  +  mypoints[i][5]  +"<br><br>" + "<a href = 'add_offer.php?shop_id="+mypoints[i][0]+"'>"+"Add offer!!!</a>" + "<br><br>" + "<a  target = '_blank' href = 'rate_offers.php?shop_id="+mypoints[i][0]+"'>"+"Rate Offers!!!</a>");
			  
		  
	   
				}

			  
			 
			  
			  else
			  
			  {
			  
			    marker.bindPopup("Name:"+ mypoints[i][1] + "<br><br>" + mypoints[i][5]);

			  
			  
			  }


			   
		}

		
		
      
    }
};


xhttp.open("GET", "find_shops.php?name="+shop_name, true);
xhttp.send();
 
 
 


}

function update_map_cat(position)

{

      document.getElementById('map').style.display = "none";
	  
	  document.getElementById('map2').style.display = "block";
	  
	  document.getElementById('mytable').style.display = "none";
	  
	  
	  document.getElementById('new_search').style.display = "block";



     
					
					//prosthetoume to vasiko layer to opoio periexei tin apeikonisi tou xarti 
					//map.addLayer(layer);



  		var mapOptions = {
					center: [position.coords.latitude, position.coords.longitude],
					zoom: 15
					}
					
  
					

					var map = new L.map('map2', mapOptions);	
					
					map.invalidateSize();

					
					
					

					var layer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
         
					map.addLayer(layer);	

					var marker = new L.Marker([position.coords.latitude, position.coords.longitude]);
					   
					   marker.bindPopup("You are here!!!");
					   
					   marker.addTo(map);
					   
					   marker.openPopup();



  var cat_name = document.getElementById("cat_name").value;
  
 
 
    var xhttp = new XMLHttpRequest();

     xhttp.onreadystatechange = function() {
    
	if (this.readyState == 4 && this.status == 200) 
	
	{

        var mypoints = JSON.parse(xhttp.responseText);
	
	
	    for(var i=0;i<mypoints.length;i++)
	   
			{
				   if (mypoints[i][5] =="No active offer")
				   
				   {

					var marker = new L.Marker([mypoints[i][3], mypoints[i][4]], {icon:redIcon});
					
					marker.addTo(map);
					
					}
					
					else
					
					{
					    var marker = new L.Marker([mypoints[i][3], mypoints[i][4]], {icon:greenIcon});
					
					marker.addTo(map);
					
					}
					
				    var mydist= getDistance(position.coords.latitude,position.coords.longitude,mypoints[i][3],mypoints[i][4]);
			  
			  
				if(mydist<500)
			  
				{
			  
					marker.bindPopup("Name:"+ mypoints[i][1] + "<br><br>"  +  mypoints[i][5]  +"<br><br>" + "<a href = 'add_offer.php?shop_id="+mypoints[i][0]+"'>"+"Add offer!!!</a>" + "<br><br>" + "<a  target = '_blank' href = 'rate_offers.php?shop_id="+mypoints[i][0]+"'>"+"Rate Offers!!!</a>");
			  
		  
	   
				}

			  
			 
			  
			  else
			  
			  {
			  
			    marker.bindPopup("Name:"+ mypoints[i][1] + "<br><br>" + mypoints[i][5]);

			  
			  
			  }


			   
		}

		
		
      
    }
};


xhttp.open("GET", "find_shops_cat.php?name="+cat_name, true);
xhttp.send();
 
 
 


}			

		

getLocation();
 
 

</script>

<div id = 'new_search'> <a href = 'view_map_rescuer.php'> New Search </a> </div>


</body>


</html>