
<?php
$limit = 30;
$db = new MysqliDb ('localhost', $dbuser, $dbpass, $dbname);
$db->autoReconnect = false;

$db2 = new MysqliDb ('localhost', $dbuser, $dbpass, $dbname);
$db2->autoReconnect = false;
// $db->where ('remark', '');
// $count = $db->getValue ("bot", "count(*)");
$db->orderBy("id","Desc");
$db->pageLimit = $limit;
// $results_pressure = $db->get ('pressure');
$page = 1;
// set page limit to 2 results per page. 20 by default
$results_pressure = $db->arraybuilder()->paginate("pressure", $page);
// echo "showing $page out of " . $db->totalPages;
// var_dump($results_pressure);
$i=0;
foreach($results_pressure as $key => $value)
{
  $j=0;
  $formatted[$i]['S'.++$j] = floatval($value['s1']);
  $formatted[$i]['S'.++$j] = floatval($value['s2']);
  $formatted[$i]['S'.++$j] = floatval($value['s3']);
  $formatted[$i]['S'.++$j] = floatval($value['s4']);
  $formatted[$i]['S'.++$j] = floatval($value['s5']);
  $formatted[$i]['S'.++$j] = floatval($value['s6']);
  $formatted[$i]['S'.++$j] = floatval($value['s7']);
  $formatted[$i]['S'.++$j] = floatval($value['s8']);
  $formatted[$i]['yaxis'] = (string)($value['created_at']);
  $i++;
}
$json_hasil = json_encode($formatted);
// var_dump($json_hasil);
////==========================================
$db2->orderBy("id","Desc");
$db2->where("remark", "esp1");
$db2->pageLimit = $limit;
$page = 1;
$results_esp1 = $db2->arraybuilder()->paginate("flowrate", $page);

$i=0;
foreach($results_esp1 as $key => $value)
{
  $formatted2[$i]['S1'] = floatval($value['con']);
  $formatted3[$i]['S1'] = floatval($value['flow']);
  $formatted2[$i]['yaxis'] = (string)($value['created_at']);
  $i++;
}
////==========================================
$db2->orderBy("id","Desc");
$db2->where("remark", "esp2");
$db2->pageLimit = $limit;
$page = 1;
$results_esp2 = $db2->arraybuilder()->paginate("flowrate", $page);

$i=0;
foreach($results_esp2 as $key => $value)
{
  $formatted2[$i]['S2'] = floatval($value['con']);
  $formatted3[$i]['S2'] = floatval($value['flow']);
  $formatted3[$i]['yaxis'] = (string)($value['created_at']);
  $i++;
}
$json_hasil2 = json_encode($formatted2);

$json_hasil3 = json_encode($formatted3);

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
              <h4 class="card-title">Device Maintenance Countdown (Device 1) </h4>
              <div id="countdown1"></div><br>
              <p><h4 style="text-align: center;"><strong>Estimation for next maintenance schedule = <?=$nextMaintenance[0].$countdowndata[0]?></strong></h4></p>
            </div>
          </div>
        </div>

        <div class="col-lg-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Machine Learning Predictive Maintenance</h4>
              <div id="countdown2"></div><br>
              <p><h4 style="text-align: center;"><strong>Estimation for Device Failure = <?=$nextMaintenance[1].$countdowndata[1]?></strong></h4></p>
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

// var net = new brain.recurrent.LSTMTimeStep({
//             inputSize: 8,
//             hiddenLayers: [10],
//             outputSize: 8,
//             });

const myTimeout = setTimeout(getDataML, 5000);
var sweet_loader = '<div class="sweet_loader"><svg viewBox="0 0 140 140" width="140" height="140"><g class="outline"><path d="m 70 28 a 1 1 0 0 0 0 84 a 1 1 0 0 0 0 -84" stroke="rgba(0,0,0,0.1)" stroke-width="4" fill="none" stroke-linecap="round" stroke-linejoin="round"></path></g><g class="circle"><path d="m 70 28 a 1 1 0 0 0 0 84 a 1 1 0 0 0 0 -84" stroke="#71BBFF" stroke-width="4" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-dashoffset="200" stroke-dasharray="300"></path></g></svg></div>';

