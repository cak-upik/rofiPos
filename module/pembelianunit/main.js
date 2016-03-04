var cache = {},
        counter = 0,
        emptyText = '<tr><td colspan="6" class="sys_align_center">Tidak ada data yang dimasukkan</td></tr>';


$(document).ready(function() {
    var tbody = $('#addProduct');
    var tbody2 = $('#addProductEdit');
    //var idnya=$('#quantity').attr('id');
    //idnya.hide();
    //var counter2 = 0;

    $('#add').click(function(evt) {
        var idp1 = $('#productId').val();
        var dc3 = window.atob(idp1);
        var myarr3 = dc3.split("||");
        var idProduct = myarr3[0];
        var nama = myarr3[1];
//            var kode= myarr3[2];
        var idProduct1 = $('#id_' + idProduct).val();
        var a = getname(idProduct);

        if (idProduct === '') {
            alert("Please select one from the list");
        } else {
            if (idProduct1 === idProduct) {
                alert("This property have available in list");
            } else {
                var output = '<tr id="data_' + counter + '">' +
                        '<td><input type="checkbox" /></td>' +
                        '<input name="id" type="hidden" id="id_' + idProduct + '" class="span2" value="' + idProduct + '" readonly/>' +
                        '<td><input name="name" type="text" id="name_' + idProduct + '" class="span2" value=' + nama + ' readonly/></td>' +
                        '<input name="unit[detail][' + counter + '][productId]" type="hidden" id="id_' + idProduct + '" class="span2" value="' + idProduct + '" readonly/>' +
                        '<td><input name="unit[detail][' + counter + '][quantity]" id="quantity_' + idProduct + '" type="text" style="text-align: right;" class="span1" value="" /></td>' +
                        '<td><div class="input-prepend"><span class="add-on">Rp</span><input name="unit[detail][' + counter + '][price]" id="price_' + idProduct + '" type="text" style="text-align:right;" class="span2" value="" /></div></td>' +
                        '<td><textarea name="unit[detail][' + counter + '][remark]" id="remark_' + idProduct + '" class="span2" row="4"></textarea></td>' +
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
        var dc2 = window.atob(idp);
        var myarr2 = dc2.split("||");
        var idProduct = myarr2[0];
        var nama = myarr2[1];
//        var kode = myarr2[2];
        var idProduct1 = $('#editCheck_' + idProduct).val();
        var a = getname(idProduct);

        if (idProduct === '') {
            alert("Please select one from the list");
        } else {
            if (idProduct1 === idProduct) {
                alert("This property have available in list");
            } else {
                var output = '<tr id="data_' + counter + '">' +
                        '<td><input type="checkbox" /></td>' +
                        '<input name="idunit" type="hidden" id="id' + idProduct + '" class="span2" value="' + idProduct + '" readonly/>' +
                        '<td><input name="name" type="text" id="name_' + idProduct + '" class="span2" value="' + nama + '" readonly/></td>' +
                        '<input name="unit[detail][' + counter + '][productId]" type="hidden" id="id_' + idProduct + '" class="span3" value="' + idProduct + '" readonly/>' +
                        '<td><input name="unit[detail][' + counter + '][quantity]" id="quantity_' + idProduct + '" type="text" style="text-align: right;" class="span1" value="" /></td>' +
                        '<td><div class="input-prepend"><span class="add-on">Rp</span><input name="unit[detail][' + counter + '][price]" id="price_' + idProduct + '" type="text" style="text-align:right;" class="span2" value="" /></div></td>' +
                        '<td><textarea name="unit[detail][' + counter + '][remark]" id="remark_' + idProduct + '" class="span2" row="4"></textarea></td>' +
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
            var iddel = $('#editCheck_' + (id)).val();

            var output = '<tr style="display: none;">' +
                    '<td colspan="2"><input name="unit[delete][' + id + '][delId]" type="hidden" value="' + iddel + '" /></td>' +
                    '</tr>';

            tbody2.append(output);

            $(this).closest('tr').remove();
        });
        if ($('tr', tbody2).length === 0) {
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
        url: "module/pembelianunit/service.php",
        data: "getname=" + value,
        cache: false,
        success: function(msg) {
            $('#name' + value).val(msg);
        }

    });
}

