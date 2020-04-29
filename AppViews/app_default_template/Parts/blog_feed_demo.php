<?php foreach ($pages_list_arr as $page) { $not_empty = true; ?>
    <div class="item wblock1 mb-4 p-3">
        <div class="row">
            <div class="col-sm-12 col-lg-5 col-md-5 it-product-bg">
                <div class="product-img">
                    <a href="#/content/show_by_alias/<?= $page['content_alias'] ?>">
                        <?php if ($page['content_img'] != '') { ?>
                            <img class="img-responsive center-block wblock1"
                                 src="https://ux.ikiev.biz/files/uploads/content_img/<?= $page['content_img'] ?>"
                                 alt="<?= $page['content_name'] ?>">
                        <?php } else { ?>
                            <img class="img-responsive center-block wblock1"
                                 src="https://ux.ikiev.biz/files/uploads/post_images/no-image-available.jpg"
                                 alt="<?= $page['content_name'] ?>">
                        <?php } ?>
                    </a>
                </div>
            </div>
            <div class="col-sm-12 col-lg-7 col-md-7">

                <h2 class="heading-left it-tw-6 content-name"><a
                        href="#/content/show_by_alias/<?= $page['content_alias'] ?>"><?= $page['content_name'] ?></a>
                </h2>
                <div class="product-data d-inline-block">
                    <i class="fa fa-calendar" aria-hidden="true"></i> &nbsp;
                    <?= $page['content_create_date'] ?>&nbsp;
                </div>
                <div class="categories d-inline-block">
                    <i class="fas fa-bookmark"></i>&nbsp;
                    <?php foreach ($content_categories_arr as $content_tags) {
                        if ($content_tags['content_id'] == $page['content_id']) { ?>
                            <a href="#<?= $lang_link_prefix ?>/content/category_list/<?= $content_tags['alias'] ?>"><?= $content_tags['name'] ?></a>
                            &nbsp;
                        <?php }
                    } ?>
                </div>
                <div class="tags d-inline-block">
                    <i aria-hidden="true" class="fa fa-hashtag"></i>&nbsp;
                    <?php foreach ($content_tags_arr as $content_tags) {
                        if ($content_tags['content_id'] == $page['content_id']) { ?>
                            <a href="#<?= $lang_link_prefix ?>/content/tag_list/<?= $content_tags['name'] ?>"><?= $content_tags['name'] ?></a>
                            &nbsp;
                        <?php }
                    } ?>
                </div>
                <p><?= $page['content_desc'] ?></p>
                <div>
                    <a href="#/content/show_by_alias/<?= $page['content_alias'] ?>" >More... &#8594;</a>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if (!isset($not_empty)) { ?>
    <h3 class="text-center" style="margin-top: 100px;">No pages here</h3>
<?php } ?>