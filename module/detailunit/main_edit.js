var cache = {},
        counter = 0,
        emptyText = '<tr><td colspan="6" class="sys_align_center">Tidak ada data yang dimasukkan</td></tr>';

function itipe() {
    //tran = document.getElementById('hpp-reimburse-biaya-transport').value;
    alert("itipe");

}

function autoComplete(value) //fungsi menangkap input search dan menampilkan hasil search
{

    q = document.getElementById('hargakosongan_' + value).value;
    p = document.getElementById('plafonbbn_' + value).value;

    if (q > 0) {
        jmlh = parseFloat(q) + parseFloat(p);
    } else {
        jmlh = parseFloat(p);
    }

    document.getElementById("hargaotr_" + value).value = jmlh;
//    calculateSum();
//    calculateTotal();
    ajaxRequest.onreadystatechange = function()
    {
        document.getElementById("hargaotr_" + value).innerHTML = ajaxRequest.responseText;
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

    var tbody2 = $('#addProductEdit');

    $('#addEdit').click(function(evt) {
        var idunit = $('#nama_unit').val();
        var dc2 = window.atob(idunit);
        var myarr2 = dc2.split("||");
        var idUnit = myarr2[0];
        var nama_unit = myarr2[1];
        var hargakosongan = myarr2[2];
        var plafonbbn = myarr2[3];
        var hargaotr = myarr2[4];

        var warna = $('#colors').val();
        var idp1 = $('#productId').val();
        var dc3 = window.atob(idp1);
        var myarr3 = dc3.split("||");
        var idProduct = myarr3[0];
        var nama = myarr3[1];
        console.log(warna);
        console.log(nama);

        var idProduct1 = $('#id_' + idProduct).val();
        var idunit1 = $('#idunit_' + idunit).val();
        var color = $('#color').val();
        var a = getname(idProduct);
        console.log(color);

        if (idProduct === '') {
            alert("Please select one from the list");
        } else {
            if (idunit1 === idUnit && idProduct1 === idProduct) {
                alert("You can't change, Unit must be " + nama_unit + " and different Color");
            } else if (warna === color) {
                alert("This property have available in list");
            } else if (idProduct1 === idProduct) {
                alert("This property have available in list");
            } else {
                var output = '<tr id="data_' + counter + '">' +
                        '<td><input type="checkbox" /></td>' +
                        '<input name="id" type="hidden" id="id_' + idProduct + '" class="span2" value="' + nama + '" readonly/>' +
                        '<input name="id_units" type="hidden" id="idunit_' + idunit + '" class="span2" value="' + idUnit + '" readonly/>' +
                        '<td><input name="name" type="text" id="color" class="span1" value="' + nama + '" readonly/></td>' +
                        '<input name="master[detail][' + counter + '][productId]" type="hidden" id="id_' + idProduct + '" class="span2" value="' + idProduct + '" readonly/>' +
                        '<td><input name="master[detail][' + counter + '][no_rangka]" id="no_rangka_' + idProduct + '" type="text" class="span2" value="" /></td>' +
                        '<td><input name="master[detail][' + counter + '][no_mesin]" id="no_mesin_' + idProduct + '" type="text" class="span2" value="" /></td>' +
                        '<td><input name="master[detail][' + counter + '][tahun]" id="tahun_' + idProduct + '" type="text" class="span1" value="" /></td>' +
                        '<td><div class="input-prepend"><span class="add-on">Rp</span><input name="master[detail][' + counter + '][hargakosongan]" type="text" id="hargakosongan_' + idProduct + '" class="span2" style="text-align:right;" value="' + hargakosongan + '" readonly/></div></td>' +
                        '<td><div class="input-prepend"><span class="add-on">Rp</span><input name="master[detail][' + counter + '][plafonbbn]" id="plafonbbn_' + idProduct + '" type="text" class="span2" style="text-align:right;" value="' + plafonbbn + '" readonly/></div></td>' +
                        '<td><div class="input-prepend"><span class="add-on">Rp</span><input name="master[detail][' + counter + '][hargaotr]" id="hargaotr_' + idProduct + '" type="text" class="span2" style="text-align:right;" value="' + hargaotr + '" readonly/></div></td>' +
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
            console.log(id);

            var output = '<tr style="display: none;">' +
                    '<td colspan="2"><input name="master[delete][' + id + '][delId]" type="hidden" value="' + iddel + '" /></td>' +
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
        url: "module/unit/service.php",
        data: "getname=" + value,
        cache: false,
        success: function(msg) {
            $('#name_' + value).val(msg);
        }

    });
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
    document.getElementById("jmlUnit").value = sum;
//    document.getElementById("jmlUnit2").value = sum;
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
        if (!isNaN(this.value) && this.value.length !== 0) {
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
        if (!isNaN(this.value) && this.value.length !== 0) {
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