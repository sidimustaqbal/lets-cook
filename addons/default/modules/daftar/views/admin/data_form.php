<div class="page-header">
	<h1><?php echo lang('daftar:data:'.$mode); ?></h1>
</div>

<?php echo form_open_multipart(uri_string()); ?>

<div class="form-horizontal">

	<div class="form-group">
		<label class="col-sm-2 control-label no-padding-right" for="id"><?php echo lang('daftar:id'); ?></label>

		<div class="col-sm-10">
			<?php 
				$value = NULL;
				if($this->input->post('id') != NULL){
					$value = $this->input->post('id');
				}elseif($mode == 'edit'){
					$value = $fields['id'];
				}
			?>
			<input name="id" type="text" value="<?php echo $value; ?>" class="col-xs-10 col-sm-5" id="" />
			
			<span class="help-inline col-xs-12 col-sm-7">
				<span class="middle">Inline help text</span>
			</span>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label no-padding-right" for="nama"><?php echo lang('daftar:nama'); ?></label>

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
		<label class="col-sm-2 control-label no-padding-right" for="status"><?php echo lang('daftar:status'); ?></label>

		<div class="col-sm-10">
			<?php 
				$value = NULL;
				if($this->input->post('status') != NULL){
					$value = $this->input->post('status');
				}elseif($mode == 'edit'){
					$value = $fields['status'];
				}
			?>
			<input name="status" type="text" value="<?php echo $value; ?>" class="col-xs-10 col-sm-5" id="" />
			
			<span class="help-inline col-xs-12 col-sm-7">
				<span class="middle">Inline help text</span>
			</span>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label no-padding-right" for="form"><?php echo lang('daftar:form'); ?></label>

		<div class="col-sm-10">
			<?php 
				$value = NULL;
				if($this->input->post('form') != NULL){
					$value = $this->input->post('form');
				}elseif($mode == 'edit'){
					$value = $fields['form'];
				}
			?>
			<input name="form" type="text" value="<?php echo $value; ?>" class="col-xs-10 col-sm-5" id="" />
			
			<span class="help-inline col-xs-12 col-sm-7">
				<span class="middle">Inline help text</span>
			</span>
		</div>
	</div>

</div>

<div class="clearfix form-actions">
	<div class="col-md-offset-3 col-md-9">
		<button type="submit" class="btn btn-primary"><span><?php echo lang('buttons:save'); ?></span></button>
		<a href="<?php echo site_url($return); ?>" class="btn btn-danger"><?php echo lang('buttons:cancel'); ?></a>
	</div>
</div>

<?php echo form_close();?>