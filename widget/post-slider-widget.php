<?php

if( ! defined ('ABSPATH') ) {
    exit;
}

class Pswe_Post_Slider extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Post Slider widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'postslider-widget';
	}

	/**
	 * Get widget title.
	 *
	 *Post Slider widget for elementor Cards widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Post slider', 'post-slider-elementor' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Post Slider widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-post-slider';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Post Slider widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'plugins-cafe' ];
	}

	/**
	 * Register Post Slider widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */

	protected function tc_cat_list( ) {
			$project_categories = get_terms( 'category' );
			
			$project_category_options = array(''=>esc_html__('All category', 'post-slider-elementor'));
			if ( $project_categories  ) {
				foreach ( $project_categories as $project_category ) {
					$project_category_options[ $project_category->term_id ] = $project_category->name;
				}
			}
			return $project_category_options;
	}
		

    protected function register_controls() {
			$this->start_controls_section(
				'additional_settning',
				[
					'label' => __( 'Layout', 'post-slider-elementor' ),
					'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				]
			);

			$this -> add_control(
				'skin_type',
				[
					'label' => __( 'Skin', 'post-slider-elementor' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'tc_classic',
					'options' => [
						'tc_classic'  	=> __( 'Classic', 'post-slider-elementor' ),
						'tc_full'	=> __('Full content', 'post-slider-elementor'),
					],
				]
				);
			$this->add_control(
				'post_count',
				[
					'label' => __( 'Post per page', 'post-slider-elementor' ),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'min' => 1,
					'max' => 50,
					'step' => 1,
					'default' => -1,
				]
			);

			$this->add_control(
				'post_title',
				[
					'label' => __( 'Title', 'post-slider-elementor' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Show', 'post-slider-elementor' ),
					'label_off' => __( 'Hide', 'post-slider-elementor' ),
					'return_value' => 'yes',
					'default' => 'yes',

				]
			);


			$this->add_control(
				'post_content',
				[
					'label' => __( 'Post content', 'post-slider-elementor' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'Show', 'post-slider-elementor' ),
					'label_off' => __( 'Hide', 'post-slider-elementor' ),
					'return_value' => 'yes',
					'default' => 'yes',

				]
			);
			$this->add_control(
				'post_excerpt',
				[
					'label' => __( 'Excerpt', 'post-slider-elementor' ),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'min' => 1,
					'max' => 300,
					'step' => 1,
					'default' => 25,
					'condition' => [
						'post_content' => 'yes',
					],
				]
			);

       
			$this->add_control(
				'button_text',
				[
					'label' => __( 'Button Text', 'post-slider-elementor' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => __( 'Read Article', 'post-slider-elementor' ),
					'placeholder' => __( 'Type your button text here', 'post-slider-elementor' ),
					'desc'	=> __("If you don't want button then leave it empty., 'post-slider-elementor ")
				]
			);


			$this->add_group_control(
				\Elementor\Group_Control_Image_Size::get_type(),
				[
					'name' => 'blg_img',
					'exclude' => [ 'custom' ],
					'include' => [],
					'default' => 'large',
				]
			);

			$this->add_control(
				'img_link',
				[
					'label' => __( 'Image Link', 'post-slider-elementor' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'On', 'post-slider-elementor' ),
					'label_off' => __( 'Off', 'post-slider-elementor' ),
					'return_value' => 'yes',
					'default' => 'yes',

				]
			);

			$this->end_controls_section();
			
			

			$this->start_controls_section(
				'post_query',
				[
					'label' => __( 'Query', 'post-slider-elementor' ),
					'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				]
			);

			$this->add_control(
				'post_type',
				[
					'label' => __( 'Post Type', 'post-slider-elementor' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'post',
					'options' => [
						'post'  	=>  __( 'Post', 'post-slider-elementor' ),
						'related'	=> __('Related', 'post-slider-elementor'),
					],
				]
				);
			$this->add_control(
				'category_select',
				[
					'label' 	=> __( 'Select Category', 'post-slider-elementor' ),
					'type' 		=> \Elementor\Controls_Manager::SELECT2,
					'multiple' 	=> true,
					'options' 	=> $this->tc_cat_list( ),
					'default' 	=> [],
					'condition' => [
						'post_type' => 'post',
					],
				]
			);
   

			$this->add_control(
				'order_type',
				[
					'label' 	=> __('Order', 'post-slider-elementor' ),
					'type' 		=> \Elementor\Controls_Manager::SELECT,
					'default' 	=> 'desc',
					'options' 	=> [
						'asc'  	=> __( 'ASC', 'post-slider-elementor' ),
						'desc'	=> __('DESC', 'post-slider-elementor'),

					],
				]
			);


			$this-> end_controls_section();

			$this->start_controls_section(
				'slider_settins',
				[
					'label' => __( 'Slider Settings', 'post-slider-elementor' ),
					'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
				]
				);

			$this->add_responsive_control(
				'slider_item',
				[
					'label' => __( 'Slides per view', 'post-slider-elementor' ),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'min' => 1,
					'max' => 10,
					'step' => 1,
					'default' => 3,
					'tablet_default' => 2,
					'mobile_default' => 1,
				]
			);


			$this->add_responsive_control(
				'space_between',
				[
					'label' => __( 'Space', 'post-slider-elementor' ),
					'type' => \Elementor\Controls_Manager::NUMBER,
					'min' => 1,
					'max' => 300,
					'step' => 1,
					'default' => 30,
					'tablet_default' => 20,
					'mobile_default' => 10,
				]
			);

			//slider autplay switcher

           $this->add_control(
			   'slider_speed',
			   [
				'label' => __( 'Speed', 'post-slider-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 100,
				'max' => 20000,
				'step' => 100,
				'default' => 600,
			   ]
			);

			$this->add_control(
				'autoplay',
				[
					'label' => __( 'Autoplay', 'post-slider-elementor' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'ON', 'post-slider-elementor' ),
					'label_off' => __( 'OFF', 'post-slider-elementor' ),
					'return_value' => 'yes',
					'default' => 'yes',

				]
			);


		//slider_autoplay_speed
		$this->add_control(
			'autoplay_delay',
			[
				'label' => __( 'Autoplay Delay', 'post-slider-elementor' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 500,
				'max' => 20000,
				'step' => 500,
				'default' => 5000,
				'condition' =>[
					'autoplay' => 'yes',
				],
			]
		);


			$this->end_controls_section();

			$this->start_controls_section(
				'box_style',
				[
					'label' => __( 'Box', 'post-slider-elementor' ),
					'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				]
			);


			$this->add_control(
				'slider_align',
				[
					'label' => __( 'Text Alignment', 'post-slider-elementor' ),
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'options' => [
						'left' => [
							'title' => __( 'Left', 'post-slider-elementor' ),
							'icon' => ' eicon-text-align-left',
						],
						'center' => [
							'title' => __( 'Center', 'post-slider-elementor' ),
							'icon' => 'eicon-text-align-center',
						],
						'right' => [
							'title' => __( 'Right', 'post-slider-elementor' ),
							'icon' => 'eicon-text-align-right',
						],
					],
					'default' => 'left',
					'toggle' => true,
				]
			);


			//border_style
			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'sing_item_border',
					'label' => __( 'Border', 'post-slider-elementor' ),
					'selector' => '{{WRAPPER}} .tc_sing_blog',
				]
			);
			$this->add_responsive_control(
				'slider_radius',
				[
					'label' => __( 'Border Radius', 'post-slider-elementor' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .tc_sing_blog' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);


			$this->add_responsive_control(
				'slider_padding',
				[
					'label' => __( 'Padding', 'post-slider-elementor' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .tc_content_box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'default' => [
						'top' => '10',
						'right' => '10',
						'bottom' => '10',
						'left' => '10',
						'unit' => 'px',
						'isLinked' => 'true',
					]

				]
			);

			$this->end_controls_section();

		$this->start_controls_section(
			'post_img_style',
			[
				'label' => __( 'Image', 'post-slider-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'post_img_width',
			[
				'label' => esc_html__( 'Width', 'post-slider-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} .tc_post_thumbnail img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'post_img_height',
			[
				'label' => esc_html__( 'Height', 'post-slider-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 200,
				],
				'selectors' => [
					'{{WRAPPER}} .tc_post_thumbnail img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


			//for title
			$this->start_controls_section(
				'title',
				[
					'label' => __( 'Title', 'post-slider-elementor' ),
					'tab' => \Elementor\Controls_Manager::TAB_STYLE,
					'condition'=>[
						"post_title" =>  "yes"
					]
				]

			);
			$this->add_control(
				'title_color',
				[
					'label' => esc_html__( 'Color', 'post-slider-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tc_sing_blog h3' => 'color: {{VALUE}}',
					],

					'global' => [
						'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
					],
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'title_typography',
					'selector' => '{{WRAPPER}} .tc_sing_blog h3',
				]
			);
			$this->add_responsive_control(
				'title_margin',
				[
					'label' => esc_html__( 'Margin', 'post-slider-elementor' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .tc_sing_blog h3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_section();


			/*for content*/
			$this->start_controls_section(
				'content',
				[
					'label' => __( 'Content', 'post-slider-elementor' ),
					'tab' => \Elementor\Controls_Manager::TAB_STYLE,
					'condition'=>[
						"post_content" =>  "yes"
					]
				]
			);

			$this->add_control(
				'cont_color',
				[
					'label' => esc_html__( 'Color', 'post-slider-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tc_blg_content p' => 'color: {{VALUE}}',
					],
					'global' => [
						'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_TEXT,
					]
				]
			);
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' 		=> 'cont_typography',
					'selector' 	=> '{{WRAPPER}} .tc_blg_content p',
					'global'	=> [
						'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_TEXT,
					],
				]
			);
		
			$this->add_responsive_control(
				'content_margin',
				[
					'label' => esc_html__( 'Margin', 'post-slider-elementor' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .tc_blg_content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);


		$this->end_controls_section();

			//for button
			$this->start_controls_section(
				'button',
				[
					'label' => __( 'Button', 'post-slider-elementor' ),
					'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				]
			);

			$this->start_controls_tabs(
				'button_hvoer'
			);
	
			$this->start_controls_tab(
				'button_normal_tab',
				[
					'label' => __( 'Normal', 'post-slider-elementor' ),
				]
			);
	
			$this->add_control(
				'btn_color',
				[
					'label' => __( 'Color', 'post-slider-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tc_blg_btn' => 'color: {{VALUE}}',
					],
					'separator'	=>	'after'
				]
			);

			$this->add_control(
				'btn_bgcolor',
				[
					'label' => __( 'Background', 'post-slider-elementor' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tc_blg_btn' => 'background-color: {{VALUE}}',
					],
					'separator'	=>	'after'
				]
			);
			$this->end_controls_tab();
	
			$this->start_controls_tab(
				'title_link_hover_tab',
				[
					'label' => __( 'Hover', 'post-slider-elementor' ),
				]
			);
				$this->add_control(
					'btn_hover_color',
					[
						'label' => __( 'Color', 'post-slider-elementor' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .tc_blg_btn:hover' => 'color: {{VALUE}}',
						],
						'separator'	=>	'after'
					]
				);

				$this->add_control(
					'btn_hover_bgcolor',
					[
						'label' => __( 'Background', 'post-slider-elementor' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .tc_blg_btn:hover' => 'background-color: {{VALUE}}',
						],
						'separator'	=>	'after'
					]
				);
			$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'button_typography',
					'selector' => '{{WRAPPER}} .tc_blg_btn',
					'global'	=> [
						'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Typography::TYPOGRAPHY_ACCENT,
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'btn_border',
					'label' => __( 'Border', 'post-slider-elementor' ),
					'selector' => '{{WRAPPER}} .tc_blg_btn',
				]
			);
			$this->add_responsive_control(
				'btn_radius',
				[
					'label' => esc_html__( 'Border radius', 'post-slider-elementor' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .tc_blg_btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'button_padding',
				[
					'label' => esc_html__( 'Padding', 'post-slider-elementor' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .tc_blg_btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'button_margin',
				[
					'label' => esc_html__( 'Margin', 'post-slider-elementor' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .tc_blg_btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'default' => [
						'top' => '10',
						'right' => '0',
						'bottom' => '0',
						'left' => '0',
						'unit' => 'px',
						'isLinked' => 'false',
					]
				]
			);



		$this->end_controls_section();



		//for navigation
		$this->start_controls_section(
			'nav_style',
			[
				'label' => __( 'Navigation', 'post-slider-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'prev_icon',
			[
				'label' => esc_html__( 'Previous Icon', 'post-slider-elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'skin' => "inline",
				'default' => [
					'value' => 'fas fa-angle-left',
					'library' => 'fa-solid',
				],

			]
			
		);

		$this->add_responsive_control(
			'nav_offset_y',
			[
				'label' => __( 'Offset Y', 'post-slider-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range' => [
					'px'=>[
						'min' => 0,
						'max' => 500,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .tc_navigation' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'nav_offset_x',
			[
				'label' => __( 'Offset X', 'post-slider-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range' => [
					'px'=>[
						'min' => 0,
						'max' => 500,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);
	
		$this->add_control(
			'next_icon',
			[
				'label' => esc_html__( 'Next Icon', 'post-slider-elementor' ),
				'type' => \Elementor\Controls_Manager::ICONS,
				'skin' => "inline",
				'default' => [
					'value' => 'fas fa-angle-right',
					'library' => 'fa-solid',
				],
			]
			
		);

		$this->add_control(
			'nav_color',
			[
				'label' => esc_html__( 'Color', 'post-slider-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tc_navigation i' => 'color: {{VALUE}}',
				],
			]
		);
	
		$this->add_control(
			'nav_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'post-slider-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tc_navigation' => 'background-color: {{VALUE}}',
				],
			]
		);
	
	
	
		$this->add_responsive_control(
			'nav_size',
			[
				'label' => __( 'Icon Size', 'post-slider-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 25,
				],
				'selectors' => [
					'{{WRAPPER}} .tc_navigation i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
	
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'nav_border',
				'label' => __( 'Border', 'post-slider-elementor' ),
				'selector' => '{{WRAPPER}} .tc_navigation',
			]
		);
		$this->add_responsive_control(
			'nav_radius',
			[
				'label' => esc_html__( 'Border radius', 'post-slider-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .tc_navigation' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
	
		
		$this->add_responsive_control(
			'nav_padding',
			[
				'label' => esc_html__( 'Padding', 'post-slider-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .tc_navigation' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


	//for dots
		$this->start_controls_section(
			'dots',
			[
				'label' => __( 'Dots', 'post-slider-elementor' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'dots_color',
			[
				'label' => esc_html__( 'Background color', 'post-slider-elementor' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination span' => 'background-color: {{VALUE}}',
				],
				'global' => [
					'default' => \Elementor\Core\Kits\Documents\Tabs\Global_Colors::COLOR_PRIMARY,
				],
			]
		);


		$this->add_responsive_control(
			'dots_padding',
			[
				'label' => esc_html__( 'Padding', 'post-slider-elementor' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .swiper-pagination span.swiper-pagination-bullet' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'dot_sapcing',
			[
				'label' => __( 'Spacing', 'post-slider-elementor' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
					'em' => [
						'min' => 0,
						'max' => 100,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .tc_sing_blog' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);




		$this->end_controls_section();

	}



    

	protected function mapped_implode($glue, $array, $symbol = '=') {
		return implode($glue, array_map(
			function($k, $v) use($symbol) {
				return "'$k'".$symbol."'$v'";
			},
			array_keys($array),
			array_values($array)
			)
		);
	}


    protected function render() {
		$settings = $this->get_settings_for_display();



		$data= array(
			"autoplay" 				=> 	isset($settings['autoplay']) ? $settings['autoplay'] : " ",
			'autoplayDelay' 		=>  isset($settings['autoplay_delay']) ? $settings['autoplay_delay'] : 5000,
			"desktop"				=>	$settings['slider_item'],
			"tablet"				=>	$settings['slider_item_tablet'],
			"mobile"				=>	$settings['slider_item_mobile'],
			"speed"					=>  $settings['slider_speed'],
			"desktopSpace"			=>  $settings['space_between'],
			"tabletSpace"			=>  $settings['space_between_tablet'],
			"mobileSpace"			=>  $settings['space_between_mobile'],

		);

		if('related' === $settings['post_type']){
			$post_id = get_the_ID();
			$cat_ids = array();
			$categories = get_the_category( $post_id );

			if(!empty($categories) && !is_wp_error($categories)):
				foreach ($categories as $category):
					array_push($cat_ids, $category->term_id);
				endforeach;
			endif;

			$current_post_type = get_post_type($post_id);
		
			$query_args = array( 
				'category__in'    => $cat_ids,
				'post_type'       => $current_post_type,
				'post__not_in'    => array($post_id),
				'posts_per_page'  => $settings['post_count'],
				'orderby'		  => 'date',
				'order'			  => $settings['order_type']
			);

		}else{
			$query_args = array(
			'post_type'=>'post',
			'posts_per_page' =>  $settings['post_count'],
			'category__in'=>$settings['category_select'],
			'orderby'=> 'date',
			'order'=> $settings['order_type'],
			);
		}	
			$q= new \WP_Query($query_args );

		 $tc_rand_class = "tc_crousel_".rand(1, 50);
		?>

		<div id="<?php echo esc_attr($tc_rand_class);?>" class="tc_blog_carousel swiper swiper-container"
		slider_settings ="{<?php echo esc_attr($this->mapped_implode(',', $data, ':'));?>}">
			<div class="swiper-wrapper">
				<?php if ($q->have_posts()):while($q->have_posts()):$q->the_post(); 
					$post_id = get_the_ID(); 
					$thumb_id = get_post_thumbnail_id();
					$category_object = get_the_category($post_id);
					$category_name = !empty($category_object) ? $category_object[0]->name : '';
				?>

				<?php require(PSWE_PLUGIN_PATH.'/inc/classic.php');  endwhile; else : ?>	

				<p style="display: block; text-align:center;">No related post found</p>

			<?php endif; ?>
			</div>
			<?php if ($q->have_posts()):?>
				<div class="tc_navigation swiper-button-next"> <?php \Elementor\Icons_Manager::render_icon( $settings['next_icon'], [ 'aria-hidden' => 'true' ] ); ?> </div>
				<div class="tc_navigation swiper-button-prev"><?php \Elementor\Icons_Manager::render_icon( $settings['prev_icon'], [ 'aria-hidden' => 'true' ] ); ?></div> 
				<div class="swiper-pagination"></div>
			<?php endif; ?>
			
		</div>
 <?php }
}