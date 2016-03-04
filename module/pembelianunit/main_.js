var cache = {},
        counter = 0,
        emptyText = '<tr><td colspan="6" class="sys_align_center">No data added...</td></tr>';


$(document).ready(function() {
    var tbody = $('#addProduct');
    var tbody2 = $('#addProductEdit');
    //var idnya=$('#quantity').attr('id');
    //idnya.hide();
    //var counter2 = 0;

    $('#add').click(function(evt) {
        var idu1 = $('#unitId').val();
        var dc3 = window.atob(idu1);
        var myarr3 = dc3.split("||");
        var id = myarr3[0];
//        var name = myarr3[1];
        var kode= myarr3[2];
        var id1 = $('#id_' + id).val();
        var a = getname(id);

        if (id === '') {
            alert("Please select one from the list");
        } else {
            if (id1 === id) {
                alert("This property have available in list");
            } else {
                var output = '<tr id="data_' + counter + '">' +
                        '<td><input type="checkbox" /></td>' +
                        '<td><input name="id" type="text" id="id'+ id +'" class="span2" value="'+kode+'" readonly/></td>' +
                        '<td><input name="name" type="text" id="name' + id + '" class="span2" value="" readonly/>' +
                        '<input name="unit[detail][' + counter + '][unitId]" type="hidden" id="id_' + id + '" class="span2" value="' + id + '" readonly/></td>' +
                        '<td><input name="unit[detail][' + counter + '][quantity]" id="quantity' + id + '" type="text" class="span2" value="" /></td>' +
                        '<td><input name="unit[detail][' + counter + '][price]" id="price' + id + '" type="text" class="span2" value="" /></td>' +
                        '<td><textarea name="unit[detail][' + counter + '][remark]" id="remark' + id + '" class="span2" row="4"></textarea></td>' +
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

        if ($('tr', tbody).length == 0) {
            tbody.html(emptyText);
        }

        evt.preventDefault();
    });

    $('#addEdit').click(function(evt) {
        var idp = $('#unitId').val();
        var dc2 = window.atob(idp);
        var myarr2 = dc2.split("||");
        var id = myarr2[0];
        var name = myarr2[1];
        var kode = myarr2[2];
        var id1 = $('#editCheck_' + id).val();
        var a = getname(id);

        if (id === '') {
            alert("Please select one from the list");
        } else {
            if (id1 === id) {
                alert("This property have available in list");
            } else {
                var output = '<tr id="data_' + counter + '">' +
                        '<td><input type="checkbox" /></td>' +
                        '<td><input name="kode_sparepart" type="text" id="kode_sparepart' + id + '" class="span2" value="' + kode + '" readonly/></td>' +
                        '<td><input name="name" type="text" id="name' + id + '" class="span2" value="" readonly/>' +
                        '<input name="unit[detail][' + counter + '][unitId]" type="hidden" id="id_' + id + '" class="span3" value="' + id + '" readonly/></td>' +
                        '<td><input name="unit[detail][' + counter + '][quantity]" id="quantity' + id + '" type="text" class="span2" value="" /></td>' +
                        '<td><input name="unit[detail][' + counter + '][price]" id="price' + id + '" type="text" class="span2" value="" /></td>' +
                        '<td><textarea name="unit[detail][' + counter + '][remark]" id="remark' + id + '" class="span2" row="4"></textarea></td>' +
                        '</tr>';

                if ($('tr td', tbody).length == 1) {
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
        url: "module/pemesananunit/service.php",
        data: "getname=" + value,
        cache: false,
        success: function(msg) {
            $('#name' + value).val(msg);
        }

    });
}

