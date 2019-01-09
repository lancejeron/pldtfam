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
    $this->SetY(-40);
    // Times italic 8
    $this->SetFont('Times','I',8);
    $this->MultiCell(0,1,'*** Must be an orginal computer pirntout without erasures to be valid. *** ',0,'L');
    $this->MultiCell(0,7,'*** For verifiaction pls. contact: (632) 584-0247/0247/0255/0261/0264/0355 or email us at HRISAdvisory@pldt.com.ph.*** ',0,'L');
    $this->SetFont('Times','',12);
    $this->MultiCell(0,10,'eHR-1123-18-94252-CEC',0,'L');
    $this->SetFont('Times','',8);
    $this->SetTextColor(255,0,0);
    $this->MultiCell(0,10,'PLDT General Office P.O. Box 2148 Makati City, Philippines',0,'R');
    $this->SetFont('Times','B',8);
    $this->MultiCell(0,5,'PLD 1',0,'R');


}
}

$pdf = new PDF('P', 'mm','Legal');
// $pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetMargins(20,5);
$pdf->Image('../pldt2.png',50,20,300);
$pdf->SetFont('Times','B',14);
$pdf->MultiCell(0,10,'CERTFICATE OF EMPLOYMENT AND COMPENSATION',0, 'C');
$pdf->SetFont('','',12);
$pdf->Ln(5);
$pdf->MultiCell(0,5,'Date: November 12, 2019',0,'R');
$pdf->Ln(5);
$pdf->MultiCell(0,5,'         This is to certify that ROBERTO JOAQUIN ZULUETA is a regular employee of PLDT Inc. (formerly "Philippine Long Distance Telephone Company") since November 1, 1994 and presently holds the positon of Sr Telecom Associate.',0,'L');
$pdf->Ln(5);
$pdf->MultiCell(0,5,'         His present basic monthly salary is P100,000.00.',0,'L');
$pdf->Ln(5);
$pdf->MultiCell(0,5,'         Further, he recieved the following bonuses, premiums and allowances during the twelve-month period:',0,'L');
$pdf->Ln(10);
$pdf->MultiCell(0,5,'                   Mid-Year Bonus',0,'L');
$pdf->MultiCell(0,5,'                   Christmas Bonus/13th Month Pay',0,'L');
$pdf->MultiCell(0,5,'                   Unused Sick Leave Pay',0,'L');
$pdf->MultiCell(0,5,'                   Other Earnings  ',0,'L');
$pdf->MultiCell(0,5,'                   Other Bonuses  ',0,'L');
$pdf->MultiCell(0,1,'                                                                                                            ____________________',0,'L');
$pdf->MultiCell(0,5,'                   Total Other Income',0,'L');
$pdf->Ln(10);
$pdf->MultiCell(0,5,'         This cetification is being issued upon employee\'s request for Visa Application. Visa Application. Visa Application. Visa Application. Visa Application. Visa Application. Visa Application. Visa Application.',0,'L');
$pdf->Ln(55);
$pdf->MultiCell(0,5,'         SUBSCRIBES AND SWORN to before me, a notary public in and for the City of ____________________ this ____ day of __________________. The affiant, whom I identified through the following competent evidence of identity: Philippine Social Security System number 0391924976, personally signed the foregoing instrument before me and avowed under penalty of law to the whole truth od the contents of said instrument.',0,'L');
$pdf->Ln(5);
$pdf->MultiCell(0,5,'WITNESS MY HAND AND SEAL on the date and at the place first abovementioned.',0,'L');
$pdf->Ln(5);
$pdf->MultiCell(0,5,'Doc. No.',0,'L');
$pdf->MultiCell(0,5,'Page No',0,'L');
$pdf->MultiCell(0,5,'Book No',0,'L');
$pdf->MultiCell(0,5,'Series of',0,'L');
$pdf->Ln(5);
$pdf->SetFont('Times','B',14);
$pdf->MultiCell(0,5,'NOTARY PUBLIC',0,'R');
$pdf->SetFont('Times');


// $pdf->MultiCell(0,5,'Renelia L. Villanueva',0,'R');
// $pdf->MultiCell(0,5,'Head',0,'R');
// $pdf->MultiCell(0,5,'HRIS & Automation',0,'R');


// eto yung last wag dugtungan. sa taas ka magdagdag.
$pdf->SetXY(137,107.5);
$pdf->MultiCell(42,0,'999,999,999.00',0,'R');
$pdf->SetXY(137,112.5);
$pdf->MultiCell(42,0,'9,999,999.00',0,'R');
$pdf->SetXY(137,117.5);
$pdf->MultiCell(42,0,'999,999.00',0,'R');
$pdf->SetXY(137,122.5);
$pdf->MultiCell(42,0,'9,999.00',0,'R');
$pdf->SetXY(137,127.5);
$pdf->MultiCell(42,0,'999.00',0,'R');
$pdf->SetXY(137,135);
$pdf->MultiCell(42,0,'999,999,999,999.00',0,'R');

// head
$pdf->SetXY(111,194);
$pdf->MultiCell(100,0,'Renelia L. Villanueva',0,'C');
$pdf->SetXY(111,196);
$pdf->MultiCell(100,5,'Head',0,'C');
$pdf->SetXY(111,200);
$pdf->MultiCell(100,5,'HRIS & Automation',0,'C');


$pdf->Output();
?>