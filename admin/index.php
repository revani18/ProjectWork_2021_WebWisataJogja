<?php 
  session_start();
  if (!$_SESSION["id_pengguna"]){
        header('Location:../index.php?halaman=login&pesan=login_dulu');
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Halaman Administrator</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <!-- Brand -->
    <img src="jogja.png" alt="logojogja">
    <a class="navbar-brand" href="../index.php">Home</a>

    <!-- Toggler/collapsibe Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar links -->
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav  ml-auto">
        <li class="text-light"><?php echo $_SESSION["nama_pengguna"]; ?> </li>
        </ul>
    </div>
   
</nav>
<br>
<div class="text-center">
<?php 
if(isset($_GET['halaman']) && !isset($_GET['kategori'])){
    $halaman = $_GET['halaman'];
   echo "<h1>".ucwords($halaman)."</h1>";
}

if(isset($_GET['halaman']) &&  isset($_GET['kategori'])){

    include '../config/database.php';
    $ambil_kategori = mysqli_query ($kon,"select * from kategori where id_kategori='".$_GET['kategori']."' limit 1");
    $row = mysqli_fetch_assoc($ambil_kategori); 
    $kategori = $row['nama_kategori'];
    $halaman = $_GET['halaman'];
   echo "<h1>".ucwords($halaman)." ".ucwords($kategori)."</h1>";
}
?>
</div>
<br>
<div class="container">
    <div class="row">
        <div class="col-sm-2">
            <div class="list-group">
                <a href="index.php?halaman=kategori" class="list-group-item list-group-item-action">Kategori Artikel</a>
                <a href="index.php?halaman=komentar" class="list-group-item list-group-item-action">Komentar</a>
                <a href="index.php?halaman=admin" class="list-group-item list-group-item-action">Admin</a>
                <a href="logout.php" class="list-group-item list-group-item-action">Logout</a>
            </div>
        </div> 
        <div class="col-sm-10">
        <?php 
            if(isset($_GET['halaman'])){
                $halaman = $_GET['halaman'];
                switch ($halaman) {
                    case 'kategori':
                        include "artikel/kategori.php";
                        break;
                     case 'artikel':
                        include "artikel/index.php";
                        break;
                    case 'komentar':
                        include "komentar/index.php";
                        break;
                    case 'admin':
                        include "admin/index.php";
                        break;
                    default:
                    echo "<center><h3>Maaf. Halaman tidak di temukan !</h3></center>";
                    break;
                }
            }else {
                include "index.php";
            }
        ?>
        </div>
    </div>
    <br>
</div>

</body> 
</html>