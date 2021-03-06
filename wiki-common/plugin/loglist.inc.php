<?php
/**
 * PukiWiki Plus! ログリストプラグイン
 *
 * @copyright	Copyright &copy; 2004-2006, Katsumi Saito <katsumi@jo1upk.ymt.prug.or.jp>
 * @version	$Id: loglist.php,v 0.5.3 2015/06/09 20:46:00 Logue Exp $
 * @license	http://opensource.org/licenses/gpl-license.php GNU Public License
 */

use PukiWiki\Auth\Auth;
use PukiWiki\Renderer\RendererFactory;

/*
 * 初期処理
 */
function plugin_loglist_init()
{
	$messages = array(
		'_loglist_messages' => array(
			'msg_not_found'	=> T_('no data.'),
			'fld_UTIME'		=> T_('Date'),
			'fld_PAGE'		=> T_('Page Name'),
			'fld_COUNT'		=> T_('Count'),
			'not_active'	=> T_('Not Active.'),
		)
	);
	set_plugin_messages($messages);
}

/*
 * ブロック型プラグイン
 */
function plugin_loglist_convert()
{
	global $script, $log;
	global $vars;
	global $_loglist_messages;

	list($kind) = func_get_args();
	$kind = (empty($kind)) ? 'update' : htmlsc($kind, ENT_QUOTES);

	if (!$log[$kind]['use']) return $_loglist_messages['not_active'];
	if (!empty($log[$kind]['file'])) {
		$vars['kind'] = $kind;
		$rc = do_plugin_action('logview');
		return $rc['body'];
	}

	$dir = log::get_filename($kind,'','');
	$pages = Auth::get_existpages($dir);

	if (count($pages) == 0) return $_loglist_messages['msg_not_found'];

	$data = array();
	foreach ($pages as $_real => $_page) {
		$data[] = array(
			filemtime($dir.'/'.$_real),
			$_page,
			log_count($kind,$_page),
		);
	}

	usort($data,function($a,$b){
		return $b[0] - $a[0];
	}); // D
	// usort($data,create_function('$a,$b','return $a[0] - $b[0];')); // A

	//$str_view = $script.'?plugin=logview&kind='.$kind.'&page=';
	$str_view = get_cmd_uri('logview', $_page, null, array('kind'=>$kind));
	$rc = '';

	$rc .=  '|'.$_loglist_messages['fld_UTIME'].
		'|'.$_loglist_messages['fld_PAGE'].
		'|'.$_loglist_messages['fld_COUNT'].
		"|h\n";

	foreach ($data as $_line) {
		$i = 0;
		foreach ($_line as $_field) {
			$rc .= '|';
			switch ($i) {
			case 0:
				$rc .= get_date('Y-m-d H:i:s', $_field).' '.get_passage($_field);
				continue;
			case 1:
				$rc .= '['.$str_view.rawurlencode($_field).' '.$_field.']';
				continue;
			default:
				$rc .= $_field;
			}
			$i++;
		}
		$rc .= "|\n";
	}
	return RendererFactory::factory($rc);
}

/* End of file loglist.inc.php */
/* Location: ./wiki-common/plugin/loglist.inc.php */