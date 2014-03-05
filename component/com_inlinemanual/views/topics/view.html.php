<?php

defined('_JEXEC') or die;

class InlineManualViewTopics extends JViewLegacy
{
	protected $items;

	protected $pagination;

	/**
	 * Display the view
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 */
	public function display($tpl = null)
	{
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');

    InlineManualHelper::addSubmenu('topics');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));

			return false;
		}

		$this->addToolbar();

		$this->sidebar = JHtmlSidebar::render();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function addToolbar()
	{
		JToolbarHelper::title('InlineManual');

    JToolbarHelper::divider();
    JToolbarHelper::publish('topics.enable', 'Enable', true);
    JToolbarHelper::unpublish('topics.disable', 'Disable', true);
    JToolbarHelper::custom('tooics.update', 'unblock.png', 'unblock_f2.png', 'Update', true);
    JToolbarHelper::custom('topics.download', 'unblock.png', 'unblock_f2.png', 'Update All', false);
    JToolbarHelper::divider();

    JToolbarHelper::preferences('com_inlinemanual');
	}

}
