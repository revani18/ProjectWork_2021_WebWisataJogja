
<div class="card mb-4">
    <div class="card-header">
        <h4>Daftar Komentar</h4>
    </div>
    <div class="card-body">
    <?php
    if (isset($_GET['tambah'])) {
        //Mengecek nilai variabel tambah 
        if ($_GET['tambah']=='berhasil'){
            echo"<div class='alert alert-success'><strong>Berhasil!</strong> komentar telah di tambahkan!</div>";
        }else if ($_GET['tambah']=='gagal'){
            echo"<div class='alert alert-danger'><strong>Gagal!</strong> komentar gagal di tambahkan!</div>";
        }    
    }
    if (isset($_GET['edit'])) {
        //Mengecek nilai variabel edit 
        if ($_GET['edit']=='berhasil'){
            echo"<div class='alert alert-success'><strong>Berhasil!</strong> komentar telah di edit!</div>";
        }else if ($_GET['edit']=='gagal'){
            echo"<div class='alert alert-danger'><strong>Gagal!</strong> komentar gagal di edit!</div>";
        }    
      }
    if (isset($_GET['hapus'])) {
        //Mengecek nilai variabel hapus 
        if ($_GET['hapus']=='berhasil'){
            echo"<div class='alert alert-success'><strong>Berhasil!</strong> komentar telah di hapus!</div>";
        }else if ($_GET['hapus']=='gagal'){
            echo"<div class='alert alert-danger'><strong>Gagal!</strong> komentar gagal di hapus!</div>";
        }    
    }
    ?>

<div class="row">
    <div class="col-md-5">
        <div class="panel panel-default">
            <div class="panel-body">
                <form class="form-inline" action="" method="POST">
                    <div class="form-group">
                    <input type="text" class="form-control" name="query" placeholder="Cari Data">
                    </div>
                    <input type="submit" class="btn btn-primary" name="cari" value="Cari">
                </form>
            </div>
        </div>
    </div>
</div>
</br>

       <!-- Tabel daftar komentar -->
       <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Artikel</th>
                    <th>Isi Komentar</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                        // include database
                        include '../config/database.php';


                        // perintah sql untuk menampilkan daftar komentar
                        $sql="select * from komentar k inner join artikel a on a.id_artikel=k.id_artikel order by id_komentar desc";
                        $hasil=mysqli_query($kon,$sql);
                        $no=0;

                        // pagination
                        $perPage = 5;

                        if(isset($_GET['page'])){
                            $page = $_GET['page'];
                        }else{
                            $page = 1;
                        }

                        if($page > 1){
                            $start = ($page * $perPage) - $perPage;
                        }else{
                            $start = 0;
                        }

                        // searching
                        error_reporting(E_ALL ^ E_WARNING || E_NOTICE);
                        if(isset($_POST ['query'])) {
                            $query = $_POST['query'];
                        }
                        
                        if ($query != '') {
                            $hasil = mysqli_query($kon, "SELECT * FROM komentar WHERE nama LIKE '%".$query."%' LIMIT ".$start."$perPage");
                        }else{
                            $hasil = mysqli_query($kon, "SELECT * FROM komentar LIMIT ".$start.",".$perPage);
                        }

                        //Menampilkan data dengan perulangan while
                        $no = $start + 1;
                        while ($data = mysqli_fetch_array($hasil)):
                
                    ?>

                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $data['nama']; ?></td>
                        <td><?php echo $data['email']; ?></td>
                        <td><?php echo $data['id_artikel']; ?></td>
                        <td><?php echo $data['isi_komentar']; ?></td>
                        <td><?php echo $data['status_komentar'] == 1 ? "<span class='text-success'>Publish</span>" : "<span class='text-danger'>Tidak Dipublish</span>"; ?> </td>
                        <td>
                            <button class="btn-edit btn btn-warning btn-circle" id_komentar="<?php echo $data['id_komentar']; ?>"  >Edit</button>
                            <button class="btn-hapus btn btn-danger btn-circle"  id_komentar="<?php echo $data['id_komentar']; ?>" >Hapus</button>
                        </td>
                    </tr>
                    <!-- bagian akhir (penutup) while -->
                    <?php endwhile; ?>
                </tbody>
            </table>

            <nav>
                <ul class="pagination justify-content-center">
            <?php
                $previous = $page - 1;
                $next = $page + 1;


                $baris = mysqli_query($kon, "SELECT * FROM komentar");
                $jmlBaris = mysqli_num_rows($baris);
                $halaman = ceil($jmlBaris/$perPage);
            ?>

            <li class="page-item">
                <a class="page-link" <?php if($page > 1){ echo "href='index.php?halaman=komentar&page=$previous'"; } ?>>Previous</a>
            </li>

            <?php
                for($i = 1; $i<=$halaman; $i++){
            ?>
            <li class="page-item"><a class="page-link" href='index.php?halaman=komentar&page=<?php echo $i ?>'><?php echo $i; ?></a></li>

            <?php
                }
            ?>

            <li class="page-item">
                <a class="page-link" <?php if($page < $halaman) { echo "href='index.php?halaman=komentar&page=$next'"; } ?>>Next</a>
            </li>
            </ul>
        </nav>
     
    </div>
</div>




<!-- Modal -->
<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        <!-- Bagian header -->
        <div class="modal-header">
            <h4 class="modal-title" id="judul"></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Bagian body -->
        <div class="modal-body">
            <div id="tampil_data">

            </div>  
        </div>
        <!-- Bagian footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

        </div>
    </div>
</div>
<script>
       
    // fungsi edit komentar
    $('.btn-edit').on('click',function(){

        var id_komentar = $(this).attr("id_komentar");
    
        $.ajax({
            url: 'komentar/edit.php',
            method: 'post',
            data: {id_komentar:id_komentar},
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Edit komentar #'+id_komentar;
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });




    // fungsi hapus komentar
    $('.btn-hapus').on('click',function(){

        var id_komentar = $(this).attr("id_komentar");

        konfirmasi=confirm("Yakin ingin menghapus?")

        if (konfirmasi){
            $.ajax({
                url: 'komentar/hapus.php',
                method: 'post',
                data: {id_komentar:id_komentar},
                success:function(data){
                    window.location.href = 'index.php?halaman=komentar&hapus=berhasil';
                }
            });
        }
});

</script>