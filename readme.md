CMB2 Field Type: Content Wrap
==================

Custom field for [CMB2](https://github.com/CMB2/CMB2) to store a content wrap values (padding, margin or border width).

![example](example.gif)

## Examples

```php
add_action( 'cmb2_admin_init', 'cmb2_content_wrap_metabox' );
function cmb2_content_wrap_metabox() {

	$prefix = 'your_prefix_demo_';

	$cmb_demo = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Content Wrap Metabox', 'cmb2' ),
		'object_types'  => array( 'page', 'post' ), // Post type
	) );

	$cmb_demo->add_field( array(
		'name'          => __( 'Default field', 'cmb2' ),
		'desc'          => __( 'Field description (optional)', 'cmb2' ),
		'id'            => $prefix . 'content_wrap',
		'type'          => 'content_wrap',
		// Custom units (units by default are 'px', '%' and 'em'
		'units'     => array(
			'px' => 'px',
			'%' => '%',
		)
	) );

}
```

## Retrieve the field value

```php
    $value = get_post_meta( get_the_ID(), 'your_field_id', false );
    $unit = isset( $value['unit'] ) ? $value['unit'] : 'px';

    if( isset( $value['all'] ) && ! empty( $value['all'] ) ) {
        echo 'padding: ' . $value['all'] . $unit . ';';
    } else {
        if( isset( $value['top'] ) && ! empty( $value['top'] ) ) {
            echo 'padding-top: ' . $value['top'] . $unit . ';<br>';
        }

        if( isset( $value['right'] ) && ! empty( $value['right'] ) ) {
            echo 'padding-right: ' . $value['right'] . $unit . ';<br>';
        }

        if( isset( $value['bottom'] ) && ! empty( $value['bottom'] ) ) {
            echo 'padding-bottom: ' . $value['bottom'] . $unit . ';<br>';
        }

        if( isset( $value['left'] ) && ! empty( $value['left'] ) ) {
            echo 'padding-left: ' . $value['left'] . $unit . ';<br>';
        }
    }
```

## Changelog

### 1.0.1
* Added the ability to define custom units

### 1.0.0
* Initial commit
