<?php

defined('_JEXEC') or die;

class InlineManualModelTopics extends JModelList
{
  public function __construct($config = array())
  {
    if (empty($config['filter_fields']))
    {
      $config['filter_fields'] = array(
        'id', 'a.id',
        'tid', 'a.tid',
        'title', 'a.title',
        'description', 'a.description',
        'steps', 'a.steps',
        'published', 'a.published',
        'timestamp', 'a.timestamp',
        'version', 'a.version',
      );
    }
    parent::__construct($config);
  }

  protected function getListQuery()
  {
    $db = $this->getDbo();
    $query = $db->getQuery(true);
    $query->select(
      $this->getState(
       'list.select',
       'a.id, a.tid, a.title, a.description, a.steps, a.published, a.version, a.timestamp'
      )
    );
    $query->from($db->quoteName('#__inlinemanual_topics').' AS a');
    return $query;
  }
}
