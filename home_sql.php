
<?php

$now = (new \DateTime())->format('Y-m-d');

$limit = 30;
$db = new MysqliDb ('localhost', $dbuser, $dbpass, $dbname);
$db->autoReconnect = false;

$db3 = new MysqliDb ('localhost', $dbuser, $dbpass, $dbname);
$db3->autoReconnect = false;

$db2 = new MysqliDb ('localhost', $dbuser, $dbpass, $dbname);
$db2->autoReconnect = false;

$db0 = new MysqliDb ('localhost', $dbuser, $dbpass, $dbname);
$db0->autoReconnect = false;

$db->orderBy("id","Desc");
$db->pageLimit = $limit;
$page = 1;

$nodes = $db0->get("node");
$node=isset($_GET['node']) ? $_GET['node'] : 'RO1';

$db->where ('remark', $node);

// set page limit to 2 results per page. 20 by default
$results_pressure = $db->arraybuilder()->paginate("data_sensors", $page);

$i=0;
foreach($results_pressure as $key => $value)
{
  $j=0;
  $formatted[$i]['S'.++$j] = floatval($value['s1']);
  $formatted[$i]['S'.++$j] = floatval($value['s2']);
  $formatted[$i]['S'.++$j] = floatval($value['s3']);
  $formatted[$i]['S'.++$j] = floatval($value['s4']);
  $formatted[$i]['S'.++$j] = floatval($value['s5']);
  
  $formatted2[$i]['S8'] = floatval($value['s8']); //cond
  $formatted2[$i]['S9'] = floatval($value['s9']); ////cond
  $formatted2[$i]['xcon'] = (string)($value['created_at']);

  $formatted3[$i]['S6'] = floatval($value['s6']); //flow
  $formatted3[$i]['S7'] = floatval($value['s7']); //flow
  $formatted3[$i]['xflow'] = (string)($value['created_at']);

  $formatted[$i]['yaxis'] = (string)($value['created_at']);
  $i++;
}
$json_hasil = json_encode($formatted);
$json_hasil2 = json_encode($formatted2);
$json_hasil3 = json_encode($formatted3);

$db3->where ('remark is not NULL');
$db3->orderBy("id","Desc");

$maintenance1 = $db3->getOne("data_sensors",'DATE_FORMAT(remark, "%d %M %Y") as remark')["remark"];
$nextMaintenance = date('d M Y');
$countdowndata = "";
if($maintenance1)
{
  $nextMaintenance = date('d M Y', strtotime( $maintenance1 ));
  $date1 = new DateTime($nextMaintenance);
  $date2 = new DateTime($now);
  $countdowndata = "";
  if($date1 > $date2)
  {
    $interval = $date1->diff($date2);
    $countdowndata =  "";
  }
  else
  {
    $nextMaintenance = date('d M Y', strtotime( $now ));
    $countdowndata = ". <h4 style='color: red;'>Maintenance Date is Today.!</h4>";
  }
}

?>
<link rel="stylesheet" href="css/countdown_flip.css">

<div class="content-wrapper " >
    <div class="row">
      <div class="col-md-12 grid-margin">
        <div class="row">
          <div class="col-12 col-xl-8 mb-4 mb-xl-0">
            <h3 class="font-weight-bold">Welcome <?=$_SESSION['u']?></h3>
            <!-- <h6 class="font-weight-normal mb-0">Robot Chatting menjawab setiap kebutuhan kamu agar #memudahkan !</h6> -->
          </div>
          <div class="col-12 col-xl-4">
            <div class="justify-content-end d-flex">
              <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                  <i class="mdi mdi-calendar"></i> Today (<?=$today?>)
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                  <a class="dropdown-item" href="#">January - March</a>
                  <a class="dropdown-item" href="#">March - June</a>
                  <a class="dropdown-item" href="#">June - August</a>
                  <a class="dropdown-item" href="#">August - November</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
              <label>Select Node : </label>
              <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                  <i class="mdi mdi-calendar"></i> Node (<?=$node?>)
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                  <?php 
                  foreach($nodes as $value) {
                    echo '<a class="dropdown-item" href="index.php?page=home_sql&node='.$nodes[0]["node_name"].'">'.$value['node_name'].'</a>';
                  }
                  ?>
                  
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Pressure</h4>
              <div id="pres-chart"></div>
            </div>
          </div>
        </div>

        <div class="col-lg-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Conductivity</h4>
              <div id="con-chart"></div>
            </div>
          </div>
        </div>

        <div class="col-lg-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Flow Rate</h4>
              <div id="flow-chart"></div>
            </div>
          </div>
        </div>

    </div>

    
    <div class="row">

        <div class="col-lg-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Machine Learning Predictive Maintenance</h4>
              <div id="countdown1"></div><br>
              <p><h4 style="text-align: center;"><strong>Estimation for Device Failure = <?=$nextMaintenance.$countdowndata?></strong></h4></p>
            </div>
          </div>
        </div>

    </div>


