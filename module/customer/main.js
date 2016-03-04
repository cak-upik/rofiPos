
$(document).ready(function()
    {
       //$('#create_pengelola').hide();
        // Validation
        $("#create").validate({
            rules:{
                
                name:"required", 
                alamat:"required", 
                no_ktp:"required", 
                tempat_lahir:"required", 
				tanggal_lahir:"required", 
				pekerjaan:"required", 
                phone:{required:true,digits:true, maxlength: 12     },
            },

            messages:{
                no_telp:{required:"Field Nomor Telepon boleh kosong",
                    digits:"Mohon masukkan angka",
                    maxlength:"Nomor terlalu banyak"
                },
                name:"Field Nomor polisi boleh kosong", 
                alamat:"Field tipe motor boleh kosong", 
                no_ktp:"Field nama pemilik boleh kosong", 
                tempat_lahir:"Field alamat pemilik boleh kosong", 
				tanggal_lahir:"Field alamat pemilik boleh kosong",
				pekerjaan:"Field alamat pemilik boleh kosong",
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
