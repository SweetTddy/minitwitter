<?php
	session_start();

	function print_object($obj)
	{
		echo "<pre>";
		print_r($obj);
		echo "</pre>";
	}
	function po($obj)
	{
		print_object($obj);
	}

	function redirect($url)
	{
		@header("Location:$url");
	}

	function islogin($redirect=true)
	{
		if(!isset($_SESSION['user_id']) && !isset($_COOKIE['user_id']))
		{
			if($redirect == true)
			{
				redirect("index.php?p=login");
			}
			else
			{				
				return true;
			}
		}
		elseif(md5($_SESSION['email']) != $_SESSION['hash'])
		{
			redirect("logout.php");
		}
		return false;
	}

	function set_session_cookie($user)
	{
		$_SESSION['user_id']		= $user['id'];
		$_SESSION['twitter_name']	= isset($user['twitter_name'])?$user['twitter_name']:'';
		$_SESSION['fullname']		= isset($user['fullname'])?$user['fullname']:'';
		$_SESSION['email']			= isset($user['email'])?$user['email']:'';
		$_SESSION['hash']			= md5(isset($user['email'])?$user['email']:'');

		@setcookie("user_id",		$user['id']);
		@setcookie("twitter_name",	$user['twitter_name']);
		@setcookie("fullname",		$user['fullname']);
		@setcookie("email",			$user['email']);
		@setcookie("hash",			md5($user['email']));
	}

	function upload_image($image_field_name, $dir_path, $sizes)
	{
		require_once 'phpthumb/ThumbLib.inc.php';

		$cnt = 1;
		
		$resized_path = $dir_path;
		if (!file_exists($dir_path)) 
		{
			mkdir($dir_path);
			chmod($dir_path, 0755);
		}

		if (!file_exists($resized_path)) 
		{
			mkdir($resized_path);
			chmod($resized_path, 0755);
		}
		if(!empty($_FILES[$image_field_name]['tmp_name']))
		{
			$info = getimagesize($_FILES[$image_field_name]['tmp_name']);		
			$originalfilename = basename($_FILES[$image_field_name]['name']);
			$imagetarget = resolve_filename_collisions($dir_path, array(basename($_FILES[$image_field_name]['name'])), $format='%s_%d.%s');
			$originalfile = $dir_path.$imagetarget[0];			
												
			if(move_uploaded_file($_FILES[$image_field_name]['tmp_name'],$originalfile))
			{
				
				foreach($sizes as $size)
				{
					$destinationfile =  $resized_path.'f'.$cnt++.'_'.$imagetarget[0];
					$thumb = PhpThumbFactory::create($originalfile);
					$thumb->resize($size['width'], $size['height']);
					$thumb->save($destinationfile);				
				}

				return $imagetarget[0];
			}else{
				return 0;
			}
		}
		else
		{
			return 0;
		}
	}

	function resolve_filename_collisions($destination,$files,$format='%s_%d.%s')
	{
		foreach ($files as $k => $f) {
			if (check_potential_filename($destination,$f,$files)) {
				$bits = explode('.', $f);
				for ($i = 1; true; $i++) {
					$try = sprintf($format, $bits[0], $i, $bits[1]);
					if (!check_potential_filename($destination,$try,$files)) {
						$files[$k] = $try;
						break;
					}
				}
			}
		}
		return $files;
	}

	/**
	 * @used by resolve_filename_collisions
	 */
	function check_potential_filename($destination,$filename,$files)
	{
		if (file_exists($destination.'/'.$filename)) {
			return true;
		}
		if (count(array_keys($files,$filename)) > 1) {
			return true;
		}
		return false;
	}

	function jsRedirect($url)
	{
		echo <<<OP
					<script type="text/javascript">
					//<![CDATA[
						function redirect()
						{
							document.location.replace('$url');
						}
						setTimeout("redirect()","100");
					//]]>
					</script>
OP;
	}

	function optional_param($parameter, $default=NULL) 
	{
		if(isset($_POST[$parameter]))
			$param = $_POST[$parameter];
		else if (isset($_GET[$parameter]))
			$param = $_GET[$parameter];
		else
			return $default;

		return $param;
	}
	
	function getRealIpAddr()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
		{
			$ip=$_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
		{
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
			$ip=$_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

	function userTotalTweets($userid=0)
	{
		echo R::count('tweets',' userid = ?',array($userid));		
	}
	
	function userTotalFollowers($userid=0)
	{
		echo R::count('following',' follows = ?',array($userid));		
	}
	
	function userTotalFollowing($userid=0)
	{
		echo R::count('following',' userid = ?',array($userid));		
	}

	function profilePic($userid=0, $size='f1')
	{
		global $CFG;
		$info = R::findOne('user',' id = ?', array($userid));
		if (empty($info->image)) {
			echo '<img alt="'.$info->image.'" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAACDUlEQVR4Xu2Yz6/BQBDHpxoEcfTjVBVx4yjEv+/EQdwa14pTE04OBO+92WSavqoXOuFp+u1JY3d29rvfmQ9r7Xa7L8rxY0EAOAAlgB6Q4x5IaIKgACgACoACoECOFQAGgUFgEBgEBnMMAfwZAgaBQWAQGAQGgcEcK6DG4Pl8ptlsRpfLxcjYarVoOBz+knSz2dB6vU78Lkn7V8S8d8YqAa7XK83ncyoUCjQej2m5XNIPVmkwGFC73TZrypjD4fCQAK+I+ZfBVQLwZlerFXU6Her1eonreJ5HQRAQn2qj0TDukHm1Ws0Ix2O2260RrlQqpYqZtopVAoi1y+UyHY9Hk0O32w3FkI06jkO+74cC8Dh2y36/p8lkQovFgqrVqhFDEzONCCoB5OSk7qMl0Gw2w/Lo9/vmVMUBnGi0zi3Loul0SpVKJXRDmphvF0BOS049+n46nW5sHRVAXMAuiTZObcxnRVA5IN4DJHnXdU3dc+OLP/V63Vhd5haLRVM+0jg1MZ/dPI9XCZDUsbmuxc6SkGxKHCDzGJ2j0cj0A/7Mwti2fUOWR2Km2bxagHgt83sUgfcEkN4RLx0phfjvgEdi/psAaRf+lHmqEviUTWjygAC4EcKNEG6EcCOk6aJZnwsKgAKgACgACmS9k2vyBwVAAVAAFAAFNF0063NBAVAAFAAFQIGsd3JN/qBA3inwDTUHcp+19ttaAAAAAElFTkSuQmCC">';
		}
		else
		{
			echo '<img alt="'.$info->image.'" src="'. $CFG->siteroot.'/uploads/users/f1_'.$info->image.'">';	
		}
		

	}
	function profilePicPath($userid=0, $size='f1')
	{
		global $CFG;
		$info = R::findOne('user',' id = ?', array($userid));

		if (empty($info->image)) {
			return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAACDUlEQVR4Xu2Yz6/BQBDHpxoEcfTjVBVx4yjEv+/EQdwa14pTE04OBO+92WSavqoXOuFp+u1JY3d29rvfmQ9r7Xa7L8rxY0EAOAAlgB6Q4x5IaIKgACgACoACoECOFQAGgUFgEBgEBnMMAfwZAgaBQWAQGAQGgcEcK6DG4Pl8ptlsRpfLxcjYarVoOBz+knSz2dB6vU78Lkn7V8S8d8YqAa7XK83ncyoUCjQej2m5XNIPVmkwGFC73TZrypjD4fCQAK+I+ZfBVQLwZlerFXU6Her1eonreJ5HQRAQn2qj0TDukHm1Ws0Ix2O2260RrlQqpYqZtopVAoi1y+UyHY9Hk0O32w3FkI06jkO+74cC8Dh2y36/p8lkQovFgqrVqhFDEzONCCoB5OSk7qMl0Gw2w/Lo9/vmVMUBnGi0zi3Loul0SpVKJXRDmphvF0BOS049+n46nW5sHRVAXMAuiTZObcxnRVA5IN4DJHnXdU3dc+OLP/V63Vhd5haLRVM+0jg1MZ/dPI9XCZDUsbmuxc6SkGxKHCDzGJ2j0cj0A/7Mwti2fUOWR2Km2bxagHgt83sUgfcEkN4RLx0phfjvgEdi/psAaRf+lHmqEviUTWjygAC4EcKNEG6EcCOk6aJZnwsKgAKgACgACmS9k2vyBwVAAVAAFAAFNF0063NBAVAAFAAFQIGsd3JN/qBA3inwDTUHcp+19ttaAAAAAElFTkSuQmCC';
		}
		else
		{
			return $CFG->siteroot.'/uploads/users/f1_'.$info->image;
		}
		

	}

?>