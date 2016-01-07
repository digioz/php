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
    <!-- main container -->
    <div class='container'>
        <!-- header -->
        <div class='row'>
                <div>Header</div>
				<jdoc:include type="modules" name="position-1" style="none" />
				<jdoc:include type="modules" name="position-3" style="xhtml" />
				<jdoc:include type="modules" name="position-2" style="none" />
        </div>
		<p>&nbsp;</p>
        <!-- mid container - includes main content area and right sidebar -->
        <div class='row'>
			<!-- left sidebar -->
			<div class='col-sm-3'>
				<div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">&nbsp;</h3>
                </div>
                <div class="panel-body">
                    <jdoc:include type="modules" name="position-4" style="well" />
                </div>
            </div>
            </div>
            <!-- main content area -->
            <div class='col-sm-6'>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">&nbsp;</h3>
					</div>
					<div class="panel-body">	
						<jdoc:include type="message" />
						<jdoc:include type="component" />
					</div>
				</div>

            </div>
            <!-- right sidebar -->
            <div class='col-sm-3'>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">&nbsp;</h3>
					</div>
					<div class="panel-body">
						<jdoc:include type="modules" name="position-7" style="well" />
					</div>
				</div>
            </div>
        </div>
        <!-- footer -->
        <div class='row'>
                <div class='span12'>Footer</div>
        </div>
    </div>
</body>
</html>

