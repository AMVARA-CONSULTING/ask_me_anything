<?php

// AMA session 20.05.2021

// Reasons for using Transactions
// --> Consistency of data
// --> Speed up IO

// without Transactions

// --> update / insert ... tabla A (clientes) + B (pedidos)
// mysqli("insert into ... A ")
// mysqli("insert into ... B")

// Script housekeeping
// --> recreate index tabla A
// --> locks table A
// insert from before fails because table is locked

// with Transactions
// --> update / insert ... tabla A (clientes) + B (pedidos)
// transaction start
// mysqli("insert into ... A ")
// mysqli("insert into ... B ")
// transaction end
// --> fallan los dos ... because table A locked


// Locks : https://stackoverflow.com/questions/40544406/mysql-exclusive-lock#:~:text=Exclusive%20locks%20are%20described%20in,from%20reading%20the%20same%20row.

include_once(__DIR__."/../REDO_practica_01/funcions.php");
$dbcon = conexion();

// insert de 500.000
$number_of_statements=500000;
// echo "<h2>Without tansactions and each insert one line</h2>";
// echo "<pre>";
// echo date(DATE_RFC2822)."\n";
// for ($i=0;$i<$number_of_statements;$i++) {
//     // usuarios
//     $sql="insert into usuarios (email) values(".$i.")";
//     execute_sql($sql); // 10ms
// }
// echo date(DATE_RFC2822)."\n";
// echo "</pre>";

// insert de 500.000

echo "<h2>With tansactions and each insert contains 5000 values</h2>";
echo "<pre>";
echo "\n\n--> Transaction Start\n";
echo date(DATE_RFC2822)."\n";
// mysql transaction start

mysqli_query($dbcon, "START TRANSACTION");
$value_string="";
for ($i=0;$i<$number_of_statements;$i++) {
    // usuarios
    $value_string .= $i.",";
    if ( $i % 100000 ==0 )  {
        $sql="insert into usuarios (email) values(".substr($value_string,0,-1).")";
        execute_sql($sql); // --> RAM sala de espera
        mysqli_query($dbcon, "COMMIT");
        mysqli_query($dbcon, "START TRANSACTION");
        echo "Commit done \n";
    } 
}
// mysql transaction end
mysqli_query($dbcon, "COMMIT");
echo date(DATE_RFC2822)."\n";

?>