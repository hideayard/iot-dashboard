<?php

function check_active($key,$string)
{
    //cara 1 : pakai array
    $result = explode(",",$string);
    foreach($result as $k => $v)
    {
        if($key==$v)
        {
            return 'aria-expanded="true"';
        }
        else  
        {
            return 'aria-expanded="false"';
        }
    }

}
?>

 <!-- partial:partials/_sidebar.html -->
 <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#dashboard" aria-expanded="false" aria-controls="dashboard">
              <i class="icon-cog menu-icon"></i>
              <span class="menu-title">Dashboard</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="dashboard">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                  <a class="nav-link" href="index.php" <?=check_active($page,'home')?> >
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">Line</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="gauge" <?=check_active($page,'gauge')?> >
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">Gauge</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>

          

          <!-- <li class="nav-item">
            <a class="nav-link"  <?=check_active($page,'bot_setting')?>  href="bot_setting">
            <i class="icon-contract menu-icon"></i>
              <span class="menu-title">FAQ Setting</span>
            </a>
          </li> -->

          <?php
          if($id_user!="" && ( $tipe_user=="ADMIN" || $tipe_user=="BIRO_JODOH") )
          {
          ?>

          <!-- <li class="nav-item">
            <a class="nav-link"  <?=check_active($page,'pretest')?>  href="pretest">
              <i class="icon-paper menu-icon"></i>
              <span class="menu-title">Pre-Test</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link"  <?=check_active($page,'kriteria')?>  href="kriteria">
              <i class="icon-contract menu-icon"></i>
              <span class="menu-title">Kriteria Setting</span>
            </a>
          </li> -->

          <?php
          }
          ?>

          <li class="nav-item">
            <a class="nav-link"  <?=check_active($page,'profile')?>  href="profile">
              <i class="icon-head menu-icon"></i>
              <span class="menu-title">Profile</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#lastmenu" aria-expanded="false" aria-controls="lastmenu">
              <i class="icon-cog menu-icon"></i>
              <span class="menu-title">Menu</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="lastmenu">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="settings"> Setting </a></li>
                <li class="nav-item"> <a class="nav-link" href="logout.php"> Logout </a></li>
              </ul>
            </div>
          </li>

        </ul>
      </nav>
      <!-- partial -->