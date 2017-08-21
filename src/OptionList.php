<?php
/**
 * This file is part of Berlioz framework.
 *
 * @license   https://opensource.org/licenses/MIT MIT License
 * @copyright 2017 Ronan GIRON
 * @author    Ronan GIRON <https://github.com/ElGigi>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code, to the root.
 */

namespace Berlioz\Core;


/**
 * Class OptionList
 *
 * @package Berlioz\Core
 */
class OptionList
{
    /** @var int Constant for global option */
    const TYPE_GLOBAL = 1;
    /** @var int Constant for local option */
    const TYPE_LOCAL = 2;
    /** @var mixed[] Global _b_options */
    private static $globalOptions = [];
    /** @var mixed Options */
    private $options = [];

    /**
     * OptionList constructor.
     */
    public function __construct()
    {
        $this->options = [];

        if (func_num_args() > 0) {
            call_user_func_array([$this, 'setOptions'], func_get_args());
        }
    }

    /**
     * OptionList destructor.
     */
    public function __destruct()
    {
    }

    /**
     * __get() magic method.
     *
     * @param string $name Option name
     *
     * @return mixed
     * @deprecated Use get(string $name) method instead
     */
    public function __get($name)
    {
        if (isset(self::$globalOptions[$name])) {
            return self::$globalOptions[$name];
        } else {
            if (isset($this->options[$name])) {
                return $this->options[$name];
            } else {
                return null;
            }
        }
    }

    /**
     * __toString() magic method.
     *
     * @return string
     */
    public function __toString()
    {
        return var_export(array_merge($this->options, self::$globalOptions), true);
    }

    /**
     * Get option value.
     *
     * @param string $name Option name
     *
     * @return mixed
     */
    public function get($name)
    {
        if (isset(self::$globalOptions[$name])) {
            return self::$globalOptions[$name];
        } else {
            if (isset($this->options[$name])) {
                return $this->options[$name];
            } else {
                return null;
            }
        }
    }

    /**
     * Set option.
     *
     * @param string $name  Option name
     * @param mixed  $value Option value
     * @param int    $type  Type of option (TYPE_LOCAL|TYPE_GLOBAL)
     */
    public function set($name, $value, $type = self::TYPE_LOCAL)
    {
        if ($type == self::TYPE_GLOBAL) {
            self::$globalOptions[$name] = $value;
        } else {
            $this->options[$name] = $value;
        }
    }

    /**
     * Unset option.
     *
     * @param string $name Option name
     * @param int    $type Type of option (TYPE_LOCAL|TYPE_GLOBAL)
     */
    public function unset($name, $type = self::TYPE_LOCAL)
    {
        if ($type == self::TYPE_GLOBAL) {
            unset(self::$globalOptions[$name]);
        } else {
            unset($this->options[$name]);
        }
    }

    /**
     * Know if option exists.
     *
     * @param string   $name Option name
     * @param null|int $type Type of option (TYPE_LOCAL|TYPE_GLOBAL)
     *
     * @return bool
     */
    public function isset($name, $type = null)
    {
        if (is_null($type)) {
            return array_key_exists($name, $this->options) || array_key_exists($name, self::$globalOptions);
        } else {
            if ($type == self::TYPE_GLOBAL) {
                return array_key_exists($name, self::$globalOptions);
            } else {
                return array_key_exists($name, $this->options);
            }
        }
    }

    /**
     * Know if value of an option is null.
     *
     * @param string   $name Option name
     * @param null|int $type Type of option (TYPE_LOCAL|TYPE_GLOBAL)
     *
     * @return bool
     */
    public function is_null($name, $type = null)
    {
        if (isset(self::$globalOptions[$name]) && (is_null($type) || $type == self::TYPE_GLOBAL)) {
            return is_null(self::$globalOptions[$name]);
        } else {
            if (isset($this->options[$name]) && (is_null($type) || $type == self::TYPE_LOCAL)) {
                return is_null($this->options[$name]);
            } else {
                return true;
            }
        }
    }

    /**
     * Know if value of an option is empty.
     *
     * @param string   $name Option name
     * @param null|int $type Type of option (TYPE_LOCAL|TYPE_GLOBAL)
     *
     * @return bool
     */
    public function is_empty($name, $type = null)
    {
        if (isset(self::$globalOptions[$name]) && (is_null($type) || $type == self::TYPE_GLOBAL)) {
            return empty(self::$globalOptions[$name]);
        } else {
            if (isset($this->options[$name]) && (is_null($type) || $type == self::TYPE_LOCAL)) {
                return empty($this->options[$name]);
            } else {
                return true;
            }
        }
    }

    /**
     * Know if value of an option is bool.
     *
     * @param string   $name Option name
     * @param null|int $type Type of option (TYPE_LOCAL|TYPE_GLOBAL)
     *
     * @return bool
     */
    public function is_bool($name, $type = null)
    {
        if (isset(self::$globalOptions[$name]) && (is_null($type) || $type == self::TYPE_GLOBAL)) {
            return is_bool(self::$globalOptions[$name]);
        } else {
            if (isset($this->options[$name]) && (is_null($type) || $type == self::TYPE_LOCAL)) {
                return is_bool($this->options[$name]);
            } else {
                return false;
            }
        }
    }

