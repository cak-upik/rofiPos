<?php

function checkPrivilege($nip, $priv){
    
    $query=mysql_query("select count(t5.nama_hak_akses) as tot
                from tb_pegawai t1 inner join tb_login t2 
                    on t1.nip=t2.id_pegawai 
                inner join tb_user t3 
                    on t1.id_user = t3.id_user 
                inner join tb_detil_hak_akses t4 
                    on t3.id_user = t4.id_user 
                inner join tb_hak_akses t5 
                    on t4.id_hak_akses=t5.id_hak_akses 
                inner join tb_menu t6 
                    on t5.id_menu=t6.id_menu
                where t1.nip='$nip' and nama_hak_akses='$priv'");
    $result=  mysql_fetch_array($query);
    if($result['tot'] == 1){
        return 'allow';
    } else{
        return 'deny';	
    }
}	

?>
