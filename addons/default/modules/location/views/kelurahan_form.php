<div class="page-header">
	<h1>
		<span><?php echo lang('location:kelurahan:'.$mode); ?></span>
	</h1>
</div>

<?php echo form_open_multipart(uri_string()); ?>

<div class="form-horizontal">

	<div class="form-group">
		<label class="col-sm-2 control-label no-padding-right" for="kode"><?php echo lang('location:kode'); ?></label>

		<div class="col-sm-10">
			<?php 
				$value = NULL;
				if($this->input->post('kode') != NULL){
					$value = $this->input->post('kode');
				}elseif($mode == 'edit'){
					$value = $fields['kode'];
				}
			?>
			<input name="kode" type="text" value="<?php echo $value; ?>" class="col-xs-10 col-sm-5" id="" />
			
			<span class="help-inline col-xs-12 col-sm-7">
				<span class="middle">Inline help text</span>
			</span>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label no-padding-right" for="nama"><?php echo lang('location:nama'); ?></label>

		<div class="col-sm-10">
			<?php 
				$value = NULL;
				if($this->input->post('nama') != NULL){
					$value = $this->input->post('nama');
				}elseif($mode == 'edit'){
					$value = $fields['nama'];
				}
			?>
			<input name="nama" type="text" value="<?php echo $value; ?>" class="col-xs-10 col-sm-5" id="" />
			
			<span class="help-inline col-xs-12 col-sm-7">
				<span class="middle">Inline help text</span>
			</span>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label no-padding-right" for="slug"><?php echo lang('location:slug'); ?></label>

		<div class="col-sm-10">
			<?php 
				$value = NULL;
				if($this->input->post('slug') != NULL){
					$value = $this->input->post('slug');
				}elseif($mode == 'edit'){
					$value = $fields['slug'];
				}
			?>
			<input name="slug" type="text" value="<?php echo $value; ?>" class="col-xs-10 col-sm-5" id="" />
			
			<span class="help-inline col-xs-12 col-sm-7">
				<span class="middle">Inline help text</span>
			</span>
		</div>
	</div>

</div>

<div class="clearfix form-actions">
	<div class="col-md-offset-2 col-md-10">
		<button type="submit" class="btn btn-primary"><span><?php echo lang('buttons:save'); ?></span></button>
		<a href="<?php echo site_url($return); ?>" class="btn btn-danger"><?php echo lang('buttons:cancel'); ?></a>
	</div>
</div>

<?php echo form_close();?>