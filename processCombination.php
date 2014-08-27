<?php
header ( "Content-Type:text/html; charset=UTF-8" );
//ini_set ( 'display_errors', false );

// process the xls file

/**
 * Include path *
 */
set_include_path ( get_include_path () . PATH_SEPARATOR . '/home/zc1415926/www/excel/Classes/' );

include 'PHPExcel/IOFactory.php';

/**
 * Define a Read Filter class implementing PHPExcel_Reader_IReadFilter
 */
class chunkReadFilter implements PHPExcel_Reader_IReadFilter
{
	private $_startRow = 0;
	private $_endRow = 0;
	
	/**
	 * We expect a list of the rows that we want to read to be passed into the constructor
	 */
	public function __construct($startRow, $chunkSize)
	{
		$this->_startRow = $startRow;
		$this->_endRow = $startRow + $chunkSize;
	}
	public function readCell($column, $row, $worksheetName = '')
	{
		// Only read the heading row, and the rows that were configured in the constructor
		if (($row == 1) || ($row >= $this->_startRow && $row < $this->_endRow))
		{
			return true;
		}
		return false;
	}
}

// 通过$_POST的值判断用户是将数据提交到该页面来是直接输入地址进入的该页面
if (isset ( $_POST ["rowsOfHead"] ) && isset ( $_POST ["rowsOfContent"] ))
{
	// 把从xls文件中读取的信息放入$resultArray中，等待写入新的xls文件中
	$resultArray = array ();
	$numOfRowsToSkip = $_POST ["rowsOfHead"];
	$numOfRowsToRead = $_POST ["rowsOfContent"];
	// 执行表格合并操作
	combineExcels ( $numOfRowsToSkip, $numOfRowsToRead );
} else
{
	echo "对不起，您不能直接访问此页面！";
}

