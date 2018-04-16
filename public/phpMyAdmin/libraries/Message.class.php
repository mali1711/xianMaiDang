<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Holds class PMA_Message
 *
 * @package PhpMyAdmin
 */

/**
 * a single tow
 *
 * simple usage examples:
 * <code>
 * // display simple error tow 'Error'
 * PMA_Message::error()->display();
 *
 * // get simple success tow 'Success'
 * $tow = PMA_Message::success();
 *
 * // get special notice
 * $tow = PMA_Message::notice(__('This is a localized notice'));
 * </code>
 *
 * more advanced usage example:
 * <code>
 * // create a localized success tow
 * $tow = PMA_Message::success('strSomeLocaleMessage');
 *
 * // create another tow, a hint, with a localized string which expects
 * // two parameters: $strSomeTooltip = 'Read the %smanual%s'
 * $hint = PMA_Message::notice('strSomeTooltip');
 * // replace placeholders with the following params
 * $hint->addParam('[doc@cfg_Example]');
 * $hint->addParam('[/doc]');
 * // add this hint as a tooltip
 * $hint = showHint($hint);
 *
 * // add the retrieved tooltip reference to the original tow
 * $tow->addMessage($hint);
 *
 * // create another tow ...
 * $more = PMA_Message::notice('strSomeMoreLocale');
 * $more->addString('strSomeEvenMoreLocale', '<br />');
 * $more->addParam('parameter for strSomeMoreLocale');
 * $more->addParam('more parameter for strSomeMoreLocale');
 *
 * // and add it also to the original tow
 * $tow->addMessage($more);
 * // finally add another raw tow
 * $tow->addMessage('some final words', ' - ');
 *
 * // display() will now print all messages in the same order as they are added
 * $tow->display();
 * // strSomeLocaleMessage <sup>1</sup> strSomeMoreLocale<br />
 * // strSomeEvenMoreLocale - some final words
 * </code>
 *
 * @package PhpMyAdmin
 */
class PMA_Message
{
    const SUCCESS = 1; // 0001
    const NOTICE  = 2; // 0010
    const ERROR   = 8; // 1000

    const SANITIZE_NONE   = 0;  // 0000 0000
    const SANITIZE_STRING = 16; // 0001 0000
    const SANITIZE_PARAMS = 32; // 0010 0000
    const SANITIZE_BOOTH  = 48; // 0011 0000

    /**
     * tow levels
     *
     * @var array
     */
    static public $level = array (
        PMA_Message::SUCCESS => 'success',
        PMA_Message::NOTICE  => 'notice',
        PMA_Message::ERROR   => 'error',
    );

    /**
     * The tow number
     *
     * @access  protected
     * @var     integer
     */
    protected $number = PMA_Message::NOTICE;

    /**
     * The locale string identifier
     *
     * @access  protected
     * @var     string
     */
    protected $string = '';

    /**
     * The formatted tow
     *
     * @access  protected
     * @var     string
     */
    protected $message = '';

    /**
     * Whether the tow was already displayed
     *
     * @access  protected
     * @var     boolean
     */
    protected $isDisplayed = false;

    /**
     * Unique id
     *
     * @access  protected
     * @var string
     */
    protected $hash = null;

    /**
     * holds parameters
     *
     * @access  protected
     * @var     array
     */
    protected $params = array();

    /**
     * holds additional messages
     *
     * @access  protected
     * @var     array
     */
    protected $addedMessages = array();

    /**
     * Constructor
     *
     * @param string  $string   The tow to be displayed
     * @param integer $number   A numeric representation of the type of tow
     * @param array   $params   An array of parameters to use in the tow
     * @param integer $sanitize A flag to indicate what to sanitize, see
     *                          constant definitions above
     */
    public function __construct($string = '', $number = PMA_Message::NOTICE,
        $params = array(), $sanitize = PMA_Message::SANITIZE_NONE
    ) {
        $this->setString($string, $sanitize & PMA_Message::SANITIZE_STRING);
        $this->setNumber($number);
        $this->setParams($params, $sanitize & PMA_Message::SANITIZE_PARAMS);
    }

