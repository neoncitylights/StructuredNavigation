<?php

namespace StructuredNavigation\Hooks;

use Article;
use StructuredNavigation\View\NonExistentView;

/**
 * @see https://www.mediawiki.org/wiki/Manual:Hooks/BeforeDisplayNoArticleText
 * @license MIT
 */
final class BeforeDisplayNoArticleTextHandler {

	private const RESOURCELOADER_MODULES = [
		'ext.structurednavigation.libs.view.emptystate.styles',
		'ext.structurednavigation.view.nonexistent.styles',
	];

	/** @var Article */
	private $article;

	/**
	 * @param Article $article
	 */
	public function __construct( Article $article ) {
		$this->article = $article;
	}

	/**
	 * @return bool
	 */
	public function getHandler() : bool {
		if ( $this->article->getPage()->getContentModel() !== CONTENT_MODEL_NAVIGATION ) {
			return true;
		}

		$this->getView();

		return false;
	}

	/**
	 * @return void
	 */
	private function getView() : void {
		$context = $this->article->getContext();
		$output = $context->getOutput();

		$output->enableOOUI();
		$output->addModuleStyles( self::RESOURCELOADER_MODULES );
		$output->addHTML(
			( new NonExistentView(
				$context->getConfig()->get( 'ExtensionAssetsPath' ),
				$context,
				$this->article->getTitle()
			) )->getView()
		);
	}

}
