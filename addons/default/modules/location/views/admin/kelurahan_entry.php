<div class="page-header">
	<h1><?php echo lang('location:kelurahan:view'); ?></h1>
	
	<div class="btn-group content-toolbar">
		
		<a href="<?php echo site_url('admin/location/kelurahan/index'); ?>" class="btn btn-sm btn-yellow">
			<i class="icon-arrow-left"></i>
			<?php echo lang('location:back') ?>
		</a>

		
		<a href="<?php echo site_url('admin/location/kelurahan/edit/'.$kelurahan['id']); ?>" class="btn btn-sm btn-yellow">
			<i class="icon-edit"></i>
			<?php echo lang('global:edit') ?>
		</a>

		
		<a href="<?php echo site_url('admin/location/kelurahan/delete/'.$kelurahan['id']); ?>" class="confirm btn btn-sm btn-danger">
			<i class="icon-trash"></i>
			<?php echo lang('global:delete') ?>
		</a>
		
	</div>
</div>

<div>
	<div class="row">
		<div class="entry-label col-sm-2">ID</div>
		<div class="entry-value col-sm-8"><?php echo $kelurahan['id']; ?></div>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:kode_kelurahan'); ?></div>
		<?php if(isset($kelurahan['kode'])){ ?>
		<div class="entry-value col-sm-8"><?php echo $kelurahan['kode']; ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:nama_kelurahan'); ?></div>
		<?php if(isset($kelurahan['nama'])){ ?>
		<div class="entry-value col-sm-8"><?php echo $kelurahan['nama']; ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:slug_kelurahan'); ?></div>
		<?php if(isset($kelurahan['slug'])){ ?>
		<div class="entry-value col-sm-8"><?php echo $kelurahan['slug']; ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:created'); ?></div>
		<?php if(isset($kelurahan['created_on'])){ ?>
		<div class="entry-value col-sm-8"><?php echo format_date($kelurahan['created_on'], 'd-m-Y G:i'); ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:updated'); ?></div>
		<?php if(isset($kelurahan['updated_on'])){ ?>
		<div class="entry-value col-sm-8"><?php echo format_date($kelurahan['updated_on'], 'd-m-Y G:i'); ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:created_by'); ?></div>
		<div class="entry-value col-sm-8"><?php echo user_displayname($kelurahan['created_by'], true); ?></div>
	</div>
</div>