<?php
class EWebUser extends CWebUser{
 
    protected $_model;
 
    protected function loadUser()
    {
        if ( $this->_model === null ) {
                $this->_model = User::model()->findByPk($this->id);
        }
        return $this->_model;
    }
    
    //1=top admin, 2=admin kabupaten, 0=member
    function getLevel()
    {
        $user=$this->loadUser();
        if($user)
            return $user->type_user;
        return 100;
    }

     function getUnitKerja()
    {
        $user=$this->loadUser();
        if($user)
            return $user->unit_kerja;
        return 100;
    }

    function isKabupaten()
    {
        $result=0;

        if(!Yii::app()->user->isGuest){
            $id=$this->id;
            $sql="SELECT uk.jenis FROM mem_user u, unit_kerja uk WHERE u.unit_kerja=uk.id AND u.id={$id}";
            $return_val=Yii::app()->db->createCommand($sql)->queryScalar();

            if($return_val==2)
                $result=1;
        }
        else{
            //mean not login
            $result = 100;
        }

        return $result;
    }
}