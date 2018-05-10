<?php
class td_data_source {

    static $fake_loop_offset = 0; //used by the found row hook in templates to fix pagination. The blocks do not use this since we use custom pagination there.


    /**
     * converts a pagebuilde array to a wordpress query args array
     * creates the $args array from shortcodes - used by the pagebuilde + widgets + by the metabox_to_args
     * @param string $atts : the shortcode string
     * @param string $paged : page number  /1  or  /2
     * @return array
     */
    static function shortcode_to_args($atts = '', $paged = '') {
        //print_r($atts);
        extract(shortcode_atts(
                array(
                    'post_ids' => '',
                    'category_ids' => '',
                    'category_id' => '',
                    'tag_slug' => '',
                    'sort' => '',
                    'limit' => '', /*'limit' => 5,*/
                    'autors_id' => '',
                    'installed_post_types' => '',
                    'posts_per_page' => '',  //@todo se poate sa nu mai fie folosit
                    'offset' => '',
                    'live_filter' => '',
                    'live_filter_cur_post_id' => '', //this is auto generated by the block render ( add_live_filter_atts ) only when it's needed - it's the current post id
                    'live_filter_cur_post_author' => '' //auto generated - author_id of current post
                ),
                $atts
            )
        );

        //init the array
        $wp_query_args = array(
            'ignore_sticky_posts' => 1,
            'post_status' => 'publish'
        );



	    /*  ----------------------------------------------------------------------
	        jetpack sorting - this will return here if that's the case because it dosn't work with other filters (it's site wide, no category + this or other combinations)
	    */
	    if ($sort == 'jetpack_popular_2') {
		    if (function_exists('stats_get_csv')) {
			    // the damn jetpack api cannot return only posts so it may return pages. That's why we query with a bigger + 5 limit
			    // so that if the api returns also 5 pages mixed with the post we will still have the desired number of posts
			    // NOTE: stats_get_csv has a cache built in!

			    $jetpack_api_posts = stats_get_csv('postviews', array(
				    'days' => 2,
				    'limit' => $limit + 5
			    ));

			    if (!empty($jetpack_api_posts) and is_array($jetpack_api_posts)) {
                    $jetpack_api_posts_ids = wp_list_pluck($jetpack_api_posts, 'post_id');

                        // Filter the returned posts. Remove all posts that do not match the default 'post' Post Type.
                        foreach ( $jetpack_api_posts_ids as $k => $post_id ) {
                            if ( get_post_type($post_id) != 'post' ) {
                                unset( $jetpack_api_posts_ids[$k] );
                            }
                        }

				    $wp_query_args['post__in'] = $jetpack_api_posts_ids;
                    $wp_query_args['orderby'] = 'post__in';
				    $wp_query_args['posts_per_page'] = $limit;

				    return $wp_query_args;
			    }
		    }
		    return array(); // empty array makes WP_Query not run. Usually the return value of this function is feed directly to a new WP_Query
	    }


        //the query goes only via $category_ids - for both options ($category_ids and $category_id) also $category_ids overwrites $category_id
        if (!empty($category_id) and empty($category_ids)) {
            $category_ids = $category_id;
        }


        if (!empty($category_ids)) {
            $wp_query_args['cat'] = $category_ids;
        }

        if (!empty($tag_slug)) {
            $wp_query_args['tag'] = str_replace(' ', '-', $tag_slug);
        }

        switch ($sort) {
            case 'featured':
                if (!empty($category_ids)) {
                    //for each category, get the object and compose the slug
                    $cat_id_array = explode (',', $category_ids);

                    foreach ($cat_id_array as &$cat_id) {
                        $cat_id = trim($cat_id);

                        //get the category object
                        $td_tmp_cat_obj =  get_category($cat_id);
                        if ( !empty($td_tmp_cat_obj) ) {
                            //make the $args
                            if (empty($wp_query_args['category_name'])) {
                                $wp_query_args['category_name'] = $td_tmp_cat_obj->slug; //get by slug (we get the children categories too)
                            } else {
                                $wp_query_args['category_name'] .= ',' . $td_tmp_cat_obj->slug; //get by slug (we get the children categories too)
                            }
                        }
                        unset($td_tmp_cat_obj);
                    }
                }

                $wp_query_args['cat'] = get_cat_ID(TD_FEATURED_CAT); //add the fetured cat
                break;
            case 'oldest_posts':
                $wp_query_args['order'] = 'ASC';
                break;
            case 'popular':
                $wp_query_args['meta_key'] = td_page_views::$post_view_counter_key;
                $wp_query_args['orderby'] = 'meta_value_num';
                $wp_query_args['order'] = 'DESC';
                break;
            case 'popular7':
                $wp_query_args['meta_query'] = 	array(
                    'relation' => 'AND',
                    array(
                        'key'     => td_page_views::$post_view_counter_7_day_total,
                        'type'    => 'numeric'
                    ),
                    array(
                        'key'     => td_page_views::$post_view_counter_7_day_last_date,
                        'value'   => (date('U') - 604800), // current date minus 7 days
                        'type'    => 'numeric',
                        'compare' => '>'
                    )
                );
                $wp_query_args['orderby'] = td_page_views::$post_view_counter_7_day_total;
                $wp_query_args['order'] = 'DESC';
                break;
            case 'review_high':
                $wp_query_args['meta_key'] = 'td_review_key';
                $wp_query_args['orderby'] = 'meta_value_num';
                $wp_query_args['order'] = 'DESC';
                break;
            case 'random_posts':
                $wp_query_args['orderby'] = 'rand';
                break;
            case 'alphabetical_order':
                $wp_query_args['orderby'] = 'title';
                $wp_query_args['order'] = 'ASC';
                break;
            case 'comment_count':
                $wp_query_args['orderby'] = 'comment_count';
                $wp_query_args['order'] = 'DESC';
                break;
            case 'random_today':
                $wp_query_args['orderby'] = 'rand';
                $wp_query_args['year'] = date('Y');
                $wp_query_args['monthnum'] = date('n');
                $wp_query_args['day'] = date('j');
                break;
            case 'random_7_day':
                $wp_query_args['orderby'] = 'rand';
                $wp_query_args['date_query'] = array(
                            'column' => 'post_date_gmt',
                            'after' => '1 week ago'
                            );
                break;
        }

        if (!empty($autors_id)) {
            $wp_query_args['author'] = $autors_id;
        }

        //add post_type to query
        if (!empty($installed_post_types)) {
            $array_selected_post_types = array();
            $expl_installed_post_types = explode(',', $installed_post_types);

            foreach ($expl_installed_post_types as $val_this_post_type) {
                if (trim($val_this_post_type) != '') {
                    $array_selected_post_types[] = trim($val_this_post_type);
                }
            }

            $wp_query_args['post_type'] = $array_selected_post_types;//$installed_post_types;
        }


        /**
         * the live filters are generated in td_block.php and are added when the block is rendered on the page in the atts of the block
         * @see td_block::add_live_filter_atts
         */
        if (!empty($live_filter)) {
            switch ($live_filter) {
                case 'cur_post_same_tags':

                    $tags = wp_get_post_tags($live_filter_cur_post_id);
                    if ($tags) {
                        $taglist = array();
                        for ($i = 0; $i <= 4; $i++) {
                            if (!empty($tags[$i])) {
                                $taglist[] = $tags[$i]->term_id;
                            } else {
                                break;
                            }
                        }
                        $wp_query_args['tag__in'] = $taglist;
                        $wp_query_args['post__not_in'] = array($live_filter_cur_post_id);

                        //print_r($wp_query_args);
                        //die;

                    }
                    break;

                case 'cur_post_same_author':
                    $wp_query_args['author'] = $live_filter_cur_post_author;
                    $wp_query_args['post__not_in'] = array($live_filter_cur_post_id);
                    break;

                case 'cur_post_same_categories':
                    //print_r($atts);
                    $wp_query_args['category__in'] = wp_get_post_categories($live_filter_cur_post_id);
                    $wp_query_args['post__not_in'] = array($live_filter_cur_post_id);
                    break;

            }
        }



        //show only unique posts if that setting is enabled on the template
        /*if (td_unique_posts::$show_only_unique == true) {
            $wp_query_args['post__not_in'] = td_unique_posts::$rendered_posts_ids;
        }*/
        if (td_unique_posts::$unique_articles_enabled == true) {
            $wp_query_args['post__not_in'] = td_unique_posts::$rendered_posts_ids;
        }



        // post in section
        if (!empty($post_ids)) {

            //split posts id string
            $post_id_array = explode (',', $post_ids);

            $post_in = array();
            $post_not_in = array();

            // split ids into post_in and post_not_in
            foreach ($post_id_array as $post_id) {
                $post_id = trim($post_id);

                // check if the ID is actually a number
                if (is_numeric($post_id)) {
                    if (intval($post_id) < 0) {
                        $post_not_in [] = str_replace('-', '', $post_id);
                    } else {
                        $post_in [] = $post_id;
                    }
                }
            }

            // don't pass an empty post__in because it will return had_posts()
            if (!empty($post_in)) {
                $wp_query_args['post__in'] = $post_in;
                $wp_query_args['orderby'] = 'post__in';
            }

            // check if the post__not_in is already set, if it is merge it with $post_not_in
            if (!empty($post_not_in)) {
                if (!empty($wp_query_args['post__not_in'])){
                    $wp_query_args['post__not_in'] = array_merge($wp_query_args['post__not_in'], $post_not_in);
                } else {
                    $wp_query_args['post__not_in'] = $post_not_in;
                }
            }
        }


        //custom pagination limit
        if (empty($limit)) {
            $limit = get_option('posts_per_page');
        }
        $wp_query_args['posts_per_page'] = $limit;

        //custom pagination
        if (!empty($paged)) {
            $wp_query_args['paged'] = $paged;
        } else {
            $wp_query_args['paged'] = 1;
        }

        // offset + custom pagination - if we have offset, wordpress overwrites the pagination and works with offset + limit
        if (!empty($offset) and $paged > 1) {
            $wp_query_args['offset'] = $offset + ( ($paged - 1) * $limit) ;
        } else {
            $wp_query_args['offset'] = $offset ;
        }


        //set this variable to pass it to the filter that fixes the pagination on the templates with fake loops. It is not used on blocks because the blocks have custom pagination
        self::$fake_loop_offset = $offset;


        //print_r($wp_query_args);

        return $wp_query_args;
    }