let timerInterval;
function getDataML() {
  $.ajax({
      url: "get_data_training.php", 
      method: "GET", 
      // datatype: "json",
      success: function(data) {
        // let data = data.replace(/(\r\n|\n|\r)/gm, "");
        console.log(JSON.parse(data));
        parsed_data = JSON.parse(data);

        document.getElementById('trainingData').value = JSON.stringify( parsed_data[0]) ;
        document.getElementById('lastData').value =JSON.stringify( parsed_data[1]) ;

        // let timerInterval;

        // Swal.fire({
        //   title: 'Please Wait, Training In Progress!',
        //   html: 'Machine Learning Complete Training in <b></b> milliseconds.',
        //   timer: 10000,
        //   timerProgressBar: true,
        //   didOpen: () => {
        //     Swal.showLoading()
        //     const b = Swal.getHtmlContainer().querySelector('b')
        //     timerInterval = setInterval(() => {
        //       b.textContent = Swal.getTimerLeft()
        //     }, 100)
        //   },
        //   willClose: () => {
        //     clearInterval(timerInterval)
        //   }
        // }).then((result) => {
        //   /* Read more about handling dismissals below */
        //   if (result.dismiss === Swal.DismissReason.timer) {
        //     console.log('I was closed by the timer')
        //   }
        // });

        if(parsed_data[2])
        {
          TrainingML(parsed_data[0],parsed_data[3],parsed_data[2]);
        }
        else
        {
          TrainingML(parsed_data[0],parsed_data[1],parsed_data[2]);
        }
        // Swal.fire({
        //   html: '<h4>Loading...</h4>',
        //   didOpen: () => {
        //       Swal.showLoading()
        //   }
        //   // onRender: function() {
        //   //   $('.swal2-content').prepend(sweet_loader);
        //   // }
        // });

          // Swal({
          //   title: 'Now loading',
          //   allowEscapeKey: false,
          //   allowOutsideClick: false,
          //   timer: 2000,
          //   onOpen: () => {
          //     Swal.showLoading();
          //   }
          // }).then(
          //   () => {},
          //   (dismiss) => {
          //     if (dismiss === 'timer') {
          //       console.log('closed by timer!!!!');
          //       Swal({ 
          //         title: 'Finished!',
          //         type: 'success',
          //         timer: 2000,
          //         showConfirmButton: false
          //       })
          //     }
          //   }
          // )
        //showLoading();

        // document.getElementById("fire")
        //   .addEventListener('click', (event) => {
        //     showLoading();
        //   });
          
      }
    
    });
  }


