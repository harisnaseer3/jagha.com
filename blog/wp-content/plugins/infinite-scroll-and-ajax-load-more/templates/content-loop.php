<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
	</header>
	<div class="entry-content">
		<?php the_post_thumbnail(); ?>
		<?php the_excerpt();?>
	</div>
	<footer class="entry-footer">
		<span class="byline"><span class="screen-reader-text"><?php esc_html_e(__( 'Posted by', 'bl-scroll' )); ?></span><span class="author vcard"><a class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ));  ?>"><?php echo esc_html( get_the_author() ); ?></a></span></span>
		<span class="posted-on"><a href="<?php echo esc_url( get_the_permalink() ); ?>" rel="bookmark"><time class="entry-date published" style="text-overflow: ellipsis;"><?php echo esc_html(get_the_time('F d, Y')); ?></time></a></span>
		<span class="cat-links"><span class="screen-reader-text"><?php esc_html_e(__( 'Posted in', 'bl-scroll' )); ?></span><?php the_category( ', ', $parents, $post_id ); ?></span>
		<?php the_tags( '<span class="tags-links">' , ', ', '</span>' ); ?>  
		<span class="comments-link"><a href="<?php echo esc_url( get_the_permalink() ); ?>#respond"><?php comments_number('Leave a comment', '1 Comment', '% Comments' );?></a></span>
	</footer>
</article>