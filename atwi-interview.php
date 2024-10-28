<?php
    /*
    Plugin Name: ATWI Interview
    Plugin URI: http://www.andthewidgetis.com
    Description: ATWI Interview formatter plugin
    Version: 1.0
    Author: Hol
    Author URI: http://www.andthewidgetis.com
    License: GPLv2
    */

	class ATWIInterviewPlugin {
	
	
	
	public function __construct () {
			
			
			add_shortcode( 'interview_id', array(&$this, 'interview_id'));
			add_shortcode( 'interview_q', array(&$this, 'interview_q'));
			add_shortcode( 'interview_a', array(&$this, 'interview_a'));
						
			//Options Page
		    add_action('admin_menu', array(&$this, 'atwi_plugin_add_options'));
			
			// Init buttons
			add_action( 'init', array(&$this, 'atwi_interview_buttons') );

			add_action( 'wp_enqueue_scripts', array(&$this, 'atwi_interview_load_plugin_scripts') );
			
			
		}
		
	public function interview_id( $atts, $content ) {
		$qa_index_text_color = get_option('qa_index_text_color', '#000000');
		$qa_bold = get_option('qa_index_bold');

		if ($qa_bold){
			$qa_bold = 'bold';
		} else
		{
			$qa_bold = 'normal';
		}
			
		extract( shortcode_atts ( array(
										'width' => '200px',
										'float' => 'left',
									), $atts ) );
		return "<section class='atwi-int-qa-frame'><div class='atwi-int-qa-idx $qa_bold' style='color:$qa_index_text_color; text-align: justify;'>" . $content . "</div>";
	}
	
	public function interview_q( $atts, $content ) {
		
		$question_text_color = get_option('question_text_color', '#000000');
		$q_bold = get_option('question_bold', 'normal');
		$q_justify = get_option('question_justify');
		
		if ($q_bold){
			$q_bold = 'bold';
		} else
		{
			$q_bold = 'normal';
		}
		
		if ($q_justify){
			$q_justify = 'justify';
		} 
		
		extract( shortcode_atts ( array(
										'width' => '200px',
										'float' => 'left',
									), $atts ) );
		return "<div class='atwi-int-q-frame $q_bold $q_justify' style='color:$question_text_color;'>" . $content . "</div>";
	}
	
	public function interview_a( $atts, $content ) {
		
		$answer_text_color = get_option('answer_text_color', '#000000');
		$a_bold = get_option('answer_bold');
		$a_justify = get_option('answer_justify');
		
		if ($a_bold){
			$a_bold = 'bold';
		} else
		{
			$a_bold = 'normal';
		}
		if ($a_justify){
			$a_justify = 'justify';
		} 
		extract( shortcode_atts ( array(
										'width' => '200px',
										'float' => 'left',
									), $atts ) );
		return "<div class='atwi-int-a-frame $a_bold $a_justify' style='color:$answer_text_color;'>" . $content . "</div></section>";
	}
	

	public function atwi_plugin_add_options() {
		add_options_page('ATWI Interview Options', 'ATWI Interview', 'manage_options', 'atwiinterviewoptions', array(&$this, 'atwi_plugin_options_page'));
		

	}
	
	public function atwi_interview_buttons() {
		add_filter( "mce_external_plugins", array(&$this, 'atwi_interview_add_buttons') );
		add_filter( 'mce_buttons', array(&$this, 'atwi_interview_register_buttons') );
	}
	
	public function atwi_interview_add_buttons( $plugin_array ) {
		$plugin_array['atwi_interview'] = $dir = plugins_url( 'js/shortcode.js', __FILE__ );
		return $plugin_array;
	}
	
	public function atwi_interview_register_buttons( $buttons ) {
		array_push( $buttons, 'qabut' );
		return $buttons;
	}
	
	function atwi_plugin_options_page() {

		wp_enqueue_style( 'atwi-style', $plugin_url . 'css/atwi-style.css' );

		$opt_name = array(
		    'qa_index_text_color' => 'qa_index_text_color',
		    'question_text_color' => 'question_text_color',
			'answer_text_color' => 'answer_text_color',
			'qa_index_bold' => 'qa_index_bold',
			'question_bold' => 'question_bold',
			'answer_bold' => 'answer_bold',
			'question_justify' => 'question_justify',
			'answer_justify' => 'answer_justify',
			
			
		);
		$hidden_field_name = 'atwiinterview_submit_hidden';

		$opt_val = array(
			'qa_index_text_color' => get_option($opt_name['qa_index_text_color']),
		    'question_text_color' => get_option($opt_name['question_text_color']),
			'answer_text_color' => get_option($opt_name['answer_text_color']),
			'qa_index_bold' => get_option($opt_name['qa_index_bold']),
			'question_bold' => get_option($opt_name['question_bold']),
			'answer_bold' => get_option($opt_name['answer_bold']),
			'question_justify' => get_option($opt_name['question_justify']),
			'answer_justify' => get_option($opt_name['answer_justify']),
			
		);

		if (isset($_POST[$hidden_field_name]) && $_POST[$hidden_field_name] == 'Y') {
			$opt_val = array(
			    'qa_index_text_color' => $_POST[$opt_name['qa_index_text_color']],
			    'question_text_color' => $_POST[$opt_name['question_text_color']],
				'answer_text_color' => $_POST[$opt_name['answer_text_color']],
				'qa_index_bold' => $_POST[$opt_name['qa_index_bold']],
				'question_bold' => $_POST[$opt_name['question_bold']],
				'answer_bold' => $_POST[$opt_name['answer_bold']],
				'question_justify' => $_POST[$opt_name['question_justify']],
				'answer_justify' => $_POST[$opt_name['answer_justify']],
			);
			
			update_option($opt_name['qa_index_text_color'], $opt_val['qa_index_text_color']);
			update_option($opt_name['question_text_color'], $opt_val['question_text_color']);
			update_option($opt_name['answer_text_color'], $opt_val['answer_text_color']);
			update_option($opt_name['qa_index_bold'], $opt_val['qa_index_bold']);
			update_option($opt_name['question_bold'], $opt_val['question_bold']);
			update_option($opt_name['answer_bold'], $opt_val['answer_bold']);
			update_option($opt_name['question_justify'], $opt_val['question_justify']);
			update_option($opt_name['answer_justify'], $opt_val['answer_justify']);
			
			?>
			<div id="message" class="updated fade">
				<p><strong>
						<?php _e('Options saved.', 'atwi-interview-locale'); ?>
					</strong></p>
			</div>
			<?php
		}
	
		
		?>
		
		
		<div class="wrap">
			<h2><?php _e('ATWI Interview', 'att_trans_domain'); ?></h2>
			<form class="settings" name="att_img_options" method="post" action="<?php echo str_replace('%7E', '~', $_SERVER['REQUEST_URI']); ?>">
				<fieldset>

					<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
					
					<div  style="border-style: solid; margin-bottom: 20px; padding: 20px;">
						<h4>Q&A Index settings</h4>
						<label style="margin-left: 10px;" for="<?php echo $opt_name['qa_index_text_color']; ?>" class="settings" >Text color:</label>
							<input class="settings" type="text" name="<?php echo $opt_name['qa_index_text_color']; ?>" id="<?php echo $opt_name['qa_index_text_color']; ?>" value="<?php echo $opt_val['qa_index_text_color']; ?>"/>
						<label style="margin-left: 10px;" for="<?php echo $opt_name['qa_index_bold']; ?>" class="settings" >Bold:</label>
						<input name="<?php echo $opt_name['qa_index_bold']; ?>" type="checkbox" value="1" <?php checked( '1', get_option( 'qa_index_bold' ) ); ?> />

					</div>
					
					<div  style="border-style: solid; margin-bottom: 20px; padding: 20px;">
						<h4>Question settings</h4>
						<label style="margin-left: 10px;"  for="<?php echo $opt_name['question_text_color']; ?>" class="settings" >Text color:</label>
						<input class="settings"  type="text" name="<?php echo $opt_name['question_text_color']; ?>" id="<?php echo $opt_name['question_text_color']; ?>" value="<?php echo $opt_val['question_text_color']; ?>"/>
						<label style="margin-left: 10px;" for="<?php echo $opt_name['question_bold']; ?>" class="settings" >Bold:</label>
						<input name="<?php echo $opt_name['question_bold']; ?>" type="checkbox" value="1" <?php checked( '1', get_option( 'question_bold' ) ); ?> />
						<label style="margin-left: 10px;" for="<?php echo $opt_name['question_justify']; ?>" class="settings" >Justify text:</label>
						<input name="<?php echo $opt_name['question_justify']; ?>" type="checkbox" value="1" <?php checked( '1', get_option( 'question_justify' ) ); ?> />
					</div>
					
					<div  style="border-style: solid; margin-bottom: 20px; padding: 20px;">
						<h4>Answer settings</h4>
						<label style="margin-left: 10px;"  for="<?php echo $opt_name['answer_text_color']; ?>" class="settings" >Text color:</label>
						<input class="settings"  type="text" name="<?php echo $opt_name['answer_text_color']; ?>" id="<?php echo $opt_name['answer_text_color']; ?>" value="<?php echo $opt_val['answer_text_color']; ?>"/>
						<label style="margin-left: 10px;" for="<?php echo $opt_name['answer_bold']; ?>" class="settings" >Bold:</label>
						<input name="<?php echo $opt_name['answer_bold']; ?>" type="checkbox" value="1" <?php checked( '1', get_option( 'answer_bold' ) ); ?> />
						<label style="margin-left: 10px;" for="<?php echo $opt_name['answer_justify']; ?>" class="settings" >Justify text:</label>
						<input name="<?php echo $opt_name['answer_justify']; ?>" type="checkbox" value="1" <?php checked( '1', get_option( 'answer_justify' ) ); ?> />
					</div>

					<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes', 'atwi-interview-locale'); ?>">
				</fieldset>
			</form>

			<?php
		}
		
		function atwi_interview_load_plugin_scripts() {
			$plugin_url = plugin_dir_url( __FILE__ );

			wp_enqueue_style( 'atwi-style', $plugin_url . 'css/atwi-style.css' );
			wp_enqueue_script('jquery');
		}
		
		
		
	
	
	
	}
    new ATWIInterviewPlugin();
?>