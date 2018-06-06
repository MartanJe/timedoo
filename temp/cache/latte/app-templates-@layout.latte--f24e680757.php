<?php
// source: C:\Users\jencmart\Dropbox\development\PHPStormProjects\timedoo\app/templates/@layout.latte

use Latte\Runtime as LR;

class Templatef24e680757 extends Latte\Runtime\Template
{
	public $blocks = [
		'_timerMenu' => 'blockTimerMenu',
		'scripts' => 'blockScripts',
	];

	public $blockTypes = [
		'_timerMenu' => 'html',
		'scripts' => 'html',
	];


	function main()
	{
		extract($this->params);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="Martin Jenc" content="">

	<title>Timer - Timedoo</title>

	<!-- Bootstrap core CSS -->
	<link href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 12 */ ?>/css/bootstrap.css" rel="stylesheet">

	<!-- Add custom CSS here -->
	<link href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 15 */ ?>/css/sb-admin.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 16 */ ?>/font-awesome/css/font-awesome.min.css">
	<!-- Page Specific CSS -->
	<link rel="stylesheet" href="http://cdn.oesmith.co.uk/morris-0.4.3.min.css">
</head>

<body>

<div id="wrapper">

	<!------------------ Sidebar --------------------------->
    <!------------------ HORNII FAKIN LISTA JE TO NAV --------------------------->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">

        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link(":Track:Timer:")) ?>">Timedoo</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
<div id="<?php echo htmlSpecialChars($this->global->snippetDriver->getHtmlId('timerMenu')) ?>"><?php $this->renderBlock('_timerMenu', $this->params) ?></div>			<!--------- TOP NAVBAR  pouze ikonky ----------->
			<ul class="nav navbar-nav navbar-right navbar-user">

				<li class="dropdown user-dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo LR\Filters::escapeHtmlText($userName) /* line 65 */ ?> <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="#"><i class="fa fa-user"></i> Profile settings</a></li>
						<li class="divider"></li>
						<li><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link(":Track:Login:logout")) ?>"><i class="fa fa-power-off"></i> Log Out</a></li>
					</ul>
				</li>
			</ul>
		</div><!-- /.navbar-collapse -->
	</nav>

    <!-- JavaScript -->
    <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 77 */ ?>/js/jquery-1.10.2.js"></script>
    <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 78 */ ?>/js/bootstrap.js"></script>


<?php
		$this->renderBlock('scripts', get_defined_vars());
?>
	<!----------------- PAGE CONTENT ------------------------------------------------------------>
	<div id="page-wrapper">

<?php
		$this->renderBlock('content', $this->params, 'html');
?>



	</div><!-- /#page-wrapper -->



	<!----------------- PAGE CONTENT ------------------------------------------------------------>


</div><!-- /#wrapper -->





</body>
</html>
<?php
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockTimerMenu($_args)
	{
		extract($_args);
		$this->global->snippetDriver->enter("timerMenu", "static");
?>
            <ul class="nav navbar-nav side-nav">

                <li <?php
		if ($this->global->uiPresenter->isLinkCurrent(":Track:Timer:")) {
			?>class="active"<?php
		}
		?>><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link(":Track:Timer:")) ?>"><i class="fa fa-clock-o"></i> Timer  <?php
		if ($active == 1) {
			?>  <span class="timer"></span><?php
		}
?></a>   </li>
                <li <?php
		if ($this->global->uiPresenter->isLinkCurrent(":Track:Projects:")) {
			?>class="active"<?php
		}
		?>><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link(":Track:Projects:")) ?>"><i class="fa fa-edit"></i> Projects</a></li>

                <li class="dropdown <?php
		if ($this->global->uiPresenter->isLinkCurrent(":Track:Stats:")) {
			?>active<?php
		}
?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bar-chart-o"></i> Stats <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li <?php
		if ($this->global->uiPresenter->isLinkCurrent(":Track:Stats:default")) {
			?>class="active"<?php
		}
		?>><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link(":Track:Stats:default")) ?>">Overall</a></li>
                        <li <?php
		if ($this->global->uiPresenter->isLinkCurrent(":Track:Stats:inDepth")) {
			?>class="active"<?php
		}
		?>><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link(":Track:Stats:inDepth")) ?>">In-depth</a></li>
                    </ul>
                </li>

                <li <?php
		if ($this->global->uiPresenter->isLinkCurrent(":Track:Requests:")) {
			?>class="active"<?php
		}
		?>><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link(":Track:Requests:default")) ?>"><i class="fa fa-bell-o"></i> Requests</a></li>

            </ul>

<?php
		$this->global->snippetDriver->leave();
		
	}


	function blockScripts($_args)
	{
		extract($_args);
		?>        <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 82 */ ?>/js/jquery.js"></script>
        <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 83 */ ?>/js/netteForms.js"></script>
        <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 84 */ ?>/js/nette.ajax.js"></script>
        <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 85 */ ?>/js/main.js"></script>

        <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
        <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 88 */ ?>/js/nette.ajax.js"></script>

        <script src="https://nette.github.io/resources/js/netteForms.min.js"></script>


        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>

        <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 96 */ ?>/js/countimer.js"></script>

        <script type="text/javascript">


            $(document).ready(function () {
                $('.timer').countimer({

                    initHours: <?php echo LR\Filters::escapeJs($h) /* line 104 */ ?>,
                    initMinutes: <?php echo LR\Filters::escapeJs($m) /* line 105 */ ?>,
                    initSeconds: <?php echo LR\Filters::escapeJs($s) /* line 106 */ ?>,
                    autoStart: true
                });
            });
        </script>
<?php
	}

}
