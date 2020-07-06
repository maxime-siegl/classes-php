<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Job 01</title>
</head>
<body>
    <?php
        class user
        {
            // création des objets dans la class user
            private $id = "";
            public $login = "";
            public $password = "";
            public $email = "";
            public $firstname = "";
            public $lastname = "";

            public function register($login, $password, $email, $firstname, $lastname)
            {
                $bdd = mysqli_connect('localhost', 'root', '', 'classes');
                // ajouter un utilisateur a la bdd
                $insert = "INSERT INTO utilisateurs (login, password, email, firstname, lastname) VALUES ('$login', '$password', '$email', '$firstname', '$lastname')";
                $insert_query = mysqli_query($bdd, $insert);
                
                // info du user
                $bdd = mysqli_connect('localhost', 'root', '', 'classes');
                $info = "SELECT * FROM utilisateurs ORDER BY id DESC";
                $info_query = mysqli_query($bdd, $info);
                $utilisateur = mysqli_fetch_assoc($info_query);
                
                $this->id = $utilisateur['id'];
                $this->login = $utilisateur['login'];
                $this->password = $utilisateur['password'];
                $this->email = $utilisateur['email'];
                $this->firstname = $utilisateur['firstname'];
                $this->lastname = $utilisateur['lastname'];
                
                return $utilisateur;
            }


            public function connect($login, $password)
            {
                session_destroy();
                $bdd = mysqli_connect('localhost', 'root', '', 'classes');
                // user connecté
                session_start();
                
                // recup données
                $info_log = "SELECT * FROM utilisateurs WHERE login = '$login' ";
                $log_query = mysqli_query($bdd, $info_log);
                $recup_info = mysqli_fetch_assoc($log_query);

                $this->id = $recup_info['id'];
                $this->login = $recup_info['login'];
                $this->password = $recup_info['password'];
                $this->email = $recup_info['email'];
                $this->firstname = $recup_info['firstname'];
                $this->lastname = $recup_info['lastname'];

                $_SESSION['id'] = $recup_info['id'];
                $_SESSION['login'] = $recup_info['login'];
                $_SESSION['password'] = $recup_info['password'];
                $_SESSION['email'] = $recup_info['email'];
                $_SESSION['firstname'] = $recup_info['firstname'];
                $_SESSION['lastname'] = $recup_info['lastname'];

                return $recup_info;
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
                $bdd = mysqli_connect('localhost', 'root', '', 'classes');
                $delete_bdd = "DELETE FROM utilisateurs WHERE id = '$id' ";
                $del_req = mysqli_query($bdd, $delete_bdd);
                
                session_destroy();
            }

            public function update($login, $password, $email, $firstname, $lastname)
            {
                $id = $_SESSION['id'];
                $bdd = mysqli_connect('localhost', 'root', '', 'classes');
                $update_info = "UPDATE utilisateurs SET login = '$login', password = '$password', email = '$email', firstname = '$firstname', lastname = '$lastname' WHERE id = '$id' ";
                $up_query = mysqli_query($bdd, $update_info);

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
                $bdd = mysqli_connect('localhost', 'root', '', 'classes');
                $all_info = "SELECT * FROM utilisateurs WHERE id = '$id' ";
                $all_query = mysqli_query($bdd, $all_info);
                $infos = mysqli_fetch_assoc($all_query);

                return $infos;
            }

            public function getLogin()
            {
                $login = $_SESSION['login'];
                $bdd = mysqli_connect('localhost', 'root', '', 'classes');
                $log = "SELECT login FROM utilisateurs WHERE login = '$login' ";
                $log_query = mysqli_query($bdd, $log);
                $recup_log = mysqli_fetch_assoc($log_query);

                return $recup_log;
            }

            public function getEmail()
            {
                $login = $_SESSION['login'];
                $bdd = mysqli_connect('localhost', 'root', '', 'classes');
                $mail = "SELECT email FROM utilisateurs WHERE login = '$login' ";
                $mail_query = mysqli_query($bdd, $mail);
                $recup_mail = mysqli_fetch_assoc($mail_query);

                return $recup_mail;
            }

            public function getFirstname()
            {
                $login = $_SESSION['login'];
                $bdd = mysqli_connect('localhost', 'root', '', 'classes');
                $firstname = "SELECT firstname FROM utilisateurs WHERE login = '$login' ";
                $firstname_query = mysqli_query($bdd, $firstname);
                $recup_firstname = mysqli_fetch_assoc($firstname_query);

                return $recup_firstname;
            }

            public function getLastname()
            {
                $login = $_SESSION['login'];
                $bdd = mysqli_connect('localhost', 'root', '', 'classes');
                $lastname = "SELECT lastname FROM utilisateurs WHERE login = '$login' ";
                $lastname_query = mysqli_query($bdd, $lastname);
                $recup_lastname = mysqli_fetch_assoc($lastname_query);

                return $recup_lastname;
            }

            public function refresh()
            {
                $id = $_SESSION['id'];
                $bdd = mysqli_connect('localhost', 'root', '', 'classes');
                $infos = "SELECT * FROM utilisateurs WHERE id = '$id' ";
                $infos_query = mysqli_query($bdd, $infos);
                $infos_log = mysqli_fetch_assoc($infos_query);

                $this->id = $infos_log['id'];
                $this->login = $infos_log['login'];
                $this->password = $infos_log['password'];
                $this->email = $infos_log['email'];
                $this->firstname = $infos_log['firstname'];
                $this->lastname = $infos_log['lastname'];

                return $infos_log;
            }
        }
        $user = new user;
        // --------------fonction register--------------
        $new_user = $user->register('Ivan', 'mdp', 'original@oui.io', 'Alban', 'LeRusse');
        var_dump($new_user);

        // --------------fonction connect--------------
        $connexion = $user->connect('Ivan', 'mdp');
        var_dump($connexion);

        // --------------fonction disconnect--------------
        $user->disconnect();

        // --------------fonction delete--------------
        $user->delete();

        // --------------fonction update--------------
        $user->update('Albert', 'reporter', '7.ans@et.demi', 'Jean-paul', 'Dupontdeligonesse');

        // --------------fonction isConnected--------------
        $deja_co = $user->isConnected();
        var_dump($deja_co);

        // --------------fonction GetAllInfos--------------
        $fbi = $user->getAllInfos();
        var_dump($fbi);

        // --------------fonction getLogin--------------
        $mister = $user->getLogin();
        var_dump($mister);
        
        // --------------fonction getEmail--------------
        $abeille = $user->getEmail();
        var_dump($abeille);

        // --------------fonction getfirstname--------------
        $vainqueur = $user->getFirstname();
        var_dump($vainqueur);

        // --------------fonction getLastname--------------
        $perdant = $user->getLastname();
        var_dump($perdant);
        
        // --------------fonction refresh--------------
        $chaleur = $user->refresh();
        var_dump($chaleur);
        
        // var_dump($user);
    ?>
</body>
</html>