<div class="page-header">
	<h1>
		<span><?php echo lang('location:kelurahan:view'); ?></span>
	</h1>
	
	<div class="btn-group content-toolbar">
		
		<a href="<?php echo site_url('location/kelurahan/index'); ?>" class="btn btn-sm btn-default">
			<i class="icon-arrow-left"></i>
			<?php echo lang('location:back') ?>
		</a>

		<?php if(group_has_role('location', 'edit_all_kelurahan')){ ?>
			<a href="<?php echo site_url('location/kelurahan/edit/'.$kelurahan['id']); ?>" class="btn btn-sm btn-default">
				<i class="icon-edit"></i>
				<?php echo lang('global:edit') ?>
			</a>
		<?php }elseif(group_has_role('location', 'edit_own_kelurahan')){ ?>
			<?php if($kelurahan->created_by_user_id == $this->current_user->id){ ?>
				<a href="<?php echo site_url('location/kelurahan/edit/'.$kelurahan['id']); ?>" class="btn btn-sm btn-default">
					<i class="icon-edit"></i>
					<?php echo lang('global:edit') ?>
				</a>
			<?php } ?>
		<?php } ?>

		<?php if(group_has_role('location', 'delete_all_kelurahan')){ ?>
			<a href="<?php echo site_url('location/kelurahan/delete/'.$kelurahan['id']); ?>" class="confirm btn btn-sm btn-danger">
				<i class="icon-trash"></i>
				<?php echo lang('global:delete') ?>
			</a>
		<?php }elseif(group_has_role('location', 'delete_own_kelurahan')){ ?>
			<?php if($kelurahan->created_by_user_id == $this->current_user->id){ ?>
				<a href="<?php echo site_url('location/kelurahan/delete/'.$kelurahan['id']); ?>" class="confirm btn btn-sm btn-danger">
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
		<div class="entry-value col-sm-8"><?php echo $kelurahan['id']; ?></div>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:kode'); ?></div>
		<?php if(isset($kelurahan['kode'])){ ?>
		<div class="entry-value col-sm-8"><?php echo $kelurahan['kode']; ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:nama'); ?></div>
		<?php if(isset($kelurahan['nama'])){ ?>
		<div class="entry-value col-sm-8"><?php echo $kelurahan['nama']; ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:slug'); ?></div>
		<?php if(isset($kelurahan['slug'])){ ?>
		<div class="entry-value col-sm-8"><?php echo $kelurahan['slug']; ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:created'); ?></div>
		<?php if(isset($kelurahan['created'])){ ?>
		<div class="entry-value col-sm-8"><?php echo format_date($kelurahan['created'], 'd-m-Y G:i'); ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:updated'); ?></div>
		<?php if(isset($kelurahan['updated'])){ ?>
		<div class="entry-value col-sm-8"><?php echo format_date($kelurahan['updated'], 'd-m-Y G:i'); ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:created_by'); ?></div>
		<div class="entry-value col-sm-8"><?php echo user_displayname($kelurahan['created_by'], true); ?></div>
	</div>
</div>