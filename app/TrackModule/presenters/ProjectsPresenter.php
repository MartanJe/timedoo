<?php

namespace App\TrackModule\Presenters;

use App\Model\UserManager;
use App\Presenters\BasePresenter;
use App\TrackModule\Model\InviteManager;
use App\TrackModule\Model\ProjectManager;
use App\TrackModule\Model\TaskManager;
use Nette\Application\UI\Form;

class ProjectsPresenter extends BasePresenter
{
    /** @var ProjectManager Instance tridy modelu pro praci s projekty. */
    protected $m_projectManager;

    /** @var TaskManager Instance tridy modelu pro praci s ukoly. */
    protected $m_taskManager;
    protected $m_userManager;
    protected $m_inviteManager;

    /**
     * Constructor with injected models for work with projects and tasks
     * @param ProjectManager $projectManager automatically injected class for work with projects
     * @param TaskManager $taskManager automatically injected class for work with tasks
     * @param UserManager $userManager
     */
    public function __construct(ProjectManager $projectManager, TaskManager $taskManager, UserManager $userManager, InviteManager $inviteManager)
    {
        parent::__construct();
        $this->m_projectManager = $projectManager;
        $this->m_taskManager = $taskManager;
        $this->m_userManager = $userManager;
        $this->m_inviteManager = $inviteManager;
    }

    /** vyrenderuje to default sablony */
    public function renderDefault()
    {
        $show = $this->m_userManager->getUserShowProject($this->user->getId());
        $this->template->projects = $this->m_projectManager->getUserProjects($this->user->getId(), !$show);
        $this->template->showArchived = $show;
    }

    public function actionProject($idProject)
    {


        if (!$this->isMyProject($idProject)) {
            $this->flashMessage("Error: project not found!", 'danger');
            $this->redrawControl('messagesErr');

            $this->redirect('default');
        }
        // CHECKNOUT SPRAVNOST ID TODO TODO TODO
        $showArchived = $this->m_userManager->getUserShowTasks($this->user->getId());
        $this->template->showArchivedTasks = $showArchived;
        $project = $this->m_projectManager->getProject($idProject);
        $tasks = $this->m_taskManager->getTasks($this->user->getId(), $idProject, $showArchived);
        $this->template->ProjectName = $project['project_name'];
        $this->template->DateCreated = $project['date_created'];
        $this->template->Description = $project['description'];
        $this->template->Client = $project['client'];
        $this->template->Tasks = $tasks;
        $this->template->Members = $this->m_projectManager->getMembers($idProject);
        $this->template->userRole = $this->m_projectManager->getRole($this->user->getId(), $idProject)['id_role'];
    }

///***************************************************************************************************
///******************************* PROJECT ***********************************************************
///*******************************  FORMS *********************************************************
///****************************************************************************************************

    //CREATE COMPONENT NEW PROJECT

    private function isMyProject($idProject)
    {
        $project = $this->m_projectManager->getProject($idProject);

        if (!$project) {
            return false;
        }

        $contribute = $this->m_projectManager->getContribute($this->user->getId(), $idProject);

        if (!$contribute) {
            return false;
        }

        return true;
    }

    //CREATE COMPONENT EDIT PROJECT

    public function createProjectFormSucceeded($form)
    {
        if (!$this->isAjax()) {
            $this->redirect('this');
            return true;
        } else {
            // Data extraction from form
            $projectName = $form->getValues()->projectName;
            $client = $form->getValues()->client;
            $description = $form->getValues()->description;

            // Error
            if ($this->m_projectManager->getProjectByName($projectName)) {
                $this->flashMessage("Error: project name already used!", 'danger');
                $this->redrawControl('messages');
                return false;
            } // Add project
            else {
                $this->m_projectManager->createProject($projectName, $client, $description, $this->user->getId());
                $this->flashMessage("Success: Project created!", 'success');
                $this->redrawControl('messages');
                return $this->redrawTableProjects();
            }
        }
    }

    //NEW PROJECT SUCCESS

    protected function redrawTableProjects()
    {
        $show = $this->m_userManager->getUserShowProject($this->user->getId());
        $this->template->projects = $this->m_projectManager->getUserProjects($this->user->getId(), !$show);
        $this->redrawControl('wholeTable');
        return true;
    }

