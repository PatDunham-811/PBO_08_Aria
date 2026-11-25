<?php
class Dokumen {
    public function judul(): string { return 'Dokumen Umum'; }
}

class Surat extends Dokumen {
    protected function judul(): string { return 'Surat Resmi'; }
}
