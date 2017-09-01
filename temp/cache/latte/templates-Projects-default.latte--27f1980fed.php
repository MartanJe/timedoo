<?php
// source: C:\Users\jencmart\Dropbox\development\PHPStormProjects\timedoo\app\TrackModule/templates/Projects/default.latte

use Latte\Runtime as LR;

class Template27f1980fed extends Latte\Runtime\Template
{
    public $blocks = [
        'content' => 'blockContent',
        '_messagesErr' => 'blockMessagesErr',
        '_wholeTable' => 'blockWholeTable',
        '_itemsContainer' => 'blockItemsContainer',
        '_messages' => 'blockMessages',
        '_editFormSnippet' => 'blockEditFormSnippet',
        '_messagesSave' => 'blockMessagesSave',
    ];

    public $blockTypes = [
        'content' => 'html',
        '_messagesErr' => 'html',
        '_wholeTable' => 'html',
        '_itemsContainer' => 'html',
        '_messages' => 'html',
        '_editFormSnippet' => 'html',
        '_messagesSave' => 'html',
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
        if (isset($this->params['flash'])) trigger_error('Variable $flash overwritten in foreach on line 58, 164, 217');
        if (isset($this->params['project'])) trigger_error('Variable $project overwritten in foreach on line 89');
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
                <h1>Projects
                    <small>Select Your Project</small>
                </h1>
            </div>

            <div class="col-lg-12">

                <ol class="breadcrumb">
                    <li class="active"><i class="fa fa-edit"></i> Projects</li>

                    <li class="active">
                        <button type="button" class="btn btn-success " data-toggle="modal" data-target="#myModal">Create
                            New
                            Project
                        </button>
                    </li>
                </ol>


            </div>

        </div><!-- /.row -->


        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">Filters</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="Show archived"
                                           id="myCheckbox" <?php
                                    if ($showArchived) {
                                        ?> checked <?php
                                    }
                                    ?>> Show archived
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-6">
                <div<?php echo ' id="' . htmlSpecialChars($this->global->snippetDriver->getHtmlId('messagesErr')) . '"' ?>>
                    <?php $this->renderBlock('_messagesErr', $this->params) ?>
                </div>
            </div>

        </div>
        <!-- MESSGES -->


        <div class="row">
            <div class="col-lg-6">
                <div class="table-responsive">

                    <div id="<?php echo htmlSpecialChars($this->global->snippetDriver->getHtmlId('wholeTable')) ?>"><?php $this->renderBlock('_wholeTable', $this->params) ?></div>
                    <!-- Modal  create-->
                    <div id="myModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Create project</h4>
                                </div>

                                <?php
                                $form = $_form = $this->global->formsStack[] = $this->global->uiControl["newProjectForm"];
                                ?>
                                <form class="form ajax"<?php
                                echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin(end($this->global->formsStack), array(
                                    'class' => NULL,
                                ), false) ?>>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label<?php
                                            $_input = end($this->global->formsStack)["projectName"];
                                            echo $_input->getLabelPart()->attributes() ?>>Project name:</label>
                                            <input class="form-control"<?php
                                            $_input = end($this->global->formsStack)["projectName"];
                                            echo $_input->getControlPart()->addAttributes(array(
                                                'class' => NULL,
                                            ))->attributes() ?>>
                                        </div>

                                        <div class="form-group">
                                            <label<?php
                                            $_input = end($this->global->formsStack)["client"];
                                            echo $_input->getLabelPart()->attributes() ?>>Client:</label>
                                            <input class="form-control"<?php
                                            $_input = end($this->global->formsStack)["client"];
                                            echo $_input->getControlPart()->addAttributes(array(
                                                'class' => NULL,
                                            ))->attributes() ?>>
                                        </div>
                                        <div class="form-group">
                                            <label<?php
                                            $_input = end($this->global->formsStack)["description"];
                                            echo $_input->getLabelPart()->attributes() ?>> Description: </label>
                                            <textarea class="form-control" rows="3"<?php
                                            $_input = end($this->global->formsStack)["description"];
                                            echo $_input->getControlPart()->addAttributes(array(
                                                'class' => NULL,
                                                'rows' => NULL,
                                            ))->attributes() ?>><?php echo $_input->getControl()->getHtml() ?></textarea>
                                        </div>

                                        <div<?php echo ' id="' . htmlSpecialChars($this->global->snippetDriver->getHtmlId('messages')) . '"' ?>>
                                            <?php $this->renderBlock('_messages', $this->params) ?>
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-primary"<?php
                                        $_input = end($this->global->formsStack)["createProject"];
                                        echo $_input->getControlPart()->addAttributes(array(
                                            'class' => NULL,
                                        ))->attributes() ?>>Create
                                        </button>
                                    </div>
                                    <?php
                                    echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(array_pop($this->global->formsStack), false);
                                    ?>                        </form>
                            </div>

                        </div>
                    </div>


                    <!-- Modal  create-->


                    <div id="myModal2" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Edit project</h4>
                                </div>

                                <div id="<?php echo htmlSpecialChars($this->global->snippetDriver->getHtmlId('editFormSnippet')) ?>"><?php
                                    $this->renderBlock('_editFormSnippet', $this->params) ?></div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

        <script>


            $("#myCheckbox").click(function () {
                $.nette.ajax({
                    type: 'GET',
                    url: <?php echo LR\Filters::escapeJs($this->global->uiControl->link("ArchivedSwitch!")) ?>,
                    data: {
                        'value': $(this).is(':checked')
                    }
                });
            });

            function OptionsSelected(me) {
                $.nette.ajax({
                    type: 'GET',
                    url: <?php echo LR\Filters::escapeJs($this->global->uiControl->link("ProjectEdit!")) ?>,
                    data: {'idProject': me.id}
                });
            }


        </script><?php
    }


