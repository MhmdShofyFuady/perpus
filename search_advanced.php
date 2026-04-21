<?php
session_start();

// Data buku (13 data untuk demonstrasi pagination)
$buku_list = [
    ['kode' => 'B001', 'judul' => 'Belajar PHP Dasar', 'kategori' => 'Pemrograman', 'pengarang' => 'Eko Kurniawan', 'penerbit' => 'Informatika', 'tahun' => 2020, 'harga' => 85000, 'stok' => 15],
    ['kode' => 'B002', 'judul' => 'Mastering Laravel', 'kategori' => 'Pemrograman', 'pengarang' => 'Budi Santoso', 'penerbit' => 'Andi Offset', 'tahun' => 2022, 'harga' => 120000, 'stok' => 5],
    ['kode' => 'B003', 'judul' => 'Algoritma dan Struktur Data', 'kategori' => 'Pemrograman', 'pengarang' => 'Rinaldi Munir', 'penerbit' => 'Informatika', 'tahun' => 2018, 'harga' => 95000, 'stok' => 0],
    ['kode' => 'B004', 'judul' => 'Jaringan Komputer', 'kategori' => 'Teknologi', 'pengarang' => 'Ono W. Purbo', 'penerbit' => 'Elex Media', 'tahun' => 2019, 'harga' => 75000, 'stok' => 20],
    ['kode' => 'B005', 'judul' => 'Sistem Operasi Linux', 'kategori' => 'Teknologi', 'pengarang' => 'Ahmad R', 'penerbit' => 'Andi Offset', 'tahun' => 2021, 'harga' => 60000, 'stok' => 8],
    ['kode' => 'B006', 'judul' => 'Novel Laskar Pelangi', 'kategori' => 'Fiksi', 'pengarang' => 'Andrea Hirata', 'penerbit' => 'Bentang Pustaka', 'tahun' => 2005, 'harga' => 65000, 'stok' => 12],
    ['kode' => 'B007', 'judul' => 'Bumi Manusia', 'kategori' => 'Fiksi', 'pengarang' => 'Pramoedya Ananta Toer', 'penerbit' => 'Lentera Dipantara', 'tahun' => 1980, 'harga' => 110000, 'stok' => 0],
    ['kode' => 'B008', 'judul' => 'Filosofi Teras', 'kategori' => 'Pengembangan Diri', 'pengarang' => 'Henry Manampiring', 'penerbit' => 'Kompas', 'tahun' => 2018, 'harga' => 98000, 'stok' => 30],
    ['kode' => 'B009', 'judul' => 'Atomic Habits', 'kategori' => 'Pengembangan Diri', 'pengarang' => 'James Clear', 'penerbit' => 'Gramedia', 'tahun' => 2019, 'harga' => 105000, 'stok' => 25],
    ['kode' => 'B010', 'judul' => 'Dasar Desain Grafis', 'kategori' => 'Desain', 'pengarang' => 'Joko S', 'penerbit' => 'Elex Media', 'tahun' => 2020, 'harga' => 55000, 'stok' => 10],
    ['kode' => 'B011', 'judul' => 'UI/UX Design for Beginner', 'kategori' => 'Desain', 'pengarang' => 'Siska W', 'penerbit' => 'Informatika', 'tahun' => 2023, 'harga' => 150000, 'stok' => 4],
    ['kode' => 'B012', 'judul' => 'Data Science dengan Python', 'kategori' => 'Pemrograman', 'pengarang' => 'Dwi M', 'penerbit' => 'Gramedia', 'tahun' => 2023, 'harga' => 135000, 'stok' => 0],
    ['kode' => 'B013', 'judul' => 'Pemrograman Web dengan Node.js', 'kategori' => 'Pemrograman', 'pengarang' => 'Budi Santoso', 'penerbit' => 'Andi Offset', 'tahun' => 2021, 'harga' => 110000, 'stok' => 15],
];

// Kategori unik untuk dropdown
$kategori_list = array_unique(array_column($buku_list, 'kategori'));
sort($kategori_list);

// Ambil parameter GET
$keyword = $_GET['keyword'] ?? '';
$kategori = $_GET['kategori'] ?? '';
$min_harga = $_GET['min_harga'] ?? '';
$max_harga = $_GET['max_harga'] ?? '';
$tahun = $_GET['tahun'] ?? '';
$status = $_GET['status'] ?? 'semua';
$sort = $_GET['sort'] ?? 'judul';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Validasi
$errors = [];
$current_year = date('Y');

