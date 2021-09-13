
<meta charset="utf-8"/>
<html lang="pt-br">
<html>
	<head>
		<meta content="text/html" http-equiv="content-type">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<title>Jogo da Forca</title>
	</head>

<style type="text/css">
#forca{
	position: absolute;
	left: 130px;
	top: 30px;
}

#letras{
	position: relative;
	height: 100px;
	width: 100px;
}

#letrasclicadas{
	position: relative;
	width:75px;
	height:75px;
	top: -320px;
	left: 300px;
}

</style>

	<body>

<?
  
  // Aplicação implementa um simples jogo de forca, contendo um dicionario de palavras, "palavras.txt" de onde se extrai aleatoriamente uma palavra que deverá ser descoberta pelo jogador, mediante "chutes". Quando o usuário informa um caracter que exista na palavra, o mesmo é exibido, se errar o jogador é lentamente levado à forca, se errar 6 caracteres o enforcamento se completa, com a morte do jogador.  
    
  // String contendo os caracteres para selecionar
  $caracteres='ABCDEFGHIJKLMNOPQRSTUVWXYZ';


$diretoria = "img/"; // esta linha não precisas é só um exemplo do conteudo que a variável vai ter

// selecionar só .jpg
$imagens = glob($diretoria . "*.png");



/*echo "Lista de Arquivos do diretório '<strong>".$path."</strong>':<br />";
while($arquivo = $diretorio -> read()){
echo "<img src='".$path.$arquivo."'></a><br />";
}
$diretorio -> close();*/


    /*
     * Descricao: Obtendo os parametros
     */
    if(isset($_REQUEST["opcao"]))
      $opcao=$_REQUEST["opcao"];
    if(isset($_REQUEST["erros"]))
	  $erros=$_REQUEST["erros"];
    if(isset($_REQUEST["letra"]))
  	  $letra=$_REQUEST["letra"];
    if(isset($_REQUEST["linha_escolhida"]))
  	  $linha_escolhida=$_REQUEST["linha_escolhida"];
    if(isset($_REQUEST["digitadas"]))
	  $digitadas=$_REQUEST["digitadas"];

	/* 
     * Descricao: nova variavel para contabilizar letras encontradas quando
	 * acertos = numero de letras da palavra jogador venceu
	 */
    if(isset($_REQUEST["acertos"]))
	  $acertos=$_REQUEST["acertos"];

	/* 
     * Descricao: Variavel configura auto start ou link para novo jogo
	 * quando jogador venceu ou morreu
	 */
     $ifWinneAutoStart=true;
	 $ifDeathAutoStart=true;
  
  echo '<div id="forca">
