<?php
// source: C:\Users\marti\Dropbox\development\PHPStormProjects\timedoo\app\TrackModule/templates/Requests/default.latte

use Latte\Runtime as LR;

class Templateef635b9a83 extends Latte\Runtime\Template
{
	public $blocks = [
		'content' => 'blockContent',
		'_messages' => 'blockMessages',
		'_requestTable' => 'blockRequestTable',
		'_itemsContainer' => 'blockItemsContainer',
	];

	public $blockTypes = [
		'content' => 'html',
		'_messages' => 'html',
		'_requestTable' => 'html',
		'_itemsContainer' => 'html',
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
		if (isset($this->params['flash'])) trigger_error('Variable $flash overwritten in foreach on line 26');
		if (isset($this->params['invite'])) trigger_error('Variable $invite overwritten in foreach on line 50');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
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
        <h1>Requests
            <small>Administrate your invitations</small>
        </h1>
    </div>
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active"><i class="fa fa-edit"></i> Requests</li>
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
        <div class="table-responsive">
<div id="<?php echo htmlSpecialChars($this->global->snippetDriver->getHtmlId('requestTable')) ?>"><?php $this->renderBlock('_requestTable', $this->params) ?></div>        </div>
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
			?>                <div class="alert alert-<?php echo LR\Filters::escapeHtmlAttr($flash->type) /* line 27 */ ?>">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?php echo LR\Filters::escapeHtmlText($flash->message) /* line 29 */ ?>

                </div>
<?php
			$iterations++;
		}
		$this->global->snippetDriver->leave();
		
	}


	function blockRequestTable($_args)
	{
		extract($_args);
		$this->global->snippetDriver->enter("requestTable", "static");
?>
                <table class="table table-bordered table-hover tablesorter">
                    <thead>
                    <tr>
                        <th>Invite to project <i class="fa fa-sort"></i></th>
                        <th>From <i class="fa fa-sort"></i></th>
                        <th>Date <i class="fa fa-sort"></i></th>
                        <th>Options <i class=""></i></th>
                    </tr>
                    </thead>
                    <tbody<?php echo ' id="' . htmlSpecialChars($this->global->snippetDriver->getHtmlId('itemsContainer')) . '"' ?>>
<?php $this->renderBlock('_itemsContainer', $this->params) ?>
                    </tbody>
                </table>
                <!-- Page Specific Plugins -->
                <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 64 */ ?>/js/tablesorter/jquery.tablesorter.js"></script>
                <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 65 */ ?>/js/tablesorter/tables.js"></script>
<?php
		$this->global->snippetDriver->leave();
		
	}


	function blockItemsContainer($_args)
	{
		extract($_args);
		$this->global->snippetDriver->enter("itemsContainer", "static");
		$iterations = 0;
		foreach ($invitations as $invite) {
?>                    <tr >
                        <td><?php echo LR\Filters::escapeHtmlText($invite->project_name) /* line 51 */ ?></td>
                        <td><?php echo LR\Filters::escapeHtmlText($invite->username_from) /* line 52 */ ?></td>
                        <td><?php echo LR\Filters::escapeHtmlText($invite->date_invite) /* line 53 */ ?></td>
                        <td>
                            <ol class="breadcrumb cum">
                                <li><a class="ajax" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("RequestAccept!", [$invite->id_user_from , $invite->id_project])) ?>">  <i class="fa fa-check green"></i>  </a></li>
                                <li><a class="ajax" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("RequestDecline!", [$invite->id_user_from , $invite->id_project])) ?>"><i class="fa fa-times red"></i></a></li>
                            </ol>
                        </td>
                    </tr>
<?php
			$iterations++;
		}
		$this->global->snippetDriver->leave();
		
	}

}
