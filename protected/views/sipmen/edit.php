<div id="edit_tag">
<div class="row">
  <div class="col-md-3">
    <div class="box box-solid">
      <div class="box-body no-padding">
        <ul class="nav nav-pills nav-stacked">
          <li>
            <div class="form-label"><?php echo $model_bs->labelProv; ?></div>
          </li>
          <li>
              <div class="form-label"><?php echo $model_bs->labelKab; ?></div>
          </li>
          <li>
              <div class="form-label"><?php echo $model_bs->labelKec; ?></div>
          </li>
          <li>
              <div class="form-label"><?php echo $model_bs->labelDesa; ?></div>
          </li>

          <li>
              <div class="form-label">NBS: <?php echo $model_bs->nbs; ?></div>
          </li>

          <li><div class="form-label">NKS: <?php echo $model_bs->nks; ?></div></li>

          <li>
              <div class="form-label">NKS SUTAS: <?php echo $model_bs->nks_sutas; ?></div>
          </li>
          <li>
              <div class="form-label"><b>RUTA ELIGIBLE: <?php echo $model_bs->jml_eligible; ?></b></div>
          </li>
        </ul>
      </div>
      <!-- /.box-body -->
    </div>
  </div>
  <!-- /.col -->
  
  <?php $form=$this->beginWidget('CActiveForm', array(
      'enableAjaxValidation'=>false,
  )); ?>
  <div class="col-md-9">
    <?php 
        $is_kabupaten_allow = false;
        if(Yii::app()->user->unitKerja == '00'){
            $is_kabupaten_allow = true;
        }
        else{
            if(Yii::app()->user->unitKerja != $model_bs->idKab){
                if($model_bs->idKab == '13' && Yii::app()->user->unitKerja=='05')
                    $is_kabupaten_allow = true;

                if($model_bs->idKab == '12' && Yii::app()->user->unitKerja=='03')
                    $is_kabupaten_allow = true;
            }
            else{
                $is_kabupaten_allow = true;
            }
        }

        if($nextBatch['label']==''){
            echo '<div class="alert alert-danger alert-dismissible">
              <h4><i class="icon fa fa-ban"></i> Error!</h4>
              NKS Ini belum melewati proses penerimaan di TU (Tata Usaha)</div>';
        }
        else if(!$is_kabupaten_allow){
            echo '<div class="alert alert-danger alert-dismissible">
            <h4><i class="icon fa fa-ban"></i> Error!</h4>
            Anda tidak berhak memasukkan data kabupaten ini</div>';
        }
        else{
    ?>

      <div class="box box-success">
          <div class="box-body">
              <div class="form-group">
                  <?php echo "Nomor Batch"; ?>
                  <input type="text" value="<?php echo $nextBatch['label'] ?>" id="no_batch" name="no_batch" class="form-control" disabled></input>
              </div>

              <div class="form-group">
                  <?php echo "Jumlah Ruta"; ?>
                    <input type="number" value="<?php echo $model_bs->jml_terima; ?>" class="form-control" disabled></input>
                    <input type="hidden" name="jumlah_ruta" value=<?php echo $model_bs->jml_terima; ?>></input>
              </div>
          </div>
      </div>

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Daftar Rumah Tangga Editing</h3>
        <!-- /.box-tools -->
      </div>
      <!-- /.box-header -->
      <div class="box-body no-padding">
        <div class="mailbox-controls">
            <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
            </button>
            <!-- /.pull-right -->
        </div>  


        <div class="table-responsive mailbox-messages">
          <table class="table table-hover table-striped">
            <tbody>
              <?php 
                  for($i=0;$i<$model_bs->jml_terima;++$i){
                      $noruta = '';
                      if($i+1 < 10)
                          $noruta = '00'.$i+1;
                      else if($i+1 >=10 && $i+1< 100)
                          $noruta = '0'.$i+1;
                      else if($i+1>=100 && $i+1< 1000)
                          $noruta = $i+1;

                      $existing_ruta = MRuta::model()->findByAttributes(array(
                          'nobatch'	=>$nextBatch['label'],
                          'noruta'	=>$noruta
                      ));

                      if($existing_ruta!=null){
                          $is_checked = '';
                          $is_checked_disable = '';
                          $is_disable = 'disabled';
                          $btn_class = 'btn-default';
                          $is_drop_val = 0;
                            if($existing_ruta->status>=2 && $existing_ruta->status<=4){
                                $is_checked='checked';
                            }
                            else{
                                $is_disable = '';
                            }

                            if($existing_ruta->status == 9){
                                $btn_class = 'btn-info';
                                $is_checked_disable = 'disabled';
                                $is_drop_val = 1;
                            }

                          echo '<tr><td><input id="edit'.$i.'" name="edit'.$i.'" type="checkbox" '.$is_checked.' '.$is_checked_disable.'></td><td>('.$existing_ruta->noruta.') '.$existing_ruta->namakrt.'</td>';
                          echo '<td><button type="button" data-nid="'.$i.'" class="btn '.$btn_class.' btn-sm btn_drop"><i class="fa fa-trash-o"></i> drop</button></td>';
                          echo '<input type="hidden" value="'.$is_drop_val.'" id="is_drop'.$i.'" name="is_drop'.$i.'"></input>';
                          echo '<td><input type="text" id="drop'.$i.'" name="drop'.$i.'" class="form-control" value="'.$existing_ruta->ket_status.'" placeholder="keterangan" '.$is_disable.'></input></td>';
                          echo '</tr>';
                      }else{
                          echo '<tr><td><input id="edit'.$i.'" name="edit'.$i.'" type="checkbox"></td><td></td>';
                          echo '<td><button type="button" data-nid="'.$i.'" class="btn btn-default btn-sm btn_drop"><i class="fa fa-trash-o"></i> drop</button></td>';
                          echo '<input type="hidden" value="0" id="is_drop'.$i.'" name="is_drop'.$i.'"></input>';
                          echo '<td><input type="text" id="drop'.$i.'" name="drop'.$i.'" class="form-control" placeholder="keterangan" disabled></input></td>';
                          echo '</tr>'; 
                      }
                  }
              ?>
            </tbody>
          </table>

        </div>
        <!-- /.mail-box-messages -->
      </div>
      <!-- /.box-body -->


    </div>
    <!-- /. box -->
      <?php echo CHtml::submitButton('Simpan', array('class'=>"btn btn-success btn-block margin-bottom")); } ?>
  </div>
  
  <?php $this->endWidget(); ?>
  <!-- /.col -->
</div>

</div>

<script src="<?php echo Yii::app()->theme->baseUrl;?>/plugins/iCheck/icheck.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/dist/js/vue_page/site/edit.js"></script>