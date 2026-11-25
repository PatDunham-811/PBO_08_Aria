<?php
class Dokumen {
    public function judul(): string { return 'Dokumen Umum'; }
}

class Surat extends Dokumen {
    public function judul(string $format): string { return 'Surat Resmi'; }
}
