<?php 
/* Roles
Usuario: 0 
administrador: 1 
*/

/*function redir($url){
	?>
	<script>
		window.location="<?=$url?>";
	</script>
	<?php 
	die(); 
}
*/


function alert($msj,$tipo,$u){
	global $url;
	if ($tipo==0) {
		$type=="error";
	}elseif($tipo==1){
		$type="Success";
	}else{
		$type="warning";
	}

?>
<!-- jQuery -->
<script src="<?=$url?>admin/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?=$url?>admin/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?=$url?>admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?=$url?>admin/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?=$url?>admin/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?=$url?>admin/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?=$url?>admin/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?=$url?>admin/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?=$url?>admin/plugins/moment/moment.min.js"></script>
<script src="<?=$url?>admin/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?=$url?>admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?=$url?>admin/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?=$url?>admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=$url?>admin/dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?=$url?>admin/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?=$url?>admin/dist/js/demo.js"></script>
 <!--Alertas de sweet alerts dowload -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<!--<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
<script type="text/javascript">
	$(document.ready(function(){
		Swal.fire({
	  icon: '<?=$type?>',
	  text: '<?=$msj?>',
	  }).then((result) => {
		  if (result.value) {
		    window.location='<?=$u?>';
		    
		  }
		})
	});
</script>
<?php
}

function clear($var){
	$var = htmlspecialchars($var);
	$var = stripslashes($var);
	return $var;
}
function redir($url){
	?>
	<script type="text/javascript">
		window.location="<?=$url?>";
	</script>
	<?php
	die();
}

function check_conectado_admin(){
	if(isset($_SESSION['id'])){
		global $pdo;
		
		$q=$pdo->prepare("SELECT * FROM users WHERE id=:id and rol=1");
		$q->bindParam(":id", $_SESSION['id'],PDO::PARAM_INT);
		$q->execute();
		if ($q->rowCount()==0){
			session_destroy();
			alert("NO TIENES PERMISO PARA ENTRAR ACA",0,"login.php");
		}
	}else{
		redir("login.php");
	}
}

function check_conectado(){
	if (!isset($_SESSION['idc'])) {
		redir("login.php");
	}
}

function enc($var){
	$var = sha1(md5($var));
	return $var;
}

function nombre_usuario_conectado(){
	global $pdo;
	$id = $_SESSION['idc'];
	$q = $pdo->prepare("SELECT * FROM users WHERE id=:id");
	$q->bindParam(":id", $id, PDO::PARAM_INT);
	$q->execute();
	$r=$q->fetch(PDO::FETCH_ASSOC);
	return $r['name'];
}

function listado_categorias(){
	global $pdo;
	$q=$pdo->prepare("SELECT * FROM categorias ORDER BY id ASC ");
	$q->execute();
	while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
		?>
		<tr>
			<td><?=$r['id']?></td>
			<td><?=$r['nombre']?></td>
			<td><a href="?p=categorias&eliminar=<?=$r['id']?>"><i class="fa fa-times" data-toggle="tooltip" title="Eliminar"></i></a></td>
		</tr>
		<?php
	}
}


function listado_tabla_productos(){
	global $pdo;
	$q=$pdo->prepare("SELECT * FROM productos ORDER BY id ASC ");
	$q->execute();
	while($r = $q->fetch(PDO::FETCH_ASSOC)){
		$pj = $r['oferta'] / 100;
		$precio_descuento = $r['precio'] - ($r['precio'] * $pj);

		if ($r['activo'] == 0) {
			$ad="Desactivado";

		}else{
			$ad = "Activo";
		}
		$sc=$pdo->prepare("SELECT * FROM categorias WHERE id = :id");
		$sc->bindParam(":id",$r['id_categoria'],PDO::PARAM_INT);
		$sc->execute();
		$rc=$sc->fetch(PDO::FETCH_ASSOC);

		$categoria = $rc['nombre'];
		?>
		<tr>
			<td><?=$r['id']?></td>
			<td><?=$r['id_categoria']?></td>
			<td><img style="max-height: 50px;" src="./productos/<?=$r['imagen']?>" alt=""></td>
			<td><?=$r['nombre']?></td>
			<td><?=$r['descripcion']?></td>
			<td><?=$r['precio']?></td>
			<td><?=$r['oferta']?>% (<?=$precio_descuento?>)</td>
			<td><?=$ad?></td>
			<td><?=$r['comprado']?></td>
			<td><a href="?p=productos&eliminar=<?=$r['id']?>"><i class="fa fa-times" data-toggle="tooltip" title="Eliminar"></i></a></td>
		</tr>
		<?php
	}

}

function options_categorias(){
	global $pdo;

	$q=$pdo->prepare("SELECT * FROM categorias ORDER BY id ASC");
	$q->execute();

	while ($r=$q->fetch(PDO::FETCH_ASSOC)) {
		?>
		<option value="<?=$r['id']?>"><?=$r['nombre']?></option>
		<?php 
	}
}

 ?>