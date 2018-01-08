<?php
$tipe = @$_GET['tipe'];
$cek = "";
$err = "";
$content = "";

function setCekBox($cb, $KeyValueStr, $isi){
  $hsl = '';
  $Prefix = "userManagement";
  /*if($KeyValueStr!=''){*/
    $hsl = "<input type='checkbox' $isi id='".$Prefix."_cb$cb' name='".$Prefix."_cb[]'
        value='".$KeyValueStr."' onchange = thisChecked('".$Prefix."_cb$cb','userManagement_jmlcek'); >";
  /*}*/
  return $hsl;
}

if(!empty($tipe)){
  include "../include/config.php";
  foreach ($_POST as $key => $value) {
      $$key = $value;
  }
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

    case 'Hapus':{
      for ($i=0; $i < sizeof($userManagement_cb) ; $i++) {
        $query = "delete from users where id = '".$userManagement_cb[$i]."'";
        sqlQuery($query);
      }

      $cek = $query;
      echo generateAPI($cek,$err,$content);
    break;
    }

    case 'Edit':{

      $content = array("idEdit" => $userManagement_cb[0]);
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
                          <td class='text-center'><span class='checkbox'><label>".setCekBox($nomorCB,$id)."&nbsp</label></span></td>
                          <td>$nama</td>
                          <td>$username</td>
                          <td>$email</td>
                          <td>$instansi</td>
                          <td>$telepon</td>
                          <td>$jenisUser</td>
                      </tr>
                    ";
          $nomor += 1;
          $nomorCB += 1;
      }
      $tabel = "<table id='datatables' class='cell-border table-striped ' cellspacing='0' width='100%' style='width:100%'>
          <thead>
              <tr>
                  <th>No</th>
                  <th class='text-center'><span class='checkbox'><label><input type='checkbox' name='userManagement_toogle' id='userManagement_toogle' onclick=checkSemua(100,'userManagement_cb','userManagement_toogle','userManagement_jmlcek')>&nbsp</label></span></th>
                  <th>Nama</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Instansi</th>
                  <th>Telepon</th>
                  <th>Kategori</th>
              </tr>
          </thead>
          <tbody>
            $data
          </tbody>
      </table>
      <input type='hidden' name='userManagement_jmlcek' id='userManagement_jmlcek' value='0'>
      ";
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
        <nav class="navbar navbar-transparent navbar-absolute">
            <div class="container-fluid">
                <div class="navbar-minimize">
                    <button id="minimizeSidebar" class="btn btn-round btn-white btn-fill btn-just-icon">
                        <i class="material-icons visible-on-sidebar-regular">more_vert</i>
                        <i class="material-icons visible-on-sidebar-mini">view_list</i>
                    </button>
                </div>
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">User Management</a>
                </div>
            </div>
        </nav>
        <?php
          if(!isset($_GET['action'])){
            ?>

            <div class="content" style="margin-top:20px;">
              <div class="container-fluid">
                  <div class="row">
                      <div class="col-md-12">
                          <div class="card">
                              <div class="card-content">
                                  <div class="col-md-12" id='tableUser'>
                                      <div style="float:right">
                                        <button class="btn btn-primary" onclick="Baru();">Baru</button> &nbsp
                                        <button class="btn btn-warning" onclick="Edit();">Edit</button> &nbsp
                                        <button class="btn btn-danger" onclick="Hapus();">Hapus</button> &nbsp
                                      </div>
                                      <div class="material-datatables">
                                        <form id='formUserManagement' name="formUserManagement" action="#">
                                          <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
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
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
            </div>

            <?php
          }else{
              if($_GET['action'] == 'baru'){
                ?>
                <div class="content" style="margin-top:20px;">
                  <div class="container-fluid">
                    <div class="card">
                      <div class="card-content">
                          <form id='formUser'>
                          <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-3">
                                <?php
                                  $arrayStatus = array(
                                            array('1','MEMBER'),
                                            array('2','ADMIN'),
                                  );
                                  echo cmbArray("statusUser","",$arrayStatus,"-- TYPE USER --","class='form-control' data-style='btn btn-primary btn-round' title='Single Select' data-size='7'")
                                ?>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group label-floating" id='divForUsername'>
                                    <label class="control-label">Username</label>
                                    <input type="text" id='usernameUser' name='usernameUser' class="form-control">
                                </div>
                            </div>
                          </div>
                            <div class="row">
                              <div class="col-lg-12">
                                  <div class="form-group label-floating" id='divForPassword'>
                                      <label class="control-label">Password</label>
                                      <input type="password" id='passwordUser' name='passwordUser' class="form-control">
                                  </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-lg-12">
                                  <div class="form-group label-floating" id='divForEmail'>
                                      <label class="control-label">Email</label>
                                      <input type="email" id='emailUser' name='emailUser' class="form-control">
                                  </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-lg-12">
                                  <div class="form-group label-floating" id='divForNama'>
                                      <label class="control-label">Nama Lengkap</label>
                                      <input type="text" id='namaUser' name='namaUser' class="form-control">
                                  </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-lg-12">
                                  <div class="form-group label-floating" id='divForTelepon'>
                                      <label class="control-label">Telepon</label>
                                      <input type="number" id='teleponUser' name='teleponUser' class="form-control">
                                  </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-lg-12">
                                  <div class="form-group label-floating" id='divForAlamat'>
                                      <label class="control-label">Alamat</label>
                                      <textarea id='alamatUser' name='alamatUser' class="form-control"></textarea>
                                  </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-lg-12">
                                  <div class="form-group label-floating" id='divForInstansi'>
                                      <label class="control-label">Instansi</label>
                                      <input id='instansiUser' name='instansiUser' class="form-control">
                                  </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-lg-12">
                                <button type="button" class="btn btn-primary"  onclick="saveUser();" data-dismiss="modal">Simpan</button>
                                <button type="button" class="btn btn-danger"  onclick="Batal();" data-dismiss="modal">Batal</button>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php
              }elseif($_GET['action']=='edit'){
                  $getData = sqlArray(sqlQuery("select * from users where id = '".$_GET['idEdit']."'"));
                  $getRealPassword = sqlArray(sqlQuery("select * from wordlist where hash = '".$getData['password']."'"));
                  ?>
                  <div class="content" style="margin-top:20px;">
                    <div class="container-fluid">
                      <div class="card">
                        <div class="card-content">
                            <form id='formUser'>
                            <div class="row">
                              <div class="col-lg-3 col-md-6 col-sm-3">
                                  <?php
                                    $arrayStatus = array(
                                              array('1','MEMBER'),
                                              array('2','ADMIN'),
                                    );
                                    echo cmbArray("statusUser",$getData['jenis_user'],$arrayStatus,"-- TYPE USER --","class='form-control' data-style='btn btn-primary btn-round' title='Single Select' data-size='7'")
                                  ?>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-lg-12">
                                  <div class="form-group label-floating" id='divForUsername'>
                                      <label class="control-label">Username</label>
                                      <input type="text" id='usernameUser' name='usernameUser' value="<?php echo $getData['username'] ?>" class="form-control">
                                  </div>
                              </div>
                            </div>
                              <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group label-floating" id='divForPassword'>
                                        <label class="control-label">Password</label>
                                        <input type="password" id='passwordUser' name='passwordUser' value="<?php echo $getRealPassword['password'] ?>" class="form-control">
                                    </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group label-floating" id='divForEmail'>
                                        <label class="control-label">Email</label>
                                        <input type="email" id='emailUser' name='emailUser' value="<?php echo $getData['email'] ?>" class="form-control">
                                    </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group label-floating" id='divForNama'>
                                        <label class="control-label">Nama Lengkap</label>
                                        <input type="text" id='namaUser' name='namaUser' value="<?php echo $getData['nama'] ?>" class="form-control">
                                    </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group label-floating" id='divForTelepon'>
                                        <label class="control-label">Telepon</label>
                                        <input type="number" id='teleponUser' name='teleponUser' value="<?php echo $getData['telepon'] ?>"  class="form-control">
                                    </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group label-floating" id='divForAlamat'>
                                        <label class="control-label">Alamat</label>
                                        <textarea id='alamatUser' name='alamatUser' class="form-control"><?php echo $getData['alamat'] ?></textarea>
                                    </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group label-floating" id='divForInstansi'>
                                        <label class="control-label">Instansi</label>
                                        <input id='instansiUser' name='instansiUser' class="form-control" value="<?php echo $getData['instansi'] ?>">
                                    </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-12">
                                  <button type="button" class="btn btn-primary"  onclick="saveEditUser(<?php echo $_GET['idEdit'] ?>);" data-dismiss="modal">Simpan</button>
                                  <button type="button" class="btn btn-danger"  onclick="Batal();" data-dismiss="modal">Batal</button>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php
              }
          }
         ?>

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
