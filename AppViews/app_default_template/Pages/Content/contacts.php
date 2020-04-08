<!-- ++++ contact form design ++++ -->
<section class="common-form-section contact-form-wrapper mt-4">
    <div class="container">
        <!--end section title -->
        <div class="row">
            <div class="col-md-3">
                <iframe width="100%" height="370" frameborder="0" style="border:1px solid silver"
                        src="https://www.google.com/maps/embed/v1/place?q=place_id:ChIJBUVa4U7P1EAR_kYBF9IxSXY&key=<?=$GLOBALS['inside4_main_config']['Website']['google_maps_key2']?>" allowfullscreen>

                </iframe>
            </div>
            <div class="col-md-5">
                <div class="customise-form contact-form clearfix">
                    <form class="contacts_form" method="post">
                        <h3><?=$t->get('contact_us_h3');?></h3>

                        <div class="form-group customised-formgroup"> <span class="icon-user"></span>
                            <input type="text" name="name" class="name form-control" placeholder="<?=$t->get('name');?>">
                        </div>
                        <div class="form-group customised-formgroup"> <span class="icon-envelope"></span>
                            <input type="email" name="email" class="email form-control" placeholder="Email">
                        </div>
                        <div class="form-group customised-formgroup"> <span class="icon-teleТелефон"></span>
                            <input type="text" name="phone" class="phone form-control" placeholder="<?=$t->get('phone');?>">
                        </div>
                        <div class="form-group customised-formgroup"> <span class="icon-bubble"></span>
                            <textarea name="message" class="message form-control" placeholder="<?=$t->get('message');?>" style="height: 110px;"></textarea>
                        </div>

                        <div class="">
                            <a class="btn btn-primary text-white send_contacts_form"><?=$t->get('send_message');?></a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <div class="contact-information">
                    <h3><?=$t->get('our_contacts');?></h3>
                    <div><?=$t->get('our_phone');?>:
                        <div><a href="tel:065557755"><?=$t->get('manager_phone');?></a></div>
                    </div>
                    <div>Skype: alex_xandr</div>
                    <div><?=$t->get('our_email');?>: <a href="mailto:torrison1@gmail.com">torrison1@gmail.com</a></div>
                    <div><?=$t->get('our_address');?></div>
                    <div><?=$t->get('office_time');?></div>
                </div>
            </div>

        </div>
    </div>
</section>
