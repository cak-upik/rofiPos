
$(document).ready(function()
{
    //}
    $("li.hakses").click(function(){
        $.get("module/hak_akses/main.php", {page:"view"}, function(a){
            $("#content").html(a);
        });
        /* get absolute path
        var loc = window.location;
        var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
        return alert(loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length)));  */
//        var loc = $('a', this).attr("href");
//        switch(loc) {
//            case 'hak_akses':
//                $("#content").html('module/hak_akses/main.php?page=view');
//                break;
//            default:
//                break;
//        }
//        if(loc == 'hak_akses') {
//            link = 'module/hak_akses/main.php';
//        }
//        return $("#content").load('penjualan/module/hak_akses/main.php');
    });
});
