<?php


class LocalhostOverview
{

	protected $sLocalhostDomainSuffix = '.localtest.me';

	protected $sFaviconLocation = '/favicons/';

	private $aWebsiteData = [];

	public function __construct( $bSaveFavicon = true )
	{

		$sWebFolder = preg_replace( '/localhost-overview$/', '', __DIR__ );

		$aFolders = glob( $sWebFolder . '*', GLOB_ONLYDIR );
		foreach ( $aFolders as $sFolderName ) {
			$sFolderName = str_replace( $sWebFolder, '', $sFolderName );
			if ( $sFolderName !== 'localhost-overview' ) {
				$this->aWebsiteData[] =
					[
						'name'    => $sFolderName,
						'url'     => '//' . $sFolderName . $this->sLocalhostDomainSuffix,
						'favicon' => $this->getFavicon( $sFolderName ),
					];
			}
		}

		if ( $bSaveFavicon ) {
			$this->saveFavicon();
		}

	}

	public function getWebsites()
	{
		return $this->aWebsiteData;
	}

	public function getItemWidth()
	{
		$iTotalItems = count( $this->aWebsiteData );
		$iColumns    = round( sqrt( $iTotalItems ) );
		if ( $iColumns > 4 ) {
			$iColumns = 4;
		}

		return $iColumns;
	}

	private function getFavicon( $sDomainName )
	{
		if ( $aFiles = glob( __DIR__ . $this->sFaviconLocation . $sDomainName . '.{jpg,jpeg,png,gif,ico}', GLOB_BRACE ) ) {
			return preg_replace( '/^' . preg_quote( __DIR__ ) . '/', '', $aFiles[ 0 ] );
		} else {
			return $this->getFaviconUrl( $sDomainName );
		}
	}

	private function getFaviconUrl( $sDomainName )
	{

		$sFaviconUrl = false;
		$sDomainName = strtolower( $sDomainName . $this->sLocalhostDomainSuffix );

		$oCurl = curl_init( $sDomainName );
		curl_setopt( $oCurl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $oCurl, CURLOPT_FOLLOWLOCATION, true );
		$sHtml = curl_exec( $oCurl );
		curl_close( $oCurl );

		$sRegex = '/((<link[^>]+rel=.(icon|shortcut icon|alternate icon)[^>]+>))/i';
		if ( preg_match( $sRegex, $sHtml, $aMatch ) ) {
			$sRegex = '/href=(\'|\")(.*?)\1/i';
			if ( isset( $aMatch[ 1 ] ) and preg_match( $sRegex, $aMatch[ 1 ], $matchUrl ) ) {
				if ( isset( $matchUrl[ 2 ] ) ) {
					$sHref = trim( $matchUrl[ 2 ] );
					switch ( $sHref ) {
						case strpos( $sHref, "//" ) === 0 :
							$sFaviconUrl = 'http:' . $sHref;
							break;
						case parse_url( $sHref, PHP_URL_SCHEME ) != '' :
							$sFaviconUrl = $sHref;
							break;
						case $sHref[ 0 ] == '#' or $sHref[ 0 ] == '?' :
							$sFaviconUrl = $sDomainName . $sHref;
							break;
						default:
							$sFaviconUrl = $sDomainName . "/" . $sHref;
							$sFaviconUrl = preg_replace( "/(\/\.?\/)/", "/", $sFaviconUrl );
							$sFaviconUrl = preg_replace( "/\/(?!\.\.)[^\/]+\/\.\.\//", "/", $sFaviconUrl );
							$sFaviconUrl = 'http://' . $sFaviconUrl;
					}
				}
			}
		}

		if ( empty( $sFaviconUrl ) ) {
			if ( @getimagesize( 'http://' . $sDomainName . '/favicon.ico' ) ) {
				$sFaviconUrl = 'http://' . $sDomainName . '/favicon.ico';
			}
		}

		return $sFaviconUrl;
	}

	public function saveFavicon( $bIsAsync = false )
	{

		if ( ! $bIsAsync ) {

			$sPhpExecutable = ini_get( 'extension_dir' );
			$sPhpExecutable = rtrim( $sPhpExecutable, '/\\' );
			$sPhpExecutable = preg_replace( '/ext$/', 'php.exe', $sPhpExecutable );

			if ( ! file_exists( $sPhpExecutable ) ) {
				$sPhpExecutable = 'php';
			}

			pclose( popen( 'start /B ' . $sPhpExecutable . ' download_favicons.php', 'r' ) );

		} else {

			if ( ! file_exists( __DIR__ . $this->sFaviconLocation ) ) {
				mkdir( __DIR__ . $this->sFaviconLocation );
			}

			foreach ( $this->aWebsiteData as $aData ) {

				if ( $aData[ 'favicon' ] ) {

					if ( substr( $aData[ 'favicon' ], 0, 4 ) === "http" ) {
						$sLocation = __DIR__ . $this->sFaviconLocation . $aData[ 'name' ] . '.' . pathinfo( parse_url( $aData[ 'favicon' ] )[ 'path' ], PATHINFO_EXTENSION );
						file_put_contents( $sLocation, file_get_contents( $aData[ 'favicon' ] ) );
					} else {
						if ( filemtime( __DIR__ . $aData[ 'favicon' ] ) ) {
							if ( date( 'Y-m-d', filemtime( __DIR__ . $aData[ 'favicon' ] ) ) !== date( 'Y-m-d' ) ) {
								$sFaviconUrl = $this->getFaviconUrl( $aData[ 'name' ] );
								$sLocation   = __DIR__ . $this->sFaviconLocation . $aData[ 'name' ] . '.' . pathinfo( parse_url( $sFaviconUrl )[ 'path' ], PATHINFO_EXTENSION );
								file_put_contents( $sLocation, file_get_contents( $sFaviconUrl ) );
							}
						}
					}
				}

			}

		}
	}

}