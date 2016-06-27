<?php

$username = (isset($_POST['username'])) ? htmlspecialchars($_POST['username']) : '';
$email = (isset($_POST['email'])) ? htmlspecialchars($_POST['email']) : '';

	if (isset($_POST['new_user'])) {
		//This should never return false but just in case.
		if (isset($_SESSION['ytbuser'])){
			$User = unserialize($_SESSION['ytbuser']);
			$auth = $User->getAuth();
			$ClaimedUser = $User->getUsername();
					
			if ($auth) {
				$_POST['username'] = (string)$User->getUsername();
				$_POST['email'] = (string)$User->getEmail();
				$_POST['password'] = (string)$User->getID();
				$settings = new Settings();
				$ans = $settings->new_user($_POST);
				if ($ans === true) {
					$_SESSION['alert'] = array('text' => Trad::A_SUCCESS_SIGNUP, 'type' => 'alert-success');
					header('Location: '.Url::parse('home'));
					exit;
				} else {
					$this->addAlert($ans);
				}
			}
		} else {
			header("Location: https://secure.domain.com"); //Change this to URL of PlexAuth
			die();
		}
	}

$title = Trad::V_SIGNUP;

$content = '

<h1>'.Trad::V_SIGNUP.'</h1>

<form action="'.Url::parse('signup').'" method="post" class="form form-signup">
	<label for="username2">Plex '.Trad::F_USERNAME.'</label>
	<input type="text" name="username" id="username2" class="input-normal" value="'.$User->getUsername().'" readonly/>
	<div class="form-actions">
		<input type="hidden" name="token" value="'.getToken().'" />
		<input type="hidden" name="new_user" value="1" />
		<button type="submit" class="btn btn-primary">'.Trad::V_SIGNUP.'</button>
	</div>
</form>

';

?>