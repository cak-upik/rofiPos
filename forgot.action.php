
<?php
include"conf/connect.php";
include "conf/fungsi_thumb.php";
include"conf/library.php";
include"conf/service.php";
include"extensions/smtpmail/PHPMailer.php";

if(isset($_GET['act'])){
    if($_GET['act'] == 'email'){
        if(isset($_POST['email'])){
            $check=emailExist($_POST['email']);
            if($check > 0){
                $key=createKey($_POST['email']);
                $body='Dear,<br/> Click this link to reset your password :
                                        <a href="localhost/ahass/forgot.php?act=reset&id='.$key.'">http://localhost/ahass/forgot.php?act=reset&id='.$key.'</a>';
                $to = $_POST['email'];
                $subject =  'Reset Password';
                $mail = new PHPMailer();
                $mail->IsSMTP();
                $mail->CharSet = 'UTF-8';
                $mail->Host       = "smtp.gmail.com"; // SMTP server example
                //$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for    testing)
                $mail->SMTPAuth   = true;                  // enable SMTP authentication
                $mail->Port       = 587;                    // set the SMTP port for the GMAIL server
                $mail->SMTPSecure = 'tls';
                $mail->Username   = "miftasp@gmail.com"; // SMTP account username example
                $mail->Password   = "jembot23";
                $mail->Mailer = "smtp";
                $mail->SetFrom('miftasp@gmail.com', 'PT Astra Honda');
                $mail->Subject = $subject;
                $mail->AddAddress($to, "");
                $mail->MsgHTML($body);

                if(!$mail->Send()) {
                    echo "Mailer Error: " . $mail->ErrorInfo;
                    exit;
                }else{
                    $expires = time()+(60*60*24*1);
                    $save=mysql_query("insert into tb_expired_link (linkkey, expires) values (
                                 '". mysql_real_escape_string(trim(htmlentities($key))) . "',
                                 '". mysql_real_escape_string(trim(htmlentities($expires))) . "')");
                    if($save){
                        header('location:forgot.php?status=sukses');
                    }
                }
            }else{
                header('location:forgot.php?status=gagal');
            }

        }
    }
    elseif($_GET['act'] === 'reset'){
        $execute =mysql_query("update tb_pegawai set
                            password ='". mysql_real_escape_string(trim(htmlentities(base64_encode($_POST['password'])))). "'
                         where email='". $_POST['email'] ."' ");

        if($execute){
            
            echo "<script>alert('Password Anda berhasil direset');</script>";
            header('Location: login.php');
        }else{
            
            echo "<script>alert('Maaf permintaan gagal dieksekusi');</script>";
            header('Location: login.php');
        }
    }
}
/*
$usercheck=mysql_real_escape_string(trim(htmlentities($_POST['username'])));
$passcheck=mysql_real_escape_string(trim(htmlentities($_POST['password'])));

$check=  mysql_fetch_array(mysql_query("select count(id_pegawai) as hasil from tb_pegawai where username='$usercheck'"));
if($check['hasil'] == 1){
    $execute=  mysql_query("update tb_pegawai set 
                            password ='". mysql_real_escape_string(trim(htmlentities(base64_encode($_POST['password'])))). "' 
                         where username='$_POST[username]'");
            if($execute){
                header('Location: login.php?status=sukses');
            }else{
                header('Location: forgot.php?status=gagal');
            }
}else{
    header('Location: forgot.php?status=gagal');
}
        */

?>