function TrainingML(trainingData,lastData,idData)
{

/////trial ML
  const net = new brain.recurrent.LSTMTimeStep({
              inputSize: 8,
              hiddenLayers: [10],
              outputSize: 8,
              learningRate: 0.01,
              decayRate: 0.0099,
              });

  // var trainingDataExample = [[-100,3,4,1,2,-20,-10,-30],[-100,3,4,1,2,-20,-10,-30],[-100,3,4,1,2,-20,-10,-30],[-100,3,4,1,2,-20,-10,-30],[-100,3,4,1,2,-20,-10,-30],[-100,3,4,1,2,-20,-10,-30],[3.04,3.42,3.61,2.48,2.86,3.42,2.11,3.61],[3.04,3.42,3.61,2.48,2.86,3.42,2.11,3.61],[3.04,3.42,3.61,2.48,2.86,3.42,0.8,3.61],[3.04,3.42,3.61,2.48,2.86,3.61,0.8,3.61],[3.04,3.42,3.61,2.48,3.04,3.61,0.8,3.61],[3.04,3.42,3.61,2.3,3.04,3.61,0.8,3.61],[3.04,3.42,3.61,2.3,3.04,3.61,0.8,3.61],[3.04,3.04,3.61,2.3,3.04,3.61,0.8,3.61],[2.67,3.04,3.61,2.3,3.04,3.61,0.8,3.61],[2.67,3.04,3.61,2.3,3.04,3.61,0.8,3.42],[2.67,3.04,3.61,2.3,3.04,3.61,2.3,3.42],[2.67,3.04,3.61,2.3,3.04,3.61,2.3,3.42],[2.67,3.04,3.61,2.3,3.04,3.61,2.3,3.42],[2.67,3.04,3.61,2.48,3.04,3.61,2.3,3.42],[2.67,3.04,3.79,2.48,3.04,3.61,2.3,3.42],[2.67,3.42,3.79,2.48,3.04,3.61,2.3,3.42],[3.04,3.42,3.79,2.48,3.04,3.61,2.3,3.42],[3.04,3.42,3.79,2.48,3.04,3.61,2.3,3.42],[3.04,3.42,3.79,2.48,3.04,3.61,2.11,3.42],[3.04,3.42,3.79,2.48,3.04,3.61,2.11,3.42],[3.04,3.42,3.79,2.48,3.04,3.61,2.11,3.42],[3.04,3.42,3.79,2.3,3.04,3.61,2.11,3.42],[3.04,3.42,3.79,2.3,3.04,3.61,2.11,3.42],[3.04,3.42,3.79,2.3,3.04,3.61,2.11,3.42]];
  // console.log("trainingDataExample=",trainingDataExample);
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
  document.getElementById('dayPrediction').value = (x*5)/60/24;
  console.log(document.getElementById('dayPrediction').value);
  // for (i; i < forecast.length; i++) 
  // { 
  //   forecastN[0] = forecast[i][0] - degradationValueTotal;
  //   degradationValueTotal+=degradationValue;
  //   if(forecastN[0]<3 || forecastN[0]>10)
  //   {
  //     console.log("detected",forecastN[0],"in",i); 

  //   }
  // }
  // console.log("After Degradate forecast1000=",forecastN );

  // const forecastN = net.forecast(
  //     [ lastData ],
  //     1000
  // );
  // console.log("this.forecast1000=",forecastN );

  // let calculatedForecast = forecastN.forEach(getDetailSensor);
  // var i=0;
  // var degradationValueTotal = 0;
  // var degradationValue = 0.01;
  // for (i; i < forecastN.length; i++) 
  // { 
  //   forecastN[i][0] = forecastN[i][0] - degradationValueTotal;
  //   degradationValueTotal+=degradationValue;
  //   if(forecastN[i][0]<3 || forecastN[i][0]>10)
  //   {
  //     console.log("detected",forecastN[i][0],"in",i); 

  //   }
  // }
  // console.log("After Degradate forecast1000=",forecastN );


  // const dataPredict = {data:forecast};
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
        // if(isEmpty(rv))
        // {
        //         Swal.fire(
        //         'Info!',
        //         'No Data!',
        //         'info'
        //         );
        //     console.log("NO DATA : ", data);
        // }
        // else
        // {
        //   if(rv.status==true)
        //   {
        //     Swal.fire(
        //         'Success!',
        //         'Success Input Data!',
        //         'success'
        //         );
        //     console.log("SUCCESS : ", data);
        //     // setTimeout(function(){ window.location="users"; }, 1000);
        //     $("#btnSubmit").html('<span class="fa fa-paper-plane"></span> Submit');
        //     // $("#roleform")[0].reset();

        //   }
        //   else 
        //   {
        //     Swal.fire(
        //         'error!',
        //         'Error Input Data, '+data,
        //         'error'
        //         );
            
        //     console.log("ERROR : ", data);
        //     $("#btnSubmit").html('<span class="fa fa-paper-plane"></span> Submit');

        //   }

        // }
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
    icon: 'Prediction Process Success',
    html: '<h4>Success!</h4>'
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
  
  // const net = new brain.recurrent.LSTMTimeStep({
  //           inputSize: 8,
  //           hiddenLayers: [10],
  //           outputSize: 8,
  //           });

  // var trainingData = [];
  init_chart(<?=$json_hasil?>,<?=$json_hasil2?>,<?=$json_hasil3?>);

  function setDataMorris(data,data2,data3) {
    morrisLine1.setData(data);
    morrisLine2.setData(data2);
    morrisLine3.setData(data3);
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
        ykeys: ['S1','S2','S3','S4','S5','S6','S7','S8'],
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
        xkey: 'yaxis',
        ykeys: ['S1','S2'],
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
        xkey: 'yaxis',
        ykeys: ['S1','S2'],
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
      url: "get_data_line_sql.php", 
      method: "GET", 
      // datatype: "json",
      success: function(data) {
        // let data = data.replace(/(\r\n|\n|\r)/gm, "");
        console.log(JSON.parse(data));
        parsed_data = JSON.parse(data);
        setDataMorris(parsed_data[0],parsed_data[1],parsed_data[2]);
        // morrisLine1.setData(parsed_data);
        // let detailsensor = this.parsed_data.forEach(checkAnomaly);
        // this.anomalyData = detailsensor;
        this.anomaly = parsed_data[3];
        console.log("this.anomaly=",this.anomaly);
        document.getElementById("anomaly").value = JSON.stringify( parsed_data[3]) ;

        // this.trainingData = parsed_data[4];
        // console.log("this.trainingData=",this.trainingData);
        // // this.TrainingML();
        // this.net.train(trainingData, { log: true, errorThresh: 0.09 });
        // const forecast = this.net.forecast(
        //     [ [-100,3,4,1,2,-20,-10,-30] ],
        //     2
        // );

        // console.log('next 2 predictions', forecast);
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
        Swal.fire(
                  'Warning!',
                  infotext,
                  'warning'
                  );
                  document.getElementById("anomaly").value = "";
      }
     
   }, 60000);

  });



  // window.console = window.console || function(t) {};

  // if (document.location.search.match(/type=embed/gi)) {
  //   window.parent.postMessage("resize", "*");
  // }

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
// document.body.appendChild(el);

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
      this.date = '<?=date('Y-m-d', strtotime( $maintenance1[1] .' +2 months'))?>';
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
        this.countdown = moment().endOf('day'); //this.$el.getAttribute('data-date');
        // this.countdown = this.$el.getAttribute('data-date');
      }
    },

    update() {
      this.frame = requestAnimationFrame(this.update.bind(this));
      if (this.i++ % 10) {return;}
      var t = moment(new Date());
      // Calculation adapted from https://www.sitepoint.com/build-javascript-countdown-timer-no-dependencies/
      if (this.countdown) {

        t = this.countdown.diff(t);

        //t = this.countdown.diff(t);//.getTime();
        //console.log(t);
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

    var el2 = document.getElementById('countdown2');

    var Countdown2 = new Vue({

el: el2,

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
    this.date = '<?=date('Y-m-d', strtotime( $maintenance2[1] .' +2 months'))?>';
    this.setCountdown(this.date);
    console.log("this.date=",this.date);
    this.callback = this.callback || function () {};
    this.update();
  }
},

methods: {

  setCountdown(date) {

    if (date) {
      this.countdown = moment(date, 'YYYY-MM-DD HH:mm:ss');
    } else {
      this.countdown = moment().endOf('day'); //this.$el.getAttribute('data-date');
      // this.countdown = this.$el.getAttribute('data-date');
    }
  },

  update() {
    this.frame = requestAnimationFrame(this.update.bind(this));
    if (this.i++ % 10) {return;}
    var t = moment(new Date());
    // Calculation adapted from https://www.sitepoint.com/build-javascript-countdown-timer-no-dependencies/
    if (this.countdown) {

      t = this.countdown.diff(t);

      //t = this.countdown.diff(t);//.getTime();
      //console.log(t);
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
  ///end of cd 2
//# sourceURL=pen.js
    </script>



