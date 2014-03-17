<?php
/**
 * インライン要素クラス
 *
 * @package   PukiWiki\Renderer\Element
 * @access    public
 * @author    Logue <logue@hotmail.co.jp>
 * @copyright 2013-2014 PukiWiki Advance Developers Team
 * @create    2013/01/26
 * @license   GPL v2 or (at your option) any later version
 * @version   $Id: HRule.php,v 1.0.1 2014/03/17 17:29:00 Logue Exp $
 */

namespace PukiWiki\Renderer\Element;

use PukiWiki\Renderer\Element\Element;
use PukiWiki\Renderer\Element\Paragraph;
use PukiWiki\Renderer\InlineFactory;

/**
 * Inline elements
 */
class InlineElement extends Element
{
	public function __construct($text)
	{
		parent::__construct();
		$this->elements[] = trim((substr($text, 0, 1) === "\n") ?
			$text : InlineFactory::factory($text));
	}

	public function insert(& $obj)
	{
		$this->elements[] = $obj->elements[0];
		return $this;
	}

	public function canContain(& $obj)
	{
		return $obj instanceof self;
	}

	public function toString()
	{
		global $line_break;
		// 改行を<br />に変換するか？
		return join(($line_break ? '<br />' . "\n" : "\n"), $this->elements);
	}

	public function toPara($class = '')
	{
		$obj = new Paragraph(null, $class);
		$obj->insert($this);
		return $obj;
	}
}

/* End of file Inline.php */
/* Location: /vendor/PukiWiki/Lib/Renderer/Element/Inline.php */