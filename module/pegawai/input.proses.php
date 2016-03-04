<?php
include"../../conf/connect.php";
include "../../conf/fungsi_thumb.php";
include"../../conf/library.php";


$image=stripslashes($_FILES['image']['name']);
    if($image) {
	   require_once "input.proses.image.php";           
    } 		
    else{
        $execute=mysql_query("insert into tb_pegawai (nama, alamat, tempat, tgl_lahir, no_telp, email, username, password, id_jabatan ) 
                     values (
                             '". mysql_real_escape_string(trim(htmlentities($_POST['nama']))) . "' ,
                             '". mysql_real_escape_string(trim(htmlentities($_POST['alamat']))) . "' ,
                             '". mysql_real_escape_string(trim(htmlentities($_POST['tempat']))) . "' ,
                             '". mysql_real_escape_string(trim(htmlentities($_POST['tgl_lahir']))) . "' ,
                             '". mysql_real_escape_string(trim(htmlentities($_POST['no_telp']))) . "' ,
                             '". mysql_real_escape_string(trim(htmlentities($_POST['email']))) . "' ,
                             '". mysql_real_escape_string(trim(htmlentities($_POST['username']))) . "' ,
                             '". mysql_real_escape_string(trim(htmlentities(base64_encode($_POST['password'])))) . "',
                             '". mysql_real_escape_string(trim(htmlentities($_POST['id_jabatan']))) . "') ");
       $lastId = mysql_insert_id();	
            if($execute){
                header('Location: ../../index.php?r=pegawai&page=view&status=sukses');
            }else{
                header('Location: ../../index.php?r=pegawai&page=view&status=gagal');
            }
    }
    //var_dump($execute);        exit();
    

?>
