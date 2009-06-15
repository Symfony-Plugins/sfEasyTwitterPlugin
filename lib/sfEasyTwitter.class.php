<?php

require_once dirname(__FILE__).'/vendor/BaseTwitter.class.php';

class sfEasyTwitter extends Twitter
{
  static protected
    $instance = null,
    $accounts = null;

  /**
   * getInstance
   *
   * Convert TwitterPHP into a singleton. Th original library can still be used
   * as multiple instance, but this is useless/wastefull.
   *
   * @return void
   */
  static public function getInstance()
  {
    if (is_null(self::$instance))
    {
      self::$instance = new self('', '');
    }

    return self::$instance;
  }

  public function setAccount($user, $pass)
  {
    $this->user = $user;
    $this->pass = $pass;
  }

  public function setAccountFromConfig($user)
  {
    if (is_null(self::$accounts))
    {
      self::$accounts = sfConfig::get('app_sfEasyTwitterPlugin_accounts');

      if (!is_array(self::$accounts))
      {
        throw new sfConfigurationException('sfEasyTwitterPlugin configuration problem: the sfEasyTwitterPlugin/accounts app.yml entry must be a login => password array to be able to use sfEasyTwitter\'s setAccountFromConfig method.');
      }
    }

    if (!isset(self::$accounts[$user]))
    {
      throw new InvalidArgumentException(sprintf('Unknown account «%s».', $user));
    }

    $this->setAccount($user, self::$accounts[$user]);
  }
}

