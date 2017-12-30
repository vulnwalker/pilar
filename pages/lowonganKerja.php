<?php
$tipe = @$_GET['tipe'];
$cek = "";
$err = "";
$content = "";

if(!empty($tipe)){
  // include "../include/config.php";
  foreach ($_POST as $key => $value) {
      $$key = $value;
  }
}


switch($tipe){

    case 'saveLowongan':{

      if(empty($posisiLowongan)){
          $err = "Pilih Posisi Pekerjaan";
      }elseif(empty($spesifikasiPekerjaan)){
          $err = "Isi spesifikasi pekerjaan";
      }elseif(empty($jobDesc)){
          $err = "Isi deskripsi pekerjaan ";
      }

      if(empty($err)){
          $data = array(
                  'posisi' => $posisiLowongan,
                  'pendidikan' => implode(";",$pendidikanLowongan),
                  'salary' => $salaryMinimum."-".$salaryMaximum,
                  'jam_kerja' => $jamKerja,
                  'pengalaman' => $pengalamanLowongan,
                  'deskripsi' =>  $jobDesc,
                  'spesifikasi' =>  $spesifikasiPekerjaan,
          );
          $query = sqlInsert("lowongan_kerja",$data);
          sqlQuery($query);
          $cek = $query;


      }
      $content = array("judulLowongan" => $judulLowongan);

      echo generateAPI($cek,$err,$content);
    break;
    }

    case 'saveEditLowongan':{
      if(empty($statusLowongan)){
          $err = "Pilih status user";
      }elseif(empty($usernameLowongan)){
          $err = "Isi username";
      }elseif(empty($emailLowongan)){
          $err = "Isi email";
      }elseif(empty($passwordLowongan)){
          $err = "Isi password ";
      }elseif(empty($namaLowongan)){
          $err = "Isi nama ";
      }

      if(empty($err)){
        $data = array(
                'email' => $emailLowongan,
                'username' => $usernameLowongan,
                'password' => sha1(md5($passwordLowongan)),
                'nama' => $namaLowongan,
                'telepon' => $teleponLowongan,
                'alamat' =>  $alamatLowongan,
                'instansi' =>  $instansiLowongan,
                'jenis_user' =>  $statusLowongan,
        );
        $query = sqlUpdate("lowongan_pekerjaan",$data,"id = '$idEdit'");
        sqlQuery($query);
        $cek = $query;

        $dataHash = array(
            'hash' => sha1(md5($passwordLowongan)),
            'password' => $passwordLowongan,
        );
        if(mysql_num_rows(mysql_query("select * from wordlist where password = '$passwordLowongan'")) == 0){
            sqlQuery(sqlInsert("wordlist",$dataHash));
        }
      }
      $content = array("judulLowongan" => $judulLowongan);

      echo generateAPI($cek,$err,$content);
    break;
    }

    case 'deleteLowongan':{
      $query = "delete from lowongan_pekerjaan where id = '$id'";
      sqlQuery($query);
      $cek = $query;
      echo generateAPI($cek,$err,$content);
    break;
    }

    case 'updateLowongan':{
      $getData = sqlArray(sqlQuery("select * from lowongan_pekerjaan where id = '$id'"));
      $getPendidikan = sqlQuery('select * from ref_pendidikan');
      $explodePendidikan = explode(";",$getData['pendidikan']);
      while ($dataPendidikan = sqlArray($getPendidikan)) {
        //  if(in_array($dataPendidikan['id'],$explodePendidikan)){
              $selected = "selected";
          // }else{
          //     $selected = "";
          // }
          $isiPendidikan .= "<option value='".$dataPendidikan['id']."' $selected > ".$dataPendidikan['tingkat']."</option>";
      }
      $comboPendidikan = "
      <div class='col-lg-12 col-md-6 col-sm-3' id='divPendidikanLowongan'>
          <label class='control-label'>Pendidikan</label>
          <select class='selectpicker' name='pendidikanLowongan[]' id='pendidikanLowongan' data-style='select-with-transition' multiple title='Pilih Pendidikan' data-size='7'>
          <option disabled> Pilih Pendidikan</option>
          $isiPendidikan
      </select>
      </div>";
      $content = array("posisiLowongan" => cmbQuery("posisiLowongan",$getData['posisi'],"select id,posisi from ref_posisi","class='selectpicker' data-style='btn btn-primary btn-round' title='Single Select' data-size='7'","-- POSISI --"),"pendidikanLowongan" => $comboPendidikan,
       "emailLowongan" => $getData['email'], "passwordLowongan" => $getRealPassword['password'], "namaLowongan" => $getData['nama'], "teleponLowongan" => $getData['telepon'], "alamatLowongan" => $getData['alamat'], "instansiLowongan" => $getData['instansi']);
      echo generateAPI($cek,$err,$content);
    break;
    }

    case 'loadTable':{
      $getData = sqlQuery("select * from lowongan_kerja");
      while($dataLowongan = sqlArray($getData)){
        foreach ($dataLowongan as $key => $value) {
            $$key = $value;
        }
        $getPosisi = sqlArray(sqlQuery("select * from ref_posisi where id = '$posisi'"));
        $namaPosisi = $getPosisi['posisi'];
        $explodePendidikan = explode(';',$pendidikan);
        if(sizeof($explodePendidikan) != 0){
            for ($i=0; $i < sizeof($explodePendidikan) ; $i++) {
                $getNamaPendidikan = sqlArray(sqlQuery("select * from ref_pendidikan where id ='".$explodePendidikan[$i]."'"));
                $listPendidikan .= "- ".$getNamaPendidikan['tingkat']."<br>";
            }
        }else{
            $getNamaPendidikan = sqlArray(sqlQuery("select * from ref_pendidikan where id ='$pendidikan'"));
            $listPendidikan = "- ".$getNamaPendidikan['tingkat'];
        }

        $data .= "     <tr>
                          <td>$namaPosisi</td>
                          <td>$listPendidikan</td>
                          <td>$salary</td>
                          <td>$jam_kerja</td>
                          <td>$pengalaman</td>
                          <td class='text-right'>
                              <a onclick=updateLowongan($id) class='btn btn-simple btn-warning btn-icon edit'><i class='material-icons'>dvr</i></a>
                              <a onclick=deleteLowongan($id) class='btn btn-simple btn-danger btn-icon remove'><i class='material-icons'>close</i></a>
                          </td>
                      </tr>
                    ";
      }

      $tabel = "<table id='datatables' class='table table-striped table-no-bordered table-hover' cellspacing='0' width='100%' style='width:100%'>
          <thead>
              <tr>
                  <th style='width: 380px!important;'>Posisi</th>
                  <th>Pendidikan</th>
                  <th>Salary</th>
                  <th>Jam Kerja</th>
                  <th>Pengalaman</th>
                  <th class='disabled-sorting text-right'>Actions</th>
              </tr>
          </thead>
          <tbody>
            $data
          </tbody>
      </table>";
      $content = array("tabelLowongan" => $tabel);

      echo generateAPI($cek,$err,$content);
    break;
    }

    case 'editTab':{
          $getPendidikan = sqlQuery('select * from ref_pendidikan');
          while ($dataPendidikan = sqlArray($getPendidikan)) {
              $optionPendidikan .= "<option value='".$dataPendidikan['id']."'> ".$dataPendidikan['tingkat']."</option>";
          }
          $comboPendidikan = "<select class='selectpicker' name='pendidikanLowongan[]' id='pendidikanLowongan' data-style='select-with-transition' multiple title='Pilih Pendidikan' data-size='7'>
              <option disabled> Pilih Pendidikan</option>
                  $optionPendidikan
          </select>";
          $content = "

          <form id='formLowongan'>
            <div class='row'>
              <div class='col-lg-3 col-md-6 col-sm-3'>
                  <label class='control-label'>Posisi</label>
                    ".cmbQuery("posisiLowongan","1","select id,posisi from ref_posisi","","-- POSISI --")."
              </div>
            </div>
            <div class='row'>
                <div class='col-lg-12 col-md-6 col-sm-3' id='divPendidikanLowongan'>
                    <label class='control-label'>Pendidikan</label>
                    $comboPendidikan
                </div>
            </div>
            <div class='row'>
              <div class='col-lg-5'>
                  <div class='form-group label-floating' id='divForSalaryMinimum'>
                      <label class='control-label'>Minimum</label>
                      <input type='text' id='salaryMinimum' name='salaryMinimum' class='form-control'>
                  </div>
              </div>
              <div class='col-lg-1'>
                  <div class='form-group label-floating' >
                      <center><h3> - </h3></center>
                  </div>
              </div>
              <div class='col-lg-6'>
                  <div class='form-group label-floating' id='divForSalaryMaximum'>
                      <label class='control-label'>Maximum</label>
                      <input type='text' id='salaryMaximum' name='salaryMaximum' class='form-control'>
                  </div>
              </div>
            </div>
            <div class='row'>
              <div class='col-lg-2'>
                <div class='radio'>
                    <label>
                        <input type='radio' value='PART TIME' id='partTime' name='jamKerja' checked> PART TIME
                    </label>
                </div>
              </div>
              <div class='col-lg-2'>
                <div class='radio'>
                    <label>
                        <input type='radio' value='FULL TIME' id='fullTIme' name='jamKerja'> FULL TIME
                    </label>
                </div>
              </div>
            </div>
            <div class='row'>
              <div class='col-lg-2'>
                  <div class='form-group label-floating' id='divForPengalaman'>
                      <label class='control-label'>Pengalaman (TAHUN)</label>
                      <input type='number' id='pengalamanKerja' name='pengalamanKerja' style='' class='form-control'>
                  </div>
              </div>
            </div>
            <div class='row'>
              <div class='col-lg-12'>
                  <div class='form-group label-floating' id='divForSpesifikasi'>
                      <label class='control-label'>Spesifikasi</label>
                      <textarea  id='spesifikasiLowongan' name='spesifikasiLowongan' class='form-control auto-resize'></textarea>
                  </div>
              </div>
            </div>
            <div class='row'>
              <div class='col-lg-12'>
                <label class='control-label'>Deskripsi Pekerjaan</label>
                <div class='card'>
                    <div class='card-body no-padding'>
                        <div id='summernote'>
                          <h3> Deskripsi </h3>
                        </div>
                    </div>
                </div>
              </div>
            </div>
            <div class='row'>
              <div class='col-lg-12'>
                <button type='button' class='btn btn-primary' id='buttonSubmit' onclick='saveLowongan();' data-dismiss='modal'>Simpan</button>
              </div>
            </div>
          </form>

          <link rel='stylesheet' type='text/css' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>";

          echo generateAPI($cek,$err,$content);
      break;
    }

     default:{
        ?>
        <script>
        var url = "http://"+window.location.hostname+"/api.php?page=lowonganKerja";

        </script>
        <script src="js/lowonganKerja.js"></script>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                            <div class="card">
                                <div class="card-content">
                                    <ul class="nav nav-pills nav-pills-primary">
                                        <li class="active">
                                            <a href="#dataLowongan" id='data1' data-toggle="tab" aria-expanded="true" onclick="baruLowongan();">Lowongan</a>
                                        </li>
                                        <li>
                                            <a href="#lowonganBaru" id='data2' data-toggle="tab" aria-expanded="false" onclick="baruLowongan();">Baru</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="dataLowongan">
                                            <div class="col-md-12" id='tableLowongan'>
                                              <div class="card">
                                                  <div class="card-header card-header-icon" data-background-color="purple">
                                                      <i class="material-icons">assignment</i>
                                                  </div>
                                                  <div class="card-content">
                                                      <h4 class="card-title">Data Lowongan</h4>
                                                      <div class="toolbar">
                                                          <!--        Here you can write extra buttons/actions for the toolbar              -->
                                                      </div>
                                                      <div class="material-datatables">
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
                                                      </div>
                                                  </div>
                                                  <!-- end content-->
                                              </div>
                                              <!--  end card  -->
                                          </div>
                                        </div>




                                        <div class="tab-pane" id="lowonganBaru">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <!-- end row -->
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
