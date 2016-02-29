<div class="page-header">	<h1>		<span><?php echo lang('location:provinsi:plural'); ?></span>	</h1>		<div class="btn-group content-toolbar">		<a class="btn btn-yellow btn-sm" href="<?php echo site_url('location/provinsi/create'); ?>">			<i class="icon-plus"></i>			<span class="no-text-shadow"><?php echo lang('location:provinsi:new'); ?></span>		</a>	</div></div><fieldset>	<legend><?php echo lang('global:filters') ?></legend>		<?php echo form_open('', array('class' => 'form-inline', 'method' => 'get'), array('f_module' => $module_details['slug'])) ?>		<div class="form-group">			<label><?php echo lang('location:kode'); ?>:&nbsp;</label>			<input type="text" name="f-kode" value="<?php echo $this->input->get('f-kode'); ?>">		</div>		<div class="form-group">			<label><?php echo lang('location:nama'); ?>:&nbsp;</label>			<input type="text" name="f-nama" value="<?php echo $this->input->get('f-nama'); ?>">		</div>		<div class="form-group">			<label><?php echo lang('location:slug'); ?>:&nbsp;</label>			<input type="text" name="f-slug" value="<?php echo $this->input->get('f-slug'); ?>">		</div>		<button href="<?php echo current_url() . '#'; ?>" class="btn btn-primary btn-xs" type="submit">			<i class="icon-ok"></i>			<?php echo lang('buttons:submit'); ?>		</button>				<button href="<?php echo current_url() . '#'; ?>" class="btn btn-danger btn-xs" type="reset">			<i class="icon-remove"></i>			<?php echo lang('buttons:clear'); ?>		</button>	<?php echo form_close() ?></fieldset><hr /><?php if ($provinsi['total'] > 0): ?>		<p class="pull-right"><?php echo lang('location:showing').' '.count($provinsi['entries']).' '.lang('location:of').' '.$provinsi['total'] ?></p>		<table class="table table-striped table-bordered table-hover">		<thead>			<tr>				<th>No</th>				<th><?php echo lang('location:kode'); ?></th>				<th><?php echo lang('location:nama'); ?></th>				<th><?php echo lang('location:slug'); ?></th>				<th><?php echo lang('location:created'); ?></th>				<th><?php echo lang('location:updated'); ?></th>				<th><?php echo lang('location:created_by'); ?></th>				<th></th>			</tr>		</thead>		<tbody>			<?php 			$cur_page = (int) $this->uri->segment($pagination_config['uri_segment']);			if($cur_page != 0){				$item_per_page = $pagination_config['per_page'];				$no = (($cur_page -1) * $item_per_page) + 1;			}else{				$no = 1;			}			?>						<?php foreach ($provinsi['entries'] as $provinsi_entry): ?>			<tr>				<td><?php echo $no; $no++; ?></td>				<td><?php echo $provinsi_entry['kode']; ?></td>				<td><?php echo $provinsi_entry['nama']; ?></td>				<td><?php echo $provinsi_entry['slug']; ?></td>							<?php if($provinsi_entry['created']){ ?>				<td><?php echo format_date($provinsi_entry['created'], 'd-m-Y G:i'); ?></td>				<?php }else{ ?>				<td>-</td>				<?php } ?>								<?php if($provinsi_entry['updated']){ ?>				<td><?php echo format_date($provinsi_entry['updated'], 'd-m-Y G:i'); ?></td>				<?php }else{ ?>				<td>-</td>				<?php } ?>								<td><?php echo user_displayname($provinsi_entry['created_by'], true); ?></td>				<td class="actions">				<?php 								echo anchor('location/provinsi/view/' . $provinsi_entry['id'], lang('global:view'), 'class="btn btn-xs btn-info view"');								echo anchor('location/provinsi/edit/' . $provinsi_entry['id'], lang('global:edit'), 'class="btn btn-xs btn-info edit"');								echo anchor('location/provinsi/delete/' . $provinsi_entry['id'], lang('global:delete'), array('class' => 'confirm btn btn-xs btn-danger delete'));								?>				</td>			</tr>			<?php endforeach; ?>		</tbody>	</table>		<?php echo $provinsi['pagination']; ?>	<?php else: ?>	<div class="well"><?php echo lang('location:provinsi:no_entry'); ?></div><?php endif;?>