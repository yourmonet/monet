<?php

namespace App\Http\Controllers;

use App\Models\KasMasuk;
use App\Models\KasKeluar;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use Carbon\Carbon;

class LaporanKeuanganController extends Controller
{
    /**
     * Tampilkan halaman laporan keuangan dengan filter bulan & tahun.
     */
    /**
     * Cari periode terbaru yang ada datanya (fallback ke bulan saat ini).
     */
    private function defaultPeriode(): array
    {
        return [Carbon::now()->month, Carbon::now()->year];
    }

    public function index(Request $request)
    {
        [$defaultBulan, $defaultTahun] = $this->defaultPeriode();
        $bulan = (int) $request->input('bulan', $defaultBulan);
        $tahun = (int) $request->input('tahun', $defaultTahun);

        $kasMasukQuery = KasMasuk::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun);

        $kasKeluarQuery = KasKeluar::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun);

        $totalMasuk   = (clone $kasMasukQuery)->sum('jumlah');
        $totalKeluar  = (clone $kasKeluarQuery)->sum('nominal');
        $saldoBersih  = $totalMasuk - $totalKeluar;

        $kasMasuk = $kasMasukQuery->orderBy('tanggal', 'asc')->paginate(10, ['*'], 'masuk_page')->withQueryString();
        $kasKeluar = $kasKeluarQuery->orderBy('tanggal', 'asc')->paginate(10, ['*'], 'keluar_page')->withQueryString();

        // Daftar tahun untuk dropdown (dari data terlama hingga sekarang)
        $tahunTersedia = collect();
        $oldestMasuk   = KasMasuk::min('tanggal');
        $oldestKeluar  = KasKeluar::min('tanggal');
        $oldest        = min(array_filter([$oldestMasuk, $oldestKeluar]));
        $tahunAwal     = $oldest ? Carbon::parse($oldest)->year : Carbon::now()->year;
        for ($y = $tahunAwal; $y <= Carbon::now()->year; $y++) {
            $tahunTersedia->push($y);
        }

        return view('bendahara.laporan.index', compact(
            'kasMasuk', 'kasKeluar',
            'totalMasuk', 'totalKeluar', 'saldoBersih',
            'bulan', 'tahun', 'tahunTersedia'
        ));
    }

    /**
     * Export laporan sebagai PDF dan download.
     */
    public function exportPdf(Request $request)
    {
        [$defaultBulan, $defaultTahun] = $this->defaultPeriode();
        $bulan = (int) $request->input('bulan', $defaultBulan);
        $tahun = (int) $request->input('tahun', $defaultTahun);

        $kasMasuk = KasMasuk::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'asc')
            ->get();

        $kasKeluar = KasKeluar::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'asc')
            ->get();

        $totalMasuk  = $kasMasuk->sum('jumlah');
        $totalKeluar = $kasKeluar->sum('nominal');
        $saldoBersih = $totalMasuk - $totalKeluar;

        $namaBulan = Carbon::create($tahun, $bulan)->translatedFormat('F Y');

        $pdf = Pdf::loadView('bendahara.laporan.pdf', compact(
            'kasMasuk', 'kasKeluar',
            'totalMasuk', 'totalKeluar', 'saldoBersih',
            'namaBulan', 'bulan', 'tahun'
        ))->setPaper('a4', 'portrait')->setOption(['isRemoteEnabled' => true]);

        $filename = 'Laporan_Keuangan_' . Carbon::create($tahun, $bulan)->format('Y_m') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Export laporan sebagai Excel (.xlsx) dan download.
     */
    public function exportExcel(Request $request)
    {
        [$defaultBulan, $defaultTahun] = $this->defaultPeriode();
        $bulan = (int) $request->input('bulan', $defaultBulan);
        $tahun = (int) $request->input('tahun', $defaultTahun);

        $kasMasuk = KasMasuk::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'asc')
            ->get();

        $kasKeluar = KasKeluar::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'asc')
            ->get();

        $totalMasuk  = $kasMasuk->sum('jumlah');
        $totalKeluar = $kasKeluar->sum('nominal');
        $saldoBersih = $totalMasuk - $totalKeluar;

        $spreadsheet = $this->buildSpreadsheet($kasMasuk, $kasKeluar, $totalMasuk, $totalKeluar, $saldoBersih, $bulan, $tahun);

        $filename = 'Laporan_Keuangan_' . Carbon::create($tahun, $bulan)->format('Y_m') . '.xlsx';
        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /**
     * Build dan style Spreadsheet dari data kas masuk/keluar.
     */
    private function buildSpreadsheet(
        \Illuminate\Support\Collection $kasMasuk,
        \Illuminate\Support\Collection $kasKeluar,
        int|float $totalMasuk,
        int|float $totalKeluar,
        int|float $saldoBersih,
        int $bulan,
        int $tahun
    ): Spreadsheet {
        $namaBulan = Carbon::create($tahun, $bulan)->translatedFormat('F Y');
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator('MONET')
            ->setTitle('Laporan Keuangan ' . $namaBulan)
            ->setSubject('Laporan Keuangan ' . $namaBulan);

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Keuangan');

        // ── Header Organisasi ──────────────────────────────────────────
        $sheet->mergeCells('A1:E1');
        $sheet->setCellValue('A1', 'LAPORAN KEUANGAN');
        $sheet->getStyle('A1')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 14, 'color' => ['rgb' => 'FFFFFF']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '003D9B']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(30);

        $sheet->mergeCells('A2:E2');
        $sheet->setCellValue('A2', 'Periode: ' . $namaBulan);
        $sheet->getStyle('A2')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 11, 'color' => ['rgb' => '003D9B']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'DAE2FF']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->getRowDimension(2)->setRowHeight(20);

        $sheet->mergeCells('A3:E3');
        $sheet->setCellValue('A3', 'Dicetak pada: ' . Carbon::now()->translatedFormat('d F Y, H:i') . ' WIB');
        $sheet->getStyle('A3')->applyFromArray([
            'font'      => ['italic' => true, 'size' => 9, 'color' => ['rgb' => '737685']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->getRowDimension(3)->setRowHeight(16);

        // ── Spacer ─────────────────────────────────────────────────────
        $sheet->getRowDimension(4)->setRowHeight(10);

        // ── Section KAS MASUK ──────────────────────────────────────────
        $sheet->mergeCells('A5:E5');
        $sheet->setCellValue('A5', 'KAS MASUK (PEMASUKAN)');
        $sheet->getStyle('A5')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 11, 'color' => ['rgb' => 'FFFFFF']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1A6B3A']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT, 'indent' => 1],
        ]);
        $sheet->getRowDimension(5)->setRowHeight(22);

        // Header tabel kas masuk
        $headerStyle = [
            'font'      => ['bold' => true, 'size' => 10, 'color' => ['rgb' => '191C1E']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E8F5E9']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'C8E6C9']]],
        ];
        $sheet->fromArray(['No', 'Tanggal', 'Keterangan', 'Sumber', 'Jumlah (Rp)'], null, 'A6');
        $sheet->getStyle('A6:E6')->applyFromArray($headerStyle);
        $sheet->getRowDimension(6)->setRowHeight(18);

        // Data kas masuk
        $row = 7;
        $no  = 1;
        $dataStyle = [
            'alignment' => ['vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'DDDDDD']]],
        ];
        foreach ($kasMasuk as $km) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, Carbon::parse($km->tanggal)->translatedFormat('d F Y'));
            $sheet->setCellValue('C' . $row, $km->keterangan);
            $sheet->setCellValue('D' . $row, ucfirst($km->sumber ?? '-'));
            $sheet->setCellValue('E' . $row, $km->jumlah);
            $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray($dataStyle);
            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('E' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $row++;
        }
        if ($kasMasuk->isEmpty()) {
            $sheet->mergeCells('A' . $row . ':E' . $row);
            $sheet->setCellValue('A' . $row, 'Tidak ada data kas masuk pada periode ini.');
            $sheet->getStyle('A' . $row)->applyFromArray([
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'font'      => ['italic' => true, 'color' => ['rgb' => '737685']],
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'DDDDDD']]],
            ]);
            $row++;
        }

        // Total kas masuk
        $sheet->mergeCells('A' . $row . ':D' . $row);
        $sheet->setCellValue('A' . $row, 'TOTAL KAS MASUK');
        $sheet->setCellValue('E' . $row, $totalMasuk);
        $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray([
            'font'      => ['bold' => true, 'color' => ['rgb' => '1A6B3A']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'C8E6C9']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'A5D6A7']]],
        ]);
        $sheet->getStyle('E' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getRowDimension($row)->setRowHeight(20);
        $row++;

        // Spacer
        $sheet->getRowDimension($row)->setRowHeight(12);
        $row++;

        // ── Section KAS KELUAR ─────────────────────────────────────────
        $sheet->mergeCells('A' . $row . ':E' . $row);
        $sheet->setCellValue('A' . $row, 'KAS KELUAR (PENGELUARAN)');
        $sheet->getStyle('A' . $row)->applyFromArray([
            'font'      => ['bold' => true, 'size' => 11, 'color' => ['rgb' => 'FFFFFF']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'BA1A1A']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT, 'indent' => 1],
        ]);
        $sheet->getRowDimension($row)->setRowHeight(22);
        $row++;

        // Header tabel kas keluar
        $headerStyleKeluar = [
            'font'      => ['bold' => true, 'size' => 10, 'color' => ['rgb' => '191C1E']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FDECEA']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'FFCDD2']]],
        ];
        $sheet->fromArray(['No', 'Tanggal', 'Keterangan', 'Sumber', 'Nominal (Rp)'], null, 'A' . $row);
        $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray($headerStyleKeluar);
        $sheet->getRowDimension($row)->setRowHeight(18);
        $row++;

        // Data kas keluar
        $no = 1;
        foreach ($kasKeluar as $kk) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, Carbon::parse($kk->tanggal)->translatedFormat('d F Y'));
            $sheet->setCellValue('C' . $row, $kk->keterangan);
            $sheet->setCellValue('D' . $row, ucfirst($kk->sumber ?? '-'));
            $sheet->setCellValue('E' . $row, $kk->nominal);
            $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray($dataStyle);
            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('E' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $row++;
        }
        if ($kasKeluar->isEmpty()) {
            $sheet->mergeCells('A' . $row . ':E' . $row);
            $sheet->setCellValue('A' . $row, 'Tidak ada data kas keluar pada periode ini.');
            $sheet->getStyle('A' . $row)->applyFromArray([
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'font'      => ['italic' => true, 'color' => ['rgb' => '737685']],
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'DDDDDD']]],
            ]);
            $row++;
        }

        // Total kas keluar
        $sheet->mergeCells('A' . $row . ':D' . $row);
        $sheet->setCellValue('A' . $row, 'TOTAL KAS KELUAR');
        $sheet->setCellValue('E' . $row, $totalKeluar);
        $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray([
            'font'      => ['bold' => true, 'color' => ['rgb' => 'BA1A1A']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFCDD2']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'EF9A9A']]],
        ]);
        $sheet->getStyle('E' . $row)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getRowDimension($row)->setRowHeight(20);
        $row++;

        // Spacer
        $sheet->getRowDimension($row)->setRowHeight(12);
        $row++;

        // ── Ringkasan Saldo ────────────────────────────────────────────
        $sheet->mergeCells('A' . $row . ':E' . $row);
        $sheet->setCellValue('A' . $row, 'RINGKASAN KEUANGAN');
        $sheet->getStyle('A' . $row)->applyFromArray([
            'font'      => ['bold' => true, 'size' => 11, 'color' => ['rgb' => 'FFFFFF']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '003D9B']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT, 'indent' => 1],
        ]);
        $sheet->getRowDimension($row)->setRowHeight(22);
        $row++;

        $summaryData = [
            ['Total Pemasukan', $totalMasuk, '1A6B3A', 'C8E6C9'],
            ['Total Pengeluaran', $totalKeluar, 'BA1A1A', 'FFCDD2'],
            ['Saldo Bersih', $saldoBersih, ($saldoBersih >= 0 ? '003D9B' : 'BA1A1A'), ($saldoBersih >= 0 ? 'DAE2FF' : 'FFDAD6')],
        ];
        foreach ($summaryData as [$label, $value, $fontColor, $fillColor]) {
            $sheet->mergeCells('A' . $row . ':D' . $row);
            $sheet->setCellValue('A' . $row, $label);
            $sheet->setCellValue('E' . $row, $value);
            $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray([
                'font'      => ['bold' => true, 'color' => ['rgb' => $fontColor]],
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $fillColor]],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT, 'vertical' => Alignment::VERTICAL_CENTER],
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'DDDDDD']]],
            ]);
            $sheet->getStyle('E' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getRowDimension($row)->setRowHeight(20);
            $row++;
        }

        // ── Set Column Widths ──────────────────────────────────────────
        $sheet->getColumnDimension('A')->setWidth(6);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(38);
        $sheet->getColumnDimension('D')->setWidth(18);
        $sheet->getColumnDimension('E')->setWidth(20);

        // ── Footer ─────────────────────────────────────────────────────
        $row++;
        $sheet->mergeCells('A' . $row . ':E' . $row);
        $sheet->setCellValue('A' . $row, 'Dokumen ini digenerate otomatis oleh sistem MONET.');
        $sheet->getStyle('A' . $row)->applyFromArray([
            'font'      => ['italic' => true, 'size' => 8, 'color' => ['rgb' => '737685']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        return $spreadsheet;
    }
}
