<?php
// source: C:\Users\marti\Dropbox\development\PHPStormProjects\timedoo\app\TrackModule/templates/Projects/project.latte

use Latte\Runtime as LR;

class Template4e6249f090 extends Latte\Runtime\Template
{
    public $blocks = [
        'content' => 'blockContent',
        '_TaskFilters' => 'blockTaskFilters',
        '_messages' => 'blockMessages',
        '_addFormSnippet' => 'blockAddFormSnippet',
        '_wholeTableTasks' => 'blockWholeTableTasks',
        '_itemsContainer' => 'blockItemsContainer',
        '_addFormSnippetMember' => 'blockAddFormSnippetMember',
        '_wholeTableMembers' => 'blockWholeTableMembers',
        '_itemsContainerMembers' => 'blockItemsContainerMembers',
        '_editTaskSnippet' => 'blockEditTaskSnippet',
        '_messagesSave' => 'blockMessagesSave',
    ];

    public $blockTypes = [
        'content' => 'html',
        '_TaskFilters' => 'html',
        '_messages' => 'html',
        '_addFormSnippet' => 'html',
        '_wholeTableTasks' => 'html',
        '_itemsContainer' => 'html',
        '_addFormSnippetMember' => 'html',
        '_wholeTableMembers' => 'html',
        '_itemsContainerMembers' => 'html',
        '_editTaskSnippet' => 'html',
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
        if (isset($this->params['flash'])) trigger_error('Variable $flash overwritten in foreach on line 84, 284');
        if (isset($this->params['task'])) trigger_error('Variable $task overwritten in foreach on line 143');
        if (isset($this->params['member'])) trigger_error('Variable $member overwritten in foreach on line 216');
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
            <div class="col-lg-6">
                <h1>Project
                    <small> <?php echo LR\Filters::escapeHtmlText($ProjectName) /* line 13 */ ?></small>
                </h1>
            </div>

            <div class="col-lg-2"></div>
            <div class="col-lg-2"></div>

            <div class="col-lg-2">
                <h1>
                    <a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Projects:default")) ?>">
                        <button type="button" class="btn btn-success btn-lg"><span class="fa fa-check"> </span> Done
                        </button>
                    </a></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">

                <ol class="breadcrumb">
                    <li class="active"><a
                                href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("default")) ?>"><i
                                    class="fa fa-edit"></i> Projects </a></li>
                    <li class="active"> Project</li>
                    <li class="active"></li>
                </ol>


            </div>

        </div><!-- /.row -->

        <div class="row">
            <div class="col-lg-6">

                <div class="panel panel-default">
                    <div class="panel-heading">Project description</div>

                    <div class="panel-body">

                        <?php
                        if ($Description == "") {
                            ?>
                            <i class="gray">(No description)</i>
                            <?php
                        } else {
                            ?>                <i
                                    class="gray">    <?php echo LR\Filters::escapeHtmlText($Description) /* line 48 */ ?> </i>
                            <?php
                        }
                        ?>
                    </div>

                </div>
            </div>

        </div>

        <div id="<?php echo htmlSpecialChars($this->global->snippetDriver->getHtmlId('TaskFilters')) ?>"><?php $this->renderBlock('_TaskFilters', $this->params) ?></div>
        <div class="row">
            <div class="col-lg-6">
                <div<?php echo ' id="' . htmlSpecialChars($this->global->snippetDriver->getHtmlId('messages')) . '"' ?>>
                    <?php $this->renderBlock('_messages', $this->params) ?>
                </div>
            </div>


        </div>


        <div class="row">
            <div class="col-lg-8">


                <div class="bs-example">

                    <ul class="nav nav-tabs" style="margin-bottom: 15px;">
                        <li class="active"><a href="#home" data-toggle="tab">Tasks</a></li>
                        <li><a href="#profile" data-toggle="tab">Team</a></li>
                    </ul>

                    <div id="myTabContent" class="tab-content">

                        <div class="tab-pane fade active in" id="home">


                            <div id="<?php echo htmlSpecialChars($this->global->snippetDriver->getHtmlId('addFormSnippet')) ?>"><?php
                                $this->renderBlock('_addFormSnippet', $this->params) ?></div>
                            <div class="table-responsive">
                                <div id="<?php echo htmlSpecialChars($this->global->snippetDriver->getHtmlId('wholeTableTasks')) ?>"><?php
                                    $this->renderBlock('_wholeTableTasks', $this->params) ?></div>
                            </div>

