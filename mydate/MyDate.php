<?php
/*
#------------------------------------------------------------------------------+
# MyDate 1.1                                                                   |
#------------------------------------------------------------------------------+
# PHP >= 5.5.0, PHP 7
#
#   Copyright 2017 Mailson Ruas
#
# Licensed under the Apache License, Version 2.0 (the "License");
# you may not use this file except in compliance with the License.
# You may obtain a copy of the License at
#
#     http://www.apache.org/licenses/LICENSE-2.0
#
# Unless required by applicable law or agreed to in writing, software
# distributed under the License is distributed on an "AS IS" BASIS,
# WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
# See the License for the specific language governing permissions and
# limitations under the License.
#
#------------------------------------------------------------------------------+
# strtotime                                                                    |
#------------------------------------------------------------------------------+
# O parâmetro informado para essa função deve estar no formato timestamp ISO 8601 (YYYY-MM-DD H:i:s)
#
#------------------------------------------------------------------------------+
# adicional                                                                    |
#------------------------------------------------------------------------------+
# As funções de formatação de datas da classe MyDate aceita como parâmetro, todos os caracteres de formato
# da função date() da biblioteca padrão do PHP, com um adicional, o caracter k (minúsculo).
# k: nome completo do dia da semana sem a palavra "feira".
#    E.: Segunda, Terça, Quarta, Quinta, Sexta, Sábado, Domingo
#
*/
class MyDate{
	//unidades fixas | o mes e o ano variam
	const MINUTO=60;
	const HORA=3600;
	const DIA=86400;
	const SEMANA=604800;
	public function __construct(){
		$this->set_timezone('America/Sao_Paulo');
	}
	public function set_timezone($timezone){//http://php.net/manual/pt_BR/timezones.php
		setlocale(LC_ALL,'pt_BR','pt_BR.iso-8859-1','pt_BR.utf-8','portuguese');
		date_default_timezone_set($timezone);
	}
	private $diasSemana=array(
		'D'=>array('\S\e\g','\T\e\r','\Q\u\a','\Q\u\i','\S\e\x','\S\a\b','\D\o\m'),
		'l'=>array('\S\e\g\u\n\d\a \F\e\i\r\a','\T\e\r\ç\a \F\e\i\r\a','\Q\u\a\r\t\a \F\e\i\r\a','\Q\u\i\n\t\a \F\e\i\r\a','\S\e\x\t\a \F\e\i\r\a','\S\á\b\a\d\o','\D\o\m\i\n\g\o'),
		'k'=>array('\S\e\g\u\n\d\a','\T\e\r\ç\a','\Q\u\a\r\t\a','\Q\u\i\n\t\a','\S\e\x\t\a','\S\á\b\a\d\o','\D\o\m\i\n\g\o')//adicional. A representação textual completa do dia da semana, excluindo 'feira' em dias específicos
	);
	private $meses=array(
		'F'=>array('\J\a\n\e\i\r\o','\F\e\v\e\r\e\i\r\o','\M\a\r\ç\o','\A\b\r\i\l','\M\a\i\o','\J\u\n\h\o','\J\u\l\h\o','\A\g\o\s\t\o','\S\e\t\e\m\b\r\o','\O\u\t\u\b\r\o','\N\o\v\e\m\b\r\o','\D\e\z\e\m\b\r\o'),
		'M'=>array('\J\a\n','\F\e\v','\M\a\r','\A\b\r','\M\a\i','\J\u\n','\J\u\l','\A\g\o','\S\e\t','\O\u\t','\N\o\v','\D\e\z')
	);

	/*
	#--------------------------------------------------------------------------------------------
	# Função formataData
	#--------------------------------------------------------------------------------------------
	# Parâmetros:
	# $formato: segue o padrão do parâmetro format da função date() padrão do PHP (vide manual [http://php.net/manual/pt_BR/function.date.php]).
	# $data: (opcional) unix time stamp -> use a função strtotime. se omitido, será usada a data atual
	#      ex.: $data=new MyDate();
    #           echo $data->formataData('l, d \d\e F \d\e Y', strtotime('2010-10-04'));
    #           Retorno: Segunda Feira, 04 de Outubro de 2010
    #
    # Retorno:
    # string com a data formatada
	*/
	public function formataData($formato,$data=NULL){
		//dia
		if($data==NULL)$data=time();
		if(preg_match_all('/^[D]|[^\\\\][D]/',$formato)){
			$formato=preg_replace('/(^[D])|([^\\\\])([D])/','$2'.$this->diasSemana['D'][date('N',$data)-1],$formato);
		}
		if(preg_match_all('/^[l]|[^\\\\][l]/',$formato)){
			$formato=preg_replace('/(^[l])|([^\\\\])([l])/','$2'.$this->diasSemana['l'][date('N',$data)-1],$formato);
		}
		if(preg_match_all('/^[k]|[^\\\\][k]/',$formato)){
			$formato=preg_replace('/(^[k])|([^\\\\])([k])/','$2'.$this->diasSemana['k'][date('N',$data)-1],$formato);
		}

		//mes
		if(preg_match_all('/^[F]|[^\\\\][F]/',$formato)){
			$formato=preg_replace('/(^[F])|([^\\\\])([F])/','$2'.$this->meses['F'][date('n',$data)-1],$formato);
		}
		if(preg_match_all('/^[M]|[^\\\\][M]/',$formato)){
			$formato=preg_replace('/(^[M])|([^\\\\])([M])/','$2'.$this->meses['M'][date('n',$data)-1],$formato);
		}
		return date($formato,$data);
	}

	/*
	#--------------------------------------------------------------------------------------------
	# Função diferença
	#--------------------------------------------------------------------------------------------
	# Parâmetros:
	# $data1: unix time stamp -> use a função strtotime
	# $data2: (opcional) unix time stamp -> use a função strtotime. se omitido, será utilizado a data atual
	#
	# Retorno:
	# array(
	#     'semanas'=>0,//int
	#     'dias'=>0,//int
	#     'horas'=>0,//int
	#     'minutos'=>0,//int
	#     'segundos'=>0,//int
	#     'passado'=>false //boolean - indica se a data informada no primeiro parametro já passou em relação ao segundo parâmetro, ou em relação a data atual caso o segundo parâmetro seja omitido - true se a data já tiver passado, e false caso contrário
	# )
	#
	*/
	public function diferencaData($data1,$data2=NULL){
		if($data2==NULL)$data2=time();
		$diferenca=$data1-$data2;
		$passado=false;
		if($diferenca<0){
			$diferenca*=-1;
			$passado=true;
		}

		$semanas=floor($diferenca/self::SEMANA);
		$dias=floor(($diferenca%self::SEMANA)/self::DIA);
		$horas=floor(($diferenca%self::DIA)/self::HORA);
		$minutos=floor(($diferenca%self::HORA)/self::MINUTO);
		$segundos=$diferenca%self::MINUTO;

		return array('semanas'=>(int)$semanas,'dias'=>(int)$dias,'horas'=>(int)$horas,'minutos'=>(int)$minutos,'segundos'=>$segundos,'passado'=>$passado);
	}
}
