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
        <!-- /.col -->
        
        <?php $form=$this->beginWidget('CActiveForm', array(
            'enableAjaxValidation'=>false,
        )); ?>
        <div class="col-md-9">
            <div class="box box-success">
                <div class="box-body">
                    <div class="form-group">
                        <?php echo "Nomor Batch"; ?>
                        <input type="text" value="<?php echo $nextBatch['label'] ?>" id="no_batch" name="no_batch" class="form-control" disabled></input>
                    </div>

                    <div class="form-group">
                        <?php echo "Jumlah Ruta"; ?>
                        <?php if($is_batch_baru){ ?>
                            <input type="number" name="jumlah_ruta" v-model.number="jumlah_ruta" class="form-control"></input>
                            <input type="hidden" id="hid_jumlah_ruta" value="0"></input>
                        <?php } else{ ?>
                            <input type="number" value="<?php echo $model_bs->jml_terima; ?>" class="form-control" disabled></input>
                            <input type="hidden" name="jumlah_ruta" v-model.number="jumlah_ruta"></input>
                            <input type="hidden" id="hid_jumlah_ruta" value="<?php echo $model_bs->jml_terima; ?>"></input>
                        <?php } ?>


                    </div>
                </div>
            </div>

          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Daftar Rumah Tangga Diterima</h3>
              <!-- /.box-tools -->
              <?php 
                if(!$is_batch_baru){
                    echo '<div class="pull-right"><button type="button" id="btn_tambah" class="btn btn-default btn-sm"><i class="fa fa-plus"></i> Tambah Ruta</button></div>';
                }
              ?>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                  <tbody>

                    <?php if($is_batch_baru){ ?>
                        <tr v-for="(row, index) in jumlah_ruta">
                            <td><input type="text" :id="'nama'+index" :name="'nama'+index" class="form-control" placeholder="masukkan nama ruta"></input></td>
                        </tr>
                    <?php } else{
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
                                echo '<tr><td><input type="text" value="'.$existing_ruta->namakrt.'" id="nama'.$i.'" name="nama'.$i.'" class="form-control" placeholder="masukkan nama ruta"></input></td>';
                                echo '<td><button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button></td>';
                                echo '</tr>';
                            }else{
                                echo '<tr><td><input type="text" id="nama'.$i.'" name="nama'.$i.'" class="form-control" placeholder="masukkan nama ruta"></input></td>';
                                echo '<td><button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button></td>';
                                echo '</tr>'; 
                            }
                        }
                        ?>
                        <tr v-for="(row, index) in tambahan_ruta">
                            <td><input type="text" :id="'nama'+(index+asal_ruta)" :name="'nama'+(index+asal_ruta)" class="form-control" placeholder="masukkan nama ruta"></input></td>
                        </tr>
                    <?php
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
            <?php echo CHtml::submitButton('Simpan', array('class'=>"btn btn-success btn-block margin-bottom")); ?>
        </div>
        
        <?php $this->endWidget(); ?>
        <!-- /.col -->
      </div>

</div>

<script src="<?php echo Yii::app()->theme->baseUrl; ?>/dist/js/vue_page/site/terima.js"></script>