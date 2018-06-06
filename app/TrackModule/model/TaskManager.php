<?php

namespace App\TrackModule\Model;

use App\Model\AbstractManager;
use Nette\Database\Table\IRow;
use Nette\Database\Table\Selection;
use Nette\Utils\ArrayHash;
use Nette\UnexpectedValueException;


class DuplicateTaskException extends UnexpectedValueException
{
    /** Konstruktor s definicích výchozí chybové zprávy. */
    /**
     * DuplicateTaskException constructor.
     * @param string $name
     */
    public function __construct($name)
    {
        parent::__construct();
        $this->message = "There is alrready \"$name\" task. Choose another name bitch!";
    }
}

class TaskManager extends AbstractManager
{
    /**
     * Vybere ty na kterych pracuji; dulezite pro timer
     * @param $idUser
     * @param $idProject
     * @return \Nette\Database\ResultSet
     */
    public function getMyWorkTasks($idUser, $idProject)
    {
        $sql = "SELECT task_name, id_task, id_project, id_user_author, id_user_processor FROM task WHERE `id_user_processor` = ? AND `id_project` = ?";
        $tasks = $this->m_database->query($sql, $idUser, $idProject);
        return $tasks;
    }

    /**
     * vyber vsechny projekty, se kterymi muzu manipulovat
     * @param $idUser
     * @param $idProject
     * @return \Nette\Database\ResultSet
     */
    public function getTasks($idUser, $idProject, $showArchived)
    {
        $taskState = !$showArchived; // showArchived = 1 kdyz chci videt
        $sql = "SELECT  id_role FROM role WHERE id_role = (SELECT  DISTINCT contribute.id_role FROM contribute WHERE contribute.id_user = ? AND contribute.id_project = ?)";
        $roles = $this->m_database->query($sql, $idUser, $idProject);
        foreach ($roles as $row) {

            /// JSEM USER
            if ($row->id_role == 2) {
                $sql2 = "SELECT DISTINCT task.task_name, task.id_task, task.id_project, task.active, (SELECT username FROM user WHERE user.id_user =  task.id_user_author) AS author, 
                        (SELECT username FROM user WHERE user.id_user =  task.id_user_processor) AS assignee ,
                        COALESCE(  (SELECT  SUM(   TIMESTAMPDIFF(HOUR,`date_activity_start`,  COALESCE( `date_activity_end` , CURRENT_TIMESTAMP)  )   ) 
                        FROM activity
                        WHERE  activity.id_task= task.id_task
                        GROUP BY  activity.id_task), 0 ) as status
                        
                
                        FROM task JOIN project  JOIN activity
                         WHERE  id_user_processor = ?   AND task.id_project = ? AND ( task.active = 1 OR task.active = ?);
                        ";

//OR id_user_author = ?
                $tasks = $this->m_database->query($sql2, $idUser, $idProject, $taskState);
                return $tasks;
            } /// JSEM ADMIN
            else {
                $sql2 = "SELECT DISTINCT task.task_name, task.id_task, task.id_project, task.active, (SELECT username FROM user WHERE user.id_user =  task.id_user_author) AS author, (SELECT username FROM user WHERE user.id_user =  task.id_user_processor) AS assignee ,
                        
                        COALESCE(  (SELECT  SUM(  
                        TIMESTAMPDIFF(HOUR,`date_activity_start`,  COALESCE( `date_activity_end` , CURRENT_TIMESTAMP)  )  
                        ) 
                        FROM activity
                        WHERE  activity.id_task= task.id_task
                        GROUP BY  activity.id_task), 0 ) as status
                        FROM task JOIN project  JOIN activity
                         WHERE task.id_project = ?  AND ( task.active = 1 or task.active = ?);
                        ";
                $tasks = $this->m_database->query($sql2, $idProject, $taskState);
                return $tasks;
            }
        }

    }


