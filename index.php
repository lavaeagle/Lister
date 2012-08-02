<?php
if(isset($_GET['phpinfo'])){
	echo phpinfo();
	die();
	exit();
}
class lister{
	private $_dir;
	private $_errors = array();
	
	public function set_dir($dir){
		if(is_dir($dir)){
			$this->_dir = $dir;
		}else{
			$this->_errors[] = "Oh snap! It's not a valid directory!";
		}
	}
	
	public function display_nav(){
		if(empty($this->_dir)){
			$this->_errors[] = "Directory can't be empty!";
		}else if(!is_dir($this->_dir)){
			$this->_errors[] = "Oh snap! It's not a valid directory!";
		}else{
			$files = scandir($this->_dir);
			unset($files[0]);
			unset($files[1]);
			
			foreach($files as $file){
				$info = pathinfo($file);
				$ext = (@$info['extension'])? true : false;
				if($ext){
					$type = array(
						"class" 	=> "icon-file",
						"tooltip"	=> "It's a file!"				
					);
				}else{
					$type = array(
						"class" 	=> "icon-folder-open",
						"tooltip"	=> "It's a folder!"				
					);
				}
				?>
				<div class="breadcrumb clearfix">
					<span class="pull-left"><i rel="tooltip" title="<?=$type['tooltip'];?>" class="tt <?=$type['class'];?>"></i> <?php echo $file; ?></span>
					<div class="btn-group pull-right">
						<a class="btn btn-mini btn-primary" href="http://localhost/<?php echo $file; ?>">Open</a>
						<a class="btn btn-mini btn-success previewIt" href="#" data-url="http://localhost/<?php echo $file; ?>">Preview</a>
					</div>
				</div>
				<?php
			}
		}
	}
	
	public function display_errors(){
		if(!empty($this->_errors)){
			foreach($this->_errors as $error){
				?>
				<div class="alert alert-error">
					<?=$error;?>
					<button class="close" data-dismiss="alert">&times;</button>
				</div>
				<?php
			}
		}
	}
}

$lister = new lister;
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			List it
		</title>
		<script src="../jquery.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/general.js"></script>
		<link href="css/bootstrap.min.css" rel="stylesheet" />
		<style>
		body{
			padding-top: 60px;
			padding-bottom: 40px;
		}
		</style>
		<link href="css/bootstrap-responsive.min.css" rel="stylesheet" />
		<link href="css/style.css" rel="stylesheet" />
	</head>
	
	<body>
		<div class="navbar navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container-fluid">
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</a>
					<a class="brand" href="#">List it!</a>
					<div class="nav-collapse">
						<ul class="nav">
							<li class="active"><a href="#"><i class="icon-home icon-white"></i> Home</a></li>
							<li><a href="#settings"><i class="icon-cog icon-white"></i> Settings</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		
		<?php $lister->set_dir("c:/xampp/htdocs"); ?>
		
		<div class="container-fluid">
			<div class="row-fluid">
			
				<div class="span4">
					<div class="well">
						<?=$lister->display_nav();?>
					</div>
				</div>
				
				<div class="span8 preview well">
					<?=$lister->display_errors();?>
					<iframe id="load" height="100%" border="0"></iframe>
				</div>
				
			</div>
		</div>
	</body>
</html>