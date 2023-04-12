"use strict";

$("#table-1").dataTable({
  "columnDefs": [
    { "sortable": true, "targets": [2,3,4] }
  ]
});
$("#table-2").dataTable({
  "columnDefs": [
    { "sortable": false, "targets": [0,2,3] }
  ]
});