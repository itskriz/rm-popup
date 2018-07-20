<?php 
	function get_rm_popup() {
		if (get_field('rm_popup_enabled')) {
			$rm_popup = array(
				'id' => get_field('rm_popup_post');
			);
			if (get_field('rm_popup_start')) {
				$rm_popup['start'] = get_field('rm_popup_start');
			}
			if (get_field('rm_popup_end')) {
				$rm_popup['end'] = get_field('rm_popup_end');
			}
			if (get_field('rm_popup_freq')) {
				$rm_popup['freq'] = get_field('rm_popup_freq');
			}
			if (get_field('rm_popup_trigger')) {
				$rm_popup['trigger'] = get_field('rm_popup_trigger');
			}
			if (get_field('rm_popup_delay')) {
				$rm_popup['delay'] = get_field('rm_popup_delay');
			}
			if (get_field('rm_popup_anchor')) {
				$rm_popup['anchor'] = get_field('rm_popup_anchor');
			}
			$rm_popup = apply_filters('the_content', $rm_popup_post->post_content);
		}
	}
?>