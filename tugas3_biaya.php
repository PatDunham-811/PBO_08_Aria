<?php
declare(strict_types=1);

function rupiah(float $angka): string
{
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

abstract class Student {
    public function __construct(
        protected string $id,
        protected string $name,
        protected float $baseFee
    ) {}

    public function getId(): string {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    abstract public function calculateFee(): float;

    public function summary(): string {
        return $this->id . ' - ' . $this->name;
    }
}

class RegularStudent extends Student {
    public function calculateFee(): float {
        return $this->baseFee;
    }
}

class ScholarshipStudent extends Student {
    public function __construct(
        string $id,
        string $name,
        float $baseFee,
        private float $discountPercent
    ) {
        if ($discountPercent < 0 || $discountPercent > 100) {
            throw new InvalidArgumentException('Diskon harus di antara 0 dan 100');
        }
        parent::__construct($id, $name, $baseFee);
    }

    public function calculateFee(): float {
        return $this->baseFee * (1 - $this->discountPercent / 100);
    }

    public function summary(): string {
        return parent::summary() . ' [Beasiswa ' . $this->discountPercent . '%]';
    }
}

// Child baru: biaya = biaya dasar + biaya internasional
class InternationalStudent extends Student {
    public function __construct(
        string $id,
        string $name,
        float $baseFee,
        private string $country,
        private float $internationalFee
    ) {
        if ($internationalFee < 0) {
            throw new InvalidArgumentException('Biaya internasional tidak boleh negatif');
        }
        parent::__construct($id, $name, $baseFee);
    }

    public function calculateFee(): float {
        return $this->baseFee + $this->internationalFee;
    }

    public function summary(): string {
        return parent::summary() . ' [Internasional - ' . $this->country . ']';
    }
}

// Repository: tidak menyebut satu pun nama class child
class StudentRepository {
    /** @var Student[] */
    private array $items = [];

    public function add(Student $student): void {
        $this->items[$student->getId()] = $student;
    }

    public function all(): array {
        return array_values($this->items);
    }

    public function totalFee(): float {
        $total = 0.0;
        foreach ($this->items as $s) {
            $total += $s->calculateFee();
        }
        return $total;
    }
}

// Pengujian positif
$repo = new StudentRepository();
$repo->add(new RegularStudent('S001', 'Dewi', 4500000));
$repo->add(new ScholarshipStudent('S002', 'Fajar', 4500000, 25));
$repo->add(new InternationalStudent('S003', 'Kenji', 4500000, 'Jepang', 1500000));

foreach ($repo->all() as $s) {
    echo $s->summary() . ' | ' . rupiah($s->calculateFee()) . "<br>";
}
echo "Total: " . rupiah($repo->totalFee()) . "<br>";

// Pengujian negatif
foreach ([-5, 150] as $diskon) {
    try {
        new ScholarshipStudent('S99', 'Uji', 4500000, $diskon);
    } catch (InvalidArgumentException $e) {
        echo "Diskon {$diskon}: " . get_class($e) . ' - ' . $e->getMessage() . "<br>";
    }
}

try {
    new InternationalStudent('S98', 'Uji', 4500000, 'Jepang', -100000);
} catch (InvalidArgumentException $e) {
    echo "Biaya internasional -100000: " . get_class($e) . ' - ' . $e->getMessage() . "<br>";
}
