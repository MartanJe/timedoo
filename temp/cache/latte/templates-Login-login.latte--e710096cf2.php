<?php
// source: C:\Users\jencmart\Dropbox\development\PHPStormProjects\timedoo\app\TrackModule\templates\Login\login.latte

class Templatee710096cf2 extends Latte\Runtime\Template
{

    function main()
    {
        extract($this->params);
        return get_defined_vars();
    }


    function prepare()
    {
        extract($this->params);
        Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);

    }

}
