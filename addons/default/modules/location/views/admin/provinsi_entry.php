<div class="page-header">
	<h1><?php echo lang('location:provinsi:view'); ?></h1>
	
	<div class="btn-group content-toolbar">
		
		<a href="<?php echo site_url('admin/location/provinsi/index'); ?>" class="btn btn-sm btn-yellow">
			<i class="icon-arrow-left"></i>
			<?php echo lang('location:back') ?>
		</a>
		
		<a href="<?php echo site_url('admin/location/provinsi/edit/'.$provinsi['id']); ?>" class="btn btn-sm btn-yellow">
			<i class="icon-edit"></i>
			<?php echo lang('global:edit') ?>
		</a>
		
		<a href="<?php echo site_url('admin/location/provinsi/delete/'.$provinsi['id']); ?>" class="confirm btn btn-sm btn-danger">
			<i class="icon-trash"></i>
			<?php echo lang('global:delete') ?>
		</a>
		
		
	</div>
</div>

<div>
	<div class="row">
		<div class="entry-label col-sm-2">ID</div>
		<div class="entry-value col-sm-8"><?php echo $provinsi['id']; ?></div>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:kode_provinsi'); ?></div>
		<?php if(isset($provinsi['kode'])){ ?>
		<div class="entry-value col-sm-8"><?php echo $provinsi['kode']; ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:nama_provinsi'); ?></div>
		<?php if(isset($provinsi['nama'])){ ?>
		<div class="entry-value col-sm-8"><?php echo $provinsi['nama']; ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:slug_provinsi'); ?></div>
		<?php if(isset($provinsi['slug'])){ ?>
		<div class="entry-value col-sm-8"><?php echo $provinsi['slug']; ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:created'); ?></div>
		<?php if(isset($provinsi['created_on'])){ ?>
		<div class="entry-value col-sm-8"><?php echo format_date($provinsi['created_on'], 'd-m-Y G:i'); ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:updated'); ?></div>
		<?php if(isset($provinsi['updated_on'])){ ?>
		<div class="entry-value col-sm-8"><?php echo format_date($provinsi['updated_on'], 'd-m-Y G:i'); ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:created_by'); ?></div>
		<div class="entry-value col-sm-8"><?php echo user_displayname($provinsi['created_by'], true); ?></div>
	</div>
</div>