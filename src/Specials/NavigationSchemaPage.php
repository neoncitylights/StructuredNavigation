<?php

namespace StructuredNavigation\Specials;

use OOUI\Tag;
use SpecialPage;
use StructuredNavigation\Json\SchemaContent;

/**
 * @license MIT
 */
final class NavigationSchemaPage extends SpecialPage {

	private const PAGE_NAME = 'NavigationSchema';

	/** @var SchemaContent */
	private $schemaContent;

	/**
	 * @param SchemaContent $schemaContent
	 */
	public function __construct( SchemaContent $schemaContent ) {
		parent::__construct( self::PAGE_NAME );

		$this->schemaContent = $schemaContent;
	}

	/**
	 * @inheritDoc
	 */
	protected function getGroupName() {
		return Constants::SPECIAL_PAGE_GROUP;
	}

	/**
	 * @param string|null $subPage
	 */
	public function execute( $subPage ) {
		$this->setHeaders();
		$this->getOutput()->addHTML(
			$this->getEmbeddedCodeView( $this->schemaContent->getSchemaContent() )
		);
	}

	/**
	 * @param string $content
	 * @return Tag
	 */
	private function getEmbeddedCodeView( string $content ) : Tag {
		return ( new Tag( 'pre' ) )
			->appendContent( $content );
	}

}
