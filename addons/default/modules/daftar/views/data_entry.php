<div class="page-header">
	<h1>
		<span><?php echo lang('daftar:data:view'); ?></span>
	</h1>
	
	<div class="btn-group content-toolbar">
		
		<a href="<?php echo site_url('daftar/data/index'); ?>" class="btn btn-sm btn-default">
			<i class="icon-arrow-left"></i>
			<?php echo lang('daftar:back') ?>
		</a>

		<?php if(group_has_role('daftar', 'edit_all_data')){ ?>
			<a href="<?php echo site_url('daftar/data/edit/'.$data['id']); ?>" class="btn btn-sm btn-default">
				<i class="icon-edit"></i>
				<?php echo lang('global:edit') ?>
			</a>
		<?php }elseif(group_has_role('daftar', 'edit_own_data')){ ?>
			<?php if($data->created_by_user_id == $this->current_user->id){ ?>
				<a href="<?php echo site_url('daftar/data/edit/'.$data['id']); ?>" class="btn btn-sm btn-default">
					<i class="icon-edit"></i>
					<?php echo lang('global:edit') ?>
				</a>
			<?php } ?>
		<?php } ?>

		<?php if(group_has_role('daftar', 'delete_all_data')){ ?>
			<a href="<?php echo site_url('daftar/data/delete/'.$data['id']); ?>" class="confirm btn btn-sm btn-danger">
				<i class="icon-trash"></i>
				<?php echo lang('global:delete') ?>
			</a>
		<?php }elseif(group_has_role('daftar', 'delete_own_data')){ ?>
			<?php if($data->created_by_user_id == $this->current_user->id){ ?>
				<a href="<?php echo site_url('daftar/data/delete/'.$data['id']); ?>" class="confirm btn btn-sm btn-danger">
					<i class="icon-trash"></i>
					<?php echo lang('global:delete') ?>
				</a>
			<?php } ?>
		<?php } ?>
		
	</div>
</div>

<div>
	<div class="row">
		<div class="entry-label col-sm-2">ID</div>
		<div class="entry-value col-sm-8"><?php echo $data['id']; ?></div>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('daftar:id'); ?></div>
		<?php if(isset($data['id'])){ ?>
		<div class="entry-value col-sm-8"><?php echo $data['id']; ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('daftar:nama'); ?></div>
		<?php if(isset($data['nama'])){ ?>
		<div class="entry-value col-sm-8"><?php echo $data['nama']; ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('daftar:status'); ?></div>
		<?php if(isset($data['status'])){ ?>
		<div class="entry-value col-sm-8"><?php echo $data['status']; ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('daftar:form'); ?></div>
		<?php if(isset($data['form'])){ ?>
		<div class="entry-value col-sm-8"><?php echo $data['form']; ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('daftar:created'); ?></div>
		<?php if(isset($data['created'])){ ?>
		<div class="entry-value col-sm-8"><?php echo format_date($data['created'], 'd-m-Y G:i'); ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('daftar:updated'); ?></div>
		<?php if(isset($data['updated'])){ ?>
		<div class="entry-value col-sm-8"><?php echo format_date($data['updated'], 'd-m-Y G:i'); ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('daftar:created_by'); ?></div>
		<div class="entry-value col-sm-8"><?php echo user_displayname($data['created_by'], true); ?></div>
	</div>
</div>