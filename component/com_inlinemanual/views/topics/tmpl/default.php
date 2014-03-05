<?php

defined('_JEXEC') or die;

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
?>
<form action="<?php echo JRoute::_('index.php?option=com_inlinemanual&view=topics');?>" method="post" name="adminForm" id="adminForm">
	<?php if (!empty($this->sidebar)): ?>
		<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
		</div>
		<div id="j-main-container" class="span10">
	<?php else: ?>
		<div id="j-main-container">
	<?php endif; ?>
  <?php if (empty($this->items)): ?>
    No topics.
  <?php else: ?>
    <table class="table table-striped">
      <thead>
      <tr>
        <th width="1%" class="nowrap center">
          <?php echo JHtml::_('grid.checkall'); ?>
        </th>
        <th class="left">
          Title
        </th>
        <th width="15%" class="nowrap center">
          Version
        </th>
        <th width="15%" class="nowrap center">
          State
        </th>
        <th width="15%" class="nowrap center">
          TID
        </th>
      </tr>
      </thead>
      <tfoot>
      <tr>
        <td colspan="5">
          <?php echo $this->pagination->getListFooter(); ?>
        </td>
      </tr>
      </tfoot>
      <tbody>
        <?php foreach ($this->items as $i => $item) : ?>
        <tr class="row<?php echo $i % 2; ?>">
          <td class="center">
            <?php echo JHtml::_('grid.id', $i, $item->id); ?>
          </td>
          <td>
            <?php echo $this->escape($item->title); ?>
          </td>
          <td class="center">
            <?php echo $this->escape($item->version); ?>
          </td>
          <td class="center">
            <?php echo $item->published ? 'Enabled' : 'Disabled' ?>
          </td>
          <td class="center">
            <?php echo $item->tid ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
	  </table>
  <?php endif; ?>
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
