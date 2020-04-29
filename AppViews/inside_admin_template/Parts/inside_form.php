<input type="hidden" id="pdg_table" name="pdg_table" value="<?php echo $table_name; ?>"/>
<input type="hidden" id="pdg_order" name="pdg_order" value=""/>
<input type="hidden" id="pdg_asc" name="pdg_asc" value="desc"/>
<input type="hidden" id="pdg_page" name="pdg_page" value="1"/>
<input type="hidden" id="scope_type" name="scope_type" value="<?=$scope_type?>"/>


<div class="subheading">
    <div class="container">
        <div class="row">
            <div class="col-md-4 left_side">
                <div class="left_side_holder">

                    <button type="button" class="btn btn-info filters_button"><i class="fa fa-filter"
                                                                                 aria-hidden="true"></i></button>
                    &nbsp;
                    <button class="btn btn-primary" type="button" id="pdg_send"><i class="fa fa-refresh"
                                                                                   aria-hidden="true"></i></button>


                </div>
            </div>
            <div class="col-md-8 right_side">
                <div class="top_pagination">
                    <a id="pdg_page_prev" style="margin-left: 20px;">&lt;&lt;</a>
                    <span>Page: <b id="pdg_page_text">1</b></span>
                    <a id="pdg_page_next">&gt;&gt;</a>
                </div>

                <div class="buttons_holder">


                    <button type="button" class="btn btn-info pdg_bcopy">COPY</button>
                    <button type="button" class="btn btn-danger pdg_bdel">DELETE</button>
                    <a href="/inside/pdg_add/table_name" OnClick="return false;" class="btn btn-success add_btn"> + ADD</a>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="advanced_filters">
    <div class="cloce_btn"><i class="fa fa-times" aria-hidden="true"></i></div>
    <div class="corner"></div>
    <div class="container">
        <?= $inside_filters ?>
    </div>
</div>