    public function getTasksForStats($idUser, $idProject, $showArchived)
    {
        $taskState = !$showArchived; // showArchived = 1 kdyz chci videt
        $sql = "SELECT  id_role FROM role WHERE id_role = (SELECT  DISTINCT contribute.id_role FROM contribute WHERE contribute.id_user = ? AND contribute.id_project = ?)";
        $roles = $this->m_database->query($sql, $idUser, $idProject);
        foreach ($roles as $row) {

            /// JSEM USER
            if ($row->id_role == 2) {
                $sql2 = "SELECT DISTINCT task.task_name, task.id_task, task.id_project, task.active, (SELECT username FROM user WHERE user.id_user =  task.id_user_author) AS author, 
                        (SELECT username FROM user WHERE user.id_user =  task.id_user_processor) AS assignee ,
                                                
                        COALESCE( FLOOR( COALESCE(  (SELECT  SUM(   TIMESTAMPDIFF(SECOND,`date_activity_start`,  COALESCE( `date_activity_end` , CURRENT_TIMESTAMP)  )   ) FROM activity WHERE  activity.id_task= task.id_task GROUP BY  activity.id_task), 0 ) /3600), 0) AS status_h,
                        COALESCE( FLOOR(  MOD(   COALESCE(  (SELECT  SUM(   TIMESTAMPDIFF(SECOND,`date_activity_start`,  COALESCE( `date_activity_end` , CURRENT_TIMESTAMP)  )   ) FROM activity WHERE  activity.id_task= task.id_task GROUP BY  activity.id_task), 0 ) /60 , 60 ) ), 0) AS status_m,
                        COALESCE( MOD( COALESCE(  (SELECT  SUM(   TIMESTAMPDIFF(SECOND,`date_activity_start`,  COALESCE( `date_activity_end` , CURRENT_TIMESTAMP)  )   ) FROM activity WHERE  activity.id_task= task.id_task GROUP BY  activity.id_task), 0 ) , 60 ), 0) AS status_s
                        
                
                        FROM task JOIN project  JOIN activity
                         WHERE  id_user_processor = ?   AND task.id_project = ? AND ( task.active = 1 OR task.active = ?);
                        ";

//OR id_user_author = ?
                $tasks = $this->m_database->query($sql2, $idUser, $idProject, $taskState);
                return $tasks;
            } /// JSEM ADMIN
            else {
                $sql2 = "SELECT DISTINCT task.task_name, task.id_task, task.id_project, task.active, (SELECT username FROM user WHERE user.id_user =  task.id_user_author) AS author, (SELECT username FROM user WHERE user.id_user =  task.id_user_processor) AS assignee ,
                        COALESCE( FLOOR( COALESCE(  (SELECT  SUM(   TIMESTAMPDIFF(SECOND,`date_activity_start`,  COALESCE( `date_activity_end` , CURRENT_TIMESTAMP)  )   ) FROM activity WHERE  activity.id_task= task.id_task GROUP BY  activity.id_task), 0 ) /3600), 0) AS status_h,
                        COALESCE( FLOOR(  MOD(   COALESCE(  (SELECT  SUM(   TIMESTAMPDIFF(SECOND,`date_activity_start`,  COALESCE( `date_activity_end` , CURRENT_TIMESTAMP)  )   ) FROM activity WHERE  activity.id_task= task.id_task GROUP BY  activity.id_task), 0 ) /60 , 60 ) ), 0) AS status_m,
                        COALESCE( MOD( COALESCE(  (SELECT  SUM(   TIMESTAMPDIFF(SECOND,`date_activity_start`,  COALESCE( `date_activity_end` , CURRENT_TIMESTAMP)  )   ) FROM activity WHERE  activity.id_task= task.id_task GROUP BY  activity.id_task), 0 ) , 60 ), 0) AS status_s  
                        
                        FROM task JOIN project  JOIN activity
                        WHERE task.id_project = ?  AND ( task.active = 1 or task.active = ?);
                        ";
                $tasks = $this->m_database->query($sql2, $idProject, $taskState);
                return $tasks;
            }
        }

    }


    // ziska usery a jejich timelog
    public function getUsersTasksForStats( $projectID)
    {

        $sql = 'select username, activity.id_user,      
                COALESCE( FLOOR( SUM(TIMESTAMPDIFF(SECOND, date_activity_start, COALESCE( `date_activity_end` , CURRENT_TIMESTAMP)) )  /3600), 0) AS status_h,
                COALESCE( FLOOR(  MOD(  SUM(TIMESTAMPDIFF(SECOND, date_activity_start, COALESCE( `date_activity_end` , CURRENT_TIMESTAMP)) )  /60 , 60 ) ), 0) AS status_m,
                COALESCE( MOD( SUM(TIMESTAMPDIFF(SECOND, date_activity_start, COALESCE( `date_activity_end` , CURRENT_TIMESTAMP)) )  , 60 ), 0) AS status_s
                
                from activity left join user on activity.id_user = user.id_user left join task on activity.id_task = task.id_task left join project on task.id_project = project.id_project
                where task.id_project  = ?
                GROUP BY username';


        $users = $this->m_database->query($sql, $projectID);
        return $users;

    }