';

  // Se nada foi selecionado entrada então conduzo para o inicio
  if(empty($opcao))
  {
    $opcao='envia';
	$erros=-1;

	/* 
     * Descricao:  Inicializando variavel acertos
	 */
	$acertos=0;
  }

  if($opcao=='envia')
  {
    // Buscando palavras no arquivo de palavras
	$arquivo  = file("palavras.txt");
    // Caso o jogo ja tenha iniciado, utilize sempre a mesma linha do arquivo
	if(!empty($linha_escolhida))	
	  $linha= $arquivo[$linha_escolhida];
	else
	{
      // Se o jogo é novo leia o numero de linhas e selecione pelo rand uma delas
	  $linhas   = count($arquivo);  
      // Selecionando uma linha
      $linha_escolhida  = rand(0, $linhas-1);
      $linha= $arquivo[$linha_escolhida];
	}  

    // Procurando caracter separador "#" que separa a palavra de sua dica 
	$pos=strpos($linha,'#');

    // Dismembrando palavra e dica em variaveis distintas
    $palavra=substr($linha,0,$pos);
    $dica=substr($linha,$pos+1,strlen($linha));
		$MSM = $palavra;
		echo $MSM;

	// Armazenando os caracteres informados, para controles de links e exibiçao na palavra
	$digitadas=$digitadas.$letra;

	// Substituindo caracteres que ja foram informados, pelos proprios, caracteres ainda não informados pelos caracteres "_" ou " "
    // Liberar flag conta erros
	$contar_erros=true;
    for($i=0;$i<strlen($palavra);$i++)
    {
	   // Se letra informada existir na palavra travar flag conta erros


	   /* 
	    * Descricao:  Criado bloco de execucao e adicionado incrementacao do contador de acertos
		*/
	   if($palavra[$i]==$letra)
	   {
		   $contar_erros=false;
		   $acertos++;
	   }	   
	   // Travar flag marca letras digitadas
	   $marcar=false;
	   for($j=0;$j<strlen($digitadas);$j++)
	   { 
	     // Se a letra da palavra já foi informada liberar flag marca letras digitadas
		 if ($palavra[$i]==$digitadas[$j])
		   $marcar=true;
       }
       // Se a letra ja foi digitada então mostre-a
	   if ($marcar==true)
		   echo $palavra[$i];
       else
	   {
         // Se existir espaco em branco substituir por espaco em branco
		 if ($palavra[$i]==' ')
	       echo '&nbsp;&nbsp;';
  	     // Senao substituir por "_"
		 else
	       echo '_ ';
	   }       
	}
	// Se a letra informada não existe na palavra entao incrementar erro
	if($contar_erros==true)
		$erros++;

    // Exibindo dica
	echo '
<br>
'.$dica.'<BR>
';

    // Exibindo a forca
	echo '<img src="forca'.$erros.'.jpg" alt="Saddan Hussein">
<br>
';
  }


   /* 
    * Descricao:  Verificando se o jogador venceu
	*
	* Descricao: Removendo caracteres branco para testar se o jogo terminou: str_replace(' ', '', $palavra)
	*            ocorria erro caso existissem espacos em branco na palavra.
	*/ 

   if($acertos==strlen(str_replace(' ', '', $palavra)))
   {
	  /*
	   * Descricao:  Iniciando novo jogo conforme configuracao
	   * pode ser autostart por javascript ou entao por clique em link
	   */
	  if($ifWinneAutoStart)		  
	  { 
	  	echo "<font color='green'> PARABENS! VOCE GANHOU, JOGUE NOVAMENTE CLICANDO EM NOVO JOGO </font> <br><br>";
	  	  echo '<a href="forca.php?opcao=envia&amp;erros=-1&amp;acertos=0" class="btn btn-success">Novo Jogo</a>
';
  echo '</center>
';

?>

<!-- ALERT QUANDO VOCÊ GANHA
		 <SCRIPT LANGUAGE="JavaScript">
            alert('Desta vez você escapou!\n\nTem coragem para encarar novamente?')-->
			<!--
				function redirect()
				{ 
					window.location = "forca.php";
				}
				setTimeout("redirect();", 10);
			//
		</SCRIPT>-->
<?		  
	  }      
      else
	  {
	     echo '<FONT SIZE="4" COLOR="blue" face="Tahoma"><B>Desta vez você venceu, vai encarar a morte novamente?</b></font>
<br>
';
         echo '<a href="forca.php?opcao=envia&erros=-1&acertos=0">[Novo Jogo]</a>
';
         echo '
';
	     exit;
	  }
   }

  if($erros<6)
  // Se o numero de erros for menor do que 6 ainda temos chance de vencer
  {
    echo '<FONT SIZE="-1" COLOR="red" face="Tahoma">Para jogar selecione abaixo o caracter desejado ...<br></FONT>
</><br>
';
	for($i=0;$i<26;$i++)
    {
      // Destravando flag que controla "linkagem" ou nao dos caracteres
	  $ja_foi=false;
	  for($j=0;$j<strlen($digitadas);$j++)
	  {
         // Se o caracter já foi digitado entao trave o flag
		 if ($caracteres[$i]==$digitadas[$j])
          $ja_foi = true;
	  }
      // Caracter ja foi digitado, somente exibi-lo, sem link
	  if($ja_foi==true)
        echo "<img id='letrasclicadas' src='".$imagens[$i]."'>".'&nbsp;&nbsp;&nbsp;
';
      else
        // Caracter ainda nao foi informado exibir com link

	    /* 
	     * Descricao:  Adicionado o parametro acertos no link
	     */
        /*CODIGO MOSTRANDO APENAS LETRAS

        echo '<a href="forca.php?opcao=envia&amp;letra='.$caracteres[$i].'&amp;linha_escolhida='.$linha_escolhida.'&amp;digitadas='.$digitadas.'&amp;erros='.$erros.'&amp;acertos='.$acertos.'">'.$caracteres[$i].'</a>&nbsp;&nbsp;&nbsp;';*/


        /* CODIGO MOSTRANDO IMAGENS NO LUGAR DAS LETRAS */

				echo '<a href="forca.php?opcao=envia&amp;letra='.$caracteres[$i].'&amp;linha_escolhida='.$linha_escolhida.'&amp;digitadas='.$digitadas.'&amp;erros='.$erros.'&amp;acertos='.$acertos.'">'.'<img id="letras" src='.$imagens[$i].'></a>&nbsp;&nbsp;&nbsp';
        
  
    }
    echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
';


  }

  // Se o numero de erros for maior ou igual a 6 You DIE...
  else
  {
     /* 
	  * Descricao:  Iniciando novo jogo conforme configuracao
	  * pode ser autostart por javascript ou entao por clique em link
	  */
	 if($ifDeathAutoStart)
	 { 
	  echo "<font color='red'> VOCE PERDEU, A PALAVRA CORRETA E: <font color='blue'> $MSM </font> <BR> TENTE NOVAMENTE CLICANDO EM NOVO JOGO! </font> <br><br>";
?>
		<!-- ALERT NA TELA QUANDO PERDER

		<SCRIPT LANGUAGE="JavaScript">
            alert('Você morreu!\n\nDeseja jogar novamente?')-->
			<!--
				function redirect()
				{ 
					window.location = "forca.php";
				}
				setTimeout("redirect();", 10);
			//
		</SCRIPT>-->
<?	
	 }
	 else
	 {
		echo '<FONT SIZE="4" COLOR="red" face="Tahoma"><B>Você Morreu!!</B></font>
<br>
';
	 }
  }
  // Opcao para iniciar novo jogo
  /* 
   * Descricao:  Adicionado o parametro acertos no link
   */
  echo '<a href="forca.php?opcao=envia&amp;erros=-1&amp;acertos=0" class="btn btn-success">Novo Jogo</a>
';
  echo '</center>
';
?>

	<br><br>
	

	</body>
</html>