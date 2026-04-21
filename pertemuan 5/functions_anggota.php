<?php
// 1. Function untuk hitung total anggota
function hitung_total_anggota($anggota_list) {
    return count($anggota_list);
}

// 2. Function untuk hitung anggota aktif
function hitung_anggota_aktif($anggota_list) {
    $count = 0;
    foreach ($anggota_list as $anggota) {
        if ($anggota['status'] == "Aktif") {
            $count++;
        }
    }
    return $count;
}

// 3. Function untuk hitung rata-rata pinjaman
function hitung_rata_rata_pinjaman($anggota_list) {
    if (empty($anggota_list)) return 0;
    $total_pinjaman = 0;
    foreach ($anggota_list as $anggota) {
        $total_pinjaman += $anggota['total_pinjaman'];
    }
    return $total_pinjaman / count($anggota_list);
}

// 4. Function untuk cari anggota by ID
function cari_anggota_by_id($anggota_list, $id) {
    foreach ($anggota_list as $anggota) {
        if ($anggota['id'] == $id) {
            return $anggota;
        }
    }
    return null;
}

// 5. Function untuk cari anggota teraktif
function cari_anggota_teraktif($anggota_list) {
    if (empty($anggota_list)) return null;
    $teraktif = $anggota_list[0];
    foreach ($anggota_list as $anggota) {
        if ($anggota['total_pinjaman'] > $teraktif['total_pinjaman']) {
            $teraktif = $anggota;
        }
    }
    return $teraktif;
}

// 6. Function untuk filter by status
function filter_by_status($anggota_list, $status) {
    $filtered = [];
    foreach ($anggota_list as $anggota) {
        if ($anggota['status'] == $status) {
            $filtered[] = $anggota;
        }
    }
    return $filtered;
}

// 7. Function untuk validasi email
function validasi_email($email) {
    if (empty($email)) return false;
    if (strpos($email, '@') === false) return false;
    if (strpos($email, '.') === false) return false;
    return true; // Cek: tidak kosong, ada @, ada .
}

// 8. Function untuk format tanggal Indonesia
function format_tanggal_indo($tanggal) {
    // ubah 2024-01-15 jadi 15 Januari 2024
    $bulan_indo = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    $pecahkan = explode('-', $tanggal); // 0 = tahun, 1 = bulan, 2 = tanggal
    if (count($pecahkan) != 3) return $tanggal;
    return $pecahkan[2] . ' ' . $bulan_indo[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}

// Bonus 1: Function untuk sort anggota by nama (A-Z)
function sort_anggota_by_nama($anggota_list) {
    usort($anggota_list, function($a, $b) {
        return strcmp($a['nama'], $b['nama']);
    });
    return $anggota_list;
}

// Bonus 2: Function untuk search anggota by nama (partial match)
function search_anggota_by_nama($anggota_list, $keyword) {
    $filtered = [];
    $keyword = strtolower($keyword);
    foreach ($anggota_list as $anggota) {
        if (strpos(strtolower($anggota['nama']), $keyword) !== false) {
            $filtered[] = $anggota;
        }
    }
    return $filtered;
}
?>
