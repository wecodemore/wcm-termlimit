<!--suppress HtmlFormInputWithoutLabel -->
<?php
if ( isset( $options ) ) {
	foreach ( $options as $index => $option ) {
		$value = get_option( $name );
		$value = $value[ $option['name'] ]; ?>
		<input type="number"
			   step="1"
			   min="<?= $min ?>"
			   max="<?= $max ?>"
			   placeholder="<?= $min ?>"
			   name="<?= "{$name}[{$option['name']}][min]" ?>"
			   value="<?= esc_attr( $value['min'] ) ?>"
			   class="small-text">
		<input type="number"
			   step="1"
			   min="<?= $min ?>"
			   max="<?= $max ?>"
			   placeholder="<?= $max ?>"
			   name="<?= "{$name}[{$option['name']}][max]" ?>"
			   value="<?= esc_attr( $value['max'] ) ?>"
			   class="small-text">
		<?= $option['label'] ?>
		<br>
	<?php }
} ?>
<?php if ( isset( $desc ) ) { ?>
	<p class="description">
		<?= $desc ?>
	</p>
<?php }