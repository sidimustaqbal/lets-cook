<div class="page-header">
	<h1><?php echo lang('location:kota:view'); ?></h1>
	
	<div class="btn-group content-toolbar">
		
		<a href="<?php echo site_url('admin/location/kota/index'); ?>" class="btn btn-sm btn-yellow">
			<i class="icon-arrow-left"></i>
			<?php echo lang('location:back') ?>
		</a>

		
		<a href="<?php echo site_url('admin/location/kota/edit/'.$kota['id']); ?>" class="btn btn-sm btn-yellow">
			<i class="icon-edit"></i>
			<?php echo lang('global:edit') ?>
		</a>
		
		<a href="<?php echo site_url('admin/location/kota/delete/'.$kota['id']); ?>" class="confirm btn btn-sm btn-danger">
			<i class="icon-trash"></i>
			<?php echo lang('global:delete') ?>
		</a>
		
	</div>
</div>

<div>
	<div class="row">
		<div class="entry-label col-sm-2">ID</div>
		<div class="entry-value col-sm-8"><?php echo $kota['id']; ?></div>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:kode_kota'); ?></div>
		<?php if(isset($kota['kode'])){ ?>
		<div class="entry-value col-sm-8"><?php echo $kota['kode']; ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:nama_kota'); ?></div>
		<?php if(isset($kota['nama'])){ ?>
		<div class="entry-value col-sm-8"><?php echo $kota['nama']; ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:slug_kota'); ?></div>
		<?php if(isset($kota['slug'])){ ?>
		<div class="entry-value col-sm-8"><?php echo $kota['slug']; ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:created'); ?></div>
		<?php if(isset($kota['created_on'])){ ?>
		<div class="entry-value col-sm-8"><?php echo format_date($kota['created_on'], 'd-m-Y G:i'); ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:updated'); ?></div>
		<?php if(isset($kota['updated_on'])){ ?>
		<div class="entry-value col-sm-8"><?php echo format_date($kota['updated_on'], 'd-m-Y G:i'); ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:created_by'); ?></div>
		<div class="entry-value col-sm-8"><?php echo user_displayname($kota['created_by'], true); ?></div>
	</div>
</div>