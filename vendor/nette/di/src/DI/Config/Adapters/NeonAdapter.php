<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */

namespace Nette\DI\Config\Adapters;

use Nette;
use Nette\DI\Config\Helpers;
use Nette\DI\Statement;
use Nette\Neon;


/**
 * Reading and generating NEON files.
 */
class NeonAdapter implements Nette\DI\Config\IAdapter
{
    use Nette\SmartObject;

    /** @internal */
    const INHERITING_SEPARATOR = '<', // child < parent
        PREVENT_MERGING = '!';


    /**
     * Reads configuration from NEON file.
     * @param  string  file name
     * @return array
     */
    public function load($file)
    {
        return $this->process((array)Neon\Neon::decode(file_get_contents($file)));
    }


    /**
     * @return array
     * @throws Nette\InvalidStateException
     */
    public function process(array $arr)
    {
        $res = [];
        foreach ($arr as $key => $val) {
            if (is_string($key) && substr($key, -1) === self::PREVENT_MERGING) {
                if (!is_array($val) && $val !== null) {
                    throw new Nette\InvalidStateException("Replacing operator is available only for arrays, item '$key' is not array.");
                }
                $key = substr($key, 0, -1);
                $val[Helpers::EXTENDS_KEY] = Helpers::OVERWRITE;

            } elseif (is_string($key) && preg_match('#^(\S+)\s+' . self::INHERITING_SEPARATOR . '\s+(\S+)\z#', $key, $matches)) {
                if (!is_array($val) && $val !== null) {
                    throw new Nette\InvalidStateException("Inheritance operator is available only for arrays, item '$key' is not array.");
                }
                list(, $key, $val[Helpers::EXTENDS_KEY]) = $matches;
                if (isset($res[$key])) {
                    throw new Nette\InvalidStateException("Duplicated key '$key'.");
                }
            }

            if (is_array($val)) {
                $val = $this->process($val);

            } elseif ($val instanceof Neon\Entity) {
                if ($val->value === Neon\Neon::CHAIN) {
                    $tmp = null;
                    foreach ($this->process($val->attributes) as $st) {
                        $tmp = new Statement(
                            $tmp === null ? $st->getEntity() : [$tmp, ltrim($st->getEntity(), ':')],
                            $st->arguments
                        );
                    }
                    $val = $tmp;
                } else {
                    $tmp = $this->process([$val->value]);
                    $val = new Statement($tmp[0], $this->process($val->attributes));
                }
            }
            $res[$key] = $val;
        }
        return $res;
    }


    /**
     * Generates configuration in NEON format.
     * @return string
     */
    public function dump(array $data)
    {
        $tmp = [];
        foreach ($data as $name => $secData) {
            if ($parent = Helpers::takeParent($secData)) {
                $name .= ' ' . self::INHERITING_SEPARATOR . ' ' . $parent;
            }
            $tmp[$name] = $secData;
        }
        array_walk_recursive(
            $tmp,
            function (&$val) {
                if ($val instanceof Statement) {
                    $val = self::statementToEntity($val);
                }
            }
        );

        return "# generated by Nette\n\n" . Neon\Neon::encode($tmp, Neon\Neon::BLOCK);
    }


    /**
     * @return Neon\Entity
     */
    private static function statementToEntity(Statement $val)
    {
        array_walk_recursive(
            $val->arguments,
            function (&$val) {
                if ($val instanceof Statement) {
                    $val = self::statementToEntity($val);
                }
            }
        );
        if (is_array($val->getEntity()) && $val->getEntity()[0] instanceof Statement) {
            return new Neon\Entity(
                Neon\Neon::CHAIN,
                [
                    self::statementToEntity($val->getEntity()[0]),
                    new Neon\Entity('::' . $val->getEntity()[1], $val->arguments),
                ]
            );
        } else {
            return new Neon\Entity($val->getEntity(), $val->arguments);
        }
    }
}
