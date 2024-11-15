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
        <select name="continent">
            <?php
                # (3.2) Bucle while
                while( $registre = mysqli_fetch_assoc($resultat) )
                {
                    $continent = $registre["continent"];
                    echo "<option value='$continent'> $continent</option>";
                }
            ?>
        </select>
        <input type="submit" value="Tramet la consulta">
    </form>

    <?php
        if(isset($_GET["continent"])){

            $consulta = "SELECT name FROM country WHERE continent = '".$_GET["continent"]."';";

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

            echo "<ul>";

                # (3.2) Bucle while
                while( $registre = mysqli_fetch_assoc($resultat) )
                {
                    $countryName = $registre["name"];
                    echo "<li>$countryName</li>";
                }

            echo "</ul>";
            
        }
       

    ?>
    
 
 </body>
</html>