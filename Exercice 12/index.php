<?php

//Ajouter un animal dans la BDD

//appel des variables
if(
    isset($_GET['name']) &&
    isset($_GET['species']) &&
    isset($_GET['birthdate'])
){
    //bloc des vérifs
    if(!preg_match('/^[a-z áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ\']{2,60}$/i' , $_GET['name'])){
        $errors[] = 'Nom est invalide';
    }
    if(!preg_match('/^[a-z áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ\']{2,60}$/i' , $_GET['species'])){
        $errors[] = 'Espèce est invalide';
    }
    if (preg_match('/([012]?[1-9]|[12]0|3[01])\/(0?[1-9]|1[012])\/([0-9]{4})/', $_GET['birthdate'])){
        $errors[] = 'La date de naissance est invalide';
    }

    //si pas d'erreurs
    if(!isset($errors)){

        //connexion à la base de données
        try{

            $bdd = new PDO('mysql:host=localhost;dbname=review_animals;charset=utf8', 'root' , '');

            //affichage des erreurs SQL si il y en a
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch(Exception $e){

            die('Problème avec la bdd : ' . $e->getMessage());
        }

        //requête préparée pour insérer l'animal
        $response = $bdd->prepare("INSERT INTO animals (name, species, birthdate) VALUES (?, ?, ?)");

        $response->execute([
            $_GET['name'],
            $_GET['species'],
            $_GET['birthdate'],
        ]);

        //si l'insertion a réussi on crée un message de succès sinon message d'erreur
        if($response->rowCount() > 0){
            $successMessage = 'L\'animal a bien été crée !';
        }else{
            $errors[] = 'Problème avec la base de données, veuillez ré-essayer';
        }

        //fermeture de la requête
        $response->closeCursor();
    }
}

?>

<?php

//Lister les animaux de la BDD

// Connexion à la BDD
try{
    $bdd = new PDO('mysql:host=localhost;dbname=review_animals;charset=utf8', 'root', '');
} catch(Exception $e){
    die('Problème avec la base de donnée : ' . $e->getMessage());
}

//récupération des animaux
$response = $bdd->query('SELECT * FROM animals');

//récupération des animaux sous forme d'un tableau associatif
$animals = $response->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les animaux</title>
</head>
<body>

    <?php
    //on affiche les erreurs si il y en a
    if(isset($errors)){
        foreach($errors as $error){
            echo '<p style="color:red;">' . $error . '</p>';
        }
    }
    if(isset($successMessage)){
        echo '<p style=color:green;">' . $successMessage . '</p>';
    } else{
        ?>
        <!--Formulaire-->
        <form action='' method='GET'>
            <input type="text" name="name" placeholder="ex:Minou">
            <input type="text" name="species" placeholder="ex:chat">
            <input type="text" name="birthdate" placeholder="ex:10/10/2010">
            <input type="submit">
        </form>

        <?php
    }
    ?>

    <!--Tableau listant tous les animaux ajoutés à la bdd-->
    <h2>Liste des animaux</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Species</th>
                <th>Birthdate</th>
            </tr>
        </thead>
        <tbody>
        <?php
        //si il y a des erreurs, on les affiche, sinon on affiche les animaux
        if(isset($errors)){
            foreach($errors as $error){
                echo '<p style="color:red;">' . $error . '</p>';
            }
        } else {
            foreach($animals as $animal){
                ?>
                <tr>
                    <td><?php echo htmlspecialchars( $animal['name'] ); ?></td>
                    <td><?php echo htmlspecialchars( $animal['species'] ); ?></td>
                    <td><?php echo htmlspecialchars( $animal['birthdate'] ); ?></td>
                </tr>
                <?php
            }
        
        }
        ?>
        </tbody>
        
    </table>
    
    
</body>
</html>