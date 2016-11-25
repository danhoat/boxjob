<?php $search_url = 'http://localhost/et/jb/?page_id=25/'; ?>
<section id="search_line" class="container-fluid search-line">
    <div class="container">
        <div class="row-fluid">
            <div class="col-md-12">
                <?php
                $search_url = bx_get_static_link('search-job');
                ?>
                <form class="form-inline" role="form" action="<?php echo home_url('search-job');?>" method="GET">
                <div class="col-md-10">
                    <div class="form-group col-md-6 search-input-text">
                        <?php
                        $keyword       = get_query_var( 'keyword' );
                        ?>
                        <input type="text" class="form-control keyword" value="<?php echo esc_attr($keyword);?>" id="keyword" name="keyword"  placeholder="<?php _e('Enter job title,position,skill','boxtheme');?>">
                    </div>
                    <div class="form-group col-md-3 col-xs-12 search-input-text">
                        <?php
                        global $location;
                        $locations = isset($_GET['loc']) ? $_GET['loc'] : 0;

                        $args = array(
                            'show_option_all'    => 'Select a location',
                            'show_option_none'   => '',
                            'option_none_value'  => '-1',
                            'echo'               => 0,
                            'selected'           => $locations,
                            'hierarchical'       => 1,
                            'name'               => 'loc',
                            'class'              => 'is_location postform 1chosen-multi1',
                            'taxonomy'           => 'location',
                            'hide_if_empty'      => false,
                            'value_field'        => 'slug',
                            );

                        $dropdown = wp_dropdown_categories($args );
                        echo $dropdown;
                        ?>
                    </div>
                    <div class="form-group col-md-3 col-xs-12 search-input-text">
                        <?php
                        global $cat;
                        $cat = isset($_GET['cat']) ? $_GET['cat'] : 0;
                        $args = array(
                            'show_option_all'    => 'All categories',
                            'show_option_none'   => '',
                            'echo'               => 0,
                            'selected'           => $cat,
                            'hierarchical'       => 1,
                            'name'               => 'cat',
                            'class'              => 'is_cat postform chosen-multi1',
                            'taxonomy'           => 'job_cat',
                            'hide_if_empty'      => false,
                            'value_field'        => 'slug',
                            );

                        $dropdown = wp_dropdown_categories($args );
                        $place_holder =   __("Select category","boxtheme");
                        $string  = ' data-placeholder= "'.__("Select category",'boxtheme').'" id=';
                        //$dropdown = str_replace('id=',$string, $dropdown);
                        echo $dropdown;
                        ?>

                    </div>
                </div>

                <div class="form-group col-md-2 col-xs-12">
                        <button type="submit" class="btn btn-default"><i class="fa fa-fw fa-search hidden-sm"></i> &nbsp; <?php _e('Search','boxtheme');?> &nbsp; &nbsp; </button>
                </div>
                </form>
            </div>

        </div>
    </div>
</section>