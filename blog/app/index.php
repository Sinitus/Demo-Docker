<?php
session_start();
$pdo = new PDO("mysql:host=database;dbname=data", "root", "root");
if (isset($_POST['send'])){
    if (!empty($_POST['pseudo']) AND !empty($_POST['mdp'])){
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mdp = md5($_POST['mdp']);
        $insertUser = $pdo->prepare('INSERT INTO users(pseudo,mdp) VALUEs(?, ?)');
        $insertUser-> execute(array($pseudo, $mdp));

        $recupUser = $pdo->prepare('SELECT * FROM users WHERE pseudo = ? AND mdp = ?');
        $recupUser->execute(array($pseudo,$mdp));
        if($recupUser->rowCount()>0){
            $_SESSION['pseudo']= $pseudo;
            $_SESSION['mdp']= $mdp;
            $_SESSION['id']= $recupUser->fetch()['id'];
        }
    }else{
        echo "Veuillez remplir tout les champs pour continuer";
    }
}

if (isset($_POST['register'])){
    if (!empty($_POST['pseudo']) AND !empty($_POST['mdp'])){
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mdp = md5($_POST['mdp']);
        $recupUser = $pdo->prepare('SELECT * FROM users WHERE pseudo = ? AND mdp = ?');
        $recupUser->execute(array($pseudo, $mdp));

        if ($recupUser->rowCount()>0){
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['mdp'] = $mdp;
            $_SESSION['id'] = $recupUser->fetch()['id'];
            header('Location:page.php');

        }else{
            echo "Votre mot de passe ou votre pseudo est incorrect. Réssayez";
        }
    }else{
        echo "Veuillez remplir tout les champs pour continuer";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Telegraf</title>
</head>
<body>
    <h1 align="center">Bienvenue sur Telegraph !</h1>
    <h2 align="center">Se connecter </h2>
    <form method="POST" action="" align="center">
        <input type="text" name="pseudo" autocomplete="off">
        <br/>
        <input type="password" name="mdp" autocomplete="off">
        <br/><br/>
        <input type="submit" name="register" value="Se connecter">
    </form>
    <br/>
    <h2 align="center">Pas de compte ? Inscrivez vous !</h2>
    <form method="POST" action="" align="center">
        <input type="text" name="pseudo" autocomplete="off">
        <br/>
        <input type="password" name="mdp" autocomplete="off">
        <br/><br/>
        <input type="submit" name="send" value="S'inscrire">
    </form>

</body>
</html>