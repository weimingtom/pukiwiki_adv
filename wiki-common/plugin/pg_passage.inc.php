<?php
// PukiWiki - Yet another WikiWikiWeb clone.
// $Id: pg_passage.inc.php,v 0.2 2011/02/05 12:04:00 Logue Exp $

function plugin_pg_passage_inline()
{
	$argv = func_get_args();
	$argc = func_num_args();

	$field = array('page','paren',);
	for($i=0; $i<$argc; $i++) {
		$$field[$i] = htmlsc($argv[$i], ENT_QUOTES);
	}

	if (empty($page)) return '';
	$paren = (empty($paren)) ? FALSE : TRUE;
	return get_pg_passage($page, $paren);
}

/* End of file pg_passage.inc.php */
/* Location: ./wiki-common/plugin/pg_passage.inc.php */