<?php
    session_start();

    require('../fpdf181/fpdf.php');

	if(!isset($_SESSION['username'])){
        header("Location:login.php");
	}
	else{
        require 'template/connection.php';

        // create record
        $persno= $_POST["persno"];
        date_default_timezone_set('Asia/Manila');
        $date_prepared= date('Y-m-d H:i:s', time());
        $start_time= $_POST["start_time"];
        $purpose = $_POST["purpose"];
        $type_of_cert = $_POST["type_of_cert"];
        $ref_no = $_POST["ref_no"];
        $withsignature = $_POST["withsignature"];
        $withlogo = $_POST["withlogo"];

        $check_cert = $conn->prepare("SELECT COUNT(*) AS x FROM prepared_certificates WHERE ref_no IN ('$ref_no')");
        $check_cert -> execute();
        $check_cert_res = $check_cert ->fetchAll();
        foreach($check_cert_res as $x){
            if($x["x"]==0){
                $create_cert_que = $conn->prepare("INSERT INTO prepared_certificates (ref_no, date_prepared, emp_id, purpose, req_date, req_status) VALUES ('$ref_no', '$date_prepared', '$persno','$purpose', '$start_time', 0)");
                if (!$create_cert_que->execute()) {
                    echo 'error';
                }
                else{
                    header('Location: request.php?emp_id='.$persno.'&start_time='.$start_time.'');
                }
            }
        }

        class PDF extends FPDF {
            function Header(){
                $withlogo = $_POST["withlogo"];
                if($withlogo==1){
                    $this->Image('../fpdf181/pldt.png',10,6,60);
                }
                $this->Ln(20);
            }
            function Footer(){
                $withlogo = $_POST["withlogo"];
                $this->SetY(-35);
                $this->SetFont('Times','I',8);
                $this->MultiCell(0,1,'*** Must be an original computer printout without erasures to be valid. *** ',0,'L');
                $this->MultiCell(0,7,'*** For verification pls. contact: (632) 584-0247/0247/0255/0261/0264/0355 or email us at HRISAdvisory@pldt.com.ph.*** ',0,'L');
                $this->Ln(7);
                if($withlogo==1){
                    $this->SetFont('Times','',8);
                    $this->SetTextColor(255,0,0);
                    $this->MultiCell(0,5,"PLDT General Office P.O. Box 2148 Makati City, Philippines",0,'R');
                    $this->SetFont('Times','B',8);
                    $this->MultiCell(0,5,'PLD 1',0,'R');
                }
            
            }
            
        }
        if($type_of_cert=='COE'){
            $pdf = new PDF('P', 'mm', 'Letter');
            $pdf->AddPage();
            $pdf->SetMargins(30,5);
            if($withlogo=='1'){
                $pdf->Image('../fpdf181/pldt2.png',50,20,300);
            }
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
            $pdf->MultiCell(0,5,'         This certification is issued upon employee\'s request for SSS purposes.',0,'L');
            $pdf->Ln(30);   

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

            // head of hris
            $pdf->SetFont('Times');
            $pdf->SetXY(111,226);
            $pdf->MultiCell(100,0,'Renelia L. Villanueva',0,'C');
            $pdf->SetXY(111,228);
            $pdf->MultiCell(100,5,'Head',0,'C');
            $pdf->SetXY(111,232);
            $pdf->MultiCell(100,5,'HRIS & Automation',0,'C');

            $pdf->Output("F", "doc_certs/$ref_no.pdf");
            $pdf->Output("");
        }
        else if($type_of_cert=='CEC'){
            $pdf = new PDF();
            $pdf->AddPage();
            $pdf->SetMargins(20,5);
            if($withlogo=='1'){
                $pdf->Image('../fpdf181/pldt2.png',50,20,300);
            }
            $pdf->SetFont('Times','B',14);
            $pdf->MultiCell(0,10,'CERTFICATE OF EMPLOYMENT AND COMPENSATION',0, 'C');
            $pdf->SetFont('','',12);
            $pdf->Ln(5);
            $pdf->MultiCell(0,5,'Date: November 12, 2019',0,'R');
            $pdf->Ln(5);
            $pdf->MultiCell(0,5,'         This is to certify that LANCE SAN PABLO is a regular employee of PLDT Inc. (formerly "Philippine Long Distance Telephone Company") since November 1, 1994 and presently holds the position of Sr Telecom Associate.',0,'L');
            $pdf->Ln(5);
            $pdf->MultiCell(0,5,'         His present basic monthly salary is P100,000.00.',0,'L');
            $pdf->Ln(5);
            $pdf->MultiCell(0,5,'         Further, he received the following bonuses, premiums and allowances during the twelve-month period:',0,'L');
            $pdf->Ln(10);
            $pdf->MultiCell(0,5,'                     Mid-Year Bonus',0,'L');
            $pdf->MultiCell(0,5,'                     Christmas Bonus/13th Month Pay',0,'L');
            $pdf->MultiCell(0,5,'                     Unused Sick Leave Pay',0,'L');
            $pdf->MultiCell(0,5,'                     Other Earnings  ',0,'L');
            $pdf->MultiCell(0,5,'                     Other Bonuses  ',0,'L');
            $pdf->MultiCell(0,1,'                                                                                                          ____________________',0,'L');
            $pdf->MultiCell(0,5,'                     Total Other Income',0,'L');
            $pdf->Ln(10);
            $pdf->MultiCell(0,5,'         This certification is being issued upon employee\'s request for Visa Application. Visa Application. Visa Application. Visa Application. Visa Application. Visa Application. Visa Application. Visa Application.',0,'L');
            $pdf->Ln(30);


            // eto yung last wag dugtungan. sa taas ka magdagdag.
            $pdf->SetXY(137,107.5);
            $pdf->MultiCell(40,0,'999,999,999.00',0,'R');
            $pdf->SetXY(137,112.5);
            $pdf->MultiCell(40,0,'9,999,999.00',0,'R');
            $pdf->SetXY(137,117.5);
            $pdf->MultiCell(40,0,'999,999.00',0,'R');
            $pdf->SetXY(137,122.5);
            $pdf->MultiCell(40,0,'9,999.00',0,'R');
            $pdf->SetXY(137,127.5);
            $pdf->MultiCell(40,0,'999.00',0,'R');
            $pdf->SetXY(137,135);
            $pdf->MultiCell(40,0,'999,999,999,999.00',0,'R');

            // head
            $pdf->SetXY(111,200);
            $pdf->MultiCell(100,0,'Renelia L. Villanueva',0,'C');
            $pdf->SetXY(111,202);
            $pdf->MultiCell(100,5,'Head',0,'C');
            $pdf->SetXY(111,206);
            $pdf->MultiCell(100,5,'HRIS & Automation',0,'C');

            $pdf->Output("F", "doc_certs/$ref_no.pdf");
            $pdf->Output("");
        }
        else if($type_of_cert=='CECwN'){
            $pdf = new PDF('P', 'mm','Legal');
            $pdf->AddPage();
            $pdf->SetMargins(20,5);
            if($withlogo=='1'){
                $pdf->Image('../fpdf181/pldt2.png',50,20,300);
            }
            $pdf->SetFont('Times','B',14);
            $pdf->MultiCell(0,10,'CERTFICATE OF EMPLOYMENT AND COMPENSATION',0, 'C');
            $pdf->SetFont('','',12);
            $pdf->Ln(5);
            $pdf->MultiCell(0,5,'Date: November 12, 2019',0,'R');
            $pdf->Ln(5);
            $pdf->MultiCell(0,5,'         This is to certify that ROBERTO JOAQUIN ZULUETA is a regular employee of PLDT Inc. (formerly "Philippine Long Distance Telephone Company") since November 1, 1994 and presently holds the position of Sr Telecom Associate.',0,'L');
            $pdf->Ln(5);
            $pdf->MultiCell(0,5,'         His present basic monthly salary is P100,000.00.',0,'L');
            $pdf->Ln(5);
            $pdf->MultiCell(0,5,'         Further, he received the following bonuses, premiums and allowances during the twelve-month period:',0,'L');
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
            $pdf->Ln(60);
            $pdf->MultiCell(0,5,'         SUBSCRIBES AND SWORN to before me, a notary public in and for the City of ____________________ this ____ day of __________________. The affiant, whom I identified through the following competent evidence of identity: Philippine Social Security System number 0391924976, personally signed the foregoing instrument before me and avowed under penalty of law to the whole truth of the contents of said instrument.',0,'L');
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

            $pdf->Output("");
            $pdf->Output("F", "doc_certs/$ref_no.pdf");
        }

    }
?>