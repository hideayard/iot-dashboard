<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once ('config/MysqliDb.php');
include_once ("config/db.php");
$db = new MysqliDb ('localhost', $dbuser, $dbpass, $dbname);
include("config/functions.php");

//  $sql = "SELECT a.*,b.*,ifnull(b.sensor_data_kwh,'-') as 'sensor_data_kwh' FROM `node` as a LEFT JOIN (SELECT * FROM sensor_data t1 WHERE t1.sensor_data_tanggal = (SELECT max(t2.sensor_data_tanggal) FROM sensor_data t2 WHERE t1.sensor_data_node_nama = t2.sensor_data_node_nama)  ) b ON b.sensor_data_node_nama = a.node_nama  where node_status = 1";
//  $hasil = $db->rawQuery($sql);
//     // var_dump($hasil);
//     echo json_encode($hasil);


 
function get_elapsed_time($then,$now,$format)
{
            $then = strtotime($then);
            //Calculate the difference.
            $difference = $now - $then;
            switch($format)
            {
              case 'jam' : {return floor($difference);}break;
              case 'menit' : {return floor($difference / 60);}break;
              case 'detik' : {return floor($difference / 60 / 60);}break;
            }
            //Convert seconds into minutes.
            
}

function date_getFullTimeDifference( $start, $end )
{
      $uts['start'] = strtotime( $start );
        $uts['end'] = strtotime( $end );
        if( $uts['start']!==-1 && $uts['end']!==-1 )
        {
            if( $uts['end'] >= $uts['start'] )
            {
                $diff    =    $uts['end'] - $uts['start'];
                if( $years=intval((floor($diff/31104000))) )
                    $diff = $diff % 31104000;
                if( $months=intval((floor($diff/2592000))) )
                    $diff = $diff % 2592000;
                if( $days=intval((floor($diff/86400))) )
                    $diff = $diff % 86400;
                if( $hours=intval((floor($diff/3600))) )
                    $diff = $diff % 3600;
                if( $minutes=intval((floor($diff/60))) )
                    $diff = $diff % 60;
                $diff    =    intval( $diff );
                $return_value = ( array('Tahun'=>$years,'Bulan'=>$months,'Hari'=>$days, 'Jam'=>$hours, 'Menit'=>$minutes) );//, 'Detik'=>$diff) );
                // var_dump($return_value);
                  $interval = "";
                  foreach($return_value as $key => $value)
                  {
                    if($value)
                    {
                      $interval .= " ".$value." ".$key;
                    }
                    
                  }
                  return $interval;
            }
            else
            {
                echo "Ending date/time is earlier than the start date/time";
            }
        }
        else
        {
            echo "Invalid date/time data detected";
        }
}   

$sql = "SELECT a.*,b.*,ifnull(b.sensor_data_kwh,'-') as 'sensor_data_kwh' FROM `node` as a LEFT JOIN (SELECT * FROM sensor_data t1 WHERE t1.sensor_data_tanggal = (SELECT max(t2.sensor_data_tanggal) FROM sensor_data t2 WHERE t1.sensor_data_node_nama = t2.sensor_data_node_nama)  ) b ON b.sensor_data_node_nama = a.node_nama  where node_status = 1";
$hasil = $db->rawQuery($sql);

$i=1;
$j=1;
//Get the current timestamp.
$now = time();
foreach ($hasil as $key => $value)
{ 
  switch($i)
  {
    case 1 :{$box_color = 'info';$btn_color = 'btn-info';$warna = 'blue';}break;
    case 2 :{$box_color = 'success';$btn_color = 'btn-success';$warna = 'green';}break;
    case 3 :{$box_color = 'warning';$btn_color = 'btn-warning';$warna = 'yellow';}break;
    case 4 :{$box_color = 'danger';$btn_color = 'btn-danger';$warna = 'red';}break;
  }
  
  $then = $value['sensor_data_tanggal'];
  $minutes = get_elapsed_time($then,$now,'menit');
  if($minutes<=5)
  {
      $status_koneksi = "Connected";
  }
  else
  {
    $status_koneksi = "Disconnected";
  }
  $date_b = new DateTime();
  if($value['node_cmd']==1)
  {
    if($value['node_time_on'])
    {
      $times = $value['node_time_on'];
        $skrg = (new DateTime())->format('Y-m-d H:i:s');
        $return_value =  date_getFullTimeDifference( $times , $skrg );
      $txt_elapsed = "On at ".(new \DateTime($value['node_time_on']))->format('H:i:s d-m-Y')." (".$return_value.")";
    }
    else
    {
      $txt_elapsed = " - ";
    }
  }
  else
  {
    if($value['node_time_off'])
    {
      $times = $value['node_time_off'];
        $skrg = (new DateTime())->format('Y-m-d H:i:s');
        $return_value =  date_getFullTimeDifference( $times , $skrg );
      $txt_elapsed = "Off at ".(new \DateTime($value['node_time_off']))->format('H:i:s d-m-Y')." (".$return_value.")";
    }
    else
    {
      $txt_elapsed = " - ";
    }
    
  }

  if($value['node_cmd'] == '1')
  {
    $class = "iconify"; 
    $data_icon = "ion-md-sunny";
    $check = "checked";
  
  }
  else{
    $class = "fa fa-lightbulb";
    $data_icon = "";
    $check = "";
  }

  $arr[] = 
  array("txt_id" => $value['node_id']
        ,"txt_nama"  => $value['node_nama']
        ,"txt_status"  => $status_koneksi
        ,"txt_onoffat"  => $txt_elapsed
        ,"txt_daya"  => $value['sensor_data_daya']
        ,"txt_tegangan"  => $value['sensor_data_voltase']
        ,"txt_arus"  => $value['sensor_data_arus']
        ,"txt_last_maintenance"  => $value['node_last_maintenance']
        ,"txt_timer_status"  => $value['node_timer_status']
        ,"txt_color"  => $box_color 
        ,"node_nama"  => $value['node_nama']
        ,"status_koneksi"  => $status_koneksi 
        ,"txt_elapsed"  => $txt_elapsed 
        ,"sensor_data_kwh"  => $value["sensor_data_kwh"] 
        ,"action_on_off"  => $check 
        // ,"node_nama".$j => $node_nama 
        // ,"node_nama".$j => $node_nama 
  
  );
  $j++;
  // echo "<input type='text' id='txt_id_".$j."' value='".$value['node_id']."' />";
  // echo "<input type='text' id='txt_nama_".$j."' value='".$value['node_nama']."' />";
  // echo "<input type='text' id='txt_status_".$j."' value='".$status_koneksi."' />";
  // echo "<input type='text' id='txt_onoffat_".$j."' value='".$txt_elapsed."' />";
  // echo "<input type='text' id='txt_daya_".$j."' value='".$value['sensor_data_daya']."' />";
  // echo "<input type='text' id='txt_tegangan_".$j."' value='".$value['sensor_data_voltase']."' />";
  // echo "<input type='text' id='txt_arus_".$j."' value='".$value['sensor_data_arus']."' />";
  // echo "<input type='text' id='txt_last_maintenance_".$j."' value='".$value['node_last_maintenance']."' />";
  // echo "<input type='text' id='txt_timer_status_".$j."' value='".$value['node_timer_status']."' />";
  // echo "<input type='text' id='txt_color_".$j."' value='".$box_color."' />"; 
  // echo "<hr>";

          }
          echo json_encode($arr);
          ?>