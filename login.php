<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">

        <title>PT. MEJI SAKTI</title>

        <meta name="description" content="">
        <meta name="author" content="">

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">

        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,600,800">
        <link rel="stylesheet" href="css/font-awesome.css">

        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/bootstrap-responsive.css">

        <link rel="stylesheet" href="./css/ui-lightness/jquery-ui-1.8.21.custom.css">	

        <link rel="stylesheet" href="css/application.css">

        <script src="js/libs/modernizr-2.5.3.min.js"></script>

        <style type="text/css">
            <!--
            .login table tr th p marquee {
                font-size: xx-large;
            }
            .login table tr th p marquee {
                color: #069;
                font-size: x-large;
            }
            -->
        </style>
    </head>

    <body class="login">
        <table width="1100" height="30" border="0" align="center">
            <tr>
                <th scope="col"><p>
            <marquee behavior="alternate">
                SELAMAT DATANG DI SISTEM INFORMASI MANAJEMEN KEUANGAN PT. MEJI SAKTI
            </marquee>
        </p></th>
</tr>
</table>
<p>&nbsp;</p>
<div class="account-container login stacked">
    <div class="content clearfix">

        <form action="cek_login.php" method="post">

            <h1>User Login</h1>		

            <div class="login-fields">

                <p>Silahkan masukkan username dan password Anda.</p>

                <div class="field">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" value="" placeholder="Username" class="login username-field" />
                </div> <!-- /field -->

                <div class="field">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" value="" placeholder="Password" class="login password-field"/>
                </div> <!-- /password -->

            </div> <!-- /login-fields -->

            <div class="login-actions">

                <span class="login-checkbox">

                    <label class="choice" for="Field"><a href="forgot.php">Lupa Password??</a></label>
                </span>

                <button class="button btn btn-primary btn-large">Masuk</button>

            </div> <!-- .actions -->


        </form>

    </div> <!-- /content -->

</div> <!-- /account-container -->





<script src="js/libs/jquery-1.7.2.min.js"></script>
<script src="js/libs/jquery-ui-1.8.21.custom.min.js"></script>
<script src="js/libs/jquery.ui.touch-punch.min.js"></script>

<script src="js/libs/bootstrap/bootstrap.min.js"></script>

<script src="js/signin.js"></script>

</body>
</html>
