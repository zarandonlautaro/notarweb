<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);//funcion encargada de convertir los links dentro de un texto en enlaces html
//funcion encargada de convertir los links dentro de un texto en enlaces html
function make_clickable($text) { 
    $regex = '#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#'; 
    return preg_replace_callback($regex, function ($matches) { 
     return "<a target=\"_blank\" href='{$matches[0]}\'>{$matches[0]}</a></br>"; 
    }, $text); 
} 
//funcion para eliminar archivos
function filedelete($id,$namefile){
    $sql2 = MySQLDB::getInstance()->query("DELETE FROM  files WHERE id='$id'");
	$rutaImg="../coursefiles/" .$namefile;
                            if($sql2){
								unlink($rutaImg);
								return true;
                            }else{false;}
	}
						

function curl_get_file_contents($URL)
    {
        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_URL, $URL);
        $contents = curl_exec($c);
        curl_close($c);

        if ($contents) return $contents;
        else return FALSE;
	}
	


	function limpia_espacios($cadena){

	$cadena = str_replace(' ', '', $cadena);
	return $cadena;
  }
  function extension($fileName){

  $fileNameCmps = explode("/", $fileName);//creamos un array con las palabras separadas por '/'
  $fileExtension = strtolower(end($fileNameCmps));//strtolower — Convierte una cadena a minúsculas ,end devuelve el ultimo valor de un array
  
  return $fileExtension;
  }
	
	function isNull($nombre, $user, $pass, $pass_con, $email){
		if(strlen(trim($nombre)) < 1 || strlen(trim($user)) < 1 || strlen(trim($pass)) < 1 || strlen(trim($pass_con)) < 1 || strlen(trim($email)) < 1)
		{
			return true;
			} else {
			return false;
		}		
	}
	
	function isEmail($email)
	{
		if (filter_var($email, FILTER_VALIDATE_EMAIL)){
			return true;
			} else {
			return false;
		}
	}
	function longitudPass($pass){
		if(strlen(trim($pass)) >=7){
			return true;
		}else{
			return false;
		}
	}
	function validaPassword($var1, $var2)
	{
		if (strcmp($var1, $var2)==0){
			return true;
			} else {
			return false;
		}
	}
	
	function minMax($min, $max, $valor){
		if(strlen(trim($valor)) < $min)
		{
			return true;
		}
		else if(strlen(trim($valor)) > $max)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	

	function generateToken()
	{
		$gen = md5(uniqid(mt_rand(), false));	
		return $gen;
	}
	

	
	function resultBlock($msgs,$tipo){
		if(count($msgs) > 0)
		{
			if($tipo==1){
				$color='alert-success';
			}else{
				$color='alert-warning';
			}

			echo ('<div id="alert" class=" col-sm-12  alert alert-dismissible fade show mb-4 '.$color.' role="alert">
			<strong>Información:</strong>
			<ul>');
			foreach($msgs as $msg)
			{
				echo '<li>'.$msg.'</li>';
			}
			echo '</ul>';

			echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
			</div>';
			
		}
	}
	

	
	function isNullLogin($usuario, $password){
		if(strlen(trim($usuario)) < 1 || strlen(trim($password)) < 1)
		{
			return true;
		}
		else
		{
			return false;
		}		
	}

	function generaTokenPass($user_id)
	{
		
		$token = generateToken();
		$sql=MySQLDB::getInstance()->query("SELECT * FROM recover WHERE idusr = '$user_id'");
		if($sql->num_rows==1){
		$check = MySQLDB::getInstance()->query("UPDATE recover SET token_password='$token', password_request=1,last_modification=NOW() WHERE idusr = '$user_id'");
		}else{

		$check = MySQLDB::getInstance()->query("INSERT INTO recover (idusr,token_password, password_request, last_modification) VALUES ('$user_id','$token',1,NOW())");
		 echo "cantidad de filas afectadas :".$check->num_rows;
		}
				
		
		return $token;

	}
	
	// function getValor($campo, $campoWhere, $valor)
	// {
	// 	global $mysqli;
		
	// 	$stmt = $mysqli->prepare("SELECT $campo FROM usuarios WHERE $campoWhere = ? LIMIT 1");
	// 	$stmt->bind_param('s', $valor);
	// 	$stmt->execute();
	// 	$stmt->store_result();
	// 	$num = $stmt->num_rows;
		
	// 	if ($num > 0)
	// 	{
	// 		$stmt->bind_result($_campo);
	// 		$stmt->fetch();
	// 		return $_campo;
	// 	}
	// 	else
	// 	{
	// 		return null;	
	// 	}
	// }
	
	// function getPasswordRequest($id)
	// {
	// 	global $mysqli;
		
	// 	$stmt = $mysqli->prepare("SELECT password_request FROM usuarios WHERE id = ?");
	// 	$stmt->bind_param('i', $id);
	// 	$stmt->execute();
	// 	$stmt->bind_result($_id);
	// 	$stmt->fetch();
		
	// 	if ($_id == 1)
	// 	{
	// 		return true;
	// 	}
	// 	else
	// 	{
	// 		return null;	
	// 	}
	// }
	
	// function verificaTokenPass($user_id, $token){
		
	// 	global $mysqli;
		
	// 	$stmt = $mysqli->prepare("SELECT activacion FROM usuarios WHERE id = ? AND token_password = ? AND password_request = 1 LIMIT 1");
	// 	$stmt->bind_param('is', $user_id, $token);
	// 	$stmt->execute();
	// 	$stmt->store_result();
	// 	$num = $stmt->num_rows;
		
	// 	if ($num > 0)
	// 	{
	// 		$stmt->bind_result($activacion);
	// 		$stmt->fetch();
	// 		if($activacion == 1)
	// 		{
	// 			return true;
	// 		}
	// 		else 
	// 		{
	// 			return false;
	// 		}
	// 	}
	// 	else
	// 	{
	// 		return false;	
	// 	}
	// }
	
	// function cambiaPassword($password, $user_id, $token){
		
	// 	global $mysqli;
		
	// 	$stmt = $mysqli->prepare("UPDATE usuarios SET password = ?, token_password='', password_request=0 WHERE id = ? AND token_password = ?");
	// 	$stmt->bind_param('sis', $password, $user_id, $token);
		
	// 	if($stmt->execute()){
	// 		return true;
	// 		} else {
	// 		return false;		
	// 	}
	// }

		// function usuarioExiste($usuario)
	// {
	// 	global $mysqli;
		
	// 	$stmt = $mysqli->prepare("SELECT id FROM usuarios WHERE usuario = ? LIMIT 1");
	// 	$stmt->bind_param("s", $usuario);
	// 	$stmt->execute();
	// 	$stmt->store_result();
	// 	$num = $stmt->num_rows;
	// 	$stmt->close();
		
	// 	if ($num > 0){
	// 		return true;
	// 		} else {
	// 		return false;
	// 	}
	// }
	
	// function emailExiste($email)
	// {
	// 	global $mysqli;
		
	// 	$stmt = $mysqli->prepare("SELECT id FROM usuarios WHERE correo = ? LIMIT 1");
	// 	$stmt->bind_param("s", $email);
	// 	$stmt->execute();
	// 	$stmt->store_result();
	// 	$num = $stmt->num_rows;
	// 	$stmt->close();
		
	// 	if ($num > 0){
	// 		return true;
	// 		} else {
	// 		return false;	
	// 	}
	// }
		
	// function login($usuario, $password)
	// {
	// 	global $mysqli;
		
	// 	$stmt = $mysqli->prepare("SELECT id, id_tipo, password FROM usuarios WHERE usuario = ? || correo = ? LIMIT 1");
	// 	$stmt->bind_param("ss", $usuario, $usuario);
	// 	$stmt->execute();
	// 	$stmt->store_result();
	// 	$rows = $stmt->num_rows;
		
	// 	if($rows > 0) {
			
	// 		if(isActivo($usuario)){
				
	// 			$stmt->bind_result($id, $id_tipo, $passwd);
	// 			$stmt->fetch();
				
	// 			$validaPassw = password_verify($password, $passwd);
				
	// 			if($validaPassw){
					
	// 				lastSession($id);
	// 				$_SESSION['id_usuario'] = $id;
	// 				$_SESSION['tipo_usuario'] = $id_tipo;
					
	// 				header("location: welcome.php");
	// 				} else {
					
	// 				$errors = "La contrase&ntilde;a es incorrecta";
	// 			}
	// 			} else {
	// 			$errors = 'El usuario no esta activo';
	// 		}
	// 		} else {
	// 		$errors = "El nombre de usuario o correo electr&oacute;nico no existe";
	// 	}
	// 	return $errors;
	// }
	
	// function lastSession($id)
	// {
	// 	global $mysqli;
		
	// 	$stmt = $mysqli->prepare("UPDATE usuarios SET last_session=NOW(), token_password='', password_request=0 WHERE id = ?");
	// 	$stmt->bind_param('s', $id);
	// 	$stmt->execute();
	// 	$stmt->close();
	// }
	
	// function isActivo($usuario)
	// {
	// 	global $mysqli;
		
	// 	$stmt = $mysqli->prepare("SELECT activacion FROM usuarios WHERE usuario = ? || correo = ? LIMIT 1");
	// 	$stmt->bind_param('ss', $usuario, $usuario);
	// 	$stmt->execute();
	// 	$stmt->bind_result($activacion);
	// 	$stmt->fetch();
		
	// 	if ($activacion == 1)
	// 	{
	// 		return true;
	// 	}
	// 	else
	// 	{
	// 		return false;	
	// 	}
	// }	
		// function registraUsuario($usuario, $pass_hash, $nombre, $email, $activo, $token, $tipo_usuario){
		
	// 	global $mysqli;
		
	// 	$stmt = $mysqli->prepare("INSERT INTO usuarios (usuario, password, nombre, correo, activacion, token, id_tipo) VALUES(?,?,?,?,?,?,?)");
	// 	$stmt->bind_param('ssssisi', $usuario, $pass_hash, $nombre, $email, $activo, $token, $tipo_usuario);
		
	// 	if ($stmt->execute()){
	// 		return $mysqli->insert_id;
	// 		} else {
	// 		return 0;	
	// 	}		
	// }
	
	// function enviarEmail($email, $nombre, $asunto, $cuerpo){
		
	// 	require_once 'PHPMailer/PHPMailerAutoload.php';
		
	// 	$mail = new PHPMailer();
	// 	$mail->isSMTP();
	// 	$mail->SMTPAuth = true;
	// 	$mail->SMTPSecure = 'tipo de seguridad'; //Modificar
	// 	$mail->Host = 'dominio'; //Modificar
	// 	$mail->Port = puerto; //Modificar
		
	// 	$mail->Username = 'correo emisor'; //Modificar
	// 	$mail->Password = 'password de correo emisor'; //Modificar
		
	// 	$mail->setFrom('correo emisor', 'nombre de correo emisor'); //Modificar
	// 	$mail->addAddress($email, $nombre);
		
	// 	$mail->Subject = $asunto;
	// 	$mail->Body    = $cuerpo;
	// 	$mail->IsHTML(true);
		
	// 	if($mail->send())
	// 	return true;
	// 	else
	// 	return false;
	// }
	
	// function validaIdToken($id, $token){
	// 	global $mysqli;
		
	// 	$stmt = $mysqli->prepare("SELECT activacion FROM usuarios WHERE id = ? AND token = ? LIMIT 1");
	// 	$stmt->bind_param("is", $id, $token);
	// 	$stmt->execute();
	// 	$stmt->store_result();
	// 	$rows = $stmt->num_rows;
		
	// 	if($rows > 0) {
	// 		$stmt->bind_result($activacion);
	// 		$stmt->fetch();
			
	// 		if($activacion == 1){
	// 			$msg = "La cuenta ya se activo anteriormente.";
	// 			} else {
	// 			if(activarUsuario($id)){
	// 				$msg = 'Cuenta activada.';
	// 				} else {
	// 				$msg = 'Error al Activar Cuenta';
	// 			}
	// 		}
	// 		} else {
	// 		$msg = 'No existe el registro para activar.';
	// 	}
	// 	return $msg;
	// }
	
	// function activarUsuario($id)
	// {
	// 	global $mysqli;
		
	// 	$stmt = $mysqli->prepare("UPDATE usuarios SET activacion=1 WHERE id = ?");
	// 	$stmt->bind_param('s', $id);
	// 	$result = $stmt->execute();
	// 	$stmt->close();
	// 	return $result;
		
	// }
?>