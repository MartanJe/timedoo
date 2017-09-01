<?php
// source: C:\Users\marti\Dropbox\development\PHPStormProjects\timedoo\app\TrackModule\templates\Login\login.latte

class Templateb7e02cf752 extends Latte\Runtime\Template
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
