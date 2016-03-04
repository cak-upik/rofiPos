var cache = {},
        counter = 0,
        emptyText = '<tr><td colspan="2" class="sys_align_center">No data added...</td></tr>';

function autoComplete(value) //fungsi menangkap input search dan menampilkan hasil search
{


    q = document.getElementById('kuantitas_' + value).value;
    p = document.getElementById('harga_' + value).value;

    if (q > 0) {
        jmlh = q * p;
    } else {
        jmlh = p;
    }

    document.getElementById("jumlah_" + value).value = jmlh;
    calculateSum();
    calculateTotal();
    ajaxRequest.onreadystatechange = function()
    {
        document.getElementById("jumlah_" + value).innerHTML = ajaxRequest.responseText;
    };
    ajaxRequest.send(null);

}

$(document).ready(function() {
    var tbody = $('#detailPekerjaan');
    var tbody2 = $('#detailUnit');

    calculatePekerjaan();
    calculateTotal();
    calculateSum();




    $("#creates").validate({
        rules: {
            setor: {digits: true, maxlength: 12}
        },
        messages: {
            setor: {
                digits: "Mohon masukkan angka",
                maxlength: "Nomor terlalu banyak"
            }
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



    var total = $('#total').val();
    if (total > 0) {
        $('#editJmlTotal').show();
        calculateSum();
        calculateTotal();
    }
    else
        $('#editJmlTotal').hide();

    var total = $('#total').val();
    if (total > 0)
        $('#EditJmlJualUnit').show();
    else
        $('#EditJmlJualUnit').hide();


    $('#addPro').click(function(evt) {
        var idUnit = $('#unit').val();
        var idSupplier = $('#supplier').val();
        var idWarna = $('#warna').val();

        if (idSupplier === '') {
            alert("Pilih Supplier");
        } else if (idWarna === '') {
            alert("Pilih salah satu");
        } else if (idUnit === '') {
            alert("Pilih salah satu");
        } else {
            var dc3 = window.atob(idUnit);
            var myarr3 = dc3.split("||");
            var id = myarr3[0];
            var nama_unit = myarr3[1];
            //var nama_unit = myarr3[2];
            var harga = myarr3[2];

            var dc4 = window.atob(idSupplier);
            var myarr4 = dc4.split("||");
            var supplier = myarr4[0];
            var name = myarr4[1];

            var dc5 = window.atob(idWarna);
            var myarr4 = dc5.split("||");
            var warna = myarr4[0];
            var nama_warna = myarr4[1];
            //var supplier = myarr3[4];
            //var noMesin = myarr3[5];
            var masuk2 = $('#akses2_' + (id)).val();
            var masuk2 = $('#supplier_' + (supplier)).val();
            var masuk2 = $('#warna_' + (warna)).val();

            if (masuk2 === id) {
                //alert("Data yang Anda masukkan sudah ada pada list");
            } else {
                var output = '<tr id="data_' + (counter) + '">' +
                        '<td><input type="checkbox" /></td>' +
                        '<td><input name="supplier[' + counter + '][name]" type="text" class="span2" id="name" value="' + name + '" readonly/>' +
                        '<input name="supplier[' + counter + '][id_supplier]" type="hidden" value="' + supplier + '" id="supplier_' + supplier + '"/></td>' +
                        '<td><input name="unit[' + counter + '][nama_unit]" type="text" class="span1" id="unit" value="' + nama_unit + '" readonly/>' +
                        '<input name="unit[' + counter + '][id]" type="hidden" value="' + id + '" id="akses2_' + id + '"/></td>' +
                        '<td><input name="unit[' + counter + '][hargabeli]" type="text" class="span2" id="harga_' + id + '" value="' + harga + '" readonly/></td>' +
                        '<td><input name="unit[' + counter + '][noRangka]" type="text" id="noRangka' + id + '" class="span2" row="4" ></td>' +
                        '<td><input name="unit[' + counter + '][noMesin]" type="text" id="noMesin' + id + '" class="span2" row="4" ></td>' +
                        '<td><input name="unit[' + counter + '][tahun]" type="text" id="tahun' + id + '" class="span2" row="4" ></td>' +
                        '<td><input name="warna[' + counter + '][nama_warna]" type="text" class="span2" id="nama_warna" value="' + nama_warna + '" readonly/>' +
                        '<input name="warna[' + counter + '][id_color]" type="hidden" value="' + warna + '" id="warna_' + warna + '"/></td>' +
                        '<td><input name="unit[' + counter + '][kuantitas]" type="text" class="span1" id="kuantitas_' + id + '" onkeyup="autoComplete(' + id + ');"/></td>' +
                        '<td><input name="unit[' + counter + '][jumlah]" type="text" class="span2 txt" id="jumlah_' + id + '"/></td>' +
                        //'<td><textarea name="po[detail][' + counter + '][remark]" id="remark'+idProduct+'" class="span2" row="4"></textarea></td>' + 
                        '</tr>';

            }
        }

        if ($('tr td', tbody2).length == 1) {
            tbody2.html('');
        }

        tbody2.append(output);
        $('#jmlJuaUnit').show();
        counter++;

        evt.preventDefault();
    });

    $('#deletePro').click(function(evt) {
        $('input:checked', tbody2).each(function() {
            $(this).closest('tr').remove();
            calculateSum();
            calculateTotal()
        });

        if ($('tr', tbody2).length == 0) {
            tbody2.html(emptyText);
            $('#jmlJuaUnit').hide();
        }

        evt.preventDefault();
    });


    $('#setor').blur(function() {
        var setor = parseInt($(this).val(), 10);
        var tot = parseInt($('#totalSemua').val(), 10);
        var jum = setor - tot;


        if (setor === '') {
            $('#JumlahKembalianLabel').text("");
        } else {
            if (setor < tot) {
                alert("Uang customer tidak cukup.");
                $('#JumlahKembalianLabel').text("");
            } else {
                var b = number_format(jum, 2, ',', '.');
                $('#JumlahKembalianLabel').text(jum);
            }
        }

    });
});

function calculateSum() {
    //tran = document.getElementById('hpp-reimburse-biaya-transport').value;
    var sum = 0;
    //iterate through each textboxes and add the values
    $(".txt").each(function() {

        //add only if the value is number
        if (!isNaN(this.value) && this.value.length != 0) {
            sum += parseFloat(this.value);

        }

    });
    //.toFixed() method will roundoff the final sum to 2 decimal places
    //jmlh2 = sum +++ tran;
    document.getElementById("jmlUnit").value = sum;
    document.getElementById("jmlUnit2").value = sum;
    var aaa = number_format(sum, 2, ',', '.');
    $('#jmlUnitLabel').text(aaa);
    //document.getElementById("jmlUnitLabel").text = sum;
}

function calculatePekerjaan() {
    //tran = document.getElementById('hpp-reimburse-biaya-transport').value;
    var sum = 0;
    //iterate through each textboxes and add the values
    $(".txt2").each(function() {

        //add only if the value is number
        if (!isNaN(this.value) && this.value.length != 0) {
            sum += parseFloat(this.value);

        }

    });
    //.toFixed() method will roundoff the final sum to 2 decimal places
    //jmlh2 = sum +++ tran;
    document.getElementById("jmlPekerjaan").value = sum;
    document.getElementById("jmlPekerjaan2").value = sum;
    var aa = number_format(sum, 2, ',', '.');
    $('#jmlPekerjaanLabel').text(aa);
}

function calculateTotal() {
    var kerja = $('#jmlUnit').val();
    // var part = document.getElementById("jmlPekerjaan2").value;

    var sum = 0;
    //iterate through each textboxes and add the values
    $(".jumlah").each(function() {

        //add only if the value is number
        if (!isNaN(this.value) && this.value.length != 0) {
            sum += parseFloat(this.value);

        }

    });
    //.toFixed() method will roundoff the final sum to 2 decimal places
    //jmlh2 = sum +++ tran;
    document.getElementById("totalSemua").value = sum;
    var a = number_format(sum, 2, ',', '.');
    $('#totalSemuaLabel').text(a);
    $('#JumlahTotalLabel').text(a);
}