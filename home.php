<div class="row">
<?php
         
    include 'config/database.php';
    if (isset($_GET['kategori'])) {
        $sql="select * from artikel where status=1 and id_kategori=".$_GET['kategori']." order by id_artikel desc";
    }else {
        $sql="select * from artikel where status=1 order by id_artikel desc";
    }

    
    $hasil=mysqli_query($kon,$sql);
    $jumlah = mysqli_num_rows($hasil);
    if ($jumlah>0){
        while ($data = mysqli_fetch_array($hasil)):
    ?>
        <div class="col-sm-3">
            <div class="thumbnail">
                <a href="index.php?halaman=artikel&id=<?php echo $data['id_artikel'];?>"><img src="admin/artikel/gambar/<?php echo $data['gambar'];?>" width="100%" alt="Cinque Terre"></a>
                <div class="caption">
                    <a class="text-dark text-center" href="index.php?halaman=artikel&id=<?php echo $data['id_artikel'];?>"><h5><?php echo $data['judul_artikel'];?></h5></a>
                </div>
            </div>
        </div>
        <?php 
        endwhile;
    }else {
        echo "<div class='alert alert-warning'> Tidak ada artikel pada kategori ini.</div>";
    };
     ?>
</div>