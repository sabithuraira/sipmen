  <aside class="main-sidebar">
    <section class="sidebar">
      <ul class="sidebar-menu">         
      <li class="header">MONITORING</li>
        <?php 
          echo '<li><a href="'.Yii::app()->createUrl('site/index').'"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>';
        ?>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-bicycle"></i>
            <span>Monitoring Kegiatan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php 
              echo '<li><a href="'.Yii::app()->createUrl('site/tagihan').'"><i class="fa fa fa-circle-o"></i> Tagihan Kerja</a></li>';
              echo '<li><a href="'.Yii::app()->createUrl('site/calendar').'"><i class="fa fa fa-circle-o"></i> Kalender Kegiatan</a></li>';
            ?>
            
            <?php 
              $list_provinsi = HelpMe::getListProvinsi();

              foreach($list_provinsi as $row){
                echo '<li><a href="'.Yii::app()->createUrl('site/bidang',array('id'=> $row['id'])).'"><i class="fa fa fa-circle-o"></i> '.$row['label'].'</a></li>';
              }
            ?>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-line-chart"></i>
            <span>Peringkat dan Nilai</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <?php 
              echo '<li><a href="'.Yii::app()->createUrl('site/peringkat').'"><i class="fa fa fa-circle-o"></i> Peringkat Tahunan</a></li>';
              echo '<li><a href="'.Yii::app()->createUrl('site/peringkat_month').'"><i class="fa fa fa-circle-o"></i> Peringkat Bulanan</a></li>';

              echo '<li class="treeview"><a href="#"><i class="fa fa-circle-o"></i> Nilai Kabupaten/Kota
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>';
              echo '<ul class="treeview-menu">';
              $list_kabupaten=HelpMe::getListKabupaten();              
              foreach($list_kabupaten as $row){
                echo '<li><a href="'.Yii::app()->createUrl('report/kabupaten',array('id'=> $row['id'])).'"><i class="fa fa fa-circle-o"></i> '.$row['label'].'</a></li>';
              }
              echo '</ul></li>';
            ?>
          </ul>
        </li>


        <!-- <li class="treeview">
          <a href="#">
            <i class="fa fa-money"></i>
            <span>Anggaran</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/charts/chartjs.html"><i class="fa fa fa-circle-o"></i> Report</a></li>
            <li><a href="pages/charts/chartjs.html"><i class="fa fa fa-circle-o"></i> Kelola Data PAGU</a></li>
            <li><a href="pages/charts/chartjs.html"><i class="fa fa fa-circle-o"></i> Kelola Rencana Penarikan</a></li>
            <li><a href="pages/charts/chartjs.html"><i class="fa fa fa-circle-o"></i> Kelola Anggaran</a></li>
            <li><a href="pages/charts/chartjs.html"><i class="fa fa fa-circle-o"></i> Import Data</a></li>
          </ul>
        </li> -->


        <li class="treeview">
          <a href="#">
            <i class="fa fa-tasks"></i>
            <span>Laporan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php
              echo '<li><a href="'.Yii::app()->createUrl('report/index').'"><i class="fa fa fa-circle-o"></i> Per Kegiatan</a></li>';
              echo '<li><a href="'.Yii::app()->createUrl('report/rekap').'"><i class="fa fa fa-circle-o"></i> Bulanan</a></li>';
            ?>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa fa-money"></i>
            <span>Anggaran</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php
              echo '<li><a href="'.Yii::app()->createUrl('indukkegiatan/dashboard').'"><i class="fa fa-circle-o"></i> <span>Progress</span></a></li>';
              echo '<li><a href="'.Yii::app()->createUrl('indukkegiatan/grafik').'"><i class="fa fa-circle-o"></i> <span>Grafik</span></a></li>';

              echo '<li class="treeview"><a href="#"><i class="fa fa-circle-o"></i> Anggaran Unit Kerja
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>';
              echo '<ul class="treeview-menu">';
              $list_prov=HelpMe::getListProvinsi();          
              foreach($list_prov as $row){
                echo '<li><a href="'.Yii::app()->createUrl('indukkegiatan/uk3',array('id'=> $row['id'])).'"><i class="fa fa fa-circle-o"></i> '.$row['label'].'</a></li>';
              }
              $list_kabupaten=HelpMe::getListKabupaten();              
              foreach($list_kabupaten as $row){
                echo '<li><a href="'.Yii::app()->createUrl('indukkegiatan/uk3',array('id'=> $row['id'])).'"><i class="fa fa fa-circle-o"></i> '.$row['label'].'</a></li>';
              }
              echo '</ul></li>';
              // echo '<li><a href="'.Yii::app()->createUrl('report/index').'"><i class="fa fa fa-circle-o"></i> Per Kegiatan</a></li>';
              // echo '<li><a href="'.Yii::app()->createUrl('report/rekap').'"><i class="fa fa fa-circle-o"></i> Bulanan</a></li>';
            ?>
          </ul>
        </li>

