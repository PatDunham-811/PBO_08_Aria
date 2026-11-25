<?php
class Dokumen {
    final public function getKode(): string { return 'DOK-01'; }
}

class Surat extends Dokumen {
    public function getKode(): string { return 'SRT-01'; }
}
