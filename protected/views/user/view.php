<div class="box box-info">
	<div class="mailbox-controls">
		<b><?php echo $model->username; ?></b>
		<div class="pull-right">
			<?php echo CHtml::link("<i class='fa fa-list'></i> Daftar User", array('index'), array('class'=>'btn btn-default btn-sm toggle-event')) ?>
			<?php echo CHtml::link("<i class='fa fa-plus'></i> Tambah", array('create'), array('class'=>'btn btn-default btn-sm toggle-event')) ?>
			<?php echo CHtml::link("<i class='fa fa-pencil'></i> Perbaharui", array('update', 'id'=>$model->id), array('class'=>'btn btn-default btn-sm toggle-event')) ?>
			<?php echo CHtml::link("<i class='fa fa-trash'></i> Hapus", "#", array("submit"=>array('delete', 'id'=>$model->id), 'confirm' => 'Anda yakin ingin menghapus data ini?', 'class'=>'btn btn-default btn-sm toggle-event')) ?>
		</div>
	</div>

	<div class="box-body">

		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				'id',
				'username',
				'email',
				//'password',
				'unit_kerja',
				//'unit_kerja',
				'created_time',
				'last_login',
			),
		)); ?>
	</div>
</div>