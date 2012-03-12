<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
// load tooltip behavior
JHtml::_('behavior.tooltip');

$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
$db =& JFactory::getDBO();
?>
<form action="<?php echo JRoute::_('index.php?option=com_mams&view=articles'); ?>" method="post" name="adminForm">
	<fieldset id="filter-bar">
		<div class="filter-search fltlft">
			
		</div>
		<div class="filter-select fltrt">
			<select name="filter_published" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.published'), true);?>
			</select>
			<select name="filter_access" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_ACCESS');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('access.assetgroups'), 'value', 'text', $this->state->get('filter.access'));?>
			</select>
			<select name="filter_sec" class="inputbox" onchange="this.form.submit()">
				<option value="*"><?php echo JText::_('COM_MAMS_SELECT_SEC');?></option>
				<?php echo JHtml::_('select.options', MAMSHelper::getSections(), 'value', 'text', $this->state->get('filter.sec'));?>
			</select>

		</div>
	</fieldset>
	
	<div class="clr"> </div>
	
	<table class="adminlist">
		<thead>
			<tr>
				<th width="5">
					<?php echo JText::_('COM_MAMS_ARTICLE_HEADING_ID'); ?>
				</th>
				<th width="20">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
				</th>			
				<th>
					<?php echo JHtml::_('grid.sort','COM_MAMS_ARTICLE_HEADING_TITLE','a.art_title', $listDirn, $listOrder); ?>
				</th>		
				<th width="120">
					<?php echo JHtml::_('grid.sort','COM_MAMS_ARTICLE_HEADING_PUBLISHED','a.art_published', $listDirn, $listOrder); ?>
				</th>		
				<th width="100">
					<?php echo JText::_('COM_MAMS_ARTICLE_HEADING_TAGS'); ?>
				</th>
				<th width="100">
					<?php echo JText::_('COM_MAMS_ARTICLE_HEADING_EXTRAS'); ?>
				</th>
				<th width="120">
					<?php echo JHtml::_('grid.sort','COM_MAMS_ARTICLE_HEADING_ADDED','a.art_added', $listDirn, $listOrder); ?>
				</th>		
				<th width="120">
					<?php echo JHtml::_('grid.sort','COM_MAMS_ARTICLE_HEADING_MODIFIED','a.art_modified', $listDirn, $listOrder); ?>
				</th>	
				<th width="100">
					<?php echo JText::_('COM_MAMS_ARTICLE_HEADING_SECTION'); ?>
				</th>
				<th width="100">
					<?php echo JText::_('JPUBLISHED'); ?>
				</th>
				<th width="100">
					<?php echo JText::_('JGRID_HEADING_ACCESS'); ?>
				</th>
			</tr>
		
		
		</thead>
		<tfoot><tr><td colspan="11"><?php echo $this->pagination->getListFooter(); ?></td></tr></tfoot>
		<tbody>
		<?php foreach($this->items as $i => $item): ?>
			<tr class="row<?php echo $i % 2; ?>">
				<td><?php echo $item->art_id; ?></td>
				<td><?php echo JHtml::_('grid.id', $i, $item->art_id); ?></td>
				<td>
					<a href="<?php echo JRoute::_('index.php?option=com_mams&task=article.edit&art_id='.(int) $item->art_id); ?>">
					<?php echo $this->escape($item->art_title); ?></a>
					<p class="smallsub"><?php echo JText::sprintf('JGLOBAL_LIST_ALIAS', $this->escape($item->art_alias));?></p>
				</td>
				<td><?php echo $item->art_published; ?></td>
				<td><?php 
					//Authors
					echo '<a href="index.php?option=com_mams&view=artauths&filter_article='.$item->art_id.'">Authors ';
					$query = 'SELECT count(*) FROM #__mams_artauth WHERE published >= 1 && aa_art="'.$item->art_id.'"';
					$db->setQuery( $query );
					$num_aa=$db->loadResult();
					echo ' ['.$num_aa.']</a><br />';
					//Categories
					echo '<a href="index.php?option=com_mams&view=artcats&filter_article='.$item->art_id.'">Categories ';
					$query = 'SELECT count(*) FROM #__mams_artcat WHERE published >= 1 && ac_art="'.$item->art_id.'"';
					$db->setQuery( $query );
					$num_ac=$db->loadResult();
					echo ' ['.$num_ac.']</a>';
				?></td>
				<td><?php 
					//Downloads
					echo '<a href="index.php?option=com_mams&view=artdloads&filter_article='.$item->art_id.'">Downloads ';
					$query = 'SELECT count(*) FROM #__mams_artdl WHERE published >= 1 && ad_art="'.$item->art_id.'"';
					$db->setQuery( $query );
					$num_ad=$db->loadResult();
					echo ' ['.$num_ad.']</a><br />';
					//Media
					echo '<a href="index.php?option=com_mams&view=artmedias&filter_article='.$item->art_id.'">Media ';
					$query = 'SELECT count(*) FROM #__mams_artmed WHERE published >= 1 && am_art="'.$item->art_id.'"';
					$db->setQuery( $query );
					$num_am=$db->loadResult();
					echo ' ['.$num_am.']</a>';
				
				?>
				<td><?php echo $item->art_added; ?></td>
				<td><?php echo $item->art_modified; ?></td>
				<td><?php echo $item->sec_name; ?></td>
				<td class="center"><?php echo JHtml::_('jgrid.published', $item->published, $i, 'articles.', true);?></td>
				<td><?php echo $item->access_level; ?></td>
				
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>

