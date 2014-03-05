<?php

defined('_JEXEC') or die;

class InlineManualController extends JControllerLegacy
{
  protected $default_view = 'topics';

  public function display($cachable = false, $urlparams = false)
  {
    parent::display();
    return $this;
  }
}
