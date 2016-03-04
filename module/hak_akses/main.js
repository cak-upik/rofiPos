
$(document).ready(function()
    {
       //$('#create').hide();
        // Validation
        $("#create").validate({
            rules:{
                
                hak_akses:"required"      
            },

            messages:{
                hak_akses:"Field Nama hak akses tidak boleh kosong"
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
    
        $("#btnTambah").click(function(){
             $(this).text(function(i, text){
                return text === "Tambah" ? "Batal" : "Tambah";
             });
            $("#frmTambah").toggle("slow");
            $("#table-hakakses").toggle("slow");
        });
        
        $("#btnEdit").click(function(){
//            $.ajax(options)
        });
    });
