<?php
/**
* Clase encargada de registrar los representantes
*/
class Representante{
	public $idRepresentante;
   public $nombresRepresentante;
   public $apellidosRepresentante;
   public $cedulaRepresentante;
   public $telefono;
   public $oficio;
   public $fechaNacimientoR;
   public $result;


	function __construct($datos){
      if(!empty($_POST['cedulaRepresentante'])){
         $this->nombresRepresentante = $_POST['nombresRepresentante'];
         $this->apellidosRepresentante = $_POST['apellidosRepresentante'];
         $this->cedulaRepresentante = $_POST['cedulaRepresentante'];
         if(!empty($_POST['nombresRepresentante'])){
            $this->idRepresentante = $this->nombresRepresentante[0].$this->apellidosRepresentante[0].$this->cedulaRepresentante;
         }
         $this->telefono = $_POST['telefono'];
         $this->oficio = $_POST['oficio'];
         $this->fechaNacimientoR = $_POST['fechaNacimientoR'];
         $boton = $_POST['boton'];
         switch ($boton) {
            case 'Buscar':
               $this->buscarRepresentante($datos);
               break;

            case 'Registrar':
               $this->agregarRepresentante($datos);
               break;

            case 'Borrar':
               $this->borrarRepresentante($datos);
               break;

            case 'Modificar':
               $this->modificarRepresentante($datos);
               break;

            default:
               # code...
               break;
         }
      }
   }

   private function agregarRepresentante($datos){
      $selectR="select * from representante where cedulaRepresentante='{$this->cedulaRepresentante}' and estado='1'";
      $consulta=$datos->query($selectR);
      if($datos->affected_rows>0){
         $this->result="Representante ya existe";
      }else{
         $selectR="select * from representante where cedulaRepresentante='{$this->cedulaRepresentante}' and estado='0'";
         $consulta=$datos->query($selectR);
         if($datos->affected_rows>0){
            $updateR="update representante set estado='1' where cedulaRepresentante='{$this->cedulaRepresentante}'";
            $consulta=$datos->query($updateR);
            $this->result="Representante Agregado";
         }else{
            $insertR="insert into representante values('{$this->idRepresentante}', '{$this->nombresRepresentante}', '{$this->apellidosRepresentante}', '{$this->cedulaRepresentante}', '{$this->telefono}', '{$this->oficio}', '{$this->fechaNacimientoR}', '1')";
            if($datos->query($insertR)){
               $this->result="Representante Agregado";
            }else{
               $this->result="Ocurrió un error";
            }
         }
      }
   }

   private function buscarRepresentante($datos){
      $selectR="select * from representante where cedulaRepresentante='{$this->cedulaRepresentante}' and estado='1'";
      $consulta=$datos->query($selectR);
      if($datos->affected_rows>0){
         $result=$consulta->fetch_assoc();
         $this->idRepresentante = $result['idRepresentante'];
         $this->nombresRepresentante = $result['nombresRepresentante'];
         $this->apellidosRepresentante = $result['apellidosRepresentante'];
         $this->cedulaRepresentante = $result['cedulaRepresentante'];
         $this->telefono = $result['telefono'];
         $this->oficio = $result['oficio'];
         $this->fechaNacimientoR = $result['fechaNacimientoR'];
      }else{
         $this->result="No se encuentra";
      }
   }
  
   private function borrarRepresentante($datos){
      $deleteR="update representante set estado='0' where cedulaRepresentante='{$this->cedulaRepresentante}'";
      if($datos->query($deleteR)){
         $this->idRepresentante = '';
         $this->nombresRepresentante = '';
         $this->apellidosRepresentante = '';
         $this->cedulaRepresentante = '';
         $this->telefono = '';
         $this->oficio = '';
         $this->fechaNacimientoR = '';
         $this->result="Representante Eliminado";
      }else{
         $this->result="Ocurrió un problema";
      }
   }

   private function modificarRepresentante($datos){
      $updateR = "update representante set nombresRepresentante='{$this->nombresRepresentante}', apellidosRepresentante='{$this->apellidosRepresentante}', cedulaRepresentante='{$this->cedulaRepresentante}', telefono='{$this->telefono}', oficio='{$this->oficio}', fechaNacimientoR='{$this->fechaNacimientoR}' where cedulaRepresentante='{$this->cedulaRepresentante}' and estado='1'";
      if ($datos->query($updateR)){
         $this->result="Datos Actualizados";
      }else{
         $this->result="Ocurrió un problema";
      }
   }
}
?>