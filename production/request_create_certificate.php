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
        $date_prepared2= date('F j, Y');
        $start_time= $_POST["start_time"];
        $purpose = $_POST["purpose"];
        $type_of_cert = $_POST["type_of_cert"];
        // $ref_no = $_POST["ref_no"];
        $confsalary = $_POST["confsalary"];
        $head_signatory = $_POST["head_signatory"];
        $withsignature = $_POST["withsignature"];
        $withlogo = $_POST["withlogo"];

        $signatory = $conn -> prepare("SELECT * FROM signatory WHERE sign_id IN ('$head_signatory')");
        $signatory -> execute();
        $signatory_res = $signatory ->fetchAll();

        $emp_coe = $conn2->prepare("SELECT *, DATENAME(MM, [Date Hired]) + RIGHT(CONVERT(VARCHAR(12), [Date Hired], 107), 9) AS DateHired2, DATENAME(MM, [Date Separated]) + RIGHT(CONVERT(VARCHAR(12), [Date Separated], 107), 9) AS DateSeparated2
            , FORMAT(Salary, 'N', 'en-us') AS Salary2 FROM [HRISData].[dbo].[vw_coe_employee] as tbl1 WHERE IDNo LIKE ('$persno')");
        $emp_coe -> execute();
        $emp_coe_res = $emp_coe->fetchAll();

        $emp_cec = $conn2->prepare("SELECT *, DATENAME(MM, [Date Hired]) + RIGHT(CONVERT(VARCHAR(12), [Date Hired], 107), 9) AS DateHired2 
                                    , FORMAT(Salary, 'N', 'en-us') AS Salary2
                                    , FORMAT(ChristmasBon, 'N', 'en-us') AS ChristmasBon2
                                    , FORMAT(LNGVTPY, 'N', 'en-us') AS LNGVTPY2
                                    , FORMAT(MIDYRBON, 'N', 'en-us') AS MIDYRBON2
                                    , FORMAT(Allowance, 'N', 'en-us') AS Allowance2
                                    , FORMAT(USLP, 'N', 'en-us') AS USLP2
                                    , FORMAT(OtherBon, 'N', 'en-us') AS OtherBon2
                                    , FORMAT(Total, 'N', 'en-us') AS Total2



                                    FROM [HRISData].[dbo].[vw_certificate] as tbl1 WHERE emp_id LIKE ('$persno')");
        $emp_cec -> execute();
        $emp_cec_res = $emp_cec->fetchAll();

            // temp refno creator
            $create_refno = $conn->prepare("SELECT COUNT(*) as totalcert FROM prepared_certificates");
            $create_refno ->execute();
            $create_refno_res = $create_refno->fetchAll();

            foreach($create_refno_res as $row){                
                $refno_sum=$row['totalcert']+1;
                $ref_no = "RF_".$refno_sum;
                $create_cert_que = $conn->prepare("INSERT INTO prepared_certificates (ref_no, date_prepared, emp_id, purpose, req_date, req_status) VALUES ('$ref_no', '$date_prepared', '$persno','$purpose', '$start_time', 0)");
                if (!$create_cert_que->execute()) {
                    echo 'error';
                }
                else{
                    header('Location: request.php?emp_id='.$persno.'&start_time='.$start_time.'');
                }
            // 

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
                $this->Ln(8);
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
            foreach($emp_coe_res as $x){
                $emp_id = $x["IDNo"];
                $emp_name = $x["Name"];
                $emp_datehired = $x["DateHired2"];
                $emp_dateseparated  = $x["DateSeparated2"];
                $emp_designation = $x["Official Title"];
                $emp_presentorg = $x["org"];
                $emp_sssnum = $x["sss_no"];
                $emp_hdmfnum = $x["HDMF"];
                $emp_basicsal = $x["Salary2"];

                $pdf = new PDF('P', 'mm', 'Letter');
                $pdf->AddPage();
                $pdf->SetMargins(30,5);
                if($withlogo=='1'){
                    $pdf->Image('../fpdf181/pldt2.png',50,20,300);
                }
                $pdf->SetFont('Times','B',14);
                $pdf->SetFont('','',12);
                
                $pdf->Ln(5);
                $pdf->MultiCell(0,5," $date_prepared2",0,'R');
                
                $pdf->Ln(5);
                $pdf->MultiCell(0,5," $ref_no",0,'R');
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
                $pdf->MultiCell(0,5,'BASIC MONTHLY SALARY:',0,'L');
                $pdf->Ln(5);
                if($purpose == 'SSS Claims/Pension'){
                    $pdf->MultiCell(0,5,'SSS NUMBER:',0,'L');
                }
                else if ($purpose == 'HDMF(Loan/Maturity)'){
                    $pdf->MultiCell(0,5,'HDMF NUMBER:',0,'L');
                }
                else{

                }
                $pdf->Ln(10);
                $pdf->SetFont('Times');
                if($purpose == 'SSS Claims/Pension'){
                    $pdf->MultiCell(0,5,'         This certification is issued upon employee\'s request for SSS purposes.',0,'L');
                }
                else if($purpose == 'HDMF(Loan/Maturity)'){
                    $pdf->MultiCell(0,5,'         This certification is issued upon employee\'s request for HDMF purposes.',0,'L');
                }
                else{
                    $pdf->MultiCell(0,5,"         This certification is issued upon employee's request for $purpose purposes.",0,'L');
                }
                $pdf->Ln(30);   

                // eto yung last wag dugtungan. sa taas ka magdagdag.
                $pdf->SetFont('Times','B',12);
                $pdf->SetXY(100,107);
                $pdf->MultiCell(50,0,"$emp_id",0,'L');
                $pdf->SetXY(100,117);
                $pdf->MultiCell(100,0,"$emp_name",0,'L');
                $pdf->SetXY(100,127);
                $pdf->MultiCell(100,0,"$emp_datehired",0,'L');
                $pdf->SetXY(100,137);
                $pdf->MultiCell(100,0,"$emp_dateseparated",0,'L');
                $pdf->SetXY(100,147);
                $pdf->MultiCell(100,0,"$emp_designation",0,'L');
                $pdf->SetXY(100,157);
                $pdf->MultiCell(100,0,"$emp_presentorg",0,'L');
                $pdf->SetXY(100,167);
                if($confsalary == 1){
                    $pdf->MultiCell(70,0,'Confidential',0,'L');
                }
                else{
                    $pdf->MultiCell(70,0,"P $emp_basicsal",0,'L');
                }

                $pdf->SetXY(100,177);
                if($purpose == 'SSS Claims/Pension'){
                    $pdf->MultiCell(70,0,"$emp_sssnum",0,'L');
                }
                else if($purpose == 'HDMF(Loan/Maturity)'){
                    $pdf->MultiCell(70,0,"$emp_hdmfnum",0,'L');
                }
                else{

                }

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
                if($purpose == 'SSS Claims/Pension' || $purpose == 'HDMF(Loan/Maturity)'){
                    $pdf->MultiCell(84,0,'_______________________________________________________________________________________',0,'L');
                }
                else{

                }

                // head of hris
                foreach($signatory_res as $sign){
                    $sign_name = $sign["signatory"];
                    $sign_desig = $sign["designation"];
                    $sign_org = $sign["organization"];

                    $pdf->SetFont('Times');
                    $pdf->SetXY(111,224);
                    $pdf->MultiCell(100,5,"$sign_name",0,'C');
                    $pdf->SetXY(111,228);
                    $pdf->MultiCell(100,5,"$sign_desig",0,'C');
                    $pdf->SetXY(111,232);
                    $pdf->MultiCell(100,5,"$sign_org",0,'C');
                }
                $pdf->Output();
                $pdf->Output("F", "doc_certs/$ref_no.pdf");
            }
        }
        else if($type_of_cert=='CEC'){
            foreach($emp_cec_res as $x){
                $emp_id = $x["emp_id"];
                $emp_fname = $x["Firstname"];
                $emp_mname = $x["Middlename"];
                $emp_lname = $x["Surname"];
                $emp_suffix = $x ["Suffix"];
                $emp_datehired = $x["DateHired2"];
                $emp_designation = $x["Official Title"];
                $emp_basicsal = $x["Salary2"];
                $emp_sex = $x["Sex"];
                $emp_xmasbon = $x["ChristmasBon2"];
                $emp_mdyrbon = $x["MIDYRBON2"];
                $emp_uslp = $x["USLP2"];
                $emp_otherearn = $x["Allowance2"];
                $emp_otherbon = $x["OtherBon2"];
                $emp_total = $x["Total2"];

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
                $pdf->MultiCell(0,5,"Date: $date_prepared2",0,'R');
                $pdf->Ln(5);
                $pdf->MultiCell(0,5,"         This is to certify that $emp_fname $emp_lname $emp_suffix is a regular employee of PLDT Inc. (formerly \"Philippine Long Distance Telephone Company\") since $emp_datehired and presently holds the position of $emp_designation.",0,'L');
                $pdf->Ln(5);
                if($emp_sex == 'M'){
                    $pdf->MultiCell(0,5,"         His present basic monthly salary is P $emp_basicsal.",0,'L');
                    $pdf->Ln(5);
                    $pdf->MultiCell(0,5,'         Further, he received the following bonuses, premiums and allowances during the twelve-month period:',0,'L');
                }
                else{
                    $pdf->MultiCell(0,5,"         Her present basic monthly salary is P $emp_basicsal.",0,'L');
                    $pdf->Ln(5);
                    $pdf->MultiCell(0,5,'         Further, she received the following bonuses, premiums and allowances during the twelve-month period:',0,'L');
                }
                $pdf->Ln(10);
                $pdf->MultiCell(0,5,'                     Mid-Year Bonus',0,'L');
                $pdf->MultiCell(0,5,'                     Christmas Bonus/13th Month Pay',0,'L');
                $pdf->MultiCell(0,5,'                     Unused Sick Leave Pay',0,'L');
                $pdf->MultiCell(0,5,'                     Other Earnings  ',0,'L');
                $pdf->MultiCell(0,5,'                     Other Bonuses  ',0,'L');
                $pdf->MultiCell(0,1,'                                                                                                          ____________________',0,'L');
                $pdf->MultiCell(0,5,'                     Total Other Income',0,'L');
                $pdf->Ln(10);
                $pdf->MultiCell(0,5,"         This certification is being issued upon employee's request for $purpose.",0,'L');
                $pdf->Ln(120);
                $pdf->MultiCell(0,5,"$ref_no",0,'L');
    
    
                // eto yung last wag dugtungan. sa taas ka magdagdag.
                $pdf->SetXY(137,107.5);
                $pdf->MultiCell(40,0,"$emp_mdyrbon",0,'R');
                $pdf->SetXY(137,112.5);
                $pdf->MultiCell(40,0,"$emp_xmasbon",0,'R');
                $pdf->SetXY(137,117.5);
                $pdf->MultiCell(40,0,"$emp_uslp",0,'R');
                $pdf->SetXY(137,122.5);
                $pdf->MultiCell(40,0,"$emp_otherearn",0,'R');
                $pdf->SetXY(137,127.5);
                $pdf->MultiCell(40,0,"$emp_otherbon",0,'R');
                $pdf->SetXY(137,135);
                $pdf->MultiCell(40,0,"P $emp_total",0,'R');
    
                // head
                foreach($signatory_res as $sign){
                    $sign_name = $sign["signatory"];
                    $sign_desig = $sign["designation"];
                    $sign_org = $sign["organization"];

                    $pdf->SetXY(111,200);
                    $pdf->MultiCell(100,5,"$sign_name",0,'C');
                    $pdf->SetXY(111,204);
                    $pdf->MultiCell(100,5,"$sign_desig",0,'C');
                    $pdf->SetXY(111,208);
                    $pdf->MultiCell(100,5,"$sign_org",0,'C');
                }
    
                $pdf->Output("F", "doc_certs/$ref_no.pdf");
                $pdf->Output();
            }
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
            $pdf->MultiCell(0,5,'         This certification is being issued upon employee\'s request for Visa Application.',0,'L');
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
            $pdf->Ln(49);
            $pdf->MultiCell(0,5,'eHR-201235',0,'L');

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
            $pdf->Output("F", "doc_certs/$ref_no.pdf");
        }
            }
    }
?>