</div>
<input type="hidden" id="anomaly"/>
<input type="hidden" id="trainingData"/>
<input type="hidden" id="lastData"/>
<input type="hidden" id="dayPrediction"/>
<script>

const myTimeout = setTimeout(getDataML, 5000);
var sweet_loader = '<div class="sweet_loader"><svg viewBox="0 0 140 140" width="140" height="140"><g class="outline"><path d="m 70 28 a 1 1 0 0 0 0 84 a 1 1 0 0 0 0 -84" stroke="rgba(0,0,0,0.1)" stroke-width="4" fill="none" stroke-linecap="round" stroke-linejoin="round"></path></g><g class="circle"><path d="m 70 28 a 1 1 0 0 0 0 84 a 1 1 0 0 0 0 -84" stroke="#71BBFF" stroke-width="4" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-dashoffset="200" stroke-dasharray="300"></path></g></svg></div>';

let timerInterval;
function getDataML() {
  $.ajax({
      url: "get_data_training.php?node=<?=$node?>", 
      method: "GET", 
      success: function(data) {
        console.log(JSON.parse(data));
        parsed_data = JSON.parse(data);

        document.getElementById('trainingData').value = JSON.stringify( parsed_data[0]) ;
        document.getElementById('lastData').value =JSON.stringify( parsed_data[1]) ;

        if(parsed_data[2])
        {
          TrainingML(parsed_data[0],parsed_data[3],parsed_data[2]);
        }
        else
        {
          TrainingML(parsed_data[0],parsed_data[1],parsed_data[2]);
        }
      }
    
    });
  }


function TrainingML(trainingData,lastData,idData)
{

/////trial ML
  const net = new brain.recurrent.LSTMTimeStep({
              inputSize: 9,
              hiddenLayers: [10],
              outputSize: 9,
              learningRate: 0.01,
              decayRate: 0.0099,
              });

  net.train(trainingData, { log: true, errorThresh: 0.09 });

  // now we're cookin' with gas!
  const forecast = net.forecast(
      [ lastData ],
      1
  );

  console.log('next n predictions', forecast);
  console.log("this.trainingData=", JSON.parse( document.getElementById('trainingData').value) );
  console.log("this.lastData=",JSON.parse( document.getElementById('lastData').value) );

  var forecastN = forecast;
  var i=0,n=0,z=0,x=0;
  var degradationValueTotal = 0;
  var degradationValue = 0.0001;
  var failureTimes = [];
  for (i; i < forecast[0].length; i++) 
  {   
    var n=0;
    while((forecastN[0][i]>=3 && forecastN[0][i]<=10))
    {
      if(forecastN[0][i] < 6.25)
      { //jika data trend keatas maka di tambahkan degradation
        forecastN[0][i] -= degradationValue;
      }
      else
      {
        forecastN[0][i] += degradationValue;
      }
      
      if(forecastN[0][i]<3 || forecastN[0][i]>10)
      {
        console.log("detected",forecastN[0][i],"in",n); 
        failureTimes[i] = n;
        z+=n;
      }
      if(++n>100000)break;
    }
    // console.log("forecastN=",forecastN,"i=",i);
  }
  x = z/8;
  console.log("failureTimes=",failureTimes,"z=",z," rata2=",x);
  document.getElementById('dayPrediction').value = parseInt( (x*5)/60/24 );
  console.log(document.getElementById('dayPrediction').value);
  
  var dataPredict = new FormData();
  dataPredict.append("predict", forecast);
  dataPredict.append("id", idData);

if(idData)
{
  $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "actionSavePredict.php",
        data: dataPredict,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 600000,
        success: function (data) {
      var rv;
      try {
        rv = JSON.parse(data);
        console.log(rv.status,rv.info,rv);

      } catch (e) {
        //error data not json
        Swal.fire(
                'error!',
                'Error Input Data, '+data,
                'error'
                );
            
            console.log("ERROR : ", data);
      } 

    },
    error: function (e) {

        console.log("ERROR : ", e);

    }
    }); //end of ajax
}

