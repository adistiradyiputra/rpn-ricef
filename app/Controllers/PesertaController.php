<?php

namespace App\Controllers;

use App\Models\PesertaModel;
use App\Models\DetailPelatihanModel;
use App\Models\PelatihanModel;
use CodeIgniter\Controller;

class PesertaController extends Controller
{
    protected $pesertaModel;
    protected $detailPelatihanModel;
    protected $pelatihanModel;

    public function __construct()
    {
        $this->pesertaModel = new PesertaModel();
        $this->detailPelatihanModel = new DetailPelatihanModel();
        $this->pelatihanModel = new PelatihanModel();
    }

    public function index()
    {
        $session = session();
        $userLevel = $session->get('level');
        $userPuslit = $session->get('puslit');
        
        // Get all peserta with their related pelatihan details
        if ($userLevel == 1) {
            // Superadmin can see all participants
            $peserta = $this->pesertaModel->getAllPesertaWithDetails();
        } else {
            // Regular admin can only see participants from their puslit
            $peserta = $this->pesertaModel->getPesertaByPuslitWithDetails($userPuslit);
        }

        return view('v_daftar_peserta', [
            'peserta' => $peserta,
            'userLevel' => $userLevel,
            'userPuslit' => $userPuslit
        ]);
    }
    
    public function getPesertaData()
    {
        $session = session();
        $userLevel = $session->get('level');
        $userPuslit = $session->get('puslit');
        
        if ($userLevel == 1) {
            $peserta = $this->pesertaModel->getAllPesertaWithDetails();
        } else {
            $peserta = $this->pesertaModel->getPesertaByPuslitWithDetails($userPuslit);
        }
        
        return $this->response->setJSON([
            'data' => $peserta
        ]);
    }
    
