<?php

defined('_JEXEC') or die;

class InlineManualModelTopic extends JModelAdmin
{
  protected $text_prefix = 'COM_INLINEMANUAL';

  public function getTable($type = 'Topic', $prefix = 'InlinemanualTable', $config = array())
  {
    return JTable::getInstance($type, $prefix, $config);
  }

  public function getForm($data = array(), $loadData = true)
  {
    // not implemented
  }

  protected function loadFormData()
  {
    // not implemented
  }

  protected function prepareTable($table)
  {
    $table->title = htmlspecialchars_decode($table->title, ENT_QUOTES);
  }

  /**
   * Method to get a single record.
   *
   * @param   integer  $pk  The id of the primary key.
   *
   * @return  mixed    Object on success, false on failure.
   *
   * @since   12.2
   */
  public function getItemByTid($tid = null)
  {
    $table = $this->getTable();


    if ($tid > 0)
    {
      // Attempt to load the row.
      $return = $table->load(array('tid' => $tid));

      // Check for a table object error.
      if ($return === false && $table->getError())
      {
        $this->setError($table->getError());
        return false;
      }
    }

    // Convert to the JObject before adding other data.
    $properties = $table->getProperties(1);
    $item = JArrayHelper::toObject($properties, 'JObject');

    if (property_exists($item, 'params'))
    {
      $registry = new JRegistry;
      $registry->loadString($item->params);
      $item->params = $registry->toArray();
    }

    return $item;
  }
}
