<div class="box box-info">
	<div class="mailbox-controls">
		<b>User</b>
		<div class="pull-right">
			<?php echo CHtml::link("<i class='fa fa-plus'></i> Tambah User", array('create'), array('class'=>'btn btn-default btn-sm toggle-event')) ?>
		</div>
		<!-- /.pull-right -->
	</div>

	<?php
	Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('.search-form form').submit(function(){
		$('#user-grid').yiiGridView('update', {
			data: $(this).serialize()
		});
		return false;
	});
	");
	?>

	<div class="box-body">
	<?php $this->renderPartial('_search',array(
		'model'=>$model,
	)); ?>

		<?php $this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'user-grid',
			'dataProvider'=>$model->search(),
			// 'filter'=>$model,

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
				'username',
				'email',
				// 'password',
				// array(
				// 	'value'=>'$data->unitKerja->name'
				// ),

				array(
					'name'	=>'unit_kerja',
					'type'=>'raw',
					'value'		=> function($data){ return $data->unit_kerja; },
				),
				'created_time',
				/*
				'last_login',
				*/
				array(
					'class'=>'CButtonColumn',
					'template' => '{view} {update} {delete}',
					'htmlOptions' => array('width' => 20),
					'buttons'=>array(
						'update'=>array(
							'url'=>function($data){
									return Yii::app()->createUrl("user/update", array("id"=>$data->id));
							},
						),
						'view'=>array(
								'url'=>function($data){
									return Yii::app()->createUrl("user/view", array("id"=>$data->id));
							},
						),
						'delete'=>array(
							'url'=>function($data){
									return Yii::app()->createUrl("user/view", array("id"=>$data->id));
							},
							// 'visible'=>function ($row, $data){
							// 		return $data->judul_ind == NULL AND $data->judul_eng == NULL;
							// },
							'label'=>'Hapus',
						),
					),
				),
			),
		)); ?>
	</div>
</div>