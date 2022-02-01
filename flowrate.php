

<?php
//auto
// $q_column = "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='smart' AND `TABLE_NAME`='sesi'";
// $d_columns = $db->rawQuery($q_column);
//end of auto
// if($tipe_user!="ADMIN")//$tipe_user
// {
//   echo "<script>Swal.fire(
//                       'Info!',
//                       'You are not authorized!',
//                       'info'
//                       );
//                 console.log('You Are Not Authorized ');
//                 setTimeout(function(){ window.location='home'; }, 1000);
//                 </script>";

// }
// $table = "settings";
// $txt_field= "settings_id,settings_type, settings_name, settings_value, settings_status";
// $txt_label = "Type,Name,Value,Status";
// $q_field = explode(",",$txt_field);
// $q_label = explode(",",$txt_label);
// $i=1;
// // $query = "select ".$q_field[0] ." as " .$q_label[0];
// // for($i;$i<count($q_field);$i++)
// // {
// //     $query .= ",".$q_field[$i] ." as " .$q_label[$i];
// // }
// // $query .= " from $table";
// $query = "SELECT $txt_field FROM $table "; 

// $data = $db->rawQuery($query);
// // var_dump($data);die;
// // if(!check_role($page,'*'))
// // {
// //   echo "<script>alert('You are not permitted!!!');window.location='home';</script>";
// // }
?>
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  <!-- Theme style -->

<div class="wrapper">



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Data Flow Rate </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home">Home</a></li>
              <li class="breadcrumb-item active">Flow Rate</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title"> Flow Rate & Conductivity Data </p>
                  <div class="row">
                    <div class="col-12">
                      <div class="table-responsive">
                        <table id="flowrate" class="display expandable-table" style="width:100%">
                          <thead>
                            <tr>
                                <th>ID#</th>
                                <th>Date</th>
                                <th>Conductivity</th>
                                <th>Flow Rate</th>
                                <th>Device</th>
                              <th></th>
                            </tr>
                          </thead>
                      </table>
                      </div>
                    </div>
                  </div>
                  </div>
                </div>
              </div>
            </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
 