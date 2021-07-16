<?php
    
    // debug=true ... outputs debugging information
    $debug=true; 

    // Before anything we need to get a session
    if(session_id() == "")
    {
        session_start();
    }



    // Include my functions
    include_once("funcions.php");

    // Open the database connection
    $database_connection = conexion();

    // Further execution is not usefull, if we do not have a database
    if (!$database_connection) { exit; }


    //inici sesio
    //crear cuenta
    //borrar cuenta
    //links
    //mirartabla

    /**
     * Users that are logged in have $_SESSION['USER_LOGGED_IN']=true;
     * Users that are not logged in have $_SESSION['USER_LOGGED_IN']=false; 
     */

    // If nothing comes in show login form
    if (!isset($_GET['entrada'])) { //mira si esta vacia o no
        // Output the default header
        show_page_header();
        show_header_login();
        show_page_footer();

        error_log("RALF Showing user form");
    } 
    
    // if user is logged in then act on parameters
    if ( isset($_GET['entrada']) ) {


        error_log("RALF Acting on parameter");
        act_on_parameter($_GET['entrada']);

    }


?>
