    <h4><strong><a href="<?php bloginfo('url'); ?>" alt="<?php bloginfo('name'); ?>">回到网站首页</a></strong></h4>		
    <div class="myArchive">
    <ul> 
	<?php
    /*
    Plugin Name:Sitemap Navigation
    Plugin URI: http://www.igoseo.net/sitemap-navigation.html
    Description: Sitemap Navigation plugin can generate simple Archives/Sitemap based on your website posts and pages. This is not another XML sitemap plugin, but rather a nice post sitemap or page sitemap navigation.Support me by link to my website.
    Version: 3.3
    Author: Matt Lee
    Author URI: http://www.igoseo.net/
    */
	/*
    Copyright 2011  Matt Lee(Email : igoseonet@gmail.com)

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
    
    */
    $categoryPosts = $wpdb->get_results("
     SELECT post_title, ID, {$wpdb->prefix}terms.term_id AS catID, {$wpdb->prefix}terms.name AS categoryname
     FROM {$wpdb->prefix}posts, {$wpdb->prefix}term_relationships, {$wpdb->prefix}term_taxonomy, {$wpdb->prefix}terms
     WHERE {$wpdb->prefix}posts.ID = {$wpdb->prefix}term_relationships.object_id
     AND {$wpdb->prefix}terms.term_id = {$wpdb->prefix}term_taxonomy.term_id
     AND {$wpdb->prefix}term_taxonomy.term_taxonomy_id = {$wpdb->prefix}term_relationships.term_taxonomy_id
     AND {$wpdb->prefix}term_taxonomy.taxonomy = 'category'
     AND {$wpdb->prefix}posts.post_status = 'publish'
     AND {$wpdb->prefix}posts.post_type = 'post'
     ORDER BY {$wpdb->prefix}terms.term_id");
 
    $postID = 0;
     if ( $categoryPosts ) :
             $categoryID = $categoryPosts[0]->catID;
             foreach ($categoryPosts as $key => $mypost) :
                 if($categoryID == $mypost->catID) {
                     if($postID == 0) {
                         echo '<li><strong>分类:</strong> <a title="'.$mypost->categoryname.'" href="'.get_category_link($mypost->catID).'">'.$mypost->categoryname."</a>\n";
                         echo '<ul>';
                     }
     ?> 
        <li><a title="<?php echo $mypost->post_title; ?>" href="<?php echo get_permalink($mypost->ID); ?>"><?php echo $mypost->post_title; ?></a></li>
     <?php
                     $categoryID = $mypost->catID;
                     $postID++;
                 }
                 else {
                     echo "</ul>\n</li>";
                     $categoryID = $mypost->catID;
                     $postID = 0;
                 }
             endforeach;
     endif;
     echo "</ul>\n</li>";
     ?>
 
        <li><strong>页面</strong>
             <ul>
             <?php
                 // 读取所有页面
                 $mypages = $wpdb->get_results("
                         SELECT post_title, post_name, ID
                         FROM {$wpdb->prefix}posts
                         WHERE post_status = 'publish'
                         AND post_type = 'page'");
 
                if ( $mypages ) :
                     foreach ($mypages as $mypage) :
             ?> 
         <li><a title="<?php echo $mypage->post_title; ?>" href="<?php echo get_permalink( $mypage->ID ); ?>"><?php echo $mypage->post_title; ?></a></li>
         <?php endforeach; echo "</ul>\n</li>"; endif; ?>
     </ul>
		<li><strong>按月归档</strong>
	<ul>
		<?php wp_get_archives('type=monthly'); ?>
	</ul>
	<li><strong>RSS订阅</strong>
	<ul>
		<li><a rel="nofollow" href="<?php bloginfo('rdf_url'); ?>" alt="RDF/RSS 1.0 feed"><acronym title="Resource Description Framework">RDF</acronym>/<acronym title="Really Simple Syndication">RSS</acronym> 1.0 feed</a></li>
		<li><a rel="nofollow" href="<?php bloginfo('rss_url'); ?>" alt="RSS 0.92 feed"><acronym title="Really Simple Syndication">RSS</acronym> 0.92 feed</a></li>
		<li><a rel="nofollow" href="<?php bloginfo('rss2_url'); ?>" alt="RSS 2.0 feed"><acronym title="Really Simple Syndication">RSS</acronym> 2.0 feed</a></li>
		<li><a rel="nofollow" href="<?php bloginfo('atom_url'); ?>" alt="Atom feed">Atom feed</a></li>
	</ul>	
     <p><a href="http://www.igoseo.net/sitemap_baidu.xml"><strong>查看百度sitemap.xml</strong></a></p>
	 <p><a href="http://www.igoseo.net/sitemap.xml"><strong>查看谷歌sitemap.xml</strong></a></p>
 </div>