<div class="page-header">
	<h1><?php echo lang('location:kecamatan:view'); ?></h1>
	
	<div class="btn-group content-toolbar">
		
		<a href="<?php echo site_url('admin/location/kecamatan/index'); ?>" class="btn btn-sm btn-yellow">
			<i class="icon-arrow-left"></i>
			<?php echo lang('location:back') ?>
		</a>

		<a href="<?php echo site_url('admin/location/kecamatan/edit/'.$kecamatan['id']); ?>" class="btn btn-sm btn-yellow">
			<i class="icon-edit"></i>
			<?php echo lang('global:edit') ?>
		</a>
		<a href="<?php echo site_url('admin/location/kecamatan/delete/'.$kecamatan['id']); ?>" class="confirm btn btn-sm btn-danger">
			<i class="icon-trash"></i>
			<?php echo lang('global:delete') ?>
		</a>
		
	</div>
</div>

<div>
	<div class="row">
		<div class="entry-label col-sm-2">ID</div>
		<div class="entry-value col-sm-8"><?php echo $kecamatan['id']; ?></div>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:kode_kecamatan'); ?></div>
		<?php if(isset($kecamatan['kode'])){ ?>
		<div class="entry-value col-sm-8"><?php echo $kecamatan['kode']; ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:nama_kecamatan'); ?></div>
		<?php if(isset($kecamatan['nama'])){ ?>
		<div class="entry-value col-sm-8"><?php echo $kecamatan['nama']; ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:slug_kecamatan'); ?></div>
		<?php if(isset($kecamatan['slug'])){ ?>
		<div class="entry-value col-sm-8"><?php echo $kecamatan['slug']; ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:created'); ?></div>
		<?php if(isset($kecamatan['created_on'])){ ?>
		<div class="entry-value col-sm-8"><?php echo format_date($kecamatan['created_on'], 'd-m-Y G:i'); ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:updated'); ?></div>
		<?php if(isset($kecamatan['updated_on'])){ ?>
		<div class="entry-value col-sm-8"><?php echo format_date($kecamatan['updated_on'], 'd-m-Y G:i'); ?></div>
		<?php }else{ ?>
		<div class="entry-value col-sm-8">-</div>
		<?php } ?>
	</div>

	<div class="row">
		<div class="entry-label col-sm-2"><?php echo lang('location:created_by'); ?></div>
		<div class="entry-value col-sm-8"><?php echo user_displayname($kecamatan['created_by'], true); ?></div>
	</div>
</div>