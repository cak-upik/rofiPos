//
$(document).ready(function()
    {
       //$('#create_pengelola').hide();
        // Validation
        $("#create_pegawai").validate({
            rules:{
                
                nama:"required",
                tempat:"required",
                tgl_lahir:"required",
                id_jabatan:"required",
                
				username:"required",
                
                cpwd:{required:true,equalTo: "#password"},
                alamat:"required",
                no_telp:{required:true,digits:true, maxlength: 12     }
            },

            messages:{
                    nama:"Field Nama tidak boleh kosong",
                    tempat:"Field Tempat Lahir tidak boleh kosong",
                    tgl_lahir:"Field Tanggal Lahir tidak boleh kosong",
                    id_jabatan:"Field ID Jabatan tidak boleh kosong",
                
                cpwd:{
                    required:"Field konfirmasi password tidak boleh kosong",
                    equalTo:"Password and Confirm Password harus sama"
                },
                no_telp:{required:"Field Nomor Telepon tidak boleh kosong",
                    digits:"Telepon anda tidak valid",
                    maxlength:"Nomor terlalu banyak"
                },
                alamat:"Field Alamat tidak boleh kosong",
                
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