    /**
     * Know if value of an option is numeric.
     *
     * @param string   $name Option name
     * @param null|int $type Type of option (TYPE_LOCAL|TYPE_GLOBAL)
     *
     * @return bool
     */
    public function is_numeric($name, $type = null)
    {
        if (isset(self::$globalOptions[$name]) && (is_null($type) || $type == self::TYPE_GLOBAL)) {
            return is_numeric(self::$globalOptions[$name]);
        } else {
            if (isset($this->options[$name]) && (is_null($type) || $type == self::TYPE_LOCAL)) {
                return is_numeric($this->options[$name]);
            } else {
                return false;
            }
        }
    }

    /**
     * Know if value of an option is integer.
     *
     * @param string   $name Option name
     * @param null|int $type Type of option (TYPE_LOCAL|TYPE_GLOBAL)
     *
     * @return bool
     */
    public function is_int($name, $type = null)
    {
        if (isset(self::$globalOptions[$name]) && (is_null($type) || $type == self::TYPE_GLOBAL)) {
            return (preg_match("/^-?[0-9]+$/", self::$globalOptions[$name]) == 1);
        } else {
            if (isset($this->options[$name]) && (is_null($type) || $type == self::TYPE_LOCAL)) {
                return (preg_match("/^-?[0-9]+$/", $this->options[$name]) == 1);
            } else {
                return false;
            }
        }
    }

    /**
     * Know if value of an option is string.
     *
     * @param string   $name Option name
     * @param null|int $type Type of option (TYPE_LOCAL|TYPE_GLOBAL)
     *
     * @return bool
     */
    public function is_string($name, $type = null)
    {
        if (isset(self::$globalOptions[$name]) && (is_null($type) || $type == self::TYPE_GLOBAL)) {
            return is_string(self::$globalOptions[$name]);
        } else {
            if (isset($this->options[$name]) && (is_null($type) || $type == self::TYPE_LOCAL)) {
                return is_string($this->options[$name]);
            } else {
                return false;
            }
        }
    }

    /**
     * Know if value of an option is an array.
     *
     * @param string   $name Option name
     * @param null|int $type Type of option (TYPE_LOCAL|TYPE_GLOBAL)
     *
     * @return bool
     */
    public function is_array($name, $type = null)
    {
        if (isset(self::$globalOptions[$name]) && (is_null($type) || $type == self::TYPE_GLOBAL)) {
            return is_array(self::$globalOptions[$name]);
        } else {
            if (isset($this->options[$name]) && (is_null($type) || $type == self::TYPE_LOCAL)) {
                return is_array($this->options[$name]);
            } else {
                return false;
            }
        }
    }

    /**
     * Know if value of an option is callable.
     *
     * @param string   $name Option name
     * @param null|int $type Type of option (TYPE_LOCAL|TYPE_GLOBAL)
     *
     * @return bool
     */
    public function is_callable($name, $type = null)
    {
        if (isset(self::$globalOptions[$name]) && (is_null($type) || $type == self::TYPE_GLOBAL)) {
            return is_callable(self::$globalOptions[$name]);
        } else {
            if (isset($this->options[$name]) && (is_null($type) || $type == self::TYPE_LOCAL)) {
                return is_callable($this->options[$name]);
            } else {
                return false;
            }
        }
    }

    /**
     * Know if value of an option is callable.
     *
     * @param string   $name  Option name
     * @param string   $class Class name to compare
     * @param null|int $type  Type of option (TYPE_LOCAL|TYPE_GLOBAL)
     *
     * @return bool
     */
    public function is_a($name, $class, $type = null)
    {
        if (isset(self::$globalOptions[$name]) && (is_null($type) || $type == self::TYPE_GLOBAL)) {
            return is_a(self::$globalOptions[$name], $class, true);
        } else {
            if (isset($this->options[$name]) && (is_null($type) || $type == self::TYPE_LOCAL)) {
                return is_a($this->options[$name], $class, true);
            } else {
                return false;
            }
        }
    }

    /**
     * Get options.
     *
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options ?? [];
    }

    /**
     * Set options.
     *
     * @var OptionList|string $param1 OptionList or array to merge ; or option name
     * @var mixed|null        $param2 Value of option if $param1 is option name
     *
     * @return static
     */
    public function setOptions()
    {
        $args = func_get_args();

        if (count($args) == 1 && is_array($args[0])) {
            foreach ($args[0] as $name => $value) {
                $this->options[$name] = $value;
            }
        } else {
            if (count($args) == 1 && $args[0] instanceof OptionList) {
                /** @var OptionList $optionList */
                $optionList = $args[0];
                $this->setOptions($optionList->getOptions());
            } else {
                if (count($args) >= 2) {
                    $this->options[$args[0]] = $args[1];
                } else {
                    trigger_error("setOptions() method require 1 or 2 arguments, if one, it must be an array.", E_USER_WARNING);
                }
            }
        }

        return $this;
    }

    /**
     * Merge $this with the given OptionList.
     *
     * @param OptionList|null $optionList
     *
     * @return OptionList|$this
     */
    public function mergeWith(OptionList $optionList = null)
    {
        if (!is_null($optionList)) {
            return $this->setOptions($optionList->getOptions());
        } else {
            return $this;
        }
    }
}
