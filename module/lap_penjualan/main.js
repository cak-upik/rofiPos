/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function autoComplete() {

    q = document.getElementById('kuantitas').value;
    p = document.getElementById('harga').value;
    a = document.getElementById('diskon').value;

    if (q !== 0 && a !== 0) {
        jmlh = p - q - a;
    } else if (q === 0 && a === 0) {
        jmlh = p - q - a;
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
});