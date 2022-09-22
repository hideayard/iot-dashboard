<?php

include_once ("config/db.php");
// DB table to use
$table = 'data_sensors';
// Table's primary key
$primaryKey = 'id';

$kolom = ['id','s6','s7','s8','s9','remark','created_at'];
$i=-1;
$counter = 0;
$columns = array(
    array(
        'db'        => 'id',
        'dt'        => $kolom[++$i],
        'formatter' => function( $d, $row ) {
            global $counter;
            return ++$counter;
        }
    ),
    array( 'db' => $kolom[++$i] , 'dt' =>$kolom[$i] ),
    array( 'db' => $kolom[++$i] , 'dt' =>$kolom[$i] ),
    array( 'db' => $kolom[++$i] , 'dt' =>$kolom[$i] ),
    array( 'db' => $kolom[++$i] , 'dt' =>$kolom[$i] ),    
    array( 'db' => $kolom[++$i] , 'dt' =>$kolom[$i] ),
    array( 'db' => $kolom[++$i] , 'dt' =>$kolom[$i] ),

);

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
require( 'ssp.class.php' );
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
    // SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns,null, $created_by ." AND role_status = 1" )

);