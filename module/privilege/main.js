var cache = {},
    counter = 0,
    emptyText = '<tr><td colspan="2" class="sys_align_center">No data added...</td></tr>';

$(document).ready(function() {
    var tbody = $('#masterprivilege');
    var tbody2 = $('#masterEditprivilege');
    var param = $('#param').val();
    //$('#hak_akses').hide();
    
    
    $('#addDetil').click(function(evt) {
        var idDetil = $('#hak_akses').val();
        if(idDetil === ''){
            alert("Please select one from the list");
        }else{
            var dc2=window.atob(idDetil);
            var myarr2 = dc2.split("||");
            var id = myarr2[0];
            var nama= myarr2[1];

            var masuk2 = $('#akses2_'+ (id)).val();
        
        
            if(masuk2 === id){
                alert("This property have available in list");
            }else{
                var output = '<tr id="data_' + (counter) + '">' +
                            '<td><input type="checkbox" /></td>' +
                            '<td><input name="master_privilege[detail][' + counter + '][nama_hak_akses]" type="text" class="span4" value="'+ nama +'" readonly/>' +
                            '<input name="master_privilege[detail][' + counter + '][id_hak_akses]" type="hidden" class="span4" value="'+ id +'" id="akses2_'+ id +'"/></td>' +
                         '</tr>';      

            }
        }
        
        if ($('tr td', tbody).length == 1) {
                tbody.html('');
            }

            tbody.prepend(output);
        
        counter++;
        
        evt.preventDefault();         
    });
    
    $('#editDetil').click(function(evt) {
        var idDetil = $('#edithak_akses').val();
        if(idDetil === '' ){
            alert("Please select one from the list");
        }else{
            var dc2=window.atob(idDetil);
            var myarr2 = dc2.split("||");
            var id = myarr2[0];
            var nama= myarr2[1];

            var masuk2 = $('#akses2_'+ (id)).val();
        
            if(masuk2 === id){
                alert("This property have available in list");
            }else{
                var output = '<tr id="data_' + (counter) + '">' +
                            '<td><input type="checkbox" /></td>' +
                            '<td><label>'+ nama +'</label>' +
                            '<input name="master_privilege[detail][' + counter + '][nama_hak_akses]" type="hidden" class="span4" value="'+ nama +'" />' +
                            '<input name="master_privilege[detail][' + counter + '][id_hak_akses]" type="hidden" class="span4" value="'+ id +'" id="akses2_'+ id +'"/></td>' +
                         '</tr>';      

            }
        }
        
        if ($('tr td', tbody).length == 1) {
                tbody2.html('');
            }

            tbody2.prepend(output);
        
        counter++;
        
        evt.preventDefault();         
    });
    
    
    $('#deleteDetil').click(function(evt) {
        $('input:checked', tbody).each(function() {
            $(this).closest('tr').remove();            
        });                                                  
        
        if ($('tr', tbody).length == 0) {            
            tbody.html(emptyText);    
        }
        
        evt.preventDefault();     
    });
    
    $('#deleteEditDetil').click(function(evt) {
        
            $('input:checked', tbody2).each(function() {
                var id = $(this).val();
                var iddel = $('#editCheck_'+ (id)).val();

                var output = '<tr style="display: none;">' +
                            '<td colspan="2"><input name="master_privilege[delete]['+ id +'][delId]" type="hidden" value="' + iddel + '" /></td>' +
                         '</tr>';

                tbody2.append(output);

                $(this).closest('tr').remove();            
            });   
            
                                                   
        
        if ($('tr', tbody2).length == 0) {            
            tbody2.html(emptyText);    
        }
        
        evt.preventDefault();     
    });
    
    // Validation
        $("#createpriv").validate({
            rules:{
		id_user:"required",
                hak_akses:"required"
            },

            messages:{
                id_user:"Field tidak boleh kosong",
                hak_akses:"Field tidak boleh kosong"

                },

                errorClass: "help-inline",
                errorElement: "span",
                highlight:function(element, errorClass, validClass)
                {
                    $(element).parents('.control-group').addClass('error');
                },
                unhighlight: function(element, errorClass, validClass)
                {
                    $(element).parents('.control-group').removeClass('error');
                    $(element).parents('.control-group').addClass('success');
                }
            });
        
});


