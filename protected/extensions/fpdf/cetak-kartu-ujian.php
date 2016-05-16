<?php
include("inc/config.php");
include("inc/fc.php");

$pin=$_POST['pin'];
if(!empty($pin)){
$sql="select idmhs,password,nama_mhs,email,kota_lahir,".
 "date_format(tanggal_lahir,'%d %M %Y') as ftanggal_lahir,asal_sma,".
 "no_telp_sma,nilai_rata2_nem,nilai_rata2_sttb,alamat_sma,alamat_tinggal,no_telp_hp,".
 "no_telp_rumah,website_sma,nama_bapak,umur_bapak,no_telp_bapak,pekerjaan_bapak,".
 "penghasilan_bapak,nama_ibu,umur_ibu,no_telp_ibu,pekerjaan_ibu,penghasilan_ibu,".
 "alamat_ortu,kodeps1,kodeps2,waktu_daftar,cara_bayar,norek_asal,".
 "(select nama_programstudi from jurusan where jurusan.kodeps=calon_mahasiswa.kodeps1) as nama_programstudi1,".
 "(select nama_programstudi from jurusan where jurusan.kodeps=calon_mahasiswa.kodeps2) as nama_programstudi2,".
 "nama_norek_asal,bank_asal,idbank from calon_mahasiswa".
 " where idmhs='$pin'";
$que=mysql_query($sql);
if(is_resource($que)){
$mhs=mysql_fetch_assoc($que);mysql_free_result($que);
  

include('fpdf/fpdf.php'); 
include('fpdf/fpdi.php'); 

// initiate FPDI 
$pdf=new FPDI(); 
// add a page 
$pdf->AddPage(); 
// set the sourcefile 
$pdf->setSourceFile('fpdf/kartuujian.pdf'); 
// import page 1 
$tplIdx = $pdf->importPage(1); 
// use the imported page as the template 
$pdf->useTemplate($tplIdx, 0, 0);

// now write some text above the imported page 
$pdf->SetFont('Arial','B'); 
$page_left=65;
$pdf->SetTextColor(0,0,0); 

$pdf->SetXY($page_left, 109);$pdf->Write(0, $mhs['idmhs']); 
$pdf->SetXY($page_left, 119);$pdf->Write(0, strtoupper($mhs['nama_mhs'])); 
$pdf->SetXY($page_left, 128);$pdf->Write(0, strtoupper($mhs['kota_lahir'])." , ".$mhs['ftanggal_lahir']); 
$pdf->SetXY($page_left, 136);$pdf->Write(0, strtoupper($mhs['nama_programstudi1']) ); 
$pdf->SetXY($page_left, 145);$pdf->Write(0, strtoupper($mhs['nama_programstudi2']) ); 


$pdf->Output();

//$pdf->Output('newpdf.pdf', 'D'); 

 
}}
