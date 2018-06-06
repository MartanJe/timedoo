<?php
// source: C:\Users\marti\Dropbox\development\PHPStormProjects\timedoo\app\TrackModule/templates/Login/default.latte

use Latte\Runtime as LR;

class Template317a5de31c extends Latte\Runtime\Template
{
	public $blocks = [
		'content' => 'blockContent',
	];

	public $blockTypes = [
		'content' => 'html',
	];


	function main()
	{
		extract($this->params);
		if ($this->getParentName()) return get_defined_vars();
		$this->renderBlock('content', get_defined_vars());
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		if (isset($this->params['flash'])) trigger_error('Variable $flash overwritten in foreach on line 24');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockContent($_args)
	{
		extract($_args);
?>

<div id="intro">

    <h1>Timedoo</h1>
    <p>Best time tracking system in the whole universe!</p>

    <div style=" width: 300px; margin: 0 auto;">
<?php
		$form = $_form = $this->global->formsStack[] = $this->global->uiControl["loginForm"];
		?>        <form class=form<?php
		echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin(end($this->global->formsStack), array (
		'class' => NULL,
		), false) ?>>
            <div class="form-group">
                <label<?php
		$_input = end($this->global->formsStack)["username"];
		echo $_input->getLabelPart()->attributes() ?>>Username:</label>
                <input class="form-control"<?php
		$_input = end($this->global->formsStack)["username"];
		echo $_input->getControlPart()->addAttributes(array (
		'class' => NULL,
		))->attributes() ?>>
            </div>
            <div class="form-group">
                <label<?php
		$_input = end($this->global->formsStack)["password"];
		echo $_input->getLabelPart()->attributes() ?>>Password:</label>
                <input class="form-control"<?php
		$_input = end($this->global->formsStack)["password"];
		echo $_input->getControlPart()->addAttributes(array (
		'class' => NULL,
		))->attributes() ?>>
            </div>
            <p><input class="btn"<?php
		$_input = end($this->global->formsStack)["login"];
		echo $_input->getControlPart()->addAttributes(array (
		'class' => NULL,
		))->attributes() ?>></p>
            Not user yet? <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Login:register")) ?>">Register here.</a>
<?php
		echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(array_pop($this->global->formsStack), false);
?>        </form>
    </div>

    <div style=" width: 300px; margin: 0 auto;">
<?php
		$iterations = 0;
		foreach ($flashes as $flash) {
			?>            <div class="alert alert-<?php echo LR\Filters::escapeHtmlAttr($flash->type) /* line 25 */ ?>">
                <?php echo LR\Filters::escapeHtmlText($flash->message) /* line 26 */ ?>

            </div>
<?php
			$iterations++;
		}
?>
    </div>
</div><?php
	}

}
