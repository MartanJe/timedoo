<?php

namespace App\TrackModule\Model;

use App\Model\AbstractManager;
use Nette\Database\Table\IRow;
use Nette\Database\Table\Selection;
use Nette\Utils\ArrayHash;


class ProjectManager extends AbstractManager
{

    public function archiveProject($idProject)
    {
        $project = $this->m_database->table('project')->get($idProject);
        $projectData = $project->toArray();
        $active =  $projectData['active'];

        if($active)
        {
            $sql = "UPDATE `project` SET `active`=0 WHERE (`id_project` = ?)";
            $this->m_database->query($sql, $idProject);
        }
        else
        {
            $sql = "UPDATE `project` SET `active`=1 WHERE (`id_project` = ?)";
            $this->m_database->query($sql, $idProject);
        }
    }

    public function deleteProject($projectID)
    {
        /// smaz activity
        $sql = "DELETE FROM activity WHERE id_activity IN (
                SELECT * FROM (
                    select  activity.id_activity 
            from project join task on project.id_project = task.id_project join activity on activity.id_task = task.id_task
            where project.id_project = ?
                ) AS p
            )";
        $this->m_database->query($sql, $projectID);

        /// smaz task
        $sql = "DELETE FROM task WHERE id_project = ? ";
        $this->m_database->query($sql, $projectID);

        /// smaz contritute
        $sql = "DELETE FROM contribute WHERE id_project = ? ";
        $this->m_database->query($sql, $projectID);

        /// smaz invite
        $sql = "DELETE FROM invite WHERE id_project = ? ";
        $this->m_database->query($sql, $projectID);

