<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Job 01</title>
</head>
<body>
    <?php
        class userpdo
        {
            // création des attributs dans la class userpdo
            private $id = "";
            public $login = "";
            public $password = "";
            public $email = "";
            public $firstname = "";
            public $lastname = "";

            public function register($login, $password, $email, $firstname, $lastname)
            {
                $bdd = new PDO('mysql:host=localhost;dbname=classes', 'root', '');
                // ajouter un utilisateur a la bdd
                $insert = $bdd->prepare(" INSERT INTO utilisateurs (login, password, email, firstname, lastname) VALUES ('$login', '$password', '$email', '$firstname', '$lastname')");
                $insert->bindParam('login', $login);
                $insert->bindParam('password', $password);
                $insert->bindParam('email', $email);
                $insert->bindParam('firstname', $firstname);
                $insert->bindParam('lastname', $lastname);
                $insert->execute();
                
                // info du userpdo
                $info_user = $bdd->prepare(" SELECT * FROM utilisateurs ORDER BY id DESC ");
                $info = $info_user->execute();
                $donnees_user = $info_user->fetch(PDO::FETCH_ASSOC);
                
                $this->id = $donnees_user['id'];
                $this->login = $donnees_user['login'];
                $this->password = $donnees_user['password'];
                $this->email = $donnees_user['email'];
                $this->firstname = $donnees_user['firstname'];
                $this->lastname = $donnees_user['lastname'];
                
                return $donnees_user;
                var_dump($insert);
                var_dump($donnees_user);

            }


            public function connect($login, $password)
            {
                session_destroy();
                $bdd = new PDO('mysql:host=localhost;dbname=classes', 'root', '');
                // userpdo connecté
                session_start();
                
                // recup données
                $info_log = $bdd->prepare(" SELECT * FROM utilisateurs WHERE login = '$login' ");
                $log_query = $info_log->execute();
                $donnees_log = $info_log->fetch(PDO::FETCH_ASSOC);

                $this->id = $donnees_log['id'];
                $this->login = $donnees_log['login'];
                $this->password = $donnees_log['password'];
                $this->email = $donnees_log['email'];
                $this->firstname = $donnees_log['firstname'];
                $this->lastname = $donnees_log['lastname'];

                $_SESSION['id'] = $donnees_log['id'];
                $_SESSION['login'] = $donnees_log['login'];
                $_SESSION['password'] = $donnees_log['password'];
                $_SESSION['email'] = $donnees_log['email'];
                $_SESSION['firstname'] = $donnees_log['firstname'];
                $_SESSION['lastname'] = $donnees_log['lastname'];

                return $donnees_log;
            }

            public function disconnect()
            {
                // possible de rajouter une condition "If isset connect" ?
                session_destroy();
                $this->id = "";
                $this->login = "";
                $this->password = "";
                $this->email = "";
                $this->firstname = "";
                $this->lastname = "";
            }

            public function delete()
            {
                $id = $_SESSION['id'];
                $bdd = new PDO('mysql:host=localhost;dbname=classes', 'root', '');
                $delete_bdd = $bdd->prepare(" DELETE FROM utilisateurs WHERE id = '$id' ");
                $del_req = $delete_bdd->execute();
                
                session_destroy();
            }

            public function update($login, $password, $email, $firstname, $lastname)
            {
                $id = $_SESSION['id'];
                $bdd = new PDO('mysql:host=localhost;dbname=classes', 'root', '');
                $update_info = $bdd->prepare("UPDATE utilisateurs SET login = '$login', password = '$password', email = '$email', firstname = '$firstname', lastname = '$lastname' WHERE id = '$id' ");
                $up_query = $update_info->execute();

                // $this->id = "";
                $this->login = $login;
                $this->password = $password;
                $this->email = $email;
                $this->firstname = $firstname;
                $this->lastname = $lastname;
  
                // $_SESSION['id'] = elle ne bouge pas la session id;
                $_SESSION['login'] = $login;
                $_SESSION['password'] = $password;
                $_SESSION['email'] = $email;
                $_SESSION['firstname'] = $firstname;
                $_SESSION['lastname'] = $lastname;
            }

            public function isConnected()
            {
                if (isset($_SESSION['login']))
                {
                    $boleen = 'true';

                    $this->login = $_SESSION['login'];
                    $this->password = $_SESSION['password'];
                    $this->email = $_SESSION['email'];
                    $this->firstname = $_SESSION['firstname'];
                    $this->lastname = $_SESSION['lastname'];
                }
                else
                {
                    $boleen = 'false';                    
                }

                return $boleen;
            }

            public function getAllInfos()
            {
                $id = $_SESSION['id'];
                $bdd = new PDO('mysql:host=localhost;dbname=classes', 'root', '');
                $all_info = $bdd->prepare("SELECT * FROM utilisateurs WHERE id = '$id' ");
                $all_query = $all_info->execute();
                $infos = $all_info->fetch(PDO::FETCH_ASSOC);

                return $infos;
            }

            public function getLogin()
            {
                $login = $_SESSION['login'];
                $bdd = new PDO('mysql:host=localhost;dbname=classes', 'root', '');
                $log = $bdd->prepare(" SELECT login FROM utilisateurs WHERE login = '$login' ");
                $log_query = $log->execute();
                $recup_log = $log->fetch(PDO::FETCH_ASSOC);

                return $recup_log;
            }

            public function getEmail()
            {
                $login = $_SESSION['login'];
                $bdd = new PDO('mysql:host=localhost;dbname=classes', 'root', '');
                $mail = $bdd->prepare(" SELECT email FROM utilisateurs WHERE login = '$login' ");
                $mail_query = $mail->execute();
                $recup_mail = $mail->fetch(PDO::FETCH_ASSOC);

                return $recup_mail;
            }

            public function getFirstname()
            {
                $login = $_SESSION['login'];
                $bdd = new PDO('mysql:host=localhost;dbname=classes', 'root', '');
                $firstname = $bdd->prepare(" SELECT firstname FROM utilisateurs WHERE login = '$login' ");
                $firstname_query = $firstname->execute();
                $recup_firstname = $firstname->fetch(PDO::FETCH_ASSOC);

                return $recup_firstname;
            }

            public function getLastname()
            {
                $login = $_SESSION['login'];
                $bdd = new PDO('mysql:host=localhost;dbname=classes', 'root', '');
                $lastname = $bdd->prepare(" SELECT lastname FROM utilisateurs WHERE login = '$login' ");
                $lastname_query = $lastname->execute();
                $recup_lastname = $lastname->fetch(PDO::FETCH_ASSOC);

                return $recup_lastname;
            }

            public function refresh()
            {
                $id = $_SESSION['id'];
                $bdd = new PDO('mysql:host=localhost;dbname=classes', 'root', '');
                $infos = $bdd->prepare(" SELECT * FROM utilisateurs WHERE id = '$id' ");
                $infos_query = $infos->execute();
                $infos_log = $infos->fetch(PDO::FETCH_ASSOC);

                $this->id = $infos_log['id'];
                $this->login = $infos_log['login'];
                $this->password = $infos_log['password'];
                $this->email = $infos_log['email'];
                $this->firstname = $infos_log['firstname'];
                $this->lastname = $infos_log['lastname'];

                return $infos_log;
            }
        }
        $userpdo = new userpdo;
        // --------------fonction register--------------
        // $new_userpdo = $userpdo->register('Pascal', 'laplateforme', 'original@oui.io', 'Pascal', 'Geek');
        // var_dump($new_userpdo);

        // --------------fonction connect--------------
        $connexion = $userpdo->connect('Pascal', 'laplateforme');
        var_dump($connexion);

        // --------------fonction disconnect--------------
        $userpdo->disconnect();

        // --------------fonction delete--------------
        $userpdo->delete();

        // --------------fonction update--------------
        $userpdo->update('Terry', 'laplateforme_', 'tout@aussi.original', 'Terry', 'Geek');

        // --------------fonction isConnected--------------
        $deja_co = $userpdo->isConnected();
        var_dump($deja_co);

        // --------------fonction GetAllInfos--------------
        $fbi = $userpdo->getAllInfos();
        var_dump($fbi);

        // --------------fonction getLogin--------------
        $mister = $userpdo->getLogin();
        var_dump($mister);
        
        // --------------fonction getEmail--------------
        $abeille = $userpdo->getEmail();
        var_dump($abeille);

        // --------------fonction getfirstname--------------
        $vainqueur = $userpdo->getFirstname();
        var_dump($vainqueur);

        // --------------fonction getLastname--------------
        $perdant = $userpdo->getLastname();
        var_dump($perdant);
        
        // --------------fonction refresh--------------
        $chaleur = $userpdo->refresh();
        var_dump($chaleur);
        
        // var_dump($userpdo);
    ?>
</body>
</html>