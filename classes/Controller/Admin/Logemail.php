<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Logemail extends Controller_Admin_Common {
	
	public function action_index(){
		//
		$today = [date('Y'),date('m'),date('d')];
		list($y,$m,$d) = $today;
		if($s=Arr::get($_GET,'date')) if(preg_match("/^(\\d{4})(\\d{2})(\\d{2})$/",$s,$p)) list($y,$m,$d) = array($p[1],$p[2],$p[3]);
		//profilertoolbar::adddata([$today,$y,$m,$d]);
		
		//$dir = APPPATH.'logs/email/'.date('Y_m');
		//$file = date('d').'.log';
		$path = sprintf("%slogs/email/%d_%d/%d.log",APPPATH,$y,$m,$d);
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
		// get list of days
		$filelist = glob(APPPATH.'logs/email/*/*.log'); $daylist=[];
		if($filelist) foreach($filelist as $path){
			preg_match('/^(\/.*)*\/(\\d{4})_(\\d{2})\/(\\d{2})\.log$/',$path,$p);
			$p[5] = ([$y,$m,$d] == [$p[2],$p[3],$p[4]]); // active flag
			profilertoolbar::adddata([[$y,$m,$d],[$p[2],$p[3],$p[4]]]);
			$daylist[]= $p;
			} else $daylist=null;
		$this->view->daylist = $daylist;
//		profilertoolbar::adddata($this->view);
//		profilertoolbar::adddata($filelist);
		profilertoolbar::adddata($daylist);

		}
	/*public function action*/
	}
