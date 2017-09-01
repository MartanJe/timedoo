<?php
// source: C:\Users\jencmart\Dropbox\development\PHPStormProjects\timedoo\app\TrackModule/templates/Stats/inDepth.latte

use Latte\Runtime as LR;

class Templatef32c81eb11 extends Latte\Runtime\Template
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
        if (isset($this->params['data'])) trigger_error('Variable $data overwritten in foreach on line 41');
        Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);

    }


    function blockContent($_args)
    {
        extract($_args);
        ?>

        <script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 3 */ ?>/js/collapsableTable.js"></script>

        <script>
            $(function () {
                $.nette.init();// And you fly...
            });
        </script>

        <div class="row">
            <div class="col-lg-12">
                <h1>Stats
                    <small>In depth stats</small>
                </h1>
            </div>
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li class="active"><i class="fa fa-edit"></i> Stats</li>
                    <li class="active">
                    </li>
                </ol>
            </div>
        </div><!-- /.row -->


        <div class="row">
            <div class="col-lg-8">
                <h2>YOUR TASKS + activity log</h2>
                <div class="table-responsive">
                    <table class="collaptable table table-bordered table-hover tablesorter">
                        <thead>
                        <tr>
                            <th>Task <i class="fa fa-sort"></i></th>
                            <th>Project <i class="fa fa-sort"></i></th>
                            <th>Status <i class="fa fa-sort"></i></th>
                            <th>Date <i class="fa fa-sort"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $iterations = 0;
                        foreach ($datas3 as $data) {
                            ?>
                            <tr data-id="<?php echo LR\Filters::escapeHtmlAttr($data['rootNum']) /* line 41 */ ?>"
                                data-parent="<?php
                                echo LR\Filters::escapeHtmlAttr($data['parentNum']) /* line 41 */ ?>" class="<?php
                            if ($data['parentNum'] != '') {
                                ?> gray <?php
                            }
                            ?>">
                                <td><?php echo LR\Filters::escapeHtmlText($data['nameTask']) /* line 42 */ ?></td>
                                <td><?php echo LR\Filters::escapeHtmlText($data['nameProject']) /* line 43 */ ?></td>
                                <td><?php
                                    if ($data['statusH'] < 10) {
                                        ?>0<?php
                                    }
                                    echo LR\Filters::escapeHtmlText($data['statusH']) /* line 44 */ ?>:<?php
                                    if ($data['statusM'] < 10) {
                                        ?>0<?php
                                    }
                                    echo LR\Filters::escapeHtmlText($data['statusM']) /* line 44 */ ?>:<?php
                                    if ($data['statusS'] < 10) {
                                        ?>0<?php
                                    }
                                    echo LR\Filters::escapeHtmlText($data['statusS']) /* line 44 */ ?></td>
                                <?php
                                if ($data['parentNum'] != '') {
                                    ?>
                                    <td> <?php echo LR\Filters::escapeHtmlText($data['dateStart']) /* line 45 */ ?> </td> <?php
                                }
                                ?>

                            </tr>
                            <?php
                            $iterations++;
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script>

            $('.collaptable').aCollapTable({
// the table is collapased at start
                startCollapsed: true,
// the plus/minus button will be added like a column
                addColumn: true,
// The expand button ("plus" +)
                plusButton: '<span class="i fa fa-toggle-right red"></span>',
// The collapse button ("minus" -)
                minusButton: '<span class="i fa fa-toggle-down"></span>'

            });

        </script>


        <?php
    }

}
