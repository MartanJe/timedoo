<?php
// source: C:\Users\jencmart\Dropbox\development\PHPStormProjects\timedoo\app\TrackModule/templates/Login/@layout.latte

use Latte\Runtime as LR;

class Template42081e5e2a extends Latte\Runtime\Template
{

    function main()
    {
        extract($this->params);
        ?>
        <!doctype html>
        <html lang="en" class="no-js">
        <head>
            <meta charset="UTF-8">
            <title>Timedoo</title>


            <!-- Bootstrap core CSS -->
            <link href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 9 */ ?>/css/bootstrap.css"
                  rel="stylesheet">

            <!-- Add custom CSS here -->
            <link href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 12 */ ?>/css/sb-admin.css"
                  rel="stylesheet">
            <link rel="stylesheet"
                  href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 13 */ ?>/font-awesome/css/font-awesome.min.css">
            <!-- Page Specific CSS -->
            <link rel="stylesheet" href="http://cdn.oesmith.co.uk/morris-0.4.3.min.css">

            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet"
                  href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 18 */ ?>/css/styleLogin.css">
            <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
            <!-- remember, jQuery is completely optional -->


            <!-- <script type='text/javascript' src='js/jquery-1.11.1.min.js'></script> -->
            <script type='text/javascript'
                    src='<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 24 */ ?>/js/jquery.particleground.js'></script>
            <script type='text/javascript'
                    src='<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 25 */ ?>/js/login.js'></script>
        </head>

        <body>

        <div id="particles">
            <?php
            /* line 31 */
            $this->createTemplate("login.latte", $this->params, "include")->renderToContentType('html');
            $this->renderBlock('content', $this->params, 'html');
            ?>
        </div>

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

}
