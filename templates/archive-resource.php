<?php get_header(); 

$resource_type = get_terms( 'resource_type', array( 'hide_empty' => false) );
$resource_topics = get_terms( 'resource_topic', array( 'hide_empty' => false) ); 
?>
<div class="container">
    <div class="resource-container">
        <select name="resource_filter" id="r_filter">
            <option name="">Select Resource Types</option>
                <?php foreach($resource_type as $type){ ?>
                    <option name="<?php echo $type->slug; ?>"><?php echo $type->name; ?></option>
                <?php } ?>
        </select>
        <select name="resource_topic_filter" id="t_filter">
            <option name="">Select Resource Topics</option>
                <?php foreach($resource_topics as $topic){ ?>
                    <option name="<?php echo $topic->slug; ?>"><?php echo $topic->name; ?></option>
                <?php } ?>
        </select>
    </div>
    <div id="resource_listing">
        <?php  $args = array(
            'post_type' => 'resource',
            'post_status'=>"publish",
            'posts_per_page' => -1,
            'order'=> 'ASC',
        );

        $query = new WP_Query($args);
        if($query->have_posts()){
            while($query->have_posts()){ 
            $query->the_post();
            the_title(); echo '<br>';
            }
        } ?>
    </div>
    <div id="response_data"></div>
</div>


<?php get_footer(); ?>
