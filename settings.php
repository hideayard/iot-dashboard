

<?php
//auto
// $q_column = "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='smart' AND `TABLE_NAME`='sesi'";
// $d_columns = $db->rawQuery($q_column);
//end of auto
if($tipe_user!="ADMIN")//$tipe_user
{
  echo "<script>Swal.fire(
                      'Info!',
                      'You are not authorized!',
                      'info'
                      );
                console.log('You Are Not Authorized ');
                setTimeout(function(){ window.location='home'; }, 1000);
                </script>";

}
$table = "settings";
$txt_field= "settings_id,settings_type, settings_name, settings_value, settings_status";
$txt_label = "Type,Name,Value,Status";
$q_field = explode(",",$txt_field);
$q_label = explode(",",$txt_label);
$i=1;
// $query = "select ".$q_field[0] ." as " .$q_label[0];
// for($i;$i<count($q_field);$i++)
// {
//     $query .= ",".$q_field[$i] ." as " .$q_label[$i];
// }
// $query .= " from $table";
$query = "SELECT $txt_field FROM $table "; 

$data = $db->rawQuery($query);
// var_dump($data);die;
// if(!check_role($page,'*'))
// {
//   echo "<script>alert('You are not permitted!!!');window.location='home';</script>";
// }
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
            <h1>Data Settings</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home">Home</a></li>
              <li class="breadcrumb-item active">Settings</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <!-- <h3 class="card-title">List Data Sesi</h3> -->
              <a href="addsettings" ><button type="button" class="btn btn-success">
                  Add Settings
                </button></a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <?php
                  echo "<th>No</th>";
                  echo "<th>Action</th>";

                    foreach ($q_label as $key => $value) {
                      echo "<th>".$value."</th>";
                      // var_dump($value);
                    }
  
                  ?>
                </tr>
                </thead>
                <tbody>
                <?php
               
if(count($data)>0)
{
  $fields = explode(",",$txt_field);
  array_shift($fields);
  // var_dump($fields);
  foreach($data as $key => $value)
    {
      echo "<tr>";
      echo "<td>".($key+1)."</td>";
      echo "<td>";
      
      if($tipe_user == "ADMIN")
      {
        echo '<a href="index.php?page=settingform&mode=edit&settings_id='.$value["settings_id"].'" class="btn btn-primary"><span><i class="fa fa-edit"></i></span></a> | <a onclick="actiondelete(\'settings\',\'settings\','.$value["settings_id"].')" class="btn btn-danger"><span><i class="fa fa-trash"></i></span></a>' ;
      }
      else
      {
        echo '<a href="index.php?page=settingform&settings_id='.$value["settings_id"].'" class="btn btn-primary"><span><i class="fa fa-eye"></i></span></a> ';
      }
                  
      echo "</td>";
      
      foreach($fields as $key2 => $value2)
      {
        echo "<td>". $value[trim($value2)] . "</td>";
      }
      echo "</tr>";
    }
}

                ?>
                </tbody>
                <!-- <tfoot>
                <tr> -->
                <?php
                    // foreach ($q_label as $key => $value) {
                    //   echo "<th>".$value."</th>";
                    // }
                  ?>
                <!-- </tr>
                </tfoot> -->
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
 

