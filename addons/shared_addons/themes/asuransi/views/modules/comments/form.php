<section id="respond" class="vmargin">
    <div class="col-xs-3 side" >
        <h3><span><?php echo lang('comments:your_comment'); ?></span></h3>
        <p>We would be glad to get your feedback. Take a moment to comment and tell us what you think.</p>
        <p>* Required fields</p>
        <p>Email will not be published.</p>
    </div>
    <div class="col-xs-9">
        <?php echo form_open("comments/create/{$module}", 'id="create-comment" class="form-horizontal"') ?>
            <noscript><?php echo form_input('d0ntf1llth1s1n', '', 'style="display:none"') ?></noscript>
            <?php echo form_hidden('entry', $entry_hash) ?>
            

           <?php if ( ! is_logged_in()): ?>
                <div class="form-group">
					<div class="col-xs-12">
                    <input type="text" class="required form-control" value="<?php echo $comment['name'] ?>" name="name" id="author" placeholder="<?php echo lang('comments:name_label'); ?>*">
					</div>
                </div>
                <div class="form-group">
					<div class="col-xs-12">
                    <input type="email" class="required form-control" value="<?php echo $comment['email'] ?>" name="email" id="email" placeholder="Email Address*">
					</div>
                </div>
                <div class="form-group">
					<div class="col-xs-12">
                    <input type="text" class="form-control" value="<?php echo $comment['website'] ?>" name="website" id="url" placeholder="<?php echo lang('comments:website_label'); ?>">
					</div>
                </div>
            <?php endif; ?>


            <div class="form-group">
				<div class="col-xs-12">
					<textarea class="required form-control" name="comment" rows="5" cols="30" id="comment" placeholder="<?php echo lang('comments:message_label'); ?>*"></textarea>
				</div>
            </div>

            <p class="form-submit">
                <input type="submit" class="btn" value="<?php echo lang('comments:send_label');?>" id="submit" name="submit">
            </p>

        <?php echo form_close(); ?>
    </div>
        
</section>

