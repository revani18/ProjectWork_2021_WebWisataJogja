
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tempat Wisata di Yogyakarta</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>



</head>
<body>
<nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <!-- Brand -->
    <img src="logo/jogja.png" alt="logojogja">
    <a class="navbar-brand" href="index.php?halaman=home">Home</a>

    <!-- Toggler/collapsibe Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar links -->
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
        <?php
         
            include 'config/database.php';
            $sql="select * from kategori";
            $hasil=mysqli_query($kon,$sql);
            while ($data = mysqli_fetch_array($hasil)):
        ?>
            <li class="nav-item">
                <a class="nav-link" href="index.php?halaman=home&kategori=<?php echo $data['id_kategori']; ?>"><?php echo $data['nama_kategori'];?></a>
            </li>
            <?php endwhile; ?>
        </ul>
        <ul class="navbar-nav  ml-auto">
            <?php 
                session_start();
                if (isset($_SESSION["id_pengguna"])) {
                        echo " <li><a class='nav-link' href='admin/index.php?halaman=kategori'>Halaman Admin</a></li>";
                }else {
                    echo " <li><a class='nav-link' href='index.php?halaman=login'><span class='fas fa-log-in'></span> Login</a></li>";
                }
            ?>
        </ul>
    </div>
   
</nav>

<div class="text-center"><br>

<?php
    $judul="Tempat Wisata di Jogja";

    include 'config/database.php';
    if (isset($_GET['id'])) {
        $sql="select * from artikel where status=1 and id_artikel=".$_GET['id']."";
        $hasil=mysqli_query($kon,$sql);
        $data = mysqli_fetch_array($hasil);
        $judul=$data['judul_artikel'];  
    }else if (isset($_GET['kategori'])){
        $sql="select * from kategori where id_kategori=".$_GET['kategori']."";
        $hasil=mysqli_query($kon,$sql);
        $data = mysqli_fetch_array($hasil);
        $judul=$data['nama_kategori'];  
    }

    

?>
    <h1><?php echo $judul;?></h1>

</div>

<div class="container"><br>
<?php 
    if(isset($_GET['halaman'])){
        $halaman = $_GET['halaman'];
        switch ($halaman) {
            case 'home':
                include "home.php";
                break;
            case 'artikel':
                include "artikel.php";
                break;
            case 'login':
                include "login.php";
                break;
            default:
            echo "<center><h3>Maaf. Halaman tidak di temukan !</h3></center>";
            break;
        }
    }else {
        include "home.php";
    }
?>
</div>
<br>

<div class="jumbotron text-center" style="margin-bottom:0">
            <h4>Website Tempat Wisata di Jogja</h4>
            <p>Daerah Istimewa Yogyakarta</p>
            <p> 
                Telepon : (0274) 1234XXX </br>
                Email : info@wisatajogja.com
            </p>
            <p>Copyright © 2021 Jogja</p>

<div class=scroll-top style="float: right;">

    <img src=gambar/top.png class="wps-ic-no-lazy "/>
</div> 
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-118274299-1"></script> 
<script src=https://cdn.alodiatour.com/wp-content/cache/jch-optimize/js/185a2e20b8629793ee6c4aaa0c718ba5.js defer></script> 
<script src='https://cdn.alodiatour.com/minify:false/asset:https://www.alodiatour.com/wp-content/plugins/flying-pages/flying-pages.min.js?icv=1625236559' id=flying-pages-js defer></script> 
</body> 
</html>