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
    $prenom = $_POST['prenom'];
    $password = $_POST['password'];

    $requeteListAllUsers = $connexion->prepare("SELECT id,nom,prenom,email,password FROM user ORDER BY id DESC");
    $requeteListAllUsers->execute();
    $resultAllUsers = $requeteListAllUsers->fetchAll();
    $id=1;
    
    foreach ($resultAllUsers as $val) {
        if($val[1]==$nom && $val[2]==$prenom && password_verify($password,$val[4])){
            header("Location: mymaps.html?$val[0]");
            exit();
        }
        $id++;
    }
    
    if(!empty($id) && !empty($nom) && !empty($prenom) && !empty($password)){
        $passhash = password_hash($password,PASSWORD_DEFAULT);
        $requestInsertUser = $connexion->prepare("INSERT INTO `user`(`id`, `nom`, `prenom`, `password`) VALUES (:id,:nom,:prenom,:pass)");
        $requestInsertUser->bindParam(':id', $id);
        $requestInsertUser->bindParam(':nom', $nom);
        $requestInsertUser->bindParam(':prenom', $prenom);
        $requestInsertUser->bindParam(':pass', $passhash);
        
        $requestInsertUser->execute();
        
        echo "alert('Created!')";
        
        
    }else{
        header("Location: createaccount.html");
        exit();
    }

?>
</body>
</html>