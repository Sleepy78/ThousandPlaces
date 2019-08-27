<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>ThousandPlaces</title>
<link
	href="https://leafletjs-cdn.s3.amazonaws.com/content/leaflet/master/leaflet.css"
	rel="stylesheet" type="text/css" />

<style type="text/css">
body {
	margin: 0;
}

#map {
	width: 80vw;
	height: 80vh;
}
</style>
</head>
<body>

		<?php
$serveur = "localhost";
$login = "sleepy";
$pass = "sleepypwd";

try {
    $connexion = new PDO("mysql:host=$serveur;dbname=id7240383_specialp", $login, $pass);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    /*echo 'Connexion BDD OK';
    $codesql = "SELECT nom FROM user";
    $requete = $connexion->prepare($codesql);
    $requete->execute();

    $result = $requete->fetchall(PDO::FETCH_COLUMN, 0);

    echo '<pre>';
    print_r($result);
    echo '</pre>';
*/
} catch (PDOException $e) {
    
    echo 'Connexion BDD KO ' . $e->getMessage();
}

    $requeteAllPlaces = $connexion->prepare("SELECT titre,description,lat,lon FROM lieux ORDER BY id DESC");
    $requeteAllPlaces->execute();
    $resultAllPlaces = $requeteAllPlaces->fetchAll();
    

?>

<?php
    $id = $_GET["id"];
    echo "$id";
    /*$nom = $_POST['nom'];
    $password = $_POST['password'];
    $userExists=false;
    $userID=null;
    $requeteListAllUsers = $connexion->prepare("SELECT id,nom,prenom,email,password FROM user ORDER BY id DESC");
    $requeteListAllUsers->execute();
    $resultAllUsers = $requeteListAllUsers->fetchAll();
    
    foreach ($resultAllUsers as $val) {
        if($val[1]==$nom){
            //if(password_verify($password,$val[4]))
                $userExists=true;
                $userID=$val[0];
        }
    }
    if($userExists){
        print("OK $userID $nom $prenom");
    }else{
        header('Location: home.html');
        exit();
    }*/

?> 

<div id='map'></div>

	<script type="text/javascript"
		src="https://leafletjs-cdn.s3.amazonaws.com/content/leaflet/master/leaflet.js"></script>

	<script type="text/javascript"
		src="https://tiles.unwiredmaps.com/js/leaflet-unwired.js"></script>

	<script type="text/javascript">

    // Maps access token goes here
    var key = 'pk.9ea450765bb6982761cd7580dc73089a';

    // Add layers that we need to the map
    var streets = L.tileLayer.Unwired({key: key, scheme: "streets"});

    // Initialize the map
    var map = L.map('map', {
        center: [47.233018, 2.420128], // Map loads with this location as center
        zoom: 6,
        scrollWheelZoom: true,
        layers: [streets] // Show 'streets' by default
    });

    // Add the 'scale' control
    L.control.scale().addTo(map);

    // Add the 'layers' control
    L.control.layers({
        "Streets": streets
    }).addTo(map);

    var redIcon = L.icon({
      iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
      iconSize: [25, 41],
      iconAnchor: [12, 41],
      popupAnchor: [1, -34],
    });
    var greenIcon = L.icon({
      iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png',
      iconSize: [25, 41],
      iconAnchor: [12, 41],
      popupAnchor: [1, -34],
    });    
    
    var mark=[];
    var isVisited=[];
    <?php 
        $counter=0;
        foreach ($resultAllPlaces as $val) {
            echo "mark[$counter] = L.marker([". $val[2] .", ". $val[3] ."], {icon: redIcon})" ;
            echo ".addTo(map) " ;
            echo ".bindPopup(\"<b>". $val[0] ."</b><br>". $val[1] ."<br><input id=$counter onchange=onClickVu2($counter) type='checkbox'/>Vu\") " ;
            echo ".closePopup();". "\xA";
            //echo ".on('click', onClick); ". "\xA";
            
            $counter++;
        }
    ?>
    
    function onClick(e) {
      //alert("test");
      if(this.options.icon==redIcon){ 
          this.setIcon(greenIcon); 
      }else{ 
          this.setIcon(redIcon);   
      }    
    }

    function onClickVu2(e){
        
        if(document.getElementById(e).checked){
           mark[e].setIcon(greenIcon); 
           //isVisited[e] = true;

       }else{
           mark[e].setIcon(redIcon);
           //isVisited[e] = false;
       }
     }     
     
       function onClick2(e) { 

         if(isVisited[e]==true){
           document.getElementById(e).checked = true;
         }
       
       }  

       /*var command = L.control({position: 'topright'});
       command.onAdd = function (map) {
           var div = L.DomUtil.create('div', 'command');
           div.innerHTML += '<form><input id=1 type="checkbox"/>toto</form>';
           return div;
       };
       command.addTo(map);*/
</script>
</body>
</html>