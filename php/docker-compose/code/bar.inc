<?php


/**
 * my Helloworld function
 * 
 * @author: Ralf Roeber
 * @since: 2021-05-08
 * @return: void
 * 
 */
function helloworld() {
    echo "<h1>Hello World!</h1>";
}


/**
 * 
 * 
 */
function show_date() {
    echo date('l jS \of F Y h:i:s A');
}

/**
 * 
 */
function define_header() {
    header("Refresh:0; url=foo.php");
    header("AMVARA: amo la informatica");
    header("X-Powered-By: AMVARA");
    header("Server: AMVARA");
}

function get_data_from_mysql($sql="") {

    $servername = "localhost";
    $username = "username";
    $password = "password";

    // Create connection
    $conn = new mysqli($servername, $username, $password);

    $sql = "SELECT * from mytable where username = '".$_GET['searchfield']."' ";


    mysqli_stmt_execute($sql);





    // ERROR_HANDLING

}

?>