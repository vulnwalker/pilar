function saveUser(){
  $("#LoadingImage").attr('style','display:block');
  $.ajax({
    type:'POST',
    data : $("#formUser").serialize(),
    url: url+'&tipe=saveUser',
      success: function(data) {
      var resp = eval('(' + data + ')');
        if(resp.err==''){
          $("#LoadingImage").hide();
          refreshList();
        }else{
          // alert(resp.err);
          swal({
            position: 'top-right',
            type: 'warning',
            title: (resp.err),
            showConfirmButton: true,
            timer: 5000
          });
          $("#LoadingImage").hide();
        }
      }
  });
}

function refreshList(){
    window.location.reload();
}

function loadTable(){
  $.ajax({
    type:'POST',

    url: url+'&tipe=loadTable',
      success: function(data) {
      var resp = eval('(' + data + ')');
        if(resp.err==''){
          $("#datatables").html(resp.content.tabelUser);
          $('#datatables').DataTable({
              "pagingType": "full_numbers",
              "lengthMenu": [
                  [10, 25, 50, -1],
                  [10, 25, 50, "Semua"]
              ],
              responsive: true,
              language: {
                  search: "_INPUT_",
                  searchPlaceholder: "Cari data",
              },
              "oLanguage": {
                "sLengthMenu": "Data perhalaman &nbsp _MENU_ ",
              },
              "bSortable": false,
              "ordering": false
              // "aaSorting" : [[]]
          });
        }else{
          alert(resp.err);
        }
      }
  });
}


function deleteUser(id){
  $.ajax({
    type:'POST',
    data : {id : id},
    url: url+'&tipe=deleteUser',
      success: function(data) {
      var resp = eval('(' + data + ')');
        if(resp.err==''){
          refreshList();
        }else{
          alert(resp.err);
        }
      }
  });
}
 function checkSemua(n,fldName,elHeaderChecked,elJmlCek) {

   if (!fldName) {
     fldName = 'cb';
   }
   if (!elHeaderChecked) {
     elHeaderChecked = 'toggle';
   }
   var c = document.getElementById(elHeaderChecked).checked;
   var n2 = 0;
   for (i=0; i < n ; i++) {
    cb = document.getElementById(fldName+i);
    if (cb) {
      cb.checked = c;

      //  thisChecked($("#"+fldName+i).val(),fldName+i);
      n2++;
    }
   }
   if (c) {
    document.getElementById(elJmlCek).value = n2;
   } else {
    document.getElementById(elJmlCek).value = 0;
   }
   }

function saveEditUser(idEdit){
  $("#LoadingImage").attr('style','display:block');
  $.ajax({
    type:'POST',
    data : $("#formUser").serialize()+"&idEdit="+idEdit,
    url: url+'&tipe=saveEditUser',
      success: function(data) {
      var resp = eval('(' + data + ')');
        if(resp.err==''){
          $("#LoadingImage").hide();
          refreshList();
        }else{

          // alert(resp.err);
          swal({
            position: 'top-right',
            type: 'warning',
            title: (resp.err),
            showConfirmButton: true,
            timer: 5000
          });
          $("#LoadingImage").hide();
        }
      }
  });
}