var dataPredict = new FormData();
  dataPredict.append("predict", document.getElementById('dayPrediction').value);

if(document.getElementById('dayPrediction').value > 0)
{
  $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "actionPredict.php",
        data: dataPredict,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 600000,
        success: function (data) {
      var rv;
      try {
        rv = JSON.parse(data);
        console.log(rv.status,rv.info,rv);

      } catch (e) {
        //error data not json
        Swal.fire(
                'error!',
                'Error Input Data, '+data,
                'error'
                );
            
            console.log("ERROR : ", data);
      } 

    },
    error: function (e) {

        console.log("ERROR : ", e);

    }
    }); //end of ajax
}

Swal.fire({
    icon: 'success',
    html: '<h4>Prediction Success!</h4>',
    timer:4000
  });
///end trial ML
}


$(function() {
  /* ChartJS
   * -------
   * Data and config for chartjs
   */
  'use strict';
  var morrisLine1, morrisLine2, morrisLine3, anomalyData, anomalyCount, anomalyflag = false;
  var parsed_data = [];
  var anomaly = [];

  // var trainingData = [];
  init_chart(<?=$json_hasil?>,<?=$json_hasil2?>,<?=$json_hasil3?>);

  function setDataMorris(data,data2,data3) {
    morrisLine1.setData(data);
    morrisLine3.setData(data3);
    morrisLine2.setData(data2);
  }

  function init_chart(data,data2,data3)
  {
    let arr_data = data;
    let arr_data2 = data2;
    let arr_data3 = data3;

    if ($('#pres-chart').length) {
      morrisLine1 = Morris.Line({
        element: 'pres-chart',
        lineColors: ['#63CF72', '#F36368', '#76C1FA', '#FABA66','#2FF3E0', '#F8D210', '#FA26A0', '#F51720'],
        data: arr_data,
        xkey: 'yaxis',
        ykeys: ['S1','S2','S3','S4','S5'],
        labels: ['Sensor 1 (Psi)','Sensor 2 (Psi)','Sensor 3 (Psi)','Sensor 4 (Psi)','Sensor 5 (Psi)','Sensor 6 (Psi)','Sensor 7 (Psi)','Sensor 8 (Psi)'],
        parseTime:false,
        hideHover:true,
        // lineWidth:'6px',
        stacked: true       
      });
    }

    if ($('#con-chart').length) {
      morrisLine2 = Morris.Line({
        element: 'con-chart',
        lineColors: ['#E56997', '#BD97CB'],
        data: arr_data2,
        xkey: 'xcon',
        ykeys: ['S8','S9'],
        labels: ['Sensor 1 (mS/cm)','Sensor 2 (mS/cm)'],
        parseTime:false,
        hideHover:true,
        // lineWidth:'6px',
        stacked: true
      });
    }

    if ($('#flow-chart').length) {
      morrisLine3 = Morris.Line({
        element: 'flow-chart',
        lineColors: ['#FBC740', '#66D2D6'],
        data: arr_data3,
        xkey: 'xflow',
        ykeys: ['S6','S7'],
        labels: ['Sensor 1 (L/min)','Sensor 2 (L/min)'],
        parseTime:false,
        hideHover:true,
        // lineWidth:'6px',
        stacked: true
      });
    }
  }


  setInterval(function(){ 
    this.anomalyflag = true;
    $.ajax({
      url: "get_data_line_sql.php?node=<?=$node?>", 
      method: "GET", 
      success: function(data) {
        parsed_data = JSON.parse(data);
        console.log("parsed_data",parsed_data);

        this.anomaly = parsed_data[3];
        console.log("this.anomaly=",this.anomaly);
        setDataMorris(parsed_data[0],parsed_data[1],parsed_data[2]);
        document.getElementById("anomaly").value = JSON.stringify( parsed_data[3]) ;
      }
    
    });

    
   }, 4000);

  //  //interval 60 sec to check 
   setInterval(function(){ 
     console.log("interval to show anomaly");
     this.anomaly = JSON.parse(document.getElementById("anomaly").value);

     console.log(this.anomaly);
      if ( typeof this.anomaly === 'object' && !Array.isArray(this.anomaly) && this.anomaly !== null ) {
        
        console.log("anomaly detected");
        let detailsensor = "";
        for (const [key, value] of Object.entries(this.anomaly)) {
        console.log(`${key}: ${value}`);
        detailsensor = detailsensor+"<h5 style='color: red;'>"+key+" = "+value+"</h5>";

      }
        // let detailsensor = this.anomaly.forEach(getDetailSensor);
        let infotext = 'System has detected anomaly data. <hr> '+detailsensor+' <hr> Please check the RO device.!';
        this.anomalyflag = false;
        Swal.fire({
                  icon: 'warning',
                  title: 'Warning!',
                  text: infotext,
                  timer: 5000
                });
                  document.getElementById("anomaly").value = "";
      }
     
   }, 60000);

  });

