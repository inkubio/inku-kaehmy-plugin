<?php

function get_all_grabbings() {
    // Returns all grabbings in the database
    global $wpdb;
    $query = "SELECT * FROM inku_kaehmy_grabbing;";
    $grabbings = $wpdb->get_results($query, ARRAY_A);
    return $grabbings;
}

function get_grabbing($request) {
    // Param ID returns grabbing with given ID
    $grabbing_ID = (int)$request['id'];
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

function delete_comment($request) {

    $nonce = $request['_wpnonce'];

    if(! wp_verify_nonce($nonce, 'delete_comment')){
        exit;
    }
    $comment_id = $request['id'];
    if(is__user_logged_in()){
        global $wpdb;
        $query = $wpdb->prepare(
            "DELETE
            FROM inku_kaehmy_comment
            WHERE ID=%d;",
            $comment_id
        );
        $wpdb->query($query);
    }
}

function delete_grabbing($request) {

    $nonce = $request['_wpnonce'];

    if(! wp_verify_nonce($nonce, 'delete_comment')){
        exit;
    }

    if(is__user_logged_in()){
        global $wpdb;
        $query = $wpdb->prepare(
            "DELETE
            FROM inku_kaehmy_grabbing
            WHERE ID=%d;",
            $grabbing_ID
        );
        $wpdb->query($query);
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
        return http_response_code(404);
    }
}

function test() {
    return get_all_tags();
}

function get_grabbing_comments($request){
    global $wpdb;

    $grabbing_ID = (int)$request['id'];

    $query = $wpdb->prepare(
        "SELECT * FROM inku_kaehmy_comment WHERE ID IN 
        (SELECT comment_ID FROM inku_kaehmy_has_comment WHERE parent_grabbing_ID = %d)
        ", $grabbing_ID);


    $res = $wpdb->get_results($query, ARRAY_A);

    if($res){
        return $res;
    }
    else{
        return http_response_code(404);
    }
}

?>