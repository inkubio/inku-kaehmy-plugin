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