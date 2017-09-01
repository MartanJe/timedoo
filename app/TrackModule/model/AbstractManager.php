<?php

namespace App\Model;

use Nette\Database\Context;
use Nette\Object;

/**
 * Abstract class used for database connection
 * @package App\Model
 */
abstract class AbstractManager extends Object
{
    /** @var Context database instance. */
    protected $m_database;

    /**
     * Constructor with injected class to work with database.
     * @param Context $database automaticaly injected class for work with database
     */
    public function __construct(Context $database)
    {
        $this->m_database = $database;
    }
}