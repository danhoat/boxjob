<?php
global $profile;
$profile_id = $profile->ID;
$skills = wp_get_post_terms( $profile_id, 'skill');

$terms = get_terms( array(
    'taxonomy'  => 'skill',
    'hide_empty' => false,
) );

$contexts = array(
        'read'   => 'manage_terms',
        'create' => 'edit_terms',
        'edit'   => 'edit_terms',
        'delete' => 'delete_terms',
        'batch'  => 'edit_terms',
    );
    $taxonomy_object  ='skill';
    $cap = $contexts[ $context ];
    $taxonomy_object = get_taxonomy( $taxonomy );
    $permission = current_user_can( $taxonomy_object->cap->$cap, $object_id );
?>

<fieldset class="form-view profile-item-row row">
    <legend class="box-md" title="">
        <i class="fa fa-fw fa-list"></i> Skill
    </legend>
    <div id="profile_skills" class="relative col-md-12">
        <form class="form-horizontal box-md form-wrapper frm-profile-edit" id="profileForm" >
            <span class="form-btn-edit">
                <button type="button" class="btn btn-sm btn-default btn-edit">
                    <i class="glyphicon glyphicon-pencil"></i>
                </button>
            </span>
            <input type="hidden" name="ID" value="<?php echo $profile_id;?>" />
            <div class="form-group m-b-none">
                <div class="view-field">
                    <div class="view-field">
                        <div class="view-control">
                            <ul class="inline list-kill" name="skill">
                                <?php
                                 $ids = array();
                                if( !is_wp_error( $skills ) && $skills){

                                    foreach($skills as $skill) {
                                        array_push($ids, $skill->term_id);
                                        echo "<li>". $skill->name."</li>"; //do something here
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="edit-field">

                   <?php

                        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
                                echo '<select multiple class="chosen-select chosen chosen-skill"  data-placeholder="Select" style="width: 400px; display: none;" name="skill">';
                                foreach ( $terms as $term ) {
                                    $class = in_array($term->term_id, $ids) ? 'selected' :'';
                                    echo "<option {$class} value='{$term->term_id}'>{$term->name}</li>";
                                }
                            echo '</select>';
                         }
            ?>
                        </select>
                   <span class="msg-profile-valid error-message" hidden="hidden">Please do not enter phone number or email.</span>
                </div>
            </div>
            <!-- Buttons-->
            <div class="form-group push-top-md edit-field">
                <div class="row">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6 text-right">
                        <button type="button" class="btn btn-cancel btn-default">Cancel</button>
                        <button type="submit" class="btn btn-save btn-primary" >Save</button>
                        <button type="button" style="display: none;" class="btn-sending btn btn-default" disabled=""><img src="http://images.vietnamworks.com/loading.gif" alt="">Sending</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</fieldset>