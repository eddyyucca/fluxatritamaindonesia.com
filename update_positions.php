<?php
use App\Models\Position;

$descriptions = [
    'Director' => 'Memimpin perusahaan, menentukan arah strategis, dan menyetujui keputusan akhir dokumen/anggaran.',
    'Operations Manager' => 'Mengawasi dan mengelola seluruh kegiatan operasional agar berjalan lancar.',
    'Project Support / Client Support' => 'Memberikan dukungan proyek dan melayani kebutuhan serta kendala klien.',
    'Finance & Administration Manager' => 'Mengatur keuangan, tagihan (invoicing), dan kegiatan administrasi umum.',
    'Technology / Business Development Manager' => 'Mengepalai divisi teknologi serta memimpin ekspansi dan peluang bisnis baru.',
    'Fullstack Developer 1' => 'Pengembang aplikasi Frontend & Backend tingkat utama (Lead/Senior).',
    'Fullstack Developer 2' => 'Pengembang aplikasi Frontend & Backend berpengalaman.',
    'Fullstack Developer 3' => 'Pengembang aplikasi Frontend & Backend berpengalaman.',
    'Fullstack Developer 4' => 'Pengembang aplikasi Frontend & Backend.',
    'IT Infrastructure Manager' => 'Bertanggung jawab atas server, arsitektur jaringan, dan keamanan sistem IT.'
];

foreach ($descriptions as $name => $desc) {
    Position::where('name', $name)->update(['description' => $desc]);
}
echo "Descriptions updated.\n";
