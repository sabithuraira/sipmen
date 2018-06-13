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

                <li>
                    <div class="form-label">NKS: <?php echo $model_bs->nks; ?></div>
                </li>

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
          'action'=>Yii::app()->createUrl($this->route),
          'method'=>'POST',
        )); ?>
        <div class="col-md-9">
            <div class="box box-success">
                <div class="box-body">
                    <div class="form-group">
                        <?php echo "Nomor Batch"; ?>
                        <?php echo CHtml::textField('no_batch','',array('size'=>18,'maxlength'=>18, 'class'=>"form-control")); ?>
                    </div>


                    <div class="form-group">
                        <?php echo "Jumlah Ruta"; ?>
                        <input type="number" v-model.number="jumlah_ruta" class="form-control"></input>
                    </div>
                </div>
            </div>

          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Daftar Rumah Tangga</h3>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                  <tbody>

                    <tr v-for="(row, index) in jumlah_ruta">
                        <td><input type="text" :id="'nama'+index" class="form-control" placeholder="masukkan nama ruta"></input></td>
                    </tr>
                  
                  </tbody>
                </table>

              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->


          </div>
          <!-- /. box -->
            <?php echo CHtml::submitButton('Simpan', array('class'=>"btn btn-success btn-block margin-bottom")); ?>
        </div>
        
        <?php $this->endWidget(); ?>
        <!-- /.col -->
      </div>

</div>

<script src="<?php echo Yii::app()->theme->baseUrl; ?>/dist/js/vue_page/site/edit.js"></script>