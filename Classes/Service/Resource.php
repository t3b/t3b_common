<?php

/* * *****************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Anno v. Heimburg <avonheimburg@agenturwerft.de>, Agenturwerft
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as
 *  published by the Free Software Foundation; either version 2 of
 *  the License, or (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * **************************************************************** */

namespace T3b\T3bCommon\Service;

class CssDescriptor
{

    /**
     * @var string
     */
    public $file;

    /**
     * @var string
     */
    public $media;

    public function __construct($path, $media)
    {
        $this->file = $path;
        $this->media = $media;
    }
}

class JsDescriptor
{
    /**
     * @var string
     */
    public $uri;

    public function __construct($uri)
    {
        $this->uri = $uri;
    }
}


/**
 * Adds resources (JS/CSS files) to the page
 *
 * Used by the resource viewhelpers
 */
class Resource implements \TYPO3\CMS\Core\SingletonInterface
{

    protected $jsLibUriPattern = "//ajax.googleapis.com/ajax/libs/@name/@version/@file";
    protected $nameFileMapping = array(
        'jquery' => 'jquery.min.js',
        'jqueryui' => 'jquery-ui.min.js',
        'webfont' => 'webfont'
    );

    protected $jsLibrariesFooter = array();
    protected $jsLibrariesHeader = array();
    protected $cssFiles = array();
    protected $jsFilesFooter = array();
    protected $jsFilesHeader = array();

    private $loadedExtResource = array();
    private $loadedJsLibraries = array();

    /**
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
     */
    protected $configurationManager;

    /**
     * @param \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager
     * @return void
     */
    public function injectConfigurationManager(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager)
    {
        $this->configurationManager = $configurationManager;
    }


    /**
     * Check whether we are currently running cached
     *
     * @return boolean
     */
    protected function isCached()
    {
		$isCached = FALSE;
		if ($contentObject = $this->configurationManager->getContentObject()) {
			$userObjType = $contentObject->getUserObjectType();
			$isCached = $userObjType !== \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer::OBJECTTYPE_USER_INT;
		}
		return $isCached;
    }

    /**
     * Include a CSS file
     * @param string $file css file
     * @param string $media
     * @return void
     */
    public function addCss($file, $media = 'all')
    {

        $filePath = self::resolvePath($file);

        if ($this->shouldLoadResource($filePath)) {
            if ($this->isCached()) {
                $this->cssFiles[md5($filePath . ':' . $media)] = new CssDescriptor($filePath, $media);
            } else {
                $GLOBALS['TSFE']->additionalHeaderData[md5($filePath)] = '<link rel="stylesheet" type="text/css" media="' . $media . '" href="' . $filePath . '"/>';
            }
        }

    }

    /**
     * Paths starting with //, http:// or https:// will be regarded as an URI and returned as is
     * All other paths will be regarded as local and EXT:-paths will be resolved
     *
     * @param string $uri uri to resolve
     * @return string resolved path
     */
    private static function resolvePath($uri)
    {
        static $urlStart = array('//', 'http://', 'https://');

        $isUri = FALSE;
        foreach ($urlStart as $start) {
            if (strpos($uri, $start) === 0) {
                $isUri = TRUE;
                break;
            }
        }

        if ($isUri) {
            return $uri;
        } else {
            return \T3b\T3bCommon\Utility\File::siteRelFilePath($uri);
        }

    }

    private function shouldLoadResource($uri)
    {
        $key = md5($uri);
        if (isset($this->loadedExtResource[$key])) {
            return FALSE;
        } else {
            $this->loadedExtResource[$key] = TRUE;
            return TRUE;
        }
    }

    /**
     * Add a javascript file
     *
     * @param string $file path to file
     * @param boolean $addToHeader add the script-tag to the head element instead of to the bottom of the page
     * @return void
     */
    public function addJs($file, $addToHeader = false)
    {

        $filePath = self::resolvePath($file);

        if ($this->shouldLoadResource($filePath)) {
            if ($this->isCached()) {
                if ($addToHeader) {
                    $this->jsFilesHeader[] = new JsDescriptor($filePath);
                } else {
                    $this->jsFilesFooter[] = new JsDescriptor($filePath);
                }
            } else {
                $GLOBALS['TSFE']->additionalHeaderData[md5($filePath)] = '<script type="text/javascript" src="' . $filePath . '"></script>';
            }
        }
    }

    /**
     * Add a Javascript library from a CDN
     *
     * See http://code.google.com/apis/libraries/devguide.html
     *
     * Currently supported are jquery, jqueryui and webfont
     *
     * @param string $name name as found on the google cdn
     * @param string $version version as found on the google cdn
     * @param boolean $addToHeader add library to header
     * @throws \Exception if a different version of the same library has already been included
     * @return void
     */
    public function addJsLibrary($name, $version, $addToHeader = FALSE)
    {
        $name = strtolower($name);

        // if the library is already in the footer but should be loaded in the
        // header, remove it from the footer and put it into the header

        if ($this->loadedJsLibraries[$name] && $this->jsLibrariesFooter[$name] && $addToHeader) {
            $libDescriptor = $this->jsLibrariesFooter[$name];
            unset($this->jsLibrariesFooter[$name]);
            $this->jsLibrariesHeader[$name] = $libDescriptor;
        }

        if ($this->loadedJsLibraries[$name]) {
            // check whether version matches
            if ($version != $this->loadedJsLibraries[$name]) {
                throw new \Exception(
                    'JS library conflict: ' . $name
                        . ' already loaded with version ' . $this->loadedJsLibraries[$name]
                        . ' and version ' . $version . ' was requested ');
            }
        } else {
            // mark library as loaded
            $this->loadedJsLibraries[$name] = $version;

            // load library
            $url = $this->compileJsLibUri($name, $version);
            $jd = new JsDescriptor($url);

            if ($this->isCached()) {
                if ($addToHeader) {
                    $this->jsLibrariesHeader[$name] = $jd;
                } else {
                    $this->jsLibrariesFooter[$name] = $jd;
                }
            } else {
                $GLOBALS['TSFE']->additionalHeaderData[md5($url)] = '<script type="text/javascript" src="' . $url . '"></script>';
            }
        }
    }

    /**
     * Compiles the uri to the js lib
     * @param string $name
     * @param string $version
     * @return string uri
     * @throws \Exception if the library name is not known
     */
    protected function compileJsLibUri($name, $version)
    {
        if ($this->nameFileMapping[$name]) {
            $file = $this->nameFileMapping[$name];

            $uri = $this->jsLibUriPattern;
            $uri = str_replace('@name', $name, $uri);
            $uri = str_replace('@version', $version, $uri);
            $uri = str_replace('@file', $file, $uri);

            return $uri;
        } else {
            throw new \Exception('Unkown JS library ' . $name);
        }
    }

    public function getJsLibrariesFooter()
    {
        return $this->jsLibrariesFooter;
    }

    public function getJsLibrariesHeader()
    {
        return $this->jsLibrariesHeader;
    }

    public function getCssFiles()
    {
        return $this->cssFiles;
    }

    public function getJsFilesFooter()
    {
        return $this->jsFilesFooter;
    }

    public function getJsFilesHeader()
    {
        return $this->jsFilesHeader;
    }
}

?>
