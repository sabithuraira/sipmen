<?php 
    $starTotal = 5;

    for($i=0;$i < $this->starNumber;++$i) 
        echo '<i class="fa fa-star text-yellow"></i>';

    for($j=0;$j<( $starTotal - $this->starNumber );++$j) 
        echo '<i class="fa fa-star text-muted"></i>';
?>
