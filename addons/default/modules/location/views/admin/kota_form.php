<div class="page-header">
	<h1><?php echo lang('location:kota:'.$mode); ?></h1>
</div>

<?php echo form_open_multipart(uri_string() . '?' . $_SERVER['QUERY_STRING']); ?>

<div class="form-horizontal">

	<div class="form-group">
		<label class="col-sm-2 control-label no-padding-right" for="kode"><?php echo lang('location:nama_provinsi'); ?> *</label>

		<div class="col-sm-10">
			<?php 
				$value = NULL;
				if($this->input->post('id_provinsi') != NULL){
					$value = $this->input->post('id_provinsi');
				}elseif($this->input->get('f-provinsi') != NULL){
					$value = $this->input->get('f-provinsi');
				}elseif($mode == 'edit'){
					$value = $fields['id_provinsi'];
				}
			?>
			<select name="id_provinsi" class="col-xs-10 col-sm-5" id="" >
				<option value="">-- Pilih Provinsi --</option>
				<?php foreach ($provinsi as $prov) { ?>
					<option value="<?php echo $prov['id']; ?>" <?php echo ($value==$prov['id']) ? 'selected' : ''; ?>><?php echo $prov['nama']; ?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-sm-2 control-label no-padding-right" for="nama"><?php echo lang('location:nama_kota'); ?> *</label>

		<div class="col-sm-10">
			<?php 
				$value = NULL;
				if($this->input->post('nama') != NULL){
					$value = $this->input->post('nama');
				}elseif($mode == 'edit'){
					$value = $fields['nama'];
				}
			?>
			<input name="nama" type="text" value="<?php echo $value; ?>" class="col-xs-10 col-sm-5" id="nama" />
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label no-padding-right" for="slug"><?php echo lang('location:slug_kota'); ?> *</label>

		<div class="col-sm-10">
			<?php 
				$value = NULL;
				if($this->input->post('slug') != NULL){
					$value = $this->input->post('slug');
				}elseif($mode == 'edit'){
					$value = $fields['slug'];
				}
			?>
			<input name="slug" type="text" value="<?php echo $value; ?>" class="col-xs-10 col-sm-5" id="slug" />
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label no-padding-right" for="kode"><?php echo lang('location:kode_kota'); ?></label>

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
<script type="text/javascript">
	$('#nama').slugify({slug:'#slug', type:'-'});
</script>