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
              <h3 class="box-title">Daftar Blok Sensus Sampel</h3>

              <div class="box-tools pull-right">
                <div class="has-feedback">
                  <input type="text" class="form-control input-sm" placeholder="Cari Blok Sensus">
                  <span class="glyphicon glyphicon-search form-control-feedback"></span>
                </div>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              
              <div class="table-responsive mailbox-messages">
                <!-- <table class="table table-hover table-striped">
                  <tbody>
                  <tr>
                    <td><input type="checkbox"></td>
                    <td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a></td>
                    <td class="mailbox-name"><a href="read-mail.html">Alexander Pierce</a></td>
                    <td class="mailbox-subject"><b>AdminLTE 2.0 Issue</b> - Trying to find a solution to this problem...
                    </td>
                    <td class="mailbox-attachment"></td>
                    <td class="mailbox-date">5 mins ago</td>
                  </tr>
                  
                  </tbody>
                </table> -->

                <?php 
                  $this->widget('zii.widgets.grid.CGridView', array(
                    'id'=>'pegawai-grid',
                    'dataProvider'=>$model->search(),

                    'summaryText'=>Yii::t('penerjemah','Menampilkan {start}-{end} dari {count} hasil'),
                    'pager'=>array(
                      'header'=>Yii::t('penerjemah','Ke halaman : '),
                      'prevPageLabel'=>Yii::t('penerjemah','Sebelumnya'),
                      'nextPageLabel'=>Yii::t('penerjemah','Selanjutnya'),
                      'firstPageLabel'=>Yii::t('penerjemah','Pertama'),
                      'lastPageLabel'=>Yii::t('penerjemah','Terakhir'),
                    ),
                    
                    'itemsCssClass'=>'table table-hover table-striped table-bordered table-condensed',
                  
                    'columns'=>array(
                      array(
                        'header' =>'Kab/Kota',
                        'type'=>'raw',
                        'value'		=> function($data){ return $data->idKab; }
                      ),
                      array(
                        'header' =>'Kec',
                        'type'=>'raw',
                        'value'		=> function($data){ return $data->idKec; }
                      ),
                      array(
                        'header' =>'Kel/Desa',
                        'type'=>'raw',
                        'value'		=> function($data){ return $data->idDesa; }
                      ),
                      
                      array(
                        'header' =>'NBS',
                        'type'=>'raw',
                        'value'		=> function($data){ return $data->nbs; }
                      ),
                      array(
                        'header' =>'NKS',
                        'type'=>'raw',
                        'value'		=> function($data){ return $data->nks; }
                      ),
                      array(
                        'header' =>'NKS SUTAS',
                        'type'=>'raw',
                        'value'		=> function($data){ return $data->nks_sutas; }
                      ),
                      array(
                        'header' =>'Jumlah Eligible',
                        'type'=>'raw',
                        'value'		=> function($data){ return $data->jml_eligible; }
                      ),
                      array(
                        'header' =>'STATUS TERIMA',
                        'type'=>'raw',
                        'value'		=> function($data){ return $data->statusTerimaLabel."<br/>Jumlah: ".$data->jml_terima."<br/> Tanggal: ".$data->tgl_terima."</br><div class='text-center link-progres'>".CHtml::link("INPUT", array('site/terima', 'id'=>$data->nks_sutas)).'</div>'; },
                      ),
                      array(
                        'header' =>'STATUS EDIT',
                        'type'=>'raw',
                        'value'		=> function($data){ return $data->statusEditLabel."<br/>Jumlah: ".$data->jml_edit."<br/>Jumlah Drop: ".$data->jml_drop."<br/> Tanggal: ".$data->tgl_edit."</br><div class='text-center link-progres'>".CHtml::link("INPUT", array('site/edit', 'id'=>$data->nks_sutas)).'</div>'; },
                      ),
                      array(
                        'header' =>'STATUS KIRIM',
                        'type'=>'raw',
                        'value'		=> function($data){ return $data->statusKirimLabel."<br/>Nomor: ".$data->nmr_kirim."<br/>Jumlah: ".$data->jml_kirim."<br/> Tanggal: ".$data->tgl_kirim."</br><div class='text-center link-progres'>".CHtml::link("INPUT", array('site/kirim', 'id'=>$data->nks_sutas)).'</div>'; },
                      ),
                      
                      array(
                        'header' =>'PENERIMAAN PROVINSI',
                        'type'=>'raw',
                        'value'		=> function($data){ return $data->statusTerimaProvLabel."<br/>Jumlah: ".$data->jml_terima_prov."<br/> Tanggal: ".$data->tgl_terima_prov."</br><div class='text-center link-progres'>".CHtml::link("INPUT", array('site/terimaprov', 'id'=>$data->nks_sutas)).'</div>'; },
                      ),
                      array(
                        'header' =>'BATCH',
                        'type'=>'raw',
                        'value'		=> function($data){ return $data->nobatch;  },
                      ),
                      // array(
                      //   'class'=>'CButtonColumn',
                      //   'template' => '{view} {update} {delete}',
                      //   'htmlOptions' => array('width' => 20),
                      //   'buttons'=>array(
                      //     'update'=>array(
                      //       'url'=>function($data){
                      //         return Yii::app()->createUrl("pegawai/update");
                      //       },
                      //     ),
                      //     'view'=>array(
                      //       'url'=>function($data){
                      //         return Yii::app()->createUrl("pegawai/view");
                      //       },
                      //     ),
                      //     'delete'=>array(
                      //       'url'=>function($data){
                      //         return Yii::app()->createUrl("pegawai/delete");
                      //       },
                      //       'label'=>'Hapus',
                      //     ),
                      //   ),
                      // ),
                    ),
                  )); 
                ?>

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