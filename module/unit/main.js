var cache = {},
        counter = 0,
        emptyText = '<tr><td colspan="6" class="sys_align_center">Tidak ada data yang dimasukkan</td></tr>';

function autoComplete(value) //fungsi menangkap input search dan menampilkan hasil search
{

    q = parseInt(document.getElementById('hargakosongan_' + value).value);
    p = parseInt(document.getElementById('plafonbbn_' + value).value);

    if (q > 0) {
        jmlh = q + p;
    } else {
        jmlh = p;
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
       
    var tbody = $('#addProduct');
//    var tbody2 = $('#addProductEdit');

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
                        '<td><input name="name" type="text" id="name_' + idProduct + '" class="span1" value="' + nama + '" readonly/></td>' +
                        '<input name="master[detail][' + counter + '][productId]" type="hidden" id="id_' + idProduct + '" class="span2" value="' + idProduct + '" readonly/>' +
                        '<td><input name="master[detail][' + counter + '][no_rangka]" id="no_rangka_' + idProduct + '" type="text" class="span2" value="" /></td>' +
                        '<td><input name="master[detail][' + counter + '][no_mesin]" id="no_mesin_' + idProduct + '" type="text" class="span2" value="" /></td>' +
                        '<td><input name="master[detail][' + counter + '][tahun]" id="tahun_' + idProduct + '" type="text" class="span1" value="" /></td>' +
                        '<td><div class="input-prepend"><span class="add-on">Rp</span><input name="master[detail][' + counter + '][hargakosongan]" type="text" id="hargakosongan_' + idProduct + '" class="span2" onkeyup="autoComplete(' + idProduct + ');" style="text-align:right;"/></div></td>' +
                        '<td><div class="input-prepend"><span class="add-on">Rp</span><input name="master[detail][' + counter + '][plafonbbn]" id="plafonbbn_' + idProduct + '" type="text" class="span2" onkeyup="autoComplete(' + idProduct + ');" style="text-align:right;"/></div></td>' +
                        '<td><div class="input-prepend"><span class="add-on">Rp</span><input name="master[detail][' + counter + '][hargaotr]" id="hargaotr_' + idProduct + '" type="text" class="span2 txt" style="text-align:right;" readonly/></div></td>' +
//                    '<td><div class="input-prepend"><span class="add-on">Rp</span><input name="master[detail][' + counter + '][hargabeli]" id="hargabeli_' + idProduct + '" type="text" class="span2" value="" style="text-align:right;" /></div></td>' +
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

