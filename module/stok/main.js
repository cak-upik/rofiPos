
$(document).ready(function()
{
    $('#search').keyup(function() {
        var filter = $(this).val();
        $.ajax({
            url: "module/stok/service.php",
            data: "search=" + filter,
            cache: false,
            success: function(msg) {
                $("#listStok").html(msg);
            }
        });
    });

    $("#create").validate({
        rules: {
            nama: "required",
            alamat: "required",
            no_telp: {required: true, digits: true, maxlength: 12},
        },
        messages: {
            no_telp: {required: "Field Nomor Telepon boleh kosong",
                digits: "Mohon masukkan angka",
                maxlength: "Nomor terlalu banyak"
            },
            nama: "Field Nama tidak boleh kosong",
            alamat: "Field Alamat tidak boleh kosong",
        },
        errorClass: "help-inline",
        errorElement: "span",
        highlight: function(element, errorClass, validClass)
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