if (!empty($min_harga) && !empty($max_harga)) {
    if ($min_harga > $max_harga) {
        $errors[] = "Harga minimum tidak boleh lebih besar dari harga maksimum.";
    }
}

if (!empty($tahun)) {
    if ($tahun < 1900 || $tahun > $current_year) {
        $errors[] = "Tahun harus valid (1900 - $current_year).";
    }
}

// Simpan pencarian ke session (recent searches bonus) jika ada filter aktif
if (!empty($_GET) && !isset($_GET['export']) && !isset($_GET['page']) && empty($errors)) {
    $search_str = [];
    if(!empty($keyword)) $search_str[] = "Keyword: '$keyword'";
    if(!empty($kategori)) $search_str[] = "Kat: '$kategori'";
    if(!empty($min_harga)) $search_str[] = "Min: $min_harga";
    if(!empty($max_harga)) $search_str[] = "Max: $max_harga";
    
    $query_string = $_SERVER['QUERY_STRING'];
    if(!empty($search_str) || !empty($_GET['status']) && $_GET['status'] != 'semua' || !empty($tahun)) {
        $label = !empty($search_str) ? implode(", ", $search_str) : "Pencarian Kustom";
        
        if(!isset($_SESSION['recent_searches'])) $_SESSION['recent_searches'] = [];
        
        // Hapus duplikat
        foreach($_SESSION['recent_searches'] as $k => $rs) {
            if ($rs['query'] === $query_string) {
                unset($_SESSION['recent_searches'][$k]);
            }
        }
        
        // Tambahkan ke paling atas
        array_unshift($_SESSION['recent_searches'], ['label' => $label, 'query' => $query_string, 'time' => date('H:i')]);
        
        // Batasi maksimal 5 pencarian terakhir
        if(count($_SESSION['recent_searches']) > 5) {
            array_pop($_SESSION['recent_searches']);
        }
    }
}

// Filter data
$hasil = [];
if (empty($errors)) {
    foreach ($buku_list as $buku) {
        $match = true;

        // Filter Keyword
        if (!empty($keyword)) {
            $keyword_lower = strtolower($keyword);
            $judul_lower = strtolower($buku['judul']);
            $pengarang_lower = strtolower($buku['pengarang']);
            if (strpos($judul_lower, $keyword_lower) === false && strpos($pengarang_lower, $keyword_lower) === false) {
                $match = false;
            }
        }

        // Filter Kategori
        if (!empty($kategori) && $buku['kategori'] != $kategori) {
            $match = false;
        }

        // Filter Harga Min
        if ($min_harga !== '' && $buku['harga'] < $min_harga) {
            $match = false;
        }

        // Filter Harga Max
        if ($max_harga !== '' && $buku['harga'] > $max_harga) {
            $match = false;
        }

        // Filter Tahun
        if (!empty($tahun) && $buku['tahun'] != $tahun) {
            $match = false;
        }

        // Filter Status Ketersediaan
        if ($status == 'tersedia' && $buku['stok'] <= 0) {
            $match = false;
        } else if ($status == 'habis' && $buku['stok'] > 0) {
            $match = false;
        }

        if ($match) {
            $hasil[] = $buku;
        }
    }
}

// Sorting
if (!empty($hasil)) {
    usort($hasil, function($a, $b) use ($sort) {
        if ($sort == 'judul') {
            return strcmp($a['judul'], $b['judul']);
        } else if ($sort == 'harga_asc') {
            return $a['harga'] <=> $b['harga'];
        } else if ($sort == 'harga_desc') {
            return $b['harga'] <=> $a['harga'];
        } else if ($sort == 'tahun_desc') {
            return $b['tahun'] <=> $a['tahun'];
        } else if ($sort == 'tahun_asc') {
            return $a['tahun'] <=> $b['tahun'];
        }
        return 0;
    });
}

// Export CSV (Bonus)
if (isset($_GET['export']) && $_GET['export'] == 'csv') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=hasil_pencarian_buku.csv');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Kode', 'Judul', 'Kategori', 'Pengarang', 'Penerbit', 'Tahun', 'Harga', 'Stok']);
    foreach ($hasil as $row) {
        fputcsv($output, $row);
    }
    fclose($output);
    exit;
}

