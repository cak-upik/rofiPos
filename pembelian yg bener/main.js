var cache = {},
        counter = 0,
        emptyText = '<tr><td colspan="2" class="sys_align_center">Belum ada data yang dimasukkan</td></tr>';

function itipe() {
    //tran = document.getElementById('hpp-reimburse-biaya-transport').value;
    alert("itipe");

}
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
    calculateTotal()
    ajaxRequest.onreadystatechange = function()
    {
        document.getElementById("jumlah_" + value).innerHTML = ajaxRequest.responseText;
    };
    ajaxRequest.send(null);

}

$(document).ready(function() {
    $("#create").validate({
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

    var tbody = $('#detailPekerjaan');
    var tbody2 = $('#detailSparepart');

    $('#jmlJualSparepart').hide();
    $('#jmlOngkosPekerjaan').hide();

    /*
     $('#save').click(function() {
     //var id_pelanggan = $('#id_pelanggan').val();
     
     if($('#id_pelanggan').length === 0){
     alert("Data tidak dapat diproses karena pengisian kurang lengkap");
     return false;
     }
     if($('#work').length === 0){
     alert("Data tidak dapat diproses karena pengisian kurang lengkap");
     return false;
     }
     if($('#spare').length === 0){
     alert("Data tidak dapat diproses karena pengisian kurang lengkap");
     return false;
     }
     
     });
     */

    $('#addWork').click(function(evt) {
        var idDetil = $('#pekerjaan').val();
        if (idDetil === '') {
            alert("Pilih salah satu");
        } else {
            var dc2 = window.atob(idDetil);
            var myarr2 = dc2.split("||");
            var id = myarr2[0];
            var nama = myarr2[1];
            var tarif = myarr2[2];
            var masuk2 = $('#akses_' + (id)).val();


            if (masuk2 === id) {
                //alert("Data yang Anda masukkan sudah ada pada list");
            } else {
                var output = '<tr id="data_' + (counter) + '">' +
                        '<td><input type="checkbox" /></td>' +
                        '<td><input name="work[detail][' + counter + '][jenis_pekerjaan]" type="text" class="span4" id="work" value="' + nama + '" readonly/>' +
                        '<input name="work[detail][' + counter + '][id_jenis_pekerjaan]" type="hidden" class="span4" value="' + id + '" id="akses_' + id + '" /></td>' +
                        '<td><input name="work[detail][' + counter + '][tarif_kerja]" type="text" class="span4 txt2" value="' + tarif + '" id="tarif_' + id + '" readonly /></td>' +
                        '</tr>';

            }
        }

        if ($('tr td', tbody).length == 1) {
            tbody.html('');
        }

        tbody.append(output);
        $('#jmlOngkosPekerjaan').show();
        calculatePekerjaan()
        calculateTotal()

        counter++;

        evt.preventDefault();
    });

    $('#deleteWork').click(function(evt) {
        $('input:checked', tbody).each(function() {
            $(this).closest('tr').remove();
            calculatePekerjaan()
            calculateTotal()
        });

        if ($('tr', tbody).length == 0) {
            tbody.html(emptyText);
            $('#jmlOngkosPekerjaan').hide();
        }

        evt.preventDefault();
    });

    $('#addPro').click(function(evt) {
        var idSparepart = $('#sparepart').val();
        if (idSparepart === '') {
            alert("Pilih salah satu");
        } else {
            var dc3 = window.atob(idSparepart);
            var myarr3 = dc3.split("||");
            var id = myarr3[0];
            var nama = myarr3[1];
            var harga = myarr3[2];
            var masuk2 = $('#akses2_' + (id)).val();


            if (masuk2 === id) {
                //alert("Data yang Anda masukkan sudah ada pada list");
            } else {
                var output = '<tr id="data_' + (counter) + '">' +
                        '<td><input type="checkbox" /></td>' +
                        '<td><input name="sparepart[detail][' + counter + '][nama_sparepart]" type="text" class="span2" id="spare" value="' + nama + '" readonly/>' +
                        '<input name="sparepart[detail][' + counter + '][id_sparepart]" type="hidden" class="span2" value="' + id + '" id="akses2_' + id + '"/></td>' +
                        '<td><input name="sparepart[detail][' + counter + '][harga_satuan]" type="text" class="span2" id="harga_' + id + '" value="' + harga + '" readonly/></td>' +
                        '<td><input name="sparepart[detail][' + counter + '][kuantitas]" type="text" class="span2" id="kuantitas_' + id + '" onkeyup="autoComplete(' + id + ');"/></td>' +
                        '<td><input name="sparepart[detail][' + counter + '][jumlah]" type="text" class="span2 txt" id="jumlah_' + id + '"/></td>' +
                        '</tr>';

            }
        }

        if ($('tr td', tbody2).length == 1) {
            tbody2.html('');
        }

        tbody2.append(output);
        $('#jmlJualSparepart').show();
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
            $('#jmlJualSparepart').hide();
        }

        evt.preventDefault();
    });

    $('#nopol').blur(function() {
        var nopol = $(this).val();
        //alert("This property have available in list");
        if (nopol === '') {
            $('#detailPelanggan').html('');
        } else {
            $.ajax({
                url: "module/pelayanan/service.php",
                data: "nopol=" + nopol,
                cache: false,
                success: function(msg) {
                    $('#detailPelanggan').html(msg);
                }

            });
        }

    });

    /*
     $('#id_type_motor').change(function() {
     var idTipe = $(this).val();
     //alert("This property have available in list");
     
     $.ajax({
     url: "module/pelayanan/service.php",
     data: "tipe="+idTipe,
     cache: false,
     success: function(msg){
     $('#sparepart').html(msg);
     }
     
     });
     
     
     });
     */
    $('#jenser1').click(function() {
        var jen = $(this).val();
        //alert("This property have available in list");

        $.ajax({
            url: "module/pelayanan/service.php",
            data: "jenis=" + jen,
            cache: false,
            success: function(msg) {
                $('#pekerjaan').html(msg);
                tbody.html(emptyText);
                $('#jmlOngkosPekerjaan').hide();
                calculatePekerjaan();
                calculateTotal();
            }

        });
    });
    $('#jenser2').click(function() {
        var jen = $(this).val();
        //alert("This property have available in list");

        $.ajax({
            url: "module/pelayanan/service.php",
            data: "jenis=" + jen,
            cache: false,
            success: function(msg) {
                $('#pekerjaan').html(msg);
                tbody.html(emptyText);
                $('#jmlOngkosPekerjaan').hide();
                calculatePekerjaan();
                calculateTotal();
            }

        });
    });

    $('#setor').blur(function() {
        var setor = $(this).val();
        var tot = $('#totalSemua').val();
        var jum = setor - tot;


        if (setor === '') {
            $('#JumlahKembalianLabel').text("");
        } else {
            var b = number_format(jum, 2, ',', '.');
            $('#JumlahKembalianLabel').text(b);
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
    document.getElementById("jmlSparepart").value = sum;
    document.getElementById("jmlSparepart2").value = sum;
    var aaa = number_format(sum, 2, ',', '.');
    $('#jmlSparepartLabel').text(aaa);
    //document.getElementById("jmlSparepartLabel").text = sum;
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
    //tran = document.getElementById('hpp-reimburse-biaya-transport').value;
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