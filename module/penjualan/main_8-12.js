var cache = {},
        counter = 0,
        emptyText = '<tr><td colspan="9" class="sys_align_center">Tidak ada data yang dimasukkan</td></tr>';

function autoComplete(value) //fungsi menangkap input search dan menampilkan hasil search
{


//    q = document.getElementById('total_' + value).value;
    p = document.getElementById('harga_' + value).value;
    a = document.getElementById('dp_' + value).value;
    b = document.getElementById('diskon_' + value).value;

    if (a > 0 && b > 0) {
//        jmlh = (p - a) - (b / 100);
        jmlh = p * a;
    } else if (a === 0 && b === 0) {
        jmlh = p;
    }

    document.getElementById("total_" + value).value = jmlh;
    calculateSum();
    calculateTotal();
    ajaxRequest.onreadystatechange = function()
    {
        document.getElementById("total_" + value).innerHTML = ajaxRequest.responseText;
    };
    ajaxRequest.send(null);

}

$(document).ready(function() {
    var tbody = $('#addProduct');
    var tbody2 = $('#addProductEdit');
    $('#jmljualunit').hide();
    $('#unit').change(function() {
        var poid = $(this).val();
        //alert("This property have available in list");
        $.ajax({
            url: "module/penjualan/service.php",
            data: "getproduct=" + poid,
            cache: false,
            success: function(msg) {
                $('#mesin').html(msg);
                tbody.html(emptyText);
            }

        });
    });

    $('#addPro').click(function(evt) {
//        var idp1 = $('#unit').val();
        var idp1 = $('#mesin').val();
//        var poId = $('#mesin').val();
        var dc3 = window.atob(idp1);
        var myarr3 = dc3.split("||");
        var idProduct = myarr3[0];
        var nama = myarr3[1];
        var warna = myarr3[2];
        var no_mesin = myarr3[3];
        var no_rangka = myarr3[4];
        var harga = myarr3[5];
        var idProduct1 = $('#id_' + idProduct).val();
        var a = getname(idProduct);
//        getquantity(idProduct, poId);

//        if (idProduct === '') {
//            alert("Please select one from the list");
//        } else {
//            if (idProduct1 === idProduct) {
//                alert("This property have available in list");
//            } else {
        var output = '<tr id="data_' + counter + '">' +
                '<td><input type="checkbox" /></td>' +
                '<input name="id" type="hidden" id="id_' + idProduct + '" class="span2" value="' + idProduct + '" readonly/>' +
                '<td><input name="nama_unit" type="text" id="nama_unit_' + idProduct + '" class="span2" value=' + nama + ' readonly/></td>' +
                '<td><input name="warna" type="text" id="warna_' + idProduct + '" class="span1" value=' + warna + ' readonly/></td>' +
                '<td><input name="no_mesin" type="text" id="no_mesin_' + idProduct + '" class="span2" value=' + no_mesin + ' readonly/></td>' +
                '<td><input name="no_rangka" type="text" id="no_rangka_' + idProduct + '" class="span2" value=' + no_rangka + ' readonly/></td>' +
                '<input name="penjualan[detail][' + counter + '][productId]" type="hidden" id="id_' + idProduct + '" class="span2" value="' + idProduct + '" readonly/>' +
                '<td><div class="input-prepend"><span class="add-on">Rp</span><input name="penjualan[detail][' + counter + '][harga]" id="harga_' + idProduct + '" type="text" class="span2" value="' + harga + '"  style="text-align:right;" readonly/></div></td>' +
                '<td><div class="input-prepend"><span class="add-on">Rp</span><input name="penjualan[detail][' + counter + '][dp]" type="text" id="dp_' + idProduct + '" class="span2" value="" style="text-align:right;"/></div></td>' +
                '<td><div class="input-prepend"><span class="add-on">Rp</span><input name="penjualan[detail][' + counter + '][diskon]" id="diskon_' + idProduct + '" type="text" class="span2" value="" style="text-align:right;"/></div></td>' +
                '<td><div class="input-prepend"><span class="add-on">Rp</span><input name="penjualan[detail][' + counter + '][total]" id="total_' + idProduct + '" type="text" class="span2" value="" onkeyup="autoComplete(' + idProduct + ');" style="text-align:right;" readonly/></div></td>' +
                '</tr>';

        if ($('tr td', tbody).length === 1) {
            tbody.html('');
        }

        tbody.append(output);
        $('#jmljualunit').show();
//            }
//        }

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
                        '<input name="id" type="hidden" id="id' + idProduct + '" class="span2" value="' + idProduct + '" readonly/>' +
                        '<td><input name="name" type="text" id="name_' + idProduct + '" class="span2" value="' + nama + '" readonly/></td>' +
                        '<input name="penjualan[detail][' + counter + '][productId]" type="hidden" id="id_' + idProduct + '" class="span3" value="' + idProduct + '" readonly/>' +
                        '<td><input name="penjualan[detail][' + counter + '][quantity]" id="quantity_' + idProduct + '" type="text" class="span2" value="" /></td>' +
                        '<td><input name="penjualan[detail][' + counter + '][harga]" id="harga_' + idProduct + '" type="text" class="span2" value="" /></td>' +
                        '<td><textarea name="penjualan[detail][' + counter + '][remark]" id="remark_' + idProduct + '" class="span2" row="4"></textarea></td>' +
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
                    '<td colspan="2"><input name="penjualan[delete][' + id + '][delId]" type="hidden" value="' + iddel + '" /></td>' +
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
        url: "module/penjualan/service.php",
        data: "getname=" + value,
        cache: false,
        success: function(msg) {
            $('#name' + value).val(msg);
        }

    });
}

function getquantity(value, poId) {
    // var id = $('#id').val();
    console.data(value);
    $.ajax({
        url: "module/penjualan/service.php",
        data: "getquantity=" + value + "&id=" + poId,
        cache: false,
        success: function(msg) {
            $('#harga' + value).val(msg);
//            $('#filterKuantitas' + value).val(msg);
        }

    });
}

function harga(value) {
    $.ajax({
        url: "module/penjualan/service.php",
        data: "total=" + value,
        cache: false,
        success: function(msg) {
            $('#total_' + value).val(msg);
        }
    });
}

function calculateTotal() {
    //tran = document.getElementById('hpp-reimburse-biaya-transport').value;
    var sum = 0;
    //iterate through each textboxes and add the values
    $("#jmlJualSparepart").each(function() {

        //add only if the value is number
        if (!isNaN(this.value) && this.value.length !== 0) {
            sum += parseFloat(this.value);

        }

    });
    //.toFixed() method will roundoff the final sum to 2 decimal places
    //jmlh2 = sum +++ tran;
    document.getElementById("jmlJualSparepart").value = sum;
//    var a = number_format(sum, 2, ',', '.');
//    $('#totalSemuaLabel').text(a);
//    $('#JumlahTotalLabel').text(a);
}

function calculateSum() {
    //tran = document.getElementById('hpp-reimburse-biaya-transport').value;
    var sum = 0;
    //iterate through each textboxes and add the values
    $(".txt").each(function() {

        //add only if the value is number
        if (!isNaN(this.value) && this.value.length !== 0) {
            sum += parseFloat(this.value);

        }

    });
    //.toFixed() method will roundoff the final sum to 2 decimal places
    //jmlh2 = sum +++ tran;
    document.getElementById("jmlSparepart").value = sum;
//    document.getElementById("jmlSparepart2").value = sum;
//    var aaa = number_format(sum, 2, ',', '.');
//    $('#jmlSparepartLabel').text(aaa);
    //document.getElementById("jmlSparepartLabel").text = sum;
}