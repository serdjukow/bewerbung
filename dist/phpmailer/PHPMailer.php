<?php

namespace PHPMailer\PHPMailer;

class PHPMailer
{
	const CHARSET_ASCII = "\x75\x73\x2d\x61\163\143\151\151";
	const CHARSET_ISO88591 = "\151\163\x6f\x2d\70\70\65\x39\55\x31";
	const CHARSET_UTF8 = "\165\x74\146\55\70";
	const CONTENT_TYPE_PLAINTEXT = "\x74\x65\170\x74\x2f\160\x6c\x61\x69\156";
	const CONTENT_TYPE_TEXT_CALENDAR = "\x74\x65\x78\x74\57\143\141\154\145\156\144\141\162";
	const CONTENT_TYPE_TEXT_HTML = "\x74\x65\170\x74\57\150\x74\155\x6c";
	const CONTENT_TYPE_MULTIPART_ALTERNATIVE = "\155\165\x6c\164\151\160\x61\162\164\x2f\141\x6c\164\145\162\x6e\x61\164\x69\x76\x65";
	const CONTENT_TYPE_MULTIPART_MIXED = "\x6d\x75\154\164\151\x70\x61\162\x74\x2f\x6d\151\x78\x65\144";
	const CONTENT_TYPE_MULTIPART_RELATED = "\x6d\x75\154\x74\151\160\141\162\164\x2f\162\x65\x6c\x61\x74\x65\144";
	const ENCODING_7BIT = "\x37\142\x69\164";
	const ENCODING_8BIT = "\70\142\151\164";
	const ENCODING_BASE64 = "\x62\x61\163\x65\66\x34";
	const ENCODING_BINARY = "\x62\x69\x6e\141\162\x79";
	const ENCODING_QUOTED_PRINTABLE = "\x71\x75\157\x74\145\x64\x2d\x70\162\x69\156\x74\x61\142\154\x65";
	const ENCRYPTION_STARTTLS = "\164\154\x73";
	const ENCRYPTION_SMTPS = "\x73\163\154";
	const ICAL_METHOD_REQUEST = "\x52\x45\x51\125\105\x53\124";
	const ICAL_METHOD_PUBLISH = "\x50\x55\102\114\111\x53\110";
	const ICAL_METHOD_REPLY = "\122\x45\120\x4c\131";
	const ICAL_METHOD_ADD = "\x41\x44\104";
	const ICAL_METHOD_CANCEL = "\103\101\116\x43\x45\114";
	const ICAL_METHOD_REFRESH = "\x52\x45\x46\x52\105\x53\110";
	const ICAL_METHOD_COUNTER = "\x43\x4f\x55\116\x54\x45\122";
	const ICAL_METHOD_DECLINECOUNTER = "\104\x45\x43\x4c\111\116\105\103\x4f\x55\116\124\105\122";
	public $Priority;
	public $CharSet = self::CHARSET_ISO88591;
	public $ContentType = self::CONTENT_TYPE_PLAINTEXT;
	public $Encoding = self::ENCODING_8BIT;
	public $ErrorInfo = '';
	public $From = "\x72\x6f\x6f\164\100\x6c\157\x63\x61\154\150\x6f\163\164";
	public $FromName = "\122\157\157\x74\x20\x55\x73\145\162";
	public $Sender = '';
	public $Subject = '';
	public $Body = '';
	public $AltBody = '';
	public $Ical = '';
	protected static $IcalMethods = array(self::ICAL_METHOD_REQUEST, self::ICAL_METHOD_PUBLISH, self::ICAL_METHOD_REPLY, self::ICAL_METHOD_ADD, self::ICAL_METHOD_CANCEL, self::ICAL_METHOD_REFRESH, self::ICAL_METHOD_COUNTER, self::ICAL_METHOD_DECLINECOUNTER);
	protected $MIMEBody = '';
	protected $MIMEHeader = '';
	protected $mailHeader = '';
	public $WordWrap = 0;
	public $Mailer = "\x6d\141\x69\154";
	public $Sendmail = "\57\x75\x73\162\57\x73\142\151\156\x2f\x73\x65\156\144\155\x61\x69\154";
	public $UseSendmailOptions = true;
	public $ConfirmReadingTo = '';
	public $Hostname = '';
	public $MessageID = '';
	public $MessageDate = '';
	public $Host = "\x6c\157\143\x61\x6c\x68\x6f\x73\164";
	public $Port = 25;
	public $Helo = '';
	public $SMTPSecure = '';
	public $SMTPAutoTLS = true;
	public $SMTPAuth = false;
	public $SMTPOptions = array();
	public $Username = '';
	public $Password = '';
	public $AuthType = '';
	protected $oauth;
	public $Timeout = 300;
	public $dsn = '';
	public $SMTPDebug = 0;
	public $Debugoutput = "\145\143\x68\x6f";
	public $SMTPKeepAlive = false;
	public $SingleTo = false;
	protected $SingleToArray = array();
	public $do_verp = false;
	public $AllowEmpty = false;
	public $DKIM_selector = '';
	public $DKIM_identity = '';
	public $DKIM_passphrase = '';
	public $DKIM_domain = '';
	public $DKIM_copyHeaderFields = true;
	public $DKIM_extraHeaders = array();
	public $DKIM_private = '';
	public $DKIM_private_string = '';
	public $action_function = '';
	public $XMailer = '';
	public static $validator = "\x70\150\x70";
	protected $smtp;
	protected $to = array();
	protected $cc = array();
	protected $bcc = array();
	protected $ReplyTo = array();
	protected $all_recipients = array();
	protected $RecipientsQueue = array();
	protected $ReplyToQueue = array();
	protected $attachment = array();
	protected $CustomHeader = array();
	protected $lastMessageID = '';
	protected $message_type = '';
	protected $boundary = array();
	protected $language = array();
	protected $error_count = 0;
	protected $sign_cert_file = '';
	protected $sign_key_file = '';
	protected $sign_extracerts_file = '';
	protected $sign_key_pass = '';
	protected $exceptions = false;
	protected $uniqueid = '';
	const VERSION = "\x36\56\x32\56\x30";
	const STOP_MESSAGE = 0;
	const STOP_CONTINUE = 1;
	const STOP_CRITICAL = 2;
	const CRLF = "\xd\12";
	const FWS = "\40";
	protected static $LE = self::CRLF;
	const MAIL_MAX_LINE_LENGTH = 63;
	const MAX_LINE_LENGTH = 998;
	const STD_LINE_LENGTH = 76;
	public function __construct($exceptions = null)
	{
		if (null !== $exceptions) {
			$this->exceptions = (bool) $exceptions;
		}
		$this->Debugoutput = strpos(PHP_SAPI, "\x63\154\151") !== false ? "\x65\x63\150\157" : "\x68\x74\x6d\x6c";
	}
	public function __destruct()
	{
		$this->smtpClose();
	}
	private function mailPassthru($to, $subject, $body, $header, $params)
	{
		if (ini_get("\155\x62\x73\x74\162\x69\x6e\147\56\146\165\156\143\x5f\x6f\x76\x65\x72\x6c\157\x61\x64") & 1) {
			$subject = $this->secureHeader($subject);
		} else {
			$subject = $this->encodeHeader($this->secureHeader($subject));
		}
		if (!$this->UseSendmailOptions || null === $params) {
			$result = @mail($to, $subject, $body, $header);
		} else {
			$result = @mail($to, $subject, $body, $header, $params);
		}
		return $result;
	}
	protected function edebug($str)
	{
		if ($this->SMTPDebug <= 0) {
			return;
		}
		if ($this->Debugoutput instanceof \Psr\Log\LoggerInterface) {
			$this->Debugoutput->debug($str);
			return;
		}
		if (is_callable($this->Debugoutput) && !in_array($this->Debugoutput, array("\x65\162\x72\157\x72\137\x6c\157\147", "\150\164\x6d\154", "\x65\143\x68\x6f"))) {
			call_user_func($this->Debugoutput, $str, $this->SMTPDebug);
			return;
		}
		switch ($this->Debugoutput) {
			case "\145\x72\162\x6f\162\137\154\x6f\x67":
				error_log($str);
				break;
			case "\x68\164\x6d\154":
				echo htmlentities(preg_replace("\x2f\133\x5c\162\134\156\135\53\x2f", '', $str), ENT_QUOTES, "\125\124\106\x2d\70"), "\x3c\142\162\x3e\xa";
				break;
			case "\145\x63\x68\157":
			default:
				$str = preg_replace("\57\134\x72\134\156\x7c\x5c\162\57\155", "\xa", $str);
				echo gmdate("\131\x2d\155\55\144\40\x48\72\x69\x3a\x73"), "\11", trim(str_replace("\xa", "\12\x20\x20\40\40\40\40\x20\x20\40\x20\x20\x20\x20\x20\x20\40\40\40\40\11\40\x20\x20\x20\x20\40\x20\x20\x20\x20\40\40\40\40\40\x20\x20\x20", trim($str))), "\12";
		}
	}
	public function isHTML($isHtml = true)
	{
		if ($isHtml) {
			$this->ContentType = static::CONTENT_TYPE_TEXT_HTML;
		} else {
			$this->ContentType = static::CONTENT_TYPE_PLAINTEXT;
		}
	}
	public function isSMTP()
	{
		$this->Mailer = "\x73\155\164\x70";
	}
	public function isMail()
	{
		$this->Mailer = "\x6d\141\151\154";
	}
	public function isSendmail()
	{
		$ini_sendmail_path = ini_get("\x73\145\156\x64\x6d\x61\x69\x6c\x5f\x70\x61\x74\150");
		if (false === stripos($ini_sendmail_path, "\163\145\x6e\144\x6d\141\151\154")) {
			$this->Sendmail = "\57\x75\163\162\x2f\x73\x62\151\x6e\x2f\163\145\x6e\144\155\x61\151\x6c";
		} else {
			$this->Sendmail = $ini_sendmail_path;
		}
		$this->Mailer = "\163\145\156\x64\x6d\141\x69\x6c";
	}
	public function isQmail()
	{
		$ini_sendmail_path = ini_get("\163\145\x6e\144\155\141\151\x6c\x5f\x70\x61\164\x68");
		if (false === stripos($ini_sendmail_path, "\161\155\141\151\x6c")) {
			$this->Sendmail = "\x2f\x76\141\162\57\161\x6d\x61\151\154\x2f\142\151\x6e\57\161\x6d\x61\x69\154\55\151\x6e\152\x65\x63\164";
		} else {
			$this->Sendmail = $ini_sendmail_path;
		}
		$this->Mailer = "\161\x6d\x61\151\x6c";
	}
	public function addAddress($address, $name = '')
	{
		return $this->addOrEnqueueAnAddress("\x74\x6f", $address, $name);
	}
	public function addCC($address, $name = '')
	{
		return $this->addOrEnqueueAnAddress("\x63\x63", $address, $name);
	}
	public function addBCC($address, $name = '')
	{
		return $this->addOrEnqueueAnAddress("\142\143\x63", $address, $name);
	}
	public function addReplyTo($address, $name = '')
	{
		return $this->addOrEnqueueAnAddress("\x52\x65\160\x6c\171\55\124\x6f", $address, $name);
	}
	protected function addOrEnqueueAnAddress($kind, $address, $name)
	{
		$address = trim($address);
		$name = trim(preg_replace("\x2f\133\x5c\162\x5c\156\135\x2b\x2f", '', $name));
		$pos = strrpos($address, "\x40");
		if (false === $pos) {
			$error_message = sprintf("\45\163\x20\x28\x25\163\51\72\x20\x25\x73", $this->lang("\151\x6e\166\141\154\151\x64\137\x61\x64\144\x72\145\x73\163"), $kind, $address);
			$this->setError($error_message);
			$this->edebug($error_message);
			if ($this->exceptions) {
				throw new Exception($error_message);
			}
			return false;
		}
		$params = array($kind, $address, $name);
		if (static::idnSupported() && $this->has8bitChars(substr($address, ++$pos))) {
			if ("\x52\x65\x70\x6c\171\55\124\157" !== $kind) {
				if (!array_key_exists($address, $this->RecipientsQueue)) {
					$this->RecipientsQueue[$address] = $params;
					return true;
				}
			} elseif (!array_key_exists($address, $this->ReplyToQueue)) {
				$this->ReplyToQueue[$address] = $params;
				return true;
			}
			return false;
		}
		return call_user_func_array(array($this, "\141\144\x64\101\156\101\144\x64\162\x65\163\163"), $params);
	}
	protected function addAnAddress($kind, $address, $name = '')
	{
		if (!in_array($kind, array("\x74\x6f", "\143\x63", "\142\x63\143", "\x52\145\160\154\x79\55\x54\157"))) {
			$error_message = sprintf("\45\x73\x3a\x20\45\163", $this->lang("\111\156\x76\x61\x6c\x69\144\40\x72\145\x63\151\x70\151\145\x6e\164\40\x6b\151\x6e\x64"), $kind);
			$this->setError($error_message);
			$this->edebug($error_message);
			if ($this->exceptions) {
				throw new Exception($error_message);
			}
			return false;
		}
		if (!static::validateAddress($address)) {
			$error_message = sprintf("\45\x73\40\x28\x25\163\51\72\x20\45\x73", $this->lang("\x69\156\166\x61\154\x69\x64\137\x61\x64\144\162\145\x73\x73"), $kind, $address);
			$this->setError($error_message);
			$this->edebug($error_message);
			if ($this->exceptions) {
				throw new Exception($error_message);
			}
			return false;
		}
		if ("\x52\x65\x70\x6c\x79\55\x54\x6f" !== $kind) {
			if (!array_key_exists(strtolower($address), $this->all_recipients)) {
				$this->{$kind}[] = array($address, $name);
				$this->all_recipients[strtolower($address)] = true;
				return true;
			}
		} elseif (!array_key_exists(strtolower($address), $this->ReplyTo)) {
			$this->ReplyTo[strtolower($address)] = array($address, $name);
			return true;
		}
		return false;
	}
	public static function parseAddresses($addrstr, $useimap = true)
	{
		$addresses = array();
		if ($useimap && function_exists("\151\x6d\x61\160\137\162\146\143\x38\x32\62\x5f\160\141\x72\x73\145\x5f\141\144\x72\154\151\163\x74")) {
			$list = imap_rfc822_parse_adrlist($addrstr, '');
			foreach ($list as $address) {
				if ("\x2e\x53\x59\116\124\101\130\55\105\122\122\x4f\x52\x2e" !== $address->host && static::validateAddress($address->mailbox . "\100" . $address->host)) {
					$addresses[] = array("\156\x61\x6d\145" => property_exists($address, "\160\x65\x72\x73\157\156\141\x6c") ? $address->personal : '', "\141\144\144\162\145\x73\x73" => $address->mailbox . "\x40" . $address->host);
				}
			}
		} else {
			$list = explode("\54", $addrstr);
			foreach ($list as $address) {
				$address = trim($address);
				if (strpos($address, "\x3c") === false) {
					if (static::validateAddress($address)) {
						$addresses[] = array("\x6e\141\x6d\145" => '', "\141\x64\x64\x72\145\163\x73" => $address);
					}
				} else {
					list($name, $email) = explode("\x3c", $address);
					$email = trim(str_replace("\76", '', $email));
					if (static::validateAddress($email)) {
						$addresses[] = array("\156\141\x6d\145" => trim(str_replace(array("\42", "\47"), '', $name)), "\x61\x64\144\162\145\x73\x73" => $email);
					}
				}
			}
		}
		return $addresses;
	}
	public function setFrom($address, $name = '', $auto = true)
	{
		$address = trim($address);
		$name = trim(preg_replace("\x2f\133\134\162\134\x6e\135\x2b\57", '', $name));
		$pos = strrpos($address, "\100");
		if (false === $pos || (!$this->has8bitChars(substr($address, ++$pos)) || !static::idnSupported()) && !static::validateAddress($address)) {
			$error_message = sprintf("\x25\163\40\50\x46\x72\157\x6d\51\x3a\x20\x25\x73", $this->lang("\151\x6e\x76\x61\154\x69\x64\137\141\x64\x64\x72\x65\163\x73"), $address);
			$this->setError($error_message);
			$this->edebug($error_message);
			if ($this->exceptions) {
				throw new Exception($error_message);
			}
			return false;
		}
		$this->From = $address;
		$this->FromName = $name;
		if ($auto && empty($this->Sender)) {
			$this->Sender = $address;
		}
		return true;
	}
	public function getLastMessageID()
	{
		return $this->lastMessageID;
	}
	public static function validateAddress($address, $patternselect = null)
	{
		if (null === $patternselect) {
			$patternselect = static::$validator;
		}
		if (is_callable($patternselect)) {
			return call_user_func($patternselect, $address);
		}
		if (strpos($address, "\12") !== false || strpos($address, "\15") !== false) {
			return false;
		}
		switch ($patternselect) {
			case "\160\143\162\145":
			case "\x70\x63\162\x65\x38":
				return (bool) preg_match("\57\136\50\77\x21\x28\x3f\x3e\x28\77\x31\x29\42\77\x28\77\76\x5c\134\133\x20\x2d\x7e\135\x7c\133\x5e\42\135\x29\x22\x3f\x28\77\x31\51\x29\173\62\x35\65\x2c\x7d\51\x28\77\41\50\77\x3e\x28\77\x31\51\x22\x3f\x28\x3f\x3e\134\134\133\x20\55\176\x5d\x7c\133\x5e\x22\135\x29\x22\x3f\50\x3f\61\51\x29\173\x36\65\x2c\175\x40\x29" . "\x28\50\x3f\76\x28\77\76\x28\x3f\76\x28\x28\x3f\76\x28\x3f\76\x28\77\76\x5c\170\x30\104\134\x78\60\x41\x29\x3f\133\134\x74\x20\135\x29\53\174\50\77\76\133\x5c\x74\40\135\52\x5c\x78\60\x44\134\170\60\x41\x29\77\x5b\134\x74\40\135\x2b\x29\x3f\x29\50\x5c\x28\x28\x3f\76\50\x3f\x32\x29" . "\x28\77\x3e\133\x5c\x78\60\x31\55\x5c\170\60\x38\134\x78\60\x42\134\170\x30\103\134\x78\x30\x45\x2d\47\52\x2d\x5c\133\134\135\x2d\x5c\x78\x37\106\x5d\x7c\134\134\x5b\x5c\x78\x30\60\55\134\170\x37\106\135\174\x28\x3f\x33\51\x29\51\x2a\x28\x3f\x32\51\x5c\x29\51\51\x2b\x28\77\62\51\51\174\x28\77\62\51\x29\77\x29" . "\x28\133\x21\x23\x2d\x27\x2a\x2b\x5c\57\55\71\75\77\x5e\55\176\x2d\135\x2b\174\42\x28\x3f\x3e\50\x3f\x32\51\50\77\76\133\x5c\x78\60\61\x2d\134\170\x30\70\x5c\170\x30\102\134\x78\60\103\134\x78\x30\105\x2d\x21\43\x2d\x5c\133\x5c\x5d\55\134\x78\x37\106\x5d\174\134\x5c\x5b\134\170\x30\x30\x2d\x5c\170\67\x46\135\x29\51\x2a" . "\x28\x3f\x32\51\x22\x29\x28\x3f\76\50\x3f\x31\51\x5c\x2e\x28\77\x31\x29\50\x3f\x34\51\x29\52\x28\77\61\x29\x40\50\x3f\41\x28\77\x31\x29\x5b\x61\55\172\60\55\71\x2d\135\x7b\x36\x34\54\x7d\51\x28\x3f\61\x29\x28\77\x3e\50\133\x61\55\x7a\60\x2d\x39\x5d\50\77\76\x5b\x61\x2d\x7a\x30\x2d\71\x2d\x5d\x2a\133\141\55\172\60\x2d\x39\x5d\x29\77\x29" . "\x28\77\x3e\x28\77\x31\x29\x5c\56\x28\77\x21\50\77\x31\51\x5b\x61\x2d\x7a\x30\x2d\71\x2d\135\x7b\x36\64\x2c\x7d\x29\50\x3f\61\51\50\x3f\x35\x29\51\x7b\x30\54\61\x32\66\x7d\x7c\134\133\x28\77\x3a\x28\x3f\76\111\120\x76\66\72\x28\77\x3e\50\x5b\x61\55\146\60\55\x39\x5d\x7b\x31\54\x34\175\51\50\x3f\76\x3a\x28\x3f\66\x29\x29\173\x37\175" . "\174\50\77\41\50\77\x3a\56\x2a\133\x61\55\146\x30\55\x39\135\133\x3a\x5c\135\135\51\x7b\x38\54\x7d\x29\50\x28\x3f\66\x29\x28\x3f\76\72\50\x3f\x36\x29\x29\x7b\x30\x2c\x36\x7d\x29\77\x3a\72\x28\77\x37\51\x3f\x29\51\x7c\x28\77\76\x28\x3f\76\x49\120\x76\x36\x3a\50\x3f\x3e\x28\x3f\66\51\50\77\x3e\x3a\x28\x3f\66\51\x29\173\65\175\72" . "\174\x28\77\x21\x28\77\72\56\52\133\x61\55\146\x30\x2d\x39\x5d\72\51\173\66\54\x7d\51\50\x3f\70\51\x3f\x3a\72\50\x3f\76\50\50\77\x36\x29\x28\77\76\72\50\x3f\x36\51\x29\x7b\x30\54\64\175\51\72\51\77\x29\x29\77\x28\62\65\x5b\x30\x2d\65\135\x7c\x32\x5b\x30\55\x34\x5d\133\60\x2d\71\x5d\174\61\x5b\60\x2d\x39\x5d\x7b\62\x7d" . "\x7c\x5b\61\x2d\x39\135\x3f\133\60\x2d\x39\x5d\51\x28\77\76\x5c\56\x28\x3f\71\x29\51\x7b\x33\x7d\51\51\x5c\135\51\x28\x3f\x31\51\44\57\x69\x73\104", $address);
			case "\150\x74\155\x6c\x35":
				return (bool) preg_match("\57\x5e\133\141\x2d\172\x41\x2d\132\60\x2d\x39\56\41\x23\x24\x25\46\47\52\x2b\x5c\x2f\75\x3f\x5e\x5f\x60\x7b\x7c\175\x7e\55\135\53\x40\x5b\141\x2d\172\x41\x2d\132\60\x2d\x39\x5d\50\77\x3a\x5b\141\55\x7a\101\55\x5a\x30\x2d\71\x2d\135\x7b\x30\x2c\66\61\x7d" . "\x5b\141\x2d\172\x41\55\x5a\x30\x2d\x39\x5d\x29\77\50\x3f\72\x5c\56\133\x61\55\x7a\101\x2d\x5a\x30\55\71\135\x28\x3f\x3a\x5b\141\x2d\172\x41\55\132\60\x2d\x39\55\x5d\173\60\54\66\61\175\133\x61\x2d\172\x41\x2d\x5a\60\55\x39\135\x29\x3f\51\x2a\44\x2f\163\x44", $address);
			case "\x70\150\x70":
			default:
				return filter_var($address, FILTER_VALIDATE_EMAIL) !== false;
		}
	}
	public static function idnSupported()
	{
		return function_exists("\x69\x64\x6e\x5f\164\157\x5f\141\x73\x63\x69\x69") && function_exists("\x6d\x62\x5f\x63\157\x6e\166\x65\162\164\137\x65\156\x63\157\x64\151\x6e\x67");
	}
	public function punyencodeAddress($address)
	{
		$pos = strrpos($address, "\100");
		if (!empty($this->CharSet) && false !== $pos && static::idnSupported()) {
			$domain = substr($address, ++$pos);
			if ($this->has8bitChars($domain) && @mb_check_encoding($domain, $this->CharSet)) {
				$domain = mb_convert_encoding($domain, "\125\x54\x46\x2d\x38", $this->CharSet);
				$errorcode = 0;
				if (defined("\x49\116\124\114\x5f\111\x44\116\101\137\126\x41\x52\x49\101\x4e\124\137\125\x54\x53\x34\66")) {
					$punycode = idn_to_ascii($domain, $errorcode, INTL_IDNA_VARIANT_UTS46);
				} elseif (defined("\111\x4e\x54\114\x5f\x49\x44\116\101\x5f\x56\101\122\x49\101\116\x54\x5f\x32\x30\x30\63")) {
					$punycode = idn_to_ascii($domain, $errorcode, INTL_IDNA_VARIANT_2003);
				} else {
					$punycode = idn_to_ascii($domain, $errorcode);
				}
				if (false !== $punycode) {
					return substr($address, 0, $pos) . $punycode;
				}
			}
		}
		return $address;
	}
	public function send()
	{
		try {
			if (!$this->preSend()) {
				return false;
			}
			return $this->postSend();
		} catch (Exception $exc) {
			$this->mailHeader = '';
			$this->setError($exc->getMessage());
			if ($this->exceptions) {
				throw $exc;
			}
			return false;
		}
	}
	public function preSend()
	{
		if ("\x73\x6d\164\160" === $this->Mailer || "\x6d\141\151\x6c" === $this->Mailer && (\PHP_VERSION_ID >= 80000 || stripos(PHP_OS, "\x57\x49\x4e") === 0)) {
			static::setLE(self::CRLF);
		} else {
			static::setLE(PHP_EOL);
		}
		if ("\x6d\x61\x69\x6c" === $this->Mailer && (\PHP_VERSION_ID >= 70000 && \PHP_VERSION_ID < 70017 || \PHP_VERSION_ID >= 70100 && \PHP_VERSION_ID < 70103) && ini_get("\155\141\x69\x6c\x2e\141\x64\x64\137\170\x5f\x68\145\141\144\x65\x72") === "\x31" && stripos(PHP_OS, "\127\x49\x4e") === 0) {
			trigger_error("\x59\157\x75\162\40\x76\x65\x72\x73\x69\x6f\x6e\40\157\x66\x20\x50\110\120\x20\151\163\40\x61\146\x66\145\143\164\x65\x64\40\x62\171\x20\x61\x20\x62\x75\x67\x20\x74\x68\x61\x74\x20\x6d\x61\x79\x20\x72\145\x73\165\x6c\x74\40\x69\156\x20\143\x6f\162\162\x75\160\164\x65\144\40\x6d\145\163\x73\x61\x67\145\x73\x2e" . "\40\x54\x6f\40\146\151\x78\40\x69\x74\54\x20\x73\x77\x69\x74\x63\x68\x20\x74\157\40\163\145\156\x64\151\156\x67\x20\165\163\x69\x6e\x67\x20\123\115\124\x50\54\40\x64\x69\x73\141\142\x6c\x65\40\164\x68\x65\40\x6d\x61\x69\154\56\141\x64\x64\137\170\137\150\145\x61\144\x65\162\x20\157\x70\164\151\x6f\x6e\x20\x69\156" . "\40\171\157\x75\x72\40\x70\150\160\x2e\x69\x6e\x69\x2c\x20\163\167\151\164\143\x68\x20\x74\157\40\x4d\141\143\117\x53\40\x6f\162\40\114\151\x6e\165\170\x2c\x20\157\162\x20\165\x70\147\162\x61\144\x65\40\171\157\165\x72\x20\x50\x48\x50\40\x74\x6f\40\166\145\x72\163\x69\157\156\40\67\56\x30\56\x31\x37\53\x20\157\x72\40\67\x2e\61\x2e\x33\x2b\56", E_USER_WARNING);
		}
		try {
			$this->error_count = 0;
			$this->mailHeader = '';
			foreach (array_merge($this->RecipientsQueue, $this->ReplyToQueue) as $params) {
				$params[1] = $this->punyencodeAddress($params[1]);
				call_user_func_array(array($this, "\x61\x64\144\101\156\101\144\144\x72\145\x73\x73"), $params);
			}
			if (count($this->to) + count($this->cc) + count($this->bcc) < 1) {
				throw new Exception($this->lang("\160\x72\157\x76\x69\144\x65\137\141\144\x64\x72\x65\163\x73"), self::STOP_CRITICAL);
			}
			foreach (array("\106\162\157\x6d", "\123\145\x6e\144\145\162", "\103\x6f\x6e\x66\x69\x72\155\122\145\141\x64\151\x6e\147\124\x6f") as $address_kind) {
				$this->{$address_kind} = trim($this->{$address_kind});
				if (empty($this->{$address_kind})) {
					continue;
				}
				$this->{$address_kind} = $this->punyencodeAddress($this->{$address_kind});
				if (!static::validateAddress($this->{$address_kind})) {
					$error_message = sprintf("\x25\163\40\x28\x25\x73\x29\x3a\x20\x25\x73", $this->lang("\x69\x6e\x76\x61\154\151\144\137\141\x64\x64\162\x65\163\163"), $address_kind, $this->{$address_kind});
					$this->setError($error_message);
					$this->edebug($error_message);
					if ($this->exceptions) {
						throw new Exception($error_message);
					}
					return false;
				}
			}
			if ($this->alternativeExists()) {
				$this->ContentType = static::CONTENT_TYPE_MULTIPART_ALTERNATIVE;
			}
			$this->setMessageType();
			if (!$this->AllowEmpty && empty($this->Body)) {
				throw new Exception($this->lang("\x65\155\160\164\x79\137\x6d\x65\x73\163\141\x67\x65"), self::STOP_CRITICAL);
			}
			$this->Subject = trim($this->Subject);
			$this->MIMEHeader = '';
			$this->MIMEBody = $this->createBody();
			$tempheaders = $this->MIMEHeader;
			$this->MIMEHeader = $this->createHeader();
			$this->MIMEHeader .= $tempheaders;
			if ("\x6d\x61\x69\x6c" === $this->Mailer) {
				if (count($this->to) > 0) {
					$this->mailHeader .= $this->addrAppend("\x54\x6f", $this->to);
				} else {
					$this->mailHeader .= $this->headerLine("\124\x6f", "\165\156\144\x69\163\x63\154\157\x73\x65\144\x2d\x72\145\x63\x69\x70\x69\145\156\164\x73\x3a\x3b");
				}
				$this->mailHeader .= $this->headerLine("\123\165\142\x6a\145\x63\164", $this->encodeHeader($this->secureHeader($this->Subject)));
			}
			if (!empty($this->DKIM_domain) && !empty($this->DKIM_selector) && (!empty($this->DKIM_private_string) || !empty($this->DKIM_private) && static::isPermittedPath($this->DKIM_private) && file_exists($this->DKIM_private))) {
				$header_dkim = $this->DKIM_Add($this->MIMEHeader . $this->mailHeader, $this->encodeHeader($this->secureHeader($this->Subject)), $this->MIMEBody);
				$this->MIMEHeader = static::stripTrailingWSP($this->MIMEHeader) . static::$LE . static::normalizeBreaks($header_dkim) . static::$LE;
			}
			return true;
		} catch (Exception $exc) {
			$this->setError($exc->getMessage());
			if ($this->exceptions) {
				throw $exc;
			}
			return false;
		}
	}
	public function postSend()
	{
		try {
			switch ($this->Mailer) {
				case "\163\145\x6e\144\155\141\151\154":
				case "\161\x6d\141\x69\154":
					return $this->sendmailSend($this->MIMEHeader, $this->MIMEBody);
				case "\163\x6d\x74\160":
					return $this->smtpSend($this->MIMEHeader, $this->MIMEBody);
				case "\155\x61\x69\154":
					return $this->mailSend($this->MIMEHeader, $this->MIMEBody);
				default:
					$sendMethod = $this->Mailer . "\123\145\156\x64";
					if (method_exists($this, $sendMethod)) {
						return $this->{$sendMethod}($this->MIMEHeader, $this->MIMEBody);
					}
					return $this->mailSend($this->MIMEHeader, $this->MIMEBody);
			}
		} catch (Exception $exc) {
			if ($this->Mailer === "\163\155\x74\160" && $this->SMTPKeepAlive == true) {
				$this->smtp->reset();
			}
			$this->setError($exc->getMessage());
			$this->edebug($exc->getMessage());
			if ($this->exceptions) {
				throw $exc;
			}
		}
		return false;
	}
	protected function sendmailSend($header, $body)
	{
		$header = static::stripTrailingWSP($header) . static::$LE . static::$LE;
		if (!empty($this->Sender) && self::isShellSafe($this->Sender)) {
			if ("\x71\155\x61\151\x6c" === $this->Mailer) {
				$sendmailFmt = "\x25\x73\x20\x2d\146\x25\163";
			} else {
				$sendmailFmt = "\45\x73\x20\x2d\x6f\151\40\x2d\x66\45\163\40\55\164";
			}
		} elseif ("\x71\155\141\151\x6c" === $this->Mailer) {
			$sendmailFmt = "\45\163";
		} else {
			$sendmailFmt = "\45\163\x20\55\x6f\x69\x20\55\164";
		}
		$sendmail = sprintf($sendmailFmt, escapeshellcmd($this->Sendmail), $this->Sender);
		if ($this->SingleTo) {
			foreach ($this->SingleToArray as $toAddr) {
				$mail = @popen($sendmail, "\167");
				if (!$mail) {
					throw new Exception($this->lang("\145\x78\x65\143\x75\164\145") . $this->Sendmail, self::STOP_CRITICAL);
				}
				fwrite($mail, "\124\157\x3a\40" . $toAddr . "\xa");
				fwrite($mail, $header);
				fwrite($mail, $body);
				$result = pclose($mail);
				$this->doCallback($result === 0, array($toAddr), $this->cc, $this->bcc, $this->Subject, $body, $this->From, array());
				if (0 !== $result) {
					throw new Exception($this->lang("\x65\x78\145\143\165\x74\145") . $this->Sendmail, self::STOP_CRITICAL);
				}
			}
		} else {
			$mail = @popen($sendmail, "\167");
			if (!$mail) {
				throw new Exception($this->lang("\145\170\x65\143\x75\x74\x65") . $this->Sendmail, self::STOP_CRITICAL);
			}
			fwrite($mail, $header);
			fwrite($mail, $body);
			$result = pclose($mail);
			$this->doCallback($result === 0, $this->to, $this->cc, $this->bcc, $this->Subject, $body, $this->From, array());
			if (0 !== $result) {
				throw new Exception($this->lang("\x65\170\145\x63\x75\x74\x65") . $this->Sendmail, self::STOP_CRITICAL);
			}
		}
		return true;
	}
	protected static function isShellSafe($string)
	{
		if (escapeshellcmd($string) !== $string || !in_array(escapeshellarg($string), array("\47{$string}\47", "\x22{$string}\x22"))) {
			return false;
		}
		$length = strlen($string);
		for ($i = 0; $i < $length; ++$i) {
			$c = $string[$i];
			if (!ctype_alnum($c) && strpos("\100\137\x2d\x2e", $c) === false) {
				return false;
			}
		}
		return true;
	}
	protected static function isPermittedPath($path)
	{
		return !preg_match("\x23\x5e\x5b\141\55\x7a\x5d\x2b\x3a\57\57\43\x69", $path);
	}
	protected static function fileIsAccessible($path)
	{
		$readable = file_exists($path);
		if (strpos($path, "\x5c\x5c") !== 0) {
			$readable = $readable && is_readable($path);
		}
		return static::isPermittedPath($path) && $readable;
	}
	protected function mailSend($header, $body)
	{
		$header = static::stripTrailingWSP($header) . static::$LE . static::$LE;
		$toArr = array();
		foreach ($this->to as $toaddr) {
			$toArr[] = $this->addrFormat($toaddr);
		}
		$to = implode("\54\40", $toArr);
		$params = null;
		if (!empty($this->Sender) && static::validateAddress($this->Sender) && self::isShellSafe($this->Sender)) {
			$params = sprintf("\x2d\x66\45\x73", $this->Sender);
		}
		if (!empty($this->Sender) && static::validateAddress($this->Sender)) {
			$old_from = ini_get("\163\x65\x6e\144\x6d\x61\151\x6c\137\146\162\157\x6d");
			ini_set("\163\x65\x6e\144\155\x61\x69\x6c\137\146\x72\x6f\155", $this->Sender);
		}
		$result = false;
		if ($this->SingleTo && count($toArr) > 1) {
			foreach ($toArr as $toAddr) {
				$result = $this->mailPassthru($toAddr, $this->Subject, $body, $header, $params);
				$this->doCallback($result, array($toAddr), $this->cc, $this->bcc, $this->Subject, $body, $this->From, array());
			}
		} else {
			$result = $this->mailPassthru($to, $this->Subject, $body, $header, $params);
			$this->doCallback($result, $this->to, $this->cc, $this->bcc, $this->Subject, $body, $this->From, array());
		}
		if (isset($old_from)) {
			ini_set("\x73\x65\156\x64\155\x61\x69\x6c\137\x66\x72\x6f\155", $old_from);
		}
		if (!$result) {
			throw new Exception($this->lang("\x69\x6e\163\164\x61\x6e\164\151\x61\x74\145"), self::STOP_CRITICAL);
		}
		return true;
	}
	public function getSMTPInstance()
	{
		if (!is_object($this->smtp)) {
			$this->smtp = new SMTP();
		}
		return $this->smtp;
	}
	public function setSMTPInstance(SMTP $smtp)
	{
		$this->smtp = $smtp;
		return $this->smtp;
	}
	protected function smtpSend($header, $body)
	{
		$header = static::stripTrailingWSP($header) . static::$LE . static::$LE;
		$bad_rcpt = array();
		if (!$this->smtpConnect($this->SMTPOptions)) {
			throw new Exception($this->lang("\163\155\164\x70\x5f\143\x6f\x6e\156\145\x63\x74\x5f\146\x61\x69\154\145\x64"), self::STOP_CRITICAL);
		}
		if ('' === $this->Sender) {
			$smtp_from = $this->From;
		} else {
			$smtp_from = $this->Sender;
		}
		if (!$this->smtp->mail($smtp_from)) {
			$this->setError($this->lang("\x66\162\x6f\155\137\x66\x61\x69\x6c\145\144") . $smtp_from . "\40\x3a\x20" . implode("\54", $this->smtp->getError()));
			throw new Exception($this->ErrorInfo, self::STOP_CRITICAL);
		}
		$callbacks = array();
		foreach (array($this->to, $this->cc, $this->bcc) as $togroup) {
			foreach ($togroup as $to) {
				if (!$this->smtp->recipient($to[0], $this->dsn)) {
					$error = $this->smtp->getError();
					$bad_rcpt[] = array("\164\x6f" => $to[0], "\x65\x72\162\x6f\x72" => $error["\144\145\164\141\x69\x6c"]);
					$isSent = false;
				} else {
					$isSent = true;
				}
				$callbacks[] = array("\151\x73\x73\x65\x6e\x74" => $isSent, "\x74\157" => $to[0]);
			}
		}
		if (count($this->all_recipients) > count($bad_rcpt) && !$this->smtp->data($header . $body)) {
			throw new Exception($this->lang("\144\x61\164\x61\137\156\x6f\164\x5f\141\x63\x63\145\160\x74\145\144"), self::STOP_CRITICAL);
		}
		$smtp_transaction_id = $this->smtp->getLastTransactionID();
		if ($this->SMTPKeepAlive) {
			$this->smtp->reset();
		} else {
			$this->smtp->quit();
			$this->smtp->close();
		}
		foreach ($callbacks as $cb) {
			$this->doCallback($cb["\151\163\x73\x65\156\164"], array($cb["\x74\157"]), array(), array(), $this->Subject, $body, $this->From, array("\x73\155\x74\x70\137\x74\x72\x61\x6e\163\141\x63\x74\151\157\156\x5f\151\144" => $smtp_transaction_id));
		}
		if (count($bad_rcpt) > 0) {
			$errstr = '';
			foreach ($bad_rcpt as $bad) {
				$errstr .= $bad["\x74\157"] . "\72\x20" . $bad["\x65\162\x72\157\x72"];
			}
			throw new Exception($this->lang("\x72\145\x63\151\x70\151\145\156\164\x73\137\x66\141\x69\x6c\x65\144") . $errstr, self::STOP_CONTINUE);
		}
		return true;
	}
	public function smtpConnect($options = null)
	{
		if (null === $this->smtp) {
			$this->smtp = $this->getSMTPInstance();
		}
		if (null === $options) {
			$options = $this->SMTPOptions;
		}
		if ($this->smtp->connected()) {
			return true;
		}
		$this->smtp->setTimeout($this->Timeout);
		$this->smtp->setDebugLevel($this->SMTPDebug);
		$this->smtp->setDebugOutput($this->Debugoutput);
		$this->smtp->setVerp($this->do_verp);
		$hosts = explode("\73", $this->Host);
		$lastexception = null;
		foreach ($hosts as $hostentry) {
			$hostinfo = array();
			if (!preg_match("\57\136\x28\x3f\72\50\x73\x73\x6c\x7c\x74\154\x73\x29\x3a\x5c\x2f\134\57\x29\77\x28\x2e\x2b\77\x29\50\77\x3a\72\x28\x5c\144\53\51\x29\x3f\44\57", trim($hostentry), $hostinfo)) {
				$this->edebug($this->lang("\151\x6e\x76\141\154\151\144\x5f\x68\157\x73\164\x65\x6e\x74\162\171") . "\x20" . trim($hostentry));
				continue;
			}
			if (!static::isValidHost($hostinfo[2])) {
				$this->edebug($this->lang("\151\x6e\166\x61\x6c\151\x64\x5f\x68\157\x73\x74") . "\x20" . $hostinfo[2]);
				continue;
			}
			$prefix = '';
			$secure = $this->SMTPSecure;
			$tls = static::ENCRYPTION_STARTTLS === $this->SMTPSecure;
			if ("\163\x73\154" === $hostinfo[1] || '' === $hostinfo[1] && static::ENCRYPTION_SMTPS === $this->SMTPSecure) {
				$prefix = "\163\163\x6c\72\57\57";
				$tls = false;
				$secure = static::ENCRYPTION_SMTPS;
			} elseif ("\164\154\x73" === $hostinfo[1]) {
				$tls = true;
				$secure = static::ENCRYPTION_STARTTLS;
			}
			$sslext = defined("\117\x50\105\116\x53\x53\x4c\137\101\x4c\x47\x4f\137\x53\110\101\x32\x35\66");
			if (static::ENCRYPTION_STARTTLS === $secure || static::ENCRYPTION_SMTPS === $secure) {
				if (!$sslext) {
					throw new Exception($this->lang("\145\170\164\x65\x6e\x73\x69\x6f\x6e\137\x6d\151\x73\x73\151\156\147") . "\x6f\x70\145\156\x73\x73\x6c", self::STOP_CRITICAL);
				}
			}
			$host = $hostinfo[2];
			$port = $this->Port;
			if (array_key_exists(3, $hostinfo) && is_numeric($hostinfo[3]) && $hostinfo[3] > 0 && $hostinfo[3] < 65536) {
				$port = (int) $hostinfo[3];
			}
			if ($this->smtp->connect($prefix . $host, $port, $this->Timeout, $options)) {
				try {
					if ($this->Helo) {
						$hello = $this->Helo;
					} else {
						$hello = $this->serverHostname();
					}
					$this->smtp->hello($hello);
					if ($this->SMTPAutoTLS && $sslext && "\x73\x73\x6c" !== $secure && $this->smtp->getServerExt("\123\124\x41\122\124\124\114\x53")) {
						$tls = true;
					}
					if ($tls) {
						if (!$this->smtp->startTLS()) {
							throw new Exception($this->lang("\x63\157\x6e\156\145\143\x74\x5f\x68\x6f\x73\164"));
						}
						$this->smtp->hello($hello);
					}
					if ($this->SMTPAuth && !$this->smtp->authenticate($this->Username, $this->Password, $this->AuthType, $this->oauth)) {
						throw new Exception($this->lang("\x61\165\164\x68\x65\156\164\x69\143\141\164\x65"));
					}
					return true;
				} catch (Exception $exc) {
					$lastexception = $exc;
					$this->edebug($exc->getMessage());
					$this->smtp->quit();
				}
			}
		}
		$this->smtp->close();
		if ($this->exceptions && null !== $lastexception) {
			throw $lastexception;
		}
		return false;
	}
	public function smtpClose()
	{
		if (null !== $this->smtp && $this->smtp->connected()) {
			$this->smtp->quit();
			$this->smtp->close();
		}
	}
	public function setLanguage($langcode = "\x65\x6e", $lang_path = '')
	{
		$renamed_langcodes = array("\x62\x72" => "\x70\164\137\x62\162", "\143\x7a" => "\x63\163", "\144\x6b" => "\144\x61", "\x6e\157" => "\156\x62", "\x73\145" => "\163\x76", "\x72\x73" => "\x73\x72", "\164\147" => "\164\x6c", "\141\155" => "\x68\x79");
		if (array_key_exists($langcode, $renamed_langcodes)) {
			$langcode = $renamed_langcodes[$langcode];
		}
		$PHPMAILER_LANG = array("\x61\x75\164\x68\x65\156\x74\151\143\141\x74\145" => "\x53\x4d\124\120\x20\105\162\x72\157\162\72\x20\x43\157\x75\154\x64\x20\x6e\157\x74\40\x61\165\x74\150\x65\x6e\164\151\143\141\164\145\x2e", "\143\157\156\156\x65\x63\164\x5f\150\x6f\163\x74" => "\123\115\x54\120\x20\x45\x72\x72\x6f\162\x3a\40\x43\157\x75\x6c\x64\x20\156\x6f\x74\40\x63\x6f\x6e\156\x65\x63\x74\x20\164\x6f\x20\x53\x4d\124\120\40\x68\157\x73\x74\56", "\x64\141\x74\x61\137\156\x6f\x74\137\x61\x63\143\x65\160\164\145\x64" => "\x53\x4d\124\120\40\105\162\162\x6f\x72\x3a\40\144\x61\x74\x61\40\x6e\x6f\164\x20\x61\x63\x63\x65\160\164\x65\144\x2e", "\145\x6d\160\x74\171\x5f\155\x65\163\x73\141\x67\x65" => "\x4d\145\163\x73\141\x67\145\40\142\157\144\x79\40\x65\x6d\x70\164\171", "\145\x6e\x63\x6f\144\151\x6e\147" => "\125\156\x6b\156\157\x77\x6e\x20\145\x6e\x63\x6f\144\x69\x6e\x67\72\40", "\x65\170\145\x63\165\x74\x65" => "\x43\x6f\x75\x6c\144\x20\x6e\x6f\x74\x20\x65\170\x65\x63\x75\x74\145\72\x20", "\146\x69\x6c\145\x5f\x61\143\143\145\x73\x73" => "\103\157\165\154\x64\40\156\x6f\164\40\141\x63\x63\145\163\163\x20\x66\x69\x6c\145\x3a\40", "\146\x69\154\x65\x5f\157\x70\145\x6e" => "\106\151\154\x65\x20\105\x72\x72\x6f\162\72\x20\x43\x6f\165\x6c\x64\40\x6e\157\164\40\x6f\160\x65\x6e\x20\x66\x69\x6c\x65\x3a\40", "\146\162\157\155\137\146\x61\151\x6c\145\144" => "\124\150\145\40\x66\x6f\154\154\x6f\167\151\x6e\x67\x20\x46\162\157\155\x20\141\144\x64\162\145\x73\163\x20\146\141\151\154\145\x64\x3a\x20", "\x69\x6e\x73\x74\x61\156\x74\x69\141\164\x65" => "\103\157\x75\154\x64\40\156\x6f\164\40\x69\156\x73\164\141\156\164\x69\x61\x74\x65\x20\x6d\x61\151\154\x20\x66\x75\156\x63\164\151\x6f\156\x2e", "\151\156\x76\141\x6c\151\144\x5f\x61\x64\x64\x72\145\163\x73" => "\111\156\x76\x61\154\x69\144\40\x61\144\144\162\145\x73\x73\72\x20", "\x69\156\x76\x61\x6c\x69\144\137\x68\x6f\163\x74\145\x6e\x74\162\171" => "\111\x6e\x76\141\x6c\x69\144\40\x68\x6f\x73\164\145\x6e\x74\162\171\x3a\40", "\151\x6e\x76\141\x6c\x69\x64\137\150\x6f\x73\164" => "\111\x6e\166\x61\154\x69\144\40\150\x6f\163\164\x3a\x20", "\155\141\x69\x6c\x65\x72\x5f\x6e\x6f\x74\137\163\x75\160\160\x6f\162\164\x65\144" => "\40\x6d\x61\x69\x6c\145\x72\40\151\163\40\x6e\157\x74\x20\x73\165\160\160\x6f\162\x74\145\x64\56", "\160\x72\157\166\151\x64\x65\137\141\x64\144\162\x65\163\163" => "\131\157\165\40\155\x75\163\x74\x20\160\162\157\x76\x69\144\145\x20\141\x74\x20\154\145\x61\x73\x74\x20\157\x6e\x65\40\x72\145\143\151\160\151\145\156\x74\40\145\x6d\x61\151\154\40\141\x64\144\162\x65\x73\163\56", "\162\x65\143\x69\x70\151\x65\156\164\163\137\146\x61\151\154\145\x64" => "\123\115\124\x50\x20\105\162\162\157\162\72\40\x54\150\x65\x20\146\x6f\x6c\x6c\x6f\x77\151\156\147\x20\162\145\x63\151\x70\151\145\156\x74\163\x20\x66\141\151\154\145\144\x3a\40", "\163\x69\x67\156\x69\156\147" => "\x53\151\x67\156\151\156\x67\x20\x45\x72\162\x6f\162\72\x20", "\163\155\x74\160\137\143\x6f\156\156\145\x63\164\x5f\x66\141\151\x6c\x65\144" => "\123\x4d\124\120\40\x63\157\x6e\156\145\x63\x74\x28\51\40\146\141\151\x6c\145\144\56", "\163\155\x74\x70\137\x65\x72\162\x6f\162" => "\x53\115\x54\x50\x20\x73\145\162\166\145\162\40\145\162\x72\157\x72\72\x20", "\166\x61\162\151\x61\142\x6c\x65\x5f\x73\145\164" => "\x43\x61\x6e\x6e\157\x74\x20\x73\145\x74\x20\x6f\162\x20\162\x65\163\x65\x74\40\x76\x61\x72\151\141\x62\154\145\x3a\x20", "\145\x78\x74\145\156\x73\x69\157\156\137\x6d\x69\163\x73\151\x6e\147" => "\105\170\164\x65\x6e\163\x69\157\x6e\40\x6d\x69\163\163\151\x6e\x67\x3a\40");
		if (empty($lang_path)) {
			$lang_path = dirname(__DIR__) . DIRECTORY_SEPARATOR . "\154\141\156\147\x75\141\147\145" . DIRECTORY_SEPARATOR;
		}
		if (!preg_match("\x2f\x5e\x5b\x61\55\x7a\x5d\173\62\175\50\x3f\x3a\137\133\141\55\x7a\x41\55\x5a\135\173\x32\x7d\51\x3f\x24\57", $langcode)) {
			$langcode = "\145\156";
		}
		$foundlang = true;
		$lang_file = $lang_path . "\160\150\x70\x6d\x61\151\154\x65\162\x2e\x6c\141\156\147\55" . $langcode . "\56\160\x68\160";
		if ("\145\x6e" !== $langcode) {
			if (!static::fileIsAccessible($lang_file)) {
				$foundlang = false;
			} else {
				$foundlang = (include $lang_file);
			}
		}
		$this->language = $PHPMAILER_LANG;
		return (bool) $foundlang;
	}
	public function getTranslations()
	{
		return $this->language;
	}
	public function addrAppend($type, $addr)
	{
		$addresses = array();
		foreach ($addr as $address) {
			$addresses[] = $this->addrFormat($address);
		}
		return $type . "\x3a\40" . implode("\54\40", $addresses) . static::$LE;
	}
	public function addrFormat($addr)
	{
		if (empty($addr[1])) {
			return $this->secureHeader($addr[0]);
		}
		return $this->encodeHeader($this->secureHeader($addr[1]), "\160\150\x72\141\163\x65") . "\40\x3c" . $this->secureHeader($addr[0]) . "\76";
	}
	public function wrapText($message, $length, $qp_mode = false)
	{
		if ($qp_mode) {
			$soft_break = sprintf("\40\x3d\x25\x73", static::$LE);
		} else {
			$soft_break = static::$LE;
		}
		$is_utf8 = static::CHARSET_UTF8 === strtolower($this->CharSet);
		$lelen = strlen(static::$LE);
		$crlflen = strlen(static::$LE);
		$message = static::normalizeBreaks($message);
		if (substr($message, -$lelen) === static::$LE) {
			$message = substr($message, 0, -$lelen);
		}
		$lines = explode(static::$LE, $message);
		$message = '';
		foreach ($lines as $line) {
			$words = explode("\x20", $line);
			$buf = '';
			$firstword = true;
			foreach ($words as $word) {
				if ($qp_mode && strlen($word) > $length) {
					$space_left = $length - strlen($buf) - $crlflen;
					if (!$firstword) {
						if ($space_left > 20) {
							$len = $space_left;
							if ($is_utf8) {
								$len = $this->utf8CharBoundary($word, $len);
							} elseif ("\x3d" === substr($word, $len - 1, 1)) {
								--$len;
							} elseif ("\x3d" === substr($word, $len - 2, 1)) {
								$len -= 2;
							}
							$part = substr($word, 0, $len);
							$word = substr($word, $len);
							$buf .= "\40" . $part;
							$message .= $buf . sprintf("\75\45\x73", static::$LE);
						} else {
							$message .= $buf . $soft_break;
						}
						$buf = '';
					}
					while ($word !== '') {
						if ($length <= 0) {
							break;
						}
						$len = $length;
						if ($is_utf8) {
							$len = $this->utf8CharBoundary($word, $len);
						} elseif ("\x3d" === substr($word, $len - 1, 1)) {
							--$len;
						} elseif ("\x3d" === substr($word, $len - 2, 1)) {
							$len -= 2;
						}
						$part = substr($word, 0, $len);
						$word = (string) substr($word, $len);
						if ($word !== '') {
							$message .= $part . sprintf("\75\x25\163", static::$LE);
						} else {
							$buf = $part;
						}
					}
				} else {
					$buf_o = $buf;
					if (!$firstword) {
						$buf .= "\40";
					}
					$buf .= $word;
					if ('' !== $buf_o && strlen($buf) > $length) {
						$message .= $buf_o . $soft_break;
						$buf = $word;
					}
				}
				$firstword = false;
			}
			$message .= $buf . static::$LE;
		}
		return $message;
	}
	public function utf8CharBoundary($encodedText, $maxLength)
	{
		$foundSplitPos = false;
		$lookBack = 3;
		while (!$foundSplitPos) {
			$lastChunk = substr($encodedText, $maxLength - $lookBack, $lookBack);
			$encodedCharPos = strpos($lastChunk, "\75");
			if (false !== $encodedCharPos) {
				$hex = substr($encodedText, $maxLength - $lookBack + $encodedCharPos + 1, 2);
				$dec = hexdec($hex);
				if ($dec < 128) {
					if ($encodedCharPos > 0) {
						$maxLength -= $lookBack - $encodedCharPos;
					}
					$foundSplitPos = true;
				} elseif ($dec >= 192) {
					$maxLength -= $lookBack - $encodedCharPos;
					$foundSplitPos = true;
				} elseif ($dec < 192) {
					$lookBack += 3;
				}
			} else {
				$foundSplitPos = true;
			}
		}
		return $maxLength;
	}
	public function setWordWrap()
	{
		if ($this->WordWrap < 1) {
			return;
		}
		switch ($this->message_type) {
			case "\x61\154\164":
			case "\141\x6c\x74\137\151\156\154\151\156\x65":
			case "\141\x6c\164\x5f\x61\164\x74\x61\x63\x68":
			case "\x61\154\164\137\x69\x6e\154\151\x6e\x65\137\141\x74\164\141\x63\150":
				$this->AltBody = $this->wrapText($this->AltBody, $this->WordWrap);
				break;
			default:
				$this->Body = $this->wrapText($this->Body, $this->WordWrap);
				break;
		}
	}
	public function createHeader()
	{
		$result = '';
		$result .= $this->headerLine("\x44\141\x74\145", '' === $this->MessageDate ? self::rfcDate() : $this->MessageDate);
		if ("\x6d\x61\x69\154" !== $this->Mailer) {
			if ($this->SingleTo) {
				foreach ($this->to as $toaddr) {
					$this->SingleToArray[] = $this->addrFormat($toaddr);
				}
			} elseif (count($this->to) > 0) {
				$result .= $this->addrAppend("\x54\157", $this->to);
			} elseif (count($this->cc) === 0) {
				$result .= $this->headerLine("\x54\x6f", "\x75\x6e\144\151\163\x63\x6c\x6f\x73\145\x64\55\x72\145\143\x69\x70\151\x65\156\164\163\x3a\x3b");
			}
		}
		$result .= $this->addrAppend("\x46\162\x6f\155", array(array(trim($this->From), $this->FromName)));
		if (count($this->cc) > 0) {
			$result .= $this->addrAppend("\x43\143", $this->cc);
		}
		if (("\163\145\156\144\x6d\x61\x69\x6c" === $this->Mailer || "\x71\x6d\141\x69\154" === $this->Mailer || "\x6d\x61\x69\x6c" === $this->Mailer) && count($this->bcc) > 0) {
			$result .= $this->addrAppend("\x42\x63\x63", $this->bcc);
		}
		if (count($this->ReplyTo) > 0) {
			$result .= $this->addrAppend("\122\145\x70\x6c\x79\55\124\x6f", $this->ReplyTo);
		}
		if ("\x6d\x61\151\x6c" !== $this->Mailer) {
			$result .= $this->headerLine("\x53\x75\x62\x6a\145\143\x74", $this->encodeHeader($this->secureHeader($this->Subject)));
		}
		if ('' !== $this->MessageID && preg_match("\x2f\x5e\x3c\x2e\52\x40\56\52\76\x24\x2f", $this->MessageID)) {
			$this->lastMessageID = $this->MessageID;
		} else {
			$this->lastMessageID = sprintf("\74\45\x73\100\45\x73\x3e", $this->uniqueid, $this->serverHostname());
		}
		$result .= $this->headerLine("\115\x65\163\x73\141\x67\x65\55\x49\104", $this->lastMessageID);
		if (null !== $this->Priority) {
			$result .= $this->headerLine("\130\x2d\x50\162\x69\x6f\162\151\164\x79", $this->Priority);
		}
		if ('' === $this->XMailer) {
			$result .= $this->headerLine("\x58\x2d\x4d\x61\151\154\145\162", "\120\x48\x50\115\141\151\154\145\x72\x20" . self::VERSION . "\40\50\150\x74\x74\x70\163\x3a\57\x2f\x67\x69\x74\x68\165\142\x2e\143\x6f\155\x2f\120\x48\x50\115\141\x69\x6c\x65\x72\57\120\110\x50\x4d\x61\151\x6c\145\162\51");
		} else {
			$myXmailer = trim($this->XMailer);
			if ($myXmailer) {
				$result .= $this->headerLine("\x58\x2d\115\141\x69\x6c\x65\162", $myXmailer);
			}
		}
		if ('' !== $this->ConfirmReadingTo) {
			$result .= $this->headerLine("\104\x69\x73\160\x6f\x73\x69\x74\151\157\x6e\x2d\116\x6f\164\x69\146\x69\x63\141\x74\x69\x6f\156\x2d\124\157", "\x3c" . $this->ConfirmReadingTo . "\x3e");
		}
		foreach ($this->CustomHeader as $header) {
			$result .= $this->headerLine(trim($header[0]), $this->encodeHeader(trim($header[1])));
		}
		if (!$this->sign_key_file) {
			$result .= $this->headerLine("\115\111\115\x45\55\x56\x65\162\x73\x69\157\156", "\x31\56\60");
			$result .= $this->getMailMIME();
		}
		return $result;
	}
	public function getMailMIME()
	{
		$result = '';
		$ismultipart = true;
		switch ($this->message_type) {
			case "\x69\156\154\151\x6e\x65":
				$result .= $this->headerLine("\103\157\156\164\145\x6e\164\x2d\124\x79\x70\x65", static::CONTENT_TYPE_MULTIPART_RELATED . "\73");
				$result .= $this->textLine("\x20\142\157\165\156\144\x61\162\x79\x3d\x22" . $this->boundary[1] . "\42");
				break;
			case "\141\x74\164\x61\x63\150":
			case "\x69\156\x6c\x69\x6e\145\x5f\x61\x74\x74\141\x63\150":
			case "\x61\x6c\164\x5f\141\x74\x74\x61\143\150":
			case "\x61\x6c\164\x5f\151\x6e\154\x69\156\145\137\x61\164\164\x61\x63\x68":
				$result .= $this->headerLine("\103\x6f\x6e\x74\145\x6e\x74\55\x54\171\160\145", static::CONTENT_TYPE_MULTIPART_MIXED . "\73");
				$result .= $this->textLine("\40\142\x6f\165\156\x64\x61\162\171\x3d\x22" . $this->boundary[1] . "\42");
				break;
			case "\141\154\164":
			case "\x61\x6c\x74\137\151\156\x6c\151\156\x65":
				$result .= $this->headerLine("\x43\x6f\156\x74\x65\156\x74\55\x54\x79\x70\145", static::CONTENT_TYPE_MULTIPART_ALTERNATIVE . "\73");
				$result .= $this->textLine("\40\x62\157\165\156\x64\141\x72\x79\75\x22" . $this->boundary[1] . "\x22");
				break;
			default:
				$result .= $this->textLine("\x43\x6f\x6e\x74\x65\156\164\55\124\x79\x70\x65\72\40" . $this->ContentType . "\73\40\x63\150\141\162\163\x65\x74\x3d" . $this->CharSet);
				$ismultipart = false;
				break;
		}
		if (static::ENCODING_7BIT !== $this->Encoding) {
			if ($ismultipart) {
				if (static::ENCODING_8BIT === $this->Encoding) {
					$result .= $this->headerLine("\x43\x6f\x6e\164\145\156\x74\x2d\124\x72\141\156\x73\x66\145\162\x2d\x45\156\143\x6f\144\x69\156\147", static::ENCODING_8BIT);
				}
			} else {
				$result .= $this->headerLine("\103\157\156\x74\145\156\164\x2d\x54\162\141\x6e\x73\x66\145\x72\55\x45\156\x63\157\144\151\156\147", $this->Encoding);
			}
		}
		if ("\x6d\x61\x69\154" !== $this->Mailer) {
		}
		return $result;
	}
	public function getSentMIMEMessage()
	{
		return static::stripTrailingWSP($this->MIMEHeader . $this->mailHeader) . static::$LE . static::$LE . $this->MIMEBody;
	}
	protected function generateId()
	{
		$len = 32;
		$bytes = '';
		if (function_exists("\x72\141\156\x64\157\155\x5f\x62\x79\164\x65\x73")) {
			try {
				$bytes = random_bytes($len);
			} catch (\Exception $e) {
			}
		} elseif (function_exists("\157\x70\x65\x6e\163\x73\x6c\x5f\x72\x61\x6e\x64\x6f\x6d\137\160\x73\x65\x75\144\157\x5f\x62\171\164\x65\163")) {
			$bytes = openssl_random_pseudo_bytes($len);
		}
		if ($bytes === '') {
			$bytes = hash("\163\150\x61\x32\x35\x36", uniqid((string) mt_rand(), true), true);
		}
		return str_replace(array("\75", "\x2b", "\57"), '', base64_encode(hash("\163\x68\x61\x32\x35\66", $bytes, true)));
	}
	public function createBody()
	{
		$body = '';
		$this->uniqueid = $this->generateId();
		$this->boundary[1] = "\142\x31\137" . $this->uniqueid;
		$this->boundary[2] = "\x62\62\x5f" . $this->uniqueid;
		$this->boundary[3] = "\x62\x33\x5f" . $this->uniqueid;
		if ($this->sign_key_file) {
			$body .= $this->getMailMIME() . static::$LE;
		}
		$this->setWordWrap();
		$bodyEncoding = $this->Encoding;
		$bodyCharSet = $this->CharSet;
		if (static::ENCODING_8BIT === $bodyEncoding && !$this->has8bitChars($this->Body)) {
			$bodyEncoding = static::ENCODING_7BIT;
			$bodyCharSet = static::CHARSET_ASCII;
		}
		if (static::ENCODING_BASE64 !== $this->Encoding && static::hasLineLongerThanMax($this->Body)) {
			$bodyEncoding = static::ENCODING_QUOTED_PRINTABLE;
		}
		$altBodyEncoding = $this->Encoding;
		$altBodyCharSet = $this->CharSet;
		if (static::ENCODING_8BIT === $altBodyEncoding && !$this->has8bitChars($this->AltBody)) {
			$altBodyEncoding = static::ENCODING_7BIT;
			$altBodyCharSet = static::CHARSET_ASCII;
		}
		if (static::ENCODING_BASE64 !== $altBodyEncoding && static::hasLineLongerThanMax($this->AltBody)) {
			$altBodyEncoding = static::ENCODING_QUOTED_PRINTABLE;
		}
		$mimepre = "\x54\x68\151\163\40\151\x73\40\141\40\x6d\165\154\164\x69\x2d\x70\141\162\164\40\x6d\x65\x73\163\x61\147\x65\x20\151\x6e\40\x4d\111\x4d\x45\40\x66\157\x72\155\141\164\x2e" . static::$LE . static::$LE;
		switch ($this->message_type) {
			case "\151\156\154\151\x6e\145":
				$body .= $mimepre;
				$body .= $this->getBoundary($this->boundary[1], $bodyCharSet, '', $bodyEncoding);
				$body .= $this->encodeString($this->Body, $bodyEncoding);
				$body .= static::$LE;
				$body .= $this->attachAll("\x69\x6e\x6c\151\x6e\145", $this->boundary[1]);
				break;
			case "\141\x74\164\141\x63\150":
				$body .= $mimepre;
				$body .= $this->getBoundary($this->boundary[1], $bodyCharSet, '', $bodyEncoding);
				$body .= $this->encodeString($this->Body, $bodyEncoding);
				$body .= static::$LE;
				$body .= $this->attachAll("\141\164\164\x61\x63\150\155\145\156\164", $this->boundary[1]);
				break;
			case "\151\156\x6c\151\156\145\137\x61\164\164\141\x63\x68":
				$body .= $mimepre;
				$body .= $this->textLine("\55\x2d" . $this->boundary[1]);
				$body .= $this->headerLine("\103\157\156\164\145\x6e\164\x2d\x54\x79\160\145", static::CONTENT_TYPE_MULTIPART_RELATED . "\73");
				$body .= $this->textLine("\40\x62\x6f\x75\x6e\144\141\162\x79\75\x22" . $this->boundary[2] . "\42\x3b");
				$body .= $this->textLine("\40\164\171\x70\x65\75\42" . static::CONTENT_TYPE_TEXT_HTML . "\x22");
				$body .= static::$LE;
				$body .= $this->getBoundary($this->boundary[2], $bodyCharSet, '', $bodyEncoding);
				$body .= $this->encodeString($this->Body, $bodyEncoding);
				$body .= static::$LE;
				$body .= $this->attachAll("\x69\x6e\154\151\x6e\145", $this->boundary[2]);
				$body .= static::$LE;
				$body .= $this->attachAll("\141\x74\164\141\x63\150\155\145\156\164", $this->boundary[1]);
				break;
			case "\x61\154\x74":
				$body .= $mimepre;
				$body .= $this->getBoundary($this->boundary[1], $altBodyCharSet, static::CONTENT_TYPE_PLAINTEXT, $altBodyEncoding);
				$body .= $this->encodeString($this->AltBody, $altBodyEncoding);
				$body .= static::$LE;
				$body .= $this->getBoundary($this->boundary[1], $bodyCharSet, static::CONTENT_TYPE_TEXT_HTML, $bodyEncoding);
				$body .= $this->encodeString($this->Body, $bodyEncoding);
				$body .= static::$LE;
				if (!empty($this->Ical)) {
					$method = static::ICAL_METHOD_REQUEST;
					foreach (static::$IcalMethods as $imethod) {
						if (stripos($this->Ical, "\x4d\105\x54\x48\117\104\x3a" . $imethod) !== false) {
							$method = $imethod;
							break;
						}
					}
					$body .= $this->getBoundary($this->boundary[1], '', static::CONTENT_TYPE_TEXT_CALENDAR . "\x3b\x20\155\145\164\150\157\144\x3d" . $method, '');
					$body .= $this->encodeString($this->Ical, $this->Encoding);
					$body .= static::$LE;
				}
				$body .= $this->endBoundary($this->boundary[1]);
				break;
			case "\x61\x6c\164\x5f\x69\156\x6c\x69\x6e\x65":
				$body .= $mimepre;
				$body .= $this->getBoundary($this->boundary[1], $altBodyCharSet, static::CONTENT_TYPE_PLAINTEXT, $altBodyEncoding);
				$body .= $this->encodeString($this->AltBody, $altBodyEncoding);
				$body .= static::$LE;
				$body .= $this->textLine("\x2d\x2d" . $this->boundary[1]);
				$body .= $this->headerLine("\103\157\x6e\164\x65\156\164\x2d\124\171\160\x65", static::CONTENT_TYPE_MULTIPART_RELATED . "\73");
				$body .= $this->textLine("\x20\142\x6f\x75\x6e\144\x61\x72\171\x3d\42" . $this->boundary[2] . "\42\73");
				$body .= $this->textLine("\40\x74\171\x70\x65\75\x22" . static::CONTENT_TYPE_TEXT_HTML . "\42");
				$body .= static::$LE;
				$body .= $this->getBoundary($this->boundary[2], $bodyCharSet, static::CONTENT_TYPE_TEXT_HTML, $bodyEncoding);
				$body .= $this->encodeString($this->Body, $bodyEncoding);
				$body .= static::$LE;
				$body .= $this->attachAll("\151\x6e\154\151\x6e\x65", $this->boundary[2]);
				$body .= static::$LE;
				$body .= $this->endBoundary($this->boundary[1]);
				break;
			case "\x61\154\164\137\x61\x74\x74\x61\x63\150":
				$body .= $mimepre;
				$body .= $this->textLine("\x2d\55" . $this->boundary[1]);
				$body .= $this->headerLine("\103\x6f\156\x74\x65\x6e\x74\x2d\x54\171\x70\145", static::CONTENT_TYPE_MULTIPART_ALTERNATIVE . "\x3b");
				$body .= $this->textLine("\x20\x62\157\x75\x6e\144\141\x72\171\x3d\x22" . $this->boundary[2] . "\42");
				$body .= static::$LE;
				$body .= $this->getBoundary($this->boundary[2], $altBodyCharSet, static::CONTENT_TYPE_PLAINTEXT, $altBodyEncoding);
				$body .= $this->encodeString($this->AltBody, $altBodyEncoding);
				$body .= static::$LE;
				$body .= $this->getBoundary($this->boundary[2], $bodyCharSet, static::CONTENT_TYPE_TEXT_HTML, $bodyEncoding);
				$body .= $this->encodeString($this->Body, $bodyEncoding);
				$body .= static::$LE;
				if (!empty($this->Ical)) {
					$method = static::ICAL_METHOD_REQUEST;
					foreach (static::$IcalMethods as $imethod) {
						if (stripos($this->Ical, "\115\105\x54\110\x4f\x44\x3a" . $imethod) !== false) {
							$method = $imethod;
							break;
						}
					}
					$body .= $this->getBoundary($this->boundary[2], '', static::CONTENT_TYPE_TEXT_CALENDAR . "\73\40\x6d\x65\x74\150\157\144\75" . $method, '');
					$body .= $this->encodeString($this->Ical, $this->Encoding);
				}
				$body .= $this->endBoundary($this->boundary[2]);
				$body .= static::$LE;
				$body .= $this->attachAll("\141\x74\164\141\x63\150\155\x65\x6e\x74", $this->boundary[1]);
				break;
			case "\x61\154\x74\x5f\151\x6e\154\151\x6e\145\137\141\164\164\x61\143\x68":
				$body .= $mimepre;
				$body .= $this->textLine("\x2d\x2d" . $this->boundary[1]);
				$body .= $this->headerLine("\x43\157\x6e\x74\145\x6e\x74\55\124\x79\x70\x65", static::CONTENT_TYPE_MULTIPART_ALTERNATIVE . "\x3b");
				$body .= $this->textLine("\x20\x62\x6f\165\156\x64\x61\162\x79\x3d\x22" . $this->boundary[2] . "\x22");
				$body .= static::$LE;
				$body .= $this->getBoundary($this->boundary[2], $altBodyCharSet, static::CONTENT_TYPE_PLAINTEXT, $altBodyEncoding);
				$body .= $this->encodeString($this->AltBody, $altBodyEncoding);
				$body .= static::$LE;
				$body .= $this->textLine("\55\x2d" . $this->boundary[2]);
				$body .= $this->headerLine("\103\x6f\156\164\x65\x6e\164\x2d\x54\171\160\145", static::CONTENT_TYPE_MULTIPART_RELATED . "\73");
				$body .= $this->textLine("\40\x62\157\165\156\x64\141\x72\x79\x3d\42" . $this->boundary[3] . "\x22\x3b");
				$body .= $this->textLine("\x20\x74\x79\x70\145\x3d\x22" . static::CONTENT_TYPE_TEXT_HTML . "\x22");
				$body .= static::$LE;
				$body .= $this->getBoundary($this->boundary[3], $bodyCharSet, static::CONTENT_TYPE_TEXT_HTML, $bodyEncoding);
				$body .= $this->encodeString($this->Body, $bodyEncoding);
				$body .= static::$LE;
				$body .= $this->attachAll("\151\x6e\x6c\151\x6e\145", $this->boundary[3]);
				$body .= static::$LE;
				$body .= $this->endBoundary($this->boundary[2]);
				$body .= static::$LE;
				$body .= $this->attachAll("\x61\x74\x74\141\143\150\155\x65\156\164", $this->boundary[1]);
				break;
			default:
				$this->Encoding = $bodyEncoding;
				$body .= $this->encodeString($this->Body, $this->Encoding);
				break;
		}
		if ($this->isError()) {
			$body = '';
			if ($this->exceptions) {
				throw new Exception($this->lang("\x65\155\160\164\x79\137\155\x65\x73\x73\141\147\x65"), self::STOP_CRITICAL);
			}
		} elseif ($this->sign_key_file) {
			try {
				if (!defined("\x50\x4b\x43\x53\67\137\124\105\130\124")) {
					throw new Exception($this->lang("\145\x78\x74\145\156\163\151\157\156\x5f\155\x69\x73\163\151\156\x67") . "\157\160\145\156\x73\x73\154");
				}
				$file = tempnam(sys_get_temp_dir(), "\163\x72\143\163\151\147\x6e");
				$signed = tempnam(sys_get_temp_dir(), "\x6d\x61\x69\154\163\151\147\156");
				file_put_contents($file, $body);
				if (empty($this->sign_extracerts_file)) {
					$sign = @openssl_pkcs7_sign($file, $signed, "\146\x69\x6c\145\x3a\x2f\x2f" . realpath($this->sign_cert_file), array("\146\x69\x6c\145\x3a\x2f\x2f" . realpath($this->sign_key_file), $this->sign_key_pass), array());
				} else {
					$sign = @openssl_pkcs7_sign($file, $signed, "\x66\x69\154\x65\72\x2f\x2f" . realpath($this->sign_cert_file), array("\x66\151\x6c\145\x3a\x2f\x2f" . realpath($this->sign_key_file), $this->sign_key_pass), array(), PKCS7_DETACHED, $this->sign_extracerts_file);
				}
				@unlink($file);
				if ($sign) {
					$body = file_get_contents($signed);
					@unlink($signed);
					$parts = explode("\xa\12", $body, 2);
					$this->MIMEHeader .= $parts[0] . static::$LE . static::$LE;
					$body = $parts[1];
				} else {
					@unlink($signed);
					throw new Exception($this->lang("\x73\151\x67\x6e\x69\x6e\x67") . openssl_error_string());
				}
			} catch (Exception $exc) {
				$body = '';
				if ($this->exceptions) {
					throw $exc;
				}
			}
		}
		return $body;
	}
	protected function getBoundary($boundary, $charSet, $contentType, $encoding)
	{
		$result = '';
		if ('' === $charSet) {
			$charSet = $this->CharSet;
		}
		if ('' === $contentType) {
			$contentType = $this->ContentType;
		}
		if ('' === $encoding) {
			$encoding = $this->Encoding;
		}
		$result .= $this->textLine("\x2d\55" . $boundary);
		$result .= sprintf("\x43\157\156\x74\145\156\x74\x2d\124\x79\160\145\x3a\40\x25\163\73\40\x63\x68\x61\162\163\x65\x74\x3d\x25\163", $contentType, $charSet);
		$result .= static::$LE;
		if (static::ENCODING_7BIT !== $encoding) {
			$result .= $this->headerLine("\x43\157\156\164\145\x6e\x74\x2d\124\162\141\156\163\146\x65\162\55\105\156\143\x6f\144\151\x6e\147", $encoding);
		}
		$result .= static::$LE;
		return $result;
	}
	protected function endBoundary($boundary)
	{
		return static::$LE . "\x2d\x2d" . $boundary . "\55\x2d" . static::$LE;
	}
	protected function setMessageType()
	{
		$type = array();
		if ($this->alternativeExists()) {
			$type[] = "\x61\154\x74";
		}
		if ($this->inlineImageExists()) {
			$type[] = "\x69\156\154\x69\156\145";
		}
		if ($this->attachmentExists()) {
			$type[] = "\x61\x74\164\x61\x63\150";
		}
		$this->message_type = implode("\x5f", $type);
		if ('' === $this->message_type) {
			$this->message_type = "\x70\x6c\141\x69\x6e";
		}
	}
	public function headerLine($name, $value)
	{
		return $name . "\72\40" . $value . static::$LE;
	}
	public function textLine($value)
	{
		return $value . static::$LE;
	}
	public function addAttachment($path, $name = '', $encoding = self::ENCODING_BASE64, $type = '', $disposition = "\x61\x74\164\x61\143\x68\x6d\x65\156\164")
	{
		try {
			if (!static::fileIsAccessible($path)) {
				throw new Exception($this->lang("\x66\x69\x6c\145\x5f\141\x63\x63\145\163\163") . $path, self::STOP_CONTINUE);
			}
			if ('' === $type) {
				$type = static::filenameToType($path);
			}
			$filename = (string) static::mb_pathinfo($path, PATHINFO_BASENAME);
			if ('' === $name) {
				$name = $filename;
			}
			if (!$this->validateEncoding($encoding)) {
				throw new Exception($this->lang("\145\x6e\143\x6f\x64\151\156\147") . $encoding);
			}
			$this->attachment[] = array(0 => $path, 1 => $filename, 2 => $name, 3 => $encoding, 4 => $type, 5 => false, 6 => $disposition, 7 => $name);
		} catch (Exception $exc) {
			$this->setError($exc->getMessage());
			$this->edebug($exc->getMessage());
			if ($this->exceptions) {
				throw $exc;
			}
			return false;
		}
		return true;
	}
	public function getAttachments()
	{
		return $this->attachment;
	}
	protected function attachAll($disposition_type, $boundary)
	{
		$mime = array();
		$cidUniq = array();
		$incl = array();
		foreach ($this->attachment as $attachment) {
			if ($attachment[6] === $disposition_type) {
				$string = '';
				$path = '';
				$bString = $attachment[5];
				if ($bString) {
					$string = $attachment[0];
				} else {
					$path = $attachment[0];
				}
				$inclhash = hash("\163\x68\141\x32\65\x36", serialize($attachment));
				if (in_array($inclhash, $incl, true)) {
					continue;
				}
				$incl[] = $inclhash;
				$name = $attachment[2];
				$encoding = $attachment[3];
				$type = $attachment[4];
				$disposition = $attachment[6];
				$cid = $attachment[7];
				if ("\151\156\x6c\x69\x6e\x65" === $disposition && array_key_exists($cid, $cidUniq)) {
					continue;
				}
				$cidUniq[$cid] = true;
				$mime[] = sprintf("\x2d\x2d\x25\x73\45\x73", $boundary, static::$LE);
				if (!empty($name)) {
					$mime[] = sprintf("\x43\157\x6e\x74\x65\x6e\x74\55\124\171\160\145\x3a\40\x25\163\x3b\40\156\141\155\145\75\45\x73\45\x73", $type, static::quotedString($this->encodeHeader($this->secureHeader($name))), static::$LE);
				} else {
					$mime[] = sprintf("\x43\x6f\156\x74\x65\x6e\x74\x2d\x54\x79\x70\x65\72\x20\45\163\45\163", $type, static::$LE);
				}
				if (static::ENCODING_7BIT !== $encoding) {
					$mime[] = sprintf("\103\157\156\164\x65\156\164\x2d\124\x72\141\156\x73\146\x65\162\x2d\x45\156\143\157\x64\151\156\x67\x3a\40\x25\163\x25\163", $encoding, static::$LE);
				}
				if ((string) $cid !== '' && $disposition === "\x69\x6e\x6c\x69\156\x65") {
					$mime[] = "\x43\x6f\x6e\164\x65\156\x74\x2d\111\x44\x3a\x20\74" . $this->encodeHeader($this->secureHeader($cid)) . "\76" . static::$LE;
				}
				if (!empty($disposition)) {
					$encoded_name = $this->encodeHeader($this->secureHeader($name));
					if (!empty($encoded_name)) {
						$mime[] = sprintf("\x43\157\156\164\x65\x6e\164\55\104\151\163\x70\157\163\x69\x74\x69\x6f\x6e\72\40\45\x73\x3b\40\146\151\154\145\x6e\141\x6d\145\x3d\x25\163\45\163", $disposition, static::quotedString($encoded_name), static::$LE . static::$LE);
					} else {
						$mime[] = sprintf("\103\x6f\x6e\164\x65\x6e\164\55\104\x69\x73\160\x6f\163\151\x74\x69\x6f\156\x3a\x20\x25\163\45\x73", $disposition, static::$LE . static::$LE);
					}
				} else {
					$mime[] = static::$LE;
				}
				if ($bString) {
					$mime[] = $this->encodeString($string, $encoding);
				} else {
					$mime[] = $this->encodeFile($path, $encoding);
				}
				if ($this->isError()) {
					return '';
				}
				$mime[] = static::$LE;
			}
		}
		$mime[] = sprintf("\55\55\45\x73\x2d\55\45\163", $boundary, static::$LE);
		return implode('', $mime);
	}
	protected function encodeFile($path, $encoding = self::ENCODING_BASE64)
	{
		try {
			if (!static::fileIsAccessible($path)) {
				throw new Exception($this->lang("\146\x69\154\x65\137\157\160\145\x6e") . $path, self::STOP_CONTINUE);
			}
			$file_buffer = file_get_contents($path);
			if (false === $file_buffer) {
				throw new Exception($this->lang("\x66\151\x6c\145\x5f\157\160\x65\156") . $path, self::STOP_CONTINUE);
			}
			$file_buffer = $this->encodeString($file_buffer, $encoding);
			return $file_buffer;
		} catch (Exception $exc) {
			$this->setError($exc->getMessage());
			$this->edebug($exc->getMessage());
			if ($this->exceptions) {
				throw $exc;
			}
			return '';
		}
	}
	public function encodeString($str, $encoding = self::ENCODING_BASE64)
	{
		$encoded = '';
		switch (strtolower($encoding)) {
			case static::ENCODING_BASE64:
				$encoded = chunk_split(base64_encode($str), static::STD_LINE_LENGTH, static::$LE);
				break;
			case static::ENCODING_7BIT:
			case static::ENCODING_8BIT:
				$encoded = static::normalizeBreaks($str);
				if (substr($encoded, -strlen(static::$LE)) !== static::$LE) {
					$encoded .= static::$LE;
				}
				break;
			case static::ENCODING_BINARY:
				$encoded = $str;
				break;
			case static::ENCODING_QUOTED_PRINTABLE:
				$encoded = $this->encodeQP($str);
				break;
			default:
				$this->setError($this->lang("\145\156\143\157\144\151\x6e\x67") . $encoding);
				if ($this->exceptions) {
					throw new Exception($this->lang("\x65\156\x63\x6f\x64\x69\156\147") . $encoding);
				}
				break;
		}
		return $encoded;
	}
	public function encodeHeader($str, $position = "\x74\x65\x78\x74")
	{
		$matchcount = 0;
		switch (strtolower($position)) {
			case "\160\150\x72\x61\x73\x65":
				if (!preg_match("\x2f\133\134\62\x30\x30\x2d\x5c\x33\67\x37\x5d\57", $str)) {
					$encoded = addcslashes($str, "\x0\56\x2e\x1f\x7f\134\x22");
					if ($str === $encoded && !preg_match("\57\x5b\136\101\55\x5a\x61\x2d\x7a\60\x2d\71\x21\x23\x24\x25\x26\47\52\x2b\134\x2f\x3d\x3f\x5e\x5f\x60\173\x7c\x7d\x7e\x20\55\135\57", $str)) {
						return $encoded;
					}
					return "\x22{$encoded}\x22";
				}
				$matchcount = preg_match_all("\57\133\136\x5c\x30\64\x30\x5c\60\64\x31\134\60\x34\63\x2d\x5c\x31\63\63\134\x31\x33\x35\x2d\x5c\61\67\x36\135\57", $str, $matches);
				break;
			case "\x63\x6f\x6d\155\145\156\164":
				$matchcount = preg_match_all("\57\133\50\51\x22\x5d\x2f", $str, $matches);
			case "\x74\145\x78\164":
			default:
				$matchcount += preg_match_all("\x2f\x5b\x5c\60\60\60\x2d\x5c\x30\61\60\x5c\60\61\63\x5c\x30\61\64\134\60\x31\x36\x2d\x5c\x30\63\x37\x5c\61\x37\67\55\134\63\x37\x37\x5d\x2f", $str, $matches);
				break;
		}
		if ($this->has8bitChars($str)) {
			$charset = $this->CharSet;
		} else {
			$charset = static::CHARSET_ASCII;
		}
		$overhead = 8 + strlen($charset);
		if ("\x6d\x61\x69\154" === $this->Mailer) {
			$maxlen = static::MAIL_MAX_LINE_LENGTH - $overhead;
		} else {
			$maxlen = static::MAX_LINE_LENGTH - $overhead;
		}
		if ($matchcount > strlen($str) / 3) {
			$encoding = "\x42";
		} elseif ($matchcount > 0) {
			$encoding = "\x51";
		} elseif (strlen($str) > $maxlen) {
			$encoding = "\121";
		} else {
			$encoding = false;
		}
		switch ($encoding) {
			case "\x42":
				if ($this->hasMultiBytes($str)) {
					$encoded = $this->base64EncodeWrapMB($str, "\12");
				} else {
					$encoded = base64_encode($str);
					$maxlen -= $maxlen % 4;
					$encoded = trim(chunk_split($encoded, $maxlen, "\xa"));
				}
				$encoded = preg_replace("\57\136\50\x2e\52\x29\x24\57\155", "\40\75\x3f" . $charset . "\77{$encoding}\x3f\x5c\x31\x3f\x3d", $encoded);
				break;
			case "\x51":
				$encoded = $this->encodeQ($str, $position);
				$encoded = $this->wrapText($encoded, $maxlen, true);
				$encoded = str_replace("\75" . static::$LE, "\12", trim($encoded));
				$encoded = preg_replace("\x2f\x5e\x28\56\x2a\x29\44\x2f\155", "\40\x3d\x3f" . $charset . "\77{$encoding}\77\x5c\x31\77\75", $encoded);
				break;
			default:
				return $str;
		}
		return trim(static::normalizeBreaks($encoded));
	}
	public function hasMultiBytes($str)
	{
		if (function_exists("\x6d\x62\x5f\163\x74\x72\x6c\x65\156")) {
			return strlen($str) > mb_strlen($str, $this->CharSet);
		}
		return false;
	}
	public function has8bitChars($text)
	{
		return (bool) preg_match("\x2f\x5b\134\x78\x38\60\55\x5c\170\x46\x46\135\x2f", $text);
	}
	public function base64EncodeWrapMB($str, $linebreak = null)
	{
		$start = "\x3d\x3f" . $this->CharSet . "\77\102\77";
		$end = "\x3f\75";
		$encoded = '';
		if (null === $linebreak) {
			$linebreak = static::$LE;
		}
		$mb_length = mb_strlen($str, $this->CharSet);
		$length = 75 - strlen($start) - strlen($end);
		$ratio = $mb_length / strlen($str);
		$avgLength = floor($length * $ratio * 0.75);
		$offset = 0;
		for ($i = 0; $i < $mb_length; $i += $offset) {
			$lookBack = 0;
			do {
				$offset = $avgLength - $lookBack;
				$chunk = mb_substr($str, $i, $offset, $this->CharSet);
				$chunk = base64_encode($chunk);
				++$lookBack;
			} while (strlen($chunk) > $length);
			$encoded .= $chunk . $linebreak;
		}
		return substr($encoded, 0, -strlen($linebreak));
	}
	public function encodeQP($string)
	{
		return static::normalizeBreaks(quoted_printable_encode($string));
	}
	public function encodeQ($str, $position = "\x74\145\x78\x74")
	{
		$pattern = '';
		$encoded = str_replace(array("\xd", "\12"), '', $str);
		switch (strtolower($position)) {
			case "\x70\x68\162\x61\163\145":
				$pattern = "\x5e\101\x2d\132\141\x2d\172\60\55\x39\41\52\53\x5c\x2f\x20\55";
				break;
			case "\143\x6f\155\x6d\145\156\164":
				$pattern = "\134\x28\134\51\x22";
			case "\164\x65\x78\x74":
			default:
				$pattern = "\134\x30\60\60\x2d\x5c\60\x31\x31\x5c\x30\x31\63\x5c\x30\61\x34\x5c\x30\x31\x36\x2d\134\x30\x33\67\134\x30\x37\65\134\60\67\67\134\61\63\x37\x5c\61\x37\x37\x2d\134\x33\67\x37" . $pattern;
				break;
		}
		$matches = array();
		if (preg_match_all("\x2f\x5b{$pattern}\x5d\x2f", $encoded, $matches)) {
			$eqkey = array_search("\75", $matches[0], true);
			if (false !== $eqkey) {
				unset($matches[0][$eqkey]);
				array_unshift($matches[0], "\x3d");
			}
			foreach (array_unique($matches[0]) as $char) {
				$encoded = str_replace($char, "\x3d" . sprintf("\45\x30\x32\x58", ord($char)), $encoded);
			}
		}
		return str_replace("\40", "\137", $encoded);
	}
	public function addStringAttachment($string, $filename, $encoding = self::ENCODING_BASE64, $type = '', $disposition = "\141\x74\x74\141\x63\150\x6d\x65\156\164")
	{
		try {
			if ('' === $type) {
				$type = static::filenameToType($filename);
			}
			if (!$this->validateEncoding($encoding)) {
				throw new Exception($this->lang("\x65\156\143\157\x64\151\156\x67") . $encoding);
			}
			$this->attachment[] = array(0 => $string, 1 => $filename, 2 => static::mb_pathinfo($filename, PATHINFO_BASENAME), 3 => $encoding, 4 => $type, 5 => true, 6 => $disposition, 7 => 0);
		} catch (Exception $exc) {
			$this->setError($exc->getMessage());
			$this->edebug($exc->getMessage());
			if ($this->exceptions) {
				throw $exc;
			}
			return false;
		}
		return true;
	}
	public function addEmbeddedImage($path, $cid, $name = '', $encoding = self::ENCODING_BASE64, $type = '', $disposition = "\151\156\154\x69\156\145")
	{
		try {
			if (!static::fileIsAccessible($path)) {
				throw new Exception($this->lang("\x66\151\x6c\x65\137\x61\x63\143\x65\163\163") . $path, self::STOP_CONTINUE);
			}
			if ('' === $type) {
				$type = static::filenameToType($path);
			}
			if (!$this->validateEncoding($encoding)) {
				throw new Exception($this->lang("\145\156\x63\157\144\x69\156\x67") . $encoding);
			}
			$filename = (string) static::mb_pathinfo($path, PATHINFO_BASENAME);
			if ('' === $name) {
				$name = $filename;
			}
			$this->attachment[] = array(0 => $path, 1 => $filename, 2 => $name, 3 => $encoding, 4 => $type, 5 => false, 6 => $disposition, 7 => $cid);
		} catch (Exception $exc) {
			$this->setError($exc->getMessage());
			$this->edebug($exc->getMessage());
			if ($this->exceptions) {
				throw $exc;
			}
			return false;
		}
		return true;
	}
	public function addStringEmbeddedImage($string, $cid, $name = '', $encoding = self::ENCODING_BASE64, $type = '', $disposition = "\x69\x6e\154\x69\x6e\x65")
	{
		try {
			if ('' === $type && !empty($name)) {
				$type = static::filenameToType($name);
			}
			if (!$this->validateEncoding($encoding)) {
				throw new Exception($this->lang("\x65\156\143\157\144\151\x6e\x67") . $encoding);
			}
			$this->attachment[] = array(0 => $string, 1 => $name, 2 => $name, 3 => $encoding, 4 => $type, 5 => true, 6 => $disposition, 7 => $cid);
		} catch (Exception $exc) {
			$this->setError($exc->getMessage());
			$this->edebug($exc->getMessage());
			if ($this->exceptions) {
				throw $exc;
			}
			return false;
		}
		return true;
	}
	protected function validateEncoding($encoding)
	{
		return in_array($encoding, array(self::ENCODING_7BIT, self::ENCODING_QUOTED_PRINTABLE, self::ENCODING_BASE64, self::ENCODING_8BIT, self::ENCODING_BINARY), true);
	}
	protected function cidExists($cid)
	{
		foreach ($this->attachment as $attachment) {
			if ("\x69\x6e\x6c\x69\x6e\145" === $attachment[6] && $cid === $attachment[7]) {
				return true;
			}
		}
		return false;
	}
	public function inlineImageExists()
	{
		foreach ($this->attachment as $attachment) {
			if ("\x69\156\x6c\x69\x6e\x65" === $attachment[6]) {
				return true;
			}
		}
		return false;
	}
	public function attachmentExists()
	{
		foreach ($this->attachment as $attachment) {
			if ("\x61\x74\164\141\143\x68\155\x65\156\164" === $attachment[6]) {
				return true;
			}
		}
		return false;
	}
	public function alternativeExists()
	{
		return !empty($this->AltBody);
	}
	public function clearQueuedAddresses($kind)
	{
		$this->RecipientsQueue = array_filter($this->RecipientsQueue, static function ($params) use ($kind) {
			return $params[0] !== $kind;
		});
	}
	public function clearAddresses()
	{
		foreach ($this->to as $to) {
			unset($this->all_recipients[strtolower($to[0])]);
		}
		$this->to = array();
		$this->clearQueuedAddresses("\x74\157");
	}
	public function clearCCs()
	{
		foreach ($this->cc as $cc) {
			unset($this->all_recipients[strtolower($cc[0])]);
		}
		$this->cc = array();
		$this->clearQueuedAddresses("\143\x63");
	}
	public function clearBCCs()
	{
		foreach ($this->bcc as $bcc) {
			unset($this->all_recipients[strtolower($bcc[0])]);
		}
		$this->bcc = array();
		$this->clearQueuedAddresses("\x62\143\x63");
	}
	public function clearReplyTos()
	{
		$this->ReplyTo = array();
		$this->ReplyToQueue = array();
	}
	public function clearAllRecipients()
	{
		$this->to = array();
		$this->cc = array();
		$this->bcc = array();
		$this->all_recipients = array();
		$this->RecipientsQueue = array();
	}
	public function clearAttachments()
	{
		$this->attachment = array();
	}
	public function clearCustomHeaders()
	{
		$this->CustomHeader = array();
	}
	protected function setError($msg)
	{
		++$this->error_count;
		if ("\163\x6d\x74\x70" === $this->Mailer && null !== $this->smtp) {
			$lasterror = $this->smtp->getError();
			if (!empty($lasterror["\145\x72\x72\x6f\162"])) {
				$msg .= $this->lang("\163\155\x74\160\137\x65\x72\162\x6f\162") . $lasterror["\x65\x72\x72\x6f\x72"];
				if (!empty($lasterror["\144\x65\164\x61\x69\154"])) {
					$msg .= "\40\x44\x65\x74\x61\x69\154\72\x20" . $lasterror["\144\145\x74\141\x69\154"];
				}
				if (!empty($lasterror["\x73\x6d\x74\160\137\x63\157\144\145"])) {
					$msg .= "\40\123\115\x54\x50\x20\x63\157\x64\145\x3a\x20" . $lasterror["\163\155\x74\160\x5f\x63\157\144\x65"];
				}
				if (!empty($lasterror["\x73\155\x74\x70\137\x63\157\x64\x65\x5f\x65\170"])) {
					$msg .= "\40\x41\144\x64\151\164\151\157\x6e\x61\154\40\x53\x4d\x54\x50\x20\151\x6e\146\157\72\40" . $lasterror["\163\155\x74\x70\137\x63\157\x64\145\137\145\x78"];
				}
			}
		}
		$this->ErrorInfo = $msg;
	}
	public static function rfcDate()
	{
		date_default_timezone_set(@date_default_timezone_get());
		return date("\x44\54\40\152\x20\x4d\40\x59\x20\110\72\x69\72\x73\40\117");
	}
	protected function serverHostname()
	{
		$result = '';
		if (!empty($this->Hostname)) {
			$result = $this->Hostname;
		} elseif (isset($_SERVER) && array_key_exists("\x53\x45\122\x56\x45\x52\x5f\116\x41\x4d\x45", $_SERVER)) {
			$result = $_SERVER["\x53\105\x52\x56\105\x52\137\116\x41\x4d\105"];
		} elseif (function_exists("\x67\145\x74\x68\x6f\x73\x74\156\141\x6d\145") && gethostname() !== false) {
			$result = gethostname();
		} elseif (php_uname("\x6e") !== false) {
			$result = php_uname("\x6e");
		}
		if (!static::isValidHost($result)) {
			return "\154\x6f\143\141\154\150\x6f\163\x74\56\154\157\143\x61\x6c\x64\x6f\x6d\x61\151\x6e";
		}
		return $result;
	}
	public static function isValidHost($host)
	{
		if (empty($host) || !is_string($host) || strlen($host) > 256 || !preg_match("\57\x5e\x28\x5b\141\55\172\101\55\x5a\134\144\56\55\135\52\x7c\x5c\133\133\x61\55\146\101\55\106\134\x64\x3a\135\x2b\135\x29\x24\57", $host)) {
			return false;
		}
		if (strlen($host) > 2 && substr($host, 0, 1) === "\x5b" && substr($host, -1, 1) === "\135") {
			return filter_var(substr($host, 1, -1), FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false;
		}
		if (is_numeric(str_replace("\x2e", '', $host))) {
			return filter_var($host, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false;
		}
		if (filter_var("\150\164\x74\160\72\57\x2f" . $host, FILTER_VALIDATE_URL) !== false) {
			return true;
		}
		return false;
	}
	protected function lang($key)
	{
		if (count($this->language) < 1) {
			$this->setLanguage();
		}
		if (array_key_exists($key, $this->language)) {
			if ("\163\155\x74\160\137\x63\x6f\x6e\x6e\145\x63\x74\x5f\x66\x61\151\x6c\x65\144" === $key) {
				return $this->language[$key] . "\40\x68\164\x74\160\163\72\x2f\57\147\151\x74\150\165\142\x2e\143\157\155\57\x50\110\x50\x4d\141\x69\x6c\x65\162\57\120\110\x50\x4d\141\x69\154\145\162\57\x77\x69\x6b\151\x2f\124\x72\x6f\165\142\154\145\x73\150\x6f\157\164\x69\x6e\147";
			}
			return $this->language[$key];
		}
		return $key;
	}
	public function isError()
	{
		return $this->error_count > 0;
	}
	public function addCustomHeader($name, $value = null)
	{
		if (null === $value && strpos($name, "\x3a") !== false) {
			list($name, $value) = explode("\72", $name, 2);
		}
		$name = trim($name);
		$value = trim($value);
		if (empty($name) || strpbrk($name . $value, "\15\xa") !== false) {
			if ($this->exceptions) {
				throw new Exception("\x49\156\x76\141\154\x69\x64\40\150\x65\141\x64\145\x72\x20\156\141\x6d\145\x20\157\x72\40\x76\x61\x6c\165\x65");
			}
			return false;
		}
		$this->CustomHeader[] = array($name, $value);
		return true;
	}
	public function getCustomHeaders()
	{
		return $this->CustomHeader;
	}
	public function msgHTML($message, $basedir = '', $advanced = false)
	{
		preg_match_all("\x2f\50\77\x3c\x21\55\x29\x28\163\162\x63\x7c\142\141\x63\153\x67\162\157\x75\156\144\51\x3d\x5b\x22\x27\135\x28\56\52\51\133\42\x27\x5d\x2f\x55\151", $message, $images);
		if (array_key_exists(2, $images)) {
			if (strlen($basedir) > 1 && "\x2f" !== substr($basedir, -1)) {
				$basedir .= "\57";
			}
			foreach ($images[2] as $imgindex => $url) {
				$match = array();
				if (preg_match("\43\x5e\x64\x61\x74\x61\72\x28\151\155\141\x67\145\57\x28\77\72\x6a\160\145\x3f\x67\174\147\x69\x66\x7c\x70\x6e\x67\x29\x29\x3b\77\50\x62\141\163\x65\66\x34\51\x3f\x2c\x28\x2e\53\x29\43", $url, $match)) {
					if (count($match) === 4 && static::ENCODING_BASE64 === $match[2]) {
						$data = base64_decode($match[3]);
					} elseif ('' === $match[2]) {
						$data = rawurldecode($match[3]);
					} else {
						continue;
					}
					$cid = substr(hash("\163\x68\141\62\65\66", $data), 0, 32) . "\x40\160\150\x70\155\141\x69\x6c\x65\162\x2e\x30";
					if (!$this->cidExists($cid)) {
						$this->addStringEmbeddedImage($data, $cid, "\145\155\x62\x65\x64" . $imgindex, static::ENCODING_BASE64, $match[1]);
					}
					$message = str_replace($images[0][$imgindex], $images[1][$imgindex] . "\75\42\x63\151\x64\72" . $cid . "\x22", $message);
					continue;
				}
				if (!empty($basedir) && strpos($url, "\x2e\x2e") === false && 0 !== strpos($url, "\143\151\x64\x3a") && !preg_match("\43\136\x5b\141\x2d\x7a\135\133\x61\x2d\172\x30\55\x39\53\x2e\x2d\x5d\x2a\72\x3f\x2f\57\x23\x69", $url)) {
					$filename = static::mb_pathinfo($url, PATHINFO_BASENAME);
					$directory = dirname($url);
					if ("\56" === $directory) {
						$directory = '';
					}
					$cid = substr(hash("\163\x68\x61\x32\x35\66", $url), 0, 32) . "\100\160\150\160\x6d\x61\x69\x6c\145\x72\x2e\x30";
					if (strlen($basedir) > 1 && "\x2f" !== substr($basedir, -1)) {
						$basedir .= "\57";
					}
					if (strlen($directory) > 1 && "\57" !== substr($directory, -1)) {
						$directory .= "\57";
					}
					if ($this->addEmbeddedImage($basedir . $directory . $filename, $cid, $filename, static::ENCODING_BASE64, static::_mime_types((string) static::mb_pathinfo($filename, PATHINFO_EXTENSION)))) {
						$message = preg_replace("\x2f" . $images[1][$imgindex] . "\75\133\x22\47\135" . preg_quote($url, "\x2f") . "\133\x22\47\135\x2f\x55\x69", $images[1][$imgindex] . "\x3d\x22\x63\151\144\72" . $cid . "\x22", $message);
					}
				}
			}
		}
		$this->isHTML();
		$this->Body = static::normalizeBreaks($message);
		$this->AltBody = static::normalizeBreaks($this->html2text($message, $advanced));
		if (!$this->alternativeExists()) {
			$this->AltBody = "\x54\x68\151\x73\x20\151\163\x20\141\x6e\40\x48\124\115\x4c\x2d\x6f\x6e\154\171\x20\155\x65\x73\x73\x61\x67\145\56\40\124\x6f\40\166\151\145\167\40\x69\x74\x2c\x20\x61\x63\164\x69\x76\141\164\x65\40\110\124\x4d\x4c\x20\x69\x6e\x20\x79\157\165\162\40\145\155\x61\151\154\x20\x61\x70\160\154\x69\x63\141\164\x69\x6f\x6e\56" . static::$LE;
		}
		return $this->Body;
	}
	public function html2text($html, $advanced = false)
	{
		if (is_callable($advanced)) {
			return call_user_func($advanced, $html);
		}
		return html_entity_decode(trim(strip_tags(preg_replace("\x2f\74\50\x68\145\141\144\x7c\164\151\x74\154\145\174\163\x74\171\x6c\145\x7c\163\143\162\x69\160\x74\x29\x5b\x5e\x3e\x5d\52\76\56\52\x3f\74\x5c\57\x5c\x31\x3e\x2f\x73\x69", '', $html))), ENT_QUOTES, $this->CharSet);
	}
	public static function _mime_types($ext = '')
	{
		$mimes = array("\x78\154" => "\x61\x70\160\154\151\x63\141\164\151\x6f\x6e\57\x65\x78\x63\145\154", "\152\x73" => "\x61\160\160\x6c\151\143\141\x74\151\x6f\156\x2f\x6a\x61\166\141\163\x63\162\x69\x70\x74", "\x68\161\170" => "\141\160\x70\x6c\x69\143\141\x74\x69\x6f\156\x2f\155\x61\143\55\x62\x69\x6e\x68\x65\x78\64\60", "\143\160\164" => "\x61\x70\160\x6c\151\143\141\x74\151\x6f\x6e\x2f\155\141\143\55\x63\157\x6d\x70\x61\x63\164\x70\162\x6f", "\142\151\x6e" => "\x61\x70\x70\154\151\x63\x61\164\151\x6f\156\57\155\141\x63\x62\151\x6e\x61\x72\x79", "\144\x6f\x63" => "\141\160\160\154\x69\143\x61\164\x69\x6f\156\57\x6d\163\167\x6f\162\144", "\167\157\162\144" => "\x61\x70\160\154\x69\143\x61\164\x69\x6f\x6e\x2f\x6d\163\167\157\162\144", "\x78\154\163\x78" => "\x61\x70\160\154\151\x63\141\164\x69\157\156\57\x76\156\x64\x2e\157\x70\145\156\170\x6d\154\x66\x6f\x72\x6d\x61\164\x73\x2d\x6f\x66\x66\151\x63\x65\x64\157\x63\x75\x6d\145\x6e\x74\56\163\x70\x72\x65\141\144\163\150\x65\145\x74\155\154\x2e\x73\x68\145\145\164", "\x78\x6c\x74\170" => "\x61\160\x70\154\151\143\x61\x74\151\157\x6e\x2f\166\x6e\144\x2e\x6f\x70\x65\x6e\170\x6d\x6c\146\x6f\162\x6d\141\x74\163\x2d\157\x66\146\x69\x63\x65\x64\x6f\143\x75\155\x65\x6e\164\x2e\x73\x70\162\145\141\144\x73\150\145\x65\x74\155\154\x2e\x74\145\155\x70\x6c\x61\164\x65", "\160\157\164\170" => "\x61\x70\x70\x6c\x69\143\x61\x74\x69\x6f\156\57\166\156\144\56\x6f\160\x65\x6e\x78\155\154\146\x6f\162\x6d\141\164\163\55\x6f\x66\x66\x69\143\145\x64\x6f\x63\165\155\x65\156\x74\x2e\160\x72\x65\163\x65\156\x74\141\x74\151\157\156\155\154\x2e\164\x65\x6d\160\154\141\x74\x65", "\x70\x70\x73\x78" => "\x61\x70\x70\x6c\151\143\x61\x74\151\x6f\156\57\x76\156\144\56\x6f\x70\145\x6e\x78\x6d\154\x66\157\x72\x6d\141\164\163\x2d\157\x66\x66\151\143\145\144\x6f\x63\x75\155\145\x6e\x74\x2e\x70\x72\x65\163\145\156\164\141\x74\x69\157\x6e\155\154\x2e\163\x6c\x69\144\145\163\x68\x6f\x77", "\160\160\x74\x78" => "\141\x70\160\x6c\x69\x63\141\x74\x69\157\x6e\x2f\166\x6e\x64\56\157\160\x65\156\170\155\154\146\x6f\162\155\x61\x74\x73\55\x6f\146\146\151\x63\x65\144\x6f\143\165\155\145\156\x74\x2e\x70\162\x65\163\145\x6e\164\x61\x74\x69\x6f\156\155\154\x2e\x70\x72\x65\163\145\156\x74\x61\164\151\x6f\156", "\x73\154\144\170" => "\x61\160\160\x6c\x69\143\x61\x74\x69\x6f\x6e\x2f\166\x6e\144\x2e\157\x70\145\156\170\x6d\x6c\x66\x6f\162\x6d\141\164\163\x2d\157\146\146\x69\x63\x65\x64\x6f\x63\x75\155\x65\156\164\56\x70\x72\x65\163\x65\156\164\x61\164\x69\157\x6e\155\154\x2e\x73\x6c\151\144\x65", "\x64\157\x63\170" => "\x61\160\x70\x6c\x69\143\141\164\x69\x6f\156\57\166\156\144\x2e\x6f\x70\145\x6e\x78\155\x6c\x66\157\x72\x6d\x61\164\x73\x2d\x6f\146\x66\x69\143\145\x64\x6f\143\x75\x6d\x65\156\x74\56\x77\x6f\x72\144\x70\x72\157\143\x65\163\163\x69\x6e\x67\x6d\154\x2e\x64\157\x63\x75\155\x65\156\164", "\144\x6f\164\170" => "\x61\160\160\154\x69\143\x61\x74\x69\x6f\x6e\57\x76\x6e\x64\56\x6f\x70\145\x6e\170\x6d\x6c\146\157\x72\x6d\141\x74\x73\55\157\146\x66\x69\x63\145\144\x6f\x63\165\x6d\x65\156\x74\x2e\x77\157\162\x64\x70\x72\157\x63\145\163\x73\x69\156\147\x6d\154\x2e\164\x65\x6d\160\154\x61\x74\145", "\170\x6c\x61\x6d" => "\141\160\160\154\x69\x63\141\164\151\x6f\156\x2f\x76\x6e\x64\56\x6d\163\x2d\x65\x78\x63\145\x6c\x2e\x61\x64\x64\x69\156\56\155\141\143\x72\157\105\156\x61\x62\154\145\144\x2e\x31\62", "\x78\x6c\x73\x62" => "\x61\160\160\x6c\x69\x63\141\x74\x69\x6f\156\57\x76\156\144\x2e\155\x73\55\145\170\143\145\x6c\56\x73\150\x65\x65\x74\56\142\151\156\141\162\x79\x2e\x6d\x61\x63\162\157\x45\x6e\141\142\x6c\145\144\x2e\61\x32", "\143\x6c\141\x73\163" => "\x61\160\x70\154\x69\x63\141\x74\151\x6f\x6e\57\x6f\x63\x74\x65\164\55\x73\164\x72\145\x61\155", "\x64\x6c\x6c" => "\141\160\x70\x6c\151\x63\141\x74\151\157\x6e\x2f\x6f\143\x74\x65\164\55\163\x74\x72\x65\141\155", "\x64\x6d\163" => "\141\x70\x70\x6c\151\x63\x61\164\151\x6f\x6e\x2f\157\x63\164\145\x74\x2d\163\x74\162\145\x61\155", "\x65\x78\x65" => "\x61\x70\x70\x6c\x69\143\x61\x74\151\x6f\156\x2f\157\x63\164\x65\164\x2d\163\164\x72\x65\x61\155", "\x6c\150\141" => "\141\x70\x70\x6c\151\x63\141\x74\x69\x6f\156\57\x6f\143\x74\145\x74\55\163\x74\162\145\141\155", "\154\172\150" => "\x61\160\160\x6c\151\143\x61\x74\151\157\156\x2f\157\143\x74\x65\164\55\163\164\162\145\141\155", "\x70\163\144" => "\x61\160\160\154\x69\x63\x61\164\x69\157\156\57\x6f\143\164\145\164\x2d\x73\x74\x72\145\x61\x6d", "\x73\x65\141" => "\141\160\x70\x6c\x69\143\x61\164\151\157\156\x2f\157\143\164\145\x74\x2d\163\164\162\x65\x61\155", "\163\x6f" => "\x61\x70\x70\154\x69\143\141\x74\151\x6f\x6e\57\157\143\x74\145\164\55\163\x74\162\145\x61\x6d", "\x6f\x64\x61" => "\141\x70\160\154\151\143\141\164\151\157\156\x2f\157\144\141", "\160\144\x66" => "\141\160\x70\154\x69\x63\x61\x74\151\x6f\x6e\x2f\x70\x64\x66", "\141\x69" => "\x61\160\x70\154\151\x63\x61\164\x69\x6f\x6e\x2f\160\x6f\163\x74\163\x63\x72\x69\160\x74", "\x65\160\163" => "\141\x70\x70\154\151\x63\141\164\151\x6f\156\57\160\157\x73\164\x73\143\x72\x69\160\x74", "\160\163" => "\141\160\x70\154\151\143\141\164\151\157\x6e\x2f\x70\x6f\x73\164\163\x63\x72\151\x70\x74", "\x73\x6d\151" => "\141\x70\x70\x6c\x69\143\141\164\151\x6f\x6e\57\x73\x6d\x69\x6c", "\x73\155\151\x6c" => "\x61\160\160\154\151\x63\141\164\151\x6f\156\57\x73\x6d\151\x6c", "\155\x69\x66" => "\141\x70\x70\154\x69\x63\x61\x74\x69\x6f\x6e\57\166\156\x64\x2e\155\x69\x66", "\x78\154\x73" => "\x61\x70\160\x6c\x69\143\141\164\x69\157\x6e\57\166\x6e\144\56\x6d\x73\x2d\x65\170\143\x65\154", "\160\x70\x74" => "\x61\160\160\154\x69\x63\x61\164\x69\157\156\57\x76\156\144\56\155\163\55\x70\x6f\167\x65\162\160\x6f\151\156\164", "\x77\x62\x78\155\x6c" => "\x61\x70\160\x6c\x69\x63\141\x74\x69\x6f\156\57\x76\x6e\x64\x2e\167\141\160\x2e\x77\142\x78\x6d\154", "\x77\x6d\x6c\x63" => "\141\x70\160\154\151\x63\141\164\151\x6f\x6e\x2f\166\156\144\x2e\167\141\x70\56\x77\x6d\154\x63", "\x64\x63\162" => "\x61\x70\x70\154\x69\x63\x61\x74\151\x6f\156\x2f\170\x2d\144\151\162\x65\143\x74\x6f\162", "\x64\x69\162" => "\x61\160\160\154\151\x63\x61\x74\x69\157\156\x2f\x78\x2d\144\151\162\145\x63\164\x6f\x72", "\x64\x78\162" => "\x61\160\x70\154\x69\143\141\x74\151\x6f\x6e\57\x78\x2d\x64\x69\x72\x65\143\x74\157\162", "\x64\166\151" => "\x61\160\160\x6c\151\143\141\x74\151\x6f\x6e\x2f\170\55\144\x76\151", "\x67\x74\x61\x72" => "\141\x70\x70\x6c\151\x63\141\164\x69\x6f\x6e\x2f\170\x2d\147\164\x61\162", "\x70\x68\x70\63" => "\141\x70\160\x6c\x69\143\141\164\x69\x6f\156\x2f\170\55\x68\164\x74\x70\x64\55\160\150\160", "\x70\150\x70\64" => "\141\x70\x70\x6c\151\x63\x61\164\151\157\156\57\170\x2d\x68\x74\x74\160\x64\x2d\x70\x68\x70", "\x70\150\x70" => "\x61\160\x70\154\151\x63\x61\164\151\157\x6e\57\x78\x2d\150\164\164\x70\144\55\x70\x68\160", "\160\150\164\x6d\x6c" => "\x61\x70\160\154\x69\143\x61\x74\x69\x6f\156\x2f\170\x2d\150\164\164\x70\144\x2d\160\x68\x70", "\160\x68\x70\163" => "\141\160\160\x6c\151\143\x61\x74\x69\157\156\57\x78\x2d\x68\x74\x74\160\x64\55\x70\150\x70\x2d\x73\x6f\165\x72\143\x65", "\x73\x77\x66" => "\x61\160\160\x6c\x69\x63\x61\x74\x69\157\x6e\57\170\55\163\x68\157\143\153\167\x61\x76\145\x2d\146\154\141\x73\150", "\163\151\x74" => "\x61\x70\160\x6c\151\x63\x61\164\x69\x6f\156\57\x78\55\163\164\x75\x66\x66\x69\164", "\x74\141\162" => "\141\160\x70\154\151\143\141\164\x69\157\156\57\x78\55\x74\x61\162", "\x74\147\172" => "\x61\160\160\154\x69\x63\x61\164\x69\157\x6e\57\170\55\164\141\x72", "\x78\x68\164" => "\x61\160\x70\x6c\x69\x63\141\164\x69\x6f\156\57\170\150\x74\x6d\154\53\x78\x6d\154", "\170\x68\x74\x6d\x6c" => "\x61\x70\160\x6c\x69\x63\x61\x74\151\x6f\156\57\x78\x68\x74\155\154\x2b\170\155\154", "\172\x69\x70" => "\141\160\x70\154\x69\x63\141\x74\x69\x6f\156\57\x7a\151\160", "\155\151\x64" => "\141\165\144\x69\157\x2f\x6d\x69\x64\151", "\x6d\151\x64\x69" => "\141\x75\144\151\157\57\155\151\x64\151", "\x6d\x70\x32" => "\x61\x75\x64\151\157\57\x6d\160\x65\147", "\x6d\x70\x33" => "\x61\x75\144\151\x6f\57\155\x70\145\147", "\155\64\141" => "\x61\165\x64\x69\157\x2f\x6d\160\x34", "\155\160\147\x61" => "\141\165\x64\151\x6f\57\x6d\160\145\x67", "\141\151\146" => "\x61\165\x64\151\x6f\x2f\170\x2d\141\x69\x66\x66", "\x61\x69\146\x63" => "\141\165\144\151\x6f\x2f\x78\55\141\x69\146\146", "\x61\x69\x66\x66" => "\141\165\144\151\157\x2f\x78\55\141\151\x66\x66", "\x72\141\155" => "\x61\x75\144\x69\x6f\x2f\x78\55\160\156\55\x72\145\x61\154\141\x75\144\x69\x6f", "\x72\x6d" => "\x61\165\x64\151\157\57\170\x2d\x70\156\x2d\x72\145\141\x6c\x61\x75\144\151\157", "\x72\160\155" => "\141\165\x64\151\x6f\57\170\x2d\x70\156\x2d\162\145\141\154\141\165\144\x69\157\55\x70\x6c\x75\147\151\156", "\162\141" => "\141\165\144\151\x6f\57\x78\x2d\162\145\x61\x6c\141\165\x64\151\x6f", "\x77\141\166" => "\x61\165\144\151\x6f\57\170\55\167\141\x76", "\x6d\153\141" => "\141\x75\x64\x69\x6f\x2f\x78\55\155\141\x74\162\x6f\x73\153\x61", "\x62\x6d\x70" => "\x69\155\141\147\x65\x2f\142\155\160", "\147\151\146" => "\x69\155\141\147\x65\x2f\x67\x69\146", "\152\x70\145\x67" => "\151\x6d\141\x67\x65\57\152\x70\145\x67", "\x6a\160\145" => "\151\155\141\147\145\x2f\x6a\160\x65\147", "\x6a\x70\x67" => "\151\x6d\x61\147\145\57\152\x70\x65\x67", "\160\156\147" => "\151\155\x61\147\x65\57\x70\x6e\x67", "\x74\151\146\146" => "\151\x6d\141\147\145\x2f\x74\151\x66\x66", "\164\x69\146" => "\x69\155\141\147\x65\57\x74\x69\146\x66", "\167\x65\142\x70" => "\151\155\x61\147\145\57\167\145\x62\x70", "\141\166\x69\146" => "\151\x6d\141\x67\x65\57\x61\166\151\x66", "\x68\145\151\x66" => "\x69\x6d\141\x67\x65\x2f\x68\145\x69\x66", "\x68\145\151\x66\163" => "\151\155\141\x67\145\x2f\150\145\151\146\x2d\163\145\161\x75\145\x6e\143\145", "\x68\145\x69\x63" => "\151\x6d\141\147\145\x2f\x68\145\151\x63", "\150\145\x69\143\163" => "\x69\x6d\x61\x67\x65\x2f\x68\x65\151\x63\x2d\x73\145\x71\165\145\156\x63\x65", "\x65\x6d\x6c" => "\155\x65\163\x73\141\147\x65\57\162\x66\x63\x38\62\62", "\x63\x73\163" => "\x74\x65\170\164\57\x63\163\x73", "\150\x74\x6d\x6c" => "\164\x65\x78\x74\x2f\x68\x74\155\154", "\x68\x74\155" => "\164\145\x78\164\x2f\x68\x74\x6d\154", "\x73\150\164\x6d\154" => "\x74\x65\170\164\57\x68\164\155\x6c", "\154\157\147" => "\164\145\x78\x74\x2f\160\x6c\x61\x69\x6e", "\164\145\x78\x74" => "\x74\x65\170\164\57\160\x6c\x61\151\x6e", "\x74\170\164" => "\x74\145\x78\x74\x2f\160\x6c\x61\x69\156", "\x72\x74\x78" => "\x74\145\x78\164\x2f\x72\151\143\x68\164\145\170\164", "\x72\164\x66" => "\x74\x65\x78\x74\x2f\x72\164\x66", "\x76\x63\x66" => "\164\145\170\x74\57\x76\143\141\162\144", "\166\143\x61\x72\x64" => "\164\145\x78\164\x2f\166\x63\x61\162\144", "\x69\143\163" => "\164\145\x78\x74\57\143\141\154\145\156\x64\141\x72", "\x78\x6d\154" => "\x74\145\x78\x74\x2f\170\x6d\x6c", "\170\x73\154" => "\x74\145\x78\x74\x2f\170\x6d\154", "\x77\x6d\166" => "\166\151\144\x65\157\57\x78\x2d\155\x73\x2d\167\155\x76", "\155\x70\145\147" => "\166\151\x64\x65\157\57\x6d\160\145\147", "\x6d\x70\145" => "\x76\x69\x64\145\157\57\155\x70\x65\x67", "\x6d\160\x67" => "\x76\x69\144\145\157\57\155\x70\x65\147", "\155\160\64" => "\166\x69\x64\x65\x6f\x2f\155\x70\x34", "\x6d\64\166" => "\x76\151\x64\x65\x6f\57\x6d\160\64", "\155\x6f\166" => "\166\x69\x64\145\x6f\x2f\161\165\151\143\153\164\x69\155\x65", "\x71\x74" => "\166\x69\x64\x65\x6f\x2f\x71\165\151\x63\153\x74\x69\x6d\x65", "\x72\166" => "\x76\151\x64\145\x6f\x2f\x76\156\x64\x2e\162\x6e\55\162\x65\141\x6c\166\x69\x64\145\157", "\141\166\151" => "\x76\x69\144\145\157\57\170\55\155\x73\x76\x69\144\x65\x6f", "\x6d\x6f\x76\151\x65" => "\166\x69\x64\145\157\57\x78\x2d\x73\x67\151\x2d\x6d\x6f\166\151\x65", "\x77\145\142\x6d" => "\166\x69\x64\145\157\57\x77\x65\x62\x6d", "\155\153\166" => "\166\151\x64\x65\157\57\x78\x2d\x6d\141\164\162\157\163\x6b\x61");
		$ext = strtolower($ext);
		if (array_key_exists($ext, $mimes)) {
			return $mimes[$ext];
		}
		return "\x61\x70\160\x6c\151\143\x61\x74\x69\157\156\x2f\157\143\164\x65\164\x2d\x73\164\x72\x65\x61\155";
	}
	public static function filenameToType($filename)
	{
		$qpos = strpos($filename, "\77");
		if (false !== $qpos) {
			$filename = substr($filename, 0, $qpos);
		}
		$ext = static::mb_pathinfo($filename, PATHINFO_EXTENSION);
		return static::_mime_types($ext);
	}
	public static function mb_pathinfo($path, $options = null)
	{
		$ret = array("\144\151\162\x6e\141\155\145" => '', "\142\141\163\x65\156\141\x6d\145" => '', "\145\x78\x74\145\x6e\163\x69\x6f\x6e" => '', "\x66\151\x6c\x65\x6e\141\x6d\x65" => '');
		$pathinfo = array();
		if (preg_match("\x23\136\50\56\52\x3f\x29\x5b\134\134\57\x5d\52\50\50\x5b\x5e\57\134\134\x5d\x2a\77\51\x28\x5c\x2e\x28\133\136\56\134\134\57\135\x2b\77\x29\x7c\51\x29\x5b\x5c\x5c\57\56\x5d\52\44\43\155", $path, $pathinfo)) {
			if (array_key_exists(1, $pathinfo)) {
				$ret["\x64\x69\162\x6e\x61\x6d\145"] = $pathinfo[1];
			}
			if (array_key_exists(2, $pathinfo)) {
				$ret["\142\x61\x73\145\x6e\141\155\145"] = $pathinfo[2];
			}
			if (array_key_exists(5, $pathinfo)) {
				$ret["\x65\170\x74\x65\156\x73\151\x6f\156"] = $pathinfo[5];
			}
			if (array_key_exists(3, $pathinfo)) {
				$ret["\x66\x69\154\145\156\x61\x6d\x65"] = $pathinfo[3];
			}
		}
		switch ($options) {
			case PATHINFO_DIRNAME:
			case "\x64\151\x72\x6e\141\155\145":
				return $ret["\x64\x69\x72\156\141\155\145"];
			case PATHINFO_BASENAME:
			case "\x62\141\163\x65\156\x61\x6d\x65":
				return $ret["\142\141\x73\145\x6e\x61\155\145"];
			case PATHINFO_EXTENSION:
			case "\x65\x78\164\x65\x6e\163\151\157\156":
				return $ret["\x65\170\164\x65\156\x73\151\x6f\156"];
			case PATHINFO_FILENAME:
			case "\146\151\x6c\145\156\x61\x6d\x65":
				return $ret["\146\151\x6c\x65\156\x61\155\x65"];
			default:
				return $ret;
		}
	}
	public function set($name, $value = '')
	{
		if (property_exists($this, $name)) {
			$this->{$name} = $value;
			return true;
		}
		$this->setError($this->lang("\x76\141\x72\x69\x61\142\x6c\x65\137\163\145\164") . $name);
		return false;
	}
	public function secureHeader($str)
	{
		return trim(str_replace(array("\xd", "\12"), '', $str));
	}
	public static function normalizeBreaks($text, $breaktype = null)
	{
		if (null === $breaktype) {
			$breaktype = static::$LE;
		}
		$text = str_replace(array(self::CRLF, "\15"), "\xa", $text);
		if ("\12" !== $breaktype) {
			$text = str_replace("\xa", $breaktype, $text);
		}
		return $text;
	}
	public static function stripTrailingWSP($text)
	{
		return rtrim($text, "\x20\xd\12\x9");
	}
	public static function getLE()
	{
		return static::$LE;
	}
	protected static function setLE($le)
	{
		static::$LE = $le;
	}
	public function sign($cert_filename, $key_filename, $key_pass, $extracerts_filename = '')
	{
		$this->sign_cert_file = $cert_filename;
		$this->sign_key_file = $key_filename;
		$this->sign_key_pass = $key_pass;
		$this->sign_extracerts_file = $extracerts_filename;
	}
	public function DKIM_QP($txt)
	{
		$line = '';
		$len = strlen($txt);
		for ($i = 0; $i < $len; ++$i) {
			$ord = ord($txt[$i]);
			if (33 <= $ord && $ord <= 58 || $ord === 60 || 62 <= $ord && $ord <= 126) {
				$line .= $txt[$i];
			} else {
				$line .= "\x3d" . sprintf("\45\x30\x32\x58", $ord);
			}
		}
		return $line;
	}
	public function DKIM_Sign($signHeader)
	{
		if (!defined("\120\113\x43\x53\67\137\124\105\x58\x54")) {
			if ($this->exceptions) {
				throw new Exception($this->lang("\145\170\x74\145\156\163\151\157\156\137\x6d\x69\163\x73\x69\156\147") . "\x6f\x70\145\156\x73\163\x6c");
			}
			return '';
		}
		$privKeyStr = !empty($this->DKIM_private_string) ? $this->DKIM_private_string : file_get_contents($this->DKIM_private);
		if ('' !== $this->DKIM_passphrase) {
			$privKey = openssl_pkey_get_private($privKeyStr, $this->DKIM_passphrase);
		} else {
			$privKey = openssl_pkey_get_private($privKeyStr);
		}
		if (openssl_sign($signHeader, $signature, $privKey, "\x73\x68\141\62\65\x36\127\151\x74\150\x52\123\101\x45\x6e\x63\x72\171\160\164\151\157\156")) {
			if (\PHP_MAJOR_VERSION < 8) {
				openssl_pkey_free($privKey);
			}
			return base64_encode($signature);
		}
		if (\PHP_MAJOR_VERSION < 8) {
			openssl_pkey_free($privKey);
		}
		return '';
	}
	public function DKIM_HeaderC($signHeader)
	{
		$signHeader = static::normalizeBreaks($signHeader, self::CRLF);
		$signHeader = preg_replace("\x2f\134\x72\x5c\x6e\133\x20\x5c\164\135\53\x2f", "\x20", $signHeader);
		$lines = explode(self::CRLF, $signHeader);
		foreach ($lines as $key => $line) {
			if (strpos($line, "\x3a") === false) {
				continue;
			}
			list($heading, $value) = explode("\72", $line, 2);
			$heading = strtolower($heading);
			$value = preg_replace("\x2f\x5b\40\134\164\135\x2b\57", "\40", $value);
			$lines[$key] = trim($heading, "\40\11") . "\72" . trim($value, "\40\11");
		}
		return implode(self::CRLF, $lines);
	}
	public function DKIM_BodyC($body)
	{
		if (empty($body)) {
			return self::CRLF;
		}
		$body = static::normalizeBreaks($body, self::CRLF);
		return static::stripTrailingWSP($body) . self::CRLF;
	}
	public function DKIM_Add($headers_line, $subject, $body)
	{
		$DKIMsignatureType = "\x72\163\x61\55\x73\150\141\x32\65\66";
		$DKIMcanonicalization = "\162\x65\154\x61\170\145\144\x2f\x73\x69\x6d\x70\154\x65";
		$DKIMquery = "\x64\x6e\163\x2f\164\170\x74";
		$DKIMtime = time();
		$autoSignHeaders = array("\x66\162\x6f\x6d", "\164\x6f", "\x63\x63", "\144\x61\x74\145", "\163\165\142\152\145\x63\164", "\x72\x65\x70\154\171\x2d\164\157", "\155\145\x73\x73\141\147\145\55\x69\144", "\x63\x6f\x6e\x74\145\x6e\x74\55\x74\x79\x70\145", "\155\x69\x6d\145\55\x76\x65\162\163\151\x6f\156", "\170\x2d\x6d\x61\151\x6c\145\162");
		if (stripos($headers_line, "\123\165\142\x6a\x65\143\164") === false) {
			$headers_line .= "\123\x75\142\152\x65\143\164\72\x20" . $subject . static::$LE;
		}
		$headerLines = explode(static::$LE, $headers_line);
		$currentHeaderLabel = '';
		$currentHeaderValue = '';
		$parsedHeaders = array();
		$headerLineIndex = 0;
		$headerLineCount = count($headerLines);
		foreach ($headerLines as $headerLine) {
			$matches = array();
			if (preg_match("\57\x5e\50\133\x5e\40\134\x74\135\x2a\x3f\x29\50\77\72\x3a\x5b\40\134\164\135\52\x29\x28\x2e\52\x29\x24\57", $headerLine, $matches)) {
				if ($currentHeaderLabel !== '') {
					$parsedHeaders[] = array("\154\x61\x62\x65\x6c" => $currentHeaderLabel, "\x76\x61\x6c\x75\x65" => $currentHeaderValue);
				}
				$currentHeaderLabel = $matches[1];
				$currentHeaderValue = $matches[2];
			} elseif (preg_match("\57\x5e\133\40\x5c\x74\x5d\53\x28\56\x2a\x29\x24\57", $headerLine, $matches)) {
				$currentHeaderValue .= "\40" . $matches[1];
			}
			++$headerLineIndex;
			if ($headerLineIndex >= $headerLineCount) {
				$parsedHeaders[] = array("\154\141\142\145\x6c" => $currentHeaderLabel, "\x76\141\x6c\165\145" => $currentHeaderValue);
			}
		}
		$copiedHeaders = array();
		$headersToSignKeys = array();
		$headersToSign = array();
		foreach ($parsedHeaders as $header) {
			if (in_array(strtolower($header["\x6c\x61\x62\x65\x6c"]), $autoSignHeaders, true)) {
				$headersToSignKeys[] = $header["\x6c\141\142\x65\x6c"];
				$headersToSign[] = $header["\x6c\x61\142\x65\154"] . "\72\40" . $header["\x76\x61\154\x75\x65"];
				if ($this->DKIM_copyHeaderFields) {
					$copiedHeaders[] = $header["\x6c\x61\142\145\x6c"] . "\72" . str_replace("\x7c", "\x3d\67\103", $this->DKIM_QP($header["\x76\x61\154\165\145"]));
				}
				continue;
			}
			if (in_array($header["\x6c\x61\x62\x65\x6c"], $this->DKIM_extraHeaders, true)) {
				foreach ($this->CustomHeader as $customHeader) {
					if ($customHeader[0] === $header["\x6c\141\142\x65\x6c"]) {
						$headersToSignKeys[] = $header["\154\141\142\145\154"];
						$headersToSign[] = $header["\154\141\x62\145\154"] . "\x3a\x20" . $header["\166\141\x6c\x75\x65"];
						if ($this->DKIM_copyHeaderFields) {
							$copiedHeaders[] = $header["\154\141\x62\145\x6c"] . "\x3a" . str_replace("\x7c", "\x3d\67\x43", $this->DKIM_QP($header["\x76\x61\x6c\165\x65"]));
						}
						continue 2;
					}
				}
			}
		}
		$copiedHeaderFields = '';
		if ($this->DKIM_copyHeaderFields && count($copiedHeaders) > 0) {
			$copiedHeaderFields = "\x20\x7a\x3d";
			$first = true;
			foreach ($copiedHeaders as $copiedHeader) {
				if (!$first) {
					$copiedHeaderFields .= static::$LE . "\40\x7c";
				}
				if (strlen($copiedHeader) > self::STD_LINE_LENGTH - 3) {
					$copiedHeaderFields .= substr(chunk_split($copiedHeader, self::STD_LINE_LENGTH - 3, static::$LE . self::FWS), 0, -strlen(static::$LE . self::FWS));
				} else {
					$copiedHeaderFields .= $copiedHeader;
				}
				$first = false;
			}
			$copiedHeaderFields .= "\x3b" . static::$LE;
		}
		$headerKeys = "\40\150\x3d" . implode("\72", $headersToSignKeys) . "\73" . static::$LE;
		$headerValues = implode(static::$LE, $headersToSign);
		$body = $this->DKIM_BodyC($body);
		$DKIMb64 = base64_encode(pack("\110\52", hash("\x73\150\141\62\65\x36", $body)));
		$ident = '';
		if ('' !== $this->DKIM_identity) {
			$ident = "\x20\151\x3d" . $this->DKIM_identity . "\73" . static::$LE;
		}
		$dkimSignatureHeader = "\104\x4b\111\115\55\123\151\147\156\141\164\165\162\145\72\40\166\x3d\x31\x3b" . "\40\x64\75" . $this->DKIM_domain . "\73" . "\x20\163\x3d" . $this->DKIM_selector . "\73" . static::$LE . "\40\141\75" . $DKIMsignatureType . "\x3b" . "\x20\161\75" . $DKIMquery . "\x3b" . "\x20\164\x3d" . $DKIMtime . "\73" . "\40\143\x3d" . $DKIMcanonicalization . "\73" . static::$LE . $headerKeys . $ident . $copiedHeaderFields . "\x20\x62\150\75" . $DKIMb64 . "\73" . static::$LE . "\40\142\x3d";
		$canonicalizedHeaders = $this->DKIM_HeaderC($headerValues . static::$LE . $dkimSignatureHeader);
		$signature = $this->DKIM_Sign($canonicalizedHeaders);
		$signature = trim(chunk_split($signature, self::STD_LINE_LENGTH - 3, static::$LE . self::FWS));
		return static::normalizeBreaks($dkimSignatureHeader . $signature);
	}
	public static function hasLineLongerThanMax($str)
	{
		return (bool) preg_match("\57\x5e\x28\56\x7b" . (self::MAX_LINE_LENGTH + strlen(static::$LE)) . "\x2c\175\x29\x2f\x6d", $str);
	}
	public static function quotedString($str)
	{
		if (preg_match("\57\x5b\40\50\51\x3c\76\100\x2c\x3b\72\42\134\57\134\133\134\135\77\75\x5d\x2f", $str)) {
			return "\42" . str_replace("\42", "\134\42", $str) . "\x22";
		}
		return $str;
	}
	public function getToAddresses()
	{
		return $this->to;
	}
	public function getCcAddresses()
	{
		return $this->cc;
	}
	public function getBccAddresses()
	{
		return $this->bcc;
	}
	public function getReplyToAddresses()
	{
		return $this->ReplyTo;
	}
	public function getAllRecipientAddresses()
	{
		return $this->all_recipients;
	}
	protected function doCallback($isSent, $to, $cc, $bcc, $subject, $body, $from, $extra)
	{
		if (!empty($this->action_function) && is_callable($this->action_function)) {
			call_user_func($this->action_function, $isSent, $to, $cc, $bcc, $subject, $body, $from, $extra);
		}
	}
	public function getOAuth()
	{
		return $this->oauth;
	}
	public function setOAuth(OAuth $oauth)
	{
		$this->oauth = $oauth;
	}
}
