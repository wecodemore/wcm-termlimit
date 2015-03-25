<!--suppress HtmlFormInputWithoutLabel -->
<input type="text"
	   value="<?= esc_attr( get_option( $name ) ); ?>"
	   id="<?= $name ?>"
	   <?php if ( isset( $placeholder ) ) { ?>placeholder="<?php echo $placeholder; ?>" <?php } ?>
	   name="<?= $name ?>">
<?php if ( isset( $description ) ) { ?>
	<p class="description">
		<?= $description ?>
	</p>
<?php }