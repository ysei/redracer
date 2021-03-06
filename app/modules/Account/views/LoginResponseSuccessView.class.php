<?php

class Account_LoginResponseSuccessView extends RedBaseView
{
	public function executeHtml(AgaviRequestDataHolder $rd)
	{
		if ($this->us->removeAttribute('remember', 'org.redracer.login') ) {
			$this->us->addFlash(sprintf('Remember cookie saved on your computer for %s! You will be logged in automatically on your next visits.', AgaviConfig::get('org.redracer.config.account.autologin_lifetime') ), 'notice');

			$this->rs->setCookie('remember', $this->us->createToken(), AgaviConfig::get('org.redracer.config.account.autologin_lifetime') );
		}

		if ($this->us->hasAttribute('redirect', 'org.redracer.login') ) {
			return $this->redirect($this->us->removeAttribute('redirect', 'org.redracer.login'));
		}

		return $this->redirect($this->rt->gen('index') );
	}
}

?>