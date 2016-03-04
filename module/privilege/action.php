<?php
include"../../conf/connect.php";
if($_GET['act'] == 'save'){
    
    $params=$_POST['master_privilege'];
    foreach ($params['detail'] as $row2) {
         
         $execute=mysql_query("insert into tb_detail_hak_akses (id_jabatan, id_hak_akses) 
             values (
             '" . mysql_real_escape_string(trim(htmlentities($_POST['id_jabatan']))) . "' ,
             '". mysql_real_escape_string(trim(htmlentities($row2['id_hak_akses']))). "' ) ");
    }
    if($execute){
            header('Location: ../../index.php?r=privilege&page=view&status=sukses');
    }
    else header('Location: ../../index.php?r=privilege&page=view&status=gagal');
	
}
elseif($_GET['act'] == 'delete'){
    
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $delete=  mysql_query("delete from tb_detail_hak_akses where id_jabatan='$id'");
        
        if($delete){
            header('Location: ../../index.php?r=privilege&page=view&status=deleted');
        }
        else header('Location: ../../index.php?r=privilege&page=view&status=gagal');
    }
    else header('Location: ../../index.php?r=privilege&page=view&status=gagal');
    
}
elseif($_GET['act'] == 'edit'){
    $params=$_POST['master_privilege'];
    
    if(isset($params['detail']) && isset($params['delete'])){
        foreach ($params['detail'] as $row2) {         
            $execute2=mysql_query("insert into tb_detail_hak_akses (id_hak_akses, id_user) 
             values ('". mysql_real_escape_string(trim(htmlentities($row2['id_hak_akses']))). "' ,
                 '" . mysql_real_escape_string(trim(htmlentities($_POST['id_user']))) . "') ");
        }
        
        foreach ($params['delete'] as $row) {         
            $execute1=mysql_query("delete from tb_detail_hak_akses where id_hak_akses='$row[delId]'");
        }
        
        if($execute1){
            if($execute2){
                header('Location: ../../index.php?r=privilege&page=view&status=edited');
            }else{
                header('Location: ../../index.php?r=privilege&page=view&status=gagal2');
            }       
        }
        else header('Location: ../../index.php?r=privilege&page=view&status=gagal1');
    }
    
    elseif(isset($params['delete'])){
        foreach ($params['delete'] as $row) {
            //if($row['delId'] > 1){
                $execute1=mysql_query("delete from tb_detail_hak_akses where id_hak_akses='$row[delId]' and id_jabatan='$_POST[id_jabatan]'");
            //}
        }
        if($execute1){            
                header('Location: ../../index.php?r=privilege&page=view&status=edited');
        }
        else header('Location: ../../index.php?r=privilege&page=view&status=gagal1');
    }
    
    elseif(isset($params['detail'])){
        foreach ($params['detail'] as $row2) {         
            $execute2=mysql_query("insert into tb_detail_hak_akses (id_jabatan, id_hak_akses) 
             values ('". mysql_real_escape_string(trim(htmlentities($_POST['id_jabatan']))). "' ,
                 '" . mysql_real_escape_string(trim(htmlentities($row2['id_hak_akses']))) . "') ");
        }
        if($execute2){            
                header('Location: ../../index.php?r=privilege&page=view&status=edited');
        }
        else header('Location: ../../index.php?r=privilege&page=view&status=gagal1');
    }
    
    
}


?>