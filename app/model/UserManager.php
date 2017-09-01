<?php

namespace App\Model;

use Nette\Database\UniqueConstraintViolationException;
use Nette\Security\AuthenticationException;
use Nette\Security\IAuthenticator;
use Nette\Security\Identity;
use Nette\Security\Passwords;


/**
 * Výjimka pro duplicitní uživatelské jméno.
 * @package App\Model
 */
class DuplicateNameException extends AuthenticationException
{
    /** Konstruktor s definicích výchozí chybové zprávy. */
    public function __construct()
    {
        parent::__construct();
        $this->message = 'User allredy exist.';
    }
}

/**
 * Správce uživatelů redakčního systému.
 * @package App\Model
 */
class UserManager extends AbstractManager implements IAuthenticator
{
    /** Konstanty pro manipulaci s modelem. */
    const
        TABLE_NAME = 'user',
        COLUMN_ID = 'user_id',
        COLUMN_NAME = 'username',
        COLUMN_PASSWORD_HASH = 'password',
        COLUMN_ROLE = 'role';

    public function authenticate(array $credentials)
    {
        list($username, $password) = $credentials;

        // Vykoná dotaz nad databází a vrátí první řádek výsledku nebo false, pokud uživatel neexistuje.
        $user = $this->getUser($username);

        // Authenticate user
        if (!$user) {
            throw new AuthenticationException('Wrong username.', self::FAILURE);
        } elseif (!Passwords::verify($password, $user['password'])) {
            throw new AuthenticationException('Wrong password.', self::FAILURE);
        } elseif (Passwords::needsRehash($user['password'])) {
            // Rehash password if needed
            $user->update(array('password' => Passwords::hash($password)));
        }

        //  $userData = $user->toArray(); // Get user data
        //unset($userData['password']); // remove password

        // return new logged in Identity
        return new Identity($user['id_user'], 'user', ['username' => $username]);
    }

    /**
     * Přihlásí uživatele do systému.
     * @param array $credentials jméno a heslo uživatele
     * @return Identity identitu přihlášeného uživatele pro další manipulaci
     * @throws AuthenticationException Jestliže došlo k chybě při prihlašování, např. špatné heslo nebo uživatelské
     *                                 jméno.
     */

    public function getUser($username)
    {
        return $this->m_database->table('user')->where('username', $username)->fetch();
    }

    /**
     * Register new user
     * @param string $username username
     * @param string $password password
     * @throws DuplicateNameException if duplicate name exits
     */
    public function register($username, $password)
    {
        try {
            // Pokusí se vložit nového uživatele do databáze.
            $this->m_database->table('user')->insert(array('username' => $username, 'password' => Passwords::hash($password),));
        } catch (UniqueConstraintViolationException $e) {
            // Vyhodí výjimku, pokud uživatel s daným jménem již existuje.
            throw new DuplicateNameException;
        }
    }


    public function getUserShowProject($userID)
    {
        $user = $this->m_database->table('user')->get($userID);
        $userData = $user->toArray();
        return $userData['show_archived_projects'];
    }

    public function updateArchivedShowProject($userID)
    {
        $user = $this->m_database->table('user')->get($userID);
        $userData = $user->toArray();
        $status = $userData['show_archived_projects'];

        if ($status) {
            $sql = "UPDATE `user` SET `show_archived_projects`=0 WHERE (`id_user` = ?)";
            $this->m_database->query($sql, $userID);

        } else {
            $sql = "UPDATE `user` SET `show_archived_projects`=1 WHERE (`id_user` = ?)";
            $this->m_database->query($sql, $userID);
        }
    }

    public function getUserShowTasks($userID)
    {
        $user = $this->m_database->table('user')->get($userID);
        $userData = $user->toArray();
        return $userData['show_archived_tasks'];
    }


    public function updateArchivedShowTasks($userID)
    {
        $user = $this->m_database->table('user')->get($userID);
        $userData = $user->toArray();
        $status = $userData['show_archived_tasks'];

        if ($status) {
            $sql = "UPDATE `user` SET `show_archived_tasks`=0 WHERE (`id_user` = ?)";
            $this->m_database->query($sql, $userID);

        } else {
            $sql = "UPDATE `user` SET `show_archived_tasks`=1 WHERE (`id_user` = ?)";
            $this->m_database->query($sql, $userID);
        }
    }

    public function getUserByID($userID)
    {
        return $this->m_database->table('user')->where('id_user', $userID)->fetch();
    }
}
