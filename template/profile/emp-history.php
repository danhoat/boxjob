<fieldset class="form-view profile-item-row row">
    <legend class="box-md" title="">
        <i class="fa fa-fw fa-list"></i> Employment History
    </legend>
    <div id="profile_skills" class="relative col-md-12">

        <form class="form-horizontal box-md form-wrapper" id="profileForm" >
            <span class="form-btn-edit">
                <button type="button" class="btn btn-sm btn-default btn-edit">
                    <i class="glyphicon glyphicon-pencil"></i>
                </button>
            </span>
            <div class="form-group m-b-none row">
                <div class="view-field">
                    <div class="view-field">
                        <div class="view-control"><p><?php echo $content;?></p></div>
                    </div>
                </div>
                <div class="edit-field">

                    <div class="form-group col-md-12">
                        <p>
                            <label>
                                Input details of your employment history. The more detail you include about your previous experience, the more likely you are to appear in search results
                            </label>
                        </p>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="formGroupExampleInput">* Position</label>
                        <input type="text" class="form-control" name="position" id="position" placeholder="e.g. UI/UX Designer">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="formGroupExampleInput2">* Company</label>
                        <input type="text" class="form-control" name="company" id="company" placeholder="e.g. ACB Bank">
                    </div>
                    <div class="form-group offset">
                        <div class="col-md-4">
                            <label for="from_month">From month</label>
                        <input type="text" class="form-control" name="from_month" id="from_month" placeholder="e.g. 09/2012">
                        </div>
                        <div class="col-md-4">
                            <label for="to_month">To month</label>
                        <input type="text" class="form-control" id="to_month" name="to_month" placeholder="e.g. 09/2015">


                        </div>
                         <div class="col-md-4">
                            <label for="to_month" class="col-md-12"> &nbsp; </label>
                            <label for="to_month"><input type="checkbox" name="is_working" />Current working</label>


                        </div>
                    </div>
                      <div class="form-group col-md-12">
                        <label>Description</label>
                        <textarea name="history_des" class="history-des" cols="10" rows="5"></textarea>
                        <p>( *) is required field</p>
                    </div>


                </div>
            </div>
            <!-- Buttons-->
            <div class="form-group push-top-md edit-field">
                <div class="row">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6 text-right">
                        <button type="button" class="btn btn-cancel btn-default">Cancel</button>
                        <button type="button" class="btn btn-save btn-primary" >Save</button>
                        <button type="button" style="display: none;" class="btn-sending btn btn-default" disabled=""><img src="http://images.vietnamworks.com/loading.gif" alt="">Sending</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
    <button data-type="edit-only" type="button" class="btn btn-default btn-block no-border add-one-more-section" style="display: inline-block;">
        <strong>Add Summary</strong>
    </button>
</fieldset>