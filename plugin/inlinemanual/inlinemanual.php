<?php

defined('_JEXEC') or die;

class PlgSystemInlineManual extends JPlugin
{

  /**
   * onBeforeRender - triggered before framework renders the application.
   */
  public function onBeforeRender()
  {
    // Check the display options
    $mainframe = JFactory::getApplication();
    $application  = $this->params->get('application', 'both');
    switch($application) {
      case 'admin':
        if ($mainframe->isSite()) return;
        break;

      case 'site':
        if ($mainframe->isAdmin()) return;
        break;
    }

    // Load translation anywhere
    $language = JFactory::getLanguage();
    $language->load('plg_system_inlinemanual', JPATH_ADMINISTRATOR);

    // Prepare data
    $backgroundColor = $this->params->get('backgroundColor', '#222222');
    $textColor = $this->params->get('textColor', '#FFFFFF');
    $user = JFactory::getUser();
    $base_path = JURI::base(true) . '/';
    $config = json_encode(
      array(
        'basePath' => $base_path,
        'variables' => array(
          'user_id' => $user->id
        ),
        'l10n' => array(
          'title' => JText::_('PLG_SYSTEM_INLINEMANUAL_TITLE'),
          'refresh' => JText::_('PLG_SYSTEM_INLINEMANUAL_REFRESH'),
          'backToTopics' => JText::_('PLG_SYSTEM_INLINEMANUAL_BACK'),
          'scrollUp' => JText::_('PLG_SYSTEM_INLINEMANUAL_SCROLL_UP'),
          'scrollDown' => JText::_('PLG_SYSTEM_INLINEMANUAL_SCROLL_DOWN'),
          'progress' => JText::_('PLG_SYSTEM_INLINEMANUAL_PROGRESS'),
          'poweredBy' => JText::_('PLG_SYSTEM_INLINEMANUAL_POWERED_BY'),
          'prev' => JText::_('PLG_SYSTEM_INLINEMANUAL_PREV'),
          'next' => JText::_('PLG_SYSTEM_INLINEMANUAL_NEXT'),
          'end' => JText::_('PLG_SYSTEM_INLINEMANUAL_END')
        ),
        'topics' => $this->getTopics(),
      )
    );

    // Inject needed javascript and files
    $document = JFactory::getDocument();
    $document->addStyleSheet('https://inlinemanual.com/inm/player/css/inm.tour.min.css');
    $document->addScript('https://inlinemanual.com/inm/player/js/inm.tour.min.js');
    $document->addScriptDeclaration("jQuery(document).ready(function() { new InmTour($config); })");
    $document->addStyleDeclaration("#InmPlayerWrapper .panel-heading { background-color: $backgroundColor; color: $textColor; }");
  }

  /**
   * Returns a list of topics ordered by title
   */
  protected function getTopics() {
    $db = JFactory::getDBO();
    $query = $db->getQuery(true);
    $query->select('tid, title, description, published, version, steps');
    $query->from('#__inlinemanual_topics');
    $query->where('published = 1');
    $query->order('title ASC');

    $db->setQuery((string) $query);
    $topics = $db->loadObjectList();
    $topic_list = array();

    if ($topics){
      foreach($topics as &$topic)
      {
        $topic->steps = unserialize($topic->steps);
        $topic_list[$topic->tid] = $topic;
      }
    }

    return $topic_list;
  }
}
