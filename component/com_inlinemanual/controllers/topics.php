<?php

defined('_JEXEC') or die;

class InlineManualControllerTopics extends JControllerAdmin
{
  protected $text_prefix = 'COM_INLINE_MANUAL_TOPICS';

	public function __construct($config = array())
	{
		parent::__construct($config);
	}

  public function getModel($name = 'Topic', $prefix = 'InlineManualModel', $config = array('ignore_request' => true))
  {
    $model = parent::getModel($name, $prefix, $config);
    return $model;
  }

  public function download()
  {
    // Check for request forgeries.
    JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

    $this->initializeInlineManualApi();
    $model = $this->getModel();

    try {
      $topic_list = InlineManual_Site::fetchAllTopics();
      foreach ($topic_list as $topic_item) {
        $rem_topic = InlineManual_Site::fetchTopic($topic_item->id);
        $loc_topic = $model->getItemByTid($topic_item->id);
        if ($rem_topic) {
          if ($loc_topic) {
            $data['id'] = $loc_topic->id;
          }
          $data['tid'] = $rem_topic->id;
          $data['title'] = $rem_topic->title;
          $data['version'] = $rem_topic->version;
          $data['steps'] = serialize($rem_topic->steps);
          $data['timestamp'] = time();
          if ($model->save($data)) {
            $msg[] = $topic_item->title;
          }
          else {
            $this->setMessage(implode('<br>', $model->getErrors()), 'error');
          }
        }
      }
      if (!empty($msg)) {
        $this->setMessage('Downloaded topics: ' .  implode(', ', $msg));
      }
    }
    catch (InlineManual_Error $e) {
      $this->setMessage($e->getMessage());
    }

    $this->setRedirect('index.php?option=com_inlinemanual&view=topics');
  }


	public function update()
	{
		// Check for request forgeries.
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		$ids    = $this->input->get('id', array(), 'array');
		$values = array('update' => 1);
		$task   = $this->getTask();
		$value  = JArrayHelper::getValue($values, $task, 0, 'int');

		if (empty($ids))
		{
			JError::raiseWarning(500, 'No topics selected');
		}
		else
		{
			// Get the model.
			$model = $this->getModel();

      $this->initializeInlineManualApi();

      try {
        foreach($ids as $id) {
          $topic = InlineManual_Site::fetchTopics($id);
          $info[] = "$topic->id: $topic->title\n";
        }
        $this->setMessage(implode('<br>', $info));
        //$this->setMessage(count($ids) . ' topics were updated');
      }
      catch (InlineManual_Error $e) {
        $this->setMessage($e->getMessage(), 'error');
      }

			// Change the state of the records.
			if (!$model->updateFromApi($ids, $value))
			{
				JError::raiseWarning(500, $model->getError());
			}
			else
			{
        $this->setMessage(count($ids) . ' topics were updated');
			}
		}

		$this->setRedirect('index.php?option=com_inlinemanual&view=topics');
	}

  protected function initializeInlineManualApi() {
    InlineManual::$site_api_key = JComponentHelper::getParams('com_inlinemanual')->get('siteKey');
  }

}
