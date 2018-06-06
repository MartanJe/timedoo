<?php


namespace App\TrackModule\Presenters;

use App\Model\UserManager;
use Nette\Application\UI\Form;
use  Nette\Application\UI\Presenter;
use Nette\Security\User;
use Nette\Security\AuthenticationException;

/**
 * Handles user login and registration
 * Class LoginPresenter
 * @package App\TrackModule\Presenters
 */
class LoginPresenter extends  Presenter
{
    private $m_userManager;
    private $m_user;

    public function __construct(UserManager $userManager, User $user)
    {
        parent::__construct();
        $this->m_userManager = $userManager;
        $this->m_user = $user;
    }

    /**
     * Login form
     * @return Form
     */
    public function createComponentLoginForm()
    {
        $form = new Form;
        $form->addText('username', 'Username')->setRequired();
        $form->addPassword('password', 'Password')->setRequired();

        $form->addSubmit('login', 'Login');
        $form->onSuccess[] = [$this, 'loginFormSucceeded'];;
        return $form;
    }

    /**
     * Login form
     * @return Form
     */
    public function createComponentRegisterForm()
    {
        $form = new Form;
        $form->addText('username', 'Username')->setRequired();
        $form->addPassword('password', 'Password')->setRequired();
        $form->addPassword('password2', 'Password confirm:')->setRequired();

        $form->addSubmit('register', 'Register');
        $form->onSuccess[] = [$this, 'registerFormSucceeded'];;
        return $form;
    }


    public function registerFormSucceeded($form)
    {

        try
        {
            // Extrakce hodnot z formuláře.
            $username = $form->getValues()->username;
            $password = $form->getValues()->password;
            $password2 = $form->getValues()->password2;

            if($password != $password2)
            {
                $this->flashMessage('Password dont match!', 'danger');
            }
            else
            {
                $this->user->getAuthenticator()->register($username, $password);

                $this->flashMessage('Registration successful.','success');
                $this->redirect(':Track:Login:');
            }
        }
        catch (AuthenticationException $ex)
        {
            $this->flashMessage($ex->getMessage(), 'danger');
        }


    }

    /**
     * Login form succeeded
     * @param $form
     */
    public function loginFormSucceeded($form)
    {
        try
        {
            // Extrakce hodnot z formuláře.
            $username = $form->getValues()->username;
            $password = $form->getValues()->password;

            $this->user->login($username, $password);
            $this->redirect(':Track:Timer:');
        }

        catch (AuthenticationException $ex)
        {
                $this->flashMessage($ex->getMessage(),'danger');
        }

    }

    // logout
    public function actionLogout()
    {
        $this->getUser()->logout();
        $this->flashMessage('Logout successful.','success');
        $this->redirect(':Track:Login:');
    }

    public function actionLogin()
    {
        if ($this->getUser()->isLoggedIn()) $this->redirect(':Track:Timer:');
    }

    public function renderDefault()
    {
        if ($this->getUser()->isLoggedIn()) $this->redirect(':Track:Timer:');
    }



}