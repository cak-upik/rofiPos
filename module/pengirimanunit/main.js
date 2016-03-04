var cache = {},
        counter = 0,
        emptyText = '<tr><td colspan="7" class="sys_align_center">Tidak  ada data yang dimasukkan.</td></tr>';

function autoComplete(value) //fungsi menangkap input search dan menampilkan hasil search
{

    a = document.getElementById('kuantitas_' + value).value;
    b = document.getElementById('qty_beli_' + value).value;
    c = document.getElementById('sisa_qty_' + value).value;

    jmlh = parseFloat(b) - parseFloat(a);
    //alert("Quantity that you enter too many. (Max. "+jmlh+")");
    document.getElementById("sisa_qty_" + value).value = jmlh;

    if (parseFloat(a) > parseFloat(b)) {

        alert("Kuantitas yang anda masukkan terlalu banyak. (Max. " + b + ")");
        //document.getElementById('quantity'+value).value = b;
        $('#sisa_qty_' + value).val(b);
    }
//    else if (jmlh === '0') {
//
//        alert("Kuantitas yang anda masukkan kosong. (Max. " + b + ")");
//        //document.getElementById('quantity'+value).value = b;
//        $('#sisa_qty_' + value).val(b);
//    }


}
$(document).ready(function() {
    var tbody = $('#addProduct');
    var tbody2 = $('#addProductEdit');

    $('#unit').change(function() {
        var poid = $(this).val();
        //alert("This property have available in list");
        $.ajax({
            url: "module/pengirimanunit/service.php",
            data: "getproduct=" + poid,
            cache: false,
            success: function(msg) {
                $('#warna').html(msg);
                tbody.html(emptyText);
            }
        });
    });

    $('#addPro').click(function(evt) {
        var idp1 = $('#warna').val();
        var poId = $('#unit').val();
        var idS1 = $('#supplier').val();

        var dc2 = window.atob(idS1);
        var myarr2 = dc2.split("||");
        var idSup = myarr2[0];
        var nama_supplier = myarr2[1];

        var dc3 = window.atob(idp1);
        var myarr3 = dc3.split("||");
        var id = myarr3[0];
        var nama_unit = myarr3[1];
        var warna = myarr3[2];
        var no_mesin = myarr3[3];
        var no_rangka = myarr3[4];
        var harga = myarr3[5];
        var tahun = myarr3[6];
        var id_unit = myarr3[7];
        var kuantiti = myarr3[8];
        var idPesan = myarr3[9];
        var idDetPeU = myarr3[10];
        var masuk2 = $('#akses2_' + id).val();
        var a = getname(id);
        getquantity(id, poId);
        console.log(idDetPeU);

        if (masuk2 === '') {
            alert("Please select one from the list yooo");
        } else {
            if (masuk2 === id) {
                alert("This property have available in list");
            } else {
                var output = '<tr id="data_' + (counter) + '">' +
                        '<td><input type="checkbox" /></td>' +
                        '<input name="unit[detail][' + counter + '][supplier]" type="hidden" class="span2" id="nama_supplier" value="' + nama_supplier + '" readonly/>' +
                        '<input name="unit[detail][' + counter + '][idsupplier]" type="hidden" class="span2" id="id_supplier" value="' + idSup + '" readonly/>' +
                        '<input name="unit[detail][' + counter + '][idDetPeU]" type="hidden" class="span2" id="id_detail_pesan_unit" value="' + idDetPeU + '" readonly/>' +
                        '<td><input name="unit[detail][' + counter + '][unit]" type="text" class="span2" id="unit" value="' + nama_unit + '" readonly/></td>' +
                        '<td><input name="unit[detail][' + counter + '][nama_warna]" type="text" class="span1" id="nama_warna" value="' + warna + '" readonly/></td>' +
                        '<input name="unit[detail][' + counter + '][iddetail]" type="hidden" value="' + id + '" id="akses2_' + id + '"/></td>' +
                        '<input name="unit[detail][' + counter + '][idunit]" type="hidden" value="' + id_unit + '" id="idUnit_' + id + '"/></td>' +
                        '<input name="unit[detail][' + counter + '][idPesan]" type="hidden" value="' + idPesan + '" id="idPesan_' + id + '"/></td>' +
                        '<input name="unit[detail][' + counter + '][noRangka]" type="hidden" id="noRangka_' + id + '" class="span2" value="' + no_rangka + '" readonly/>' +
                        '<input name="unit[detail][' + counter + '][noMesin]" type="hidden" id="noMesin_' + id + '" class="span2" value="' + no_mesin + '" readonly/>' +
                        '<td><input name="unit[detail][' + counter + '][tahun]" type="text" id="tahun_' + id + '" class="span1" value="' + tahun + '" readonly/></td>' +
                        '<td><input name="unit[detail][' + counter + '][qty_beli]" type="text" class="span1" id="qty_beli_' + id + '" style="text-align: right;" value="' + kuantiti + '" readonly/></td>' +
                        '<td><input name="unit[detail][' + counter + '][kuantitas]" type="text" class="span1" id="kuantitas_' + id + '" style="text-align: right;" onkeyup="autoComplete(' + id + ');" value=""/></td>' +
                        '<td><input name="unit[detail][' + counter + '][sisa_qty]" type="text" class="span1" id="sisa_qty_' + id + '" style="text-align: right;" value="" readonly/></td>' +
                        '<td><textarea name="unit[detail][' + counter + '][keterangan]" id="keterangan_' + id + '" class="span2" row="4"></textarea></td>' +
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
        var idp1 = $('#warna').val();
        var poId = $('#unit').val();
        var idS1 = $('#supplier').val();

        var dc2 = window.atob(idS1);
        var myarr2 = dc2.split("||");
        var idSup = myarr2[0];
        var nama_supplier = myarr2[1];

        var dc3 = window.atob(idp1);
        var myarr3 = dc3.split("||");
        var id = myarr3[0];
        var nama_unit = myarr3[1];
        var warna = myarr3[2];
        var no_mesin = myarr3[3];
        var no_rangka = myarr3[4];
        var harga = myarr3[5];
        var tahun = myarr3[6];
        var id_unit = myarr3[7];
        var kuantiti = myarr3[8];
        var idPesan = myarr3[9];
        var idDetPeU = myarr3[10];
        var masuk2 = $('#akses2_' + id).val();
        var a = getname(id);
        getquantity(id, poId);
        console.log(id_unit);

        if (masuk2 === '') {
            alert("Please select one from the list yooo");
        } else {
            if (masuk2 === id) {
                alert("This property have available in list");
            } else {
                var output = '<tr id="data_' + (counter) + '">' +
                        '<td><input type="checkbox" /></td>' +
                        '<input name="unit[detail][' + counter + '][supplier]" type="hidden" class="span2" id="nama_supplier" value="' + nama_supplier + '" readonly/>' +
                        '<input name="unit[detail][' + counter + '][idsupplier]" type="hidden" class="span2" id="id_supplier" value="' + idSup + '" readonly/>' +
                        '<input name="unit[detail][' + counter + '][idDetPeU]" type="hidden" class="span2" id="id_detail_pesan_unit" value="' + idDetPeU + '" readonly/>' +
                        '<td><input name="unit[detail][' + counter + '][unit]" type="text" class="span2" id="unit" value="' + nama_unit + '" readonly/></td>' +
                        '<td><input name="unit[detail][' + counter + '][nama_warna]" type="text" class="span1" id="nama_warna" value="' + warna + '" readonly/></td>' +
                        '<input name="unit[detail][' + counter + '][iddetail]" type="hidden" value="' + id + '" id="akses2_' + id + '"/></td>' +
                        '<input name="unit[detail][' + counter + '][idunit]" type="hidden" value="' + id_unit + '" id="idUnit_' + id + '"/></td>' +
                        '<input name="unit[detail][' + counter + '][idPesan]" type="hidden" value="' + idPesan + '" id="idPesan_' + id + '"/></td>' +
                        '<input name="unit[detail][' + counter + '][noRangka]" type="hidden" id="noRangka_' + id + '" class="span2" value="' + no_rangka + '" readonly/>' +
                        '<input name="unit[detail][' + counter + '][noMesin]" type="hidden" id="noMesin_' + id + '" class="span2" value="' + no_mesin + '" readonly/>' +
                        '<td><input name="unit[detail][' + counter + '][tahun]" type="text" id="tahun_' + id + '" class="span1" value="' + tahun + '" readonly/></td>' +
                        '<td><input name="unit[detail][' + counter + '][qty_beli]" type="text" class="span1" id="qty_beli_' + id + '" style="text-align: right;" value="' + kuantiti + '" readonly/></td>' +
                        '<td><input name="unit[detail][' + counter + '][kuantitas]" type="text" class="span1" id="kuantitas_' + id + '" style="text-align: right;" onkeyup="autoComplete(' + id + ');" value=""/></td>' +
                        '<td><input name="unit[detail][' + counter + '][sisa_qty]" type="text" class="span1" id="sisa_qty_' + id + '" style="text-align: right;" value="" readonly/></td>' +
                        '<td><textarea name="unit[detail][' + counter + '][keterangan]" id="keterangan_' + id + '" class="span2" row="4"></textarea></td>' +
                        '</tr>';

                if ($('tr td', tbody2).length === 1) {
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
        url: "module/pengirimanunit/service.php",
        data: "getname=" + value,
        cache: false,
        success: function(msg) {
            $('#name' + value).val(msg);
        }

    });
}

function getquantity(value, poId) {
    $.ajax({
        url: "module/pengirimanunit/service.php",
        data: "getquantity=" + value + "&id=" + poId,
        cache: false,
        success: function(msg) {
            $('#kuantitas' + value).val(msg);
            $('#filterKuantitas' + value).val(msg);
        }

    });
}
