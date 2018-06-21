<div class="box box-info">
	<div class="mailbox-controls">
		<b>Update User <?php echo $model->username; ?></b>
		<div class="pull-right">
			<?php echo CHtml::link("<i class='fa fa-list'></i> Daftar User", array('index'), array('class'=>'btn btn-default btn-sm toggle-event')) ?>
			<?php echo CHtml::link("<i class='fa fa-plus'></i> Tambah", array('create'), array('class'=>'btn btn-default btn-sm toggle-event')) ?>
			<?php echo CHtml::link("<i class='fa fa-search'></i> Detail", array('view', "id"=>$model->id), array('class'=>'btn btn-default btn-sm toggle-event')) ?>
			<?php 
				if(Yii::app()->user->getLevel()==1){
					echo CHtml::link("<i class='fa fa-lock'></i> Ganti Password", array('cpadmin',"id"=>$model->id), array('class'=>'btn btn-default btn-sm toggle-event'));
				}
			?>
		</div>
	</div>

	<div class="box-body">
		<?php $this->renderPartial('_form', array('model'=>$model)); ?>
	</div>
</div>