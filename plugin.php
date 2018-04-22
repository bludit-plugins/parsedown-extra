<?php

class pluginParsedownExtra extends Plugin {

	private function parse($content)
	{
		require_once($this->phpPath().'vendors/ParsedownExtra.php');
		$ParsedownExtra = new ParsedownExtra();
		return $ParsedownExtra->text($content);
	}

	public function beforeSiteLoad()
	{
		if ($GLOBALS['WHERE_AM_I']=='page') {
			$content = $this->parse($GLOBALS['page']->contentRaw());
			$explode = explode(PAGE_BREAK, $content);

			$GLOBALS['page']->setField('content', $content);
			$GLOBALS['page']->setField('contentBreak', $explode[0]);
		} else {
			foreach ($GLOBALS['pages'] as $key=>$page)  {
				$content = $this->parse($page->contentRaw());
				$explode = explode(PAGE_BREAK, $content);

				$GLOBALS['pages'][$key]->setField('content', $content);
				$GLOBALS['pages'][$key]->setField('contentBreak', $explode[0]);
			}
			$GLOBALS['content'] = $GLOBALS['pages'];
			$GLOBALS['page'] = $GLOBALS['pages'][0];
		}
	}
}
