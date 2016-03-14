<?php defined('SYSPATH') OR die('No direct access allowed.');

class Kohana_Email_Logger extends Kohana_Email{

	public function send(){
		$m = $this->_mailer;
		$m->ErrorInfo = '';
		$result = $m->send();
		$logdata = [
			'timestamp'=>time(),
			'email_to'=>$m->getToAddresses(),
			'sender'=>$m->Sender,
			'subject'=>$m->Subject,
			'attachment'=>$m->getAttachments(),
			'result'=>$result,
			'result_false'=>!$result,
			'error'=>$m->ErrorInfo
			];
		// write logfile
		$dir = APPPATH.'logs/email/'.date('Y_m'); if(!file_exists($dir)) mkdir($dir,0775,true);
		$file = date('d').'.log';
		$path = "$dir/$file"; $fileopen=fopen($path, "a+");
		$data = json_encode($logdata)."\r\n";
		fwrite($fileopen,$data);
		fclose($fileopen);
		// return result we got first
		return $result;
		}

	
	}
