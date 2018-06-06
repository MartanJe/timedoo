<?php

namespace App\TrackModule\Presenters;

use App\TrackModule\Model\ProjectManager;
use App\TrackModule\Model\TaskManager;
use App\Presenters\BasePresenter;



class StatsPresenter extends BasePresenter
{
    /** @var ProjectManager Instance tridy modelu pro praci s projekty. */
    protected $m_projectManager;

    /** @var TaskManager Instance tridy modelu pro praci s ukoly. */
    protected $m_taskManager;

    /**
     * Constructor with injected models for work with projects and tasks
     * @param ProjectManager $projectManager  automatically injected class for work with projects
     * @param TaskManager $taskManager        automatically injected class for work with tasks
     */
    public function __construct(ProjectManager $projectManager, TaskManager $taskManager)
    {
        parent::__construct();
        $this->m_projectManager  = $projectManager;
        $this->m_taskManager     = $taskManager;
    }

    /** vyrenderuje to default sablony */
    public function renderDefault()
    {
        /* DATA PROJECT - TASK*/
        $data = $this->m_projectManager->getUserProjectsForStats($this->user->getId(), 0);
        $dataEdited = array();
        $i = 1;
        foreach ($data  as $d)
        {
            $projectID = $d->id_project;
            $dataEdited[] = array( 'rootNum' => $i, 'parentNum' => "", 'name' => $d->project_name, 'projectID' => $projectID, 'client' => $d->client, 'statusH' =>$d->status_h, 'statusM' => $d->status_m, 'statusS' => $d->status_s );
            $dataTasks = $this->m_taskManager->getTasksForStats($this->user->getId(),$projectID,1);
            if($dataTasks->fetch())
            {
                $parent = $i;
                $dataTasksFinal  = $this->m_taskManager->getTasksForStats($this->user->getId(),$projectID,1);
                foreach ($dataTasksFinal  as $d2)
                {
                    $i++;
                    $dataEdited[] = array( 'rootNum' => $i, 'parentNum' => "$parent", 'name' => $d2->task_name, 'taskID' => $d2->id_task, 'statusH' =>$d2->status_h, 'statusM' => $d2->status_m, 'statusS' => $d2->status_s );
                }
            }
                $i++;
        }
        $this->template->datas = $dataEdited;


        /* DATA PROJECT - USER*/
        $data = $this->m_projectManager->getUserProjectsForStats($this->user->getId(), 0);
        $dataEdited2 = array();
        $i = 1;
        foreach ($data  as $d)
        {
            $projectID = $d->id_project;
            $dataEdited2[] = array( 'rootNum' => $i, 'parentNum' => "", 'name' => $d->project_name, 'projectID' => $projectID, 'client' => $d->client, 'statusH' =>$d->status_h, 'statusM' => $d->status_m, 'statusS' => $d->status_s );

            $dataUsers = $this->m_taskManager->getUsersTasksForStats($projectID);

            if($dataUsers->fetch())
            {
                $parent = $i;
                $dataUsers  = $this->m_taskManager->getUsersTasksForStats($projectID);
                foreach ($dataUsers  as $d2)
                {
                    $i++;
                    $dataEdited2[] = array( 'rootNum' => $i, 'parentNum' => "$parent", 'name' => $d2->username, 'userID' => $d2->id_user, 'statusH' =>$d2->status_h, 'statusM' => $d2->status_m, 'statusS' => $d2->status_s );
                }
            }
            $i++;
        }

        $this->template->datas2 = $dataEdited2;
    }


    public function renderInDepth()
    {
        /* DATA ONE USER - TASK - ENTRY */ //projectname, project id, taskname, taskid, suma aktivit
        $data = $this->m_taskManager->getUserTasks($this->user->getId());
        $dataEdited = array();
        $i = 1;
        foreach ($data  as $d)
        {
            $taskID = $d->id_task;
            $projectName =  $d->project_name;
            $taskName =   $d->task_name;
            $dataEdited[] = array( 'rootNum' => $i, 'parentNum' => "", 'nameProject' => $projectName, 'nameTask' => $taskName, 'taskID' => $taskID,  'statusH' =>$d->status_h, 'statusM' => $d->status_m, 'statusS' => $d->status_s );


            $dataTasks = $this->m_taskManager->getEntriesForStats($this->user->getId(),$taskID);
            if($dataTasks->fetch())
            {
                $parent = $i;
                $dataTasksFinal  = $this->m_taskManager->getEntriesForStats($this->user->getId(),$taskID);
                foreach ($dataTasksFinal  as $d2)
                {
                    $i++;
                    $dataEdited[] = array( 'rootNum' => $i, 'parentNum' => "$parent", 'nameProject' => $projectName, 'nameTask' => $taskName, 'dateStart' => $d2->date_start , 'taskID' => $taskID, 'statusH' =>$d2->status_h, 'statusM' => $d2->status_m, 'statusS' => $d2->status_s );
                }
            }
            $i++;
        }
        $this->template->datas3 = $dataEdited;
    }

}