// 表格合并函数，参数为每个xls文件要路过的行数（即表头有几行），和每个xls文件要取几行内容
function combineExcels($numOfRowsToSkip, $numOfRowsToRead)
{
	//xls文件路径，即文件上传时的目的路径
	$dirPath = 'uploads/';
	
	if (! ($handle = opendir ( $dirPath )))
	{
		die ( "不能打开文件夹！" );
	}
	
	
	// 用来计算，表格合成完成了百分之几
	//表格内文件总数，*2是为了读取完成时，进度只完成一半，写入完成时，进度完成另一半
	$numOfFiles = (count ( scandir ( $dirPath ) ) - 2)+1;
	$currNumOfFiles = 0;
	$percentFinish = 0;
	
	//当文件夹内还有文件时
	while ( $file = readdir ( $handle ) )
	{
		//！！！！且文件不是“.”和“..”
		if ($file != "." && $file != "..")
		{
			$inputFileType = 'Excel5';
			$inputFileName = './uploads/' . $file; 
			                                       

			$objReader = PHPExcel_IOFactory::createReader ( $inputFileType );


			/*$chunkSize = 20;
			

			for($startRow = 2; $startRow <= 3; $startRow += $chunkSize)
			{


				$objReader->setReadFilter ( $chunkFilter );

				$objPHPExcel = $objReader->load ( $inputFileName );
				
				// Do some processing here
				//一个xls文件读取完成，数据放入$sheetData中，使用var_dump ($sheetData);或print_r ($sheetData [2]);来查看
				$sheetData = $objPHPExcel->getActiveSheet ()->toArray ( null, true, true, true );

				//$sheetData中有很多无用的数据，只选取几行需要的，存入$resultArray中
				for($i = 1 + $numOfRowsToSkip; $i <= $numOfRowsToRead + $numOfRowsToSkip; $i ++)
				{
					$resultArray [] = $sheetData [$i];
				}
			}*/
			
			$objReader->setReadDataOnly(true);
			$objPHPExcel = $objReader->load($inputFileName);
			//一个xls文件读取完成，数据放入$sheetData中，使用var_dump ($sheetData);或print_r ($sheetData [2]);来查看
			$sheetData = $objPHPExcel->getActiveSheet ()->toArray ( null, true, true, true );
			
			//$sheetData中有很多无用的数据，只选取几行需要的，存入$resultArray中
			for($i = 1 + $numOfRowsToSkip; $i <= $numOfRowsToRead + $numOfRowsToSkip; $i ++)
			{
			$resultArray [] = $sheetData [$i];
			}
			
			//var_dump($resultArray);
			
			// 读文件时“，”.和“..”都算一个文件，要注意把它们排除掉（用上一层的if语句）
			$currNumOfFiles++;// +=(1 *6);
			
			$percentFinish = round ( $currNumOfFiles / $numOfFiles * 100 );
			writeLog ( $percentFinish );
			//echo print_r(count($sheetData)."<br>");
			unlink($inputFileName);
		}
	}
	

	

	// 关闭文件夹句柄
	closedir ( $handle );
	
	// 释放变量，释放内存
	$objPHPExcel->disconnectWorksheets ();
	unset ( $objPHPExcel );-
	
	// create a $resultPHPExcel
	$resultPHPExcel = new PHPExcel ();
	// add a worksheet
	$resultWorksheet = new PHPExcel_Worksheet ( $resultPHPExcel, "Result" );
	$resultPHPExcel->addSheet ( $resultWorksheet, 0 );
	$resultPHPExcel->setActiveSheetIndex ( 0 );
	// !!!yo an array begin from 0
	// set cell by loop
	$numOfRows = count ( $resultArray );
	$nameOfLastCol = array();
	$nameOfLastCol = strtoupper($_POST ["nameOfLastCol"]);
	
	if(strlen($nameOfLastCol)>1)
	{
		$numOfLastCol = (ord ( $nameOfLastCol [0] ) - 65 + 1) * 26 + ord ( $nameOfLastCol [1] ) - 65 + 1;
		//echo '$numOfLastCol';
		//echo $numOfLastCol;
	}
	else 
	{ 
		
		$numOfLastCol = ord ( $nameOfLastCol [0] ) - 65 + 1;
	}
	
	$numOfColumns = $numOfLastCol; 
	$timesOfColBy26 = 0;
	//echo $currNumOfFiles ."\n";
	//echo $numOfFiles ."\n";
	
	// first param is column, begin with 0, second is row, begin with 1,
	for($row = 1; $row <= $numOfRows; $row ++)
	{
		
		for($col = 1; $col <= $numOfColumns; $col ++)
		{
			// echo (int)($col / (26 - 1)) . "<br>";//因为从0开始的, 得数为小数
			$timesOfColBy26 = ( int ) ($col / (26 + 0.5)); // 试出来的+0.5，如果-1就少一位，如果+1就多一位，+0.5刚好
			                                               // echo $timesOfColBy26 . "<br>";
			                                               // if($timesOfColBy26 == 0)
			if (1 <= $col && $col <= 26)
			{
				$resultPHPExcel->getActiveSheet ()->setCellValueExplicitByColumnAndRow ( $col - 1, $row, $resultArray [$row - 1] [chr ( 65 + $col - 1 )] );
				// echo chr(65+$col-1). "<br>";//上边是从1开始的，下边是从0开始的，所以到了下边就要减1
			} else // 只能应对两位字母表示的列数
			{
				
				$resultPHPExcel->getActiveSheet ()->setCellValueExplicitByColumnAndRow ( $col - 1, $row, $resultArray [$row - 1] [chr ( 65 + $timesOfColBy26 - 1 ) . chr ( $col - 1 - 26 * $timesOfColBy26 + 65 )] );
				// echo chr(65 + $timesOfColBy26-1).chr($col-1 - 26*$timesOfColBy26 + 65) . "<br>";//不减1就从B开始了,弄不清楚要不要减一了，试一试就知道了
			}
		}
		//写到第几行，就占最后一份的几分之一，和前边读文件的算法不太一样
		$currNumOfFiles += 1/$numOfRows;
		//echo $currNumOfFiles ."\n";
		$percentFinish = round ( $currNumOfFiles / $numOfFiles * 100 );
		//echo $percentFinish ."\n";
		writeLog ( $percentFinish );
		
	}
	//print_r($resultPHPExcel->getActiveSheet ()->toArray ( null, true, true, true ));
	$resultWriter = PHPExcel_IOFactory::createWriter ( $resultPHPExcel, 'Excel5' );
	$resultWriter->save ( './result/result.xls' );
	
	//echo "<a class='btn btn-large btn-danger' href='./result/result.xls'>合并完成，点击下载<a>";

}

function writeLog($prarm)
{
	$file = "logs/log.log";
	// $content = date("Y-m-d H:i:s =>") .$prarm. "\n" ;
	$content = $prarm . "\n";
	$fileHandle = file_put_contents ( $file, $content ); // , FILE_APPEND);
}
?>