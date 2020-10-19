<?php


function buscaAnos($dados) {
	$anos = $dados[4];
	unset($anos['A']);
	unset($anos['B']);
	unset($anos['C']);
	unset($anos['D']);
	return array_values($anos);
}

function buscaPaises($dados) {
	$paises = array_slice($dados, 4, count($dados) - 4);
	$paisesNovos = array();

	$pais = 0;
	foreach ($paises as $key => $value) {
		$dado = 0;
		foreach ($value as $paisDados) {
			$paisesNovos[$pais][$dado] = $paisDados;
			$dado++;
		}
		$pais++;
	}

	return $paisesNovos;
}