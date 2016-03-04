<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">

	<title>Ahass</title>
	
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

</head>

<body class="login">
<script>
    $(document).ready(function()
    {
       //$('#create_pengelola').hide();
        // Validation
        $("#forgot_page").validate({
            rules:{
                
                email:{required:true,email: true}
            },

            messages:{
                email:{
                    required:"Field email tidak boleh kosong",
                    email:"Email salah"
                }
                
                
                },

            errorClass: "help-inline",
            errorElement: "span",
            highlight:function(element, errorClass, validClass)
            {
                $(element).parents('.control-group').addClass('error');
            },
            unhighlight: function(element, errorClass, validClass)
            {
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.control-group').addClass('success');
            }
        });
    
    
		
    });
</script>


<div class="account-container login stacked">
	
	<div class="content clearfix">
		<?php
                if(isset($_GET['act'])){
                    if($_GET['act'] === 'reset'){
                        if(isset($_GET['id'])){
                            require_once"conf/service.php";
                            require_once"conf/connect.php";
                            $check=checkKey($_GET['id']);
                            if($check > 0){
                                $find=mysql_fetch_array(mysql_query("select * from tb_expired_link where linkkey='".$_GET['id']."'"));
                                if($find['expires'] >= time()){
                                    list($email, $timer)= explode('||', base64_decode($_GET['id']));
                                    ?>
                                    <div id="login">

                                        <h3>Reset Kata Sandi</h3>

                                        <h5>Silahkan masukkan Password Baru Anda</h5>

                                        <form id="validate-enhanced" action="forgot.action.php?act=reset" class="form parsley-form" method="post">
                                            
                                            <div class="login-fields">
				

                                                <div class="field">
                                                        <label for="email">Username:</label>
                                                        <input type="text" id="email" name="email" value="<?php echo $email; ?>" class="login username-field" readonly />
                                                </div> <!-- /field -->

                                                <div class="field">
                                                        <label for="password">Password Baru:</label>
                                                        <input type="password" id="password" name="password" value="" placeholder="Password Baru" class="login password-field"/>
                                                </div> <!-- /password -->

                                                <div class="field">
                                                        <label for="password">Ulangi Password:</label>
                                                        <input type="password" id="password2" name="password2" value="" placeholder="Ulangi Password" class="login password-field"/>
                                                </div> <!-- /password -->

                                        </div> <!-- /login-fields -->

                                        <div class="login-actions">
                                                <span class="login-checkbox">

                                                        <label class="choice" for="Field">Link pemulihan kata sandi akan dikirim melalui email Anda</label>
                                                </span>		
                                                <button class="button btn btn-primary btn-large">Proses</button>

                                        </div> <!-- .actions -->
                                        </form>

                                    </div> <!-- /#login -->
                                    <?php
                                }
                                else{
                                    echo "<script>alert('Link yang anda tuju telah kadaluarsa');</script>";
                                    header( 'Location: page_error/error-403.php' ) ;
                                }
                            }else{
                                echo "<script>alert('Link yang anda tuju tidak ditemukan');</script>";
                                header( 'Location: page_error/error-404.php' ) ;
                            }

                        }else
                        header( 'Location: page_error/error-404.php' ) ;
                
                
                    }
                }else{
                ?>
		<form action="forgot.action.php?act=email" method="post" id="forgot_page">
		
			<h1>Lupa Password</h1>		
			
			<div class="login-fields">
				
				<p>Silahkan masukkan Email Anda.</p>
				
				<div class="field">
					<label for="email">Email:</label>
					<input type="text" id="email" name="email" value="" placeholder="Email" class="login username-field" />
				</div> <!-- /field -->
				
			</div> <!-- /login-fields -->
			
			<div class="login-actions">
				<span class="login-checkbox">
					
					<label class="choice" for="Field"><a href="login.php">Kembali ke halaman login.</a></label>
				</span>		
				<button class="button btn btn-primary btn-large">Proses</button>
				
			</div> <!-- .actions -->
			
			
		</form>
                <?php } ?>
		
	</div> <!-- /content -->
	
</div> <!-- /account-container -->





<script src="js/libs/jquery-1.7.2.min.js"></script>
<script src="js/libs/jquery-ui-1.8.21.custom.min.js"></script>
<script src="js/libs/jquery.ui.touch-punch.min.js"></script>

<script src="js/libs/bootstrap/bootstrap.min.js"></script>
<script src="js/jquery.validate.js"></script>

<script src="js/signin.js"></script>

</body>
</html>
