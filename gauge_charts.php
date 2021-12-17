
<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

require __DIR__ . '/vendor/autoload.php';
require_once ('config/MysqliDb.php');
include_once ("config/db.php");
$db = new MysqliDb ('localhost', $dbuser, $dbpass, $dbname);
include("config/functions.php");
require_once ("jwt_token.php");
require_once ("customhelper.php");

$data=isset($_GET['data']) ? $_GET['data'] : null; 
$i=isset($_GET['i']) ? ($_GET['i']-1) : 0; 

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
    <script>
    let dbcolor = ['#63CF72', '#F36368', '#76C1FA', '#FABA66','#63CF72', '#F36368', '#76C1FA', '#FABA66','#E56997', '#BD97CB','#FBC740', '#66D2D6'];
    let arr_data = <?=$data?>;
    let d_color = [];
    let d_label = [];
    let i=0;
    let j=<?=$i?>;
    for(i;i<arr_data.length;i++)
    {
        d_color.push(dbcolor[j]);
        d_label.push("Sensor "+(j+1) );
        j++;

    }

    console.log(arr_data);
    
    var options1 = {
          series: arr_data,
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
        colors: d_color,
        labels: d_label,
        legend: {
          show: true,
          floating: true,
          fontSize: '13px',
          position: 'left',
          offsetX: 120,
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
  
    </script>

  </body>
</html>
