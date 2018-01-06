<?php
$tipe = @$_GET['tipe'];
$cek = "";
$err = "";
$content = "";

if(!empty($tipe)){
  include "../include/config.php";
  foreach ($_POST as $key => $value) {
      $$key = $value;
  }
}

function setCekBox($cb, $KeyValueStr, $isi){
  $hsl = '';
  $Prefix = "userManagement";
  /*if($KeyValueStr!=''){*/
    $hsl = "<input type='checkbox' $isi id='".$Prefix."_cb$cb' name='".$Prefix."_cb[]'
        value='".$KeyValueStr."' onchange = thisChecked('$KeyValueStr','".$Prefix."_cb$cb'); >";
  /*}*/
  return $hsl;
}

switch($tipe){

    case 'saveUser':{
      if(empty($statusUser)){
          $err = "Pilih status user";
      }elseif(empty($usernameUser)){
          $err = "Isi username";
      }elseif(empty($emailUser)){
          $err = "Isi email";
      }elseif(empty($passwordUser)){
          $err = "Isi password ";
      }elseif(empty($namaUser)){
          $err = "Isi nama ";
      }

      if(empty($err)){
          $data = array(
                  'email' => $emailUser,
                  'username' => $usernameUser,
                  'password' => sha1(md5($passwordUser)),
                  'nama' => $namaUser,
                  'telepon' => $teleponUser,
                  'alamat' =>  $alamatUser,
                  'instansi' =>  $instansiUser,
                  'jenis_user' =>  $statusUser,
          );
          $query = sqlInsert("users",$data);
          sqlQuery($query);
          $cek = $query;

          $dataHash = array(
              'hash' => sha1(md5($passwordUser)),
              'password' => $passwordUser,
          );
          if(mysql_num_rows(mysql_query("select * from wordlist where password = '$passwordUser'")) == 0){
              sqlQuery(sqlInsert("wordlist",$dataHash));
          }

      }
      $content = array("judulUser" => $judulUser);

      echo generateAPI($cek,$err,$content);
    break;
    }

    case 'saveEditUser':{
      if(empty($statusUser)){
          $err = "Pilih status user";
      }elseif(empty($usernameUser)){
          $err = "Isi username";
      }elseif(empty($emailUser)){
          $err = "Isi email";
      }elseif(empty($passwordUser)){
          $err = "Isi password ";
      }elseif(empty($namaUser)){
          $err = "Isi nama ";
      }

      if(empty($err)){
        $data = array(
                'email' => $emailUser,
                'username' => $usernameUser,
                'password' => sha1(md5($passwordUser)),
                'nama' => $namaUser,
                'telepon' => $teleponUser,
                'alamat' =>  $alamatUser,
                'instansi' =>  $instansiUser,
                'jenis_user' =>  $statusUser,
        );
        $query = sqlUpdate("users",$data,"id = '$idEdit'");
        sqlQuery($query);
        $cek = $query;

        $dataHash = array(
            'hash' => sha1(md5($passwordUser)),
            'password' => $passwordUser,
        );
        if(mysql_num_rows(mysql_query("select * from wordlist where password = '$passwordUser'")) == 0){
            sqlQuery(sqlInsert("wordlist",$dataHash));
        }
      }
      $content = array("judulUser" => $judulUser);

      echo generateAPI($cek,$err,$content);
    break;
    }

    case 'deleteUser':{
      $query = "delete from users where id = '$id'";
      sqlQuery($query);
      $cek = $query;
      echo generateAPI($cek,$err,$content);
    break;
    }

    case 'updateUser':{
      $getData = sqlArray(sqlQuery("select * from users where id = '$id'"));
      $getRealPassword = sqlArray(sqlQuery("select * from wordlist where hash = '".$getData['password']."'"));
      $arrayStatus = array(
                array('1','MEMBER'),
                array('2','ADMIN'),
      );
      $content = array("usernameUser" => $getData['username'],"statusUser" => cmbArray("statusUser",$getData['jenis_user'],$arrayStatus,"-- TYPE USER --","class='selectpicker' data-style='btn btn-primary btn-round' title='Single Select' data-size='7'"),
       "emailUser" => $getData['email'], "passwordUser" => $getRealPassword['password'], "namaUser" => $getData['nama'], "teleponUser" => $getData['telepon'], "alamatUser" => $getData['alamat'], "instansiUser" => $getData['instansi']);
      echo generateAPI($cek,$err,$content);
    break;
    }

    case 'loadTable':{
      $getData = sqlQuery("select * from users");
      $nomor = 1;
      $nomorCB = 0;
      while($dataUser = sqlArray($getData)){
        foreach ($dataUser as $key => $value) {
            $$key = $value;
        }
        if($jenis_user == '1'){
            $jenisUser = "MEMBER";
        }else{
            $jenisUser = "ADMIN";
        }
        $data .= "     <tr>
                          <td class='text-center'>$nomor</td>
                          <td class='text-center'><span class='checkbox'><label>".setCekBox($nomorCB,$id,"")."&nbsp</label></span></td>
                          <td>$nama</td>
                          <td>$email</td>
                          <td>$instansi</td>
                          <td>$telepon</td>
                          <td>$alamat</td>
                          <td>$jenisUser</td>
                      </tr>
                    ";
          $nomor += 1;
          $nomorCB += 1;
      }

      $tabel = "<form id='formUserManagement'><table id='datatables' class='cell-border table-striped ' cellspacing='0' width='100%' style='width:100%'>
          <thead>
              <tr>
                  <th>No</th>
                  <th class='text-center'><span class='checkbox'><label><input type='checkbox' name='userManagement_toogle' id='userManagement_toogle' onclick=checkSemua(100,'userManagement_cb','userManagement_toogle','userManagement_jmlcek')>&nbsp</label></span></th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Instansi</th>
                  <th>Telepon</th>
                  <th>Alamat</th>
                  <th>Kategori</th>

              </tr>

          </thead>

          <tbody>
            $data
          </tbody>
      </table></form>";
      $content = array("tabelUser" => $tabel);

      echo generateAPI($cek,$err,$content);
    break;
    }

     default:{
        ?>
        <script>
        var url = "http://"+window.location.hostname+"/api.php?page=userManagement";

        </script>
        <script src="js/userManagement.js"></script>



        <div class="content" style="margin-top:100px;">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-12">

                      <div class="card-content">
                          <div class="col-md-2">
                            <div class="card-content">
                                <span id='minimizeSidebar' >
                                 <i  class='material-icons visible-on-sidebar-regular' style="cursor:pointer;">
                                    arrow_back
                                 </i>
                                 <i  class='material-icons visible-on-sidebar-mini' style="cursor:pointer;">
                                    arrow_forward
                                 </i>
                               </span>

                            </div>
                          </div>
                          <div class="col-md-10" style="text-align:right;">
                            <div class="card-content">
                              <i class='large material-icons' style="cursor:pointer;">
                                 add_to_photos
                              </i>
                              <i class='large material-icons' style="cursor:pointer;">
                                edit
                              </i>
                              <i class='large material-icons' style="cursor:pointer;">
                                delete
                              </i>

                            </div>
                          </div>
                        </div>
                    </div>
                  </div>
                <div class="row">
                    <div class="col-md-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="col-md-12" id='tableUser'>
                                          <div class="card-content">
                                              <h4 class="card-title">User Management</h4>
                                              <div class="material-datatables">
                                                  <table id="datatables" class="cell-border table-striped table-hover" cellspacing="0" width="100%" style="width:100%">
                                                      <thead>
                                                          <tr>
                                                              <th>Judul</th>
                                                              <th>Posisi</th>
                                                              <th>Tanggal</th>
                                                              <th>Penulis</th>
                                                              <th>Status</th>
                                                              <th class="disabled-sorting text-right">Actions</th>
                                                          </tr>
                                                      </thead>
                                                      <tbody>
                                                      </tbody>
                                                  </table>
                                              </div>
                                      </div>
                                </div>
                            </div>
                        </div>
                </div>
                <!-- end row -->
            </div>
        </div>



  <!-- Popup Area -->

        <div class="modal fade" id="formUserBaru" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="width:80%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="material-icons">clear</i>
                        </button>
                        <h4 class="modal-title">User</h4>
                    </div>
                    <div class="modal-body">
                        <form id='formUser'>
                        <!-- Start Customisable -->
                        <div class="row">
                          <div class="col-md-6">
                              <div class="row">
                                  <div class="col-lg-6 col-md-4 col-sm-3">
                                    <?php
                                        $arrayStatus = array(
                                                  array('1','PUBLISH'),
                                                  array('2','NON PUBLISH'),
                                        );
                                        echo cmbArray("statusPublish","1",$arrayStatus,"STATUS","class='selectpicker' data-style='btn btn-primary btn-round' title='Single Select' data-size='7'")
                                     ?>
                                  </div>
                              </div>
                          </div>
                      </div>
                        <!-- End Customisable -->

                        <!-- Start Form Input -->
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">Judul User</label>
                                    <input type="text" id='judulUser' class="form-control">
                                </div>
                            </div>
                        </div>
                        <!-- End Form Input -->



                        <!-- Start Checkbox and Radio Buttons -->
                        <div class="row">
                          <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                <div class="radio">
                                    <label class="control-label">Posisi User</label>
                                </div>
                          </div>
                          <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                              <div class="radio">
                                  <label>
                                      <input type="radio" value='1' id='kiri' name="posisiUser" checked> Kiri
                                  </label>
                              </div>
                          </div>
                          <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                              <div class="radio">
                                  <label>
                                      <input type="radio" value='2' id='kanan' name="posisiUser"> Kanan
                                  </label>
                              </div>
                          </div>
                        </div>
                        <!-- End Checkbox and Radio Buttons -->

                        <!-- BEGIN SUMMERNOTE -->
                        <div class="card">
                            <div class="card-body no-padding">
                                <div id="summernote">
                                </div>
                            </div><!--end .card-body -->
                        </div><!--end .card -->
                        <!-- END SUMMERNOTE -->

                    </div>
                  </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-simple" id='buttonSubmit' onclick="saveUser();" data-dismiss="modal">Simpan</button>
                        <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>



        <div class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" id="LoadingImage" style="display: none;">
                <div class="modal-dialog modal-notice">
                    <div class="modal-content" style="background-color: transparent; border: unset; box-shadow: unset;">
                        <div class="modal-body">
                            <!-- <div id="LoadingImage"> -->
                              <img src="img/unnamed.gif" style="width: 30%; height: 30%; display: block; margin: auto;">
                            <!-- </div> -->
                        </div>
                    </div>
                </div>
        </div>
<?php

     break;
     }

}

?>
