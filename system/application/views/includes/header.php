<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
	"http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<title><?php echo $pageTitle; ?></title>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="initial-scale=1, maximum-scale=1,user-scalable=no" />
		<link rel="stylesheet" type="text/css" href="http://serverapi.arcgisonline.com/jsapi/arcgis/2.1/js/dojo/dijit/themes/tundra/tundra.css"/>
		<link rel="stylesheet" href="/css/ui-lightness/jquery-ui-1.8.5.custom.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="/css/style.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="/css/jquery.qtip.css" type="text/css" media="screen" charset="utf-8" />
		<script src="/js/jquery-1.4.2.min.js" type="text/javascript"></script>
		<?php if ($this->uri->segment(1) != "logon"): ?>
			<script type="text/javascript" src="/js/jquery-ui-1.8.4.custom.min.js"></script>
			<script type="text/javascript" src="http://serverapi.arcgisonline.com/jsapi/arcgis/?v=2.1"></script>
			<script type="text/javascript" src="/js/jquery.entwine-dist.js"></script>
			<script type="text/javascript" src="/js/jquery.metadata.js"></script>
			<script type="text/javascript" src="/js/jquery.tablesorter.min.js"></script>
			<script type="text/javascript" src="/js/jquery.qtip.js"></script>
			<script type="text/javascript" src="/js/civic.js"></script>
			<script type="text/javascript" src="/js/civic.widgets.js"></script>
			<script type="text/javascript" src="/js/jquery-ui-personalized-1.6rc6.js"></script>
			<script type="text/javascript" src="/js/jquery.ui.widget.js"></script>
			<script type="text/javascript" src="/js/analysis.js"></script>
			<script type="text/javascript" src="/js/fusioncharts/FusionCharts_Website/Charts/FusionCharts.js"></script>
			<?php
			if (isset($extraJS)):
				if (!is_array($extraJS)) {
					echo '<script type="text/javascript" src="/js/' . $extraJS . '.js"></script>' . "\n";
				}
				else {
					foreach ($extraJS as $script) {
						echo '<script type="text/javascript" src="/js/' . $script . '.js"></script>' . "\n";
					}
				}
			endif;
			if (isset($extraCSS)):
				if (!is_array($extraCSS)) {
					echo '<link href="/css/' . $extraCSS . '.css" rel="stylesheet" type="text/css" />' . "\n";
				}
				else {
					foreach ($extraCSS as $css) {
						echo '<link href="/css/' . $css . '.css" rel="stylesheet" type="text/css" />' . "\n";
					}
				}
			endif;
			?>
			<script type="text/javascript" charset="utf-8">
				$(document).ready(function(){
					$(".ultabs").tabs();
					// add parser through the tablesorter addParser method
					jQuery.tablesorter.addParser({
						id: "commaDigit",
						is: function(s, table) {
							var c = table.config;
							return jQuery.tablesorter.isDigit(s.replace(/,/g, ""), c);
						},
						format: function(s) {
							return jQuery.tablesorter.formatFloat(s.replace(/,/g, ""));
						},
						type: "numeric"
					});
					$('.tableSorter').tablesorter({sorter: 'commaDigit'});
					$('.tip').qtip({
						style: {
							tip: {
								corner: 'top left',
								mimic: 'top center',
								offset: 30,
								border: 1
							}
						},
						position: {
							my: 'top center',
							adjust: { x: 25, y: 10 }
						}
					});
					$('.generate_pdf_report').attr('title','Click this icon to make a report of the data on this page');
					$('.generate_pdf_report').qtip({
						style: {
							tip: {
								corner: 'top left',
								mimic: 'top center',
								offset: 30,
								border: 1
							}
						},
						position: {
							my: 'top center',
							adjust: { x: 25, y: 10 }
						}
					});
				});