    //EDIT PROJECT SUCCESS

    public function saveProjectFormSucceeded($form)
    {
        $projectID = $form->getValues()->editHidden;
        $oldProject = $this->m_projectManager->getProjectByName($form->getValues()->projectName);

        /// pokud narazime na stejne jmeno, ale id je jine -> kolize jmen
        if ($oldProject && $oldProject['id_project'] != $projectID) {
            $this->flashMessage("Error: project name already used!", 'danger');
            $this->redrawControl('messagesSave');
            return false;
        } else {
            $this->m_projectManager->updateProject($projectID, $form->getValues()->projectName, $form->getValues()->client, $form->getValues()->description);
            $this->flashMessage("All changes saved. You can close the window now.", 'success');
            $this->redrawControl('messagesSave');
            return $this->redrawTableProjects();
        }
    }


///***************************************************************************************************
///******************************** TASK ***********************************************************
///*******************************  FORMS *********************************************************
///**************************************************************************************************

    //CREATE COMPONENT NEW TASK

    public function createTaskFormSucceeded(Form $form)
    {
        if (!$this->isAjax()) {
            $this->redirect('this');
        } else {

            // Data extraction from form
            $taskName = $form->getValues()->taskName;

            $projectName = $this->template->ProjectName;
            $projectID = $this->m_projectManager->getProjectByName($projectName)['id_project'];
            // Error
            if ($this->m_taskManager->getTasksByName($projectID, $taskName)) {
                $this->flashMessage("Error: Task name in this project allready used!", 'danger');
                $this->redrawControl('messages');
                return false;
            } // Add task
            else {
                $this->m_taskManager->createTask($this->user->getId(), $projectID, $taskName);
                return $this->redrawTableTasks();
            }
        }
    }

    //NEW TASK SUCCESS

    protected function redrawTableTasks()
    {
        $projectID = $this->m_projectManager->getProjectByName($this->template->ProjectName)['id_project'];

        $showArchived = $this->m_userManager->getUserShowTasks($this->user->getId());
        $this->template->Tasks = $this->m_taskManager->getTasks($this->user->getId(), $projectID, $showArchived);
        $this['newTaskForm']['taskName']->setValue("");
        $this->redrawControl('wholeTableTasks');
        $this->redrawControl('addFormSnippet');
        return true;
    }

    //CREATE COMPONENT EDIT TASK

    public function saveTaskFormSucceeded(Form $form)
    {
        $taskID = $form->getValues()->editHidden;
        $projectID = $this->m_projectManager->getProjectByName($this->template->ProjectName)['id_project'];
        $oldTask = $this->m_taskManager->getTask($taskID);
        $taskName = $form->getValues()->taskName;

        $newName = $form->getValues()->taskName;
        $values = $form->getHttpData();
        unset($values['send']);
        $newAsigneID = $values['assignee'];

        if ($this->m_taskManager->getTasksByName($projectID, $taskName) && $this->m_taskManager->getTasksByName($projectID, $taskName)['id_task'] != $oldTask['id_task']) {
            $this->flashMessage("Error: project name already used!", 'danger');
            $this->redrawControl('messagesSave');
            return false;
        } else {
            $this->m_taskManager->updateTask($taskID, $newName, $newAsigneID);
            $this->flashMessage("All changes saved. You can close the window now.", 'success');
            $this->redrawControl('messagesSave');
            return $this->redrawTableTasks();
        }
    }

    //EDIT TASK SUCCESS