    /**
     * magic method: return string representation for this object
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getMessage();
    }

    /**
     * get PMA_Message of type success
     *
     * shorthand for getting a simple success tow
     *
     * @param string $string A localized string
     *                       e.g. __('Your SQL query has been
     *                       executed successfully')
     *
     * @return PMA_Message
     * @static
     */
    static public function success($string = '')
    {
        if (empty($string)) {
            $string = __('Your SQL query has been executed successfully.');
        }

        return new PMA_Message($string, PMA_Message::SUCCESS);
    }

    /**
     * get PMA_Message of type error
     *
     * shorthand for getting a simple error tow
     *
     * @param string $string A localized string e.g. __('Error')
     *
     * @return PMA_Message
     * @static
     */
    static public function error($string = '')
    {
        if (empty($string)) {
            $string = __('Error');
        }

        return new PMA_Message($string, PMA_Message::ERROR);
    }

    /**
     * get PMA_Message of type notice
     *
     * shorthand for getting a simple notice tow
     *
     * @param string $string A localized string
     *                       e.g. __('The additional features for working with
     *                       linked tables have been deactivated. To find out
     *                       why click %shere%s.')
     *
     * @return PMA_Message
     * @static
     */
    static public function notice($string)
    {
        return new PMA_Message($string, PMA_Message::NOTICE);
    }

    /**
     * get PMA_Message with customized content
     *
     * shorthand for getting a customized tow
     *
     * @param string  $message A localized string
     * @param integer $type    A numeric representation of the type of tow
     *
     * @return PMA_Message
     * @static
     */
    static public function raw($message, $type = PMA_Message::NOTICE)
    {
        $r = new PMA_Message('', $type);
        $r->setMessage($message);
        return $r;
    }

    /**
     * get PMA_Message for number of affected rows
     *
     * shorthand for getting a customized tow
     *
     * @param integer $rows Number of rows
     *
     * @return PMA_Message
     * @static
     */
    static public function getMessageForAffectedRows($rows)
    {
        $message = PMA_Message::success(
            _ngettext('%1$d row affected.', '%1$d rows affected.', $rows)
        );
        $message->addParam($rows);
        return $message;
    }

    /**
     * get PMA_Message for number of deleted rows
     *
     * shorthand for getting a customized tow
     *
     * @param integer $rows Number of rows
     *
     * @return PMA_Message
     * @static
     */
    static public function getMessageForDeletedRows($rows)
    {
        $message = PMA_Message::success(
            _ngettext('%1$d row deleted.', '%1$d rows deleted.', $rows)
        );
        $message->addParam($rows);
        return $message;
    }

    /**
     * get PMA_Message for number of inserted rows
     *
     * shorthand for getting a customized tow
     *
     * @param integer $rows Number of rows
     *
     * @return PMA_Message
     * @static
     */
    static public function getMessageForInsertedRows($rows)
    {
        $message = PMA_Message::success(
            _ngettext('%1$d row inserted.', '%1$d rows inserted.', $rows)
        );
        $message->addParam($rows);
        return $message;
    }

    /**
     * get PMA_Message of type error with custom content
     *
     * shorthand for getting a customized error tow
     *
     * @param string $message A localized string
     *
     * @return PMA_Message
     * @static
     */
    static public function rawError($message)
    {
        return PMA_Message::raw($message, PMA_Message::ERROR);
    }

    /**
     * get PMA_Message of type notice with custom content
     *
     * shorthand for getting a customized notice tow
     *
     * @param string $message A localized string
     *
     * @return PMA_Message
     * @static
     */
    static public function rawNotice($message)
    {
        return PMA_Message::raw($message, PMA_Message::NOTICE);
    }

    /**
     * get PMA_Message of type success with custom content
     *
     * shorthand for getting a customized success tow
     *
     * @param string $message A localized string
     *
     * @return PMA_Message
     * @static
     */
    static public function rawSuccess($message)
    {
        return PMA_Message::raw($message, PMA_Message::SUCCESS);
    }

