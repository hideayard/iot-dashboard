<?php
$formatted = [];
$formatted2 = [];
$formatted3 = [];
$formatted4 = [];
$limit = 1;
$db = new MysqliDb ('localhost', $dbuser, $dbpass, $dbname);
$db->autoReconnect = false;

$db2 = new MysqliDb ('localhost', $dbuser, $dbpass, $dbname);
$db2->autoReconnect = false;
// $db->where ('remark', '');
// $count = $db->getValue ("bot", "count(*)");
$db->orderBy("created_at","Desc");
$db->pageLimit = $limit;
// $results_pressure = $db->get ('pressure');
$page = 1;
// set page limit to 2 results per page. 20 by default
$results_pressure = $db->arraybuilder()->paginate("data_sensors", $page);
// echo "showing $page out of " . $db->totalPages;
// var_dump($results_pressure);
$i=0;
foreach($results_pressure as $key => $value)
{
  $formatted[] = floatval($value['s1']);
  $formatted[] = floatval($value['s2']);
  $formatted[] = floatval($value['s3']);
  $formatted[] = floatval($value['s4']);

  $formatted2[] = floatval($value['s5']);
  // $formatted2[] = floatval($value['s6']);
  // $formatted2[] = floatval($value['s7']);
  // $formatted2[] = floatval($value['s8']);
  $i++;
}
$json_hasil = json_encode($formatted);
// var_dump($json_hasil);
////==========================================
$db2->orderBy("created_at","Desc");
$db2->where("remark", "esp1");
$db2->pageLimit = $limit;
$page = 1;
$results_esp1 = $db2->arraybuilder()->paginate("flowrate", $page);

$i=0;
foreach($results_esp1 as $key => $value)
{
  $formatted3[] = floatval($value['con']);
  $formatted3[] = floatval($value['flow']);
  $i++;
}
$json_hasil2 = json_encode($formatted2);
////==========================================
$db2->orderBy("created_at","Desc");
$db2->where("remark", "esp2");
$db2->pageLimit = $limit;
$page = 1;
$results_esp2 = $db2->arraybuilder()->paginate("flowrate", $page);

$i=0;
foreach($results_esp2 as $key => $value)
{
  $formatted4[] = floatval($value['con']);
  $formatted4[] = floatval($value['flow']);
  $i++;
}

$json_hasil = json_encode($formatted);
$json_hasil2 = json_encode($formatted2);
$json_hasil3 = json_encode($formatted3);
$json_hasil4 = json_encode($formatted4);

?>
<div class="row">
    <div class="col-lg-6 grid-margin stretch-card ex1">
        <div class="card">
        <div class="card-body">
            <h4 class="card-title">Pressure</h4>
            <iframe id="chart1" width="100%" height="100%" frameborder="0" src="gauge_charts.php?i=1&data=<?=$json_hasil?>" scrolling="no"></iframe>
        </div>
        </div>
    </div>

    <div class="col-lg-6 grid-margin stretch-card ex1">
        <div class="card">
        <div class="card-body">
            <h4 class="card-title">Pressure</h4>
            <iframe id="chart2" width="100%"  height="100%" frameborder="0" src="gauge_charts.php?i=5&data=<?=$json_hasil2?>" scrolling="no"></iframe>            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 grid-margin stretch-card ex1">
        <div class="card">
        <div class="card-body">
            <h4 class="card-title">Conductivity</h4>
                <iframe id="chart3" width="100%"   height="100%" frameborder="0" src="gauge_charts.php?i=9&data=<?=$json_hasil3?>" scrolling="no"></iframe>            </div>
        </div>
    </div>

    <div class="col-lg-6 grid-margin stretch-card ex1">
        <div class="card">
        <div class="card-body">
            <h4 class="card-title">Flow Rate</h4>
                <iframe id="chart4" width="100%"  width="100%"  height="100%" frameborder="0" src="gauge_charts.php?i=11&data=<?=$json_hasil4?>" scrolling="no"></iframe>            </div>
        </div>
    </div>
</div>

<script>

$(function() {
    setInterval(function(){ 
    $.ajax({
      url: "get_data_sql.php", 
      method: "GET", 
      success: function(data) {
        let parsed_data = JSON.parse(data);
        console.log("parsed=",parsed_data);
        console.log("parsed 0 0=",parsed_data[0]);
        console.log("stringify=",JSON.stringify(parsed_data[0]) );
        $('#chart1').attr('src', 'gauge_charts.php?i=1&data='+JSON.stringify( parsed_data[0]) );
        $('#chart2').attr('src', 'gauge_charts.php?i=5&data='+JSON.stringify( parsed_data[1]) );
        $('#chart3').attr('src', 'gauge_charts.php?i=9&data='+JSON.stringify( parsed_data[2]) );
        $('#chart4').attr('src', 'gauge_charts.php?i=11&data='+JSON.stringify( parsed_data[3]) );
        // $('#chart1').attr('src')
        console.log("reload chart");
      }
    
    });
   }, 4000);
  });
</script>