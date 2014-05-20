<?php global $post; ?>

<p><strong>E-mail Receipt To</strong></p>
<input type="email" name="send_confirmation_to" placeholder="email@domain.com" value="<?php echo get_post_meta( $post->ID, 'send_confirmation_to', true ); ?>" />