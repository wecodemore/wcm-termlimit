<!--suppress HtmlFormInputWithoutLabel -->
<?php $selected = selected( esc_attr( get_option( $name ) ), true, false ); ?>
<select name="<?= $name ?>" id="<?= $name ?>">
	<?php
	if ( isset( $options ) ) {
		foreach ( $options as $option ) { ?>
			<option value="<?= $option['name'] ?>" <?= $selected ?>>
				<?= $option['label'] ?>
			</option>
		<?php }
	} ?>
</select>