<?php

namespace StructuredNavigation\Api;

use ApiQuery;
use ApiQueryBase;
use StructuredNavigation\Json\DocumentationContent;

/**
 * @license MIT
 */
class ApiMetaNavigationExamples extends ApiQueryBase {

	/** @var DocumentationContent */
	private $documentationContent;

	/** @inheritDoc */
	public function __construct(
		ApiQuery $apiQuery,
		string $moduleName,
		DocumentationContent $documentationContent
	) {
		parent::__construct( $apiQuery, $moduleName );
		$this->documentationContent = $documentationContent;
	}

	/** @inheritDoc */
	public function execute() {
		$this->getResult()->addValue(
			'query',
			$this->getModuleName(),
			$this->documentationContent->getExamples()
		);
	}

	/** @inheritDoc */
	protected function getExamplesMessages() {
		return [
			"action=query&meta={$this->getModuleName()}"
				=> 'apihelp-query+structurednavigationexamples-example',
		];
	}

}