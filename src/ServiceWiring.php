<?php

namespace StructuredNavigation;

use Config;
use MediaWiki\MediaWikiServices;
use StructuredNavigation\Renderer\NavigationRenderer;

/**
 * @license GPL-2.0-or-later
 */

return [
	Constants::SERVICE_CONFIG => function ( MediaWikiServices $services ) : Config {
		return $services->getConfigFactory()->makeConfig( 'structurednavigation' );
	},

	Constants::SERVICE_NAVIGATION_RENDERER => function ( MediaWikiServices $services ) : NavigationRenderer {
		return new NavigationRenderer(
			$services->getLinkRenderer(),
			$services->getTitleParser()
		);
	},
];