    public function addMemberFormSucceeded($form)
    {
        if (!$this->isAjax()) {
            $this->redirect('this');
            return true;
        } else {

            // Data extraction from form
            $memberName = $form->getValues()->memberName;
            $toUser = $this->m_userManager->getUser($memberName);

            $projectName = $this->template->ProjectName;
            $projectID = $this->m_projectManager->getProjectByName($projectName)['id_project'];

            // Error
            if (!$toUser) {
                $this->flashMessage("Error: No such user!", 'danger');
                $this->redrawControl('messages');
                return false;
            } else if ($toUser['id_user'] == $this->user->getId()) {

                $this->flashMessage("Warning: High probability you are imbecile! You are trying to invite yourselves...  fuck ass", 'warning');
                $this->redrawControl('messages');
            } else if ($this->m_projectManager->getMember($toUser['id_user'], $projectID)) {
                $this->flashMessage("This user is already part of this project yo dumbass...", 'info');
                $this->redrawControl('messages');
                return false;
            } else if ($this->m_inviteManager->getInvite($this->user->getId(), $toUser['id_user'], $projectID)) {

                $this->flashMessage("Info: Invitation allready pending...", 'info');
                $this->redrawControl('messages');
            } // Add invite
            else {
                $this->m_inviteManager->invite($this->user->getId(), $toUser['id_user'], $projectID);
                $this->flashMessage("User invited!", 'success');
                $this->redrawControl('messages');
                $this['newMemberForm']['memberName']->setValue("");
                $this->redrawControl('addFormSnippetMember');
                return $this->redrawTableMembers();
            }
        }
    }













///***************************************************************************************************
///******************************* MEMBERS ***********************************************************
///*******************************  FORMS *********************************************************
///***************************************************************************************************

    //CREATE COMPONENT NEW MEMBER

    protected function redrawTableMembers()
    {
        $project = $this->template->ProjectName;
        $dataProject = $this->m_projectManager->getProjectByName($project);
        $this->template->Members = $this->m_projectManager->getMembers($dataProject['id_project']);
        $this->redrawControl('wholeTableMembers');
        return true;
    }

    //NEW MEMBER SUCCESS

    public function handleArchivedSwitch($userID = '')
    {
        if (!$this->isAjax()) {
            $this->redirect($this);
        }

        $this->m_userManager->updateArchivedShowProject($this->user->getId());
        $show = $this->m_userManager->getUserShowProject($this->user->getId());
        $this->template->projects = $this->m_projectManager->getUserProjects($this->user->getId(), !$show);
        $this->redrawControl('wholeTable');
    }

///***************************************************************************************************
///******************************* PROJECT ***********************************************************
///******************************  HANDLERS *********************************************************
///****************************************************************************************************

    public function handleProjectEdit($idProject)
    {
        $project = $this->m_projectManager->getProject($idProject);
        $this['newEditForm']['projectName']->setValue($project['project_name']);
        $this['newEditForm']['client']->setValue($project['client']);
        $this['newEditForm']['description']->setValue($project['description']);
        $this['newEditForm']['editHidden']->setValue($idProject);
        $this->redrawControl('editFormSnippet');
    }

    public function handleProjectArchive($idProject = 0)
    {
        $this->m_projectManager->archiveProject($idProject);
        $show = $this->m_userManager->getUserShowProject($this->user->getId());
        $this->template->projects = $this->m_projectManager->getUserProjects($this->user->getId(), !$show);
        $this->redrawControl('wholeTable');
    }

    public function handleProjectDelete($idProject)
    {
        if (!$this->isAjax()) {
            $this->redirect($this);
        }

        $this->m_projectManager->deleteProject($idProject);
        return $this->redrawTableProjects();
    }

    public function handleProjectLeave($idProject)
    {
        if (!$this->isAjax()) {
            $this->redirect($this);
        }

        $this->m_projectManager->removeUser($this->user->getId(), $idProject);
        return $this->redrawTableProjects();
    }

    public function handleArchivedSwitchTasks($value = '')
    {
        if (!$this->isAjax()) {
            $this->redirect($this);
        }
        $this->m_userManager->updateArchivedShowTasks($this->user->getId());
        return $this->redrawTableTasks();
    }


///***************************************************************************************************
///********************************* TASK ***********************************************************
///******************************  HANDLERS *********************************************************
///****************************************************************************************************

    public function handleTaskEdit($idTask)
    {
        $task = $this->m_taskManager->getTask($idTask);
        $this['newEditTaskForm']['taskName']->setValue($task['task_name']);
        $this['newEditTaskForm']['assignee']->setItems($this->getMembers($idTask))->setValue($this->m_taskManager->getTask($idTask)['id_user_processor']);
        $this['newEditTaskForm']['editHidden']->setValue($idTask);

        $this->redrawControl('editTaskSnippet');
    }