    public function delete($id)
    {
        if ($this->pesertaModel->delete($id)) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal menghapus peserta']);
        }
    }
    
    public function update($id)
    {
        $data = [
            'username' => $this->request->getPost('username'),
            'nama' => $this->request->getPost('nama'),
            'alamat' => $this->request->getPost('alamat'),
            'instansi' => $this->request->getPost('instansi'),
            'telp' => $this->request->getPost('telp')
        ];
        
        // Update password only if provided
        if ($password = $this->request->getPost('password')) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
        
        if ($this->pesertaModel->update($id, $data)) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal memperbarui data peserta']);
        }
    }

    public function getPesertaById($id)
    {
        $peserta = $this->pesertaModel->find($id);
        
        if ($peserta) {
            return $this->response->setJSON([
                'success' => true,
                'data' => $peserta
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Peserta tidak ditemukan'
            ]);
        }
    }

    /**
     * Export peserta data to Excel with enhanced formatting
     * 
     * @param int|null $id_pelatihan ID pelatihan untuk filter, null untuk semua
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function exportExcel($id_pelatihan = null)
    {
        $session = session();
        $userLevel = $session->get('level');
        $userPuslit = $session->get('puslit');
        
        // Get data based on user level
        if ($userLevel == 1) {
            $peserta = $this->pesertaModel->getAllPesertaWithDetails();
        } else {
            $peserta = $this->pesertaModel->getPesertaByPuslitWithDetails($userPuslit);
        }
        
        // Filter by pelatihan id if specified
        $pelatihan_name = "Semua Pelatihan";
        if ($id_pelatihan && is_numeric($id_pelatihan)) {
            // Get pelatihan name for title
            $pelatihan_data = $this->pelatihanModel->find($id_pelatihan);
            if ($pelatihan_data) {
                $pelatihan_name = $pelatihan_data['nama_pelatihan'];
            }
            
            // Filter peserta by pelatihan ID
            $peserta = array_filter($peserta, function($p) use ($id_pelatihan) {
                return $p['id_pelatihan'] == $id_pelatihan;
            });
            // Re-index array
            $peserta = array_values($peserta);
        }
        
        // Create new Spreadsheet object
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Daftar Peserta');
        
        // Set document properties
        $spreadsheet->getProperties()
            ->setCreator('PT Riset Perkebunan Nusantara')
            ->setLastModifiedBy('PT Riset Perkebunan Nusantara')
            ->setTitle('Daftar Peserta Pelatihan')
            ->setSubject('Rekapitulasi Peserta Pelatihan')
            ->setDescription('Daftar peserta pelatihan dari sistem RPN Online Learning')
            ->setKeywords('peserta pelatihan export')
            ->setCategory('Peserta');
        
        // Set page orientation and margins
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageMargins()->setTop(0.5);
        $sheet->getPageMargins()->setRight(0.5);
        $sheet->getPageMargins()->setLeft(0.5);
        $sheet->getPageMargins()->setBottom(0.5);
        
        // Add logo
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Logo RPN');
        $drawing->setPath('assets/img/logo.png'); // Adjust path as needed
        $drawing->setCoordinates('A1');
        $drawing->setHeight(60);
        $drawing->setWorksheet($spreadsheet->getActiveSheet());
        
        // Set Indonesia locale for date formatting
        setlocale(LC_TIME, 'id_ID.utf8', 'id_ID', 'id');
        $bulan = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember'
        ];
        
        $tanggal = date('d F Y');
        foreach ($bulan as $en => $id) {
            $tanggal = str_replace($en, $id, $tanggal);
        }
        
        // Add title - changed to PT Riset Perkebunan Nusantara
        $sheet->setCellValue('C1', 'PT RISET PERKEBUNAN NUSANTARA');
        $sheet->setCellValue('C2', 'REKAPITULASI DATA PESERTA PELATIHAN');
        $sheet->setCellValue('C3', $pelatihan_name);
        $sheet->setCellValue('C4', 'Tanggal: ' . $tanggal);
        
        // Merge cells for title
        $sheet->mergeCells('C1:F1');
        $sheet->mergeCells('C2:F2');
        $sheet->mergeCells('C3:F3');
        $sheet->mergeCells('C4:F4');
        
        // Style for company name header
        $companyHeaderStyle = [
            'font' => [
                'bold' => true,
                'size' => 16,
                'color' => ['rgb' => '000000'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];
        $sheet->getStyle('C1')->applyFromArray($companyHeaderStyle);
        
        // Style for document title
        $titleStyle = [
            'font' => [
                'bold' => true,
                'size' => 14,
                'color' => ['rgb' => '000000'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];
        $sheet->getStyle('C2')->applyFromArray($titleStyle);
        
        // Style for subtitle
        $subtitleStyle = [
            'font' => [
                'bold' => true,
                'size' => 14,
                'color' => ['rgb' => '000000'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];
        $sheet->getStyle('C3')->applyFromArray($subtitleStyle);
        
        // Style for date
        $dateStyle = [
            'font' => [
                'bold' => true,
                'size' => 11,
                'color' => ['rgb' => '000000'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];
        $sheet->getStyle('C4')->applyFromArray($dateStyle);
        
        // Row height for header section - reduced to 2 header items
        $sheet->getRowDimension(1)->setRowHeight(25);
        $sheet->getRowDimension(2)->setRowHeight(25);
        $sheet->getRowDimension(3)->setRowHeight(25);
        $sheet->getRowDimension(4)->setRowHeight(20);
        
        // Add space
        $sheet->getRowDimension(5)->setRowHeight(10);
        
        // Add headers at row 6 (moved up from 8)
        $headers = ['No', 'Nama', 'Alamat', 'Instansi', 'Telepon', 'Puslit'];
        
        for ($i = 0; $i < count($headers); $i++) {
            $col = chr(65 + $i); // A, B, C, ...
            $sheet->setCellValue($col . '6', $headers[$i]);
        }
        
        // Style for table headers
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '4472C4',
                ],
            ],
        ];
        $sheet->getStyle('A6:F6')->applyFromArray($headerStyle);
        $sheet->getRowDimension(6)->setRowHeight(30);
        
        // Add data starting from row 7 (moved up from 9)
        $row = 7;
        $counter = 1;
        foreach ($peserta as $p) {
            $sheet->setCellValue('A' . $row, $counter);
            $sheet->setCellValue('B' . $row, $p['nama']);
            $sheet->setCellValue('C' . $row, $p['alamat']);
            $sheet->setCellValue('D' . $row, $p['instansi']);
            $sheet->setCellValue('E' . $row, $p['telp']);
            $sheet->setCellValue('F' . $row, $p['puslit']);
            
            // Zebra striping for rows
            if ($counter % 2 == 0) {
                $sheet->getStyle('A' . $row . ':F' . $row)->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('E9EDF5');
            }
            
            $row++;
            $counter++;
        }
        
        // Style for data
        $dataStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
            ],
        ];
        $sheet->getStyle('A7:F' . ($row - 1))->applyFromArray($dataStyle);
        
        // Center align No column
        $sheet->getStyle('A7:A' . ($row - 1))->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        
        // Text wrap for potentially long content
        $sheet->getStyle('B7:D' . ($row - 1))->getAlignment()->setWrapText(true);
        
        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(6);  // No
        $sheet->getColumnDimension('B')->setWidth(30); // Nama
        $sheet->getColumnDimension('C')->setWidth(40); // Alamat
        $sheet->getColumnDimension('D')->setWidth(30); // Instansi
        $sheet->getColumnDimension('E')->setWidth(20); // Telepon
        $sheet->getColumnDimension('F')->setWidth(20); // Puslit
        
        // Add summary below table - dengan kolom yang lebih besar
        $row += 2;
        $sheet->mergeCells('A' . $row . ':B' . $row);
        $sheet->setCellValue('A' . $row, 'Jumlah Peserta:');
        $sheet->setCellValue('C' . $row, count($peserta));
        
        // Add footer
        $sheet->getHeaderFooter()->setOddFooter('&L&B' . $spreadsheet->getProperties()->getTitle() . '&RPage &P of &N');
        
        // Set filename
        $filename = 'Daftar_Peserta_' . ($id_pelatihan ? str_replace(' ', '_', $pelatihan_name) : 'Semua_Pelatihan') . '_' . date('d-m-Y') . '.xlsx';
        
        // Create writer and output
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit();
    }
} 