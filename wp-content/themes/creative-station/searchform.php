<?php
/**
 * Template for displaying search forms in Twenty Sixteen
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo home_url($path = 'craft-ideas/', $scheme = 'relative' ); ?>">
	<label>
		<input type="search" class="search-field" placeholder="Search by ideas, project or technique" value="<?php echo get_search_query(); ?>" name="s" />
		<button type="submit" class="search-submit"></button>
	</label>
</form>
