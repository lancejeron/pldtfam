<?php
require('../fpdf.php');

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image('../pldt.png',10,6,60);
    // Times bold 15
    // $this->SetFont('Times','B',42);
    // Move to the right
    // $this->Cell(20);
    // // Title
    // $this->Cell(0,10,'PLDT',0,0,'L');
    // // Line break
    $this->Ln(20);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Times italic 8
    $this->SetFont('Times','I',8);
    $this->MultiCell(0,1,'*** Must be an orginal computer pirntout without erasures to be valid. *** ',0,'L');
    $this->MultiCell(0,7,'*** For verifiaction pls. contact: (632) 584-0247/0247/0255/0261/0264/0355 or email us at HRISAdvisory@pldt.com.ph.*** ',0,'L');
  
}
}

$pdf = new PDF('P', 'mm', 'Letter');
// $pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetMargins(30,5);
$pdf->Image('../pldt2.png',50,20,300);
$pdf->SetFont('Times','B',14);
$pdf->SetFont('','',12);
$pdf->Ln(5);
$pdf->MultiCell(0,5,' November 12, 2019',0,'R');
$pdf->Ln(5);
$pdf->MultiCell(0,5,' eHr-1212-1894533-CEC',0,'R');
$pdf->Ln(20);
$pdf->SetFont('Times','B',12);
$pdf->MultiCell(0,5,'TO WHOM IT MAY CONCERN:',0,'L');
$pdf->SetFont('','',12);
$pdf->Ln(10);
$pdf->MultiCell(0,5,'         This is to certify that the following data are true and indicated in the records of this company:',0,'L');
$pdf->Ln(10);
$pdf->SetFont('Times','B',12);
$pdf->MultiCell(0,5,'ID NUMBER:',0,'L');
$pdf->Ln(5);
$pdf->MultiCell(0,5,'NAME OF EMPLOYEE:',0,'L');
$pdf->Ln(5);
$pdf->MultiCell(0,5,'DATE EMPLOYED:',0,'L');
$pdf->Ln(5);
$pdf->MultiCell(0,5,'DATE SEPARATED:',0,'L');
$pdf->Ln(5);
$pdf->MultiCell(0,5,'DESIGNATION:',0,'L');
$pdf->Ln(5);
$pdf->MultiCell(0,5,'PRESENT ORGANIZATION:',0,'L');
$pdf->Ln(5);
$pdf->MultiCell(0,5,'BASIC MONTHLY SALARY',0,'L');
$pdf->Ln(5);
$pdf->MultiCell(0,5,'SSS NUMBER:',0,'L');
$pdf->Ln(10);
$pdf->SetFont('Times');
$pdf->MultiCell(0,5,'         This cetification is issued upon employee\'s request for SSS, SSS, SSS, SSS, SSS, SSS, SSS, SSS, SSS, SSS, SSS, SSS, SSS, SSS, SSS, SSS, SSS, SSS, SSS, SSS, SSS, SSS, SSS, SSS, SSS, SSS, SSS, SSS, SSS, SSS, SSS, SSS, SSS, SSS, purposes.',0,'L');
$pdf->Ln(30);   
// $pdf->MultiCell(0,5,'Renelia L. Villanueva',0,'R');
// $pdf->MultiCell(0,5,'Head',0,'R');
// $pdf->MultiCell(0,5,'HRIS & Automation',0,'R');


// eto yung last wag dugtungan. sa taas ka magdagdag.
$pdf->SetFont('Times','B',12);
$pdf->SetXY(100,107);
$pdf->MultiCell(50,0,'J852',0,'L');
$pdf->SetXY(100,117);
$pdf->MultiCell(50,0,'Roberto Joaquin Zulueta',0,'L');
$pdf->SetXY(100,127);
$pdf->MultiCell(50,0,'January 4, 2019',0,'L');
$pdf->SetXY(100,137);
$pdf->MultiCell(70,0,'March 14, 1999(Manpower)',0,'L');
$pdf->SetXY(100,147);
$pdf->MultiCell(50,0,'Analyst-Programmer',0,'L');
$pdf->SetXY(100,157);
$pdf->MultiCell(70,0,'Application Development 3 Division',0,'L');
$pdf->SetXY(100,167);
$pdf->MultiCell(70,0,'Confidential',0,'L');
$pdf->SetXY(100,177);
$pdf->MultiCell(70,0,'3304511823',0,'L');

$pdf->SetXY(95.5,37.5);
$pdf->MultiCell(100,0,'Date:',0,'C');
$pdf->SetXY(88,47.5);
$pdf->MultiCell(100,0,'Ref:',0,'C');

$pdf->SetFont('Times');
$pdf->SetXY(100,108);
$pdf->MultiCell(84,0,'_______________________________________________________________________________________',0,'L');
$pdf->SetXY(100,118);
$pdf->MultiCell(84,0,'_______________________________________________________________________________________',0,'L');
$pdf->SetXY(100,128);
$pdf->MultiCell(84,0,'_______________________________________________________________________________________',0,'L');
$pdf->SetXY(100,138);
$pdf->MultiCell(84,0,'_______________________________________________________________________________________',0,'L');
$pdf->SetXY(100,148);
$pdf->MultiCell(84,0,'_______________________________________________________________________________________',0,'L');
$pdf->SetXY(100,158);
$pdf->MultiCell(84,0,'_______________________________________________________________________________________',0,'L');
$pdf->SetXY(100,168);
$pdf->MultiCell(84,0,'_______________________________________________________________________________________',0,'L');
$pdf->SetXY(100,178);
$pdf->MultiCell(84,0,'_______________________________________________________________________________________',0,'L');

// head
$pdf->SetFont('Times');
$pdf->SetXY(111,232);
$pdf->MultiCell(100,0,'Renelia L. Villanueva',0,'C');
$pdf->SetXY(111,234);
$pdf->MultiCell(100,5,'Head',0,'C');
$pdf->SetXY(111,238);
$pdf->MultiCell(100,5,'HRIS & Automation',0,'C');

$pdf->Output();
?>