    // ziska vsechny tasky konkretniho usera a k taskum spocita timelog
    public function getUserTasks($userID)
    {

       $sql =  'select project.id_project, project.project_name,  task.id_task, task.task_name , 
                
                 
                
                COALESCE( FLOOR(SUM(   TIMESTAMPDIFF(SECOND,`date_activity_start`,  COALESCE( `date_activity_end` , CURRENT_TIMESTAMP))) /3600), 0) AS status_h,
                COALESCE( FLOOR(  MOD(  SUM(   TIMESTAMPDIFF(SECOND,`date_activity_start`,  COALESCE( `date_activity_end` , CURRENT_TIMESTAMP))) /60 , 60 ) ), 0) AS status_m,
                COALESCE( MOD( SUM(   TIMESTAMPDIFF(SECOND,`date_activity_start`,  COALESCE( `date_activity_end` , CURRENT_TIMESTAMP))) , 60 ), 0) AS status_s


                from activity left join task on activity.id_task = task.id_task left join project on task.id_project = project.id_project 
                where  id_user = ?  
                group by activity.id_task';

        $users = $this->m_database->query($sql, $userID);
        return $users;

    }

    public function getAssigneeTasks($idUser, $idProject)
    {
        $sql = "SELECT  id_role FROM role WHERE id_role = (SELECT  DISTINCT contribute.id_role FROM contribute WHERE contribute.id_user = ? AND contribute.id_project = ?)";
        $roles = $this->m_database->query($sql, $idUser, $idProject);

        /// 1 = admin ; 2 = user ; 3 = manager
        ///
        ///

        $sql2 = "SELECT DISTINCT task.task_name, task.id_task, task.id_project, (SELECT username FROM user WHERE user.id_user =  task.id_user_author) AS author, (SELECT username FROM user WHERE user.id_user =  task.id_user_processor) AS assignee ,
                        
                        COALESCE(  (SELECT  SUM(  
                        TIMESTAMPDIFF(HOUR,`date_activity_start`,  COALESCE( `date_activity_end` , CURRENT_TIMESTAMP)  )  
                        ) 
                        FROM activity
                        WHERE  activity.id_task= task.id_task
                        GROUP BY  activity.id_task), 0 ) as status
                        FROM task JOIN project  JOIN activity
                         WHERE task.id_project = ? AND task.id_user_processor = ?;
                        ";


        $tasks = $this->m_database->query($sql2, $idProject, $idUser);
        return $tasks;


    }

    public function countTime()
    {
        $sql = "SELECT id_task, SUM(  
TIMESTAMPDIFF(SECOND,`date_activity_start`,  COALESCE( `date_activity_end` , CURRENT_TIMESTAMP)  )  
) AS hours
FROM activity
WHERE id_user=1 and id_task=1 
GROUP BY  id_task ";