//				function check_login() {
//					if (confirm('Your session is about to expire. To stay logged in, click Ok.')) {
//						$.ajax({
//							url: 'common_ajax/relogin_user',
//							success: function(resp) {
//								if (resp == 1) {
//									alert('Your session has been restored.');
//								}
//							}
//						});
//					}
//					else {
//						window.location.href = '/logon';
//					}
//				}
//				setInterval('check_login()', 7100000); // 100 seconds to answer
			</script>
		<?php endif; ?>
	</head>
	<body class="<?php if (isset($pageClass))
			echo $pageClass; ?>">
		<div id="wrapper"><!-- terminated in footer.php -->
			<!--HEADER-->
			<div id="header">
				<div id="globalnav">
					<?php if ($this->uri->segment('1') != 'logon'): ?>
						<ul id="globalnavlist">
							<li><a href="/about" title="Read background information about CommunityConnect with LiteracyDecision" class="tip">About</a></li>
							<?php
							$check_uid = $this->session->userdata('uid');
							$check_role = $this->session->userdata('role');
							$check_auth = $this->session->userdata('auth');
							if (isset($check_uid) && $check_uid > 0):
								?>
								<li><a href="/myaccount" title="Change your preferences and password" class="tip">My Account</a></li>
								<?php
							endif;
							if (isset($check_auth)):
								?>
								<li><a href="/logout" title="logout" class="tip">Logout</a></li>
							<?php else: ?>
								<li><a href="/logon" title="Log in" class="tip">Login</a></li>
							<?php endif; ?>
							<li><a href="/support" title="Look up terms in the glossary, get contact information, and read the LiteracyDecision Methodology" class="tip">Support</a></li>
							<?php if ($check_uid > 0): ?>
							<li><a href="/reports" id="reports" class="tip" title="View and work with your saved reports">Reports</a></li>
							<?php endif; ?>
							<?php if (isset($check_uid) && $check_uid > 0 && ($check_role == 2 || $check_role == 3)): ?>
								<li><a href="/customeradmin">Customer Admin</a></li>
							<?php endif; ?>
						</ul>
					<?php endif; // logon  ?>
				</div>
				<a href="#"><img src="/css/images/header.jpg" height="75px" id="clark_county" al="Clark County Library District"/></a>
				<img id="community_connect" src="/css/images/commconn.png" alt="Community Connect" />
				<span id="beta">BETA</span>
			</div>
			<!--End DIV header-->
			<div id="tabs">
				<?php
				if ($this->uri->segment('1') != 'logon'):
					$tabsArray = array(// id | url | text | title/tooltip
						'homebutton' => array(
							'status' => 'enabled',
							'id' => 'homebutton',
							'url' => 'home',
							'text' => 'Home',
							'title' => "We're going home"
						),
						'customersbutton' => array(
							'status' => 'enabled',
							'id' => 'customersbutton',
							'url' => 'findcustomers',
							'text' => 'Find Customers',
							'title' => 'Pinpoint where to find new customers'
						),
						'increasebutton' => array(
							'status' => 'enabled',
							'id' => 'increasebutton',
							'url' => 'increaseservices',
							'text' => 'Increase Services',
							'title' => 'Discover which services to offer which customers'
						),
						// removed Plan Materials button for Phase I launch
						//					'planbutton' => array(
						//						'status' => 'disabled',
						//						'id' => 'planbutton',
						//						'url' => '',
						//						'text' => 'Plan Materials &amp; Budgets',
						//						'title' => 'Target investment and measure ROI...coming soon.'
						//					),
						'literacybutton' => array(
							'status' => 'enabled',
							'id' => 'literacybutton',
							'url' => 'literacydecision',
							'text' => 'LiteracyDecision',
							'title' => 'Find literacy challenged people and identify services to help them'
						),
						'comparebutton' => array(
							'status' => 'enabled',
							'id' => 'comparebutton',
							'url' => 'compareservices',
							'text' => 'Compare Service Areas',
							'title' => 'Compare detailed service area information for a district-wide view and to see how each service area stacks up'
						),
						'researchbutton' => array(
							'status' => 'enabled',
							'id' => 'researchbutton',
							'url' => 'marketresearch',
							'text' => 'Market Research',
							'title' => 'Perform detailed market research'
						),
						'feedbackbutton' => array(
							'status' => 'enabled',
							'id' => 'feedbackbutton',
							'url' => 'feedback',
							'text' => 'Feedback',
							'title' => 'Provide detailed feedback'
						)
					);
					/*
					  'researchbutton' => array(
					  'status' => 'disabled',
					  'id' => 'researchbutton',
					  'url' => 'marketresearch',
					  'text' => 'Market Research',
					  'title' => 'Perform detailed market research using current year demographic, market potential, and consumer spending data.'
					  )
					 */
					foreach ($tabsArray as $id => $tab) {
						if ($tab['status'] == 'disabled') {
							$class = " faded";
						}
						elseif ($tab['url'] == $this->uri->segment(1) || ($tab['url'] == 'home' && $this->uri->segment(1) == '')) {
							$class = " current ";
						}
						else {
							$class = "";
						}
						$span = $this->common->tool_tip($tab['title'], $tab['text']);
						echo '<div class="mainMenu ' . $class . '" id="' . $id . '"><a href="/' . $tab['url'] . '">' . $span . '</a></div>';
					}
				endif; // logon
				?>
			</div>
			<div id="container">
				<div id="appcontainer" class="contain">
					<!--MAIN-->
					<div id="main">
						<div id="mapoverlay">
							<div id="contentwrapper">
								<div id="mappulldownbox">
									<p class="widgetlabel">Map Menu</p>
								</div>
							</div>
						</div>
