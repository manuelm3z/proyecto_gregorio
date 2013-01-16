<?php
/*
*Clase encargada del registro de alumnos
*/
class Alumno{
   public $idAlumno;
   public $nombresAlumno;
   public $apellidosAlumno;
   public $cedulaAlumno;
   public $fechaNacimientoA;
   public $lugarNacimiento;
   public $estatura;
   public $peso;
   public $tCamisa;
   public $tPantalon;
   public $tZapatos;
   public $observacion;
   public $idRepresentante;
   public $result;
   private $id;
   
   function __construct($datos){
      if(!empty($_GET['m'])){
         $this->id = $_GET['m'];
      }
      if(!empty($_POST['boton'])){
         if(!empty($_POST['idRepresentante'])){
            $this->idRepresentante = $_POST['idRepresentante'];
         }
         if(!empty($_POST['nombresAlumno'])){
            $this->nombresAlumno = $_POST['nombresAlumno'];
         }
         if(!empty($_POST['apellidosAlumno'])){
            $this->apellidosAlumno = $_POST['apellidosAlumno'];
         }
         if(!empty($_POST['cedulaAlumno'])){
            $this->cedulaAlumno = $_POST['cedulaAlumno'];
         }
         if(!empty($_POST['fechaNacimientoA'])){
            $this->fechaNacimientoA = $_POST['fechaNacimientoA'];
         }
         if(!empty($_POST['lugarNacimiento'])){
            $this->lugarNacimiento = $_POST['lugarNacimiento'];
         }
         if(!empty($_POST['estatura'])){
            $this->estatura = $_POST['estatura'];
         }
         if(!empty($_POST['peso'])){
            $this->peso = $_POST['peso'];
         }
         if(!empty($_POST['tCamisa'])){
            $this->tCamisa = $_POST['tCamisa'];
         }
         if(!empty($_POST['tPantalon'])){
            $this->tPantalon = $_POST['tPantalon'];
         }
         if(!empty($_POST['tZapatos'])){
            $this->tZapatos = $_POST['tZapatos'];
         }
         if(!empty($_POST['observacion'])){
            $this->observacion = $_POST['observacion'];
         }
         $this->datos = $datos;
         $boton = $_POST['boton'];
         switch ($boton) {
            case 'Buscar':
               $this->buscarAlumno($datos);
               break;

            case 'Inscribir':
               $this->agregarAlumno($datos);
               break;

            case 'Borrar':
               $this->borrarAlumno($datos);
               $this->buscarAlumnoId($datos);
               break;

            case 'Modificar':
               $this->modificarAlumno($datos);
               $this->buscarAlumnoId($datos);
               break;

            default:
               # code...
               break;
         }
      }else{
            if(strlen($_GET['m'])>1){
               $this->buscarAlumnoId($datos);
            }elseif($_GET['m'] == "a"){
               $this->formulario();
            }
      }
   }
   private function id(){
      $rand=rand(10000,99999);
      $this->idAlumno=$this->nombresAlumno[0].$this->apellidosAlumno[0].$rand;
   }
   private function agregarAlumno($datos){
      if(!empty($this->cedulaAlumno)){
         $selectA="select * from alumno where cedulaAlumno='{$this->cedulaAlumno}' and estado='1'";
         $consulta=$datos->query($selectA);
         if($datos->affected_rows>0){
            $this->result = "Alumno ya existe";
         }else{
            $selectA="select * from alumno where cedulaAlumno='{$this->cedulaAlumno}' and estado='0'";
            $consulta=$datos->query($selectA);
            if($datos->affected_rows>0){
               $updateA="update alumno set estado='1' where cedulaAlumno='{$this->cedulaAlumno}'";
               $consulta=$datos->query($updateA);
               $this->result="Alumno Inscrito";
            }else{
               $this->ejecutar($datos);
            }
         }
      }
   }
   private function ejecutar($datos){
      do{
         $this->id();
         $selectA="select * from alumno where idAlumno='{$this->idAlumno}'";
         $consulta=$datos->query($selectA);
      }while($datos->affected_rows>0);
      $selectR="select idRepresentante from representante where idRepresentante='{$this->idRepresentante}' or cedulaRepresentante='{$this->idRepresentante}'";
      $consulta=$datos->query($selectR);
      if($datos->affected_rows>0){
         $result=$consulta->fetch_assoc();
         $selectR="select idRepresentante from representante where idRepresentante='{$result['idRepresentante']}' and estado='1'";
         $consulta=$datos->query($selectR);
         if($datos->affected_rows>0){
            $insertA="insert into alumno values('{$this->idAlumno}','{$this->nombresAlumno}','{$this->apellidosAlumno}','{$this->cedulaAlumno}', '{$this->fechaNacimientoA}','{$this->lugarNacimiento}','{$this->estatura}','{$this->peso}','{$this->tCamisa}','{$this->tPantalon}','{$this->tZapatos}','{$this->observacion}','{$result['idRepresentante']}', '1', curdate())";
            if($datos->query($insertA)){
               $this->result = "Alumno Inscrito";
            }else{
               $this->result = "Ocurrió un error";
            }
         }else{
            $this->result = "Representante no encontrado";
         }
      }else{
         $this->result = "Representante no encontrado";
      }
   }
   private function buscarAlumno($datos){
      $selectA="select * from alumno where idAlumno='{$this->idRepresentante}' or cedulaAlumno='{$this->idRepresentante}' or apellidosAlumno='{$this->idRepresentante}' and estado='1'";
      if(!empty($this->idRepresentante)){
         $consulta=$datos->query($selectA);
         $this->formulario();
         if($datos->affected_rows>0){
            echo "<table class='resultado'>
                  <tr>
                  <th>Codigo</th>
                  <th>Nombres</th>
                  <th>Apellidos</th>
                  <th>Cedula</th>
                  <th>Fecha de Nacimiento</th>
                  <th>Lugar de Nacimiento</th>
                  <th>Estatura</th>
                  <th>Peso</th>
                  <th>Camisa</th>
                  <th>Pantalón</th>
                  <th>Zapatos</th>
                  <th>Observación</th>
                </tr>";
            while($valores = $consulta->fetch_assoc()){
               echo "<tr>
                     <td>{$valores['idAlumno']}</td>
                     <td>{$valores['nombresAlumno']}</td>
                     <td>{$valores['apellidosAlumno']}</td>
                     <td>{$valores['cedulaAlumno']}</td>
                     <td>{$valores['fechaNacimientoA']}</td>
                     <td>{$valores['lugarNacimiento']}</td>
                     <td>{$valores['estatura']}</td>
                     <td>{$valores['peso']}</td>
                     <td>{$valores['tCamisa']}</td>
                     <td>{$valores['tPantalon']}</td>
                     <td>{$valores['tZapatos']}</td>
                     <td>{$valores['observacion']}</td>
                     </tr>
                     <tr colspan='12'>
                     <td><a href='".nombre."/?m={$valores['idAlumno']}'>Perfil</a></td>
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
   }
   private function formulario(){
      echo "<form class='incripcion' method='post' action='".nombre."/?m=a'>
               <h2>Busqueda de Alumnos</h2>
               <input type='text' name='idRepresentante' placeholder='Codigo, Cedula o Apellido del Alumno' required><br>
               <input type='submit' name='boton' value='Buscar'>
               </form>";
   }
   private function buscarAlumnoId($datos){
      $selectA="select * from alumno where idAlumno='{$this->id}' and estado='1'";
      $consulta=$datos->query($selectA);
      if($datos->affected_rows>0){
         $result=$consulta->fetch_assoc();
         $this->idAlumno = $result['idAlumno'];
         $this->nombresAlumno = $result['nombresAlumno'];
         $this->apellidosAlumno = $result['apellidosAlumno'];
         $this->cedulaAlumno = $result['cedulaAlumno'];
         $this->fechaNacimientoA = $result['fechaNacimientoA'];
         $this->lugarNacimiento = $result['lugarNacimiento'];
         $this->estatura = $result['estatura'];
         $this->peso = $result['peso'];
         $this->tCamisa = $result['tCamisa'];
         $this->tPantalon = $result['tPantalon'];
         $this->tZapatos = $result['tZapatos'];
         $this->observacion = $result['observacion'];
         $selectR="select * from representante where idRepresentante=(select idRepresentante from alumno where idAlumno='{$this->id}')";
         $consulta=$datos->query($selectR);
         if($datos->affected_rows>0){
            $result=$consulta->fetch_assoc();
            echo "<form class='incripcion' method='post' action='".nombre."/?m={$this->id}'>
               <h3>Datos del Representante</h3>
               <label>Codigo:{$result['idRepresentante']} Cedula:{$result['cedulaRepresentante']}</label><br>
               <label>Nombres:{$result['nombresRepresentante']} Apellidos:{$result['apellidosRepresentante']}</label><br>
               <label>Teléfono:{$result['telefono']}</label><br>
               <h3>Datos del Alumno</h3>
               <label>Codigo:{$this->idAlumno}</label><br>
               <input type='text' name='nombresAlumno' placeholder='Nombres' value='{$this->nombresAlumno}' required><br>
               <input type='text' name='apellidosAlumno' placeholder='Apellidos' value='{$this->apellidosAlumno}' required><br>
               <input type='text' name='cedulaAlumno' placeholder='Cedula' value='{$this->cedulaAlumno}'><br>
               <input type='date' name='fechaNacimientoA' placeholder='Fecha de Nacimiento' value='{$this->fechaNacimientoA}' required><br>
               <input type='text' name='lugarNacimiento' placeholder='Lugar de Nacimiento' value='{$this->lugarNacimiento}' required><br>
               <input type='text' name='estatura' placeholder='Estatura(cm)' value='{$this->estatura}' required><br>
               <input type='text' name='peso' placeholder='Peso' value='{$this->peso}' required><br>
               <input type='text' name='tCamisa' placeholder='Talla de Camisa' value='{$this->tCamisa}' required><br>
               <input type='text' name='tPantalon' placeholder='Talla de Pantalon' value='{$this->tPantalon}' required><br>
               <input type='text' name='tZapatos' placeholder='Talla de Zapato' value='{$this->tZapatos}' required><br>
               <input type='textarea' name='observacion' placeholder='Observaci&oacute;n' value='{$this->observacion}'><br>
               <label>{$this->result}</label><br>
               <input type='submit' name='boton' value='Modificar'>
               <input type='submit' name='boton' value='Borrar'><br><br>
              </form>";
         }
      }else{
         echo "<table class='resultado'>
                  <tr>
                  <th><h2>Alumno no encontrado</h2></th>
                </tr>";
      }
   }
   private function modificarAlumno($datos){
      $updateA = "update alumno set nombresAlumno='{$this->nombresAlumno}', apellidosAlumno='{$this->apellidosAlumno}', cedulaAlumno='{$this->cedulaAlumno}', fechaNacimientoA='{$this->fechaNacimientoA}', lugarNacimiento='{$this->lugarNacimiento}', estatura='{$this->estatura}', peso='{$this->peso}', tCamisa='{$this->tCamisa}', tPantalon='{$this->tPantalon}', tZapatos='{$this->tZapatos}', observacion='{$this->observacion}'  where idAlumno='{$this->id}' and estado='1'";
      if ($datos->query($updateA)){
         $this->result="Datos Actualizados";
      }else{
         $this->result="Ocurrió un problema";
      }
   }
   private function borrarAlumno($datos){
      $deleteA="update alumno set estado='0' where idAlumno='{$this->id}'";
      if($datos->query($deleteA)){
         $this->idAlumno = '';
         $this->nombresAlumno = '';
         $this->apellidosAlumno = '';
         $this->cedulaAlumno = '';
         $this->fechaNacimientoA = '';
         $this->lugarNacimiento = '';
         $this->estatura = '';
         $this->peso = '';
         $this->tCamisa = '';
         $this->tPantalon = '';
         $this->tZapatos = '';
         $this->observacion = '';
         $this->result="Alumno Eliminado";
      }else{
         $this->result="Ocurrió un problema";
      }
   }
}
?>