<?php

defined('_JEXEC') or die;

JHtml::_('behavior.tabstate');

if (!JFactory::getUser()->authorise('core.manage', 'com_inlinemanual'))
{
  return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

require  __DIR__ . '/lib/InlineManual.php';

JLoader::register('InlineManualHelper', __DIR__ . '/helpers/inlinemanual.php');

$controller	= JControllerLegacy::getInstance('InlineManual');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();