<!--         
        <li class="header">TUGAS DAN DINAS LUAR</li>

        <?php if(!Yii::app()->user->isGuest){ ?>
          <li><a href="<?php echo Yii::app()->createUrl('jadwalTugas/create'); ?>"><i class="fa fa-bicycle"></i><span> Buat Surat Tugas</span></a></li>
          <li><a href="<?php echo Yii::app()->createUrl('jadwalTugas/index'); ?>"><i class="fa fa-bicycle"></i><span> Manajemen Surat Tugas</span></a></li>
        <?php } ?>
        <li><a href="<?php echo Yii::app()->createUrl('jadwalTugas/calendar'); ?>"><i class="fa fa-calendar"></i><span> Kalender Tugas dan DL</span></a></li>
        <li><a href="<?php echo Yii::app()->createUrl('jadwalTugas/single_calendar'); ?>"><i class="fa fa-calendar-plus-o"></i><span> Kalender Pegawai</span></a></li>
         -->
        <li class="header">WILAYAH</li>
        <?php 
          echo '<li><a href="'.Yii::app()->createUrl('mfd/index').'"><i class="fa fa-map-o"></i> Wilayah Sumatera Selatan</a></li>';
        ?>
        <?php if(Yii::app()->user->isKabupaten()==0){ ?>
          <li class="header">LAINNYA</li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-align-justify"></i>
              <span>Master Data</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <?php 
                echo '<li><a href="'.Yii::app()->createUrl('user/index').'"><i class="fa fa-user"></i> User</a></li>';
                echo '<li><a href="'.Yii::app()->createUrl('pegawai/index').'"><i class="fa fa-user-plus"></i> Pegawai</a></li>';
                echo '<li><a href="'.Yii::app()->createUrl('unitdaerah/index').'"><i class="fa  fa-bookmark-o"></i> Unit Kerja Kab/Kota</a></li>';
                
                echo '<li><a href="'.Yii::app()->createUrl('kegiatan/index').'"><i class="fa fa-cube"></i> Kegiatan</a></li>';
                
                echo '<li class="treeview"><a href="#"><i class="fa fa-money"></i> Anggaran
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>';
                echo '<ul class="treeview-menu">';
                if(Yii::app()->user->getLevel()==1){
                  echo '<li><a href="'.Yii::app()->createUrl('output/index').'"><i class="fa fa-circle-o"></i> Output</a></li>';
                  echo '<li><a href="'.Yii::app()->createUrl('indukkegiatan/index').'"><i class="fa fa-circle-o"></i> Komponen</a></li>';
                }
                // echo '<li><a href="'.Yii::app()->createUrl('k_anggaran/index').'"><i class="fa fa fa-circle-o"></i> Kegiatan</a></li>';
                echo '</ul></li>';

                echo '<li><a href="'.Yii::app()->createUrl('unitkerja/index').'"><i class="fa fa-building-o"></i> Unit Kerja</a></li>';
                echo '<li><a href="'.Yii::app()->createUrl('mitrabps/index').'"><i class="fa fa-circle-o"></i> Mitra BPS</a></li>';
              ?>
            </ul>
          </li>
        <?php } ?>


      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>