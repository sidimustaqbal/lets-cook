<div class="page-header">
			<label><?php echo lang('location:kode'); ?>:&nbsp;</label>
			<input type="text" name="f-kode" value="<?php echo $this->input->get('f-kode'); ?>">
		</div>
		<div class="form-group">
			<label><?php echo lang('location:nama'); ?>:&nbsp;</label>
			<input type="text" name="f-nama" value="<?php echo $this->input->get('f-nama'); ?>">
		</div>
		<div class="form-group">
			<label><?php echo lang('location:slug'); ?>:&nbsp;</label>
			<input type="text" name="f-slug" value="<?php echo $this->input->get('f-slug'); ?>">
		</div>
		<button href="<?php echo current_url() . '#'; ?>" class="btn btn-primary btn-xs" type="submit">