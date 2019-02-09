<?php

namespace StructuredNavigation\Services;

use Config;
use ConfigException;
use MediaWiki\MediaWikiServices;
use StructuredNavigation\NavigationLinkRenderer;
use StructuredNavigation\Hooks\ParserFirstCallInitHandler;
use StructuredNavigation\Renderer\NavigationRenderer;
use UnexpectedValueException;

/**
 * Acts as a convience wrapper around the \MediaWiki\MediaWikiServices
 * object for retrieving services specific to this extension. This allows
 * the consumer to not have to know the unique service key of the specific
 * service, they can just call a method for what they want.
 *
 * @license GPL-2.0-or-later
 */
final class Services {

	/** @var MediaWikiServices */
	private $services;

	/**
	 * @param MediaWikiServices $services
	 */
	public function __construct( MediaWikiServices $services ) {
		$this->services = $services;
	}

	/**
	 * @return Services
	 */
	public static function getInstance() : Services {
		return new self( MediaWikiServices::getInstance() );
	}

	/**
	 * @throws ConfigException|UnexpectedValueException
	 * @return Config
	 */
	public function getConfig() : Config {
		return $this->services->getService( Constants::SERVICE_CONFIG );
	}

	/**
	 * @return NavigationLinkRenderer
	 */
	public function getNavigationLinkRenderer() : NavigationLinkRenderer {
		return $this->services->getService( Constants::SERVICE_NAVIGATION_LINK_RENDERER );
	}

	/**
	 * @return NavigationRenderer
	 */
	public function getNavigationRenderer() : NavigationRenderer {
		return $this->services->getService( Constants::SERVICE_NAVIGATION_RENDERER );
	}

	/**
	 * @return ParserFirstCallInitHandler
	 */
	public function getParserFirstCallInitHandler() : ParserFirstCallInitHandler {
		return $this->services->getService(
			Constants::SERVICE_PARSERFIRSTCALLINIT_HANDLER
		);
	}

}
