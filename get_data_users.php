<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();
    $tipe = isset($_SESSION['t']) ? $_SESSION['t'] : "";
    $id_user = isset($_SESSION['i']) ? $_SESSION['i'] : "";
/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simple to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */
include_once ("config/db.php");

// DB table to use
$table = 'users';
 
// Table's primary key
$primaryKey = 'user_id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$counter=0;

$id = isset($_GET['id']) ? $_GET['id'] : ""; 
$i=-1;
$columns = array(
    array(
        'db'        => 'user_id',
        'dt'        => ++$i,
        'formatter' => function( $d, $row ) {
            global $counter;
            return $counter++;
            //++$_SESSION["users"+$_SESSION['i']];
            // if (isset($_COOKIE["users"]))
            // {
            //     return ++$_COOKIE["users"];
            // }
            // else
            // {
            //     setcookie("users", 1, time() + (86400 * 30), "/"); // 86400 = 1 day
            // }
        }
    )
    ,array(
        'db'        => 'user_id',
        'dt'        => ++$i,
        'formatter' => function( $d, $row ) {
                    $tipe = isset($_SESSION['t']) ? $_SESSION['t'] : "";

                    if($tipe == "ADMIN")
                    {
                        return '<a href="index.php?page=profile&user_id='.$d.'" class="btn btn-primary"><span><i class="fa fa-eye"></i></span></a> | <a onclick="actiondelete(\'user\',\'user\','.$d.')" class="btn btn-danger"><span><i class="fa fa-trash"></i></span></a>' ;
                    }
                    else
                    {
                        return '<a href="index.php?page=profile&user_id='.$d.'" class="btn btn-primary"><span><i class="fa fa-eye"></i></span></a> ';
                        //| <a onclick="actiondelete(\'user\','.$d.')" class="btn btn-danger"><span><i class="fa fa-trash"></i></span></a>' ;    
                    }


        }
    ),
    array( 'db' => 'user_name', 'dt' => ++$i ),
    array( 'db' => 'user_nama',  'dt' => ++$i ),
    array( 'db' => 'user_hp',   'dt' => ++$i ),
    array( 'db' => 'user_email',   'dt' => ++$i ),
    array( 'db' => 'user_tipe',   'dt' => ++$i )
    ,array(
        'db'        => 'user_foto',
        'dt'        => ++$i,
        'formatter' => function( $d, $row ) {
            if($d)
            {//<img class="direct-chat-img" src="../dist/img/user3-128x128.jpg" alt="Message User Image">
                return '<img src="uploads/user/'.$d.'"  class="direct-chat-img" alt="User Image">';
            }
            else
            {
                return '<img src="uploads/user/avatar5.png" class="direct-chat-img" alt="User Image">';
            }
        }
    )
    // ,array(
    //     'db'        => 'salary',
    //     'dt'        => 5,
    //     'formatter' => function( $d, $row ) {
    //         return '$'.number_format($d);
    //     }
    // )
);
 

 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
 
require( 'ssp.class.php' );
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
    // SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns,null, $created_by ." AND user_status = 1" )

);