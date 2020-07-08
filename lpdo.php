<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>LPDO</title>
</head>
<body>
    <?php
        class lpdo
        {
            public $bdd = "";
            public $query = "";
            public $result = "";
            

            public function constructeur($host, $username, $password, $db)
            {
               $bdd = mysqli_connect($host, $username, $password, $db);
               $this->bdd = $bdd;
            }

            public function connect($host, $username, $password, $db)
            {
                if (!empty($this->bdd))
                {
                    mysqli_close($this->bdd);
                    $bdd = mysqli_connect($host, $username, $password, $db);
                    $this->bdd = $bdd;
                }
            }

            public function destructeur()
            {
                mysqli_close($this->bdd);
                $this->bdd = "";
            }

            public function close()
            {
                mysqli_close($this->bdd);
                $this->bdd = "";
            }

            public function execute($query)
            {
                $this->query = $query;
                $execute = mysqli_query($this->bdd, $query);
                $result = mysqli_fetch_assoc($execute);

                $this->result = $result;
                return $result;
            }

            public function getLastQuery()
            {
                if (!empty($this->query))
                {
                    return $query;
                }
                else
                {
                    return FALSE;
                }
            }

            public function getLastResult()
            {
                if (!empty($this->result))
                {
                    return $result;
                }
                else
                {
                    return FALSE;
                }
            }
            
            public function getTables()
            {
                if (!empty($this->bdd))
                {
                    $tables = "SHOW tables FROM '$db' ";
                    $tables_query = mysqli_query($this->$bdd, $tables);
                    $recup_tab = mysqli_fetch_assoc($tables_query);

                    return $recup_tab;
                }
            }

            public function getFields($table)
            {
                function verif_tab($table, $db)
                {
                    // recup et verifie que la tab existe dans la bdd
                    $afficher_tab = "SHOW TABLES FROM $db";
                    $affichage_query = mysql_query($afficher_tab);
                    
                    $tables = array();
                    while($row = mysql_fetch_row($affichage_query)){
                        $tables[] = $row[0];
                    }
                    
                    if(in_array($table, $tables))
                    {
                        return TRUE;
                    }
                }

                if (verif_tab($table, $db) == TRUE)
                {
                    verif_tab($table, $db);
                    $champs = "SHOW COLUMNS FROM '$table' ";
                    $champs_query = mysqli_query($this->$bdd, $champs);
                    $champs_recup = mysqli_fetch_assoc($champs_query);

                    return $champs_recup;
                }
                else
                {
                    return FALSE;
                }
            }
        }

        $lpdo = new lpdo;

        $bdd_co = $lpdo->constructeur('localhost', 'root', '', 'classes');

        // connect('localhost', 'root', '', 'classes');

        // destructeur();

        // close();

        $req = $lpdo->execute("SELECT * FROM utilisateurs");
        var_dump($req);

        $req_bis = $lpdo->getLastQuery();
        var_dump($req_bis);

        $resultat = $lpdo->getLastResult();
        var_dump($resultat);

        $tab = $lpdo->getTables();
        var_dump($tab);

        $fields = $lpdo->getFields('utilisateurs');
        var_dump($fields);


    ?>
</body>
</html>