<?php
//TODO: sanitize_key() <- Add this
//Useful link
//https://stackoverflow.com/questions/41362277/wp-rest-api-custom-end-point-post-request
//https://stackoverflow.com/questions/44189832/wordpress-rest-api-custom-endpoint-for-method-post


function grabbing_parser($grabbing_array) {
    $grabbing_array = change_array_key($grabbing_array,'grabbing_text','text');
    $grabbing_array = change_array_key($grabbing_array,'grabbing_title','title');
    $grabbing_array = change_array_key($grabbing_array,'grabbing_batch','batch');
    $grabbing_array = change_array_key($grabbing_array,'time_stamp','timestamp');
    $user_info = get_userdata($grabbing_array['userID']);
    $username = $user_info->first_name . " " . $user_info->last_name;
    $grabbing_array['username'] = $username;
    $grabbing_array['is_hallitus'] = boolval($grabbing_array['is_hallitus']);
    return $grabbing_array;
}

function comment_parser($comment_array) {
    $comment_array = change_array_key($comment_array, 'time_stamp', 'timestamp');
    $comment_array = change_array_key($comment_array,'comment_text','text');
    $user_info = get_userdata($comment_array['userID']);
    $username = $user_info->first_name . " " . $user_info->last_name;
    $comment_array['username'] = $username;
    return $comment_array;
}

function change_array_key($array, $old_key, $new_key) {

    if (!array_key_exists($old_key, $array))
        return $array;
    
    $array[$new_key] = $array[$old_key];
    unset($array[$old_key]);

    return $array;
}

/*------------------GETs---------------------------*/
function get_all_grabbings() {
    // Returns all grabbings in the database
    global $wpdb;
    $query = "SELECT * FROM inku_kaehmy_grabbing;";
    $grabbings = $wpdb->get_results($query, ARRAY_A);
    foreach($grabbings as &$grabbing) {
        $grabbing = grabbing_parser($grabbing);
    }
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
    $grabbing = $wpdb->get_row($query, ARRAY_A);
    $grabbing = grabbing_parser($grabbing);
    return $grabbing;
}

function get_all_tags() {
    global $wpdb;
    $query = "SELECT * FROM inku_kaehmy_tag;";
    $res = $wpdb->get_results($query, ARRAY_A);

    return $res;
}

function get_subcomments($parent_id) {
    global $wpdb;
    $query = $wpdb->prepare(
        "SELECT c.ID, c.userID, c.comment_text, c.time_stamp, c.depth
        FROM inku_kaehmy_comment AS c, inku_kaehmy_has_comment AS h
        WHERE c.ID = h.comment_ID
        AND h.parent_comment_ID IS NOT NULL
        AND h.parent_comment_ID = %d",
        $parent_id
    );
    $comments = $wpdb->get_results($query, ARRAY_A);
    foreach($comments as &$comment) {
        $comment = comment_parser($comment);
        $comment['comments'] = get_subcomments($comment['ID']);
    }
    return $comments;
}

function get_grabbing_comments($request){
    global $wpdb;

    $grabbing_ID = (int)$request['id'];
    $query = $wpdb->prepare(
         "SELECT * FROM inku_kaehmy_comment WHERE ID IN 
            (SELECT comment_ID
            FROM inku_kaehmy_has_comment
            WHERE parent_grabbing_ID = %d AND parent_comment_ID IS NULL)",
         $grabbing_ID
     );
    $comments = $wpdb->get_results($query, ARRAY_A);

    foreach($comments as &$comment) {
        $comment = comment_parser($comment);
        $comment['comments'] = get_subcomments($comment['ID']);
    }
    return $comments;
}

function get_logged_in_user_id($request) {
    $response = new WP_REST_response();
    if (is_user_logged_in()) {
        $response->set_data(get_current_user_id());
        return $response;
    }
    return -1;
}


/*---------------------DELETEs----------------------*/ 
function delete_comment($request) {

    // Should be changed to parse commentID and parentID from
    // request and the call delete_comment_by_ID with commentID
    // and parent_grabbing_ID

    $response = new WP_REST_response();
    $nonce = $request['_wpnonce'];

    if(! wp_verify_nonce($nonce, 'delete_comment')){
        $response->set_status(418);
        return;
    }
    $comment_id = $request['id'];
    
    if(is_user_logged_in()){
        global $wpdb;
        $query = $wpdb->prepare(
            "DELETE
            FROM inku_kaehmy_comment
            WHERE ID=%d;",
            $comment_id
        );
        $wpdb->query($query);
        return $response->set_status(200);
    }
    $response->set_status(404);
    return $response;
}

function delete_comment_by_ID($comment_id, $parent_grabbing_id) {

    // Get all child comment IDs.
    global $wpdb;
    $child_query = $wpdb->prepare(
        "SELECT comment_ID
        FROM inku_kaehmy_has_comment
        WHERE parent_grabbing_ID=%d
        AND parent_comment_ID=%d;",
        $parent_grabbing_id, $comment_id
    );
    $child_ids = $wpdb->get_col($child_query);

    // Call this function for all child comments.
    foreach($child_ids as &$child_id){
        delete_comment_by_ID($child_id, $parent_grabbing_id);
    }

    // remove has_comment entry with given grabbing_id and comment_id
    $hc_query = $wpdb->prepare(
        "DELETE
        FROM inku_kaehmy_has_comment
        WHERE comment_ID=%d
        AND parent_grabbing_ID=%d;",
        $comment_id, $parent_grabbing_id
    );
    $wpdb->query($hc_query);

    // Delete comment with given comment_id
    $query = $wpdb->prepare(
        "DELETE
        FROM inku_kaehmy_comment
        WHERE ID=%d;",
        $comment_id
    );
    $wpdb->query($query);
}

