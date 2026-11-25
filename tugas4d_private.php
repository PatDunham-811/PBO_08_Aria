<?php
class Dokumen {
    private function nama(): string { return 'induk'; }
    public function tampil(): string { return $this->nama(); }
}

class Surat extends Dokumen {
    private function nama(): string { return 'anak'; }
}

echo (new Surat())->tampil();
