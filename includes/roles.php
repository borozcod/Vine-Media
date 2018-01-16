<?php
/*
* Register Series admin
*/

function register_series_role() {
    add_role('series-admin', 'Series Admin');
}

function remove_series_role() {
    remove_role('series-admin', 'Series Admin');
}

/*
* Grant Series Admin capabilities
*/

function series_add_capabilities() {

    $roles = array('administrator', 'editor', 'series-admin');

    foreach ($roles as $the_role) {
        $role = get_role($the_role);
        $role->add_cap('read');
        $role->add_cap('edit_series');
        $role->add_cap('publish_series');
        $role->add_cap('edit_published_series');
    }
}
