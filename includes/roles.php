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

    $manager_roles = array('administrator', 'editor');

    foreach ($manager_roles as $the_role) {
        $role = get_role($the_role);
        $role->add_cap('read_private_series');
        $role->add_cap('edit_others_series');
        $role->add_cap('edit_private_series');
        $role->add_cap('delete_series');
        $role->add_cap('delete_published_series');
        $role->add_cap('delete_private_series');
        $role->add_cap('delete_others_series');
    }
}

/*
* Removes Series Admin capabilities
*/
function series_remove_capabilities() {

    $manager_roles = array('administrator', 'editor');

    foreach ($manager_roles as $the_role) {
        $role = get_role($the_role);
        $role->remove_cap('read');
        $role->remove_cap('edit_series');
        $role->remove_cap('publish_series');
        $role->remove_cap('edit_published_series');
        $role->remove_cap('read_private_series');
        $role->remove_cap('edit_others_series');
        $role->remove_cap('edit_private_series');
        $role->remove_cap('delete_series');
        $role->remove_cap('delete_published_series');
        $role->remove_cap('delete_private_series');
        $role->remove_cap('delete_others_series');
    }
}
