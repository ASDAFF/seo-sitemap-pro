<?php
namespace Maximaster\SeoSitemapPro;

use Bitrix\Main\Entity;
use Bitrix\Main\Text\Converter;
use Bitrix\Main\IO\File;
use \Bitrix\Seo\SitemapRuntime;

/**
 * Extended generates index file from sitemap files list
 * Class SitemapIndexEx
 */
class SitemapRuntimeEx extends SitemapRuntime
{

	const ENTRY_TPL = '<url><loc>%s</loc><lastmod>%s</lastmod><priority>%s</priority></url>';
    const DEFAULT_PRIORITY = 0.5;

    public function addEntry($entry)
    {
        if($this->isSplitNeeded())
        {
            $this->split();
            $this->addEntry($entry);
        }
        else
        {
            if(!$this->partChanged)
            {
                $this->addHeader();
            }

            $this->putContents(
                sprintf(
                    self::ENTRY_TPL,
                    Converter::getXmlConverter()->encode($entry['XML_LOC']),
                    Converter::getXmlConverter()->encode($entry['XML_LASTMOD']),
                    Converter::getXmlConverter()->encode($entry['XML_PRIORITY'])
                ), self::APPEND
            );
        }
    }

    public function appendEntry($entry)
    {
        if($this->isSplitNeeded())
        {
            $this->split();
            $this->appendEntry($entry);
        }
        else
        {
            if(!$this->partChanged)
            {
                $this->addHeader();
            }

            $fd = $this->open('r+');

            fseek($fd, $this->getSize()-strlen(self::FILE_FOOTER));
            fwrite($fd, sprintf(
                    self::ENTRY_TPL,
                    Converter::getXmlConverter()->encode($entry['XML_LOC']),
                    Converter::getXmlConverter()->encode($entry['XML_LASTMOD']),
                    Converter::getXmlConverter()->encode($entry['XML_PRIORITY'])
                ).self::FILE_FOOTER);
            fclose($fd);
        }
    }

    public function addFileEntry(File $f, $priority = 0)
    {
        if($f->isExists() && !$f->isSystem())
        {
            $this->addEntry(array(
                'XML_LOC' => $this->settings['PROTOCOL'].'://'.\CBXPunycode::toASCII($this->settings['DOMAIN'], $e = null).$this->getFileUrl($f),
                'XML_LASTMOD' => date('c', $f->getModificationTime()),
                'XML_PRIORITY' => $priority ? $priority : self::DEFAULT_PRIORITY
            ));
        }
    }

    public function addIBlockEntry($url, $modifiedDate, $priority = 0)
    {
        $this->addEntry(array(
            'XML_LOC' => $this->settings['PROTOCOL'].'://'.\CBXPunycode::toASCII($this->settings['DOMAIN'], $e = null).$url,
            'XML_LASTMOD' => date('c', $modifiedDate - \CTimeZone::getOffset()),
            'XML_PRIORITY' => $priority ? $priority : self::DEFAULT_PRIORITY
        ));
    }

    public function appendIBlockEntry($url, $modifiedDate, $priority = 0)
    {
        if($this->isExists())
        {
            $this->appendEntry(array(
                'XML_LOC' => $this->settings['PROTOCOL'].'://'.\CBXPunycode::toASCII($this->settings['DOMAIN'], $e = null).$url,
                'XML_LASTMOD' => date('c', $modifiedDate - \CTimeZone::getOffset()),
                'XML_PRIORITY' => $priority ? $priority : self::DEFAULT_PRIORITY
            ));
        }
        else
        {
            $this->addHeader();
            $this->addIBlockEntry($url, $modifiedDate, $priority);
            $this->addFooter();
        }
    }

}