                        </div>


                        <div class="tab-pane fade" id="profile">

                            <?php
                            if ($userRole == 1) {
                                ?>
                                <div
                                id="<?php echo htmlSpecialChars($this->global->snippetDriver->getHtmlId('addFormSnippetMember')) ?>"><?php
                            $this->renderBlock('_addFormSnippetMember', $this->params) ?></div><?php
                            }
                            ?>

                            <div class="table-responsive">

                                <div id="<?php echo htmlSpecialChars($this->global->snippetDriver->getHtmlId('wholeTableMembers')) ?>"><?php
                                    $this->renderBlock('_wholeTableMembers', $this->params) ?></div>

                            </div>
                        </div>
                    </div>
                </div>


                <div id="myModal2" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Edit task</h4>
                            </div>

                            <div id="<?php echo htmlSpecialChars($this->global->snippetDriver->getHtmlId('editTaskSnippet')) ?>"><?php
                                $this->renderBlock('_editTaskSnippet', $this->params) ?></div>
                        </div>

                    </div>
                </div>
            </div>

        </div>


        <script type="text/javascript">

            $("#myCheckbox").click(function () {
                $.nette.ajax({
                    type: 'GET',
                    url: <?php echo LR\Filters::escapeJs($this->global->uiControl->link("ArchivedSwitchTasks!")) ?>,
                    data: {
                        'value': $(this).is(':checked')
                    }
                });
            });


            function OpenSelected(me) {
                $.nette.ajax({
                    type: 'GET',
                    url: <?php echo LR\Filters::escapeJs($this->global->uiControl->link("TaskEdit!")) ?>,
                    data: {'idTask': me.id}
                });
            }

            function OptionsSelected(me) {
                $.nette.ajax({
                    type: 'GET',
                    url: <?php echo LR\Filters::escapeJs($this->global->uiControl->link("AdminSwitch!")) ?>,
                    data: {'userID': me.value}
                });
            }

        </script>


