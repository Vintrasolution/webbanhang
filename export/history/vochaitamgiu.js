$(document).ready(function(){
    $(".saveAsExcel").click(function(){
        var workbook = XLSX.utils.book_new();
        
        //var worksheet_data  =  [['hello','world']];
        //var worksheet = XLSX.utils.aoa_to_sheet(worksheet_data);
      
        var worksheet_data  = document.getElementById("mytable");
        var worksheet = XLSX.utils.table_to_sheet(worksheet_data);
        
        workbook.SheetNames.push("Test");
        workbook.Sheets["Test"] = worksheet;
      
         exportExcelFile(workbook);
      
     
    });
})

function exportExcelFile(workbook) {
    var today = new Date();
  var year = today.getFullYear();
  var month = today.getMonth() + 1;
  var day = today.getDate();
  var fileName = "vochaitamgiu" + day + "-" + month + "-" + year + ".xlsx";
  return XLSX.writeFile(workbook, fileName);
}