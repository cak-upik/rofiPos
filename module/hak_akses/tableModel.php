<?php
function showTable() {
    $query = mysql_query("select * from tb_hak_akses order by hak_akses");
    $total = mysql_num_rows($query);

    $no = $posisi + 1;
    while ($result = mysql_fetch_array($query)) {
        echo"<tr>
            <td>$no</td>
            <td>$result[hak_akses]</td>
            <td style='text-align: center'>
                <a href='index.php?r=hak_akses&page=edit&id=$result[id_hak_akses]' title='Edit' class='btn btn-inverse'><i class='icon-edit'></i> Edit</a>
                <a href='module/hak_akses/delete.php?id=$result[id_hak_akses]' title='Delete' onClick=\"return confirm ('Are you sure?')\" class='btn btn-danger'><i class='icon-remove'></i> Delete</a>
            </td>                                                   
         </tr>";
        $no++;
    }
}

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
