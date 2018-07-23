<div id="cetak_tag">
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

          <?php echo CHtml::submitButton('Filter', array('class'=>"btn btn-info btn-block margin-bottom")); ?>
          <?php $this->endWidget(); ?>
            <button id="cetak-surat"  onclick="tableToExcel();" class="btn btn-success btn-block margin-bottom">Cetak Surat Pengantar</button>
        </div>
        <!-- /.col -->
        <div class="col-md-9">


          <div class="loading">
            <img class="loading_image"  height="50" width="50" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/loading.gif" /><br/>
            <b class="loading_message">Loading...</b>
          </div>
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Daftar Blok Sensus Sampel</h3>

              <div class="box-tools pull-right">
                <div class="has-feedback">
                </div>
              </div>
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
                <table class="table table-hover table-bordered table-condensed">
                    <tr>
                        <th></th>
                        <th>Kab/Kota</th>
                        <th>Kecamatan</th>
                        <th>Kel/Desa</th>
                        <th>NBS</th>
                        <th>NKS</th>
                        <th>NKS SUTAS</th>
                        <th>Jumlah</th>
                        <th>Tanggal Terima</th>
                    </tr>

                    <tr v-for="(row, index) in wils">

                        <td><input :id="'no'+index" :name="'no'+index"  v-model="selected_index" :value="index" type="checkbox"></td>
                        <td>{{ row.nmKab }}</td>
                        <td>{{ row.nmKec }}</td>
                        <td>{{ row.nmDesa }}</td>
                        <td>{{ row.nbs }}</td>
                        <td>{{ row.nks }}</td>
                        <td>{{ row.nks_sutas }}</td>
                        <td>{{ row.jml_terima_prov }}</td>
                        <td>{{ row.tgl_terima_prov }}</td>
                    </tr>
                </table>

                <table id="initabel" style="display:none" class="table table-hover table-bordered table-condensed">
                    <tr>
                        <th colspan="6">
                            Kepada Yth,<br/>
                            Kepala Bidang IPDS<br/>
                            BPS Provinsi Sumsel
                        </th>
                        <th colspan="2">Palembang, <?php echo date('d')." ".date("M")." ".date("Y"); ?></th>
                    </tr>
                    <tr><th colspan="8"></th></tr>
                    <tr><th colspan="8"></th></tr>
                    <tr>
                        <th>Kab/Kota</th>
                        <th>Kecamatan</th>
                        <th>Kel/Desa</th>
                        <th>NBS</th>
                        <th>NKS</th>
                        <th>NKS SUTAS</th>
                        <th>Jumlah</th>
                        <th>Tanggal Terima</th>
                    </tr>

                    <tr v-for="(row, index) in selected_wil">
                        <td>{{ row.nmKab }}</td>
                        <td>{{ row.nmKec }}</td>
                        <td>{{ row.nmDesa }}</td>
                        <td>{{ row.nbs }}</td>
                        <td>{{ row.nks }}</td>
                        <td>{{ row.nks_sutas }}</td>
                        <td>{{ row.jml_terima_prov }}</td>
                        <td>{{ row.tgl_terima_prov }}</td>
                    </tr>

                    <tr><th colspan="8"></th></tr>
                    <tr><th colspan="8"></th></tr>
                    <tr>
                        <th colspan="6"></th>
                        <th colspan="2">
                            Kasubbag Umum,<br/>
                            BPS Prov. Sumsel<br/>
                        </th>
                    </tr>
                    <tr><th colspan="8"></th></tr>
                    <tr>
                        <th colspan="6"></th>
                        <th colspan="2">HADIRMAN</th>
                    </tr>
                </table>
              </div>
            </div>

            <div class="box-footer no-padding"></div>
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>

</div>

<script src="<?php echo Yii::app()->theme->baseUrl;?>/plugins/iCheck/icheck.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl; ?>/dist/js/vue_page/report/cetak.js"></script>