<?php

namespace App\TrackModule\Presenters;

use App\Presenters\BasePresenter;
use App\TrackModule\Model\ProjectManager;
use App\TrackModule\Model\TaskManager;
use Nette\Application\UI\Form;

class TimerPresenter extends BasePresenter
{
    /** @var ProjectManager Instance tridy modelu pro praci s projekty. */
    protected $m_projectManager;

    /** @var TaskManager Instance tridy modelu pro praci s ukoly. */
    protected $m_taskManager;

    /**
     * Constructor with injected models for work with projects and tasks
     * @param ProjectManager $projectManager automatically injected class for work with projects
     * @param TaskManager $taskManager automatically injected class for work with tasks
     */
    public function __construct(ProjectManager $projectManager, TaskManager $taskManager)
    {
        parent::__construct();
        $this->m_projectManager = $projectManager;
        $this->m_taskManager = $taskManager;

    }

    /************************** ******************************************************************************************/
    /********************* EVENT HANDLERS*********************************************************************************/
    /************************   ******************************************************************************************/

    /**
     * @param $value
     */
    public function handleFirstChange($value)
    {
        if ($value) {
            $secondItems = $this->getSecond($value);
            $this['selectForm']['second']->setItems($secondItems)->setPrompt('Select');;

            $this->redrawControl('wrapper');
            $this->redrawControl('secondSnippet');

        } else {
            $this['selectForm']['second']->setPrompt('Select project first')->setItems([]);
        }
    }

    /*************************** ******************************************************************************************/
    /********************** FORM ******************************************************************************************/

    protected function getSecond($projectID)
    {
        $tasks = $this->m_taskManager->getTasks($this->user->getId(), $projectID, 0);
        $secondItems = array();
        foreach ($tasks as $task) {
            $secondItems[] = array($task->id_task => "$task->task_name");
        }
        return $secondItems;
    }

    public function processSelectForm(Form $form)
    {
        // TO SE MUSI DOMYSLET
        if ($this->m_taskManager->isTracking($this->user->getId())) {
            $this->m_taskManager->stopActivity($this->user->getId());

            $this['selectForm']['first']->setItems($this->getFirst())->setValue(0)->setDisabled(FALSE);
            $this['selectForm']['second']->setPrompt('First select project')->setDisabled(FALSE);
            $this['selectForm']['send']->caption = 'START';
            $this->flashMessage("Tracking stopped");
            return $this->redrawTimer();
        }

        $values = $form->getHttpData();
        unset($values['send']);
        $project = $values['first'];
        $task = $values['second'];

        if (!$project) {
            $this['selectForm']['first']->setItems($this->getFirst())->setValue(0);
            $this->flashMessage("Project not selected");
            return $this->redrawTimer();
        } else if (!$task) {
            $this['selectForm']['first']->setItems($this->getFirst())->setValue(0);
            $this->flashMessage("Task not selected");
            return $this->redrawTimer();
        } else {
            $this->m_taskManager->startActivity($this->user->getId(), $task);
            $data = $this->m_taskManager->getTrackingData($this->user->getId());
            $this['selectForm']['first']->setItems([])->setPrompt($data['project_name']);
            $this['selectForm']['second']->setItems([])->setPrompt($data['task_name']);
            $this['selectForm']['send']->caption = 'STOP';
            $this['selectForm']['first']->setDisabled(TRUE);
            $this['selectForm']['second']->setDisabled(TRUE);
            $this->flashMessage("Tracking started... ");
            return $this->redrawTimer();
        }
    }

    /*************************   ******************************************************************************************/
    protected function getFirst()
    {
        $projects = $this->m_projectManager->getUserProjects($this->user->getId(), 1);
        $firstItems = array(0 => 'Select');
        foreach ($projects as $project) {
            $firstItems[] = array($project->id_project => "$project->project_name");
        }
        return $firstItems;
    }

    private function redrawTimer()
    {
        $this->redrawControl('timerMenu');
        $this->redrawControl('bigSnippet');
        $this->redrawControl('messages');

    }

    protected function createComponentSelectForm()
    {
        $form = new Form;
        $form->getElementPrototype()->class('ajax');
        if ($this->m_taskManager->isTracking($this->user->getId())) {
            $data = $this->m_taskManager->getTrackingData($this->user->getId());

            $form->addSelect('first', 'Select project:')->setPrompt($data['project_name'])->setDisabled(true);
            $form->addSelect('second', 'Select task:')->setPrompt($data['task_name'])->setDisabled(true);
            $form->addSubmit('send', 'STOP');
            $form->onSuccess[] = [$this, 'processSelectForm'];

        } else {
            $form->addSelect('first', 'Select project:', $this->getFirst());
            $form->addSelect('second', 'Select task:')->setPrompt('First select project');
            $form->addSubmit('send', 'START');
            $form->onSuccess[] = [$this, 'processSelectForm'];

        }
        return $form;
    }
}