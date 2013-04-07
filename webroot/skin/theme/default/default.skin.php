<?php
/////////////////////////////////////////////////
// PukiWiki - Yet another WikiWikiWeb clone.
//
// PukiWiki Plus! skin for PukiWiki Advance.
// Original version by miko and upk.
// Modified by Logue
//
// $Id: default.skin.php,v 1.4.18 2012/05/03 21:35:00 Logue Exp $
//
use PukiWiki\Time;
use PukiWiki\Factory;
use PukiWiki\Renderer\PluginRenderer;

// navibar
$navibar = PluginRenderer::executePluginBlock('suckerfish');
if (empty($navibar)) $navibar = PluginRenderer::executePluginBlock('navibar','top,|,edit,freeze,diff,backup,upload,reload,|,new,list,search,recent,help,|,login'). '<hr />';

// start
// Output HTML DTD, <html>, and receive content-type
?>
<!doctype html>
<head prefix="og: http://ogp.me/ns# fb: http://www.facebook.com/2008/fbml">
<?php echo $this->head; ?>
<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/<?php echo JQUERY_UI_VER; ?>/themes/redmond/jquery-ui.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo SKIN_URI . 'scripts.css.php?base=' . urlencode(IMAGE_URI) ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo SKIN_URI . THEME_PLUS_NAME . PLUS_THEME . '/'. PLUS_THEME . '.css.php'; ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo SKIN_URI . THEME_PLUS_NAME . PLUS_THEME . '/blue.css'; ?>"id="coloring" />
<title><?php echo $this->title . ' - ' . $this->site_name; ?></title>
</head>
	<body>
		<div id="container" class="<?php echo $this->colums ?>" role="document">
<!-- *** Header *** -->
			<header id="header" role="banner">
<?php if (empty($this->headarea)){ ?>
				<a href="<?php echo $this->links['top'] ?>"><img id="logo" src="<?php echo $this->conf['logo']['src'] ?>" width="<?php echo $this->conf['logo']['width'] ?>" height="<?php echo $this->conf['logo']['height'] ?>" alt="<?php echo $this->conf['logo']['alt'] ?>" /></a>
				<hgroup id="hgroup">
					<h1 id="title"><?php echo $this->title ?></h1>
					<h2><a href="<?php echo $this->links['reload'] ?>" id="parmalink"><?php echo $this->links['reload'] ?></a></h2>
				</hgroup>
<!-- * Ad space *-->
				<?php if ($this->conf['adarea']['header']) echo '<div id="ad" class="noprint">' . $this->conf['adarea']['header'] . '</div>'; ?>
<!-- * End Ad space * -->
<?php }else{ ?>
				<h1 id="title" style="display:none;"><?php echo $this->title ?></h1>
				<?php echo $this->headarea; ?>
<?php } ?>
				<?php echo (!empty($this->lastmodified)) ? '<div id="lastmodified">Last-modified: '.$this->lastmodified.'</div>'."\n" : '' ?>
			</header>
<!-- *** End Header *** -->

			<?php echo $navibar; ?>
			<div id="wrapper" class="clearfix">
<!-- Center -->
				<div id="main_wrapper">
					<div id="main" role="main">
						<?php echo PluginRenderer::executePluginBlock('topicpath'); ?>
						<section id="body">
							<?php echo $this->body."\n" ?>
						</section>
<?php if (!empty($notes)) { ?>
						<hr />
						<!-- * Note * -->
						<aside id="note" role="note">
							<?php echo $this->notes."\n" ?>
						</aside>
						<!--  End Note -->
<?php } ?>
						<?php if (!empty($this->conf['adarea']['footer'])) echo '<div id="footer_adspace" class="noprint" style="text-align:center;">' . $this->conf['adarea']['footer'] . '</div>'; ?>
					</div>
				</div>

<?php if (!empty($this->menubar))  { ?>
<!-- Left -->
				<aside id="menubar">
					<?php echo $this->menubar ?>
				</aside>
<?php } ?>

<?php if (!empty($this->sidebar))  { ?>
<!-- Right -->
				<aside id="sidebar">
					<?php echo $this->sidebar; ?>
				</aside>
<?php } ?>
			</div>
			<div id="misc">
<?php if (!empty($this->attaches)) { ?>
				<hr />
				<!-- * Attach * -->
				<aside id="attach">
					<?php echo $this->attaches ?>
				</aside>
				<!--  End Attach -->
<?php } ?>
<?php if (!empty($this->related)) { ?>
				<!-- * Related * -->
				<hr />
				<aside id="related">
					<?php echo $this->related ?>
				</aside>
				<!--  End Related -->
<?php } ?>
				<hr />
				<?php echo PluginRenderer::executePluginBlock('toolbar','reload,|,new,newsub,edit,freeze,source,diff,upload,copy,rename,|,top,list,search,recent,backup,referer,log,|,help,|,rss');?>
			</div>

			<footer id="footer" class="clearfix" role="contentinfo">
<?php if (!empty($this->footarea)) { ?>
				<?php echo $this->footarea; ?>
<?php }else{ ?>
				<div id="qr_code">
					<?php echo PluginRenderer::executePluginInline('qrcode'); ?>
				</div>
				<address>Founded by <a href="<?php echo $this->modifierlink ?>" rel="contact"><?php echo $this->modifier ?></a></address>
				<div id="sigunature">
					Powered by <a href="http://pukiwiki.logue.be/" rel="external"><?php echo GENERATOR ?></a>. Processing time: <var><?php echo $this->getTakeTime() ?></var> sec. <br />
					Original Theme Design by <a href="http://pukiwiki.cafelounge.net/plus/" rel="external">PukiWiki Plus!</a> Team.
				</div>
				<div id="banner_box">
					<a href="http://pukiwiki.logue.be/" rel="external"><img src="<?php echo IMAGE_URI; ?>pukiwiki_adv.banner.png" width="88" height="31" alt="PukiWiki Advance" title="PukiWiki Advance" /></a>
					<a href="http://validator.w3.org/check/referer" rel="external"><img src="<?php echo IMAGE_URI ?>html5.png" width="88" height="31" alt="HTML 5" title="HTML5" /></a>
				</div>
<?php } ?>
			</footer>
		</div>
		<?php echo $this->js; ?>
	</body>
</html>
