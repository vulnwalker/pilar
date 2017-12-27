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


switch($tipe){

    case 'saveChating':{
      if(empty($namaChating)){
          $err = "Isi Nama Chating";
      }elseif(empty($statusPublish)){
          $err = "Pilih status publish";
      }elseif(empty($gambarChating)){
          $err = "Pilih gambar Chating";
      }
      if(empty($err)){
        $imageTitle = baseToImage($gambarChating,"images/chating/".md5($namaChating).md5(date("Y-m-d")).md5(date("H:i:s")).".jpg");
        $data = array(
                'nama' => $namaChating,
                'status' => $statusPublish,
                'gambar' => "images/chating/".md5($namaChating).md5(date("Y-m-d")).md5(date("H:i:s")).".jpg",
        );
        $query = sqlInsert("chating",$data);
        sqlQuery($query);
        $cek = $query;

      }
      $content = array("judulChating" => $judulChating);

      echo generateAPI($cek,$err,$content);
    break;
    }

    case 'saveEditChating':{
      if(empty($namaChating)){
          $err = "Isi Nama Chating";
      }elseif(empty($statusPublish)){
          $err = "Pilih status publish";
      }elseif(empty($gambarChating)){
          $err = "Pilih gambar Chating";
      }
      if(empty($err)){
        $imageTitle = baseToImage($gambarChating,"images/chating/".md5($namaChating).md5(date("Y-m-d")).md5(date("H:i:s")).".jpg");
        $data = array(
                'nama' => $namaChating,
                'status' => $statusPublish,
                'gambar' => "images/chating/".md5($namaChating).md5(date("Y-m-d")).md5(date("H:i:s")).".jpg",
        );
        $query = sqlUpdate("chating",$data,"id = '$idEdit'");
        sqlQuery($query);
        $cek = $query;
      }
      $content = array("judulChating" => $judulChating);

      echo generateAPI($cek,$err,$content);
    break;
    }

    case 'deleteChating':{
      $query = "delete from chating where id = '$id'";
      sqlQuery($query);
      $cek = $query;
      echo generateAPI($cek,$err,$content);
    break;
    }

    case 'updateChating':{
      $getData = sqlArray(sqlQuery("select * from chating where id = '$id'"));
      $type = pathinfo($getData['gambar'], PATHINFO_EXTENSION);
			$data = file_get_contents($getData['gambar']);
			$baseOfFile = 'data:image/' . $type . ';base64,' . base64_encode($data);
      $content = array("namaChating" => $getData['nama'],"statusPublish" => $getData['status'], "gambarChating" => $getData['gambar'], "baseImage" => $baseOfFile);
      echo generateAPI($cek,$err,$content);
    break;
    }

    case 'loadTable':{
      $getData = sqlQuery("select * from chating");
      while($dataChating = sqlArray($getData)){
        foreach ($dataChating as $key => $value) {
            $$key = $value;
        }

        if($status == "1"){
            $status = "PUBLISH";
        }else{
            $status = "NON PUBLISH";
        }
        $data .= "     <tr>
                          <td>$nama</td>
                          <td><img src='$gambar'  class='materialboxed' style='width:100px;height:100px;'></img> </td>
                          <td>$status</td>
                          <td class='text-right'>
                              <a onclick=updateChating($id) class='btn btn-simple btn-warning btn-icon edit'><i class='material-icons'>dvr</i></a>
                              <a onclick=deleteChating($id) class='btn btn-simple btn-danger btn-icon remove'><i class='material-icons'>close</i></a>
                          </td>
                      </tr>
                    ";
      }

      $tabel = "<table id='datatables' class='table table-striped table-no-bordered table-hover' cellspacing='0' width='100%' style='width:100%'>
          <thead>
              <tr>
                  <th>Nama</th>
                  <th>Gambar</th>
                  <th>Status</th>
                  <th class='disabled-sorting text-right'>Actions</th>
              </tr>
          </thead>
          <tbody>
            $data
          </tbody>
      </table>";
      $content = array("tabelChating" => $tabel);

      echo generateAPI($cek,$err,$content);
    break;
    }

     default:{
        ?>
        <script>
        var url = "http://"+window.location.hostname+"/api.php?page=chating";

        </script>
        <script src="js/chating.js"></script>
        <script src="https://cdn.socket.io/socket.io-1.2.0.js"></script>
        <script src="http://code.jquery.com/jquery-1.11.1.js"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
        <!-- auto refresh. I can use ajax but it's demo. -->
        <meta http-equiv="refresh" content="3" >
        <style>
        </style>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- Start Modal -->
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="row">
                                    <div class="col-md-12 text-left">
                                      <table class="table table-striped">
                                          <thead>
                                              <tr>
                                                  <th>User no.</th>
                                                  <th>Name</th>
                                                  <th>Join at</th>
                                                  <th>Status</th>
                                                  <th>Action</th>
                                              </tr>
                                          </thead>
                                          <?php
                                              $queue = json_decode(file_get_contents("http://".$_SERVER['HTTP_HOST'].":3421/customer/queue"), true);
                                          ?>
                                          <tbody>
                                              <?php if (count($queue) > 0): ?>
                                                  <?php foreach ($queue as $key => $data): ?>
                                                      <tr>
                                                          <td><?php echo $data['id']; ?></td>
                                                          <td><?php echo $data['username']; ?></td>
                                                          <td><?php echo $data['join_at']; ?></td>
                                                          <td><?php echo $data['status']; ?></td>
                                                          <td>
                                                              <?php if ($data['status'] == "new"): ?>
                                                          <a href="chat.php?username=<?php echo $_GET['username']; ?>&join=<?php echo $data['username']; ?>" target="_blank">Chat!</a>
                                                              <?php endif; ?>
                                                          </td>
                                                      </tr>
                                                  <?php endforeach; ?>
                                              <?php else: ?>
                                              <tr>
                                                  <td colspan="5">
                                                      No customer in lobby.
                                                  </td>
                                              </tr>
                                              <?php endif; ?>

                                          </tbody>
                                      </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal -->




                </div>
                <!-- end row -->
            </div>
        </div>



<?php

     break;
     }

}


?>
