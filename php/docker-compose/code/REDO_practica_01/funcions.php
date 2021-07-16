<?php




    /**
    * Realizar doc de conexion, errors controlats
    * TODO realizar depuracion de errores
    */
    function errores($error_number, $error_string, $filename, $line_number){
        echo $error_number . "<br>";
        echo $error_string . "<br>";
        echo $filename . "<br>";
        echo $line_number . "<br>";

        $today = date("Y-m-d");

        $str = $error_number . ": " . $error_string . " in " . $filename . " at line " . $line_number . "\n";

        file_put_contents("logs/" . $today . ".txt", $str, FILE_APPEND);
    }


    /**
     * fA COINEXIO DE LA BASE DE DADES
     * 
     * @return: false or database connection
     * 
     */
    function conexion(){
        $Nameserver = "172.17.0.2";
        $Username = "root";
        $Password = "password";
        $Database = "linuga";

        $conexion = new mysqli($Nameserver, $Username, $Password, $Database);
        if (!$conexion) {
            set_error_handler("errores");
            echo ("We could not connect to the database. Error: ".mysqli_connect_errno(). " - ".$conexion->connect_error);
        }
        return $conexion;
    }


    /**
    *  Link de sortida
    */
    function sortir(){
        print_r("<p class='adv'>L'usuar@ ha sortit.</p>");
        header("refresh: 2; principal.php");
        session_destroy();
    }   

    function show_page_footer() {
        echo "
        <div class='page_footer'>This is the page footer for practica01</div>
        </body>
        </html>";
    }

    /**
     * show_page_header .... echos the HTML code that will always start the page
     * 
     */
    function show_page_header() {
        echo '<!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" type="text/css" href="css/general.css">
                <title>Pagina principal</title>
            </head>

            <body>
                <p class="link sep">Portal Lingua</p>';
    }

    /**
     * Pagina de login
     */
    function show_header_login($filename="index"){
        echo ('
            <div class="login_mostrar">
                <form action="'.$filename.'.php?entrada=verificar" method="post" enctype="multipart/form-data" name="form1">
                    <div class="caixa">
                        <div class="input-contenidor">
                            <p>Compte de mail: <input type="text" name="mail" placeholder="Mail" required></p>
                        </div>
                        <div class="input-contenidor">
                            <p>Password: <input type="text" name="pass" placeholder="Password" required></p> <!--El name se referencia $post --> 
                        </div>
                        <div class="links_mostrar">
                            <p><a href="'.$filename.'.php?entrada=registre">Encara no estas Registrat?</a></p>
                        </div>
                        <input type="submit" value="Aceptar" class="button">
                    </div>
                </form>
            </div>');
    }

    /**
     * Pagina links
     */
    function show_header_links($filename="index"){
        global $debug, $_SESSION;        
        if (isset($debug)) {
            echo "Session Header Links: ".session_id()." - ".$_SESSION['mail'];
        }
        print_r('<p class="link"><a href="'.$filename.'.php?entrada=tabla">Veure persones que em poden ajudar</a></p>');
        print_r('<p class="link"><a href="'.$filename.'.php?entrada=baixa">Donar-me de baixa</a></p>');
        print_r('<p class="link"><a href="'.$filename.'.php?entrada=sortir">Sortir</a></p>');
    }

    /**
     * Pagina registres
     */
    function show_header_register($filename="index"){
        if (!isset($_POST["new_mail"])) {
            echo '
            <div class="registre_mostrar">
                <form action="'.$filename.'.php?entrada=crear" method="post" enctype="multipart/form-data">
                    <div class="caixa">
                        <div class="input-contenidor">
                            <p>Compte de mail: <input name="new_mail" type="text" placeholder="Mail" required></p>
                        </div>
                        <div class="input-contenidor">
                            <p>Password: <input name="new_pass" type="text" placeholder="Password" required></p>
                        </div>
                        <div class="input-contenidor">
                            <p>Nom: <input name="new_nom" type="text" placeholder="Nom" required></p>
                        </div>
                        <div class="input-contenidor">
                            <label for="new_lang" >Idioma natiu: </label>
                            <select name="new_lang" id="new_lang" required>
                            <option value="Espanyol">Espanyol</option>
                            <option value="Angles">Angles</option>
                            <option value="Francés">Francés</option>
                            <option value="Alemany">Alemany</option>
                            </select>
                        </div>
                        <div class="input-contenidor">
                            <label for="new_lang_prac" >Idioma a practicar: </label>
                            <select name="new_lang_prac" id="new_lang_prac" required>
                            <option value="Espanyol">Espanyol</option>
                            <option value="Angles">Angles</option>
                            <option value="Francés">Francés</option>
                            <option value="Alemany">Alemany</option>
                            </select>
                        </div>
                        <input name="enviarform" type="submit" value="Aceptar" class="button">
                    </div>
                        <p class="adv"><a href="'.$filename.'.php">Return</a></p>
                </form>
            </div>';
        } 
        else {
            echo "Usuario creado";
        }
    }


    function execute_sql($sql="") {
        $result = mysqli_query(conexion(), $sql);
        $res = mysqli_query(conexion(), $sql);
        if (5==3) {
            echo "we had an error asking the database. Pls do not worry! this is our problem. We informed a bunch of trained monkeys already.";
            // Send an email to admin ... so he/she can fix the error
            exit(2);
        }
        return $result;
    }


    /**
     * On s'afegeixen usuaris
     */
    function add_new_users($filename="index"){
        $sql = "INSERT INTO usuaris (email, pass, nom, idioma_natiu, idioma_aprendre)
                VALUES ('".$_POST['new_mail']."', '".$_POST['new_pass']."', '".$_POST['new_nom']."', '".$_POST['new_lang'] . "', '".$_POST['new_lang_prac']."');";

        if (execute_sql($sql)) {
            header("refresh: 2; '.$filename.'.php");
            echo ("<p class='p'>Has creat l'usuari satisfactoriament.</p>");
        } else {
            header("refresh: 2; '.$filename.'.php?entrada=registre");
            echo ("<pL class='p adv'>L'usuari que vols afegir ja existeix.</span></p>");
        }
    }

    /**
     * Eliminacio dels usuaris
     */
    function delete_users($filename){
        echo (' 
                <form action="'.$filename.'.php?entrada=baixa">
                <table>
                    <tr><p>Usuari a eliminar</p></tr>
                    <td><input name="ok" type="checkbox"></td>
                    <td><p>' .$_SESSION['mail'] . '</p></td>
                    <td><input type="submit" class="button" name="enviarform" value="Esborrar"</td>
                </table>
                </form>');
        $sql = "SELECT from USUARIS where email = ('" . $_SESSION['mail'] . "');";
        $resultat = execute_sql($sql);
        $sql = "DELETE FROM usuaris WHERE email = ('" . $_SESSION['mail'] . "');";
        if (execute_sql($sql)) {
            session_destroy();
        }
    }



    /**
     * consulta especifica usuario
     */
    function query_general_users(){
        $sql = "SELECT * FROM usuaris WHERE email = '".$_SESSION['mail']."';";
        $cunsulta = execute_sql($sql);
        //assoc permite coger los datos de toda la  fila 
        return mysqli_fetch_assoc($cunsulta);
    }

    /**
     * Consulta de idioma_aprendre
     */
    function query_students(){
        $linia_usu = query_general_users();
        //La almacenamos dentro una variable para despues preguntar en la query
        $sql = "SELECT * FROM usuaris 
            WHERE (idioma_aprendre IN ('".$linia_usu["idioma_aprendre"]. "') 
                and (email != '" . $linia_usu["email"] . "')) ;";
        return execute_sql($sql);
    }

    /**
     * Sacar nombre on hi ha aprendre_idiomes
     */
    function charge_user_name(){
        $linia_usu = query_general_users();
        return $_SESSION['nom'] = $linia_usu['nom'];
    }

    /**
     * taula persones que poden ajudar
     */
    function show_table_students($filename="index"){
        print_r("<div class='tabla'>");
        print_r('Hola '.charge_user_name().' aqui et mostrem les persones que et poden ajudar:');
        print_r("<table class='idiomes'>");
        print_r("<tr>");
        print_r("<th>Nom</th>");
        print_r("<th>Email</th>");
        print_r("<th>idioma_natiu</th>");
        print_r("<th>idioma_aprendre</th>");
        print_r("</tr>");
        $resultat = query_students();
        $valor = mysqli_num_rows($resultat);
        if ($valor == false) { error_log("This goes to error_log of webserver"); exit(3); }
        for ($i = 0; $i < $valor; $i++) {
            print_r("<tr>");
            for ($i = 0; $i < $valor; $i++) {
                $linia = mysqli_fetch_assoc($resultat);
                print_r("<td>" . $linia['nom'] . "</td>");
                print_r("<td>" . $linia['email'] . "</td>");
                print_r("<td>" . $linia['idioma_natiu'] . "</td>");
                print_r("<td>" . $linia['idioma_aprendre'] . "</td>");
                print_r("</tr>");
            }
        }
        print_r("</table>");
        print_r('<p class="adv"><a href="'.$filename.'.php?entrada=link">Tornar al menu de link</a></p');
        print_r('</div>');
    }

    /**
    * Realiza una query de usuario, si existe redirecciona, si nó hará un exit 2.
    * - This function checks if the user exists
    * - if the user exists
    * 
    */
    function show_user_redirect($filename="index"){
        global $debug;
        $_SESSION['USER_LOGGED_IN']=false;

        if (isset($_POST['mail'])) { //saber si esta asignado un valor

            // If there is no session yet, then start one
            if ( session_id() == "" ) {
                session_start();
            }

            // Save incoming parameters to the session
            $_SESSION['mail'] = isset($_POST['mail']) ? $_POST['mail'] : NULL;
            $_SESSION['pass'] = isset($_POST['pass']) ? $_POST['pass'] : NULL;

            // Connect to database
            $conexion = conexion();
            $sql = mysqli_query($conexion, "SELECT * FROM usuaris 
                WHERE email = '" . $_SESSION['mail'] . "' 
                    AND pass = '" . $_SESSION['pass'] . "'");

            //realizar try catch futuro
            if (!$sql) {
                echo ('<div>"El usuario o contraseña no existen."</div>');+
                error_log("RALF exit 2 : ");
                exit(2);
            }


            //Si esta correcto el usuario redireccionará a página
            if ($user = mysqli_fetch_assoc($sql)) { 
                $_SESSION['USER_LOGGED_IN']=true;
                error_log("RALF exit 3 : ");
                header("Location: ".$filename.".php?entrada=link");
            } 

            error_log("RALF exit 4 : ");

        }
    }

    /**
     * Function to check user access ... if user has no access it says "No access" and stops"
     */
    function check_user_access() {
        global $_SESSION;
        if ($_SESSION['USER_LOGGED_IN']==false) {
            echo "Access denied. Please login.";
            exit(1);
        }
    }

    /**
     * function to act on incmoing paramters
     */
    function act_on_parameter($para)
    {
        
        error_log("RALF acting on parameter: ".$para);

        // Echo HTML for the page header
        switch ($para) {
            case "phpinfo":                
                phpinfo();
                exit;
            case 'verificar':
                show_user_redirect();
                break;
            case 'registre':
                show_header_register();
                break;
            case 'crear':
                add_new_users();
                break;
            case 'link':
                check_user_access();
                show_header_links();
                break;
            case 'tabla':
                check_user_access();
                show_table_students();
                break;
            case 'baixa':
                check_user_access();
                delete_users();
                break;
            case 'sortir':
                check_user_access();
                sortir();
                break;
            default:
                echo "Algo va mal";

        }
    }
?>