function saveLowongan(){
  $("#LoadingImage").attr('style','display:block');
  $.ajax({
    type:'POST',
    data : $("#formLowongan").serialize()+"&jobDesc="+$("#summernote").code()+"&spesifikasiPekerjaan="+$("#spesifikasiLowongan").val(),
    url: url+'&tipe=saveLowongan',
      success: function(data) {
      var resp = eval('(' + data + ')');
      $("#LoadingImage").hide();
        if(resp.err==''){
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
          $("#datatables").html(resp.content.tabelLowongan);
          $('#datatables').DataTable({
              "pagingType": "full_numbers",
              "lengthMenu": [
                  [10, 25, 50, -1],
                  [10, 25, 50, "All"]
              ],
              responsive: true,
              language: {
                  search: "_INPUT_",
                  searchPlaceholder: "Search records",
              }

          });
        }else{
          alert(resp.err);
        }
      }
  });
}


function deleteLowongan(id){
  $.ajax({
    type:'POST',
    data : {id : id},
    url: url+'&tipe=deleteLowongan',
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
function clearTemp(){
  $("#data2").text("Baru");
  $("#data2").click();
}
function baruLowongan(){

          // $("#divForLowonganname").attr("class","form-group label-floating ");
          // $("#divForPassword").attr("class","form-group label-floating ");
          // $("#divForEmail").attr("class","form-group label-floating ");
          // $("#divForNama").attr("class","form-group label-floating ");
          // $("#divForTelepon").attr("class","form-group label-floating ");
          // $("#divForAlamat").attr("class","form-group label-floating ");
          // $("#divForInstansi").attr("class","form-group label-floating ");
          // $("#usernameLowongan").val("");
          // $("#passwordLowongan").val("");
          // $("#emailLowongan").val("");
          // $("#namaLowongan").val("");
          // $("#teleponLowongan").val("");
          // $("#alamatLowongan").text("");
          // $("#instansiLowongan").val("");
          // $("#statusLowongan").val("1");
          // $("#buttonSubmit").attr("onclick","saveLowongan()");

          $.ajax({
            type:'POST',
            url: url+'&tipe=editTab',
              success: function(data) {
              var resp = eval('(' + data + ')');
                if(resp.err==''){
                  $("#data2").text("Baru");
                  $("#lowonganBaru").html(resp.content);
                  $("#summernote").summernote();
                  $("#posisiLowongan").attr("class","form-control");
                  // $("#posisiLowongan").attr("data-style","btn btn-primary btn-round");
                  // $("#posisiLowongan").attr("title","Single Select' data-size='7'");
                  // $("#posisiLowongan").attr("class='selectpicker' data-style='btn btn-primary btn-round' title='Single Select' data-size='7'");
                }else{
                  alert(resp.err);
                }
              }
          });

}
function updateLowongan(id){
//  $("#LoadingImage").attr('style','display:block');
  $.ajax({
    type:'POST',
    data : {id : id},
    url: url+'&tipe=updateLowongan',
      success: function(data) {
      var resp = eval('(' + data + ')');
      //  $("#LoadingImage").hide();
        if(resp.err==''){
          $("#data2").text("Edit");
          $("#data2").click();
          // $("#divForLowonganname").attr("class","form-group label-floating is-focused");
          // $("#divForPassword").attr("class","form-group label-floating is-focused");
          // $("#divForEmail").attr("class","form-group label-floating is-focused");
          // $("#divForNama").attr("class","form-group label-floating is-focused");
          // $("#divForTelepon").attr("class","form-group label-floating is-focused");
          // $("#divForAlamat").attr("class","form-group label-floating is-focused");
          // $("#divForInstansi").attr("class","form-group label-floating is-focused");
          $("#posisiLowongan").html(resp.content.posisiLowongan);
          $("#divPendidikanLowongan").html(resp.content.pendidikanLowongan);
          // $("#emailLowongan").val(resp.content.emailLowongan);
          // $("#namaLowongan").val(resp.content.namaLowongan);
          // $("#teleponLowongan").val(resp.content.teleponLowongan);
          // $("#alamatLowongan").text(resp.content.alamatLowongan);
          // $("#instansiLowongan").val(resp.content.instansiLowongan);
          // $("#statusLowongan").html(resp.content.statusLowongan);
          $("#buttonSubmit").attr("onclick","saveEditLowongan("+id+")");
        }else{
          alert(resp.err);
        }
      }
  });
}


function saveEditLowongan(idEdit){
  $("#LoadingImage").attr('style','display:block');
  $.ajax({
    type:'POST',
    data : $("#formLowongan").serialize()+"&jobDesc="+$("#summernote").code()+"&idEdit="+idEdit+"&spesifikasiPekerjaan="+$("#spesifikasiLowongan").val(),
    url: url+'&tipe=saveEditLowongan',
      success: function(data) {
      var resp = eval('(' + data + ')');
        $("#LoadingImage").hide();
        if(resp.err==''){
          refreshList();
        }else{
          swal({
            position: 'top-right',
            type: 'warning',
            title: (resp.err),
            showConfirmButton: true,
            timer: 5000
          });

        }
      }
  });
}


function base64Encode(str) {
    return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g,
        function toSolidBytes(match, p1) {
            return String.fromCharCode('0x' + p1);
    }));
}

function base64Decode(str) {
    // Going backwards: from bytestream, to percent-encoding, to original string.
    return decodeURIComponent(atob(str).split('').map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(''));
}