    function blockMessagesErr($_args)
    {
        extract($_args);
        $this->global->snippetDriver->enter("messagesErr", "static");
        ?><?php
        $iterations = 0;
        foreach ($flashes as $flash) {
            ?>

            <div class="alert alert-<?php echo LR\Filters::escapeHtmlAttr($flash->type) /* line 59 */ ?>">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                    &times;
                </button>
                <?php echo LR\Filters::escapeHtmlText($flash->message) /* line 63 */ ?>

            </div>
            <?php
            $iterations++;
        }
        $this->global->snippetDriver->leave();

    }


    function blockWholeTable($_args)
    {
        extract($_args);
        $this->global->snippetDriver->enter("wholeTable", "static");
        ?>
        <table class="table table-bordered table-hover tablesorter">
            <thead>
            <tr>
                <th>Project <i class="fa fa-sort"></i></th>
                <th>Client <i class="fa fa-sort"></i></th>
                <th>Your Role <i class="fa fa-sort"></i></th>
                <th>Status <i class="fa fa-sort"></i></th>
                <th>Options <i class=""></i></th>
            </tr>
            </thead>
            <tbody<?php echo ' id="' . htmlSpecialChars($this->global->snippetDriver->getHtmlId('itemsContainer')) . '"' ?>>
            <?php $this->renderBlock('_itemsContainer', $this->params) ?>
            </tbody>
        </table>

        <!-- Page Specific Plugins -->
        <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 133 */ ?>/js/tablesorter/jquery.tablesorter.js"></script>
        <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 134 */ ?>/js/tablesorter/tables.js"></script>
        <?php
        $this->global->snippetDriver->leave();

    }