        $sql2 = "SELECT DISTINCT task.task_name, task.id_task, task.id_project, task.id_user_author, task.id_user_processor ,

COALESCE(  (SELECT  SUM(  
TIMESTAMPDIFF(SECOND,`date_activity_start`,  COALESCE( `date_activity_end` , CURRENT_TIMESTAMP)  )  
) 
FROM activity
WHERE  activity.id_task= task.id_task
GROUP BY  activity.id_task), 0 ) as status


FROM task JOIN project  JOIN activity
WHERE task.id_project = 1;
" ;
    }

    /**
     * Creates new task. throws DuplicateTaskException if taskname allready exists
     * @param $idUser
     * @param $idProject
     * @param $name
     */
    public function createTask($idUser, $idProject, $name)
    {

        $sql = "INSERT INTO task (task_name, id_project, id_user_author, id_user_processor) VALUES (?,?, ?, ?);";
        $this->m_database->query($sql, $name, $idProject, $idUser, $idUser);
    }


    public function deleteTask( $idTask)
    {
        //TODO ODSTRANI SE I AKTIVITA KTERA NA TOMTO PROJEKTU BYLA . DOBRE SPATNE ???
        $sql = "DELETE FROM activity WHERE id_activity IN (SELECT * FROM (
            SELECT activity.id_activity  from task join activity on activity.id_task = task.id_task
                    where task.id_task= ?
                ) AS p)";
        $this->m_database->query($sql, $idTask);

        //DELETE TASK
        $sql = "DELETE FROM `task` WHERE (`id_task` = ?)";
        $this->m_database->query($sql, $idTask);
    }

    public function reassignTask( $idTask, $name)
    {
        $sql = "UPDATE `task` SET `id_user_processor`=? WHERE (`id_task` = ?)";
        $this->m_database->query($sql, $name, $idTask);
    }

    public function updateNameTask($idTask, $name)
    {
        $sql = "UPDATE `task` SET `task_name`=? WHERE (`id_task` = ?)";
        $this->m_database->query($sql, $name, $idTask);

    }

    public function archiveTask($idTask)
    {
        $task = $this->m_database->table('task')->where('id_task',$idTask)->fetch();

        if($task['active'])
        {
            $sql = "UPDATE `task` SET `active`=0 WHERE (`id_task` = ?)";
            $this->m_database->query($sql, $idTask);
        }
        else
        {
            $sql = "UPDATE `task` SET `active`=1 WHERE (`id_task` = ?)";
            $this->m_database->query($sql, $idTask);
        }
    }


    public function isTracking($userID)
    {

        $activity = $this->m_database->table('activity')->where('id_user = ? AND active = 1', $userID)->fetch();

        return $activity ? true : false;

    }

    public function getTrackingData($userID)
    {

        $activity = $this->m_database->table('activity')->where('id_user', $userID)->where('active', 1)->fetch();
        $task = $this->m_database->table('task')->where('id_task', $activity['id_task'])->fetch();
        $project = $this->m_database->table('project')->where('id_project',  $task['id_project'])->fetch();
        $data = array('task_name'=>$task['task_name'],'project_name'=>$project['project_name'] , 'id_activity' => $activity['id_activity'], 'id_task' => $activity['id_task'], 'id_project' => $task['id_project'], 'date_activity_start' => $activity['date_activity_start'] );

        return $data;
    }

    public function startActivity($userID, $taskID)
    {
        $sql = "INSERT INTO activity (active, id_user, id_task) VALUES  (1,?,? );";
        $this->m_database->query($sql, $userID, $taskID);

    }

    public function stopActivity($userID)
    {

        $activity = $this->m_database->table('activity')->where('id_user', $userID)->where('active', 1)->fetch();
        $activityID = $activity['id_activity'];
        $sql = "UPDATE `activity` SET `active`=0 WHERE (`id_activity` = ?)";
        $this->m_database->query($sql, $activityID);

    }

    public function getTrackingTime($userID)
    {
        $activity = $this->m_database->table('activity')->where('id_user = ? AND active = 1', $userID)->fetch();
        $activityID = $activity['id_activity'];

        $sql = "SELECT TIMESTAMPDIFF(SECOND,`date_activity_start`,   CURRENT_TIMESTAMP) as seconds
                FROM activity
                WHERE `id_activity` = ?";

        $seconds = $this->m_database->query($sql, $activityID)->fetch()['seconds'];
        $h = floor($seconds / 3600);
        $m = floor (($seconds/60)%60);
        $s = ($seconds%60);

        $data = array ('h'=>$h, 'm'=>$m, 's'=>$s);
        return $data;

    }

    public function getTasksByName($projectID, $taskName)
    {
        return $this->m_database->table('task')->where('task_name = ? AND id_project = ?', $taskName, $projectID)->fetch();
    }

    public function getTask($idTask)
    {
        return $this->m_database->table('task')->where('id_task', $idTask)->fetch();

    }

    public function updateTask($taskID, $newName, $newAsigneID)
    {
        $sql = "UPDATE `task` SET `task_name`=? , `id_user_processor` = ? WHERE (`id_task` = ?)";
        $this->m_database->query($sql, $newName, $newAsigneID, $taskID);
    }

    public function getEntriesForStats($userID, $taskID)
    {
        $sql = 'select activity.id_task ,    
    

                COALESCE( FLOOR( TIMESTAMPDIFF(SECOND,`date_activity_start`,COALESCE( `date_activity_end` , CURRENT_TIMESTAMP)  )/3600), 0) AS status_h,
                COALESCE( FLOOR(  MOD( TIMESTAMPDIFF(SECOND,`date_activity_start`,COALESCE( `date_activity_end` , CURRENT_TIMESTAMP)  ) /60 , 60 ) ), 0) AS status_m,
                COALESCE( MOD(TIMESTAMPDIFF(SECOND,`date_activity_start`,COALESCE( `date_activity_end` , CURRENT_TIMESTAMP)  ) , 60 ), 0) AS status_s,
                DATE_FORMAT(DATE(activity.date_activity_start),  \'%e %b %Y\') AS date_start



                from activity  
                where  id_user = ? and id_task = ?';


        return $this->m_database->query($sql, $userID, $taskID);
    }
}