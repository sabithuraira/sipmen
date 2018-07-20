
  <header class="main-header">
  <nav class="navbar navbar-static-top">
    <div class="container">
      <div class="navbar-header">
        <a href="<?php echo Yii::app()->createUrl('site/index') ?>" class="navbar-brand">Sipmen<b>SUTAS</b></a>
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
          <i class="fa fa-bars"></i>
        </button>


        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- User Account Menu -->
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Progress <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="<?php echo Yii::app()->createUrl('report/index'); ?>">Per Wilayah</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('report/user'); ?>">Per Petugas Provinsi</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>

      <!-- /.navbar-collapse -->
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          

          <li class="dropdown user user-menu">
            <?php 
              if(Yii::app()->user->isGuest){ 
                echo CHtml::link("Login", array("site/login"));
              }
              else{  
            ?>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <span class="hidden-xs">Hallo <?php echo Yii::app()->user->name; ?> !</span>
              </a>
              
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                  <p>
                    Selamat datang <?php echo Yii::app()->user->name; ?>. Salam PIA!
                    <small>Salam PIA..</small>
                  </p>
                </li>
                
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                  <?php echo CHtml::link("Change Password", array("user/cp"),array('class'=>'btn btn-default btn-flat') ) ?>
                  </div>
                  <div class="pull-right">
                    <?php echo CHtml::link("Sign Out", array("site/logout"),array('class'=>'btn btn-default btn-flat') ) ?>
                  </div>
                </li>
              </ul>
            <?php } ?>
          </li>
        </ul>
      </div>
      <!-- /.navbar-custom-menu -->
    </div>
    <!-- /.container-fluid -->
  </nav>
</header>