<?php
namespace ZupinCustomTabs\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class Zup_Gallery_Tabs extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve tabs widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'zup-gallery-tabs';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve tabs widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Zupin Gallery Tabs', 'zup-widgets' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve tabs widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-tabs';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return ['zup-custom-tabs'];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'tabs', 'accordion', 'toggle' ];
	}

	/**
	 * Register tabs widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 3.1.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_tabs',
			[
				'label' => esc_html__( 'Tabs', 'zup-widgets' ),
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'tab_title',
			[
				'label' => esc_html__( 'Title & Description', 'zup-widgets' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Tab Title', 'zup-widgets' ),
				'placeholder' => esc_html__( 'Tab Title', 'zup-widgets' ),
				'label_block' => true,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'tab_subtitle',
			[
				'label' => esc_html__( 'Subtitle', 'zup-widgets' ),
				'default' => esc_html__( 'Subtitle', 'zup-widgets' ),
				'placeholder' => esc_html__( 'Subtitle', 'zup-widgets' ),
				'type' => Controls_Manager::WYSIWYG,
				'show_label' => true,
			]
		);

		$repeater->add_control(
			'tab_gallery',
			[
				'label' => esc_html__( 'Add Images', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::GALLERY,
				'default' => [],
			]
		);

		

		$this->add_control(
			'tabs',
			[
				'label' => esc_html__( 'Tabs Items', 'zup-widgets' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'tab_title' => esc_html__( 'Tab #1', 'zup-widgets' ),
					],
					[
						'tab_title' => esc_html__( 'Tab #2', 'zup-widgets' ),
					],
				],
				'title_field' => '{{{ tab_title }}}',
			]
		);

		$this->add_control(
			'view',
			[
				'label' => esc_html__( 'View', 'zup-widgets' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);

		

		$this->end_controls_section();

		$this->start_controls_section(
			'section_tabs_style',
			[
				'label' => esc_html__( 'Tabs', 'zup-widgets' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'navigation_width',
			[
				'label' => esc_html__( 'Navigation Width', 'zup-widgets' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
					'unit' => '%',
				],
				'range' => [
					'%' => [
						'min' => 10,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .zup-vertical-tabs ul.zup-tabs-list' => 'width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .zup-vertical-tabs .zup-tabs-container' => 'width: calc(100% - {{SIZE}}{{UNIT}})',
				],
			]
		);

		$this->add_control(
			'heading_title',
			[
				'label' => esc_html__( 'Title', 'zup-widgets' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Title Typography', 'zup-widgets' ),
				'selector' => '{{WRAPPER}} .tab-title',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
				'label' => esc_html__( 'Subtitle Typography', 'zup-widgets' ),
				'selector' => '{{WRAPPER}} .tab-subtitle',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
			]
		);

		$this->add_responsive_control(
			'item_padding',
			[
				'label' => esc_html__( 'Padding', 'zup-widgets' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 50,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .zup-tabs-list .elementor-tab-title' => 'padding: {{SIZE}}{{UNIT}} !important;',
					'{{WRAPPER}} .zup-vertical-tabs h2.zup-accordion' => 'padding: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_control(
			'bullet_color',
			[
				'label' => esc_html__( 'Bullet Color', 'zup-widgets' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zup-accordion .tab-title span::before' => 'background: {{VALUE}}',
					'{{WRAPPER}} .zup-tabs-list li .tab-title span::before' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'inactive_tab',
			[
				'label' => esc_html__( 'Inactive Tab', 'zup-widgets' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'tab_color',
			[
				'label' => esc_html__( 'Title Color', 'zup-widgets' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-tab-title:not(.zup-tab-active) .tab-title' => 'color: {{VALUE}}',
					'{{WRAPPER}} .zup-vertical-tabs h2.zup-accordion:not(.zup-tab-active) .tab-title, {{WRAPPER}} .zup-vertical-tabs h2.zup-accordion .tab-title span' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'tab_subtitle_color',
			[
				'label' => esc_html__( 'Subtitle Color', 'zup-widgets' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-tab-title:not(.zup-tab-active) .tab-subtitle' => 'color: {{VALUE}}',
					'{{WRAPPER}} .zup-vertical-tabs h2.zup-accordion:not(.zup-tab-active) .tab-subtitle, {{WRAPPER}} .zup-vertical-tabs h2.zup-accordion .tab-subtitle a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'tab_background',
			[
				'label' => esc_html__( 'Background', 'zup-widgets' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .zup-tabs-list .elementor-tab-title:not(.zup-tab-active)' => 'background: {{VALUE}} !important;',
					'{{WRAPPER}} .zup-vertical-tabs h2.zup-accordion:not(.zup-tab-active)' => 'background: {{VALUE}} !important;',
				],
			]
		);

		

		$this->add_control(
			'active_tab',
			[
				'label' => esc_html__( 'Active Tab', 'zup-widgets' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'tab_active_color',
			[
				'label' => esc_html__( 'Title Color', 'zup-widgets' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-tab-title.zup-tab-active .tab-title, {{WRAPPER}} .elementor-tab-title.zup-tab-active .tab-title span' => 'color: {{VALUE}}',
					'{{WRAPPER}} .zup-vertical-tabs h2.zup-accordion.zup-tab-active .tab-title, {{WRAPPER}} .zup-vertical-tabs h2.zup-accordion.zup-tab-active .tab-title span' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'tab_active_subtitle_color',
			[
				'label' => esc_html__( 'Subtitle Color', 'zup-widgets' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-tab-title.zup-tab-active .tab-subtitle, {{WRAPPER}} .elementor-tab-title.zup-tab-active .tab-subtitle a' => 'color: {{VALUE}}',
					'{{WRAPPER}} .zup-vertical-tabs h2.zup-accordion.zup-tab-active .tab-subtitle, {{WRAPPER}} .zup-vertical-tabs h2.zup-accordion.zup-tab-active .tab-title span' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'tab_active_background',
			[
				'label' => esc_html__( 'Background', 'zup-widgets' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					 '{{WRAPPER}} .zup-tabs-list .elementor-tab-title.zup-tab-active' => 'background: {{VALUE}} !important;',
					 '{{WRAPPER}} .zup-vertical-tabs .zup-tab-content' => 'background: {{VALUE}} !important;',
					 '{{WRAPPER}} .zup-vertical-tabs h2.zup-accordion.zup-tab-active' => 'background: {{VALUE}}  !important;',
				],
			]
		);


		$this->add_control(
			'heading_gallery',
			[
				'label' => esc_html__( 'Gallery', 'zup-widgets' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'image_gap',
			[
				'label' => esc_html__( 'Images Gap', 'zup-widgets' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 20,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .zup-tab-content .zup-gallery-images' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_image_caption',
				'label' => esc_html__( 'Caption Typography', 'zup-widgets' ),
				'selector' => '{{WRAPPER}} .zup-gallery-images .image-caption',
			]
		);
		$this->add_control(
			'image_caption_color',
			[
				'label' => esc_html__( 'Caption Color', 'zup-widgets' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					 '{{WRAPPER}} .zup-gallery-images .image-caption' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render tabs widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$tabs = $this->get_settings_for_display( 'tabs' );
		$id_int = substr( $this->get_id_int(), 0, 3 );
		$tabidentify_id = 'tab-' . $id_int;
		$tabs_count = count($tabs);
		$tabs_count_class = "has-" . $tabs_count . "-row";
		$this->add_render_attribute( 'elementor-tabs', 'class', 'elementor-tabs' );

		?>

		<div id="<?php echo $tabidentify_id; ?>" class="zup-gallery-tab-wrapper">
            
			<ul class="zup-tabs-list <?php echo $tabidentify_id; ?> <?php echo $tabs_count_class; ?>">
			<?php
				foreach ( $tabs as $index => $item ) :
					$tab_count = $index + 1;
					$tab_title_setting_key = $this->get_repeater_setting_key( 'tab_title', 'tabs', $index );
					$tab_title = '<span>' . $item['tab_title'] . '</span>';
					$tab_subtitle = $item['tab_subtitle'];

					$this->add_render_attribute( $tab_title_setting_key, [
						'id' => 'elementor-tab-title-' . $id_int . $tab_count,
						'class' => [ 'elementor-tab-title' ],
						'aria-selected' => 1 === $tab_count ? 'true' : 'false',
						'data-tab' => $tab_count,
						'role' => 'tab',
						'tabindex' => 1 === $tab_count ? '0' : '-1',
						'aria-controls' => 'elementor-tab-content-' . $id_int . $tab_count,
						'aria-expanded' => 'false',
					] );
					?>
					<li <?php $this->print_render_attribute_string( $tab_title_setting_key ); ?>>
						<div class="tab-title">
						<?php
						// PHPCS - the main text of a widget should not be escaped.
						echo $tab_title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</div>
						<div class="tab-subtitle">
							<?php echo $tab_subtitle; ?>
						</div>
						
					</li>
				<?php endforeach; ?>
            </ul>

            <div class="zup-tabs-container <?php echo $tabidentify_id; ?>">
			<?php
				foreach ( $tabs as $index => $item ) :
					
					$tab_count = $index + 1;
					$hidden = 1 === $tab_count ? 'false' : 'hidden';
					$tab_content_setting_key = $this->get_repeater_setting_key( 'tab_content', 'tabs', $index );
					$slideshow_id = 'slide_' . rand(100, 999);
				
					?>
					
					<div <?php $this->print_render_attribute_string( $tab_content_setting_key ); ?>>
						<div class="zup-gallery-wrapper">
							<div class="shadow shadow-left"></div>
							<div class="shadow shadow-right"></div>
							<div class="zup-gallery-images">
								<?php
								foreach ( $item['tab_gallery'] as $image ) {

									$attachment_image = wp_get_attachment_image( $image['id'], 'zup-md');
									$attachment_image_caption = wp_get_attachment_caption( $image['id']);
									$attachment_image_caption_html = ( $attachment_image_caption ) ? sprintf( '<div class="image-caption"> %s </div>', $attachment_image_caption ) : '';

									echo '<a href="'. esc_attr( $image['url'] ) .'" data-elementor-open-lightbox="yes" data-elementor-lightbox-slideshow="'. $slideshow_id .'">';
									echo $attachment_image;
									echo $attachment_image_caption_html;
									echo '</a>';
								}
								?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
            </div>
        </div>

		<script type="text/javascript">

			jQuery(document).ready(function ($) {

				// Init Respinsive Tabs
				$("#<?php echo $tabidentify_id; ?>").easyResponsiveTabs({
					type: "vertical", //Types: default, vertical, accordion
					width: "auto", //auto or any width like 600px
					fit: true, // 100% fit in a container
					closed: false, // Start closed if in accordion view
					tabidentify: "<?php echo $tabidentify_id; ?>", // The tab groups identifier
				});


				// Gallery Scroll Wheel
				var galleries = document.getElementsByClassName("zup-gallery-images");
				for (var i = 0; i < galleries.length; i++) {

					const scrollContainer = galleries.item(i);
					scrollContainer.addEventListener('wheel', (evt) => {
						evt.preventDefault();
						scrollContainer.scrollLeft += evt.deltaY;
						scrollContainer.scrollLeft += evt.deltaX;
					});
				}


				$(".zup-gallery-wrapper").each(function () {

					var wrapper = $(this),
						content = wrapper.find('.zup-gallery-images'),
						shadowTop = wrapper.find('.shadow-left'),
						shadowBottom = wrapper.find('.shadow-right');

					content.on( 'scroll', function(){
						
						var contentScrollWidth = content[0].scrollWidth - wrapper[0].offsetWidth,
							currentScroll = this.scrollLeft / (contentScrollWidth);

						shadowTop.css('opacity', currentScroll);
						shadowBottom.css('opacity', 1 - currentScroll );
					});

				});

			});
		
		</script>
<?php
	
	}

}
