<div class="page-header">
	<h1>
		<span><?php echo lang('location:kota:view'); ?></span>
	</h1>
	
	<div class="btn-group content-toolbar">
		
		<a href="<?php echo site_url('location/kota/index'); ?>" class="btn btn-sm btn-default">
			<i class="icon-arrow-left"></i>
			<?php echo lang('location:back') ?>
		</a>

		<?php if(group_has_role('location', 'edit_all_kota')){ ?>
			<a href="<?php echo site_url('location/kota/edit/'.$kota['id']); ?>" class="btn btn-sm btn-default">
				<i class="icon-edit"></i>
				<?php echo lang('global:edit') ?>
			</a>
		<?php }elseif(group_has_role('location', 'edit_own_kota')){ ?>
			<?php if($kota->created_by_user_id == $this->current_user->id){ ?>
				<a href="<?php echo site_url('location/kota/edit/'.$kota['id']); ?>" class="btn btn-sm btn-default">
					<i class="icon-edit"></i>
					<?php echo lang('global:edit') ?>
				</a>
			<?php } ?>
		<?php } ?>

		<?php if(group_has_role('location', 'delete_all_kota')){ ?>
			<a href="<?php echo site_url('location/kota/delete/'.$kota['id']); ?>" class="confirm btn btn-sm btn-danger">
				<i class="icon-trash"></i>
				<?php echo lang('global:delete') ?>
			</a>
		<?php }elseif(group_has_role('location', 'delete_own_kota')){ ?>
			<?php if($kota->created_by_user_id == $this->current_user->id){ ?>
				<a href="<?php echo site_url('location/kota/delete/'.$kota['id']); ?>" class="confirm btn btn-sm btn-danger">
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
		<div class="entry-value col-sm-8"><?php echo $kota['id']; ?></div>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:kode'); ?></div>
		<?php if(isset($kota['kode'])){ ?>
		<div class="entry-value col-sm-8"><?php echo $kota['kode']; ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:nama'); ?></div>
		<?php if(isset($kota['nama'])){ ?>
		<div class="entry-value col-sm-8"><?php echo $kota['nama']; ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:slug'); ?></div>
		<?php if(isset($kota['slug'])){ ?>
		<div class="entry-value col-sm-8"><?php echo $kota['slug']; ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:created'); ?></div>
		<?php if(isset($kota['created'])){ ?>
		<div class="entry-value col-sm-8"><?php echo format_date($kota['created'], 'd-m-Y G:i'); ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:updated'); ?></div>
		<?php if(isset($kota['updated'])){ ?>
		<div class="entry-value col-sm-8"><?php echo format_date($kota['updated'], 'd-m-Y G:i'); ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:created_by'); ?></div>
		<div class="entry-value col-sm-8"><?php echo user_displayname($kota['created_by'], true); ?></div>
	</div>
</div>