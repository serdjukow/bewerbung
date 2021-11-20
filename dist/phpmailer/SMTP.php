<?php

namespace PHPMailer\PHPMailer;

class SMTP
{
	const VERSION = "\x36\x2e\62\x2e\60";
	const LE = "\15\xa";
	const DEFAULT_PORT = 25;
	const MAX_LINE_LENGTH = 998;
	const MAX_REPLY_LENGTH = 512;
	const DEBUG_OFF = 0;
	const DEBUG_CLIENT = 1;
	const DEBUG_SERVER = 2;
	const DEBUG_CONNECTION = 3;
	const DEBUG_LOWLEVEL = 4;
	public $do_debug = self::DEBUG_OFF;
	public $Debugoutput = "\145\143\150\x6f";
	public $do_verp = false;
	public $Timeout = 300;
	public $Timelimit = 300;
	protected $smtp_transaction_id_patterns = array("\145\x78\x69\x6d" => "\x2f\133\x5c\x64\135\173\x33\175\x20\x4f\x4b\40\151\x64\75\x28\56\x2a\51\x2f", "\163\x65\x6e\x64\x6d\141\151\x6c" => "\57\x5b\134\144\135\x7b\x33\x7d\40\x32\x2e\60\56\x30\x20\50\x2e\52\x29\40\x4d\x65\163\163\x61\x67\x65\x2f", "\x70\x6f\x73\164\x66\151\x78" => "\57\133\x5c\x64\x5d\x7b\63\x7d\40\x32\x2e\x30\56\60\x20\117\x6b\72\x20\x71\165\145\x75\145\144\40\141\163\x20\x28\56\52\x29\x2f", "\115\x69\143\x72\157\163\x6f\146\x74\x5f\x45\123\x4d\124\120" => "\57\133\x30\x2d\x39\x5d\173\x33\x7d\x20\x32\x2e\x5b\x5c\144\x5d\56\60\40\50\56\x2a\x29\100\50\x3f\x3a\x2e\52\51\40\121\165\145\165\145\x64\40\x6d\141\151\154\40\146\x6f\162\40\144\145\154\151\x76\x65\162\x79\x2f", "\101\155\x61\x7a\x6f\156\x5f\123\x45\x53" => "\57\x5b\x5c\144\135\173\x33\175\x20\117\x6b\x20\x28\x2e\52\51\x2f", "\x53\145\156\144\107\162\151\x64" => "\57\x5b\134\144\135\x7b\63\175\x20\x4f\153\72\x20\x71\165\145\165\x65\144\40\x61\x73\40\50\x2e\x2a\51\57", "\x43\141\155\x70\x61\x69\x67\x6e\115\157\x6e\151\x74\157\x72" => "\57\133\134\144\x5d\173\63\x7d\x20\x32\x2e\60\x2e\60\x20\117\113\72\50\x5b\141\x2d\172\101\55\x5a\134\x64\x5d\x7b\x34\70\x7d\51\x2f");
	protected $last_smtp_transaction_id;
	protected $smtp_conn;
	protected $error = array("\x65\162\162\x6f\162" => '', "\144\145\164\x61\x69\x6c" => '', "\x73\x6d\x74\x70\x5f\x63\157\x64\145" => '', "\163\x6d\164\x70\137\143\157\144\145\x5f\x65\x78" => '');
	protected $helo_rply;
	protected $server_caps;
	protected $last_reply = '';
	protected function edebug($str, $level = 0)
	{
		if ($level > $this->do_debug) {
			return;
		}
		if ($this->Debugoutput instanceof \Psr\Log\LoggerInterface) {
			$this->Debugoutput->debug($str);
			return;
		}
		if (is_callable($this->Debugoutput) && !in_array($this->Debugoutput, array("\145\162\162\157\162\x5f\x6c\x6f\147", "\x68\164\155\x6c", "\x65\143\x68\x6f"))) {
			call_user_func($this->Debugoutput, $str, $level);
			return;
		}
		switch ($this->Debugoutput) {
			case "\x65\162\162\x6f\162\x5f\x6c\157\x67":
				error_log($str);
				break;
			case "\150\x74\x6d\154":
				echo gmdate("\x59\55\155\55\x64\x20\110\72\151\72\x73"), "\40", htmlentities(preg_replace("\57\x5b\134\162\134\x6e\x5d\x2b\57", '', $str), ENT_QUOTES, "\x55\x54\x46\x2d\x38"), "\x3c\x62\x72\76\12";
				break;
			case "\x65\143\150\x6f":
			default:
				$str = preg_replace("\x2f\134\x72\134\156\174\x5c\x72\x2f\x6d", "\xa", $str);
				echo gmdate("\131\x2d\x6d\55\144\40\110\x3a\151\x3a\x73"), "\x9", trim(str_replace("\12", "\12\x20\40\40\40\40\x20\40\x20\x20\x20\x20\40\40\40\40\x20\x20\40\x20\11\x20\x20\x20\40\40\40\40\40\40\40\x20\40\40\40\40\40\x20\x20", trim($str))), "\xa";
		}
	}
	public function connect($host, $port = null, $timeout = 30, $options = array())
	{
		$this->setError('');
		if ($this->connected()) {
			$this->setError("\101\x6c\x72\x65\141\x64\171\40\143\157\156\156\145\143\x74\145\x64\x20\x74\x6f\40\x61\x20\x73\145\162\166\145\162");
			return false;
		}
		if (empty($port)) {
			$port = self::DEFAULT_PORT;
		}
		$this->edebug("\103\x6f\x6e\156\145\143\164\x69\157\156\72\x20\157\160\x65\x6e\x69\156\147\40\164\157\40{$host}\72{$port}\54\40\164\x69\155\x65\x6f\165\x74\x3d{$timeout}\x2c\40\157\x70\164\151\x6f\156\x73\75" . (count($options) > 0 ? var_export($options, true) : "\x61\x72\162\141\171\x28\51"), self::DEBUG_CONNECTION);
		$this->smtp_conn = $this->getSMTPConnection($host, $port, $timeout, $options);
		if ($this->smtp_conn === false) {
			return false;
		}
		$this->edebug("\103\157\156\156\x65\x63\164\151\x6f\x6e\72\x20\157\x70\145\x6e\x65\x64", self::DEBUG_CONNECTION);
		$this->last_reply = $this->get_lines();
		$this->edebug("\123\105\122\x56\105\122\x20\55\76\40\103\x4c\x49\x45\116\x54\72\40" . $this->last_reply, self::DEBUG_SERVER);
		$responseCode = (int) substr($this->last_reply, 0, 3);
		if ($responseCode === 220) {
			return true;
		}
		if ($responseCode === 554) {
			$this->quit();
		}
		$this->edebug("\x43\x6f\156\156\x65\143\x74\151\x6f\x6e\72\x20\x63\x6c\157\x73\x69\156\x67\40\144\x75\x65\40\x74\157\x20\x65\162\x72\157\162", self::DEBUG_CONNECTION);
		$this->close();
		return false;
	}
	protected function getSMTPConnection($host, $port = null, $timeout = 30, $options = array())
	{
		static $streamok;
		if (null === $streamok) {
			$streamok = function_exists("\163\164\x72\145\141\x6d\x5f\x73\x6f\x63\x6b\145\164\137\143\x6c\151\x65\156\164");
		}
		$errno = 0;
		$errstr = '';
		if ($streamok) {
			$socket_context = stream_context_create($options);
			set_error_handler(array($this, "\145\162\162\157\162\110\141\156\144\x6c\x65\162"));
			$connection = stream_socket_client($host . "\x3a" . $port, $errno, $errstr, $timeout, STREAM_CLIENT_CONNECT, $socket_context);
			restore_error_handler();
		} else {
			$this->edebug("\103\157\156\156\145\143\x74\151\157\x6e\x3a\40\163\164\162\x65\141\x6d\137\163\157\143\x6b\145\164\x5f\x63\x6c\x69\x65\x6e\x74\40\x6e\x6f\x74\x20\x61\166\141\151\154\x61\x62\154\145\x2c\x20\x66\141\154\x6c\151\x6e\x67\40\142\141\x63\153\40\x74\x6f\x20\146\163\x6f\x63\153\x6f\160\145\156", self::DEBUG_CONNECTION);
			set_error_handler(array($this, "\x65\162\162\157\x72\x48\x61\156\144\x6c\145\162"));
			$connection = fsockopen($host, $port, $errno, $errstr, $timeout);
			restore_error_handler();
		}
		if (!is_resource($connection)) {
			$this->setError("\x46\x61\151\x6c\145\144\x20\164\157\40\x63\x6f\156\x6e\x65\x63\164\x20\164\x6f\40\x73\145\x72\166\145\x72", '', (string) $errno, $errstr);
			$this->edebug("\x53\115\124\x50\x20\x45\x52\x52\x4f\x52\x3a\40" . $this->error["\145\162\162\x6f\x72"] . "\x3a\40{$errstr}\x20\50{$errno}\x29", self::DEBUG_CLIENT);
			return false;
		}
		if (strpos(PHP_OS, "\127\111\116") !== 0) {
			$max = (int) ini_get("\x6d\141\170\x5f\x65\170\145\143\x75\x74\x69\157\156\x5f\164\151\x6d\x65");
			if (0 !== $max && $timeout > $max && strpos(ini_get("\x64\x69\163\x61\x62\154\145\137\x66\x75\x6e\143\164\x69\x6f\156\x73"), "\x73\145\164\x5f\x74\x69\155\145\x5f\x6c\x69\x6d\x69\x74") === false) {
				@set_time_limit($timeout);
			}
			stream_set_timeout($connection, $timeout, 0);
		}
		return $connection;
	}
	public function startTLS()
	{
		if (!$this->sendCommand("\123\x54\x41\122\x54\124\x4c\123", "\x53\x54\101\122\x54\124\114\x53", 220)) {
			return false;
		}
		$crypto_method = STREAM_CRYPTO_METHOD_TLS_CLIENT;
		if (defined("\123\124\122\x45\101\115\137\103\122\131\120\124\x4f\x5f\x4d\x45\x54\x48\117\x44\137\x54\114\123\166\61\x5f\x32\137\x43\x4c\111\x45\x4e\x54")) {
			$crypto_method |= STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT;
			$crypto_method |= STREAM_CRYPTO_METHOD_TLSv1_1_CLIENT;
		}
		set_error_handler(array($this, "\x65\x72\162\x6f\162\x48\x61\x6e\x64\154\x65\x72"));
		$crypto_ok = stream_socket_enable_crypto($this->smtp_conn, true, $crypto_method);
		restore_error_handler();
		return (bool) $crypto_ok;
	}
	public function authenticate($username, $password, $authtype = null, $OAuth = null)
	{
		if (!$this->server_caps) {
			$this->setError("\x41\x75\164\x68\x65\156\164\x69\143\141\164\x69\x6f\156\40\151\163\40\x6e\157\x74\x20\141\154\154\x6f\167\145\x64\x20\x62\x65\x66\x6f\162\x65\x20\x48\105\x4c\117\57\105\110\x4c\117");
			return false;
		}
		if (array_key_exists("\105\110\x4c\117", $this->server_caps)) {
			if (!array_key_exists("\x41\x55\124\110", $this->server_caps)) {
				$this->setError("\101\165\164\150\x65\156\164\x69\x63\x61\x74\151\x6f\156\x20\151\163\40\156\x6f\164\40\x61\x6c\154\157\x77\145\x64\x20\x61\x74\x20\x74\150\151\163\40\163\164\141\x67\145");
				return false;
			}
			$this->edebug("\101\x75\164\150\x20\155\x65\164\150\157\144\40\x72\x65\x71\x75\x65\163\164\145\144\72\x20" . ($authtype ?: "\125\x4e\x53\120\105\x43\111\x46\x49\105\x44"), self::DEBUG_LOWLEVEL);
			$this->edebug("\101\x75\x74\150\x20\x6d\x65\x74\150\157\x64\163\x20\141\x76\141\x69\154\141\142\x6c\145\40\157\x6e\x20\164\x68\x65\40\163\x65\x72\166\x65\x72\72\x20" . implode("\x2c", $this->server_caps["\x41\125\124\x48"]), self::DEBUG_LOWLEVEL);
			if (null !== $authtype && !in_array($authtype, $this->server_caps["\x41\125\x54\x48"], true)) {
				$this->edebug("\122\x65\x71\x75\145\x73\164\x65\x64\x20\x61\x75\164\150\x20\x6d\x65\x74\x68\157\144\x20\156\x6f\x74\40\x61\166\141\x69\x6c\141\142\x6c\x65\72\x20" . $authtype, self::DEBUG_LOWLEVEL);
				$authtype = null;
			}
			if (empty($authtype)) {
				foreach (array("\x43\122\x41\x4d\55\x4d\x44\x35", "\114\117\107\x49\116", "\x50\114\101\x49\x4e", "\x58\x4f\101\125\124\x48\x32") as $method) {
					if (in_array($method, $this->server_caps["\101\x55\x54\x48"], true)) {
						$authtype = $method;
						break;
					}
				}
				if (empty($authtype)) {
					$this->setError("\x4e\157\x20\x73\165\x70\x70\157\x72\x74\x65\x64\x20\x61\x75\164\150\x65\x6e\x74\151\x63\141\x74\151\157\156\x20\155\x65\x74\x68\157\x64\163\x20\146\x6f\165\x6e\x64");
					return false;
				}
				$this->edebug("\x41\165\x74\150\40\x6d\145\164\x68\157\x64\x20\x73\x65\x6c\145\x63\x74\x65\x64\x3a\40" . $authtype, self::DEBUG_LOWLEVEL);
			}
			if (!in_array($authtype, $this->server_caps["\101\x55\124\x48"], true)) {
				$this->setError("\x54\x68\145\x20\162\x65\161\x75\x65\x73\164\x65\144\x20\x61\165\164\x68\x65\x6e\164\x69\143\x61\x74\151\x6f\156\40\x6d\145\164\x68\x6f\144\x20\42{$authtype}\42\x20\x69\163\40\156\157\164\40\x73\165\x70\160\x6f\162\164\x65\144\40\x62\171\x20\x74\150\x65\x20\163\145\162\x76\145\162");
				return false;
			}
		} elseif (empty($authtype)) {
			$authtype = "\114\117\x47\111\x4e";
		}
		switch ($authtype) {
			case "\x50\114\x41\111\x4e":
				if (!$this->sendCommand("\x41\125\124\110", "\x41\x55\124\x48\40\x50\x4c\101\111\116", 334)) {
					return false;
				}
				if (!$this->sendCommand("\x55\x73\145\x72\40\46\40\120\x61\163\x73\x77\157\x72\x64", base64_encode("\0" . $username . "\x0" . $password), 235)) {
					return false;
				}
				break;
			case "\x4c\117\x47\111\x4e":
				if (!$this->sendCommand("\101\x55\124\110", "\x41\x55\x54\x48\40\114\x4f\x47\111\x4e", 334)) {
					return false;
				}
				if (!$this->sendCommand("\125\163\x65\x72\x6e\141\x6d\x65", base64_encode($username), 334)) {
					return false;
				}
				if (!$this->sendCommand("\x50\x61\x73\163\167\x6f\x72\144", base64_encode($password), 235)) {
					return false;
				}
				break;
			case "\103\122\x41\x4d\x2d\115\104\65":
				if (!$this->sendCommand("\x41\125\x54\x48\x20\x43\122\x41\x4d\55\x4d\x44\65", "\101\125\124\x48\x20\103\122\x41\x4d\x2d\115\104\x35", 334)) {
					return false;
				}
				$challenge = base64_decode(substr($this->last_reply, 4));
				$response = $username . "\x20" . $this->hmac($challenge, $password);
				return $this->sendCommand("\125\163\x65\x72\156\x61\155\145", base64_encode($response), 235);
			case "\130\x4f\x41\125\x54\x48\62":
				if (null === $OAuth) {
					return false;
				}
				$oauth = $OAuth->getOauth64();
				if (!$this->sendCommand("\x41\x55\x54\x48", "\101\125\x54\x48\x20\130\x4f\x41\x55\124\x48\62\x20" . $oauth, 235)) {
					return false;
				}
				break;
			default:
				$this->setError("\101\x75\164\150\145\156\164\151\143\x61\x74\x69\x6f\x6e\x20\x6d\145\164\x68\x6f\144\x20\x22{$authtype}\42\40\151\x73\x20\x6e\157\x74\x20\x73\165\160\x70\x6f\x72\x74\x65\144");
				return false;
		}
		return true;
	}
	protected function hmac($data, $key)
	{
		if (function_exists("\x68\141\x73\x68\137\150\155\x61\143")) {
			return hash_hmac("\155\144\65", $data, $key);
		}
		$bytelen = 64;
		if (strlen($key) > $bytelen) {
			$key = pack("\x48\52", md5($key));
		}
		$key = str_pad($key, $bytelen, chr(0));
		$ipad = str_pad('', $bytelen, chr(54));
		$opad = str_pad('', $bytelen, chr(92));
		$k_ipad = $key ^ $ipad;
		$k_opad = $key ^ $opad;
		return md5($k_opad . pack("\110\x2a", md5($k_ipad . $data)));
	}
	public function connected()
	{
		if (is_resource($this->smtp_conn)) {
			$sock_status = stream_get_meta_data($this->smtp_conn);
			if ($sock_status["\145\x6f\146"]) {
				$this->edebug("\123\115\x54\x50\40\116\117\124\111\x43\x45\x3a\40\105\x4f\106\40\143\141\x75\x67\150\x74\40\167\150\x69\154\145\40\143\150\x65\143\x6b\151\156\147\x20\151\x66\40\x63\157\x6e\156\x65\x63\164\145\x64", self::DEBUG_CLIENT);
				$this->close();
				return false;
			}
			return true;
		}
		return false;
	}
	public function close()
	{
		$this->setError('');
		$this->server_caps = null;
		$this->helo_rply = null;
		if (is_resource($this->smtp_conn)) {
			fclose($this->smtp_conn);
			$this->smtp_conn = null;
			$this->edebug("\x43\x6f\156\156\x65\143\164\x69\157\156\x3a\x20\143\x6c\x6f\x73\145\144", self::DEBUG_CONNECTION);
		}
	}
	public function data($msg_data)
	{
		if (!$this->sendCommand("\x44\x41\x54\101", "\x44\x41\124\101", 354)) {
			return false;
		}
		$lines = explode("\12", str_replace(array("\15\12", "\15"), "\xa", $msg_data));
		$field = substr($lines[0], 0, strpos($lines[0], "\72"));
		$in_headers = false;
		if (!empty($field) && strpos($field, "\x20") === false) {
			$in_headers = true;
		}
		foreach ($lines as $line) {
			$lines_out = array();
			if ($in_headers && $line === '') {
				$in_headers = false;
			}
			while (isset($line[self::MAX_LINE_LENGTH])) {
				$pos = strrpos(substr($line, 0, self::MAX_LINE_LENGTH), "\40");
				if (!$pos) {
					$pos = self::MAX_LINE_LENGTH - 1;
					$lines_out[] = substr($line, 0, $pos);
					$line = substr($line, $pos);
				} else {
					$lines_out[] = substr($line, 0, $pos);
					$line = substr($line, $pos + 1);
				}
				if ($in_headers) {
					$line = "\11" . $line;
				}
			}
			$lines_out[] = $line;
			foreach ($lines_out as $line_out) {
				if (!empty($line_out) && $line_out[0] === "\x2e") {
					$line_out = "\56" . $line_out;
				}
				$this->client_send($line_out . static::LE, "\x44\x41\x54\101");
			}
		}
		$savetimelimit = $this->Timelimit;
		$this->Timelimit *= 2;
		$result = $this->sendCommand("\x44\101\x54\101\40\105\116\x44", "\x2e", 250);
		$this->recordLastTransactionID();
		$this->Timelimit = $savetimelimit;
		return $result;
	}
	public function hello($host = '')
	{
		if ($this->sendHello("\105\110\x4c\x4f", $host)) {
			return true;
		}
		if (substr($this->helo_rply, 0, 3) == "\64\x32\61") {
			return false;
		}
		return $this->sendHello("\x48\105\x4c\x4f", $host);
	}
	protected function sendHello($hello, $host)
	{
		$noerror = $this->sendCommand($hello, $hello . "\x20" . $host, 250);
		$this->helo_rply = $this->last_reply;
		if ($noerror) {
			$this->parseHelloFields($hello);
		} else {
			$this->server_caps = null;
		}
		return $noerror;
	}
	protected function parseHelloFields($type)
	{
		$this->server_caps = array();
		$lines = explode("\12", $this->helo_rply);
		foreach ($lines as $n => $s) {
			$s = trim(substr($s, 4));
			if (empty($s)) {
				continue;
			}
			$fields = explode("\x20", $s);
			if (!empty($fields)) {
				if (!$n) {
					$name = $type;
					$fields = $fields[0];
				} else {
					$name = array_shift($fields);
					switch ($name) {
						case "\x53\x49\132\105":
							$fields = $fields ? $fields[0] : 0;
							break;
						case "\x41\125\124\110":
							if (!is_array($fields)) {
								$fields = array();
							}
							break;
						default:
							$fields = true;
					}
				}
				$this->server_caps[$name] = $fields;
			}
		}
	}
	public function mail($from)
	{
		$useVerp = $this->do_verp ? "\40\130\126\x45\122\120" : '';
		return $this->sendCommand("\x4d\101\111\x4c\x20\106\x52\x4f\x4d", "\115\101\111\x4c\x20\106\x52\117\115\72\74" . $from . "\76" . $useVerp, 250);
	}
	public function quit($close_on_error = true)
	{
		$noerror = $this->sendCommand("\121\125\111\124", "\121\125\x49\124", 221);
		$err = $this->error;
		if ($noerror || $close_on_error) {
			$this->close();
			$this->error = $err;
		}
		return $noerror;
	}
	public function recipient($address, $dsn = '')
	{
		if (empty($dsn)) {
			$rcpt = "\x52\103\120\124\x20\x54\117\x3a\x3c" . $address . "\x3e";
		} else {
			$dsn = strtoupper($dsn);
			$notify = array();
			if (strpos($dsn, "\x4e\105\x56\x45\x52") !== false) {
				$notify[] = "\x4e\x45\126\105\x52";
			} else {
				foreach (array("\123\125\103\x43\105\x53\x53", "\x46\101\111\114\125\122\x45", "\104\105\114\101\131") as $value) {
					if (strpos($dsn, $value) !== false) {
						$notify[] = $value;
					}
				}
			}
			$rcpt = "\x52\103\x50\124\40\x54\117\72\74" . $address . "\x3e\40\116\117\x54\x49\x46\x59\x3d" . implode("\54", $notify);
		}
		return $this->sendCommand("\x52\103\x50\124\40\124\x4f", $rcpt, array(250, 251));
	}
	public function reset()
	{
		return $this->sendCommand("\x52\123\x45\x54", "\122\123\105\124", 250);
	}
	protected function sendCommand($command, $commandstring, $expect)
	{
		if (!$this->connected()) {
			$this->setError("\103\141\154\154\x65\144\40{$command}\40\x77\151\x74\x68\157\165\x74\40\142\145\151\156\147\40\x63\157\156\156\145\143\164\145\144");
			return false;
		}
		if (strpos($commandstring, "\xa") !== false || strpos($commandstring, "\xd") !== false) {
			$this->setError("\x43\x6f\x6d\x6d\141\x6e\x64\x20\x27{$command}\47\40\x63\157\x6e\x74\141\x69\x6e\x65\144\x20\154\x69\x6e\x65\40\142\162\145\141\153\163");
			return false;
		}
		$this->client_send($commandstring . static::LE, $command);
		$this->last_reply = $this->get_lines();
		$matches = array();
		if (preg_match("\x2f\136\50\x5b\x5c\x64\135\x7b\63\175\x29\133\x20\x2d\x5d\x28\x3f\x3a\x28\x5b\134\x64\135\x5c\x2e\133\134\x64\135\134\x2e\133\134\144\x5d\173\61\x2c\x32\175\x29\40\x29\x3f\x2f", $this->last_reply, $matches)) {
			$code = (int) $matches[1];
			$code_ex = count($matches) > 2 ? $matches[2] : null;
			$detail = preg_replace("\57{$code}\x5b\40\55\135" . ($code_ex ? str_replace("\x2e", "\x5c\56", $code_ex) . "\40" : '') . "\x2f\x6d", '', $this->last_reply);
		} else {
			$code = (int) substr($this->last_reply, 0, 3);
			$code_ex = null;
			$detail = substr($this->last_reply, 4);
		}
		$this->edebug("\123\105\x52\x56\x45\x52\40\x2d\x3e\x20\103\114\111\x45\116\124\72\40" . $this->last_reply, self::DEBUG_SERVER);
		if (!in_array($code, (array) $expect, true)) {
			$this->setError("{$command}\40\x63\157\155\155\141\x6e\144\40\x66\x61\x69\x6c\x65\144", $detail, $code, $code_ex);
			$this->edebug("\x53\x4d\x54\120\40\105\x52\122\x4f\x52\72\x20" . $this->error["\145\162\x72\x6f\162"] . "\72\x20" . $this->last_reply, self::DEBUG_CLIENT);
			return false;
		}
		$this->setError('');
		return true;
	}
	public function sendAndMail($from)
	{
		return $this->sendCommand("\123\x41\115\114", "\x53\x41\x4d\x4c\x20\x46\122\117\115\x3a{$from}", 250);
	}
	public function verify($name)
	{
		return $this->sendCommand("\x56\x52\106\131", "\x56\x52\x46\x59\x20{$name}", array(250, 251));
	}
	public function noop()
	{
		return $this->sendCommand("\x4e\x4f\x4f\x50", "\x4e\x4f\117\120", 250);
	}
	public function turn()
	{
		$this->setError("\124\x68\x65\40\x53\115\x54\x50\40\124\125\122\116\40\x63\157\155\x6d\x61\x6e\144\x20\151\163\x20\x6e\157\x74\40\x69\155\160\x6c\x65\x6d\145\x6e\164\x65\144");
		$this->edebug("\123\x4d\124\120\40\x4e\x4f\124\x49\x43\105\72\x20" . $this->error["\x65\x72\x72\x6f\x72"], self::DEBUG_CLIENT);
		return false;
	}
	public function client_send($data, $command = '')
	{
		if (self::DEBUG_LOWLEVEL > $this->do_debug && in_array($command, array("\x55\163\x65\x72\x20\46\x20\120\x61\163\x73\167\157\x72\144", "\125\x73\x65\x72\156\141\155\145", "\120\x61\x73\163\x77\157\x72\x64"), true)) {
			$this->edebug("\103\114\111\x45\x4e\x54\x20\55\76\40\x53\105\122\126\105\122\x3a\x20\133\x63\x72\145\x64\145\156\x74\x69\x61\x6c\163\40\x68\151\x64\144\x65\x6e\x5d", self::DEBUG_CLIENT);
		} else {
			$this->edebug("\x43\114\111\x45\116\x54\40\55\x3e\40\123\x45\122\x56\105\x52\72\40" . $data, self::DEBUG_CLIENT);
		}
		set_error_handler(array($this, "\145\x72\x72\x6f\x72\110\x61\156\x64\154\x65\x72"));
		$result = fwrite($this->smtp_conn, $data);
		restore_error_handler();
		return $result;
	}
	public function getError()
	{
		return $this->error;
	}
	public function getServerExtList()
	{
		return $this->server_caps;
	}
	public function getServerExt($name)
	{
		if (!$this->server_caps) {
			$this->setError("\116\x6f\40\x48\x45\x4c\117\57\x45\110\114\117\x20\x77\141\x73\40\163\x65\156\164");
			return;
		}
		if (!array_key_exists($name, $this->server_caps)) {
			if ("\110\x45\114\x4f" === $name) {
				return $this->server_caps["\x45\x48\114\x4f"];
			}
			if ("\105\x48\114\117" === $name || array_key_exists("\105\110\114\117", $this->server_caps)) {
				return false;
			}
			$this->setError("\x48\x45\114\117\40\x68\x61\x6e\x64\x73\x68\141\153\145\x20\x77\x61\x73\x20\165\x73\x65\x64\x3b\40\116\157\40\x69\156\x66\157\x72\x6d\x61\x74\151\x6f\x6e\x20\141\142\x6f\165\x74\40\x73\145\x72\x76\145\162\40\145\x78\164\x65\156\163\x69\157\x6e\163\x20\x61\x76\x61\x69\x6c\x61\x62\x6c\x65");
			return;
		}
		return $this->server_caps[$name];
	}
	public function getLastReply()
	{
		return $this->last_reply;
	}
	protected function get_lines()
	{
		if (!is_resource($this->smtp_conn)) {
			return '';
		}
		$data = '';
		$endtime = 0;
		stream_set_timeout($this->smtp_conn, $this->Timeout);
		if ($this->Timelimit > 0) {
			$endtime = time() + $this->Timelimit;
		}
		$selR = array($this->smtp_conn);
		$selW = null;
		while (is_resource($this->smtp_conn) && !feof($this->smtp_conn)) {
			set_error_handler(array($this, "\145\x72\x72\x6f\162\x48\141\156\144\x6c\145\162"));
			$n = stream_select($selR, $selW, $selW, $this->Timelimit);
			restore_error_handler();
			if ($n === false) {
				$message = $this->getError()["\x64\x65\x74\141\151\154"];
				$this->edebug("\123\115\124\120\40\x2d\76\40\x67\145\164\x5f\x6c\151\x6e\145\163\50\51\72\x20\x73\x65\154\x65\x63\164\x20\146\x61\151\x6c\x65\x64\40\50" . $message . "\51", self::DEBUG_LOWLEVEL);
				if (stripos($message, "\x69\156\164\x65\162\162\165\160\164\145\144\x20\163\171\163\x74\x65\155\40\143\x61\154\x6c") !== false) {
					$this->edebug("\123\115\x54\120\x20\55\76\x20\147\145\x74\137\x6c\151\x6e\x65\x73\50\x29\72\40\162\x65\x74\x72\x79\151\x6e\147\x20\x73\x74\x72\x65\141\155\137\163\145\154\x65\143\x74", self::DEBUG_LOWLEVEL);
					$this->setError('');
					continue;
				}
				break;
			}
			if (!$n) {
				$this->edebug("\123\115\x54\x50\40\x2d\x3e\40\147\x65\x74\x5f\154\x69\x6e\x65\x73\50\x29\72\40\163\145\x6c\x65\143\164\40\164\x69\155\145\x64\x2d\x6f\x75\164\x20\151\x6e\x20\50" . $this->Timelimit . "\40\x73\145\143\x29", self::DEBUG_LOWLEVEL);
				break;
			}
			$str = @fgets($this->smtp_conn, self::MAX_REPLY_LENGTH);
			$this->edebug("\123\115\124\120\40\x49\116\102\x4f\x55\x4e\x44\72\40\x22" . trim($str) . "\x22", self::DEBUG_LOWLEVEL);
			$data .= $str;
			if (!isset($str[3]) || $str[3] === "\x20" || $str[3] === "\xd" || $str[3] === "\12") {
				break;
			}
			$info = stream_get_meta_data($this->smtp_conn);
			if ($info["\164\151\x6d\145\144\x5f\157\x75\164"]) {
				$this->edebug("\x53\115\124\x50\x20\x2d\76\40\x67\x65\x74\137\x6c\x69\156\145\x73\x28\51\72\x20\x73\164\162\145\x61\x6d\40\164\x69\x6d\x65\x64\55\157\x75\164\x20\50" . $this->Timeout . "\x20\x73\145\x63\51", self::DEBUG_LOWLEVEL);
				break;
			}
			if ($endtime && time() > $endtime) {
				$this->edebug("\123\115\x54\120\x20\x2d\x3e\40\147\x65\x74\x5f\x6c\151\156\x65\x73\50\51\72\x20\164\151\x6d\145\x6c\x69\155\x69\164\40\162\x65\x61\x63\x68\x65\x64\x20\x28" . $this->Timelimit . "\x20\x73\145\143\x29", self::DEBUG_LOWLEVEL);
				break;
			}
		}
		return $data;
	}
	public function setVerp($enabled = false)
	{
		$this->do_verp = $enabled;
	}
	public function getVerp()
	{
		return $this->do_verp;
	}
	protected function setError($message, $detail = '', $smtp_code = '', $smtp_code_ex = '')
	{
		$this->error = array("\x65\x72\x72\157\x72" => $message, "\144\x65\164\x61\151\154" => $detail, "\x73\x6d\164\x70\x5f\143\157\x64\145" => $smtp_code, "\163\155\164\x70\x5f\143\x6f\x64\x65\137\145\x78" => $smtp_code_ex);
	}
	public function setDebugOutput($method = "\145\x63\150\x6f")
	{
		$this->Debugoutput = $method;
	}
	public function getDebugOutput()
	{
		return $this->Debugoutput;
	}
	public function setDebugLevel($level = 0)
	{
		$this->do_debug = $level;
	}
	public function getDebugLevel()
	{
		return $this->do_debug;
	}
	public function setTimeout($timeout = 0)
	{
		$this->Timeout = $timeout;
	}
	public function getTimeout()
	{
		return $this->Timeout;
	}
	protected function errorHandler($errno, $errmsg, $errfile = '', $errline = 0)
	{
		$notice = "\103\157\156\x6e\x65\143\x74\x69\x6f\156\x20\x66\x61\151\x6c\x65\144\x2e";
		$this->setError($notice, $errmsg, (string) $errno);
		$this->edebug("{$notice}\x20\x45\162\x72\157\x72\x20\43{$errno}\72\x20{$errmsg}\40\133{$errfile}\x20\154\x69\x6e\x65\x20{$errline}\135", self::DEBUG_CONNECTION);
	}
	protected function recordLastTransactionID()
	{
		$reply = $this->getLastReply();
		if (empty($reply)) {
			$this->last_smtp_transaction_id = null;
		} else {
			$this->last_smtp_transaction_id = false;
			foreach ($this->smtp_transaction_id_patterns as $smtp_transaction_id_pattern) {
				$matches = array();
				if (preg_match($smtp_transaction_id_pattern, $reply, $matches)) {
					$this->last_smtp_transaction_id = trim($matches[1]);
					break;
				}
			}
		}
		return $this->last_smtp_transaction_id;
	}
	public function getLastTransactionID()
	{
		return $this->last_smtp_transaction_id;
	}
}
