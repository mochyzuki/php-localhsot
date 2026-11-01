<?php
require_once 'data.php';
require_once 'fungsi.php';

$totalSks = 0;
$totalBobotSks = 0;
$dataTabel = [];

foreach ($matkul as $item) {
    $konversi = hitungBobot($item['nilai']);
    $huruf    = $konversi['huruf'];
    $bobot    = $konversi['bobot'];

    $status   = ($bobot >= 2.0) ? 'LULUS' : 'MENGULANG';
    
    $totalSks      += $item['sks'];
    $totalBobotSks += ($item['sks'] * $bobot);

    $dataTabel[] = [
        'nama'   => $item['nama'],
        'sks'    => $item['sks'],
        'nilai'  => $item['nilai'],
        'huruf'  => $huruf,
        'bobot'  => $bobot,
        'status' => $status
    ];
}

$ips = ($totalSks > 0) ? ($totalBobotSks / $totalSks) : 0.0;

if ($ips >= 3.00) {
    $maxSks = 24;
    $ketentuanSks = "IPS Anda &ge; 3.00, berhak mengambil maksimal 24 SKS di semester depan.";
} else {
    $maxSks = 20;
    $ketentuanSks = "IPS Anda &lt; 3.00, berhak mengambil maksimal 20 SKS di semester depan.";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Hasil Studi (KHS) - Perhitungan IPS</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <div class="header">
        <h1>KARTU HASIL STUDI (KHS)</h1>
        <p>Perhitungan Indeks Prestasi Semester (IPS) & Kuota SKS</p>
    </div>

    <div class="student-info">
        <div><strong>Nama:</strong> <?= htmlspecialchars($mahasiswa['nama']) ?></div>
        <div><strong>NIM:</strong> <?= htmlspecialchars($mahasiswa['nim']) ?></div>
        <div><strong>Jurusan:</strong> <?= htmlspecialchars($mahasiswa['jurusan']) ?></div>
        <div><strong>Semester:</strong> <?= htmlspecialchars($mahasiswa['semester']) ?></div>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th style="width: 5%; text-align: center;">No</th>
                    <th>Nama Matkul</th>
                    <th style="width: 12%; text-align: center;">SKS</th>
                    <th style="width: 15%; text-align: center;">Nilai Angka</th>
                    <th style="width: 15%; text-align: center;">Nilai Huruf</th>
                    <th style="width: 12%; text-align: center;">Bobot</th>
                    <th style="width: 18%; text-align: center;">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($dataTabel as $row) : ?>
                    <?php $isMengulang = ($row['status'] === 'MENGULANG'); ?>
                    <tr class="<?= $isMengulang ? 'baris-mengulang' : '' ?>">
                        <td style="text-align: center;"><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['nama']) ?></td>
                        <td style="text-align: center;"><?= $row['sks'] ?></td>
                        <td style="text-align: center;"><?= $row['nilai'] ?></td>
                        <td style="text-align: center;"><?= $row['huruf'] ?></td>
                        <td style="text-align: center;"><?= number_format($row['bobot'], 1) ?></td>
                        <td style="text-align: center;">
                            <span class="badge <?= $isMengulang ? 'badge-mengulang' : 'badge-lulus' ?>">
                                <?= $row['status'] ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="summary-card">
        <div class="summary-title">Ringkasan Hasil Studi & Kuota SKS</div>
        <div class="summary-grid">
            <div class="summary-item">
                <div class="label">Total SKS Ditempuh</div>
                <div class="value"><?= $totalSks ?> SKS</div>
            </div>
            <div class="summary-item">
                <div class="label">Total Mutu (&Sigma; SKS &times; Bobot)</div>
                <div class="value"><?= number_format($totalBobotSks, 1) ?></div>
            </div>
            <div class="summary-item">
                <div class="label">Indeks Prestasi Semester (IPS)</div>
                <div class="value highlight"><?= number_format($ips, 2) ?></div>
            </div>
            <div class="summary-item">
                <div class="label">Batas Maksimal SKS Depan</div>
                <div class="value highlight"><?= $maxSks ?> SKS</div>
            </div>
        </div>

        <div class="info-ketentuan">
            <strong>Catatan Akademik:</strong> <?= $ketentuanSks ?>
        </div>
    </div>
</div>

</body>
</html>
