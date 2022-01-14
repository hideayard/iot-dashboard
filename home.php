
<?php
$now = (new \DateTime())->format('Y-m-d');
// $now = date('Y-m-d');
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

$range = '2021!A'.$start.':L'.($jml+1);

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

////select device 1
$rangeJumlahlog1 = 'ro_log_1!Z1:Z1';
$responselog1 = $service->spreadsheets_values->get($spreadsheetId, $rangeJumlahlog1);
$valueslog1 = $responselog1->getValues();
$jmllog1 = $valueslog1[0][0] - 2; //2 is header
// $last_maintenance1 = $valueslog1[1][0]; 

$startlog1 = 3;
$nlog = 60;

if(($jmllog1>$n) && ($jmllog1-$nlog) >= 3)
{
  $startlog1 = $jmllog1-$nlog;
}

$rangelog1 = 'ro_log_1!C'.$startlog1.':T'.($jmllog1+2);

$paramslog1 = array(
  'ranges' => $rangelog1
);
$resultlog1 = $service->spreadsheets_values->batchGet($spreadsheetId, $paramslog1);
$hasillog1 = $resultlog1->getValueRanges();

////select device 2
$rangeJumlahlog2 = 'ro_log_2!Z1:Z1';
$responselog2 = $service->spreadsheets_values->get($spreadsheetId, $rangeJumlahlog2);
$valueslog2 = $responselog2->getValues();
$jmllog2 = $valueslog2[0][0] - 2; //2 is header
// $last_maintenance2 = $valueslog2[1][0]; 

$startlog2 = 3;

if(($jmllog2>$n) && ($jmllog2-$nlog) >= 3)
{
  $startlog2 = $jmllog2-$nlog;
}

$rangelog2 = 'ro_log_2!C'.$startlog2.':T'.($jmllog2+2);

$paramslog2 = array(
  'ranges' => $rangelog2
);
$resultlog2 = $service->spreadsheets_values->batchGet($spreadsheetId, $paramslog2);
$hasillog2 = $resultlog2->getValueRanges();
/// end device 2
// var_dump($paramslog1);
// echo "<br>";
// var_dump($paramslog2);
//start calculating 
// echo count($hasillog1[0]['values']);
$maintenance1 = checkMaintenance($hasillog1[0]['values']);
$maintenance2 = checkMaintenance($hasillog2[0]['values']);
// echo " | ".$maintenance1[0]." | ".$maintenance1[1];
// echo "<hr>";
// echo count($hasillog2[0]['values']);
// echo " | ".$maintenance2[0]." | ".$maintenance2[1];
// echo date('d M Y', strtotime( $maintenance1[1] .' +2 months')) ."<br>";
// echo (new \DateTime($maintenance1[1]))->format('Y-m-d');
// $date1 = date_create( $maintenance1[1]);
// $now = date_create( $now );
// $diff=date_diff( $date1 ,$now);
// echo "hasil=".$diff;

$countdowndata = [];
$nextMaintenance[0] = date('d M Y', strtotime( $maintenance1[1] .' +2 months'));
$date1 = new DateTime($nextMaintenance[0]);
$date2 = new DateTime($now);
$countdowndata[0] = "";
if($date1 > $date2)
{
  $interval = $date1->diff($date2);
  $countdowndata[0] =  "";//$interval;
  // echo "difference " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days "; 
  // shows the total amount of days (not divided into years, months and days like above)
  // echo "difference " . $interval->days . " days ";
}
else
{
  $countdowndata[0] = ". <h4 style='color: red;'>But it was Expired</h4>";
}
///////
$nextMaintenance[1] = date('d M Y', strtotime( $maintenance2[1] .' +2 months'));
$date3 = new DateTime($nextMaintenance[1]);
$date2 = new DateTime($now);
$countdowndata[1] = "";
if($date3 > $date2)
{
  $interval = $date3->diff($date2);
  $countdowndata[1] = "";//$interval;
  // echo "difference " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days "; 
  // shows the total amount of days (not divided into years, months and days like above)
  // echo "difference " . $interval->days . " days ";
}
else
{
  $countdowndata[1] = ". <h4 style='color: red;'>But it was Expired</h4>";
}
///////


function checkMaintenance($arr)
{
  $i=0;
  $date_input = null;
  foreach($arr as $value)
  {
    if($value[0] == 'maintenance')
    {
      $i++;
      $date_input = $value[17];
    }
  }
  return array($i,$date_input);

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
              <h4 class="card-title">Device Maintenance Countdown (Device 2) </h4>
              <div id="countdown2"></div><br>
              <p><h4 style="text-align: center;"><strong>Estimation for next maintenance schedule = <?=$nextMaintenance[1].$countdowndata[1]?></strong></h4></p>
            </div>
          </div>
        </div>

    </div>

    <div class="row">

        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Database </h4>
              <div>For Detail Database, kindly check <a target="_blank" href="https://docs.google.com/spreadsheets/d/1HZ-lVFx6TenJiFlFEv0R3d9w3FpuRXeXwZAEirHdtpU/edit?usp=sharing">this link</a></div>
            </div>
          </div>
        </div>

    </div>

</div>

<script>

$(function() {
  /* ChartJS
   * -------
   * Data and config for chartjs
   */
  'use strict';
  var morrisLine1;
  var morrisLine2;
  var morrisLine3;

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
        labels: ['Sensor 1','Sensor 2','Sensor 3','Sensor 4','Sensor 5','Sensor 6','Sensor 7','Sensor 8'],
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
        labels: ['Sensor 1','Sensor 2'],
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
        labels: ['Sensor 1','Sensor 2'],
        parseTime:false,
        hideHover:true,
        // lineWidth:'6px',
        stacked: true
      });
    }
  }

  setInterval(function(){ 
    $.ajax({
      url: "get_data_line.php", 
      method: "GET", 
      // datatype: "json",
      success: function(data) {
        // let data = data.replace(/(\r\n|\n|\r)/gm, "");
        // console.log(JSON.parse(data));
        let parsed_data = JSON.parse(data);
        setDataMorris(parsed_data[0],parsed_data[1],parsed_data[2]);
      }
    
    });
   }, 4000);
  });
</script>

<script>
  window.console = window.console || function(t) {};

  if (document.location.search.match(/type=embed/gi)) {
    window.parent.postMessage("resize", "*");
  }
  
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