// Pagination (10 per page)
$items_per_page = 10;
$total_items = count($hasil);
$total_pages = ceil($total_items / $items_per_page);
if ($page < 1) $page = 1;
if ($page > $total_pages && $total_pages > 0) $page = $total_pages;

$offset = ($page - 1) * $items_per_page;
$paginated_hasil = array_slice($hasil, $offset, $items_per_page);

// Helper function untuk highlight (Bonus)
function highlight_keyword($text, $keyword) {
    if (empty($keyword)) return htmlspecialchars($text);
    $escaped_text = htmlspecialchars($text);
    $preg_keyword = preg_quote($keyword, '/');
    return preg_replace("/($preg_keyword)/i", "<mark class='bg-warning p-0'>$1</mark>", $escaped_text);
}

// Fungsi untuk membuat URL dengan parameter yang dipertahankan
function build_url($params = []) {
    $current = $_GET;
    unset($current['export']); // Jangan bawa flag export di navigasi halaman
    foreach ($params as $key => $value) {
        $current[$key] = $value;
    }
    return '?' . http_build_query($current);
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian Buku Lanjutan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; }
    </style>
</head>
<body>
    
    <div class="container mt-5 mb-5">
        <h2 class="mb-4 text-primary"><i class="bi bi-search"></i> Pencarian Buku Lanjutan</h2>
        
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger shadow-sm">
                <ul class="mb-0">
                    <?php foreach ($errors as $err): ?>
                        <li><i class="bi bi-exclamation-triangle-fill me-2"></i><?= htmlspecialchars($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="row">
            <!-- Sidebar / Form Filter -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-0 border-top border-primary border-4">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0 fw-bold"><i class="bi bi-funnel text-primary"></i> Filter Pencarian</h5>
                    </div>
                    <div class="card-body bg-light">
                        <form method="GET" action="search_advanced.php">
                            <!-- Keyword -->
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">Keyword (Judul/Pengarang)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="bi bi-type"></i></span>
                                    <input type="text" name="keyword" class="form-control" placeholder="Masukkan kata kunci..." value="<?= htmlspecialchars($keyword) ?>">
                                </div>
                            </div>
                            
                            <!-- Kategori -->
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">Kategori</label>
                                <select name="kategori" class="form-select">
                                    <option value="">-- Semua Kategori --</option>
                                    <?php foreach ($kategori_list as $kat): ?>
                                        <option value="<?= htmlspecialchars($kat) ?>" <?= $kategori == $kat ? 'selected' : '' ?>><?= htmlspecialchars($kat) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <!-- Range Harga -->
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">Range Harga (Rp)</label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="number" name="min_harga" class="form-control" placeholder="Min" value="<?= htmlspecialchars($min_harga) ?>" min="0">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" name="max_harga" class="form-control" placeholder="Max" value="<?= htmlspecialchars($max_harga) ?>" min="0">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Tahun Terbit -->
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">Tahun Terbit</label>
                                <input type="number" name="tahun" class="form-control" placeholder="Contoh: 2020" value="<?= htmlspecialchars($tahun) ?>" min="1900" max="<?= $current_year ?>">
                            </div>
                            
                            <!-- Status -->
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">Status Ketersediaan</label>
                                <div class="d-flex gap-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status_semua" value="semua" <?= $status == 'semua' ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="status_semua">Semua</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status_tersedia" value="tersedia" <?= $status == 'tersedia' ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="status_tersedia">Tersedia</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status_habis" value="habis" <?= $status == 'habis' ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="status_habis">Habis</label>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Sort Options -->
                            <div class="mb-4">
                                <label class="form-label fw-bold small text-muted">Urutkan Berdasarkan</label>
                                <select name="sort" class="form-select">
                                    <option value="judul" <?= $sort == 'judul' ? 'selected' : '' ?>>Judul (A-Z)</option>
                                    <option value="harga_asc" <?= $sort == 'harga_asc' ? 'selected' : '' ?>>Harga (Termurah)</option>
                                    <option value="harga_desc" <?= $sort == 'harga_desc' ? 'selected' : '' ?>>Harga (Termahal)</option>
                                    <option value="tahun_desc" <?= $sort == 'tahun_desc' ? 'selected' : '' ?>>Tahun (Terbaru)</option>
                                    <option value="tahun_asc" <?= $sort == 'tahun_asc' ? 'selected' : '' ?>>Tahun (Terlama)</option>
                                </select>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Terapkan Filter</button>
                                <a href="search_advanced.php" class="btn btn-outline-secondary">Reset Pencarian</a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Recent Searches Widget (Bonus) -->
                <?php if (isset($_SESSION['recent_searches']) && count($_SESSION['recent_searches']) > 0): ?>
                <div class="card shadow-sm mt-3 border-0">
                    <div class="card-header bg-info text-white">
                        <h6 class="card-title mb-0"><i class="bi bi-clock-history"></i> Pencarian Terakhir</h6>
                    </div>
                    <ul class="list-group list-group-flush small">
                        <?php foreach ($_SESSION['recent_searches'] as $rs): ?>
                            <a href="search_advanced.php?<?= htmlspecialchars($rs['query']) ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2">
                                <span class="text-truncate text-secondary fw-semibold" style="max-width: 200px;" title="<?= htmlspecialchars($rs['label']) ?>">
                                    <?= htmlspecialchars($rs['label']) ?>
                                </span>
                                <span class="badge bg-light text-dark border rounded-pill"><?= $rs['time'] ?></span>
                            </a>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Hasil Pencarian -->
            <div class="col-lg-8">
                <div class="card shadow-sm mb-3 border-0">
                    <div class="card-body d-flex justify-content-between align-items-center flex-wrap py-3">
                        <h5 class="mb-0 text-success fw-bold"><i class="bi bi-check-circle-fill me-2"></i>Menemukan <?= $total_items ?> buku</h5>
                        
                        <?php if ($total_items > 0 && empty($errors)): ?>
                            <a href="<?= build_url(['export' => 'csv']) ?>" class="btn btn-success btn-sm mt-2 mt-md-0 shadow-sm">
                                <i class="bi bi-file-earmark-spreadsheet"></i> Export CSV
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="card shadow-sm border-0">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0 align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="px-3 py-3">Kode</th>
                                        <th class="py-3">Judul</th>
                                        <th class="py-3">Kategori</th>
                                        <th class="py-3">Pengarang</th>
                                        <th class="py-3">Thn</th>
                                        <th class="py-3">Harga</th>
                                        <th class="text-center py-3">Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($errors)): ?>
                                        <tr><td colspan="7" class="text-center py-5 text-danger"><i class="bi bi-exclamation-triangle fs-1 d-block mb-3"></i> Terdapat kesalahan pada filter.</td></tr>
                                    <?php elseif ($total_items == 0): ?>
                                        <tr><td colspan="7" class="text-center py-5 text-muted"><i class="bi bi-inbox fs-1 d-block mb-3"></i>Tidak ada buku yang sesuai kriteria.</td></tr>
                                    <?php else: ?>
                                        <?php foreach ($paginated_hasil as $buku): ?>
                                        <tr>
                                            <td class="px-3 fw-bold text-secondary"><?= $buku['kode'] ?></td>
                                            <td class="fw-semibold text-primary"><?= highlight_keyword($buku['judul'], $keyword) ?></td>
                                            <td><span class="badge bg-secondary bg-opacity-10 text-secondary border px-2"><?= htmlspecialchars($buku['kategori']) ?></span></td>
                                            <td><?= highlight_keyword($buku['pengarang'], $keyword) ?></td>
                                            <td><?= $buku['tahun'] ?></td>
                                            <td>Rp <?= number_format($buku['harga'], 0, ',', '.') ?></td>
                                            <td class="text-center">
                                                <?php if ($buku['stok'] > 0): ?>
                                                    <span class="badge bg-success rounded-pill px-2 py-1"><?= $buku['stok'] ?></span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Habis</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                <nav class="mt-4">
                    <ul class="pagination justify-content-center shadow-sm">
                        <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="<?= build_url(['page' => $page - 1]) ?>">Sebelumnya</a>
                        </li>
                        
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                                <a class="page-link" href="<?= build_url(['page' => $i]) ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        
                        <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
                            <a class="page-link" href="<?= build_url(['page' => $page + 1]) ?>">Selanjutnya</a>
                        </li>
                    </ul>
                </nav>
                <?php endif; ?>
                
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
