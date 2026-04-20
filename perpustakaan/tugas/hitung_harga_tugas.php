<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Perhitungan Diskon - Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5 mb-5">

    <h1 class="mb-1">🛒 Sistem Perhitungan Diskon Bertingkat</h1>
    <p class="text-muted mb-4">Perpustakaan Universitas ABC</p>

    <?php
    // ─────────────────────────────────────────
    // 1. DATA INPUT
    // ─────────────────────────────────────────
    $nama_pembeli = "Budi Santoso";
    $judul_buku   = "Laravel Advanced";
    $harga_satuan = 150000;
    $jumlah_beli  = 4;
    $is_member    = true; // true = member, false = non-member

    // ─────────────────────────────────────────
    // 2. SUBTOTAL
    // ─────────────────────────────────────────
    $subtotal = $harga_satuan * $jumlah_beli;

    // ─────────────────────────────────────────
    // 3. DISKON BERTINGKAT BERDASARKAN JUMLAH
    // ─────────────────────────────────────────
    if ($jumlah_beli >= 1 && $jumlah_beli <= 2) {
        $persentase_diskon = 0;
        $label_diskon      = "Tidak ada diskon";
    } elseif ($jumlah_beli >= 3 && $jumlah_beli <= 5) {
        $persentase_diskon = 10;
        $label_diskon      = "Beli 3–5 buku";
    } elseif ($jumlah_beli >= 6 && $jumlah_beli <= 10) {
        $persentase_diskon = 15;
        $label_diskon      = "Beli 6–10 buku";
    } else {
        // lebih dari 10
        $persentase_diskon = 20;
        $label_diskon      = "Beli > 10 buku";
    }

    // ─────────────────────────────────────────
    // 4. HITUNG DISKON JUMLAH
    // ─────────────────────────────────────────
    $diskon              = $subtotal * ($persentase_diskon / 100);
    $total_setelah_diskon1 = $subtotal - $diskon;

    // ─────────────────────────────────────────
    // 5. DISKON MEMBER (tambahan 5%)
    // ─────────────────────────────────────────
    $persentase_member = 0;
    $diskon_member     = 0;

    if ($is_member) {
        $persentase_member = 5;
        $diskon_member     = $total_setelah_diskon1 * ($persentase_member / 100);
    }

    // ─────────────────────────────────────────
    // 6. TOTAL SETELAH SEMUA DISKON
    // ─────────────────────────────────────────
    $total_setelah_diskon = $total_setelah_diskon1 - $diskon_member;

    // ─────────────────────────────────────────
    // 7. PPN 11%
    // ─────────────────────────────────────────
    $ppn = $total_setelah_diskon * 0.11;

    // ─────────────────────────────────────────
    // 8. TOTAL AKHIR
    // ─────────────────────────────────────────
    $total_akhir = $total_setelah_diskon + $ppn;

    // ─────────────────────────────────────────
    // 9. TOTAL PENGHEMATAN (semua diskon tanpa PPN)
    // ─────────────────────────────────────────
    $total_hemat = $diskon + $diskon_member;

    // Helper: format Rupiah
    function rp($angka) {
        return "Rp " . number_format($angka, 0, ',', '.');
    }
    ?>

    <div class="row g-4">

        <!-- ═══════════════════════════════════
             KOLOM KIRI — Detail Transaksi
        ════════════════════════════════════ -->
        <div class="col-md-8">

            <!-- Identitas Pembeli -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">👤 Identitas Pembeli</h5>
                    <?php if ($is_member): ?>
                        <span class="badge bg-warning text-dark">⭐ MEMBER</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">Non-Member</span>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <th width="200">Nama Pembeli</th>
                            <td>: <?php echo $nama_pembeli; ?></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>:
                                <?php if ($is_member): ?>
                                    <span class="badge bg-warning text-dark">Member</span>
                                    <small class="text-muted ms-1">(+5% diskon ekstra)</small>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Non-Member</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Rincian Perhitungan -->
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">🧾 Rincian Perhitungan</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">

                        <!-- Detail Buku -->
                        <tr class="table-light">
                            <th colspan="2" class="ps-3 text-muted small text-uppercase">Detail Buku</th>
                        </tr>
                        <tr>
                            <th width="260" class="ps-3">Judul Buku</th>
                            <td><?php echo $judul_buku; ?></td>
                        </tr>
                        <tr>
                            <th class="ps-3">Harga Satuan</th>
                            <td><?php echo rp($harga_satuan); ?></td>
                        </tr>
                        <tr>
                            <th class="ps-3">Jumlah Beli</th>
                            <td><?php echo $jumlah_beli; ?> buku</td>
                        </tr>

                        <!-- Subtotal -->
                        <tr class="table-secondary">
                            <th class="ps-3">Subtotal</th>
                            <td><strong><?php echo rp($subtotal); ?></strong></td>
                        </tr>

                        <!-- Diskon Jumlah -->
                        <tr class="table-light">
                            <th colspan="2" class="ps-3 text-muted small text-uppercase">Potongan Harga</th>
                        </tr>
                        <tr class="text-success">
                            <th class="ps-3">
                                Diskon Jumlah
                                <span class="badge bg-success ms-1"><?php echo $persentase_diskon; ?>%</span>
                                <br><small class="text-muted fw-normal"><?php echo $label_diskon; ?></small>
                            </th>
                            <td>
                                <?php if ($persentase_diskon > 0): ?>
                                    <span class="text-success fw-semibold">- <?php echo rp($diskon); ?></span>
                                <?php else: ?>
                                    <span class="text-muted">Tidak ada</span>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <!-- Diskon Member -->
                        <tr class="text-warning">
                            <th class="ps-3">
                                Diskon Member
                                <?php if ($is_member): ?>
                                    <span class="badge bg-warning text-dark ms-1">5%</span>
                                    <br><small class="text-muted fw-normal">dari <?php echo rp($total_setelah_diskon1); ?></small>
                                <?php endif; ?>
                            </th>
                            <td>
                                <?php if ($is_member): ?>
                                    <span class="text-warning fw-semibold">- <?php echo rp($diskon_member); ?></span>
                                <?php else: ?>
                                    <span class="text-muted">Tidak ada (Non-Member)</span>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <!-- Total Setelah Diskon -->
                        <tr class="table-secondary">
                            <th class="ps-3">Total Setelah Diskon</th>
                            <td><strong><?php echo rp($total_setelah_diskon); ?></strong></td>
                        </tr>

                        <!-- PPN -->
                        <tr>
                            <th class="ps-3">
                                PPN
                                <span class="badge bg-secondary ms-1">11%</span>
                            </th>
                            <td>+ <?php echo rp($ppn); ?></td>
                        </tr>

                        <!-- TOTAL AKHIR -->
                        <tr class="table-primary">
                            <th class="ps-3 fs-5">TOTAL AKHIR</th>
                            <td class="fs-5 fw-bold text-primary"><?php echo rp($total_akhir); ?></td>
                        </tr>

                    </table>
                </div>
            </div>

            <!-- Alert diskon -->
            <?php if ($total_hemat > 0): ?>
            <div class="alert alert-success mt-3">
                🎉 <strong>Selamat, <?php echo $nama_pembeli; ?>!</strong>
                Anda menghemat <strong><?php echo rp($total_hemat); ?></strong>
                <?php if ($is_member): ?>
                    (termasuk diskon member 5%)
                <?php endif; ?>
            </div>
            <?php else: ?>
            <div class="alert alert-info mt-3">
                💡 Beli minimal 3 buku untuk mendapatkan diskon!
            </div>
            <?php endif; ?>

        </div>

        <!-- ═══════════════════════════════════
             KOLOM KANAN — Ringkasan & Info
        ════════════════════════════════════ -->
        <div class="col-md-4">

            <!-- Ringkasan Hemat -->
            <div class="card border-success shadow-sm mb-3">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0">💰 Total Penghematan</h6>
                </div>
                <div class="card-body text-center">
                    <h3 class="text-success"><?php echo rp($total_hemat); ?></h3>
                    <small class="text-muted">dari harga normal <?php echo rp($subtotal); ?></small>

                    <?php if ($persentase_diskon > 0): ?>
                    <hr>
                    <div class="d-flex justify-content-between small">
                        <span>Diskon Jumlah (<?php echo $persentase_diskon; ?>%)</span>
                        <span class="text-success">- <?php echo rp($diskon); ?></span>
                    </div>
                    <?php endif; ?>

                    <?php if ($is_member): ?>
                    <div class="d-flex justify-content-between small mt-1">
                        <span>Diskon Member (5%)</span>
                        <span class="text-warning">- <?php echo rp($diskon_member); ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Tabel Diskon Bertingkat -->
            <div class="card border-info shadow-sm mb-3">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">📋 Tabel Diskon</h6>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Jumlah</th>
                                <th>Diskon</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="<?php echo ($jumlah_beli <= 2) ? 'table-warning fw-bold' : ''; ?>">
                                <td class="ps-3">1 – 2 buku</td>
                                <td><span class="badge bg-secondary">0%</span></td>
                            </tr>
                            <tr class="<?php echo ($jumlah_beli >= 3 && $jumlah_beli <= 5) ? 'table-warning fw-bold' : ''; ?>">
                                <td class="ps-3">3 – 5 buku</td>
                                <td><span class="badge bg-success">10%</span></td>
                            </tr>
                            <tr class="<?php echo ($jumlah_beli >= 6 && $jumlah_beli <= 10) ? 'table-warning fw-bold' : ''; ?>">
                                <td class="ps-3">6 – 10 buku</td>
                                <td><span class="badge bg-primary">15%</span></td>
                            </tr>
                            <tr class="<?php echo ($jumlah_beli > 10) ? 'table-warning fw-bold' : ''; ?>">
                                <td class="ps-3">> 10 buku</td>
                                <td><span class="badge bg-danger">20%</span></td>
                            </tr>
                            <tr class="table-light">
                                <td class="ps-3">Member</td>
                                <td><span class="badge bg-warning text-dark">+5%</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Info PPN -->
            <div class="card border-warning shadow-sm">
                <div class="card-header bg-warning">
                    <h6 class="mb-0">⚠️ Catatan</h6>
                </div>
                <div class="card-body small">
                    <ul class="mb-0 ps-3">
                        <li>Semua harga belum termasuk PPN.</li>
                        <li>PPN dihitung setelah semua diskon.</li>
                        <li>Diskon member dihitung dari harga setelah diskon jumlah.</li>
                        <li>Diskon tidak dapat digabungkan dengan promo lain.</li>
                    </ul>
                </div>
            </div>

        </div>

    </div><!-- /row -->
</div><!-- /container -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>