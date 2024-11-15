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
</head>
<body>

    <form action="" method="GET">
        <input type="text" name="countrySubstring">
        <input type="submit">
    </form>

    <?php

        if (isset($_GET["countrySubstring"])){
            try {
                
                //preparem i executem la consulta
                $query = $pdo->prepare("SELECT ci.name AS city_name, co.name AS country_name FROM city ci, country co WHERE ci.CountryCode = co.Code AND co.Name LIKE '%".$_GET["countrySubstring"]."%';");
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

            echo "<ul>";
                foreach ($query as $row) {
                    echo "<li>".$row["city_name"]." - ".$row["country_name"]."</li>";
                }
            echo "</ul>";

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