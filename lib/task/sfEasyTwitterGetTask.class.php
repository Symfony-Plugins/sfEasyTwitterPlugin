<?php

class sfEasyTwitterGetTask extends sfBaseTask
{
  protected function configure()
  {
    $this->addArguments(array(
       new sfCommandArgument('account', sfCommandArgument::REQUIRED, 'Twitter account to use. May be an app.yml configured account or a login:password string.'),
    ));

    $this->addOptions(array(
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'prod'),
      new sfCommandOption('count', null, sfCommandOption::PARAMETER_REQUIRED, 'How many post you want', 10),
      new sfCommandOption('with_friends', null, sfCommandOption::PARAMETER_REQUIRED, 'Do you want friends\' posts too', false),
    ));

    $this->namespace        = 'easy_twitter';
    $this->name             = 'get';
    $this->briefDescription = 'Retrieve last posts on a given twitter account.';
    $this->detailedDescription = <<<EOF
    TODO: write some extended description here.
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $twitter = sfEasyTwitter::getInstance();

    if (false !== strpos($arguments['account'], ':'))
    {
      list($user, $password) = explode(':', $arguments['account']);
      $twitter->setAccount($user, $password);
    }
    else
    {
      $twitter->setAccountFromConfig($arguments['account']);
    }

    print_r($twitter->load($options['with_friends']));
  }
}
