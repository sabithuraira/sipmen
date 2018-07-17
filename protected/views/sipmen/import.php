<div id="terima_tag">
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


        <div class="col-md-9">
            <div class="box box-success">
                <div class="box-body">
                    <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'mkab-form',
                        'enableAjaxValidation'=>false,
                        'htmlOptions'=>array(
                        'enctype'=>'multipart/form-data',
                        ),
                    )); ?>
                        <?php if($is_batch_baru){ ?>
                        <p class="note">Pastikan data yang anda import sudah sesuai dengan format yang ditetapkan dan tidak ada nomor urut RT yang terlewat</p>

                        <?php echo $form->errorSummary($model); ?>

                        <div class="form-group">
                            <?php echo $form->fileField($model,'filename', array('class'=>'form-control')); ?>
                            <?php echo $form->error($model,'filename'); ?>
                        </div>

                        <?php
                            echo CHtml::link("Download template", Yii::app()->baseUrl.'/upload/temp/sipmen_sutas.xlsx');
                        ?>
                        <br/>

                        <div>
                            <?php echo CHtml::submitButton('Import', array('class'=>"btn btn-success btn-block margin-bottom")); ?>
                        </div>
                        <?php } else{ ?>
                            <h2>Menu "Import Excel" tidak tersedia karena data pada NKS ini sudah ada</h2>
                        <?php } ?>

                    <?php $this->endWidget(); ?>
                </div>
            </div>
        </div>
    </div>

</div>