    private function getMembers($idTask)
    {
        $project = $this->template->ProjectName;
        $dataProject = $this->m_projectManager->getProjectByName($project);
        $members = $this->m_projectManager->getMembers($dataProject['id_project']);
        $currentMemberID = $this->m_taskManager->getTask($idTask)['id_user_processor'];
        $memberArray = array($currentMemberID => $this->m_userManager->getUserByID($currentMemberID)['username']);

        foreach ($members as $member) {
            //pokud to neni ten current
            if ($member->id_user != $currentMemberID)
                $memberArray[] = array($member->id_user => "$member->username");
        }
        return $memberArray;
    }

    public function handleTaskArchive($idTask)
    {
        if (!$this->isAjax()) {
            $this->redirect($this);
        }

        $this->m_taskManager->archiveTask($idTask);

        return $this->redrawTableTasks();
    }

    public function handleTaskDelete($idTask)
    {
        if (!$this->isAjax()) {
            $this->redirect($this);
        }
        $this->m_taskManager->deleteTask($idTask);
        return $this->redrawTableTasks();
    }

    public function handleMemberDelete($idMember)
    {
        if (!$this->isAjax()) {
            $this->redirect($this);
        }

        $projectID = $this->m_projectManager->getProjectByName($this->template->ProjectName)['id_project'];
        $this->m_projectManager->removeUser($idMember, $projectID);
        return $this->redrawTableMembers();
    }


///***************************************************************************************************
///******************************** MEMBER ***********************************************************
///******************************  HANDLERS *********************************************************
///****************************************************************************************************

    public function handleAdminSwitch($userID)
    {
        if (!$this->isAjax()) {
            $this->redirect($this);
        }

        $project = $this->template->ProjectName;
        $this->m_projectManager->changeUserRole($userID, $project);
        return $this->redrawTableMembers();
    }

    protected function createComponentNewProjectForm()
    {
        $form = new Form;
        $form->getElementPrototype()->class('ajax');
        $form->addText('projectName', 'Project Name')->setRequired();
        $form->addText('client', 'Client');
        $form->addTextArea('description', 'Description');
        $form->addSubmit('createProject', 'Create project');
        $form->onSuccess[] = [$this, 'createProjectFormSucceeded'];;
        return $form;
    }

///************************************************************************************************
///******************************** REDRAWERS ***********************************************************
///************************************************************************************************

    protected function createComponentNewEditForm()
    {
        $form = new Form;
        $form->getElementPrototype()->class('ajax');
        $form->addText('projectName', 'Project Name')->setRequired();
        $form->addText('client', 'Client');
        $form->addTextArea('description', 'Description');
        $form->addSubmit('saveProject', 'Create project');
        $form->addHidden('editHidden');
        $form->onSuccess[] = [$this, 'saveProjectFormSucceeded'];
        return $form;
    }

    protected function createComponentNewTaskForm()
    {
        $form = new Form;
        $form->getElementPrototype()->class('ajax');
        $form->addText('taskName', 'Task Name')->setRequired();
        $form->addSubmit('createTask', 'Create task');
        $form->onSuccess[] = [$this, 'createTaskFormSucceeded'];;
        return $form;
    }

    protected function createComponentNewEditTaskForm()
    {
        $form = new Form;
        $form->getElementPrototype()->class('ajax');
        $form->addText('taskName', 'Task Name')->setRequired();
        $form->addSelect('assignee', 'Assignee');
        $form->addSubmit('saveTask', 'Create project');
        $form->addHidden('editHidden');
        $form->onSuccess[] = [$this, 'saveTaskFormSucceeded'];
        return $form;
    }

    protected function createComponentNewMemberForm()
    {
        $form = new Form;
        $form->getElementPrototype()->class('ajax');
        $form->addText('memberName', 'Member Name')->setRequired();
        $form->addSubmit('addMember', 'Add member');
        $form->onSuccess[] = [$this, 'addMemberFormSucceeded'];;
        return $form;
    }
}
