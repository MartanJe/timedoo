<?php

namespace App\TrackModule\Presenters;

use App\TrackModule\Model\InviteManager;
use App\TrackModule\Model\ProjectManager;
use App\TrackModule\Model\TaskManager;
use App\Presenters\BasePresenter;

class RequestsPresenter extends BasePresenter
{
    /** @var ProjectManager Instance tridy modelu pro praci s projekty. */
    protected $m_projectManager;

    /** @var TaskManager Instance tridy modelu pro praci s ukoly. */
    protected $m_taskManager;

    protected $m_inviteManager;

    /**
     * Constructor with injected models for work with projects and tasks
     * @param ProjectManager $projectManager  automatically injected class for work with projects
     * @param TaskManager $taskManager        automatically injected class for work with tasks
     */
    public function __construct(ProjectManager $projectManager, TaskManager $taskManager, InviteManager $inviteManager)
    {
        parent::__construct();
        $this->m_projectManager  = $projectManager;
        $this->m_taskManager     = $taskManager;
        $this->m_inviteManager   = $inviteManager;
    }

    /** vyrenderuje to default sablony */
    public function renderDefault()
    {
        $invitations = $this->m_inviteManager->getInvitations($this->user->getId());
        if( ! $invitations->fetch() )
        {
            $this->flashMessage("You don't have any new requests. ", "info");
        }
        $this->template->invitations = $invitations;
    }


    public function handleRequestAccept($fromID, $porojectID)
    {
        $this->m_inviteManager->acceptInvitation($fromID, $this->user->getId(), $porojectID);
        $this->flashMessage("Request accepted. Look at your new projects :-)", "success");
        $this->redrawRequestTable();
    }


    public function handleRequestDecline($fromID, $porojectID)
    {
        $this->m_inviteManager->declineInvitation($fromID, $this->user->getId(), $porojectID);
        $this->flashMessage("Request declined", "info");
        $this->redrawRequestTable();
    }


    private function redrawRequestTable()
    {
        $invitations = $this->m_inviteManager->getInvitations($this->user->getId());
        if( ! $invitations->fetch() )
        {
            $this->flashMessage("You don't have any new requests. ", "info");
        }
        $this->template->invitations = $invitations;
        $this->redrawControl('requestTable');
        $this->redrawControl('messages');
        return true;
    }
}