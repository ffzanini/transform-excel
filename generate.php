<?php
require_once 'libraries/phpexcel/Classes/PHPExcel.php';
require_once 'libraries/phpexcel/Classes/PHPExcel/IOFactory.php';

require_once 'functions.php';

$nomeArquivo = $_FILES['arquivo']['tmp_name'];

$objPHPExcel = new PHPExcel();

$objReader = new PHPExcel_Reader_Excel5();
$objReader->setReadDataOnly(true);
$objPHPExcel = $objReader->load($nomeArquivo);
$objPHPExcel->setActiveSheetIndex(0);

$dados = $objPHPExcel->getActiveSheet()->toArray(null, true,true,true);

$anos = buscaAnos($dados);
$paises = buscaPaises($dados);

$dadosFormatados = array(array(
	'country',
	'year',
	'iso',
	'indicator_name',
	'indicator_code',
	'estimate'
));

foreach ($paises as $pais) {
	foreach ($anos as $key => $ano) {
		$linhaAno = 4 + $key;

		$dadosFormatados[] = array(
			$pais[0],
			$ano,
			$pais[1],
			$pais[2],
			$pais[3],
			$pais[$linhaAno]
		);
	}
}

$doc = new PHPExcel();
$doc->setActiveSheetIndex(0);

$doc->getActiveSheet()->fromArray($dadosFormatados, null, 'A1');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="formatted-'.$_FILES['arquivo']['name'].'"');
header('Cache-Control: max-age=0');

// Do your stuff here
$writer = PHPExcel_IOFactory::createWriter($doc, 'Excel5');

$writer->save('php://output');