
$(document).ready(function()
    {
       //$('#provinsi').hide();
       $('#provinsi').change(function() {
           var id = $(this).val();
           
           $.ajax({
                url: "module/leasing/get_data.php",
                data: "id_prov="+id,
                cache: false,
                      success: function(msg){
                         $('#kota').html(msg);
                                       
                     }
            });
       });
        // Validation
        $("#create").validate({
            rules:{
                
                nama:"required",      
                kota:"required",      
            },

            messages:{
                nama:"Field nama tidak boleh kosong",
                kota:"Mohon pilih salah satu",
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
