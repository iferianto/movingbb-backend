<?php


class MYPDF extends TCPDF {

	//Separated Header Drawing into it's own function for reuse.
    public function DrawHeader($header, $w) {
        // Colors, line width and bold font
        // Header
        $this->SetFillColor(0, 150, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B');        
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
			$width=(isset($w[$i])?$w[$i]:100);
            $this->Cell($width, 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 255, 200);
        $this->SetTextColor(0);
        $this->SetFont('');
    }

    // Colored table
    public function ColoredTable($header,$w,$alx,$data) {        
        $this->DrawHeader($header, $w);

        // Data
        $fill = 0;
        foreach($data as $row) {
            //Get current number of pages.
            $num_pages = $this->getNumPages();
            //$this->startTransaction();
			foreach($w as $cid=>$wd){
				list($k,$d)=each($row);
				$al=(isset($alx[$cid])?$alx[$cid]:'LR');
				$d=trim(str_replace(array("\r","\n"),"",$d));				
				$this->Cell($wd, 6, $d, 'LR', 0, $al, $fill);
			}
            $this->Ln();
            //$this->commitTransaction();
            
            $fill=!$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}


?>