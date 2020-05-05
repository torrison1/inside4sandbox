<div class="content">

	<section class="container mt-3">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/">Главная</a></li>
				<li class="breadcrumb-item"><a href="/info/feed">Блог</a></li>
				<li class="breadcrumb-item" aria-current="page">
					<?=$page_row['content_name']?>
				</li>
			</ol>
		</nav>
	</section>

	<!-- Product-list -->
	<section>
		<div class="container content-page wblock1 p-3">
			<div class="content-html">
					<img class="page-image wblock1 mt-2" src="/Uploads/content_img/<?=$page_row['content_img']?>" alt="<?=$page_row['content_name']?>">
					<h1 class="content-name"><?=$page_row['content_name']?></h1>
					<div class="content-date">
						<i class="fa fa-calendar" aria-hidden="true"></i> &nbsp;
						<?= $page_row['content_create_date'] ?>
					</div>
					<?=htmlspecialchars_decode($page_row['content_html'])?>
			</div>

			<?php if($gallery = json_decode($page_row['content_gallery'], true)) { ?>

				<div class="clearfix text-center">
					<ul id="lightSlider" class="it-mb-25">
						<?php if($page_row['content_youtube_link'] != '') { ?>
							<a href="<?=$page_row['content_youtube_link']?>">
								<?php

								$y_img = 'youtube_video.jpg';
								if($page_row['content_img_youtube'] != '') $y_img = $page_row['content_img_youtube'];

								?>
								<img class="img-responsive inside_gallery_img" src="/Uploads/content_img/<?=$y_img?>">
							</a>
						<?php } ?>
						<?php foreach($gallery as $image) { ?>
							<a data-src="/Uploads/content_img/<?=$image?>">
                                <div class="gallery_img_holder">
                                    <img class="img-responsive inside_gallery_img" src="/Uploads/content_img/<?=$image?>">
                                </div>
							</a>
						<?php } ?>
					</ul>
				</div>
			<?php } ?>

			<div class="tags-block it-mt-10 pull-left">
				<i aria-hidden="true" class="fa fa-hashtag"></i>
				<?php foreach ($content_tags_arr as $tag) { ?>
					<?php if($tag['content_id'] == $page_row['content_id']) { ?>
						<a href="<?=$lang_link_prefix?>/info/tag/<?=$tag['name']?>"><?=$tag['name']?></a>
					<?php } ?>
				<?php } ?>
				<?php if($username) echo " by <b>$username"; ?>
			</div>
			<div class="pluso pull-right" data-background="transparent" data-options="medium,round,line,horizontal,nocounter,theme=04" data-services="vkontakte,facebook,twitter,google,linkedin,print"></div>
		</div>
	</section>
	<section class="comment container mt-4 wblock1 p-3">
		<?php if ($page_row['content_type'] != '2') { ?>
			<!-- comments list -->
			<div id="comments-wrap">
				<div class="h3 comments_label"><span>Comments </span></div>
				<div class="commentlist">

					<?php foreach ($comments_arr as $comment) { ?>

						<div class="comment mt-3">

							<?php if ($comment['avatar'] == '') $comment['avatar'] = 'no_ava.png'?>
							<img style="width: 30px;" alt='' src='/Uploads/Users/Avatars/<?=$comment['avatar']?>' class='avatar avatar-35 photo fleft' />
							<?php
							if ($comment['username'] != '') {
								$name = $comment['username'];

							} elseif ($comment['first_name'] != '') {
								$name = $comment['first_name'];
							}
							else {
								$name = explode("@", $comment['email']);
								$name = $name[0];
							}
							?>
							<b><?=$name?></b> <span class="comment-date"><?=date('d.m.Y', $comment['comments_datetime'])?></span>
							<br>
							<?=$comment['comments_text']?>
							<div style="display:none;" class="comment-meta commentmetadata">
								<div class="grey_button"><a href='#'>Reply</a></div>
							</div>
						</div>
					<?php } ?>

				</div>
			</div>

			<!-- ENDS comments list -->

			<div id="respond" class="mt-3">

				<form method="post" id="comment_form" class="style_form">

					<?php if (!$user) { ?><textarea name="comment" id="reg_text_area" class="comments_textarea form-control" placeholder="Here you can add your comment..."  tabindex="4" disabled="disabled"></textarea>
						<div class="reg_user_slogan">
							<div>
								<b>Only for register users</b>
								<br /><br />
								<a href="/auth/login" id="comment_reg_btn" class="btn btn-sm btn-primary">Register</a>
							</div>
						</div>
					<?php } else { ?>
						<textarea name="comment" id="comment" class="comments_textarea form-control" placeholder="Add comment ..."  tabindex="4" ></textarea>
						<div class="comment_msg"></div>
						<a id="comment_post" class="btn btn-sm btn-primary mt-3 text-white">POST</a>
					<?php } ?>

					<div class="clearfix"></div>
					<input type="hidden" name="page_url" value='/<?=$lang_link_prefix?>/info/page/<?=$page_row['content_alias']?>' />
					<input type="hidden" name="page_id" value='<?=$page_row['content_id']?>' />

				</form>

			</div>
			<!-- ends fullwidth content -->
		<?php } ?>
	</section>
</div>
<div>&nbsp;</div>