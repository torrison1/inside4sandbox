<section class="jumbotron text-center" style="background: url('/Public/AppFront/app_default_template/img/bg1.jpg'); background-size:cover; background-position:center;">

    <div class="wblock1 text-left p-4 top_block1 container">

        <div class="row">
            <div class="col-md-6">
                <h1 class="jumbotron-heading"><?=$t->get('your_best_offer');?></h1>
                <p class="lead">
                    <?=$t->get('sale_info');?>
                </p>
                <p>
                    <a href="#" class="btn btn-lg btn-success my-2" data-toggle="modal" data-target="#order_modal">&nbsp;&nbsp;&nbsp;<?=$t->get('order_now_btn');?>&nbsp;&nbsp;&nbsp;</a>
                    &nbsp;&nbsp;&nbsp;
                    <a href="<?=$lang_link_prefix?>/auth/login?reg=1" class="btn btn-lg btn-primary my-2">&nbsp;<?=$t->get('sign_up');?>&nbsp;&gt;&gt;&nbsp;</a>

                </p>
            </div>
            <div class="col-md-6">
                <img src="/Public/AppFront/app_default_template/img/sale1.jpg" alt="Discount" width="100%" class="wblock1 mt-2">
            </div>
        </div>


    </div>

</section>
<div class="top-shadow">&nbsp;</div>

<!-- Begin page content -->
<main role="main" class="container">

    <div class="blocks-list row">
        <div class="col-md-4">
            <div class="card mb-4 box-shadow">
                <img class="card-img-top" data-src="/Public/AppFront/app_default_template/img/app2.png" src="/Public/AppFront/app_default_template/img/app2.png" alt="Card image cap">
                <div class="top-shadow">&nbsp;</div>
                <div class="card-body">
                    <h3>App development</h3>
                    <ul>
                        <li>Product Plan - from 200$</li>
                        <li>Wireframes - from 500$</li>
                        <li>Graphics Design - from 1000$</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4 box-shadow">
                <img class="card-img-top" data-src="/Public/AppFront/app_default_template/img/website2.png" src="/Public/AppFront/app_default_template/img/website2.png" alt="Card image cap">
                <div class="top-shadow">&nbsp;</div>
                <div class="card-body">
                    <h3>Web-site</h3>
                    <ul>
                        <li>Product Plan - from 40$</li>
                        <li>Wireframes - from 100$</li>
                        <li>Graphics Design - from 200$</li>
                    </ul>

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4 box-shadow">
                <img class="card-img-top" data-src="/Public/AppFront/app_default_template/img/startup2.png" src="/Public/AppFront/app_default_template/img/startup2.png" alt="Card image cap">
                <div class="top-shadow">&nbsp;</div>
                <div class="card-body">
                    <h3>Custom Web-service / Startup</h3>
                    <ul>
                        <li>Product Plan - from 200$</li>
                        <li>Wireframes - from 500$</li>
                        <li>Graphics Design - from 1000$</li>
                    </ul>
                </div>
            </div>
        </div>

        <!--   -------------------- 2nd Line of 3-block on TOP ------------------------------------   -->

    </div>
</main>


<div class="info_bottom mt-4 pb-4">
    <div class="container">
        <?=$t->get('seo_text_bottom');?>
    </div>
</div>

<div class="modal fade bd-example-modal-lg modal_request" id="order_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?=$t->get('order_now_btn');?></h5>
                <button type="button" class="close" request_container="order_modal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label class="col-form-label"><?=$t->get('request_form_label_1');?></label>
                        <input type="text" class="form-control name_contacts" name="name_contacts">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label"><?=$t->get('message');?>:</label>
                        <textarea class="form-control message" name="message"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-body-success d-none">
                <div class="text-center mt-5 mb-4">
                    <i class="fas fa-check big_icon text-success mb-4"></i>
                    <p><?=$t->get('thx_text_1');?></p>
                    <a class="refresh_form a_link" request_container="order_modal"><?=$t->get('refresh_form');?></a>
                </div>
            </div>
            <div class="modal-footer">
                <div class="d-inline-block callback_message"></div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$t->get('close');?></button>
                <button type="button" class="btn btn-primary request_btn" request_container="order_modal" request_target="Main Page Order"><?=$t->get('send_message');?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg modal_request" id="ask_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ask_modal_label"><?=$t->get('ask_question');?></h5>
                <button type="button" class="close" request_container="ask_modal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label class="col-form-label"><?=$t->get('request_form_label_1');?></label>
                        <input type="text" class="form-control name_contacts" name="name_contacts">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label"><?=$t->get('message');?>:</label>
                        <textarea class="form-control message" name="message"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-body-success d-none">
                <div class="text-center mt-5 mb-4">
                    <i class="fas fa-check big_icon text-success mb-4"></i>
                    <p><?=$t->get('thx_text_1');?></p>
                    <a class="refresh_form a_link" request_container="ask_modal"><?=$t->get('refresh_form');?></a>
                </div>
            </div>
            <div class="modal-footer">
                <div class="d-inline-block callback_message"></div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=$t->get('close');?></button>
                <button type="button" class="btn btn-primary request_btn" request_container="ask_modal" request_target="Main Page Ask Button"><?=$t->get('send_message');?></button>
            </div>
        </div>
    </div>
</div>
