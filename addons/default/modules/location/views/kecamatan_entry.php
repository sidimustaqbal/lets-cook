<div class="page-header">
	<h1>
		<span><?php echo lang('location:kecamatan:view'); ?></span>
	</h1>
	
	<div class="btn-group content-toolbar">
		
		<a href="<?php echo site_url('location/kecamatan/index'); ?>" class="btn btn-sm btn-default">
			<i class="icon-arrow-left"></i>
			<?php echo lang('location:back') ?>
		</a>

		<?php if(group_has_role('location', 'edit_all_kecamatan')){ ?>
			<a href="<?php echo site_url('location/kecamatan/edit/'.$kecamatan['id']); ?>" class="btn btn-sm btn-default">
				<i class="icon-edit"></i>
				<?php echo lang('global:edit') ?>
			</a>
		<?php }elseif(group_has_role('location', 'edit_own_kecamatan')){ ?>
			<?php if($kecamatan->created_by_user_id == $this->current_user->id){ ?>
				<a href="<?php echo site_url('location/kecamatan/edit/'.$kecamatan['id']); ?>" class="btn btn-sm btn-default">
					<i class="icon-edit"></i>
					<?php echo lang('global:edit') ?>
				</a>
			<?php } ?>
		<?php } ?>

		<?php if(group_has_role('location', 'delete_all_kecamatan')){ ?>
			<a href="<?php echo site_url('location/kecamatan/delete/'.$kecamatan['id']); ?>" class="confirm btn btn-sm btn-danger">
				<i class="icon-trash"></i>
				<?php echo lang('global:delete') ?>
			</a>
		<?php }elseif(group_has_role('location', 'delete_own_kecamatan')){ ?>
			<?php if($kecamatan->created_by_user_id == $this->current_user->id){ ?>
				<a href="<?php echo site_url('location/kecamatan/delete/'.$kecamatan['id']); ?>" class="confirm btn btn-sm btn-danger">
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
		<div class="entry-value col-sm-8"><?php echo $kecamatan['id']; ?></div>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:kode'); ?></div>
		<?php if(isset($kecamatan['kode'])){ ?>
		<div class="entry-value col-sm-8"><?php echo $kecamatan['kode']; ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:nama'); ?></div>
		<?php if(isset($kecamatan['nama'])){ ?>
		<div class="entry-value col-sm-8"><?php echo $kecamatan['nama']; ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:slug'); ?></div>
		<?php if(isset($kecamatan['slug'])){ ?>
		<div class="entry-value col-sm-8"><?php echo $kecamatan['slug']; ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:created'); ?></div>
		<?php if(isset($kecamatan['created'])){ ?>
		<div class="entry-value col-sm-8"><?php echo format_date($kecamatan['created'], 'd-m-Y G:i'); ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:updated'); ?></div>
		<?php if(isset($kecamatan['updated'])){ ?>
		<div class="entry-value col-sm-8"><?php echo format_date($kecamatan['updated'], 'd-m-Y G:i'); ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:created_by'); ?></div>
		<div class="entry-value col-sm-8"><?php echo user_displayname($kecamatan['created_by'], true); ?></div>
	</div>
</div>