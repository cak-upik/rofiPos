<?php
function combotgl($awal, $akhir, $var, $terpilih){
  echo "<select name=$var id=$var>";
  //echo "<option value='' selected>-- Pilih --</option>";
  for ($i=$awal; $i<=$akhir; $i++){
    $lebar=strlen($i);
    switch($lebar){
      case 1:
      {
        $g="0".$i;
        break;     
      }
      case 2:
      {
        $g=$i;
        break;     
      }      
    }  
    if ($i==$terpilih)
      echo "<option value=$g selected>$g</option>";
    else
      echo "<option value=$g>$g</option>";
  }
  echo "</select> ";
}

function combobln($awal, $akhir, $var, $terpilih){
  echo "<select name='$var' id='$var'>";
  for ($bln=$awal; $bln<=$akhir; $bln++){
    $lebar=strlen($bln);
    switch($lebar){
      case 1:
      {
        $b="0".$bln;
        break;     
      }
      case 2:
      {
        $b=$bln;
        break;     
      }      
    }  
      if ($bln==$terpilih)
         echo "<option value=$b selected>$b</option>";
      else
        echo "<option value=$b>$b</option>";
  }
  echo "</select> ";
}

function combothn($awal, $akhir, $var, $terpilih){
  echo "<select name='$var' id='$var' class='inline'>";
//  echo "<option value='' selected>Pilih</option>";
  for ($i=$awal; $i<=$akhir; $i++){
    
      //echo "<option value=$i>$i</option>";
      if ($i == $terpilih) {
            echo "<option value=$i selected>$i</option>";
        } else {
            echo "<option value=$i>$i</option>";
        }
    }
  echo "</select> ";
}

function combonamabln($awal, $akhir, $var, $terpilih){
  $nama_bln=array(1=> "Januari", "Februari", "Maret", "April", "Mei", 
                      "Juni", "Juli", "Agustus", "September", 
                      "Oktober", "November", "Desember");
  echo "<select name=$var id=$var class='inline'>";
//  echo "<option value='0' selected>-Pilih-</option>";
  for ($bln=$awal; $bln<=$akhir; $bln++){
      $lebar=strlen($bln);
    switch($lebar){
      case 1:
      {
        $b="0".$bln;
        break;     
      }
      case 2:
      {
        $b=$bln;
        break;     
      }      
    }  
    if ($bln == $terpilih) {
            echo "<option value=$b selected>$nama_bln[$bln]</option>";
        } else {
            echo "<option value=$b>$nama_bln[$bln]</option>";
        }
    }
  echo "</select> ";
}