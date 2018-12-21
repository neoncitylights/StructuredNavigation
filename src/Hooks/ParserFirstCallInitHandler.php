<?php

namespace StructuredNavigation\Hooks;

use JsonContent;
use Parser;
use ParserOutput;
use StructuredNavigation\JsonEntity;
use StructuredNavigation\Renderer\TableRenderer;
use Title;
use WikiPage;

/**
 * @license GPL-2.0-or-later
 */
final class ParserFirstCallInitHandler {

	/** @var TableRenderer */
	private $tableRenderer;

	/**
	 * @param TableRenderer $tableRenderer
	 */
	public function __construct( TableRenderer $tableRenderer ) {
		$this->tableRenderer = $tableRenderer;
	}

	/**
	 * @param string|null $input
	 * @param array $attributes
	 * @param Parser $parser
	 * @return string
	 */
	public function getParserHandler( $input, array $attributes, Parser $parser ) : string {
		// Retrieve title and get page
		$title = Title::makeTitle( NS_NAVIGATION, $attributes['title'] );
		$page = WikiPage::factory( $title );

		// retrieve data for page of interest
		$content = $this->getParsedData( $page->getContent() );

		// setup ParserOutput
		$parserOutput = $parser->getOutput();
		$this->setPageProperty( $parserOutput, $title->getArticleID() );
		$this->loadResourceLoaderModules( $parserOutput );

		return $this->tableRenderer->render( $content );
	}

	/**
	 * @param JsonContent $content
	 * @return JsonEntity
	 */
	private function getParsedData( JsonContent $content ) : JsonEntity {
		return new JsonEntity( $content->getJsonData() );
	}

	/**
	 * @param ParserOutput $parserOutput
	 */
	private function loadResourceLoaderModules( ParserOutput $parserOutput ) {
		$parserOutput->addModuleStyles( [
			'ext.structurednavigation.ui.structurednavigation.styles',
			'ext.structurednavigation.ui.structurednavigation.separator.styles'
		] );
	}

	/**
	 * @param ParserOutput $parserOutput
	 * @param int $articleId
	 */
	private function setPageProperty( ParserOutput $parserOutput, int $articleId ) {
		$parserOutput->setProperty( 'structurednavigation', $articleId );
	}
}
