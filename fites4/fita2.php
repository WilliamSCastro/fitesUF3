<html>
 <head>
 	<title>Exemple de lectura de dades a MySQL</title>
 	<style>
 		body{
 		}
 		table,td {
 			border: 1px solid black;
 			border-spacing: 0px;
 		}
 	</style>
 </head>
 
 <body>
 	<h1>Exemple de lectura de dades a MySQL</h1>
 
 	<?php
 		# (1.1) Connectem a MySQL (host,usuari,contrassenya)
 		$conn = mysqli_connect('localhost','admin','admin123');
 
 		# (1.2) Triem la base de dades amb la que treballarem
 		mysqli_select_db($conn, 'mundo');
 
 		# (2.1) creem el string de la consulta (query)
 		$consulta = "SELECT DISTINCT continent FROM country;";
 		# (2.2) enviem la query al SGBD per obtenir el resultat
 		$resultat = mysqli_query($conn, $consulta);
 		# (2.3) si no hi ha resultat (0 files o bé hi ha algun error a la sintaxi)
 		#     posem un missatge d'error i acabem (die) l'execució de la pàgina web
 		if (!$resultat) {
     			$message  = 'Consulta invàlida: ' . mysqli_error($conn) . "\n";
     			$message .= 'Consulta realitzada: ' . $consulta;
     			die($message);
 		}
 	?>

    <form action="" method="GET">
            <?php
                # (3.2) Bucle while
                while( $registre = mysqli_fetch_assoc($resultat) ) {
                    $continent = $registre["continent"];
                    echo "<label for='$continent'>$continent</label>";
                    echo "<input type='checkbox' name='continents[]' value='$continent' />";
                    echo "<br>";
                }
            ?>
        <input type="submit" value="Tramet la consulta">
    </form>

    <?php
        if(isset($_GET["continents"])){

 
            echo "<ul>";
            $continents = $_GET["continents"];
            
        // FORMA 1: TANTAS CONSULTAS COMO CONTINENTES HAY

            // foreach ($continents as $continentWhereClause) {

            //     $consulta = "SELECT name FROM country WHERE continent = '".$continentWhereClause."';";
            //     # (2.2) enviem la query al SGBD per obtenir el resultat
            //     $resultat = mysqli_query($conn, $consulta);
            //     # (2.3) si no hi ha resultat (0 files o bé hi ha algun error a la sintaxi)
            //     #     posem un missatge d'error i acabem (die) l'execució de la pàgina web
            //     if (!$resultat) {
            //             $message  = 'Consulta invàlida: ' . mysqli_error($conn) . "\n";
            //             $message .= 'Consulta realitzada: ' . $consulta;
            //             echo "<p>$message</p>";
            //             die($message);
            
            //     }

            //     while( $registre = mysqli_fetch_assoc($resultat) ) {
            //         echo "<li>".$registre["name"]."</li>";
            //     }
            // }

        // FORMA 2: IN....
            $countriesString = "'".implode("', '",  $continents)."'";
            $consulta = "SELECT name FROM country WHERE continent IN ($countriesString);";

            # (2.2) enviem la query al SGBD per obtenir el resultat
            $resultat = mysqli_query($conn, $consulta);
            # (2.3) si no hi ha resultat (0 files o bé hi ha algun error a la sintaxi)
            #     posem un missatge d'error i acabem (die) l'execució de la pàgina web
            if (!$resultat) {
                    $message  = 'Consulta invàlida: ' . mysqli_error($conn) . "\n";
                    $message .= 'Consulta realitzada: ' . $consulta;
                    echo "<p>$message</p>";
                    die($message);
        
            }

            while( $registre = mysqli_fetch_assoc($resultat) ) {
                    $countryName = $registre["name"];
                    echo "<li>$countryName</li>";
            }


            echo "</ul>";   
            
        }
    

    ?>
    
 
 </body>
</html>