<?php
session_start();
require 'config/bdd.php';

if (($_SERVER['REQUEST_METHOD'] === "POST")) {


    //========Pour une connnexion============
    if (isset($_POST['submit'])) {
        //traitement de donnees
        $email = htmlspecialchars(trim($_POST['email']));
        $psd   = htmlspecialchars($_POST['pwd']);

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                if (password_verify($psd, $row['psd'])) {
                    $_SESSION['user_id'] = $row['user_id'];

                    //redirection 
                    header('location:index.php');
                    exit;
                } else {
                    $_SESSION['error'] = 'Erreur : Vos donnees ne correspondent pas ';
                    header('location:login.php');
                    exit;
                }
            } else {
                $_SESSION['error'] = 'Erreur : Vos donnees ne correspondent pas ';
                header('location:login.php');
                exit;
            }
        } else {
            $_SESSION['error'] = 'Donnees invalide';
            header('location:login.php');
            exit;
        }

        //=========Pour une creation de compte et connexion=======
    } elseif (isset($_POST['send'])) {

        //traitement de donnees
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars(trim($_POST['email']));
        $psd   = htmlspecialchars($_POST['pwd']);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error']  = 'Donnees invalides';
                header('location:signin.php');
                exit;
        } else {
            $sql_req = "SELECT * FROM users WHERE email = :email";
            $stmt = $conn->prepare($sql_req);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //verifier si l'email existe deja
            if ($row) {
                $_SESSION['error']  = 'Impossible d\'utiliser cet email';
                 header('location:signin.php');
                 exit;
            } else {
                $hashed_psd = password_hash($psd, PASSWORD_DEFAULT);

                $sql = "INSERT INTO users(name, email, psd) VALUES( :name, :email, :psd)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':psd', $hashed_psd);
                $stmt->execute();
                $_SESSION['user_id'] = $conn->lastInsertId();
                $_SESSION['email'] = $email;

                header('location:index.php');
                exit;
            }
        }
    }
}
