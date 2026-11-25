<?php
class Dokumen {
    protected function cetak(): string { return 'Cetak dokumen'; }
}

class Surat extends Dokumen {
    public function cetak(): string {
        return parent::cetak() . ' + cap surat';
    }
}

echo (new Surat())->cetak();
