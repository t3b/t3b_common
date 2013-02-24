<?php

namespace T3b\T3bCommon\Utility;

/**
 * @author Anno v. Heimburg <avonheimburg@agenturwerft.de>, Agenturwerft GmbH
 */
class File
{

    /**
     * Resolves EXT:-paths, returning the path relative to PATH_site
     *
     *
     * @param $file string path to resolve
     * @return string
     * @throw \Exception if the file does not exist
     */
    public static function siteRelFilePath($file)
    {
        $absFilePath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($file);
        if ($absFilePath !== FALSE && file_exists($absFilePath)) {
            $relFilePath = str_replace(PATH_site, '', $absFilePath);
            return $relFilePath;
        } else {
            throw new \Exception("File \"$file\" not found or not in a legal path");
        }
    }
}
