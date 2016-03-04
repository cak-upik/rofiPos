var cache = {},
        counter = 0,
        emptyText = '<tr><td colspan="2" class="sys_align_center">No data added...</td></tr>';

function autoComplete(value) //fungsi menangkap input search dan menampilkan hasil search
{

    q = document.getElementById('kuantitas_' + value).value;
    p = document.getElementById('harga_' + value).value;
    a = document.getElementById('diskon_' + value).value;

    if (q !== 0 && a !== 0) {
        jmlh = p - q - a;
    } else if (q === 0 && a === 0) {
        jmlh = p - q - a;
    }

    document.getElementById("jumlah_" + value).value = jmlh;
    calculateSum();
//    calculateTotal();
    ajaxRequest.onreadystatechange = function()
    {
        document.getElementById("jumlah_" + value).innerHTML = ajaxRequest.responseText;
    };
    ajaxRequest.send(null);

}

$(document).ready(function() {
    var tbody2 = $('#detailUnit');
    var tbody = $('#detailPekerjaan');
//    calculateTotal();detailUnit
//    calculateSum();

    var subtotal = $('#subtotal').val();
//    if (subtotal > 0)
//        $('#EditJmlJualUnit').show();
//    else
//        $('#EditJmlJualUnit').hide();

//    $('#total').hide();

    $('#unit').change(function() {
        var poid = $(this).val();
        //alert("This property have available in list");
        $.ajax({
            url: "module/penjualan/service.php",
            data: "getproduct=" + poid,
            cache: false,
            success: function(msg) {
                $('#warna').html(msg);
                tbody.html(emptyText);
            }

        });
    });

    $('#addEdit').click(function(evt) {
        var idp1 = $('#warna').val();
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
        var idpenjualan = $('#id_penjualan').val();
        console.log(idpenjualan);
//        var dc5 = window.atob(idWarna);
//        var myarr4 = dc5.split("||");
//        var warna = myarr4[0];
//        var nama_warna = myarr4[1];
        var masuk2 = $('#akses2_' + (id)).val();
//        var masuk2 = $('#warna_' + (warna)).val();

        if (masuk2 === '') {
            alert("Please select one from the list yooo");
        } else {
            if (masuk2 === id) {
                alert("This property have available in list");
            } else {
                var output = '<tr id="data_' + (counter) + '">' +
                        '<td><input type="checkbox" /></td>' +
                        '<input name="ids" type="hidden" id="id_' + id + '" class="span2" value="' + id + '" readonly/>' +
                        '<td><input name="unit[detail][' + counter + '][nama_unit]" type="text" class="span2" id="unit" value="' + nama_unit + '" readonly/>' +
                        '<td><input name="unit[detail][' + counter + '][nama_warna]" type="text" class="span1" id="nama_warna" value="' + warna + '" readonly/>' +
                        '<input name="unit[detail][' + counter + '][id]" type="hidden" value="' + id + '" id="akses2_' + id + '"/></td>' +
                        '<input name="unit[detail][' + counter + '][idunit]" type="hidden" value="' + id_unit + '" id="idUnit_' + id_unit + '"/></td>' +
                        '<input name="unit[detail][' + counter + '][idpenjualan]" type="hidden" value="' + idpenjualan + '" id="idpenjualan_' + id + '"/></td>' +
                        '<td><input name="unit[detail][' + counter + '][noRangka]" type="text" id="noRangka_' + id + '" class="span2" value="' + no_rangka + '" readonly/></td>' +
                        '<td><input name="unit[detail][' + counter + '][noMesin]" type="text" id="noMesin_' + id + '" class="span2" value="' + no_mesin + '" readonly/></td>' +
                        '<td><input name="unit[detail][' + counter + '][tahun]" type="text" id="tahun_' + id + '" class="span1" value="' + tahun + '" readonly/></td>' +
                        '<td><div class="input-prepend"><span class="add-on">Rp</span><input name="unit[detail][' + counter + '][hargabeli]" type="text" class="span2" id="harga_' + id + '" value="' + harga + '" readonly style="text-align: right;"/></div></td>' +
                        '<td><div class="input-prepend"><span class="add-on">Rp</span><input name="unit[detail][' + counter + '][kuantitas]" type="text" class="span2" id="kuantitas_' + id + '" onkeyup="autoComplete(' + id + ');" style="text-align: right;"/></div></td>' +
                        '<td><div class="input-prepend"><span class="add-on">Rp</span><input name="unit[detail][' + counter + '][diskon]" type="text" class="span2" id="diskon_' + id + '" onkeyup="autoComplete(' + id + ');" style="text-align: right;"/></div></td>' +
                        '<td><div class="input-prepend"><span class="add-on">Rp</span><input name="unit[detail][' + counter + '][jumlah]" type="text" class="span2 txt" id="jumlah_' + id + '" style="text-align: right;" readonly/></div></td>' +
                        '</tr>';
            }
        }

        if ($('tr td', tbody2).length === 1) {
            tbody2.html('');
        }

        tbody2.append(output);
        $('#EditJmlJualUnit').show();
//        calculateSum();
//        calculateTotal();
        counter++;
        evt.preventDefault();
    });

    $('#deleteEdit').click(function(evt) {

        $('input:checked', tbody2).each(function() {
            var id = $(this).val();
            var iddel = $('#editCheck_' + (id)).val();
            console.log(id);
            var output = '<tr style="display: none;">' +
                    '<td colspan="2"><input name="unit[delete][' + id + '][delId]" type="hidden" value="' + iddel + '" /></td>' +
                    '</tr>';
            tbody2.append(output);
            $(this).closest('tr').remove();
            calculateSum();
            calculateTotal();
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

    document.getElementById("total").value = sum;
//    var aaa = number_format(sum, 2, ',', '.');
//    $('#jmlUnitLabel').text(aaa);
//
}

function calculateTotal() {
    var jumlah = $('#jumlah_').val();
//    var part = document.getElementById("jmlPekerjaan2").value;

    var sum = parseInt(jumlah, 10);

    document.getElementById("total").value = sum;
//    var a = number_format(sum, 2, ',', '.');
//    $('#totalSemuaLabel').text(a);
//    $('#JumlahTotalLabel').text(a);
}