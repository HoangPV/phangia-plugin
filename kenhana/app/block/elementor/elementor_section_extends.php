<?php


namespace Kenhana\App\Block\Elementor;


use Elementor\Controls_Manager;

class Elementor_Section_Extends {
	private static $instance;

	public static function getInstance(){
		if ( null == self::$instance ){
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		add_action('elementor/element/column/section_advanced/after_section_end', [$this, 'section_tab_advanced_controls'],10,2);
		add_action('elementor/element/common/_section_style/after_section_end', [$this, 'section_tab_advanced_controls'], 10, 2);
	}

	public function section_tab_advanced_controls($instance, $args) {
		$instance->start_controls_section(
			'appside_sec_extends_animation_section',
			[
				'label' => esc_html__('\'Aapside Animation'),
				'tab' =>  \Elementor\Controls_Manager::TAB_ADVANCED,
			]
		);

		$instance->add_control(
			'appside_sec_extends_is_scrollme',
			[
				'label' => esc_html__('Scroll Animation'),
				'description' => esc_html__('Add animation to element when scrolling through page contents'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__('Yes'),
				'label_off' => esc_html__('No'),
				'return_value' => 'true',
				'default' => 'false',
				'frontend_available' => true
			]
		);

		$instance->add_control(
			'appside_sec_extends_scrollme_smoothness', [
				'label' =>  __( 'Smoothness', 'aapside-master' ),
				'description' => __( 'factor that slowdown the animation, the more the smoothier', 'aapside-master' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 30
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 5
					]
				],
				'size_units' => ['px'],
				'condition' => [
					'appside_sec_extends_is_scrollme' => 'yes'
				],
				'frontend_available' => true
			]
		);

		$instance->add_control('appside_sec_extends_scrollme_scalex', [
			'label' => __( 'Scale X', 'aapside-master' ),
			'type' => \Elementor\Controls_Manager::SLIDER,
			'default' => [
				'size' => 1
			],
			'range' => [
				'px' => [
					'min' => 0.1,
					'max' => 2,
					'step' => 0.1
				]
			],
			'size_units' => ['px'],
			'condition' => [
				'appside_sec_extends_is_scrollme' => 'true'
			],
			'frontend_available' => true
		]);

		$instance->add_control('appside_sec_extends_scrollme_scaley', [
			'label' =>  __( 'Scale Y', 'aapside-master' ),
			'type' => \Elementor\Controls_Manager::SLIDER,
			'default' => [
				'size' => 1
			],
			'range' => [
				'px' => [
					'min' => 0.1,
					'max' => 2,
					'step' => 0.1
				]
			],
			'size_units' => ['px'],
			'condition' => [
				'appside_sec_extends_is_scrollme' => 'true'
			],
			'frontend_available' => true
		]);

		$instance->add_control('appside_sec_extends_scrollme_scalez', [
			'label' => __( 'Scale Z', 'aapside-master' ),
			'type' => \Elementor\Controls_Manager::SLIDER,
			'default' => [
				'size' => 1
			],
			'range' => [
				'px' => [
					'min' => 0.1,
					'max' => 2,
					'step' => 0.1
				]
			],
			'size_units' => ['px'],
			'condition' => [
				'appside_sec_extends_is_scrollme' => 'yes',
			],
			'frontend_available' => true
		]);

		$instance->add_control('appside_sec_extends_scrollme_rotatex', [
			'label' =>  __( 'Rotate X', 'aapside-master' ),
			'type' => \Elementor\Controls_Manager::SLIDER,
			'default' => [
				'size' => 0
			],
			'range' => [
				'px' => [
					'min' => -360,
					'max' => 360,
					'step' => 1
				]
			],
			'size_unit'=> ['px'],
			'condition' => [
				'appside_sec_extends_is_scrollme' => 'true'
			],
			'frontend_available' => true
		]);

		$instance->add_control('appside_sec_extends_scrollme_rotatey', [
			'label' =>  __( 'Rotate Y', 'aapside-master' ),
			'type' => \Elementor\Controls_Manager::SLIDER,
			'default' => [
				'size' => 0
			],
			'range' => [
				'px' => [
					'min' => -360,
					'max' => 360,
					'step' => 1
				]
			],
			'size_units' => ['px'],
			'condition' => [
				'appside_sec_extends_is_scrollme' => 'true'
			],
			'frontend_available' => true
		]);

		$instance->add_control('appside_sec_extends_scrollme_rotatez', [
			'label' =>  __( 'Rotate Z', 'aapside-master' ),
			'type' => \Elementor\Controls_Manager::SLIDER,
			'default' => [
				'size' => 0,
			],
			'range' => [
				'px' => [
					'min' => -360,
					'max' => 360,
					'step' => 1,
				]
			],
			'size_units' => ['px'],
			'condition' => [
				'appside_sec_extends_is_scrollme' => true,
			],
			'frontend_available' => true,
		]);

		$instance->add_control('appside_sec_extends_scrollme_translatey', [
			'label' =>  __( 'Translate Y', 'aapside-master' ),
			'type' => \Elementor\Controls_Manager::SLIDER,
			'default' => [
				'size' => 0
			],
			'range' => [
				'px' => [
					'min' => -1000,
					'max' => 1000,
					'step' => 1,
				]
			],
			'size_units' => ['px'],
			'condition' => [
				'appside_sec_extends_is_scrollme' => 'true',
			],
			'frontend_available' => true
		]);

		$instance->add_control('appside_sec_extends_scrollme_translatez', [
			'label' => __( 'Translate Z', 'aapside-master' ),
			'type' => \Elementor\Controls_Manager::SLIDER,
			'default' => [
				'size' => 0
			],
			'range' => [
				'px' => [
					'min' => -1000,
					'max' => 1000,
					'step' => 1
				]
			],
			'size_units' => ['px'],
			'condition' => [
				'appside_sec_extends_is_scrollme' => 'true',
			],
			'frontend_available' => true
		]);

		$instance->add_control('appside_sec_extends_is_smoove', [
			'label' => esc_html__('Entrance Animation'),
			'description' => esc_html__('Add custom entrance animation to element'),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'label_on' => esc_html__( 'Yes', 'aapside-master' ),
			'label_off' =>  esc_html__( 'No', 'aapside-master' ),
			'return_value' => 'true',
			'default' => 'false',
			'frontend_available' => true
		]);

		$instance->add_control('appside_sec_extends_smoove_disable', [
			'label' => esc_html__( 'Disable for', 'aapside-master' ),
			'type' =>\Elementor\Controls_Manager::SELECT,
			'default' => 1,
			'options' => [
				1 => __( 'None', 'aapside-master' ),
				769 => __( 'Mobile and Tablet', 'aapside-master' ),
				415 => __( 'Mobile', 'aapside-master' ),
			],
			'condition' => [
				'appside_sec_extends_is_smoove' => 'true'
			],
			'frontend_available' => true
		]);


	}
}