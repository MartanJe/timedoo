<?php

namespace App\TrackModule\Model;

use App\Model\AbstractManager;
use Nette\Database\Table\IRow;
use Nette\Database\Table\Selection;
use Nette\UnexpectedValueException;
use Nette\Utils\ArrayHash;


/**
 * Class InviteManager
 * Handles invitations to the projects
 * @package App\FrontModule\Model
 */
class InviteManager extends AbstractManager
{

    public function  invite($fromUser, $toUser, $toProject)
    {
        $sql = "INSERT INTO invite (id_user_from, id_user_to, id_project) VALUES (?,?,?)";
        $this->m_database->query($sql, $fromUser, $toUser, $toProject);
    }

    public function getInvite($fromUser, $toUser, $toProject)
    {
        return $this->m_database->table('invite')->where('id_user_from = ? AND id_user_to = ? AND id_project = ?', $fromUser, $toUser, $toProject)->fetch();
    }

    public function  acceptInvitation($fromUser, $toUser, $toProject)
    {
        /// add contribute
        $sql = "INSERT INTO contribute (id_user, id_project, id_role) VALUES (?,?,?)";
        $this->m_database->query($sql, $toUser, $toProject, 2);

        /// delete invitation
        $sql = "DELETE FROM invite  WHERE id_user_from = ? AND id_user_to = ? AND id_project = ?";
        $this->m_database->query($sql, $fromUser, $toUser, $toProject);

    }

    public function  declineInvitation($fromUser, $toUser, $toProject)
    {
        /// delete invitation
        $sql = "DELETE FROM invite  WHERE id_user_from = ? AND id_user_to = ? AND id_project = ?";
        $this->m_database->query($sql, $fromUser, $toUser, $toProject);

    }

    public function getInvitations($userID)
    {
     $sql = "SELECT id_user_from, date_invite, id_user_to,  invite.id_project, user.username as username_from, 
             u.username as username_to, project.project_name as project_name from invite 
             join user on id_user_from = id_user join  ( select * from user  ) as u  
             on id_user_to = u.id_user join project on invite.id_project = project.id_project
             where  id_user_to = ?";
     return $this->m_database->query($sql, $userID);
    }
}