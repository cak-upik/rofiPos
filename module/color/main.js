
$(document).ready(function()
    {
       //$('#create').hide();
        // Validation
        $("#create").validate({
            rules:{
                
                jenis_pekerjaan:"required",      
                kode_jenis_pekerjaan:"required",      
                id_kategori_pekerjaan:"required",      
            },

            messages:{
                jenis_pekerjaan:"Field jenis pekerjaan tidak boleh kosong",
                kode_jenis_pekerjaan:"Field kode jenis pekerjaan tidak boleh kosong",      
                id_kategori_pekerjaan:"Field kategori pekerjaan tidak boleh kosong",   
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
