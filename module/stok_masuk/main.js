var cache = {},
        counter = 0,
        emptyText = '<tr><td colspan="4" class="sys_align_center">Tidak  ada data yang dimasukkan.</td></tr>';

function autoComplete(value) //fungsi menangkap input search dan menampilkan hasil search
{


    //id = document.getElementById('kode').value;
    a = document.getElementById('kuantitas' + value).value;
    b = document.getElementById('filterKuantitas' + value).value;
    //var a = $('#quantity'+value).val();
    //var b = $('#quantityfilter'+value).val();

    jmlh = a - b;
    //alert("Quantity that you enter too many. (Max. "+jmlh+")");

    if (jmlh > '0') {

        alert("Kuantitas yang anda masukkan terlalu banyak. (Max. " + b + ")");
        //document.getElementById('quantity'+value).value = b;
        $('#kuantitas' + value).val(b);
    }
    else if (jmlh === '0') {

        alert("Kuantitas yang anda masukkan terlalu banyak. (Max. " + b + ")");
        //document.getElementById('quantity'+value).value = b;
        $('#kuantitas' + value).val(b);
    }


}
$(document).ready(function() {
    var tbody = $('#addProduct');
    var tbody2 = $('#addProductEdit');
    //var idnya=$('#quantity').attr('id');
    //idnya.hide();
    //var counter2 = 0;
    $('#no_faktur').change(function() {
        var poid = $(this).val();
        //alert("This property have available in list");
        $.ajax({
            url: "module/stok_masuk/service.php",
            data: "getproduct=" + poid,
            cache: false,
            success: function(msg) {
                $('#id_sparepart').html(msg);
                tbody.html(emptyText);
            }

        });
    });

    $('#addPro').click(function(evt) {
        var idp1 = $('#id_sparepart').val();
        var poId = $('#no_faktur').val();
        var dc3 = window.atob(idp1);
        var myarr3 = dc3.split("||");
        var idProduct = myarr3[0];
        var nama = myarr3[1];
        var kode = myarr3[2];
        var idProduct1 = $('#id_' + idProduct).val();
        getquantity(idProduct, poId);

        if (idProduct === '') {
            alert("Please select one from the list");
        } else {
            if (idProduct1 === idProduct) {
                alert("This property have available in list");
            } else {
                var output = '<tr id="data_' + counter + '">' +
                        '<td><input type="checkbox" /></td>' +
                        '<td><input name="kode_sparepart" type="text" id="kode_sparepart' + idProduct + '" class="span3" value="' + kode + '" readonly/></td>' +
                        '<td><input name="name" type="text" id="name' + idProduct + '" class="span3" value="' + nama + '" readonly/>' +
                        '<input name="ro[detail][' + counter + '][id_sparepart]" type="hidden" id="id_' + idProduct + '" class="span2" value="' + idProduct + '" readonly/></td>' +
                        '<td><input name="ro[detail][' + counter + '][kuantitas]" id="kuantitas' + idProduct + '" type="text" class="span2" value="" onblur="autoComplete(' + idProduct + ',' + poId + ' );"/>' +
                        '<input id="filterKuantitas' + idProduct + '" type="hidden" class="span2" value="" /></td>' +
                        '</tr>';

                if ($('tr td', tbody).length === 1) {
                    tbody.html('');
                }

                tbody.append(output);
            }
        }


        counter++;

        evt.preventDefault();
    });

    $('#delete').click(function(evt) {
        $('input:checked', tbody).each(function() {
            $(this).closest('tr').remove();
        });

        if ($('tr', tbody).length === 0) {
            tbody.html(emptyText);
        }

        evt.preventDefault();
    });

    $('#addEdit').click(function(evt) {
        var idp = $('#productId').val();
        var poId = $('#no_faktur').val();
        var dc2 = window.atob(idp);
        var myarr2 = dc2.split("||");
        var idProduct = myarr2[0];
        var nama = myarr2[1];
        var kode = myarr2[2];
        var idProduct1 = $('#editCheck_' + idProduct).val();
        getquantity(idProduct, poId);
        var a = getname(idProduct);

        if (idProduct === '') {
            alert("Please select one from the list");
        } else {
            if (idProduct1 === idProduct) {
                alert("This property have available in list");
            } else {
                var output = '<tr id="data_' + counter + '">' +
                        '<td><input type="checkbox" /></td>' +
                        '<td><input name="kode_sparepart" type="text" id="kode_sparepart' + idProduct + '" class="span2" value="' + kode + '" readonly/></td>' +
                        '<td><input name="name" type="text" id="name' + idProduct + '" class="span2" value="" readonly/>' +
                        '<input name="ro[detail][' + counter + '][id_sparepart]" type="hidden" id="id_' + idProduct + '" class="span3" value="' + idProduct + '" readonly/></td>' +
                        '<td><input name="ro[detail][' + counter + '][kuantitas]" id="kuantitas' + idProduct + '" type="text" class="span2" value="" onblur="autoComplete(' + idProduct + ',' + poId + ' );"/>' +
                        '<input id="filterKuantitas' + idProduct + '" type="hidden" class="span2" value="" /></td>' +
                        '</tr>';

                if ($('tr td', tbody).length === 1) {
                    tbody2.html('');
                }

                tbody2.append(output);
            }
        }


        counter++;

        evt.preventDefault();
    });

    $('#deleteEdit').click(function(evt) {

        $('input:checked', tbody2).each(function() {
            var id = $(this).val();
            var id_sparepart = $('#editCheck_' + (id)).val();
            var kuantitas = $('#kuantitas' + id).val();

            var output = '<tr>' +
                    '<td><input name="ro[delete][' + id + '][id_sparepart]" type="text" value="' + id_sparepart + '" /></td>' +
                    '<td><input name="ro[delete][' + id + '][kuantitas]" type="text" value="' + kuantitas + '" /></td>' +
                    '</tr>';

            tbody2.append(output);

            $(this).closest('tr').remove();
        });



        if ($('tr', tbody2).length == 0) {
            tbody2.html(emptyText);
        }

        evt.preventDefault();
    });

    $('.trigger').click(function() {
        $(this).parents("tr").next().slideToggle();
        return false;
    });

});



function getname(value) {
    // var id = $('#id').val();
    $.ajax({
        url: "module/stok_masuk/service.php",
        data: "getname=" + value,
        cache: false,
        success: function(msg) {
            $('#name' + value).val(msg);
        }

    });
}
function getquantity(value, poId) {
    // var id = $('#id').val();
    $.ajax({
        url: "module/stok_masuk/service.php",
        data: "getquantity=" + value + "&id=" + poId,
        cache: false,
        success: function(msg) {
            $('#kuantitas' + value).val(msg);
            $('#filterKuantitas' + value).val(msg);
        }

    });
}
