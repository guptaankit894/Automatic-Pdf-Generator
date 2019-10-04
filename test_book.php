<?php
require "fpdf/fpdf.php";
$read_file=fopen('test.csv',"r");

////////Data Procesing
$key=array();
$count=0;
$key1=array();

while(($line = fgetcsv($read_file,','))!=false){
	if(!empty($line[1])){
	
	$count++;	
	$output=array();
	if($count==1){
		$lin= array_shift($line);
		$key=$line;
		continue;
	}
	
	else{
		$lin= array_shift($line);		
		array_push($output,$line);				
	}
	
	array_push($key1,$output);
	
	}	
		
	
}
///////pdf generation
class pdf extends FPDF
{	
	function Header()
{
    // Select Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(80);
    // Framed title
    //$this->Cell(30,10,'Title',1,0,'C');
    // Line break
    $this->Ln(15);
}
function Footer()
{
    // Go to 1.5 cm from bottom
    $this->SetY(-15);
    // Select Arial italic 8
    $this->SetFont('Arial','I',8);
    // Print centered page number
    $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
}

	function addEntry($key1,$key)
	{			
		$this->SetFont('Times','B','10');	
		//$this->Cell(40,30,$b,15);
		$this->SetXY(10,35);		
		for($i=0;$i<sizeof($key1);$i++){
				
			foreach(array_combine($key,$key1[$i][0]) as $key2=>$value2){					
					
					$this->SetX(35);
					$this->SetFont('Times','B','10');
					$this->Cell(47,6,$key2,0,'L');
					$this->SetFont('Times','','10');
					if($key2!="Inventors Name:"){
						
					$value2=ucfirst(strtolower($value2));
					$this->MultiCell(100,6,$value2,0,'J');
					}
					else{
					$this->MultiCell(100,6,$value2,0,'J');
					}	
				
				}				
				$this->Ln();
				$this->Ln();				
				}				
			//$this->AddPage();	
		}
		
	}
$pdf = new PDF();
$pdf->SetFont('Times','','10');
//$pdf->SetMargins(5,10,5);
$pdf->AddPage('P','A4');
$pdf->Header();
$pdf->addEntry($key1,$key);
$pdf->Footer();
$pdf->Output('test.pdf','F');




?>