<?php

# override the default TCPDF config file
if(!defined('K_TCPDF_EXTERNAL_CONFIG')) {	
	define('K_TCPDF_EXTERNAL_CONFIG', TRUE);
}
	
# include TCPDF
require(APPPATH.'config/tcpdf'.EXT);
require_once($tcpdf['base_directory'].'/tcpdf.php');



/************************************************************
 * TCPDF - CodeIgniter Integration
 * Library file
 * ----------------------------------------------------------
 * @author Jonathon Hill http://jonathonhill.net
 * @version 1.0
 * @package tcpdf_ci
 ***********************************************************/
class reportpdf extends TCPDF {
	
	
	/**
	 * TCPDF system constants that map to settings in our config file
	 *
	 * @var array
	 * @access private
	 */
	private $cfg_constant_map = array(
		'K_PATH_MAIN'	=> 'base_directory',
		'K_PATH_URL'	=> 'base_url',
		'K_PATH_FONTS'	=> 'fonts_directory',
		'K_PATH_CACHE'	=> 'cache_directory',
		'K_PATH_IMAGES'	=> 'image_directory',
		'K_BLANK_IMAGE' => 'blank_image',
		'K_SMALL_RATIO'	=> 'small_font_ratio',
		'K_CELL_HEIGHT_RATIO' => 'cell_height_ratio'
	);
	private $units = 'in';
	private $load_unicode = false;
	private $text_encoding = 'UTF-8';
	private $enableDiskCache = false;
	private $margin_top = 1.1;
	private $margin_bottom = .5;
	private $margin_left   = .5;
	private $margin_right  = .5;
	private $header_on = true;
	private $footer_on = true;
	private $margin_header = .375;
	private $margin_footer = .375;
	private $page_break_auto = true;
	private $image_scale = 1;	
	private $cellheight_ratio = 1.25;
	private $cellpadding = 0;
	private $_config = array();
	
	private $_title = '';
	private $_subtitle = '';
	private $_geoarea = '';
	
	function __construct($params) {
		$orientation = $params['orientation'];
		$format = $params['format'];
		$author = $params['author'];
		$this->_title = $params['title'];
		$this->_subtitle = $params['subtitle'];
		$this->_geoarea = $params['geoarea'];

		require(APPPATH.'config/tcpdf'.EXT);
		$this->_config = $tcpdf;
		unset($tcpdf);
		
		foreach($this->cfg_constant_map as $const => $cfgkey) {
			if(!defined($const)) {
				define($const, $this->_config[$cfgkey]);
			}
		}
		
		parent::__construct($orientation, $this->units, $format, $this->load_unicode, $this->text_encoding, $this->enable_disk_cache);
	
		if(is_file($this->_config['language_file'])) {
			include($this->_config['language_file']);
			$this->setLanguageArray($l);
			unset($l);
		}
		
		$this->SetMargins($this->margin_left, $this->margin_top, $this->margin_right);
		
		$this->print_header = $this->header_on;
		$this->SetHeaderMargin($this->margin_header);
		
		$this->print_footer = $this->footer_on;
		$this->setFooterMargin($this->margin_footer);
		
		$this->SetAutoPageBreak($this->page_break_auto, $this->margin_footer);
		
		$this->cMargin = $this->cellpadding;
		$this->setCellHeightRatio($this->cellheight_ratio);
		
		$this->author = $author;
		$this->creator = $this->_config['creator'];
		$this->SetTitle($this->_title.' - '.$this->_subtitle);
		
		$this->imgscale = $this->image_scale;
	}
	
	public function Header() {
		$this->Image(K_PATH_IMAGES.'commconn-logo3.png', .5, $this->margin_header, '', '.5');
		$this->Image(K_PATH_IMAGES.'customer-logo3.png', 3.75, $this->margin_header, '', '.5');
		$this->SetFont('arial', 'B', 14);
		$this->SetTextColor(51, 32, 68, 8);
		$this->Cell(0, 1, $this->_title, 0, false, 'R', 0, '', 0, false, 'T', 'T');
		$this->SetY(.6);
		$this->SetFont('arial', 'B', 8);
		$this->SetTextColor(0);
		$this->Cell(0, 1, $this->_subtitle, 0, false, 'R', 0, '', 0, false, 'T', 'T');
		$this->SetY(.85);
		$this->SetFont('arial', 'B', 10);
		$this->Cell(0, 0, $this->_geoarea, 0, false, 'L', 0, '', 0, false, 'T', 'T');
		
		$this->SetLineStyle(array('width' => 0.85 / $this->getScaleFactor(), 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
		$this->SetX($ormargins['left']);
		$this->SetY(1);
		$this->Cell(0, 0, '', 'T', 0, 'C');
	}

	public function Footer() {
		$this->SetY(0 - $this->margin_footer);
		$this->SetFont('arial', '', 7);
		$this->SetTextColor(69, 63, 62, 58);
		// Page number
		$this->Cell(2.875, 0, '(c)CIVICTechnologies. CommunityConnect with LiteracyDecision. ', 0, false, 'L', 0, '', 0, false, 'T', 'M');
		$this->addHtmlLink('www.civictechnologies.com', 'www.civictechnologies.com');
		$this->Cell(1, 0, ' or (888) 606-7600.', 0, false, 'L', 0, '', 0, false, 'T', 'M');
		$this->Cell(1.25, 0, date('m/d/Y'), 0, false, 'R', 0, '', 0, false, 'T', 'M');
		$this->Cell(0, 0, 'Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
	}
	
	
}