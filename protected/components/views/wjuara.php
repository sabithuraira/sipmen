<div class="box box-widget widget-user">
    <div class="widget-user-header <?php echo "bg-".$this->color."-active" ?>">
        <h3 class="widget-user-username"><?php echo $this->kab_name; ?></h3>
        <h5 class="widget-user-desc"><?php echo $this->title_name; ?></h5>
        <a type="button" href="<?php echo $this->url ?>" class="btn btn-default btn-sm">Selengkapnya</a>
    </div>
    <div class="widget-user-image">
        <img class="img-circle" src="<?php echo Yii::app()->theme->baseUrl."/dist/img/logo_bps.png" ?>">
    </div>
    <div class="box-footer">
        <div class="row">
        <div class="col-sm-4 border-right">
            <div class="description-block">
            <h5 class="description-header"><?php echo $this->kegiatan; ?></h5>
            <span class="description-text">KEGIATAN</span>
            </div>
            <!-- /.description-block -->
        </div>
        <!-- /.col -->
        <div class="col-sm-4 border-right">
            <div class="description-block">
            <h5 class="description-header"><?php echo $this->target; ?></h5>
            <span class="description-text">TARGET</span>
            </div>
            <!-- /.description-block -->
        </div>
        <!-- /.col -->
        <div class="col-sm-4">
            <div class="description-block">
            <h5 class="description-header"><?php echo $this->point; ?></h5>
            <span class="description-text">POINT</span>
            </div>
            <!-- /.description-block -->
        </div>
        <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
</div>