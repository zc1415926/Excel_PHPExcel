<?php
header ( "Content-Type:text/html; charset=UTF-8" );
ini_set('display_errors', false);

// process the xls file
/**
 * Include path *
 */
set_include_path ( get_include_path () . PATH_SEPARATOR . '/home/zc1415926/www/excel/Classes/' );

/**
 * PHPExcel_IOFactory
 */
include 'PHPExcel/IOFactory.php';

/**
 * Define a Read Filter class implementing PHPExcel_Reader_IReadFilter
 */
class chunkReadFilter implements PHPExcel_Reader_IReadFilter {
	private $_startRow = 0;
	private $_endRow = 0;
		
	/**
	 * We expect a list of the rows that we want to read to be passed into the constructor
	 */
	public function __construct($startRow, $chunkSize) {
		$this->_startRow = $startRow;
		$this->_endRow = $startRow + $chunkSize;
	}
	public function readCell($column, $row, $worksheetName = '') {
		// Only read the heading row, and the rows that were configured in the constructor
		if (($row == 1) || ($row >= $this->_startRow && $row < $this->_endRow)) {
			return true;
		}
		return false;
	}
}

if(isset($_POST["rowsOfHead"]) && isset($_POST["rowsOfContent"]))
{
	$resultArray = array();
	$numOfRowsToSkip=$_POST["rowsOfHead"];// = 1;
	$numOfRowsToRead=$_POST["rowsOfContent"];// = 2;
	
	combineExcels($numOfRowsToSkip, $numOfRowsToRead);
}





function combineExcels($numOfRowsToSkip, $numOfRowsToRead)
{

echo "<ul>";
$dirPath = 'uploads/';
//echo $dirPath;

if (! ($handle = opendir ( $dirPath ))) {
	die ( "不能打开文件夹！" );
}

while ( $file = readdir ( $handle ) ) {
	if ($file != "." && $file != "..") {
		echo "<li>$file</li>";
		
		$inputFileType = 'Excel5';
		// $inputFileType = 'Excel2007';
		// $inputFileType = 'Excel2003XML';
		// $inputFileType = 'OOCalc';
		// $inputFileType = 'Gnumeric';
		$inputFileName = './uploads/'.$file; // './sampleData/example2.xls';
		

		
		
		
		
		//echo 'Loading file ', pathinfo ( $inputFileName, PATHINFO_BASENAME ), ' using IOFactory with a defined reader type of ', $inputFileType, '<br />';
		/**
		 * Create a new Reader of the type defined in $inputFileType *
		 */
		$objReader = PHPExcel_IOFactory::createReader ( $inputFileType );
		
//		echo '<hr />';
		
		/**
		 * Define how many rows we want for each "chunk" *
		 */
		$chunkSize = 20;
		
		/**
		 * Loop to read our worksheet in "chunk size" blocks *
		 */
		for($startRow = 2; $startRow <= 3; $startRow += $chunkSize) {
			//echo 'Loading WorkSheet using configurable filter for headings row 1 and for rows ', $startRow, ' to ', ($startRow + $chunkSize - 1), '<br />';
			/**
			 * Create a new Instance of our Read Filter, passing in the limits on which rows we want to read *
			 */
			$chunkFilter = new chunkReadFilter ( $startRow, $chunkSize );
			/**
			 * Tell the Reader that we want to use the new Read Filter that we've just Instantiated *
			 */
			$objReader->setReadFilter ( $chunkFilter );
			/**
			 * Load only the rows that match our filter from $inputFileName to a PHPExcel Object *
			 */
			$objPHPExcel = $objReader->load ( $inputFileName );
			
			// Do some processing here
			
			$sheetData = $objPHPExcel->getActiveSheet ()->toArray ( null, true, true, true );
			//var_dump ( $sheetData [1] );
			//echo '<br /><br />';
			//print_r ( $sheetData [2] );
			//echo $numOfRowsToRead;
			//$sheetData = null;
			//for($startRow = 2; $startRow <= 3; $startRow += $chunkSize) {
			for($i = 1 + $numOfRowsToSkip; $i <= $numOfRowsToRead + $numOfRowsToSkip; $i++)
			{
				//print_r($i);
				//print_r($sheetData [$i]);
				//echo "<br>!!!!<br>";
				//print_r($sheetData[$i]);
				//echo "<br>";
				$resultArray[] = $sheetData [$i];
			}
		
			
		
		}
	}
}
//print_r($sheetData);
echo "</ul>";

//关闭文件夹句柄
closedir ( $handle );


//释放变量，释放内存
$objPHPExcel->disconnectWorksheets();
unset($objPHPExcel);
//print_r($resultArray);


//create a $resultPHPExcel
$resultPHPExcel = new PHPExcel();
//add a worksheet
$resultWorksheet = new PHPExcel_Worksheet($resultPHPExcel, "Result");
$resultPHPExcel->addSheet($resultWorksheet, 0);
$resultPHPExcel->setActiveSheetIndex(0);

//!!!yo an array begin from 0

//echo "<br>haha<br>";
//print_r($resultArray);
//echo "<br>haha<br>";
//print_r($resultArray[1]);
//echo "<br>haha<br>";

//set cell by loop
$numOfRows = count($resultArray);
//echo "numOfRows: ".$numOfRows."<br>";

$nameOfLastCol = $_POST["nameOfLastCol"];

//echo $nameOfLastCol[0];
//echo "<br>";
//echo $nameOfLastCol[1];
//echo "<br>";
$numOfLastCol =  (ord($nameOfLastCol[0])-65+1)*26 + ord($nameOfLastCol[1])-65+1;
//echo $numOfLastCol;
//echo "!!<br>";

$numOfColumns = $numOfLastCol;//count($resultArray[0]);
//echo $numOfColumns."<br>";
//print_r($resultArray[0]);
$timesOfColBy26 = 0;

//first param is column, begin with 0, second is row, begin with 1, 
for($row = 1; $row <= $numOfRows; $row++)
{
	for ($col = 1; $col <= $numOfColumns; $col++)
	{
		//echo (int)($col / (26 - 1)) . "<br>";//因为从0开始的, 得数为小数
		$timesOfColBy26 = (int)($col / (26+0.5));//试出来的+0.5，如果-1就少一位，如果+1就多一位，+0.5刚好
		//echo $timesOfColBy26 . "<br>";
		//if($timesOfColBy26 == 0)
		if(1<=$col && $col<=26)
		{
			$resultPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col-1, $row, $resultArray[$row-1][chr(65+$col-1)]);
			//echo chr(65+$col-1). "<br>";//上边是从1开始的，下边是从0开始的，所以到了下边就要减1
		}
		else //只能应对两位字母表示的列数
		{
	
			$resultPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow($col-1, $row, $resultArray[$row-1][chr(65 + $timesOfColBy26-1).chr($col-1 - 26*$timesOfColBy26 + 65)]);
			//echo chr(65 + $timesOfColBy26-1).chr($col-1 - 26*$timesOfColBy26 + 65) . "<br>";//不减1就从B开始了,弄不清楚要不要减一了，试一试就知道了
	
			
		}
	}
}

//echo '<br>AAAAAAAAAAAAAAA<br>';
//echo ord('A');





$resultWriter = PHPExcel_IOFactory::createWriter($resultPHPExcel, 'Excel5');
//$resultWriter->save('php://output');
$resultWriter->save('./result/result.xls');


echo "<a href='./result/result.xls'>合并完成，点击下载<a>"; 

//exit;
}
?>
