<!-- Link to bring up Report a Problem Modal -->
<div class="reportBtnWrapper"><a class="reportBtn" href="#reportModal" data-toggle="modal">Report a Problem</a></div>

<!-- Report a Problem Modal -->
<div id="reportModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
		<h3 id="reportModalLabel">Report a Problem</h3>
	</div>
<form name="reportform" method="post" action="/process_report.php" style="overflow-x:scroll;">
	<fieldset>
		<div class="modal-body">
			<input type="hidden" name="email_to" value="<?php
				$blogusers = get_users();
				foreach ($blogusers as $user) {
					if (!empty( $user->user_email)) {
						echo $user->user_email . ', ';
					}
			}?>">
			<input type="hidden" name="site_name" value="<?php bloginfo('name'); ?>">
			<input type="hidden" name="page_title" value="<?php wp_title('',true); ?>">
			<label>Name (Optional)</label>
			<input type="text" id="name" name="name">
			
			<label>Email (Optional)</label>
			<input type="text" id="email" name="email">
			
			<div style="display: none">
				<label>Emailers</label>
				<input name="emailers" type="text" value="">
			</div>
			
			<p>What problems are you experiencing with this page?</p>
			<textarea class="input-block-level" name="comments" id="comments"></textarea>
			<script type="text/javascript"
				src="/verify.js">
			</script>
		</div>
		<div class="modal-footer">
			<input type="hidden" name="url" id="url" value="" />
			<script>document.getElementById('url').value = document.URL;</script>
			<button class="btn btn-primary">Report</button>
		</div>
	</fieldset>
	</form>
</div>