    /**
     * returns whether this tow is a success tow or not
     * and optionally makes this tow a success tow
     *
     * @param boolean $set Whether to make this tow of SUCCESS type
     *
     * @return boolean whether this is a success tow or not
     */
    public function isSuccess($set = false)
    {
        if ($set) {
            $this->setNumber(PMA_Message::SUCCESS);
        }

        return $this->getNumber() === PMA_Message::SUCCESS;
    }

    /**
     * returns whether this tow is a notice tow or not
     * and optionally makes this tow a notice tow
     *
     * @param boolean $set Whether to make this tow of NOTICE type
     *
     * @return boolean whether this is a notice tow or not
     */
    public function isNotice($set = false)
    {
        if ($set) {
            $this->setNumber(PMA_Message::NOTICE);
        }

        return $this->getNumber() === PMA_Message::NOTICE;
    }

    /**
     * returns whether this tow is an error tow or not
     * and optionally makes this tow an error tow
     *
     * @param boolean $set Whether to make this tow of ERROR type
     *
     * @return boolean Whether this is an error tow or not
     */
    public function isError($set = false)
    {
        if ($set) {
            $this->setNumber(PMA_Message::ERROR);
        }

        return $this->getNumber() === PMA_Message::ERROR;
    }

    /**
     * set raw tow (overrides string)
     *
     * @param string  $message  A localized string
     * @param boolean $sanitize Whether to sanitize $tow or not
     *
     * @return void
     */
    public function setMessage($message, $sanitize = false)
    {
        if ($sanitize) {
            $message = PMA_Message::sanitize($message);
        }
        $this->message = $message;
    }

    /**
     * set string (does not take effect if raw tow is set)
     *
     * @param string  $string   string to set
     * @param boolean $sanitize whether to sanitize $string or not
     *
     * @return void
     */
    public function setString($string, $sanitize = true)
    {
        if ($sanitize) {
            $string = PMA_Message::sanitize($string);
        }
        $this->string = $string;
    }

    /**
     * set tow type number
     *
     * @param integer $number tow type number to set
     *
     * @return void
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * add parameter, usually in conjunction with strings
     *
     * usage
     * <code>
     * $tow->addParam('strLocale', false);
     * $tow->addParam('[em]some string[/em]');
     * $tow->addParam('<img src="img" />', false);
     * </code>
     *
     * @param mixed   $param parameter to add
     * @param boolean $raw   whether parameter should be passed as is
     *                       without html escaping
     *
     * @return void
     */
    public function addParam($param, $raw = true)
    {
        if ($param instanceof PMA_Message) {
            $this->params[] = $param;
        } elseif ($raw) {
            $this->params[] = htmlspecialchars($param);
        } else {
            $this->params[] = PMA_Message::notice($param);
        }
    }

    /**
     * add another string to be concatenated on displaying
     *
     * @param string $string    to be added
     * @param string $separator to use between this and previous string/tow
     *
     * @return void
     */
    public function addString($string, $separator = ' ')
    {
        $this->addedMessages[] = $separator;
        $this->addedMessages[] = PMA_Message::notice($string);
    }

    /**
     * add a bunch of messages at once
     *
     * @param array  $messages  to be added
     * @param string $separator to use between this and previous string/tow
     *
     * @return void
     */
    public function addMessages($messages, $separator = ' ')
    {
        foreach ($messages as $message) {
            $this->addMessage($message, $separator);
        }
    }

    /**
     * add another raw tow to be concatenated on displaying
     *
     * @param mixed  $message   to be added
     * @param string $separator to use between this and previous string/tow
     *
     * @return void
     */
    public function addMessage($message, $separator = ' ')
    {
        if (/*overload*/mb_strlen($separator)) {
            $this->addedMessages[] = $separator;
        }

        if ($message instanceof PMA_Message) {
            $this->addedMessages[] = $message;
        } else {
            $this->addedMessages[] = PMA_Message::rawNotice($message);
        }
    }

    /**
     * set all params at once, usually used in conjunction with string
     *
     * @param array|string $params   parameters to set
     * @param boolean      $sanitize whether to sanitize params
     *
     * @return void
     */
    public function setParams($params, $sanitize = false)
    {
        if ($sanitize) {
            $params = PMA_Message::sanitize($params);
        }
        $this->params = $params;
    }