        /// smaz projekt
        $sql = "DELETE FROM project WHERE id_project = ?";
        $this->m_database->query($sql, $projectID);
    }

    /**
     * Returns projects in which user contributes
     */
    public function getUserProjects($idUser, $active)
    {
        $sql = "SELECT DISTINCT project.project_name, 
                                project.id_project,
                                project.active,
                                COALESCE(project.client, \"\") as client , 
                                contribute.id_role,
                                COALESCE(status, 0) AS status  
                FROM project join contribute  LEFT JOIN 
                    (SELECT id_project,  sum(status)  as status 
                    from (SELECT DISTINCT  task.id_task,  task.id_project,COALESCE((SELECT  SUM( TIMESTAMPDIFF(HOUR,`date_activity_start`,  COALESCE( `date_activity_end` , CURRENT_TIMESTAMP)  )     ) 
                                                                                    FROM activity  WHERE  activity.id_task= task.id_task GROUP BY  activity.id_task), 0 ) as status
                                FROM  project JOIN task JOIN activity  )  as t1 group by id_project) as t2 ON project.id_project = t2.id_project
                          
                WHERE contribute.id_user = ? AND contribute.id_project = project.id_project 
                AND ( t2.id_project = project.id_project  OR  NOT EXISTS ( SELECT * FROM task where id_project = t2.id_project) )and (project.active = 1 OR project.active = ?)  ";
        $projects = $this->m_database->query($sql,$idUser,  $active);
        return $projects;
    }



    public function getUserProjectsForStats($idUser, $onlyActive)
    {
        $sql = "SELECT DISTINCT project.project_name, 
                                project.id_project,
                                COALESCE(project.client, \"\") as client,
                                COALESCE( FLOOR(status/3600), 0) AS status_h,
                                COALESCE( FLOOR(  MOD( status/60 , 60 ) ), 0) AS status_m,
                                COALESCE( MOD(status, 60 ), 0) AS status_s
                FROM project join contribute  LEFT JOIN 
                    (SELECT id_project,  COALESCE(sum(status),0)  as status 
                    from (SELECT DISTINCT  task.id_task,  task.id_project,COALESCE((SELECT  SUM( TIMESTAMPDIFF(SECOND,`date_activity_start`,  COALESCE( `date_activity_end` , CURRENT_TIMESTAMP)  )     ) 
                                                                                    FROM activity  WHERE  activity.id_task= task.id_task GROUP BY  activity.id_task), 0 ) as status
                                FROM  project JOIN task JOIN activity  )  as t1 group by id_project) as t2 ON project.id_project = t2.id_project
                          
                WHERE contribute.id_user = ? AND contribute.id_project = project.id_project 
                AND ( t2.id_project = project.id_project  OR  NOT EXISTS ( SELECT * FROM task where id_project = t2.id_project) )and (project.active = 1 OR project.active = ?)  ";
        $projects = $this->m_database->query($sql,$idUser,  $onlyActive);
        return $projects;
    }









    /**
     * zjjisti tvoji roli v danem projektu
     * @param $idUser
     * @param $idProject
     * @return \Nette\Database\ResultSet
     */
    public function getRole($idUser, $idProject)
    {
       // $sql ="SELECT  id_role, description FROM role WHERE id_role = (SELECT  DISTINCT contribute.id_role FROM contribute WHERE contribute.id_user = ? AND contribute.id_project = ?)";
        //$role = $this->m_database->query($sql, $idUser, $idProject);
        //return $role;
        return $this->m_database->table('contribute')->where('id_user', $idUser)->where('id_project', $idProject)->fetch();
    }




    public function getProject($projectID)
    {
        return $this->m_database->table('project')->where('id_project', $projectID)->fetch();
    }

    public function addUser($userID, $projectID)
    {
        $sql = "INSERT INTO contribute (id_user, id_project, id_role) VALUES (?, ?, '1')";
        $this->m_database->query($sql, $userID, $projectID, 2);
    }



    public function removeUser($userID, $projectID)
    {

// TODO tasks and activity of the user remains !!! handle carefully !!!
        $sql = "DELETE FROM contribute WHERE id_user = ? AND id_project = ?";
        $this->m_database->query($sql, $userID, $projectID);
    }

    public function changeUserRole($userID, $projectName)
    {
        $project = $this->m_database->table('project')->where('project_name', $projectName)->fetch();
        $projectID = $project['id_project'];
        $contribute = $this->m_database->table('contribute')->where('id_user', $userID)->where('id_project', $projectID)->fetch();
        $sql = "UPDATE contribute SET id_role = ? WHERE id_user = ? AND id_project = ?";
        if($contribute['id_role'] == 1)
        {
            $this->m_database->query($sql, 2, $userID, $projectID);
        }
        else
        {
            $this->m_database->query($sql, 1, $userID, $projectID);
        }
    }

    public function getMembers($idProject)
    {
        $sql ="SELECT   contribute.id_user, (SELECT username from user where user.id_user = contribute.id_user) as username,  id_role FROM contribute  WHERE contribute.id_project = ?";
        $members = $this->m_database->query($sql, $idProject);
        return $members;

    }

    public function getProjectByName($projectName, $workspace = 1)
    {
        return $this->m_database->table('project')->where('project_name', $projectName)->fetch();
    }

    public function createProject($projectName, $client, $description, $userID)
    {
         // create project
        $sql = "INSERT INTO project (project_name, active, client, description ) VALUES  ( ?,?,?,?)";
        $this->m_database->query($sql, $projectName, 1, $client, $description);

        // add contribution to the user
        $sql = "INSERT INTO contribute (id_user, id_project, id_role) VALUES (?, ?, '1')";
        $this->m_database->query($sql, $userID, $this->m_database->getInsertId());
    }

    public function getMember($id_user, $projectID)
    {
        return $this->m_database->table('contribute')->where('id_user = ? AND id_project = ?', $id_user, $projectID)->fetch();
    }

    public function updateProject($projectID, $projectName, $client, $description)
    {
        $sql = "UPDATE project SET project_name = ? , client = ? , description = ? WHERE id_project = ?";
        $this->m_database->query($sql,  $projectName, $client, $description, $projectID);
    }

    public function getContribute($getId, $idProject)
    {
        return $this->m_database->table('contribute')->where('id_user = ? AND id_project = ?', $getId, $idProject)->fetch();
    }


}