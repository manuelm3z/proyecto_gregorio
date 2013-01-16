<?php
/*
*Clase que se encarga de gestionar los usuarios del software
* además de las interfaces
*/
require('settings.php');
include('representante.php');
require('alumno.php');
class Usuario{
	public $login;
	public $fechaRegistro;
	private $clave;
	public $mensaje;
	public $tituloVentana;
	public $datos;

	function __construct(){
		$this->datos = new mysqli(server, user, pass, bd);
		$this->titulo();
		if(!isset($_SESSION['login'])){
			if (!empty($_POST['login'])) {
				$this->login=($_POST['login']);
				$this->clave=($_POST['clave']);
				$this->iniciarSession();
			}
		}
		if(!empty($_GET['m'])){
			if($_GET['m'] == "u"){
				if(!empty($_POST['login'])){
					$login = $_POST['login'];
				}
				if(!empty($_POST['clave'])){
					$clave = $_POST['clave'];
				}
				if(!empty($_POST['boton'])){
					$boton = $_POST['boton'];
					switch ($boton) {
						case 'Registrar':
							$this->registrarUsuario($login, $clave);
							break;

						case 'Modificar':
							$this->modificarUsuario($login, $clave);
							break;

						case 'Eliminar':
							$this->borrarUsuario($login);
							break;

						default:
							# code...
							break;
					}
				}
			}
		}
	}
	//Se encargad de iniciar la sesion de usuario
	private function iniciarSession(){
		$datos = $this->datos;
		$select = "select login, clave  from usuario where login='{$this->login}' and estado ='1'";
		$consulta = $datos->query($select);
		if($datos->affected_rows>0){
			$_SESSION['login']=$this->login;
			$this->mensaje = "Sesion iniciada";
		}else{
			$this->mensaje = "No pudo iniciar sesion";
		}
	}
	//se encarga de finazlizar la sesion de usuario
	public function cerrarSession(){
		session_start();
		session_destroy();
		header ("Location: ".nombre);
	}
	//registra los  nuevos usuarios
	private function registrarUsuario($login, $clave){
		$datos = $this->datos;
		$buscarU = "select * from usuario where login='{$login}' and estado='1'";
		$consulta = $datos->query($buscarU);
		if($datos->affected_rows>0){
			$this->mensaje = "Usuario ya existe";
		}else{
			$buscarU = "select * from usuario where login='{$login}' and estado='0'";
			$consulta = $datos->query($buscarU);
			if($datos->affected_rows>0){
				$updateU = "update usuario set estado='1', clave='{$clave}' where login='{$login}'";
				$this->mensaje = "Usuario registrado con exito";
			}else{
				$insertU = "insert into usuario values(null, '{$login}', '{$clave}', curdate(), 1)";
				if($datos->query($insertU)){
					$this->mensaje = "Usuario registrado con exito";
				}else{
					$this->mensaje = "Ocurrió un problema registrando al usuario";
				}
			}
		}
	}
	//realiza la busqueda de usuarios en base de datos
	private function buscarUsuario(){
		$datos = $this->datos;
		$selectU="select * from usuario where estado='1'";
		$consulta=$datos->query($selectU);
		if($datos->affected_rows>0){
			echo "<table class='resultado'>
			      <tr>
                  <th> Codigo </th>
                  <th> Login </th>
                  <th> Fecha de Registro </th>
                  </tr>";
            while($valores = $consulta->fetch_assoc()){
               echo "<tr>
                     <td> {$valores['idUsuario']} </td>
                     <td> {$valores['login']} </td>
                     <td> {$valores['fechaRegistro']} </td>
                     </tr>";
                  }
                  echo "</table>";
         }else{
            echo "<table class='resultado'>
                  <tr>
                  <th><h2>No hay resultados</h2></th>
                </tr>";
         }
   	}
   	//Deshabilita los usuarios en base de datos
   	private function borrarUsuario($login){
   		$datos = $this->datos;
   		$deleteU="update usuario set estado='0' where login='{$login}'";
      	if($datos->query($deleteU)){
      		$this->mensaje = "Usuario Eliminado";
      	}else{
      		$this->mensaje = "Ocurrió un problema";
      	}
   	}
   	//Modifica los usuarios de base de datos
   	private function modificarUsuario($login, $clave){
   		$datos = $this->datos;
   		$updateU="update usuario set clave='{$clave}' where login='{$login}'";
   		if($datos->query($updateU)){
   			$this->mensaje = "Password cambiada";
   		}else{
   			$this->mensaje = "Ocurrió un problema";
   		}
   	}
	public function accesoUsuario(){
		if(isset($_SESSION['login'])){
			if($_SESSION['login']=="admin"){
				echo $_SESSION['login']."
				<a href='".nombre."'>Inicio</a>
				<a href='".nombre."/?m=r'>Representantes</a>
				<a href='".nombre."/?m=i'>Inscripción</a>
				<a href='".nombre."/?m=a'>Alumnos</a>
				<a href='".nombre."/?m=u'>Usuarios</a>
				<a href='".nombre."/?m=s'>Sobre</a>
				<a href='".nombre."/cerrar.php'>Cerrar Sesión</a>";
			}else{
				echo $_SESSION['login']."
				<a href='".nombre."'>Inicio</a>
				<a href='".nombre."/?m=r'>Representantes</a>
				<a href='".nombre."/?m=i'>Inscripción</a>
				<a href='".nombre."/?m=a'>Alumnos</a>
				<a href='".nombre."/?m=s'>Sobre</a>
				<a href='".nombre."/cerrar.php'>Cerrar Sesión</a>";
			}
        }else{
        	echo "<a href='".nombre."'>Sesión no iniciada</a>";
        } 
	}
	public function titulo(){
		$modulo=null;
		if(!empty($_GET['m'])){
			$modulo=$_GET['m'];
		}
		switch ($modulo) {
			case '':
				$this->tituloVentana = "Inicio";
				break;

			case 'r':
				$this->tituloVentana = "Registro de Representantes";
				break;

			case 'i':
				$this->tituloVentana = "Inscripción de Alumnos";
				break;

			case 'a':
				$this->tituloVentana = "Busqueda de Alumnos";
				break;

			case 'u':
				$this->tituloVentana = "Usuarios del Sistema";
				break;
			
			case 's':
				$this->tituloVentana = "Sobre";
				break;
			
			default:
				# code...
				break;
		}
	}
	public function contenidoUsuario(){
		$modulo=null;
		if(!empty($_GET['m'])){
			$modulo=$_GET['m'];
		}
		switch ($modulo) {
			case '':
				$this->inicio();
				break;

			case 'r':
				$this->registro();
				break;

			case 'i':
				$this->inscripcion();
				break;

			case 'a':
				$this->alumnos();
				break;

			case 'u':
				$this->usuarios();
				break;
			
			case 's':
				$this->sobre();
				break;
			
			default:
				$this->perfiles();
				break;
		}
	}
	private function inicio(){
		if(isset($_SESSION['login'])){
			if($_SESSION['login']=="admin"){
				echo "Bienvenido ".$_SESSION['login'];
			}else{
				echo "Bienvenido ".$_SESSION['login'];
			}
		}else{
			echo "<form class='login' method='post' action=''>
					<b>Inicia sesion:</b><br>
					Login: <input type='text' name='login'><br>
					Clave: <input type='password' name='clave'><br>
					<p>{$this->mensaje}</p>
					<input type='submit' name='loguearse' value='Loguearse'>
				  </form>";
		}
	}
	private function registro(){
		if(isset($_SESSION['login'])){
			$datos = $this->datos;
			$representante = new Representante($datos);
				echo "<form class='incripcion' method='post' action='".nombre."/?m=r'>
						<h2>Datos del Representante</h2>
						<label>Codigo: {$representante->idRepresentante}</label><br>
						<input type='text' name='nombresRepresentante' placeholder='Nombres' value='{$representante->nombresRepresentante}'><br>
						<input type='text' name='apellidosRepresentante' placeholder='Apellidos' value='{$representante->apellidosRepresentante}'><br>
						<input type='text' name='cedulaRepresentante' placeholder='Cedula' value='{$representante->cedulaRepresentante}'><br>
						<input type='text' name='telefono' placeholder='Telefono' value='{$representante->telefono}'><br>
						<input type='text' name='oficio' placeholder='Oficio' value='{$representante->oficio}'><br>
						<input type='date' name='fechaNacimientoR' placeholder='Fecha de Nacimiento' value='{$representante->fechaNacimientoR}'><br>
						<label>{$representante->result}</label><br>
						<input type='submit' name='boton' value='Registrar'>
						<input type='submit' name='boton' value='Buscar'>
						<input type='submit' name='boton' value='Borrar'>
						<input type='submit' name='boton' value='Modificar'><br>
					  </form>";
		}else{
			echo "No tienes permiso para estar acá, primero logueate";
		}
	}
	private function inscripcion(){
		if(isset($_SESSION['login'])){
			$datos = $this->datos;
			$alumno = new Alumno($datos);
			echo "<form class='incripcion' method='post' action='".nombre."/?m=i'>
					<h2>Datos del Alumno</h2>
					<label>Codigo:{$alumno->idAlumno}</label><br>
					<input type='text' name='idRepresentante' placeholder='Codigo o Cedula de Representante' value='{$alumno->idRepresentante}' required><br>
					<input type='text' name='nombresAlumno' placeholder='Nombres' value='{$alumno->nombresAlumno}' required><br>
					<input type='text' name='apellidosAlumno' placeholder='Apellidos' value='{$alumno->apellidosAlumno}' required><br>
					<input type='text' name='cedulaAlumno' placeholder='Cedula' value='{$alumno->cedulaAlumno}'><br>
					<input type='date' name='fechaNacimientoA' placeholder='Fecha de Nacimiento' value='{$alumno->fechaNacimientoA}' required><br>
					<input type='text' name='lugarNacimiento' placeholder='Lugar de Nacimiento' value='{$alumno->lugarNacimiento}' required><br>
					<input type='text' name='estatura' placeholder='Estatura(cm)' value='{$alumno->estatura}' required><br>
					<input type='text' name='peso' placeholder='Peso' value='{$alumno->peso}' required><br>
					<input type='text' name='tCamisa' placeholder='Talla de Camisa' value='{$alumno->tCamisa}' required><br>
					<input type='text' name='tPantalon' placeholder='Talla de Pantalon' value='{$alumno->tPantalon}' required><br>
					<input type='text' name='tZapatos' placeholder='Talla de Zapato' value='{$alumno->tZapatos}' required><br>
					<input type='textarea' name='observacion' placeholder='Observaci&oacute;n' value='{$alumno->observacion}'><br>
					<label>{$alumno->result}</label><br>
					<input type= 'submit' name='boton' value='Inscribir'><br>
				  </form>";
		}
	}
	private function alumnos(){
		if(isset($_SESSION['login'])){
			$datos = $this->datos;
			$alumno = new Alumno($datos);
		}else{
			echo "No tienes permiso para estar acá, primero logueate";
		}
	}
	private function usuarios(){
		if(isset($_SESSION['login'])){
			if($_SESSION['login']=="admin"){
				echo "<form class='incripcion' method='post' action='".nombre."/?m=u'>
						<h2>Bienvenido a modulo de usuarios {$_SESSION['login']}</h2><br>
						Login: <input type='text' name='login'><br>
						Clave: <input type='password' name='clave'><br>
						<label>{$this->mensaje}</label><br>
						<input type='submit' name='boton' value='Registrar'>
						<input type='submit' name='boton' value='Modificar'>
						<input type='submit' name='boton' value='Eliminar'>
					  </form>";
				$this->buscarUsuario();
			}else{
				echo "No tienes permiso para estar acá ".$_SESSION['login'];
			}
		}else{
			echo "No tienes permiso para estar acá, primero logueate";
		}
	}
	private function sobre(){
		echo '<p>La unidad educativa "Amparo Manroy Power" fue fundada en el año 1937, zona rural para la epoca, lo que hace presumir que los escolares atendidos eran mayormente hijos de canpesinos y parceleros que se ocupaban de laborer agricolas.</p>
		      <p>Somos una intitucion que busca consolidar las areas de formacion pedagogica, social y comunitaria, tomando en cuenta los principios democraticos y humanitario a traves de actores directos e indirectos, planificando proyecto de interes coletivo y futurista.</p>
		      <p>Tienes como misión brindar atención educativa a los niños de la zona aledañas con el proposito de incrementar sus oportunidades, de mejorar su calidad de vida y reducir los indices de exclución.</p>
		      <p>Atendiendo a un criterio de formacion integral, contribuimos a la formación de la cultura participativa, a traves de su conexion con las experesiones: con la junta de vecinos, clubes deportivos, colectivos comunales y asambleas populares.</p>
		      <p>En marcado en el proceso de tecnologización nos hemos propuesto a avanzar en la consolidación de una aula audiovisual, asi como promover la participación en las diferentes areas o actividades culturales y deportivas que se desarrollen en el ámbito deportivo cultural.</p>
		      <p>Nuestra maxima, materializar el penzamiento de Don Simón Rodriguez "encaminar todos los esfuerzos por conseguir el bienestar no del individuo aislado sino de la colectividad organizada en la sociedad"</p>
		      <p>MISION: En la Unidad Educativa "Amparo Monroy Power", tiene como propósito garantizar a través de los niveles educativos iniciales y primarios el desarrollo del potencial humano de los niños, niñas y adolescentes, basado en la formación de los valores para la convivencias, independencia, la libertad, la emancipación, la valoración y defensa de la soberania, paz y justicia social, respeto a los derechos humanos, las practicas de la equidad y la inclusión, con identidad nacional y lealtad a la patria, formando ciudadanos para la vida.</p>
		      <p>VISION: La unidad educativa "Amparo Manroy Power" sera reconocida por ser una institución orientanda al desarrollo del potencial del niño, niña y adolecente propiciada a la democracia parcitipativa y protagonista la responsabilidad social, igualdad humana, la paz, el respeto a los derechos humanos, con sentido de potencial humanista, capaces de tranformarlas a la realidad.</p>';
	}
	private function perfiles(){
		$datos = $this->datos;
		$alumno = new Alumno($datos);
	}
}
?>