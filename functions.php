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

function del_comment($comment_id) {
    global $wpdb;
    $query = $wpdb->prepare(
        "DELETE *
        FROM inku_kaehmy_comment
        WHERE ID=%d;",
        $comment_id
    );
    $wpdb->query($query);
}

function delete_grabbing($grabbing_ID) {
    global $wpdb;
    $query = $wpdb->prepare(
        "DELETE *
        FROM inku_kaehmy_grabbing
        WHERE ID=%d;",
        $grabbing_ID
    );
    $wpdb->query($query);
}

function test() {
    delete_grabbing(2444);
    return get_all_grabbings();
}


function get_all_tags() {
    global $wpdb;

    $query = "SELECT * FROM inku_kaehmy_tag;";

    $res = $wpdb->get_results($query, ARRAY_A);

    if($res){
        return $res;
    }
    else{
        return http_response_code(204);
    }

}


function get_all_tags() {
    global $wpdb;

    $query = "SELECT * FROM inku_kaehmy_tag;";

    $res = $wpdb->get_results($query, ARRAY_A);

    if($res){
        return $res;
    }
    else{
        return http_response_code(204);
    }

}

?>