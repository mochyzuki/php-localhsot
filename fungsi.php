<?php
function hitungBobot($nilai) {
    if ($nilai >= 85) {
        return ['huruf' => 'A', 'bobot' => 4.0];
    } elseif ($nilai >= 70) {
        return ['huruf' => 'B', 'bobot' => 3.0];
    } elseif ($nilai >= 55) {
        return ['huruf' => 'C', 'bobot' => 2.0];
    } elseif ($nilai >= 40) {
        return ['huruf' => 'D', 'bobot' => 1.0];
    } else {
        return ['huruf' => 'E', 'bobot' => 0.0];
    }
}
