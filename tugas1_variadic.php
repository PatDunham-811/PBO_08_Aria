<?php
declare(strict_types=1);

class Kalkulator {
    public function jumlahkan(int ...$angka): int {
        return array_sum($angka);
    }
}

$kalkulator = new Kalkulator();
echo "jumlahkan(5, 15) = " . $kalkulator->jumlahkan(5, 15) . "<br>";
echo "jumlahkan(5, 15, 25) = " . $kalkulator->jumlahkan(5, 15, 25) . "<br>";
echo "jumlahkan() = " . $kalkulator->jumlahkan() . "<br>";
