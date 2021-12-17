
<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
require __DIR__ . '/vendor/autoload.php';

require_once ('config/MysqliDb.php');
include_once ("config/db.php");
$db = new MysqliDb ('localhost', $dbuser, $dbpass, $dbname);
include("config/functions.php");
require_once ("jwt_token.php");
require_once ("customhelper.php");


$client = new Google_Client();
$client->setApplicationName('Google Sheets API PHP for RO System');
$client->setScopes(Google_Service_Sheets::SPREADSHEETS);
$client->setAuthConfig('spreadsheet.json');
$client->setAccessType('online');
$client->setPrompt('select_account consent');
$service = new Google_Service_Sheets($client);
$spreadsheetId = '1HZ-lVFx6TenJiFlFEv0R3d9w3FpuRXeXwZAEirHdtpU';

$rangeJumlah = '2021!Z1:Z1';
$response = $service->spreadsheets_values->get($spreadsheetId, $rangeJumlah);
$values = $response->getValues();
$jml = $values[0][0];

$start = 1;
$n = 30;
if($jml>$n)
{
  $start = $jml-$n;
}

$range = '2021!A'.($jml+1).':L'.($jml+1);

$params = array(
  'ranges' => $range
);
$result = $service->spreadsheets_values->batchGet($spreadsheetId, $params);
$hasil = $result->getValueRanges();
// printf("%d ranges retrieved.", count($hasil) );
$formatted = [];
$formatted2 = [];
$formatted3 = [];
$i=0;
foreach($hasil[0]['values'] as $key => $value)
{
  $formatted[$i]['yaxis'] = (string)($i+1);
  $formatted2[$i]['yaxis'] = (string)($i+1);
  $formatted3[$i]['yaxis'] = (string)($i+1);
  $j=0;
  $formatted[$i]['S'.++$j] = floatval($value[$j-1]);
  $formatted[$i]['S'.++$j] = floatval($value[$j-1]);
  $formatted[$i]['S'.++$j] = floatval($value[$j-1]);
  $formatted[$i]['S'.++$j] = floatval($value[$j-1]);
  $formatted[$i]['S'.++$j] = floatval($value[$j-1]);
  $formatted[$i]['S'.++$j] = floatval($value[$j-1]);
  $formatted[$i]['S'.++$j] = floatval($value[$j-1]);
  $formatted[$i]['S'.++$j] = floatval($value[$j-1]);
  $j = 9;
  $formatted2[$i]['S1'] = floatval($value[$j-1]);
  $j = 10;
  $formatted2[$i]['S2'] = floatval($value[$j-1]);
  $j = 11;
  $formatted3[$i]['S1'] = floatval($value[$j-1]);
  $j = 12;
  $formatted3[$i]['S2'] = floatval($value[$j-1]);

  $i++;
}
$json_hasil = json_encode($formatted);
$json_hasil2 = json_encode($formatted2);
$json_hasil3 = json_encode($formatted3);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Gauge Dashboard</title>

    <link href="css/apex_style.css" rel="stylesheet" />

    <style>
      
        #chart {
      padding: 0;
      max-width: 650px;
      margin: 35px auto;
    }
    
    .apexcharts-legend text {
      font-weight: 900;
    }
      
    </style>

    <script>
      window.Promise ||
        document.write(
          '<script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.min.js"><\/script>'
        )
      window.Promise ||
        document.write(
          '<script src="https://cdn.jsdelivr.net/npm/eligrey-classlist-js-polyfill@1.2.20171210/classList.min.js"><\/script>'
        )
      window.Promise ||
        document.write(
          '<script src="https://cdn.jsdelivr.net/npm/findindex_polyfill_mdn"><\/script>'
        )
    </script>

    
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    

    <script>
      // Replace Math.random() with a pseudo-random number generator to get reproducible results in e2e tests
      // Based on https://gist.github.com/blixt/f17b47c62508be59987b
      var _seed = 42;
      Math.random = function() {
        _seed = _seed * 16807 % 2147483647;
        return (_seed - 1) / 2147483646;
      };
    </script>

    
  </head>

  <body>
  <div id="chart1"></div>
  <div id="chart2"></div>
  <div id="chart3"></div>
  <div id="chart4"></div>

    <script>
    let arr_data = <?=$json_hasil?>;
    let arr_data2 = <?=$json_hasil2?>;
    let arr_data3 = <?=$json_hasil3?>;
    console.log(arr_data,arr_data2,arr_data3);
    
    var options1 = {
          series: [76, 67, 61, 90],
          chart: {
          height: 390,
          type: 'radialBar',
        },
        plotOptions: {
          radialBar: {
            offsetY: 0,
            startAngle: 0,
            endAngle: 270,
            hollow: {
              margin: 5,
              size: '30%',
              background: 'transparent',
              image: undefined,
            },
            dataLabels: {
              name: {
                show: false,
              },
              value: {
                show: false,
              }
            }
          }
        },
        colors: ['#63CF72', '#F36368', '#76C1FA', '#FABA66'],
        labels: ['Sensor 1','Sensor 2','Sensor 3','Sensor 4'],
        legend: {
          show: true,
          floating: true,
          fontSize: '16px',
          position: 'left',
          offsetX: 160,
          offsetY: 15,
          labels: {
            useSeriesColors: true,
          },
          markers: {
            size: 0
          },
          formatter: function(seriesName, opts) {
            return seriesName + ":  " + opts.w.globals.series[opts.seriesIndex]
          },
          itemMargin: {
            vertical: 3
          }
        },
        responsive: [{
          breakpoint: 480,
          options: {
            legend: {
                show: false
            }
          }
        }]
        };

        var chart = new ApexCharts(document.querySelector("#chart1"), options1);
        chart.render();

        var options2 = {
          series: [76, 67, 61, 90],
          chart: {
          height: 390,
          type: 'radialBar',
        },
        plotOptions: {
          radialBar: {
            offsetY: 0,
            startAngle: 0,
            endAngle: 270,
            hollow: {
              margin: 5,
              size: '30%',
              background: 'transparent',
              image: undefined,
            },
            dataLabels: {
              name: {
                show: false,
              },
              value: {
                show: false,
              }
            }
          }
        },
        colors: ['#2FF3E0', '#F8D210', '#FA26A0', '#F51720'],
        labels: ['Sensor 5','Sensor 6','Sensor 7','Sensor 8'],
        legend: {
          show: true,
          floating: true,
          fontSize: '16px',
          position: 'left',
          offsetX: 160,
          offsetY: 15,
          labels: {
            useSeriesColors: true,
          },
          markers: {
            size: 0
          },
          formatter: function(seriesName, opts) {
            return seriesName + ":  " + opts.w.globals.series[opts.seriesIndex]
          },
          itemMargin: {
            vertical: 3
          }
        },
        responsive: [{
          breakpoint: 480,
          options: {
            legend: {
                show: false
            }
          }
        }]
        };

        var chart2 = new ApexCharts(document.querySelector("#chart2"), options2);
        chart2.render();
      
      
    </script>

    
  </body>
</html>
