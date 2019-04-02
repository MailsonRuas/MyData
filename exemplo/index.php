<?php
/*
#------------------------------------------------------------------------------+
# Exemplos de uso - MyDate                                                     |
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
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Exemplos</title>
		<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
		<style>
			h3{
				font-family: 'Lato', sans-serif;
				font-weight: normal;
				font-size: 1.4rem;
				margin: 30px 0 6px 0;
			}
		</style>
	</head>
	<body>
		<?php
			require_once '../mydate/MyDate.php';
			$data=new MyDate();//instancia de um objeto da classe MyDate

			// Exemplos de uso

			// definir timezone de acordo com a sua localidade. Não é obrigatório definir o timezone, mas se não definir será usado o valor padrão (America/Sao_Paulo)
			$data->set_timezone('America/Sao_Paulo');

			// exemplo de uma data formatada, somando um ano e duas horas a data e hora atuais
			echo '<h3>Exemplo 1</h3><p>data formatada, somando um ano e duas horas a data e hora atuais</p>';
			echo '<pre>$data->formataData(\'l, d \d\e F \d\e Y. H:i:s\',strtotime(\'+ 1 year + 2 hour\'))</pre>';
			echo $data->formataData('l, d \d\e F \d\e Y. H:i:s',strtotime('+ 1 year + 2 hour'));

			// exemplo de uma data formatada
			echo '<h3>Exemplo 2</h3><p>data formatada</p>';
			echo '<pre>$data->formataData(\'D. d \d\e M. \d\e Y\',strtotime(\'2017-07-13\'))</pre>';
			echo $data->formataData('D. d \d\e M. \d\e Y',strtotime('2017-07-13'));

			// exemplo de uma data formatada, sem o segundo parâmetro, é usada a data atual
			echo '<h3>Exemplo 3</h3><p>data formatada, sem o segundo par&acirc;metro, &eacute; usada a data atual</p>';
			echo '<pre>$data->formataData(\'k. d \d\e F. \d\e Y H:i:s\')</pre>';
			echo $data->formataData('k. d \d\e F. \d\e Y H:i:s');

			// exemplo de cálculo de diferença entre uma data informada no primeiro parâmetro e a data atual
			echo '<h3>Exemplo 4</h3><p>c&aacute;lculo de diferen&ccedil;a entre uma data informada e a data atual</p>';
			echo '<pre>$d=$data->diferencaData(strtotime(\'2017-07-11 00:00:00\'));</pre>';
			$d=$data->diferencaData(strtotime('2017-07-11 00:00:00'));
			echo '<pre>';
			print_r($d);
			echo '</pre>';

			print_r($data->diferencaData(strtotime('2017-09-04 00:00:00'),strtotime('2017-08-04 00:00:00')));
		?>
	</body>
</html>