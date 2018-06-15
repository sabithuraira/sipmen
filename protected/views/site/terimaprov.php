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
        if($model_bs->status_kirim==''){
            echo '<div class="alert alert-danger alert-dismissible">
              <h4><i class="icon fa fa-ban"></i> Error!</h4>
              NKS Ini belum melewati proses Pengiriman</div>';
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
        <h3 class="box-title">Daftar Rumah Tangga Diterima BPS Provinsi</h3>
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
                    $all_ruta_edit = MRuta::model()->findAllByAttributes(
                        array(
                            'nobatch'	=>$nextBatch['label'],
                        ),
                        array(
                            'condition' =>'status >=3',
                        )
                    );
                    
                    foreach($all_ruta_edit as $key=>$value){
                        $is_checked = '';
                        if($value->status==4)
                            $is_checked='checked';

                        echo '<tr><td><input id="prov'.$value['noruta'].'" name="prov'.$value['noruta'].'" type="checkbox" '.$is_checked.'></td><td>'.$value->namakrt.'</td>';
                        echo '<td><button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button></td>';
                        echo '</tr>';
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