    function blockItemsContainer($_args)
    {
        extract($_args);
        $this->global->snippetDriver->enter("itemsContainer", "static");
        $iterations = 0;
        foreach ($projects as $project) {
            ?>
            <tr class="clickable-row " data-href="#">

                <td class="<?php
                if ($project->active == 0) {
                    ?> deleted <?php
                }
                ?>">
                    <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Projects:project", [$project->id_project])) ?>"> <?php
                        echo LR\Filters::escapeHtmlText($project->project_name) /* line 92 */ ?> </a></td>
                <td class="<?php
                if ($project->active == 0) {
                    ?> deleted <?php
                }
                ?>">
                    <?php
                    if ($project->client != "") {
                        ?>                                <span
                                class="label label-warning"><?php echo LR\Filters::escapeHtmlText($project->client) /* line 95 */ ?></span>
                        <?php
                    } else {
                        ?>
                        <span class="gray"><i>(No Client)</i></span>
                        <?php
                    }
                    ?>

                </td>
                <td class="<?php
                if ($project->active == 0) {
                    ?> deleted <?php
                }
                ?>"><?php
                    if ($project->id_role == 1) {
                        ?>

                        <span class="label label-success">Admin</span>
                        <?php
                    } else {
                        ?>
                        <span class="label label-default">User</span>
                        <?php
                    }
                    ?>
                </td>
                <td class="<?php
                if ($project->active == 0) {
                    ?> deleted <?php
                }
                ?>"><?php echo LR\Filters::escapeHtmlText($project->status) /* line 107 */ ?>h
                </td>
                <td>
                    <?php
                    if ($project->id_role == 1) {
                        ?>
                        <ol class="breadcrumb cum">
                            <li><a
                                        class="ajax"
                                        href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("ProjectArchive!", [$project->id_project])) ?>"> <?php
                                    if ($project->active == 0) {
                                        ?>  <i
                                                class="fa fa-refresh blue"></i><?php
                                    } else {
                                        ?>  <i
                                                class="fa fa-check green"></i> <?php
                                    }
                                    ?>  </a></li>
                            <li><a data-toggle="modal" onclick="return OptionsSelected(this)"
                                   id=<?php echo LR\Filters::escapeHtmlAttrUnquoted($project->id_project) /* line 116 */ ?>  data-target="#myModal2"><i
                                            class="fa fa-edit orange"></i></a></li>
                            <li><a class="ajax"
                                   href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("ProjectDelete!", [$project->id_project])) ?>"><i
                                            class="fa fa-times red"></i></a></li>
                        </ol>
                        <?php
                    } else {
                        ?>                                <a class="ajax"
                                                             href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("ProjectLeave!", [$project->id_project])) ?>"><i
                                    class="fa fa-sign-out orange"></i></a>
                        <?php
                    }
                    ?>
                </td>

            </tr>
            <?php
            $iterations++;
        }
        ?>

        <?php
        $this->global->snippetDriver->leave();

    }


    function blockMessages($_args)
    {
        extract($_args);
        $this->global->snippetDriver->enter("messages", "static");
        ?><?php
        $iterations = 0;
        foreach ($flashes as $flash) {
            ?>

            <div class="alert alert-<?php echo LR\Filters::escapeHtmlAttr($flash->type) /* line 165 */ ?>">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                    &times;
                </button>
                <?php echo LR\Filters::escapeHtmlText($flash->message) /* line 169 */ ?>

            </div>
            <?php
            $iterations++;
        }
        $this->global->snippetDriver->leave();

    }


    function blockEditFormSnippet($_args)
    {
        extract($_args);
        $this->global->snippetDriver->enter("editFormSnippet", "static");
        ?>

        <?php
        $form = $_form = $this->global->formsStack[] = $this->global->uiControl["newEditForm"];
        ?>
        <form class="form ajax"<?php
        echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin(end($this->global->formsStack), array(
            'class' => NULL,
        ), false) ?>>
            <div class="modal-body">
                <div class="form-group">
                    <label<?php
                    $_input = end($this->global->formsStack)["projectName"];
                    echo $_input->getLabelPart()->attributes() ?>>Project name:</label>
                    <input class="form-control"<?php
                    $_input = end($this->global->formsStack)["projectName"];
                    echo $_input->getControlPart()->addAttributes(array(
                        'class' => NULL,
                    ))->attributes() ?>>
                </div>

                <div class="form-group">
                    <label<?php
                    $_input = end($this->global->formsStack)["client"];
                    echo $_input->getLabelPart()->attributes() ?>>Client:</label>
                    <input class="form-control"<?php
                    $_input = end($this->global->formsStack)["client"];
                    echo $_input->getControlPart()->addAttributes(array(
                        'class' => NULL,
                    ))->attributes() ?>>
                </div>
                <div class="form-group">
                    <label<?php
                    $_input = end($this->global->formsStack)["description"];
                    echo $_input->getLabelPart()->attributes() ?>> Description: </label>
                    <textarea class="form-control" rows="3"<?php
                    $_input = end($this->global->formsStack)["description"];
                    echo $_input->getControlPart()->addAttributes(array(
                        'class' => NULL,
                        'rows' => NULL,
                    ))->attributes() ?>><?php echo $_input->getControl()->getHtml() ?></textarea>
                </div>

                <div<?php echo ' id="' . htmlSpecialChars($this->global->snippetDriver->getHtmlId('messagesSave')) . '"' ?>>
                    <?php $this->renderBlock('_messagesSave', $this->params) ?>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-success" data-dismiss="modal"<?php
                $_input = end($this->global->formsStack)["saveProject"];
                echo $_input->getControlPart()->addAttributes(array(
                    'class' => NULL,
                    'data-dismiss' => NULL,
                ))->attributes() ?>><span
                            class="fa fa-check"> </span>Save
                </button>
            </div>
            <?php
            echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(array_pop($this->global->formsStack), false);
            ?>                            </form>

        <?php
        $this->global->snippetDriver->leave();

    }


    function blockMessagesSave($_args)
    {
        extract($_args);
        $this->global->snippetDriver->enter("messagesSave", "static");
        ?><?php
        $iterations = 0;
        foreach ($flashes as $flash) {
            ?>

            <div class="alert alert-<?php echo LR\Filters::escapeHtmlAttr($flash->type) /* line 218 */ ?>">
                <button type="button" class="close" data-dismiss="alert"
                        aria-hidden="true">&times;
                </button>
                <?php echo LR\Filters::escapeHtmlText($flash->message) /* line 222 */ ?>

            </div>
            <?php
            $iterations++;
        }
        $this->global->snippetDriver->leave();

    }

}
