<style type="text/css">
	div.head_role {
    width: 100%;
		margin-top: 10px;
    clear: both;
    border: 2px solid rgba(0,0,0,0.3);
    float: left;
    padding: 5px 0px;
  }
	div.head_role:first-child {
		margin-top: 0px;
  }
  div.head_titles {
    font-weight: bolder;
		padding: 5px 7px;
		margin: 0px 5px 5px;
    background-color: rgba(0,0,0,0.3);
  }
	label.inline {float: left; margin-right: 5px; margin-left: 5px;}
</style>
<section class="title">
	<h4><?php echo $group->description ?></h4>
</section>
<section class="item">
	<div class="content">
		<?php echo form_open(uri_string(), array('class'=> 'crud', 'id'=>'edit-permissions')) ?>
		<table border="0" class="table-list" cellspacing="0">
			<thead>
				<tr>
					<th><?php echo form_checkbox(array('id'=>'check-all', 'name' => 'action_to_all', 'class' => 'check-all', 'title' => lang('permissions:checkbox_tooltip_action_to_all'))) ?></th>
					<th><?php echo lang('permissions:module') ?></th>
					<th><?php echo lang('permissions:roles') ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($permission_modules as $module): ?>
				<tr>
					<td style="width: 30px">
						<?php echo form_checkbox(array(
							'id'=> $module['slug'],
							'class' => 'select-row',
							'value' => true,
							'name'=>'modules['.$module['slug'].']',
							'checked'=> array_key_exists($module['slug'], $edit_permissions),
							'title' => sprintf(lang('permissions:checkbox_tooltip_give_access_to_module'), $module['name']),
						)) ?>
					</td>
					<td>
						<label class="inline" for="<?php echo $module['slug'] ?>">
							<?php echo $module['name'] ?>
						</label>
					</td>
					<td>
					<?php if ( ! empty($module['roles'])){ ?>
						<?php foreach ($module['roles'] as $role): ?>
						<label class="inline">
							<?php echo form_checkbox(array(
								'class' => 'select-rule',
								'name' => 'module_roles['.$module['slug'].']['.$role.']',
								'value' => true,
								'checked' => isset($edit_permissions[$module['slug']]) AND array_key_exists($role, (array) $edit_permissions[$module['slug']])
							)) ?>
							<?php echo lang($module['slug'].':role_'.$role) ?>
						</label>
						<?php endforeach ?>
					<?php }else if($module['slug']=='settings'){ ?>
						<?php
						$set_var = 'random';
						echo '<div class="head_role"><div>';
						foreach ($settings as $setting) {
							if($set_var != $setting->module){
								if($set_var!='random'){
									echo '</div></div><div class="head_role"><div>';
								}
								$set_var = $setting->module;
								echo '<div class="head_titles">'.$setting_sections[$setting->module].'</div>';
							}
						?>
						<label class="inline">
							<?php echo form_checkbox(array(
								'class' => 'select-rule',
								'name' => 'module_roles[settings]['.$setting->slug.']',
								'value' => true,
								'checked' => isset($edit_permissions['settings']) AND array_key_exists($setting->slug, (array) $edit_permissions['settings'])
							)) ?>
							<?php echo $setting->title; ?>
						</label>
						<?php }
						echo '</div></div>';?>
					<?php } ?>
					</td>
				</tr>
				<?php endforeach ?>
			</tbody>
		</table>
		<div class="buttons float-right padding-top">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel'))) ?>
		</div>
		<?php echo form_close() ?>
	</div>
</section>