# MyData

# Função formataData
<pre>
Parâmetros:<br>
 $formato: segue o padrão do parâmetro format da função date() padrão do PHP<br>
 (vide manual [http://php.net/manual/pt_BR/function.date.php]).<br>
 $data: (opcional) unix time stamp -> use a função strtotime. se omitido, será usada a data atual<br>
       ex.: $data=new MyData();<br>
             echo $data->formataData('l, d \d\e F \d\e Y', strtotime('2010-10-04'));<br>
             Retorno: Segunda Feira, 04 de Outubro de 2010<br>
Retorno:<br>
 string com a data formatada<br>
</pre>

# Função diferença
<pre>
Parâmetros:
	$data1: unix time stamp -> use a função strtotime
	$data2: (opcional) unix time stamp -> use a função strtotime. se omitido, será utilizado a data atual
Retorno:
	array(
	    'semanas'=>0,//int
	    'dias'=>0,//int
	    'horas'=>0,//int
	    'minutos'=>0,//int
	    'segundos'=>0,//int
	    'passado'=>false //boolean - indica se a data informada no primeiro parametro já passou em relação ao segundo parâmetro, ou em relação a data atual caso o segundo parâmetro seja omitido - true se a data já tiver passado, e false caso contrário
	)
</pre>
