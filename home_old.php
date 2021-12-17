
<?php

// $file = basename($_SERVER['PHP_SELF']);
// $filename = (explode(".",$file))[0];

// if(!check_role($file,null))
// {
//   echo json_encode( array("status" => false,"info" => "You are not authorized.!!!","messages" => "You are not authorized.!!!" ) );
// }
// else
// {

  //  $sql = "SELECT * FROM ucux WHERE ucux_is_deleted=0 and ucux_status<>0  order by ucux_id desc LIMIT 0,6 "; 
  $sql = "SELECT 
  (SELECT count(user_id) FROM `users` WHERE YEAR(user_created_at) = YEAR(NOW()) ) as user_year
  , (SELECT count(user_id) FROM `users` WHERE YEAR(user_created_at) = YEAR(NOW()) and MONTH(user_created_at) = MONTH(NOW()) ) as user_month
  , (SELECT count(user_id) FROM `users` WHERE YEAR(user_created_at) = YEAR(NOW()) and MONTH(user_created_at) = MONTH(NOW())  and  YEARWEEK(user_created_at)=YEARWEEK(NOW()) ) as user_week
  , (SELECT count(user_id) FROM `users` WHERE date(user_created_at) = curdate() ) as user_today" ;
  $result = $db->rawQuery($sql);//@mysql_query($sql);
  //  var_dump($result);
  // require_once ("jwt_token.php");
  // var_dump(verify_token($_SESSION['token'],'B15m1ll4#');
  ?>
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
          <div class="container-fluid">
              <div class="row mb-2">
                  <div class="col-sm-6">
                      <h1>Home</h1>
                  </div>
                  <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="#">Home</a></li>
                      </ol>
                  </div>
              </div>
          </div><!-- /.container-fluid -->
      </section>
      <!-- Main content -->
      <section class="content">
          <div class="container-fluid">
              <!-- Small boxes (Stat box) -->
              <div class="row">
                  <div class="col-lg-12">
                  
  <?php

  if($_SESSION['t']=="ADMIN")
  {
  ?>   
                      <div class="card card-primary">
                          <div class="card-header">
                              <h3 class="card-title">SUMMARY OF REGISTERED USER</h3>
                          </div>
                          <!-- /.card-header -->
                          <div class="card-body">
                              <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                  <ol class="carousel-indicators">
                                      <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                      <li data-target="#carouselExampleIndicators" data-slide-to="1" class=""></li>
                                      <li data-target="#carouselExampleIndicators" data-slide-to="2" class=""></li>
                                      <li data-target="#carouselExampleIndicators" data-slide-to="3" class=""></li>
                                  </ol>
                                  <div class="carousel-inner">
                                  <div class="carousel-item active">
                                          <div class="info-box bg-gradient-info " >
                                            <div class="col-lg-12" style="text-align:center;">
                                              <table style="width:100%;">
                                                  <tr>
                                                      <td colspan="2">User Registered</td>
                                                      <td></td>
                                                  </tr>
                                                  <tr>
                                                      <td>Today : <?=$result[0]['user_today']?></td>
                                                      <td></td>
                                                  </tr>
                                                  <!-- <tr>
                                                      <td>This week : <?=$result[0]['user_week']?></td>
                                                      <td></td>
                                                  </tr> -->
                                                  <tr>
                                                      <td>This month : <?=$result[0]['user_month']?></td>
                                                      <td></td>
                                                  </tr>
                                                  <tr>
                                                      <td>This year : <?=$result[0]['user_year']?></td>
                                                      <td></td>
                                                  </tr>
                                                  <tr>
                                                      <td><br></td>
                                                      <td></td>
                                                  </tr>
                                              </table>
                                              
                                            </div>

                                          </div>

                                      </div>

                                  </div>
                                  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                                      data-slide="prev">
                                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                      <span class="sr-only">Previous</span>
                                  </a>
                                  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                                      data-slide="next">
                                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                      <span class="sr-only">Next</span>
                                  </a>
                              </div>


                          </div>
                          <!-- /.card-body -->
                      </div>
                      <!-- /.card -->
                  <?php } // else { ?>
                    <div class="row">
                      <div class="col-lg-3 col-6">
                        <!-- small card -->
                        <a href="oshe">
                        <div class="small-box bg-info center">
                          <div class="inner">
                            <h3>USERS</h3>

                            <!-- <p>New Orders</p> -->
                          </div>
                          <div class="icon">
                            <!-- <i class="fas fa-shopping-cart"></i> -->
                          </div>
                          <a href="#" class="small-box-footer">
                          Module User  
                          <!-- <i class="fas fa-arrow-circle-right"></i> -->
                          </a>
                        </div></a>
                      </div>
                      <!-- ./col -->

                      <?php
                          if($_SESSION['t']=="ADMIN")
                          {
                          ?>   
                          <!-- ./col -->
                          <div class="col-lg-3 col-6">
                                      <!-- small card -->
                                      <a href="statistic">
                                      <div class="small-box bg-purple center">
                                        <div class="inner">
                                          <h3>Statistics</h3>

                                          <!-- <p>User Registrations</p> -->
                                        </div>
                                        <div class="icon">
                                          <!-- <i class="fas fa-user-plus"></i> -->
                                        </div>
                                        <a href="statistic" class="small-box-footer">
                                        <i class="nav-icon fas fa-chart-bar"></i> Statistics
                                          <!-- <i class="fas fa-arrow-circle-right"></i> -->
                                        </a>
                                      </div></a>
                                    </div>

                          <?php } ?>
                    </div>

                  </div>

              </div>
  

          </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->

  </div>

  <script>
  function goto(link)
  {
      window.location=link;
  }
  </script>
<?php
// }
?>