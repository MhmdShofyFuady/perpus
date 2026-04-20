<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info Buku - Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5 mb-5">

    <h1 class="mb-2">📚 Informasi Buku</h1>
    <p class="text-muted mb-4">Katalog koleksi buku perpustakaan</p>

    <?php
    // ───────────────────────────────
    // BUKU 1 (buku asli dari info_buku.php)
    // ───────────────────────────────
    $judul1      = "Pemrograman Web dengan PHP";
    $pengarang1  = "Budi Raharjo";
    $penerbit1   = "Informatika";
    $tahun1      = 2023;
    $harga1      = 85000;
    $stok1       = 15;
    $isbn1       = "978-602-1234-56-7";
    $kategori1   = "Programming";
    $bahasa1     = "Indonesia";
    $halaman1    = 450;
    $berat1      = 620;   // gram

    // ───────────────────────────────
    // BUKU 2
    // ───────────────────────────────
    $judul2      = "MySQL Database Administration";
    $pengarang2  = "Baron Schwartz";
    $penerbit2   = "O'Reilly Media";
    $tahun2      = 2022;
    $harga2      = 125000;
    $stok2       = 8;
    $isbn2       = "978-1-491-90215-5";
    $kategori2   = "Database";
    $bahasa2     = "Inggris";
    $halaman2    = 832;
    $berat2      = 1100;  // gram

    // ───────────────────────────────
    // BUKU 3
    // ───────────────────────────────
    $judul3      = "CSS & Web Design Mastery";
    $pengarang3  = "Jon Duckett";
    $penerbit3   = "Wiley";
    $tahun3      = 2023;
    $harga3      = 110000;
    $stok3       = 12;
    $isbn3       = "978-1-118-00818-8";
    $kategori3   = "Web Design";
    $bahasa3     = "Inggris";
    $halaman3    = 490;
    $berat3      = 750;   // gram

    // ───────────────────────────────
    // BUKU 4
    // ───────────────────────────────
    $judul4      = "Pemrograman Python untuk Pemula";
    $pengarang4  = "Andi Wijaya";
    $penerbit4   = "Elex Media Komputindo";
    $tahun4      = 2024;
    $harga4      = 95000;
    $stok4       = 20;
    $isbn4       = "978-602-0443-11-3";
    $kategori4   = "Programming";
    $bahasa4     = "Indonesia";
    $halaman4    = 380;
    $berat4      = 530;   // gram

    // ───────────────────────────────
    // Helper: warna badge per kategori
    // ───────────────────────────────
    function badge_kategori($kategori) {
        switch ($kategori) {
            case "Programming": return "bg-primary";
            case "Database":    return "bg-danger";
            case "Web Design":  return "bg-success";
            default:            return "bg-secondary";
        }
    }
    ?>

    <div class="row g-4">

        <!-- ── CARD BUKU 1 ── -->
        <div class="col-md-6">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><?php echo $judul1; ?></h5>
                    <span class="badge <?php echo badge_kategori($kategori1); ?> border border-white">
                        <?php echo $kategori1; ?>
                    </span>
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-sm mb-0">
                        <tr><th width="160">Pengarang</th>  <td>: <?php echo $pengarang1; ?></td></tr>
                        <tr><th>Penerbit</th>               <td>: <?php echo $penerbit1; ?></td></tr>
                        <tr><th>Tahun Terbit</th>           <td>: <?php echo $tahun1; ?></td></tr>
                        <tr><th>ISBN</th>                   <td>: <?php echo $isbn1; ?></td></tr>
                        <tr><th>Harga</th>                  <td>: Rp <?php echo number_format($harga1, 0, ',', '.'); ?></td></tr>
                        <tr><th>Stok</th>                   <td>: <?php echo $stok1; ?> buku</td></tr>
                        <tr><th>Kategori</th>               <td>: <span class="badge <?php echo badge_kategori($kategori1); ?>"><?php echo $kategori1; ?></span></td></tr>
                        <tr><th>Bahasa</th>                 <td>: <?php echo $bahasa1; ?></td></tr>
                        <tr><th>Jumlah Halaman</th>         <td>: <?php echo $halaman1; ?> halaman</td></tr>
                        <tr><th>Berat Buku</th>             <td>: <?php echo $berat1; ?> gram</td></tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- ── CARD BUKU 2 ── -->
        <div class="col-md-6">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><?php echo $judul2; ?></h5>
                    <span class="badge <?php echo badge_kategori($kategori2); ?> border border-white">
                        <?php echo $kategori2; ?>
                    </span>
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-sm mb-0">
                        <tr><th width="160">Pengarang</th>  <td>: <?php echo $pengarang2; ?></td></tr>
                        <tr><th>Penerbit</th>               <td>: <?php echo $penerbit2; ?></td></tr>
                        <tr><th>Tahun Terbit</th>           <td>: <?php echo $tahun2; ?></td></tr>
                        <tr><th>ISBN</th>                   <td>: <?php echo $isbn2; ?></td></tr>
                        <tr><th>Harga</th>                  <td>: Rp <?php echo number_format($harga2, 0, ',', '.'); ?></td></tr>
                        <tr><th>Stok</th>                   <td>: <?php echo $stok2; ?> buku</td></tr>
                        <tr><th>Kategori</th>               <td>: <span class="badge <?php echo badge_kategori($kategori2); ?>"><?php echo $kategori2; ?></span></td></tr>
                        <tr><th>Bahasa</th>                 <td>: <?php echo $bahasa2; ?></td></tr>
                        <tr><th>Jumlah Halaman</th>         <td>: <?php echo $halaman2; ?> halaman</td></tr>
                        <tr><th>Berat Buku</th>             <td>: <?php echo $berat2; ?> gram</td></tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- ── CARD BUKU 3 ── -->
        <div class="col-md-6">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><?php echo $judul3; ?></h5>
                    <span class="badge <?php echo badge_kategori($kategori3); ?> border border-white">
                        <?php echo $kategori3; ?>
                    </span>
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-sm mb-0">
                        <tr><th width="160">Pengarang</th>  <td>: <?php echo $pengarang3; ?></td></tr>
                        <tr><th>Penerbit</th>               <td>: <?php echo $penerbit3; ?></td></tr>
                        <tr><th>Tahun Terbit</th>           <td>: <?php echo $tahun3; ?></td></tr>
                        <tr><th>ISBN</th>                   <td>: <?php echo $isbn3; ?></td></tr>
                        <tr><th>Harga</th>                  <td>: Rp <?php echo number_format($harga3, 0, ',', '.'); ?></td></tr>
                        <tr><th>Stok</th>                   <td>: <?php echo $stok3; ?> buku</td></tr>
                        <tr><th>Kategori</th>               <td>: <span class="badge <?php echo badge_kategori($kategori3); ?>"><?php echo $kategori3; ?></span></td></tr>
                        <tr><th>Bahasa</th>                 <td>: <?php echo $bahasa3; ?></td></tr>
                        <tr><th>Jumlah Halaman</th>         <td>: <?php echo $halaman3; ?> halaman</td></tr>
                        <tr><th>Berat Buku</th>             <td>: <?php echo $berat3; ?> gram</td></tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- ── CARD BUKU 4 ── -->
        <div class="col-md-6">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><?php echo $judul4; ?></h5>
                    <span class="badge <?php echo badge_kategori($kategori4); ?> border border-white">
                        <?php echo $kategori4; ?>
                    </span>
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-sm mb-0">
                        <tr><th width="160">Pengarang</th>  <td>: <?php echo $pengarang4; ?></td></tr>
                        <tr><th>Penerbit</th>               <td>: <?php echo $penerbit4; ?></td></tr>
                        <tr><th>Tahun Terbit</th>           <td>: <?php echo $tahun4; ?></td></tr>
                        <tr><th>ISBN</th>                   <td>: <?php echo $isbn4; ?></td></tr>
                        <tr><th>Harga</th>                  <td>: Rp <?php echo number_format($harga4, 0, ',', '.'); ?></td></tr>
                        <tr><th>Stok</th>                   <td>: <?php echo $stok4; ?> buku</td></tr>
                        <tr><th>Kategori</th>               <td>: <span class="badge <?php echo badge_kategori($kategori4); ?>"><?php echo $kategori4; ?></span></td></tr>
                        <tr><th>Bahasa</th>                 <td>: <?php echo $bahasa4; ?></td></tr>
                        <tr><th>Jumlah Halaman</th>         <td>: <?php echo $halaman4; ?> halaman</td></tr>
                        <tr><th>Berat Buku</th>             <td>: <?php echo $berat4; ?> gram</td></tr>
                    </table>
                </div>
            </div>
        </div>

    </div><!-- /row -->
</div><!-- /container -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>     