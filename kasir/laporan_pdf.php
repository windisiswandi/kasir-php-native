<?php
// memanggil library FPDF
require('../library/fpdf181/fpdf.php');


include '../koneksi.php'; 
$tgl_dari = $_GET['tanggal_dari'];
$tgl_sampai = $_GET['tanggal_sampai'];

// intance object dan memberikan pengaturan halaman PDF
$pdf = new FPDF('l','mm','A4');
// membuat halaman baru
$pdf->AddPage();
// setting jenis font yang akan digunakan
$pdf->SetFont('Arial','B',14);
// mencetak string 
$pdf->Cell(280,7,'SISTEM POS (Point Of Sales)',0,1,'C');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(280,7,'LAPORAN PENJUALAN',0,1,'C');

// Memberikan space kebawah agar tidak terlalu rapat
$pdf->Cell(10,7,'',0,1);
$pdf->SetFont('Arial','B',10);

$pdf->Cell(35,6,'DARI TANGGAL',0,0);
$pdf->Cell(5,6,':',0,0);
$pdf->Cell(35,6, date('d-m-Y', strtotime($tgl_dari)) ,0,0);
$pdf->Cell(10,7,'',0,1);
$pdf->Cell(35,6,'SAMPAI TANGGAL',0,0);
$pdf->Cell(5,6,':',0,0);
$pdf->Cell(35,6, date('d-m-Y', strtotime($tgl_sampai)) ,0,0);

$pdf->Cell(10,10,'',0,1);
$pdf->SetFont('Arial','B',10);

$pdf->Cell(10,7,'NO',1,0,'C');
$pdf->Cell(26,7,'NO.INVOICE',1,0,'C');
$pdf->Cell(26,7, 'TANGGAL' ,1,0,'C');
$pdf->Cell(30,7,'PELANGGAN',1,0,'C');
$pdf->Cell(34,7,'KASIR',1,0,'C');
$pdf->Cell(30,7, 'SUB TOTAL' ,1,0,'C');
$pdf->Cell(25,7,'DISKON (%)',1,0,'C');
$pdf->Cell(30,7,'TOTAL BAYAR',1,0);
$pdf->Cell(30,7,'MODAL',1,0,'C');
$pdf->Cell(30,7,'LABA',1,0,'C');


$pdf->Cell(10,7,'',0,1);
$pdf->SetFont('Arial','',10);


$no=1;
$x_total_sub_total = 0;
$x_total_total = 0;
$x_total_modal = 0;
$x_total_laba = 0;
$data = mysqli_query($koneksi,"SELECT * FROM invoice,kasir where kasir_id=invoice_kasir and date(invoice_tanggal) >= '$tgl_dari' and date(invoice_tanggal) <= '$tgl_sampai' order by invoice_id desc");
while($d = mysqli_fetch_array($data)){

  $pdf->Cell(10,6,$no++,1,0,'C');
  $pdf->Cell(26,6,$d['invoice_nomor'],1,0,'C');
  $pdf->Cell(26,6, date('d-m-Y', strtotime($d['invoice_tanggal'])) ,1,0,'C');
  $pdf->Cell(30,6,$d['invoice_pelanggan'],1,0,'C');
  $pdf->Cell(34,6,$d['kasir_nama'],1,0,'C');
  $pdf->Cell(30,6, "Rp.".number_format($d['invoice_sub_total']).",-" ,1,0,'C');
  $pdf->Cell(25,6,$d['invoice_diskon'],1,0,'C');
  $pdf->Cell(30,6,"Rp.".number_format($d['invoice_total']).",-",1,0,'C');
  
  $id_invoice = $d['invoice_id'];
  $total_modal = 0;
  $modal = mysqli_query($koneksi,"SELECT * FROM invoice,transaksi,produk where invoice_id=transaksi_invoice and transaksi_produk=produk_id and invoice_id='$id_invoice'");
  while($l = mysqli_fetch_array($modal)){
    $m = $l['produk_harga_modal'] * $l['transaksi_jumlah'];
    $total_modal += $m;
  }

  $pdf->Cell(30,6,"Rp.".number_format($total_modal).",-",1,0,'C');
  $total_laba = $d['invoice_total'] - $total_modal;
  $pdf->Cell(30,6,"Rp.".number_format($total_laba).",-",1,0,'C');

  $x_total_sub_total += $d['invoice_sub_total'];
  $x_total_total += $d['invoice_total'];
  $x_total_modal += $total_modal;
  $x_total_laba += $total_laba;

  $pdf->Cell(10,6,'',0,1);
}


$pdf->SetFont('Arial','B',10);

$pdf->Cell(126,7,'TOTAL',1,0,'C');
$pdf->Cell(30,7,"Rp.".number_format($x_total_sub_total).",-",1,0,'C');
$pdf->Cell(25,7,"",1,0,'C');
$pdf->Cell(30,7, "Rp.".number_format($x_total_total).",-" ,1,0,'C');
$pdf->Cell(30,7,"Rp.".number_format($x_total_modal).",-",1,0,'C');
$pdf->Cell(30,7,"Rp.".number_format($x_total_laba).",-",1,0,'C');





$pdf->Output();
?>