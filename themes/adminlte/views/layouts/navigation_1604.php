<aside class="main-sidebar">
    <section class="sidebar">
      <ul class="sidebar-menu">         
      
        <li class="header">MONITORING EVALUASI KINERJA PEGAWAI BPS</li>

        <?php if(!Yii::app()->user->isGuest){ ?>
          <li><a href="<?php echo Yii::app()->createUrl('kegiatan_mitra'); ?>"><i class="fa fa-bicycle"></i><span> Daftar Kegiatan Mitra BPS</span></a></li>
          <?php
            echo '<li><a href="'.Yii::app()->createUrl('pegawai/index').'"><i class="fa fa-user-plus"></i> Pegawai</a></li>';
            echo '<li><a href="'.Yii::app()->createUrl('mitrabps/index').'"><i class="fa fa-user-plus"></i> Mitra BPS</a></li>';
            echo '<li><a href="'.Yii::app()->createUrl('pertanyaan/index').'"><i class="fa fa-user-plus"></i> Pertanyaan</a></li>';

            echo '<li class="treeview"><a href="#"><i class="fa fa-circle-o"></i> Rapor Penilaian Kinerja
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>';

            echo '<ul class="treeview-menu">';
              echo '<li><a href="'.Yii::app()->createUrl('pegawai/rapor').'"><i class="fa fa-user-plus"></i> Pegawai</a></li>';
              echo '<li><a href="'.Yii::app()->createUrl('mitrabps/rapor').'"><i class="fa fa-user-plus"></i> Mitra BPS</a></li>';
            echo '</ul></li>';
          ?>
          
        <?php } ?>


      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

