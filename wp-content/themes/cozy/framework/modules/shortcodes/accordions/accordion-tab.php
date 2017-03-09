<?php 
namespace CozyEdge\Modules\Shortcodes\AccordionTab;

use CozyEdge\Modules\Shortcodes\Lib\ShortcodeInterface;
/**
	* class Accordions
*/
class AccordionTab implements ShortcodeInterface{
	/**
	 * @var string
	 */
	private $base;
	function __construct() {
		$this->base = 'edgtf_accordion_tab';
		add_action('vc_before_init', array($this, 'vcMap'));
	}
	public function getBase() {
		return $this->base;
	}
	
	public function vcMap() {
		if(function_exists('vc_map')){
			vc_map( array(
				"name" => esc_html__('Edge Accordion Tab', 'cozy'),
				"base" => $this->base,
				"as_parent" => array('except' => 'vc_row, edgtf_tabs, edgtf_tab'),
				"as_child" => array('only' => 'edgtf_accordion'),
				'is_container' => true,
				"category" => 'by EDGE',
				"icon" => "icon-wpb-accordion-section extended-custom-icon",
				"show_settings_on_create" => true,
				"js_view" => 'VcColumnView',
				"params" => array(
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Title', 'cozy' ),
						'param_name' => 'title',
						'admin_label' => true,
						'value' => esc_html__( 'Section', 'cozy' ),
						'description' => esc_html__( 'Enter accordion section title.', 'cozy' )
					),
					array(
						'type' => 'el_id',
						'heading' => esc_html__( 'Section ID', 'cozy' ),
						'param_name' => 'el_id',
						'description' => sprintf( esc_html__( 'Enter optional row ID. Make sure it is unique, and it is valid as w3c specification: %s (Must not have spaces)', 'cozy' ), '<a target="_blank" href="http://www.w3schools.com/tags/att_global_id.asp">' . esc_html__( 'link', 'cozy' ) . '</a>' ),
					),
				)

			));
		}
	}	
	public function render($atts, $content = null) {

		$default_atts = (array(
			'title'	=> "Accordion Title",
			'el_id' => ''
		));
		
		$params = shortcode_atts($default_atts, $atts);
		extract($params);
		$params['content'] = $content;
		
		$output = '';
		
		$output .= cozy_edge_get_shortcode_module_template_part('templates/accordion-template','accordions', '',$params);

		return $output;
		
	}

}