function delete_grabbing($request) {

    $response = new WP_REST_response();

    $nonce = $request['_wpnonce'];

    if(! wp_verify_nonce($nonce, 'delete_grabbing')){
        $response->set_status(418);
        return $response;
    }

    if(is__user_logged_in()){
        global $wpdb;
        // $hc_query = $wpdb-> prepare(
        //     "SELECT comment_ID
        //     FROM inku_kaehmy_has_comment
        //     WHERE parent_grabbing_id=%d",
        //     $grabbing_ID
        // );
        // $comment_ids = $wpdb->get_col($hc_query);
        // foreach($comment_ids as &$comment){

        // }

        $query = $wpdb->prepare(
            "DELETE
            FROM inku_kaehmy_grabbing
            WHERE ID=%d;",
            $grabbing_ID
        );
        $wpdb->query($query);
        $response->set_status(200);
        return $response;
    }
    $response->set_status(404);
    return $response;
}
/*--------------POSTs----------------------*/ 
/*TODO: Add these to post. Must be generated by quesry.    
//$userID = get_user_id();
    //$ID = something()*/
function post_grabbing($request){

    $response = new WP_REST_response();

    $nonce = $request->get_header('X-WP-Nonce');
/*
    if(! wp_verify_nonce($nonce, 'post_grabbing')){
        $response->set_status(418);
        return $response;
    }
*/
    if(! (current_user_can('administrator') || current_user_can('subscriber'))){
        $response->set_status(418);
        $response->set_data(get_current_user_id());
        return $response;
    }
    
    try {
        if(is_user_logged_in()){
            $is_hallitus = $request['is_hallitus'];
            $grabbing_text = $request['text'];
            $grabbing_title = $request['title'];
            $grabbing_batch = $request['batch'];
            if (empty($grabbing_text) or 
            empty($grabbing_title) or empty($grabbing_batch)) {
                $response->set_data('ei vittu nyt');
                $response->set_status(401);
                return $response;
            }
            global $wpdb;
            $user_id = get_current_user_id();
            $query = $wpdb->prepare(
                "INSERT INTO inku_kaehmy_grabbing (userID, is_hallitus, 
                grabbing_text, grabbing_title, grabbing_batch)
                VALUES (%d, %d, '%s', '%s', '%s');",
                $user_id, $is_hallitus, $grabbing_text, $grabbing_title, $grabbing_batch
            );
            $wpdb->query($query);
            $response->set_status(201);
            return $response;
        }
    } catch (Exception $e) {
        $response->set_status(500);
        $response->set_date($e->getMessage());
        return $response;
    }
    $response->set_status(401);
    return $response;
}



function post_comment($request){

    $response = new WP_REST_response();
    global $wpdb;

    if(! (current_user_can('administrator') || current_user_can('subscriber'))){
        $response->set_status(418);
        $response->set_data(get_current_user_id());
        return $response;
    }

    $params = $request->get_params();

    if(is_user_logged_in()){
        $comment_text = $request['text'];
        $parent_grabbing_id = $request['parent_grabbing_id'];
        $parent_comment_id = $request['parent_comment_id'];
        $user_id = get_current_user_id();

        global $wpdb;
        $query = $wpdb->prepare(
                "INSERT INTO inku_kaehmy_comment (userID, comment_text, depth)
                VALUES (%d, '%s', %d);",
                $user_id, $comment_text, 0
        );
        $wpdb->query($query);
        
        $comment_id = $wpdb->get_var("SELECT LAST_INSERT_ID();");
        if ($parent_comment_id) {
            $query = $wpdb->prepare(
                "INSERT INTO (comment_ID, parent_grabbing_ID, parent_comment_ID)
                VALUES (%d, %d, %d);",
                $comment_id, $parent_grabbing_id, $parent_comment_id
            );
        } else {
            $query = $wpdb->prepare(
                "INSERT INTO (comment_ID, parent_grabbing_ID)
                VALUES (%d, %d);",
                $comment_id, $parent_grabbing_id
            );
        }
        $wpdb->query($query);

        $response->set_status(201);
        return $response;
    }
    $response->set_status(401);
    return $response;
}

/*-------------------------PUTs-----------------------*/
function put_grabbing($request) {
    
    $response = new WP_REST_response();

    $nonce = $request['_wpnonce'];


    if(! wp_verify_nonce($nonce, 'put_crabbing')){
        $response->set_status(418);
        return $response;
    }

    $params = $request->get_params();

    $comment_id = $request['id'];
    if(is_user_logged_in()){
        $grabbing_text = $request['text'];
        $grabbing_title = $request['title'];
        $grabbing_batch = $request['batch'];
        global $wpdb;

        // $query = $wpdb->prepare(

        // );
        // $wpdb->query($query);
        $response->set_status(200);
        return $response;
    }
    $response->set_status(401);
    return $response;
}

function put_comment($request){
    
    $response = new WP_REST_response();

    $nonce = $request['_wpnonce'];

    if(! wp_verify_nonce($nonce, 'put_comment')){
        $response->set_status(418);
        return $response;
    }
    $comment_id = $request['id'];
    
    $params = $request->get_params();

    if(is_user_logged_in()){
        $grabbing_text = $request['text'];
        $grabbing_title = $request['title'];
        $grabbing_patch = $request['patch'];
        global $wpdb;

        // $query = $wpdb->prepare(

        // );
        // $wpdb->query($query);
        $response->set_status(200);
        return $response;
    }
    $response->set_status(401);
    return $response;

}


function test() {
    return get_all_tags();
}

?>
