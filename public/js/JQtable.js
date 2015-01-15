(function(){
 
var huSort = [' ', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'á', 'b', 'c', 'd', 'e', 'é', 'f', 'g', 'h', 'i', 'í', 'j', 'k', 'l', 'm', 'n', 'o', 'ó', 'ö', 'ő', 'p', 'q', 'r', 's', 't', 'u', 'ú', 'ü', 'ű', 'v', 'w', 'x', 'y', 'z' ];
 
  function GetUniCode(source) {
      source = $.trim(source);
      var result = '';
      var i, index;
      for (i = 0; i < source.length; i++) {
          //Check and fix IE indexOf bug
          if (!Array.indexOf) {
              index = jQuery.inArray(source.charAt(i), huSort);
          }else{
              index = huSort.indexOf(source.charAt(i));
          }
          if (index < 0) {
              index = source.charCodeAt(i);
          }
          if (index < 10) {
              index = '0' + index;
          }
          result += '00' + index;
      }
      return 'a' + result;
  }
 
  jQuery.extend( jQuery.fn.dataTableExt.oSort, {
      "huSort-pre": function ( a ) {
          if ($.isNumeric(a)){
            return parseInt(a);
          }
          else {
            return GetUniCode(a.toLowerCase());
          }
      },
   
      "huSort-asc": function ( a, b ) {
          return ((a < b) ? -1 : ((a > b) ? 1 : 0));
      },
   
      "huSort-desc": function ( a, b ) {
          return ((a < b) ? 1 : ((a > b) ? -1 : 0));
      }
  } );
 
}());


      init.push(function () {
        $(document).ready(function() {
          $("#sortable").dataTable({
            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "aoColumnDefs": [ { "sType": "huSort", "aTargets": ["_all"] } ],
          });
          $('.dataTables_filter input').attr('placeholder', 'Search...');
        });
      });