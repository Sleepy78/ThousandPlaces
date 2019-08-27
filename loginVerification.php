<html>
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

    $nom = $_POST['nom'];
    $password = $_POST['password'];
    
    $requeteListAllUsers = $connexion->prepare("SELECT id,nom,prenom,email,password FROM user ORDER BY id DESC");
    $requeteListAllUsers->execute();
    $resultAllUsers = $requeteListAllUsers->fetchAll();
    
    foreach ($resultAllUsers as $val) {

        if($val[1]==$nom && password_verify($password,$val[4])){
            header("Location: mymap.php?id=$val[0]");
            exit();
        }
    }
    
    header("Location: home.html");
    exit();

?>
</body>
</html>