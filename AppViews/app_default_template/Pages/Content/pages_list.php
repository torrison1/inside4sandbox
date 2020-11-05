<style>
    @media(max-width:1024px){
        .toggle_filters {
            display: block !important;
            cursor: pointer;
            text-align: center;
            margin-bottom: 10px;
            padding: 5px;
        }
        .content_filters {
            display: none;
            margin-bottom: 10px;
        }
        h2.content-name {
            margin-top: 10px;
        }
    }
</style>
<div class="content content-blog">
    <section>
        <div class="container">
            <div class="mt-3">

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= $lang_link_prefix ?>/">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= $lang_link_prefix ?>/info/feed">Content</a></li>
                        <li class="breadcrumb-item" aria-current="plist">
                            <?php if(isset($category_row['categories_name'])) { ?>
                                <?=$category_row['categories_name']?>
                            <?php } else if(isset($tag)) { ?>
                                <?=$tag?>
                            <?php } else { ?>
                                Feed
                            <?php } ?>

                            <?php if ($page > 1) { ?> page 2<?php } ?>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <!-- Product-list -->
    <div class="container">
        <div class="row">
        <section class="col-md-3 category_tags_list">
            <div class="toggle_filters wblock1" onclick="$(this).next().toggle();" style="display: none;">
                <i class="fa fa-book"></i> Categories / Tags / Filters
            </div>
            <div class="wblock1 p-3 content_filters">
                <h4><a href="<?= $lang_link_prefix ?>/info/feed">Content</a></h4>
                <div class="categoties_tree it-mb-10">
                    <?=$catalog_tree?>
                </div>
                <h4 class="it-mb-10">#hashtags</h4>
                <ul>
                    <?php foreach($tags_arr as $tag) { ?>
                        <li><a href="<?= $lang_link_prefix ?>/info/tag/<?= $tag['tags_name'] ?>"><?= $tag['tags_name'] ?></a></li>
                    <?php } ?>
                </ul>
                <form action="<?= $lang_link_prefix ?>/info/feed" method="get" class="showListFilterForm">
                    <div class="input-group mb-3">

                        <input style="background: #fff;" name="search" class="show-list-search-input"
                               value="<?php if (isset($_GET['search'])) echo $inside4_security->xss_cleaner($_GET['search']) ?>"
                               placeholder="Search...">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-secondary ">Find</button>
                        </div>
                    </div>



                </form>
            </div>

        </section>
        <section class="col-md-9 pages_list_holder">
            <?php foreach ($pages_list_arr as $page) { $not_empty = true; ?>
                <div class="item wblock1 mb-4 p-3">
                    <div class="row">
                        <div class="col-sm-12 col-lg-5 col-md-5 it-product-bg">
                            <div class="product-img">
                                <a href="<?= $lang_link_prefix ?>/info/page/<?= $page['content_alias'] ?>">
                                    <?php if ($page['content_img'] != '') { ?>
                                        <img class="img-responsive center-block wblock1"
                                             src="<?= $page['content_img'] ?>"
                                             alt="<?= $page['content_name'] ?>">
                                    <?php } else { ?>
                                        <img class="img-responsive center-block wblock1"
                                             src="/Uploads/content_img/no-image-available.jpg"
                                             alt="<?= $page['content_name'] ?>">
                                    <?php } ?>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-7 col-md-7">

                            <h2 class="heading-left it-tw-6 content-name"><a
                                    href="<?= $lang_link_prefix ?>/info/page/<?= $page['content_alias'] ?>"><?= $page['content_name'] ?></a>
                            </h2>
                            <div class="product-data d-inline-block">
                                    <i class="fa fa-calendar" aria-hidden="true"></i> &nbsp;
                                    <?= $page['content_create_date'] ?>&nbsp;
                            </div>
                            <div class="categories d-inline-block">
                                <i class="fas fa-bookmark"></i>&nbsp;
                                <?php foreach ($content_categories_arr as $content_tags) {
                                    if ($content_tags['content_id'] == $page['content_id']) { ?>
                                        <a href="<?= $lang_link_prefix ?>/info/category/<?= $content_tags['alias'] ?>"><?= $content_tags['name'] ?></a>
                                        &nbsp;
                                    <?php }
                                } ?>
                            </div>
                            <div class="tags d-inline-block">
                                <i aria-hidden="true" class="fa fa-hashtag"></i>&nbsp;
                                <?php foreach ($content_tags_arr as $content_tags) {
                                    if ($content_tags['content_id'] == $page['content_id']) { ?>
                                        <a href="<?= $lang_link_prefix ?>/info/tag/<?= $content_tags['name'] ?>"><?= $content_tags['name'] ?></a>
                                    <?php }
                                } ?>
                            </div>
                            <p><?= $page['content_desc'] ?></p>
                            <div>
                                <a href="<?= $lang_link_prefix ?>/info/page/<?= $page['content_alias'] ?>" >More... &#8594;</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if (!isset($not_empty)) { ?>
                <h3 class="text-center" style="margin-top: 100px;">No Content here...</h3>
            <?php } ?>
            <div class="inside_pagination text-right mb-5">
                <?php if ($prev_page) { ?>
                    <a class="wblock1 p-2" href="<?= $lang_link_prefix ?><?=$page_uri.'/'.$prev_page?>">&lt;&lt; prev</a>
                <?php } ?>
                <?php if ($next_page) { ?>
                    <a class="wblock1 p-2" href="<?= $lang_link_prefix ?><?=$page_uri.'/'.$next_page?>">next &gt;&gt;</a>
                <?php } ?>
                <!-- <?= $pagination ?> -->
            </div>
        </section>

        </div>
    </div>
</div>
			