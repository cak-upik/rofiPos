
$(document).ready(function()
    {
       //$('#create').hide();
        // Validation
        $("#create").validate({
            rules:{
                
                nama_jabatan:"required",      
            },

            messages:{
                nama_jabatan:"Field nama jabatan tidak boleh kosong",
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
