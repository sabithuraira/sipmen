<div id="index_tag">
      <div class="row">
        <div class="col-md-3">
        <?php $form=$this->beginWidget('CActiveForm', array(
          'action'=>Yii::app()->createUrl($this->route),
          'method'=>'POST',
        )); ?>
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Filter Wilayah</h3>
            </div>
            <div class="box-body no-padding">
              <ul class="nav nav-pills nav-stacked">
                <li>

                  <?php
                    echo CHtml::dropDownList("prov_id", "16",
                        CHtml::listData(MProv::model()->findAll(), "idProv", "kodeNama"),
                        array('class'=>'form-control'));
                  ?>
                </li>
                <li>
                  <?php
                    echo CHtml::dropDownList("kab_id", $model->idKab,
                        CHtml::listData(MKab::model()->findAll(), "idKab", 'kodeNama'),
                        array('empty'=>'- Semua Kabupaten -', 'class'=>'form-control'));
                  ?>
                </li>
                <li>
                  <?php
                    $data_kec = array();
                    if($model->idKab!=null){
                      $data_kec = CHtml::listData(
                        MKec::model()->findAllByAttributes(array('idProv'=>'16', 'idKab'=>$model->idKab)),
                        'idKec', 'kodeNama');
                    }

                    echo CHtml::dropDownList("kec_id", $model->idKec,
                        $data_kec,
                        array('empty'=>'- Kecamatan -', 'class'=>'form-control'));
                  ?>
                </li>
                <li>
                  <?php

                    $data_desa = array();
                    if($model->idKab!=null && $model->idKec!=null){
                      $data_desa = CHtml::listData(
                        MDesa::model()->findAllByAttributes(array('idProv'=>'16', 'idKab'=>$model->idKab, 'idKec'=>$model->idKec)),
                        'idDesa', 'kodeNama');
                    }
                  
                    echo CHtml::dropDownList("desa_id", $model->idDesa,
                        $data_desa,
                        array('empty'=>'- Desa -', 'class'=>'form-control'));
                  ?>
                </li>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>

          <div class="loading">
            <img class="loading_image"  height="50" width="50" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/loading.gif" /><br/>
            <b class="loading_message">Loading...</b>
          </div>

          <?php echo CHtml::submitButton('Cari', array('class'=>"btn btn-success btn-block margin-bottom")); ?>
          <?php $this->endWidget(); ?>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Rekap Progres Dokumen</h3>

              <div class="box-tools pull-right">
                <div class="has-feedback">
                  <!-- <input type="text" class="form-control input-sm" placeholder="Cari Blok Sensus">
                  <span class="glyphicon glyphicon-search form-control-feedback"></span> -->
                </div>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              
              <div class="table-responsive mailbox-messages">

                <table class="table table-hover table-bordered table-condensed">
                        <tr>
                            <th>Wilayah</th>
                            <th>Jumlah BS</th>
                            <th>Terima TU (L1/L2)</th>
                            <th>Editing (L1/L2)</th>
                            <th>Kirim Prov (L1/L2)</th>
                            <th>Terima Provinsi (L1/L2)</th>
                        </tr>

                        <?php
                          $total_bs = 0;
                          $total_terima = 0;
                          $total_terima_ruta = 0;
                          $total_kirim = 0;
                          $total_kirim_ruta = 0;
                          $total_editing = 0;
                          $total_editing_ruta = 0;
                          $total_terima_prov = 0;
                          $total_terima_prov_ruta = 0;

                            foreach($data as $key=>$value){

                                $total_bs += $value['total_bs'];
                                $total_terima += $value['terima'];
                                $total_terima_ruta += $value['terima_ruta'];
                                $total_kirim += $value['kirim'];
                                $total_kirim_ruta += $value['kirim_ruta'];
                                $total_editing += $value['editing'];
                                $total_editing_ruta += $value['editing_ruta'];
                                $total_terima_prov += $value['terima_prov'];
                                $total_terima_prov_ruta += $value['terima_prov_ruta'];
                                echo '<tr>';
                                    echo '<td>('.$value['kode'].') '.$value['nama'].'</td>';
                                    echo '<td>'.$value['total_bs'].'</td>';
                                    echo '<td>'.$value['terima'].' / '.$value['terima_ruta'].'</td>';
                                    echo '<td>'.$value['editing'].' / '.$value['editing_ruta'].'</td>';
                                    echo '<td>'.$value['kirim'].' / '.$value['kirim_ruta'].'</td>';
                                    echo '<td>'.$value['terima_prov'].' / '.$value['terima_prov_ruta'].'</td>';
                                echo '</tr>';
                            }
                        ?>

                        <tr>
                            <th>TOTAL</th>
                            <th><?php echo $total_bs; ?></th>
                            <th><?php echo $total_terima.' / '.$total_terima_ruta; ?></th>
                            <th><?php echo $total_editing.' / '.$total_editing_ruta; ?></th>
                            <th><?php echo $total_kirim.' / '.$total_kirim_ruta; ?></th>
                            <th><?php echo $total_terima_prov.' / '.$total_terima_prov_ruta; ?></th>
                        </tr>
                </table>

              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->


            <div class="box-footer no-padding">
              
            </div>


          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>

</div>

<script src="<?php echo Yii::app()->theme->baseUrl; ?>/dist/js/vue_page/site/index.js"></script>