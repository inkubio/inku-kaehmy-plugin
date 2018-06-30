<?php

$TABLE = "inku_kaehmy_grabbing";

function get_all_grabbings() {
    global $wpdb;
    $query = $wpdb->prepare(
        "SELECT * FROM %s;",
        $TABLE
    );
    $grabbings = $wpdb->get_col($query);
    return $grabbings;
}

function test() {
    return get_all_grabbings();
}
?>