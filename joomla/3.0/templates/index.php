<?php

defined('_JEXEC') or die;

$doc = JFactory::getDocument();

$doc->addStyleSheet('templates/' . $this->template . '/css/jquery-ui.min.css');
$doc->addStyleSheet('templates/' . $this->template . '/css/bootstrap.css');
$doc->addStyleSheet('templates/' . $this->template . '/css/style.css');
$doc->addScript('templates/' . $this->template . '/js/jquery-1.10.2.min.js', 'text/javascript');
$doc->addScript('templates/' . $this->template . '/js/bootstrap.min.js', 'text/javascript');
$doc->addScript('templates/' . $this->template . '/js/main.js', 'text/javascript');

?>

<!DOCTYPE html>
<html>
<head>
    <jdoc:include type="head" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<!-- Top Navigation -->
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">
		  <div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
			  <span class="sr-only">Toggle navigation</span>
			  <span class="icon-bar"></span>
			  <span class="icon-bar"></span>
			  <span class="icon-bar"></span>
			</button>
		  </div>
		  <div class="navbar-collapse collapse">
			<jdoc:include type="modules" name="position-1" style="none" />
		  </div><!--/.nav-collapse -->
		</div>
	</nav>

    <!-- main container -->
    <div class="container-fluid" style="padding:10px;">
        <!-- header -->
        <div class='row'>
			<jdoc:include type="modules" name="header" style="none" />
			
			<jdoc:include type="modules" name="position-3" style="xhtml" />
			<jdoc:include type="modules" name="position-2" style="none" />
        </div>
		
		<p>&nbsp;</p>
		
		<!-- banner -->
		<?php if ($this->countModules('banner')) : ?>
        <div class='row'>
			<jdoc:include type="modules" name="banner" style="none" />
        </div>
		<p>&nbsp;</p>
		
		<?php endif; ?>
		
        <!-- mid container - includes main content and left and right navs -->
        <div class='row'>
			<!-- left sidebar -->
			<?php if ($this->countModules('position-4')) : ?>
			<div class="col-sm-2">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">&nbsp;</h3>
					</div>
					<div class="panel-body">
						<jdoc:include type="modules" name="position-4" style="well" />
					</div>
				</div>
            </div>
			<?php endif; ?>
			
            <!-- main content area -->
            <div class="col-sm-8">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">&nbsp;</h3>
					</div>
					<div class="panel-body">	
						<jdoc:include type="message" />
						<jdoc:include type="component" />
					</div>
				</div>
            </div>
			
            <!-- search box -->
			<?php if ($this->countModules('position-0')) : ?>
			<div class="col-sm-2">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">&nbsp;</h3>
					</div>
					<div class="panel-body">
						<jdoc:include type="modules" name="position-0" style="well" />
					</div>
				</div>
            </div>
			<?php endif; ?>
			
			<!-- right sidebar -->
			<?php if ($this->countModules('position-7')) : ?>
            <div class="col-sm-2">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">&nbsp;</h3>
					</div>
					<div class="panel-body">
						<jdoc:include type="modules" name="position-7" style="well" />
					</div>
				</div>
            </div>
			<?php endif; ?>
        </div>
        <!-- footer -->
		<?php if ($this->countModules('footer')) : ?>
        <div class='row'>
			<div class='span12'>
				<jdoc:include type="modules" name="footer" style="none" />
				<br />
				<div class="sm-3"><a href="http://www.digioz.com" target="_blank">Template by DigiOz Multimedia.</a></div>
			</div>
        </div>
		<?php endif; ?>
		
		<div class='row'>
			<div class='span12'>
				<center>
					<span style="font-size:10px;font-style: italic;"><a href="http://www.digioz.com" target="_blank">Template by DigiOz Multimedia.</a></span>
				</center>
			</div>
        </div>
		
		<p>&nbsp;</p>

    </div>
</body>
</html>

