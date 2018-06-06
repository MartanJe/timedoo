<?php
// source: C:\Users\marti\Dropbox\development\PHPStormProjects\timedoo\app\TrackModule/templates/Timer/default.latte

use Latte\Runtime as LR;

class Template04b591a8dc extends Latte\Runtime\Template
{
	public $blocks = [
		'jsCallback' => 'blockJsCallback',
		'content' => 'blockContent',
		'_messages' => 'blockMessages',
		'_bigSnippet' => 'blockBigSnippet',
		'_wrapper' => 'blockWrapper',
		'_secondSnippet' => 'blockSecondSnippet',
	];

	public $blockTypes = [
		'jsCallback' => 'html',
		'content' => 'html',
		'_messages' => 'html',
		'_bigSnippet' => 'html',
		'_wrapper' => 'html',
		'_secondSnippet' => 'html',
	];


	function main()
	{
		extract($this->params);
		if ($this->getParentName()) return get_defined_vars();
?>

<?php
		$this->renderBlock('content', get_defined_vars());
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		if (isset($this->params['flash'])) trigger_error('Variable $flash overwritten in foreach on line 41');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockJsCallback($_args)
	{
		extract($_args);
?>
    <script>

        $('#' + <?php echo LR\Filters::escapeJs($control["selectForm"][$input]->htmlId) /* line 4 */ ?>).off('change').on('change', function () {
            $.nette.ajax({
                type: 'GET',
                url: <?php echo LR\Filters::escapeJs($this->global->uiControl->link("{$link}!")) ?>,
                data: {
                    'value': $(this).val()
                }
            });
        });
    </script>
<?php
	}


	function blockContent($_args)
	{
		extract($_args);
?>
<script>
    $(function () {
        $.nette.init();// And you fly...
    });
</script>

<div class="row">
    <div class="col-lg-12">
        <h1>Timer
            <small>Tracking Base</small>
        </h1>
    </div>
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active"><i class="fa fa-cl"></i> Timer</li>
            <li class="active"></li>
        </ol>
    </div>
</div><!-- /.row -->


<div class="row">
    <div class="col-lg-6">
<div id="<?php echo htmlSpecialChars($this->global->snippetDriver->getHtmlId('messages')) ?>"><?php $this->renderBlock('_messages', $this->params) ?></div>    </div>
</div><!-- /.row -->

<div class="row">
    <div class="col-lg-6">
<div id="<?php echo htmlSpecialChars($this->global->snippetDriver->getHtmlId('bigSnippet')) ?>"><?php $this->renderBlock('_bigSnippet', $this->params) ?></div>
    </div>
</div><!-- /.row -->


<?php
	}


	function blockMessages($_args)
	{
		extract($_args);
		$this->global->snippetDriver->enter("messages", "static");
		$iterations = 0;
		foreach ($flashes as $flash) {
?>
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?php echo LR\Filters::escapeHtmlText($flash->message) /* line 44 */ ?>

                </div>
<?php
			$iterations++;
		}
		$this->global->snippetDriver->leave();
		
	}


	function blockBigSnippet($_args)
	{
		extract($_args);
		$this->global->snippetDriver->enter("bigSnippet", "static");
		$this->renderBlock('_wrapper', $this->params);
		$this->renderBlock('jsCallback', ['input' => 'first', 'link' => 'firstChange'] + get_defined_vars(), 'html');
		$this->global->snippetDriver->leave();
		
	}


	function blockWrapper($_args)
	{
		extract($_args);
		$this->global->snippetDriver->enter("wrapper", "area");
?>
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading  <?php
		if ($active == 1) {
			?> green_bg <?php
		}
		?>"> <?php
		if ($active == 1) {
			?> <strong>Tracking: <span class="timer"></span> </strong><?php
		}
		else {
			?> Not Tracking <?php
		}
?> </div>
                    <div class="panel-body">
<?php
		$form = $_form = $this->global->formsStack[] = $this->global->uiControl["selectForm"];
		?>                        <form<?php
		echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin(end($this->global->formsStack), array (
		), false) ?>>
                            <div class="form-group">
                                <label<?php
		$_input = end($this->global->formsStack)["first"];
		echo $_input->getLabelPart()->attributes() ?>>Project</label>
                                <select class="form-control"<?php
		$_input = end($this->global->formsStack)["first"];
		echo $_input->getControlPart()->addAttributes(array (
		'class' => NULL,
		))->attributes() ?>><?php echo $_input->getControl()->getHtml() ?></select>
                            </div>
                            <div class="form-group">
<div id="<?php echo htmlSpecialChars($this->global->snippetDriver->getHtmlId('secondSnippet')) ?>"><?php
		$this->renderBlock('_secondSnippet', $this->params) ?></div>                            </div>
                            <input class="btn btn-primary"<?php
		$_input = end($this->global->formsStack)["send"];
		echo $_input->getControlPart()->addAttributes(array (
		'class' => NULL,
		))->attributes() ?>>
<?php
		echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(array_pop($this->global->formsStack), false);
?>                        </form>
                    </div>
                </div>
            </div>


            <script type="text/javascript">
                $(document).ready(function () {
                    $('.timer').countimer({

                        initHours: <?php echo LR\Filters::escapeJs($h) /* line 81 */ ?>,
                        initMinutes: <?php echo LR\Filters::escapeJs($m) /* line 82 */ ?>,
                        initSeconds: <?php echo LR\Filters::escapeJs($s) /* line 83 */ ?>,
                        autoStart: true
                    });
                });
            </script>

<?php
		$this->global->snippetDriver->leave();
		
	}


	function blockSecondSnippet($_args)
	{
		extract($_args);
		$this->global->snippetDriver->enter("secondSnippet", "static");
		?>                                    <label<?php
		$_input = end($this->global->formsStack)["second"];
		echo $_input->getLabelPart()->attributes() ?>>Task</label>
                                    <select class="form-control"<?php
		$_input = end($this->global->formsStack)["second"];
		echo $_input->getControlPart()->addAttributes(array (
		'class' => NULL,
		))->attributes() ?>><?php echo $_input->getControl()->getHtml() ?></select>
<?php
		$this->global->snippetDriver->leave();
		
	}

}