    /**
     * converts a post metabox value array to a wordpress query args array
     * @param $td_homepage_loop_filter - the post loop filer metadata array [$td_homepage_loop will be applied actually]
     * @param string $paged
     * @return array
     */
    static function metabox_to_args($td_homepage_loop_filter, $paged = '') {


        $wp_query_args = self::shortcode_to_args($td_homepage_loop_filter, $paged);



        //$wp_query_args['paged'] = $paged;

        if (!empty($td_homepage_loop_filter['show_featured_posts'])) {
            if (empty($wp_query_args['cat'])) {
                $wp_query_args['cat'] = '-' . get_cat_ID(TD_FEATURED_CAT);
            } else {
                $wp_query_args['cat'] .= ',-' . get_cat_ID(TD_FEATURED_CAT);
            }
        }


        $wp_query_args['ignore_sticky_posts'] = 0;

        // custom pagination for the fake template loops
        if (isset($wp_query_args['offset']) and $wp_query_args['offset'] > 0) {
            //fix reported posts for the fake loops
            add_filter('found_posts', array(__CLASS__, 'hook_fix_offset_pagination'), 1, 2 );
        }


        //print_r($wp_query_args);

        return $wp_query_args;
    }

    // custom pagination for the fake template loops - used by hook
    static function hook_fix_offset_pagination($found_posts, $query) {
        remove_filter('found_posts','hook_fix_offset_pagination');
        return (int)$found_posts - (int)td_data_source::$fake_loop_offset;
    }





    /**
     * is used by all the blocks
     * @param string $atts
     * @param string $paged - is used by ajax
     * @return WP_Query
     */
    static function &get_wp_query ($atts = '', $paged = '') { //by ref
        $args = self::shortcode_to_args($atts, $paged);

        $td_query = new WP_Query($args);
        return $td_query;
    }


    /**
     * used by the ajax search feature
     * @param $search_string
     * @return WP_Query
     */
    static function &get_wp_query_search($search_string) {
        $args = array(
            's' => $search_string,
            //'post_type' => array('post', 'page'),
            'posts_per_page' => 4,
            'post_status' => 'publish'
        );

        $td_query = new WP_Query($args);
        return $td_query;
    }







}

