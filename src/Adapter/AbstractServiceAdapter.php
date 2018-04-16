<?php
/**
 * Created by PhpStorm.
 * User: Ricardo Fiorani
 * Date: 29/08/2015
 * Time: 19:37.
 */
namespace RicardoFiorani\Adapter;

use RicardoFiorani\Exception\NotEmbeddableException;
use RicardoFiorani\Renderer\EmbedRendererInterface;

abstract class AbstractServiceAdapter implements VideoAdapterInterface
{
    /**
     * @var string
     */
    public $rawUrl;

    /**
     * @var string
     */
    public $videoId;

    /**
     * @var string
     */
    public $pattern;

    /**
     * @var EmbedRendererInterface
     */
    public $renderer;

    /**
     * AbstractVideoAdapter constructor.
     *
     * @param string $url
     * @param string $pattern
     * @param EmbedRendererInterface $renderer
     */
    public function __construct($url, $pattern, EmbedRendererInterface $renderer)
    {
        $this->rawUrl = $url;
        $this->pattern = $pattern;
        $this->renderer = $renderer;
    }

    /**
     * Returns the input URL.
     *
     * @return string
     */
    public function getRawUrl()
    {
        return $this->rawUrl;
    }

    /**
     * @param string $rawUrl
     */
    public function setRawUrl($rawUrl)
    {
        $this->rawUrl = $rawUrl;
    }

    /**
     * @return string
     */
    public function getVideoId()
    {
        return $this->videoId;
    }

    /**
     * @param string $videoId
     */
    public function setVideoId($videoId)
    {
        $this->videoId = $videoId;
    }

    /**
     * @return string
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * @param string $pattern
     */
    public function setPattern($pattern)
    {
        $this->pattern = $pattern;
    }

    /**
     * @return EmbedRendererInterface
     */
    public function getRenderer()
    {
        return $this->renderer;
    }

    /**
     * @param EmbedRendererInterface $renderer
     */
    public function setRenderer($renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * @param int $width
     * @param int $height
     * @param bool $forceAutoplay
     * @param bool $forceSecure
     *
     * @return string
     * @throws NotEmbeddableException
     */
    public function getEmbedCode($width, $height, $forceAutoplay = false, $forceSecure = false)
    {
        if (false == $this->isEmbeddable()) {
            throw new NotEmbeddableException();
        }

        return $this->getRenderer()->renderVideoEmbedCode($this->getEmbedUrl($forceAutoplay, $forceSecure), $width, $height);
    }

    /**
     * Switches the protocol scheme between http and https
     *
     * @param bool|false $forceSecure
     * @return string
     */
    public function getScheme($forceSecure = false)
    {
        return ($forceSecure ? 'https' : 'http');
    }
}