</script>

<script src='https://cdn.rawgit.com/vuejs/vue/v1.0.24/dist/vue.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js'></script>
  <script id="rendered-js" >
    Vue.filter('zerofill', function (value) {
    //value = ( value < 0 ? 0 : value );
    return (value < 10 && value > -1 ? '0' : '') + value;
    });

    var Tracker = Vue.extend({
    template: `
    <span v-show="show" class="flip-clock__piece">
        <span class="flip-clock__card flip-card">
        <b class="flip-card__top">{{current | zerofill}}</b>
        <b class="flip-card__bottom" data-value="{{current | zerofill}}"></b>
        <b class="flip-card__back" data-value="{{previous | zerofill}}"></b>
        <b class="flip-card__back-bottom" data-value="{{previous | zerofill}}"></b>
        </span>
        <span class="flip-clock__slot">{{property}}</span>
    </span>`,
  props: ['property', 'time'],
  data: () => ({
    current: 0,
    previous: 0,
    show: false }),


  events: {
    time(newValue) {

      if (newValue[this.property] === undefined) {
        this.show = false;
        return;
      }

      var val = newValue[this.property];
      this.show = true;

      val = val < 0 ? 0 : val;

      if (val !== this.current) {

        this.previous = this.current;
        this.current = val;

        this.$el.classList.remove('flip');
        void this.$el.offsetWidth;
        this.$el.classList.add('flip');
      }

    } } });

    var el = document.getElementById('countdown1');

var Countdown = new Vue({

  el: el,

  template: ` 
  <div class="flip-clock" data-date="2022-02-11" @click="update">
    <tracker 
      v-for="tracker in trackers"
      :property="tracker"
      :time="time"
      v-ref:trackers
    ></tracker>
  </div>
  `,

  props: ['date', 'callback'],

  data: () => ({
    time: {},
    i: 0,
    trackers: ['Days', 'Hours', 'Minutes', 'Seconds'] //'Random', 
  }),

  components: {
    Tracker },


  beforeDestroy() {
    if (window['cancelAnimationFrame']) {
      cancelAnimationFrame(this.frame);
    }
  },

  watch: {
    'date': function (newVal) {
      this.setCountdown(newVal);
    } },


  ready() {
    if (window['requestAnimationFrame']) {
      this.date = '<?=date('Y-m-d', strtotime( $maintenance1 ))?>';
      this.setCountdown(this.date);
      this.callback = this.callback || function () {};
      this.update();
    }
  },

  methods: {

    setCountdown(date) {

      if (date) {
        this.countdown = moment(date, 'YYYY-MM-DD HH:mm:ss');
      } else {
        this.countdown = moment().endOf('day'); 
      }
    },

    update() {
      this.frame = requestAnimationFrame(this.update.bind(this));
      if (this.i++ % 10) {return;}
      var t = moment(new Date());
      // Calculation adapted from https://www.sitepoint.com/build-javascript-countdown-timer-no-dependencies/
      if (this.countdown) {

        t = this.countdown.diff(t);
        this.time.Days = Math.floor(t / (1000 * 60 * 60 * 24));
        this.time.Hours = Math.floor(t / (1000 * 60 * 60) % 24);
        this.time.Minutes = Math.floor(t / 1000 / 60 % 60);
        this.time.Seconds = Math.floor(t / 1000 % 60);
      } else {
        this.time.Days = undefined;
        this.time.Hours = t.hours() % 13;
        this.time.Minutes = t.minutes();
        this.time.Seconds = t.seconds();
      }

      this.time.Total = t;

      this.$broadcast('time', this.time);
      return this.time;
    } } });
    //end of cd 1

    </script>



