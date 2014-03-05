<?php

defined('_JEXEC') or die;

/**
 * InlineManual component helper.
 */
class InlineManualHelper
{

  /**
   * Configure the Linkbar.
   *
   * @param   string  $viewName  The name of the active view.
   *
   * @return  void
   */
  public static function addSubmenu($viewName)
  {
    JHtmlSidebar::addEntry(
                  'Topics',
                  'index.php?option=com_inlinemanual&view=topics',
                  $viewName == 'topics'
    );

    JHtmlSidebar::addEntry(
                  'Permissions',
                  'index.php?option=com_inlinemanual&view=permissions',
                  $viewName == 'permissions'
    );
  }

}