        <?php
    }


    function blockTaskFilters($_args)
    {
        extract($_args);
        $this->global->snippetDriver->enter("TaskFilters", "static");
        ?>
        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">Filters</div>

                    <div class="panel-body">

                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" value="Show archived" id="myCheckbox" <?php
                                    if ($showArchivedTasks) {
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

            <div class="alert alert-<?php echo LR\Filters::escapeHtmlAttr($flash->type) /* line 85 */ ?>">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo LR\Filters::escapeHtmlText($flash->message) /* line 87 */ ?>

            </div>
            <?php
            $iterations++;
        }
        $this->global->snippetDriver->leave();

    }


    function blockAddFormSnippet($_args)
    {
        extract($_args);
        $this->global->snippetDriver->enter("addFormSnippet", "static");
        $form = $_form = $this->global->formsStack[] = $this->global->uiControl["newTaskForm"];
        ?>
        <form class="form ajax"<?php
        echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin(end($this->global->formsStack), array(
            'class' => NULL,
        ), false) ?>>
            <div class="col-lg-4">
                <div class="form-group">

                    <input class="form-control" placeholder="Add new task..."<?php
                    $_input = end($this->global->formsStack)["taskName"];
                    echo $_input->getControlPart()->addAttributes(array(
                        'class' => NULL,
                        'placeholder' => NULL,
                    ))->attributes() ?>>
                </div>
            </div>
            <button class="btn btn-success" <?php
            $_input = end($this->global->formsStack)["createTask"];
            echo $_input->getControlPart()->addAttributes(array(
                'class' => NULL,
            ))->attributes() ?>>Add
            </button>
            <?php
            echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(array_pop($this->global->formsStack), false);
            ?>                        </form>
        <?php
        $this->global->snippetDriver->leave();

    }


    function blockWholeTableTasks($_args)
    {
        extract($_args);
        $this->global->snippetDriver->enter("wholeTableTasks", "static");
        ?>
        <table class="table table-bordered table-hover tablesorter">
            <thead>
            <tr>
                <th>Task <i class="fa fa-sort"></i></th>
                <th>Author <i class="fa fa-sort"></i></th>
                <th>Assignee <i class="fa fa-sort"></i></th>
                <th>Status <i class="fa fa-sort"></i></th>
                <th>Options <i class=""></i></th>
            </tr>
            </thead>

            <tbody<?php echo ' id="' . htmlSpecialChars($this->global->snippetDriver->getHtmlId('itemsContainer')) . '"' ?>>
            <?php $this->renderBlock('_itemsContainer', $this->params) ?>
            </tbody>
        </table>
        <?php
        $this->global->snippetDriver->leave();

    }


    function blockItemsContainer($_args)
    {
        extract($_args);
        $this->global->snippetDriver->enter("itemsContainer", "static");
        $iterations = 0;
        foreach ($Tasks as $task) {
            ?>
            <tr class="clickable-row" data-href="#">

                <td class="<?php
                if ($task->active == 0) {
                    ?> deleted <?php
                }
                ?>"><?php echo LR\Filters::escapeHtmlText($task->task_name) /* line 145 */ ?> </td>

                <td class="<?php
                if ($task->active == 0) {
                    ?> deleted <?php
                }
                ?>">
                    <span class="gray"><i><?php echo LR\Filters::escapeHtmlText($task->author) /* line 147 */ ?></i></span>
                </td>

                <td class="<?php
                if ($task->active == 0) {
                    ?> deleted <?php
                }
                ?>">
                    <span class="gray"><i><?php echo LR\Filters::escapeHtmlText($task->assignee) /* line 151 */ ?></i></span>
                </td>

                <td class="<?php
                if ($task->active == 0) {
                    ?> deleted <?php
                }
                ?>"><?php echo LR\Filters::escapeHtmlText($task->status) /* line 154 */ ?> h
                </td>


                <td>
                    <?php
                    if ($userRole == 1 || $task->author == $task->assignee) {
                        ?>
                        <ol class="breadcrumb cum">
                            <li><a class="ajax"
                                   href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("TaskArchive!", [$task->id_task])) ?>"><?php
                                    if ($task->active == 0) {
                                        ?>  <i class="fa fa-refresh blue"></i><?php
                                    } else {
                                        ?>  <i class="fa fa-check green"></i> <?php
                                    }
                                    ?></a></li>
                            <li><a data-toggle="modal" onclick="return OpenSelected(this)" id=<?php
                                echo LR\Filters::escapeHtmlAttrUnquoted($task->id_task) /* line 162 */ ?>  data-target="#myModal2"><i
                                            class="fa fa-edit orange"></i></a></li>
                            <li><a class="ajax"
                                   href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("TaskDelete!", [$task->id_task])) ?>"><i
                                            class="fa fa-times red"></i></a></li>
                        </ol>
                        <?php
                    } else {
                        ?>
                        <ol class="breadcrumb cum">
                            <li><a class="ajax"
                                   href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("TaskArchive!", [$task->id_task])) ?>"><?php
                                    if ($task->active == 0) {
                                        ?>  <i class="fa fa-refresh blue"></i><?php
                                    } else {
                                        ?>  <i class="fa fa-check green"></i> <?php
                                    }
                                    ?></a></li>
                        </ol>
                        <?php
                    }
                    ?>
                </td>

            </tr>
            <?php
            $iterations++;
        }
        $this->global->snippetDriver->leave();

    }


    function blockAddFormSnippetMember($_args)
    {
        extract($_args);
        $this->global->snippetDriver->enter("addFormSnippetMember", "static");
        $form = $_form = $this->global->formsStack[] = $this->global->uiControl["newMemberForm"];
        ?>
        <form class="form ajax"<?php
        echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin(end($this->global->formsStack), array(
            'class' => NULL,
        ), false) ?>>
            <div class="col-lg-4">
                <div class="form-group">

                    <input class="form-control" placeholder="Add new member..."<?php
                    $_input = end($this->global->formsStack)["memberName"];
                    echo $_input->getControlPart()->addAttributes(array(
                        'class' => NULL,
                        'placeholder' => NULL,
                    ))->attributes() ?>>
                </div>
            </div>
            <button class="btn btn-success" <?php
            $_input = end($this->global->formsStack)["addMember"];
            echo $_input->getControlPart()->addAttributes(array(
                'class' => NULL,
            ))->attributes() ?>>Add
            </button>
            <?php
            echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(array_pop($this->global->formsStack), false);
            ?>                        </form>
        <?php
        $this->global->snippetDriver->leave();

    }


    function blockWholeTableMembers($_args)
    {
        extract($_args);
        $this->global->snippetDriver->enter("wholeTableMembers", "static");
        ?>
        <table class="table table-bordered table-hover tablesorter">
            <thead>
            <tr>
                <th>Member <i class="fa fa-sort"></i></th>
                <th>Role <i class="fa fa-sort"></i></th>
                <?php
                if ($userRole == 1) {
                    ?>
                    <th>Change Role <i class="fa"></i></th>
                    <th>Options <i class="fa"></i></th>
                    <?php
                }
                ?>
            </tr>
            </thead>

            <tbody<?php echo ' id="' . htmlSpecialChars($this->global->snippetDriver->getHtmlId('itemsContainerMembers')) . '"' ?>>
            <?php $this->renderBlock('_itemsContainerMembers', $this->params) ?>
            </tbody>
        </table>

        <?php
        $this->global->snippetDriver->leave();

    }


    function blockItemsContainerMembers($_args)
    {
        extract($_args);
        $this->global->snippetDriver->enter("itemsContainerMembers", "static");
        $iterations = 0;
        foreach ($Members as $member) {
            ?>
            <tr class="clickable-row" data-href="#">

                <td> <?php echo LR\Filters::escapeHtmlText($member->username) /* line 218 */ ?> </td>

                <td>
                    <?php
                    if ($member->id_role == 1) {
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

                <?php
                if ($userRole == 1) {
                    ?>
                    <td>
                        <?php
                        if ($member->id_user != $user->getID()) {
                            ?>                                    <p><input class=' ajax'
                                                                            onclick="return OptionsSelected(this)"
                                                                            type=checkbox name="sel[]" value=<?php
                                echo LR\Filters::escapeHtmlAttrUnquoted($member->id_user) /* line 233 */ ?> <?php
                                if ($member->id_role == 1) {
                                ?> checked <?php
                                }
                                ?>> Admin </p>
                            <?php
                        }
                        ?>
                    </td>

                    <td>
                        <?php
                        if ($member->id_user != $user->getID()) {
                            ?>
                            <ol class="breadcrumb cum">
                                <li><a class="ajax"
                                       href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("MemberDelete!", [$member->id_user])) ?>"><i
                                                class="fa fa-times red"></i></a></li>
                            </ol>
                            <?php
                        }
                        ?>
                    </td>

                    <?php
                }
                ?>
            </tr>
            <?php
            $iterations++;
        }
        $this->global->snippetDriver->leave();

    }


    function blockEditTaskSnippet($_args)
    {
        extract($_args);
        $this->global->snippetDriver->enter("editTaskSnippet", "static");
        $form = $_form = $this->global->formsStack[] = $this->global->uiControl["newEditTaskForm"];
        ?>
        <form class="form ajax"<?php
        echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin(end($this->global->formsStack), array(
            'class' => NULL,
        ), false) ?>>
            <div class="modal-body">
                <div class="form-group">
                    <label<?php
                    $_input = end($this->global->formsStack)["taskName"];
                    echo $_input->getLabelPart()->attributes() ?>>Task name:</label>
                    <input class="form-control"<?php
                    $_input = end($this->global->formsStack)["taskName"];
                    echo $_input->getControlPart()->addAttributes(array(
                        'class' => NULL,
                    ))->attributes() ?>>
                </div>
                <div class="form-group">
                    <label<?php
                    $_input = end($this->global->formsStack)["assignee"];
                    echo $_input->getLabelPart()->attributes() ?>>Assignee:</label>
                    <select class="form-control"<?php
                    $_input = end($this->global->formsStack)["assignee"];
                    echo $_input->getControlPart()->addAttributes(array(
                        'class' => NULL,
                    ))->attributes() ?>><?php echo $_input->getControl()->getHtml() ?></select>
                </div>

                <div<?php echo ' id="' . htmlSpecialChars($this->global->snippetDriver->getHtmlId('messagesSave')) . '"' ?>>
                    <?php $this->renderBlock('_messagesSave', $this->params) ?>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-success" <?php
                $_input = end($this->global->formsStack)["saveTask"];
                echo $_input->getControlPart()->addAttributes(array(
                    'class' => NULL,
                ))->attributes() ?>><span class="fa fa-check"> </span>Save
                </button>
            </div>
            <?php
            echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(array_pop($this->global->formsStack), false);
            ?>                    </form>
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

            <div class="alert alert-<?php echo LR\Filters::escapeHtmlAttr($flash->type) /* line 285 */ ?>">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo LR\Filters::escapeHtmlText($flash->message) /* line 287 */ ?>

            </div>
            <?php
            $iterations++;
        }
        $this->global->snippetDriver->leave();

    }

}
