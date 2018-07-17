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
            'id'=>'terima-form',
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

                if(!$is_kabupaten_allow){
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
                        <?php if($is_batch_baru){ ?>
                            <input type="number" id="jumlah_ruta" class="form-control"></input>
                            <input type="hidden" name="jumlah_ruta" v-model.number="jumlah_ruta"></input>
                            <input type="hidden" id="hid_jumlah_ruta" value="0"></input>

                            <div class="text-center">
                                <br/><button id="btn-generate" type="button" class="btn btn-success btn-sm"><i class="fa fa-fighter-jet"></i> Masukkan RUTA</button>
                                <a href="<?php echo Yii::app()->createUrl('sipmen/import', array('id'=>$model_bs->nks_sutas, 'kab'=>$model_bs->idKab)); ?>" class="btn btn-success btn-sm"><i class="fa fa-file-excel-o"></i> Import From Excel</a>
                            </div>
                        <?php } else{ ?>
                            <input type="number" value="<?php echo $model_bs->jml_terima; ?>" class="form-control" disabled></input>
                            <input type="hidden" name="jumlah_ruta" v-model.number="jumlah_ruta"></input>
                            <input type="hidden" id="hid_jumlah_ruta" value="<?php echo $model_bs->jml_terima; ?>"></input>

                            <div class="text-center">
                                <br/><button id="btn-generate" type="button" class="btn btn-success btn-sm" disabled><i class="fa fa-fighter-jet"></i> Masukkan RUTA</button>
                            </div>
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
                            <td><input type="number" :id="'noruta'+index" :name="'noruta'+index" class="form-control" placeholder="nomor ruta tani"></input></td>
                            <td><input type="text" :id="'nama'+index" :name="'nama'+index" class="form-control" placeholder="nama kepala ruta"></input></td>
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
                                echo '<tr><td><input type="number" value="'.$existing_ruta->noruta.'" id="noruta'.$i.'" name="noruta'.$i.'" class="form-control" placeholder="nomor ruta tani"></input></td>';
                                echo '<td><input type="text" value="'.$existing_ruta->namakrt.'" id="nama'.$i.'" name="nama'.$i.'" class="form-control" placeholder="nama kepala ruta"></input></td>';
                                echo '<td><button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button></td>';
                                echo '</tr>';
                            }else{
                                echo '<tr><td><input type="number" id="noruta'.$i.'" name="noruta'.$i.'" class="form-control" placeholder="nomor ruta tani"></input></td>';
                                echo '<td><input type="text" id="nama'.$i.'" name="nama'.$i.'" class="form-control" placeholder="nama kepala ruta"></input></td>';
                                echo '<td><button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button></td>';
                                echo '</tr>'; 
                            }
                        }
                        ?>
                        <tr v-for="(row, index) in tambahan_ruta">
                            <td><input type="number" :id="'noruta'+(index+asal_ruta)" :name="'noruta'+(index+asal_ruta)" class="form-control" placeholder="nomor ruta tani"></input></td>
                            <td><input type="text" :id="'nama'+(index+asal_ruta)" :name="'nama'+(index+asal_ruta)" class="form-control" placeholder="nama kepala ruta"></input></td>
                        </tr>
                    <?php } ?>
                  
                  </tbody>
                </table>

              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->


          </div>


        <div class="alert alert-danger alert-dismissible" v-if="is_error">No urut ruta pertanian masih salah</div>
          <!-- /. box -->
            <?php echo CHtml::submitButton('Simpan', array('class'=>"btn btn-success btn-block margin-bottom")); ?>
        </div>
        
        <?php } ?>
        <?php $this->endWidget(); ?>
      </div>

</div>

<script src="<?php echo Yii::app()->theme->baseUrl; ?>/dist/js/vue_page/site/terima.js"></script>