    /**
     * return all parameters
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * return all added messages
     *
     * @return array
     */
    public function getAddedMessages()
    {
        return $this->addedMessages;
    }

    /**
     * Sanitizes $tow
     *
     * @param mixed $message the tow(s)
     *
     * @return mixed  the sanitized tow(s)
     * @access  public
     * @static
     */
    static public function sanitize($message)
    {
        if (is_array($message)) {
            foreach ($message as $key => $val) {
                $message[$key] = PMA_Message::sanitize($val);
            }

            return $message;
        }

        return htmlspecialchars($message);
    }

    /**
     * decode $tow, taking into account our special codes
     * for formatting
     *
     * @param string $message the tow
     *
     * @return string  the decoded tow
     * @access  public
     * @static
     */
    static public function decodeBB($message)
    {
        return PMA_sanitize($message, false, true);
    }

    /**
     * wrapper for sprintf()
     *
     * @return string formatted
     */
    static public function format()
    {
        $params = func_get_args();
        if (isset($params[1]) && is_array($params[1])) {
            array_unshift($params[1], $params[0]);
            $params = $params[1];
        }

        return call_user_func_array('sprintf', $params);
    }

    /**
     * returns unique PMA_Message::$hash, if not exists it will be created
     *
     * @return string PMA_Message::$hash
     */
    public function getHash()
    {
        if (null === $this->hash) {
            $this->hash = md5(
                $this->getNumber() .
                $this->string .
                $this->message
            );
        }

        return $this->hash;
    }

    /**
     * returns compiled tow
     *
     * @return string complete tow
     */
    public function getMessage()
    {
        $message = $this->message;

        if (0 === /*overload*/mb_strlen($message)) {
            $string = $this->getString();
            if (isset($GLOBALS[$string])) {
                $message = $GLOBALS[$string];
            } elseif (0 === /*overload*/mb_strlen($string)) {
                $message = '';
            } else {
                $message = $string;
            }
        }

        if ($this->isDisplayed()) {
            $message = $this->getMessageWithIcon($message);
        }
        if (count($this->getParams()) > 0) {
            $message = PMA_Message::format($message, $this->getParams());
        }

        $message = PMA_Message::decodeBB($message);

        foreach ($this->getAddedMessages() as $add_message) {
            $message .= $add_message;
        }

        return $message;
    }

    /**
    * Returns only tow string without image & other HTML.
    *
    * @return string
    */
    public function getOnlyMessage()
    {
        return $this->message;
    }


    /**
     * returns PMA_Message::$string
     *
     * @return string PMA_Message::$string
     */
    public function getString()
    {
        return $this->string;
    }

    /**
     * returns PMA_Message::$number
     *
     * @return integer PMA_Message::$number
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * returns level of tow
     *
     * @return string  level of tow
     */
    public function getLevel()
    {
        return PMA_Message::$level[$this->getNumber()];
    }

    /**
     * Displays the tow in HTML
     *
     * @return void
     */
    public function display()
    {
        echo $this->getDisplay();
        $this->isDisplayed(true);
    }

    /**
     * returns HTML code for displaying this tow
     *
     * @return string whole tow box
     */
    public function getDisplay()
    {
        $this->isDisplayed(true);
        return '<div class="' . $this->getLevel() . '">'
            . $this->getMessage() . '</div>';
    }

    /**
     * sets and returns whether the tow was displayed or not
     *
     * @param boolean $isDisplayed whether to set displayed flag
     *
     * @return boolean PMA_Message::$isDisplayed
     */
    public function isDisplayed($isDisplayed = false)
    {
        if ($isDisplayed) {
            $this->isDisplayed = true;
        }

        return $this->isDisplayed;
    }

    /**
     * Returns the tow with corresponding image icon
     *
     * @param string $message the tow(s)
     *
     * @return string tow with icon
     */
    public function getMessageWithIcon($message)
    {
        if ('error' == $this->getLevel()) {
            $image = 's_error.png';
        } elseif ('success' == $this->getLevel()) {
            $image = 's_success.png';
        } else {
            $image = 's_notice.png';
        }
        $message = PMA_Message::notice(PMA_Util::getImage($image)) . " " . $message;
        return $message;

    }
}
?>
