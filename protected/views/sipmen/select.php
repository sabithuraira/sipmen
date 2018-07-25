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

                    <?php if($model_bs->status_terima!=1){ ?>
                    <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'login-form',
                        'enableClientValidation'=>true,
                        'clientOptions'=>array(
                            'validateOnSubmit'=>true,
                        ),
                        'htmlOptions'=>array(
                            'enctype'=>'multipart/form-data',
                        ),
                        )); 
                    ?>
                    
                    <?php if(strlen($naname)>1){ ?>
                        <div class="form-group">
                            <label>Pilih Excel Sheet</label>
                            <input type="hidden" name="naname" value=<?php echo $naname;?>>
                            <?php echo CHtml::dropDownList('listname','',CHtml::listData($model->getSheet($naname), 'id', 'label'),array('empty'=>'- Select Data -', 'class'=>'form-control')); ?>
                        </div>
                    <?php } ?>
                    
                    <div>
                        <?php echo CHtml::submitButton('Import', array('class'=>"btn btn-success btn-block margin-bottom")); ?>
                    </div>
                    
                    <?php $this->endWidget(); ?>

                    <?php } else{ ?>
                            <h2>Menu "Import Excel" tidak tersedia karena data pada NKS ini sudah ada</h2>
                        <?php } ?>

                </div>
            </div>
        </div>
    </div>
</div>