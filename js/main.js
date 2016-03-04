var hitEvent = 'ontouchstart' in document.documentElement
? 'touchstart'
: 'click';

$(document).ready(function() {

   $("form select").select2();
});

function deleteConfirm() {
   $('a[href=#delete-confirm]').click(function(e) {
      var data = $(this).data('data');
      var url = $(this).data('url');
      return bootbox.dialog('Anda yakin akan menghapus data?', [{
         'label':'Hapus',
         'class':'btn btn-danger',
         'icon':'icon-trash icon-white',
         'callback':function() {
            return location.href = url;
         }
      }, {
         'label':'Batal',
         'class':'btn'
      }]);
   });   
}