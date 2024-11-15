<!-- 
    SELECT ci.name FROM city ci, country co WHERE ci.CountryCode = co.Code AND co.Name = 'Spain';
    SELECT ci.name FROM city ci JOIN country co ON ci.CountryCode = co.Code WHERE co.Name = 'Spain'; 
-->     

<?php
    try {
        $hostname = "localhost";
        $dbname = "mundo";
        $username = "admin";
        $pw = "admin123";
        $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
    } catch (PDOException $e) {
        echo "Error connectant a la BD: " . $e->getMessage() . "<br>\n";
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>

        table, td, th {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th, td {
            padding: 5px;
        }

        th {
            font-size: 1.5rem;
            font-weight: bold;
        }

    </style>
</head>
<body>

    <form action="" method="GET">
        <input type="text" name="countrySubstring">
        <input type="submit">
    </form>
    <br>
    <?php

        if (isset($_GET["countrySubstring"])){
            try {
                
                //preparem i executem la consulta
                $query = $pdo->prepare("SELECT co.name, cl.language, cl.isofficial, cl.percentage FROM country co, countrylanguage cl WHERE co.code = cl.countrycode AND co.name LIKE '%".$_GET["countrySubstring"]."%';");
                $query->execute();

            } catch (PDOException $e) {

                echo "Error de SQL<br>\n";
                //comprovo errors:
                $e = $query->errorInfo();
                if ($e[0]!='00000') {
                    echo "\nPDO::errorInfo():\n";
                    die("Error accedint a dades: " . $e[2]);
                }  
                
            }

            echo "<table>";

                echo "<tr>";
                    echo "<th>Country</th>";
                    echo "<th>Idioma</th>";
                    echo "<th>Es oficial?</th>";
                    echo "<th>% population</th>";
                echo "</tr>";

                foreach ($query as $row) {
                   
                    $isOfficial = "";
                    if ($row["isofficial"] == "T"){
                        $isOfficial = "Oficial";
                    } else {
                        $isOfficial = "No oficial";
                    }

                    echo "<tr>";
                        echo "<td>".$row["name"]."</td>";
                        echo "<td>".$row["language"]."</td>";
                        echo "<td>".$isOfficial."</td>";
                        echo "<td>".$row["percentage"]."</td>";
                    echo "</tr>";
                }

            echo "</table>";

            // eliminem els objectes per alliberar memòria 
            unset($pdo); 
            unset($query);

            // connexió dins block try-catch:
            // prova d'executar el contingut del try
            // si falla executa el catch

            // anem agafant les fileres d'amb una amb una
            // $row = $query->fetch();
            // while ( $row ) {
            //     echo " - " . $row['name']. "<br/>";
            //     $row = $query->fetch();
            // }
            
            // versió alternativa amb foreach
            // foreach ($query as $row) {
            //     echo $row['i']." - " . $row['a']. "<br/>";
            // }
            
            
           
        }
    
    ?>
</body>
</html>