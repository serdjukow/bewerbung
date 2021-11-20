<?php

namespace PHPMailer\PHPMailer;

class Exception extends \Exception
{
	public function errorMessage()
	{
		return "\74\x73\164\x72\157\156\147\x3e" . htmlspecialchars($this->getMessage()) . "\74\x2f\x73\x74\162\x6f\x6e\x67\x3e\74\x62\x72\40\57\x3e\xa";
	}
}
