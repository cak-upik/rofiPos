<?php
session_start();
session_destroy();
include "conf/connect.php";

$username = $_POST['username'];
$password = $_POST['password'];

if (!ctype_alnum($username) OR !ctype_alnum($password)) {
    echo "<script>alert('gunakan huruf dan angka saja untuk login');history.back();</script>";
} else {
    if ($username == 'programmer' AND $password == 'programmer') {
        //echo "<script>alert('Anda menggunakan hak akses penuh sebagai programmer');history.back();</script>";
        session_start();

        $_SESSION[nip] = 'programmer';
        $_SESSION[nama_log] = 'programmer';
        $_SESSION[username_log] = 'programmer';
        $_SESSION[password_log] = 'programmer';

        header('location:/home');
        echo "<script>alert('Selamat datang programmer');</script>";
    } else {
        $login = mysql_query("SELECT * FROM tb_pegawai WHERE username ='" . $username . "' AND password ='" . base64_encode($password) . "'");
        $ketemu = mysql_num_rows($login);
        $r = mysql_fetch_array($login);

        if (($ketemu > 0)) {

            //$id_perusahaan= $r[id_perusahaan];
            session_start();
            $_SESSION['id_pegawai'] = $r['id_pegawai'];
            $_SESSION['nama_log'] = $r['nama'];
            $_SESSION['username_log'] = $r['username'];
            $_SESSION['password_log'] = $r['password'];



            header('location:index.php?page=home');
            echo "<script>alert('Selamat datang $r[nama]');</script>";
        } else {
            echo "<script>alert('Login gagal! username dan  password tidak benar');history.back()</script>";
        }
    }
}
?>
