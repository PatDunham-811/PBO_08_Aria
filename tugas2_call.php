<?php
class MahasiswaView {
    public function __call(string $nama, array $argumen): string
    {
        if ($nama !== 'showData') {
            throw new BadMethodCallException('Method tidak dikenal: ' . $nama);
        }

        foreach ($argumen as $nilai) {
            if (!is_string($nilai)) {
                throw new InvalidArgumentException('Semua argumen harus bertipe string');
            }
        }

        return match (count($argumen)) {
            1 => 'Nama: ' . $argumen[0],
            2 => 'NIM: ' . $argumen[0] . ', Nama: ' . $argumen[1],
            3 => 'NIM: ' . $argumen[0] . ', Nama: ' . $argumen[1] . ', Jurusan: ' . $argumen[2],
            default => throw new InvalidArgumentException('Jumlah argumen harus 1, 2, atau 3'),
        };
    }
}

function jalankan(string $label, callable $aksi): void
{
    try {
        echo $label . " : " . $aksi() . "<br>";
    } catch (Throwable $e) {
        echo $label . " : Error [" . get_class($e) . "] " . $e->getMessage() . "<br>";
    }
}

$view = new MahasiswaView();

jalankan("showData('Rizki')", fn() => $view->showData('Rizki'));
jalankan("showData('2530521001', 'Rizki')", fn() => $view->showData('2530521001', 'Rizki'));
jalankan("showData('2530521001', 'Rizki', 'Sistem Informasi')", fn() => $view->showData('2530521001', 'Rizki', 'Sistem Informasi'));
jalankan("showData()", fn() => $view->showData());
jalankan("showData(456)", fn() => $view->showData(456));
jalankan("showData('a', 'b', 'c', 'd')", fn() => $view->showData('a', 'b', 'c', 'd'));
jalankan("hapusData('x')", fn() => $view->hapusData('x'));
