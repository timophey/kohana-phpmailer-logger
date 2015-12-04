<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Logemail extends Controller_Admin_Common {
	
	public function action_index(){
		// get list of days
		$filelist = glob(APPPATH.'logs/email/*/*.log');
		$daylist = ($filelist) ? array_map(function($path){
			preg_match('/^(\/.*)*\/(\\d{4})_(\\d{2})\/(\\d{2})\.log$/',$path,$m);
			return $m;
			},$filelist) : null;
		//profilertoolbar::adddata($filelist);
		//profilertoolbar::adddata($daylist);
		$this->view->daylist = $daylist;
		//
		$dir = APPPATH.'logs/email/'.date('Y_m');
		$file = date('d').'.log';
		$path = "$dir/$file";
		if(file_exists($path)){
			$file_contents = file_get_contents($path);
			$strings = explode("\r\n",$file_contents);
			if($strings){
				$this->view->items = array_map(function($str){
					$assoc = json_decode($str,true);
					$assoc['datetime']=date('Y-m-d H:i:s',$assoc['timestamp']);
					//profilertoolbar::adddata($assoc);
					return $assoc;
					},$strings);
				}
			}
		}
	/*public function action*/
	}
