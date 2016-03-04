var cache = {},
    counter = 0,
    emptyText = '<tr><td colspan="6" class="sys_align_center">No data added...</td></tr>';

function autoComplete(value) //fungsi menangkap input search dan menampilkan hasil search
{
	
        
        //id = document.getElementById('kode').value;
	a = document.getElementById('kuantitas'+value).value;
	b = document.getElementById('filterKuantitas'+value).value;
        //var a = $('#quantity'+value).val();
        //var b = $('#quantityfilter'+value).val();
        
        jmlh = a - b;
         //alert("Quantity that you enter too many. (Max. "+jmlh+")");
         
        if(jmlh > '0'){
            
            alert("Kuantitas yang anda masukkan terlalu banyak. (Max. "+b+")");
            //document.getElementById('quantity'+value).value = b;
            $('#kuantitas'+value).val(b);
        }
        else if(jmlh === '0'){
            
            alert("Kuantitas yang anda masukkan terlalu banyak. (Max. "+b+")");
            //document.getElementById('quantity'+value).value = b;
            $('#kuantitas'+value).val(b);
        }
        
          
}


$(document).ready(function() {
    var tbodyw = $('#returProduct');
    var tbodye = $('#addProductEdit');
    //var idnya=$('#quantity').attr('id');
    //idnya.hide();
    //var counter2 = 0;
    $('#id_pemesanan_stok').change(function() {
        var poid = $(this).val();
        //alert("This property have available in list");
        $.ajax({
            url: "module/retur/service.php",
            data: "getproduct="+poid,
            cache: false,
            success: function(msg){
                $('#id_sparepart').html(msg);
                tbodyw.html(emptyText); 
            }
            
	});
    });
    
    $('#addRetur').click(function(evt) {
        
        var idp1 = $('#id_sparepart').val();
        var poId = $('#id_pemesanan_stok').val();
        var dc3=window.atob(idp1);
            var myarr3 = dc3.split("||");
            var idProduct = myarr3[0];
            var nama= myarr3[1];
            var kode= myarr3[2];
            var harga= myarr3[3];
        var idProduct1 = $('#id_'+ idProduct).val();
        //alert("Please select one from the list "+idProduct);
        getquantity(idProduct, poId);
        
        if(idProduct === ''){
            alert("Please select one from the list");
        }else{
            if(idProduct1 === idProduct){
                alert("This property have available in list");
            }else{
                var output = '<tr id="data_' + counter +'">' +
                                '<td><input type="checkbox" /></td>' +
                                '<td><input name="kode_sparepart" type="text" id="kode_sparepart'+ idProduct +'" class="span2" value="'+ kode +'" readonly/></td>' +
                                '<td><input name="name" type="text" id="name'+ idProduct +'" class="span2" value="'+ nama +'" readonly/>' +
                                '<input name="retur[detail][' + counter + '][id_sparepart]" type="hidden" id="id_'+ idProduct +'" class="span2" value="'+ idProduct +'" readonly/></td>' +
                                '<td><input name="retur[detail][' + counter + '][harga]" type="text" id="harga'+ idProduct +'" class="span3" value="'+ harga +'" readonly/></td>' +
                                '<td><input name="retur[detail][' + counter + '][kuantitas]" id="kuantitas'+idProduct+'" type="text" class="span2" value="" onblur="autoComplete('+ idProduct +','+ poId +' );"/>' + 
                                '<input id="filterKuantitas'+idProduct+'" type="hidden" class="span2" value="" /></td>' +
                                '<td><textarea name="retur[detail][' + counter + '][keterangan]" class="span2"></textarea></td>' +
                             '</tr>';

                if ($('tr td', tbodyw).length == 1) {
                    tbodyw.html('');
                }

                tbodyw.append(output);
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
        var idp = $('#id_sparepart').val();
        var poId = $('#id_pemesanan_stok').val();
        var dc6=window.atob(idp);
            var myarr6 = dc6.split("||");
            var idProduct = myarr6[0];
            var nama= myarr6[1];
            var kode= myarr6[2];
            var harga= myarr6[3];
        var idProduct1 = $('#akses2_'+ idProduct).val();
        getquantity2(idProduct, poId);
        //var a = getname(idProduct);
        
        if(idProduct === ''){
            alert("Please select one from the list");
        }else{
            if(idProduct1 === idProduct){
                alert("This property have available in list");
            }else{
               
                var output = '<tr id="data_' + counter +'">' +
                                '<td><input type="checkbox" /></td>' +
                                '<td><input name="kode_sparepart" type="text" id="kode_sparepart'+ idProduct +'" class="span2" value="'+ kode +'" readonly/></td>' +
                                '<td><input name="name" type="text" id="name'+ idProduct +'" class="span2" value="'+ nama +'" readonly/>' +
                                '<input name="retur[detail][' + counter + '][id_sparepart]" type="hidden" id="akses2_'+ idProduct +'" class="span2" value="'+ idProduct +'" readonly/></td>' +
                                '<td><input name="retur[detail][' + counter + '][harga]" type="text" id="harga'+ idProduct +'" class="span2" value="'+ harga +'" readonly/></td>' +
                                '<td><input name="retur[detail][' + counter + '][kuantitas]" id="kuantitas2'+idProduct+'" type="text" class="span2" value="" onblur="autoComplete('+ idProduct +','+ poId +' );"/>' + 
                                '<input id="filterKuantitas2'+idProduct+'" type="hidden" class="span2" value="" /></td>' +
                                '<td><textarea name="retur[detail][' + counter + '][keterangan]" class="span2"></textarea></td>' +
                             '</tr>';

                if ($('tr td', tbodye).length == 1) {
                    tbodye.html('');
                }

                tbodye.append(output);
            }
        }
        
        
        counter++;
        
        evt.preventDefault();             
    });
    
    $('#deleteEdit').click(function(evt) {
        
            $('input:checked', tbodye).each(function() {
                var id = $(this).val();
                var iddel = $('#editCheck_'+ (id)).val();
                var quantity = $('#quantity_'+ (id)).val();

                var output = '<tr style="display: none;">' +
                            '<td colspan="2"><input name="retur[delete]['+ id +'][id_sparepart]" type="hidden" value="' + iddel + '" /></td>' +
                            '<td colspan=""><input name="retur[delete]['+ id +'][kuantitas]" type="hidden" value="' + quantity + '" /></td>' +
                         '</tr>';

                tbodye.append(output);

                $(this).closest('tr').remove();            
            });   
            
                                                   
        
        if ($('tr', tbodye).length == 0) {            
            tbodye.html(emptyText);    
        }
        
        evt.preventDefault();     
    });
    
    $('.trigger').click(function() {
        $(this).parents("tr").next().slideToggle();
        return false;
    });
  
});


 function getquantity(value, poId){
   // var id = $('#id').val();
	$.ajax({
            url: "module/retur/service.php",
            data: "getquantity="+value+"&id="+poId,
            cache: false,
            success: function(msg){
                $('#kuantitas'+value).val(msg);
                $('#filterKuantitas'+value).val(msg);
            }
            
	});
}

function getquantity2(value, poId){
   // var id = $('#id').val();
	$.ajax({
            url: "module/retur/service.php",
            data: "getquantity2="+value+"&id="+poId,
            cache: false,
            success: function(msg){
                $('#kuantitas2'+value).val(msg);
                $('#filterKuantitas2'+value).val(msg);
            }
            
	});
}

