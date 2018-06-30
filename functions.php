<?php

function get_all_grabbings() {
    // Returns all grabbings in the database
    global $wpdb;
    $query = "SELECT * FROM inku_kaehmy_grabbing;";
    $grabbings = $wpdb->get_results($query, ARRAY_A);
    return $grabbings;
}

function get_grabbing($grabbing_ID) {
    // Param ID returns grabbing with given ID
    global $wpdb;
    $query = $wpdb->prepare(
        "SELECT * 
        FROM inku_kaehmy_grabbing
        WHERE ID=%d;",
        $grabbing_ID
    );
    $grabbing = $wpdb->get_row($query);
    return $grabbing;
}

//function get_comment($comment_id) {}

function test() {
    return get_grabbing(666);
}

?>