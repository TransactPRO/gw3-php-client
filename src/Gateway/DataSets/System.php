<?php declare(strict_types = 1);

/*
 * This file is part of the transact-pro/gw3-client package.
 *
 * (c) Transact Pro
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TransactPro\Gateway\DataSets;

use TransactPro\Gateway\Interfaces\DataSetInterface;

/**
 * Class System.
 *
 * Class System has all methods to fill `auth-data` block of the request.
 */
class System extends DataSet implements DataSetInterface
{
    /**
     * @param  string $userIP
     * @return System
     */
    public function setUserIP(string $userIP): self
    {
        $this->data[self::SYSTEM_USER_IP] = $userIP;

        return $this;
    }

    /**
     * @param  string $xForwardedFor
     * @return System
     */
    public function setXForwardedFor(string $xForwardedFor): self
    {
        $this->data[self::SYSTEM_X_FORWARDED_FOR] = $xForwardedFor;

        return $this;
    }

    /**
     * @param  string $browserAcceptHeader
     * @return System
     */
    public function setBrowserAcceptHeader(string $browserAcceptHeader): self
    {
        $this->data[self::SYSTEM_BROWSER_ACCEPT_HEADER] = $browserAcceptHeader;

        return $this;
    }

    /**
     * @param  bool $browserJavaEnabled
     *
     * @return System
     */
    public function setBrowserJavaEnabled(bool $browserJavaEnabled): self
    {
        $this->data[self::SYSTEM_BROWSER_JAVA_ENABLED] = $browserJavaEnabled;

        return $this;
    }

    /**
     * @param  bool $browserJavaScriptEnabled
     *
     * @return System
     */
    public function setBrowserJavaScriptEnabled(bool $browserJavaScriptEnabled): self
    {
        $this->data[self::SYSTEM_BROWSER_JAVASCRIPT_ENABLED] = $browserJavaScriptEnabled;

        return $this;
    }

    /**
     * @param  string $browserLanguage
     *
     * @return System
     */
    public function setBrowserLanguage(string $browserLanguage): self
    {
        $this->data[self::SYSTEM_BROWSER_LANGUAGE] = $browserLanguage;

        return $this;
    }

    /**
     * @param  string $browserColorDepth
     *
     * @return System
     */
    public function setBrowserColorDepth(string $browserColorDepth): self
    {
        $this->data[self::SYSTEM_BROWSER_COLOR_DEPTH] = $browserColorDepth;

        return $this;
    }

    /**
     * @param  string $browserScreenHeight
     *
     * @return System
     */
    public function setBrowserScreenHeight(string $browserScreenHeight): self
    {
        $this->data[self::SYSTEM_BROWSER_SCREEN_HEIGHT] = $browserScreenHeight;

        return $this;
    }

    /**
     * @param  string $browserScreenWidth
     *
     * @return System
     */
    public function setBrowserScreenWidth(string $browserScreenWidth): self
    {
        $this->data[self::SYSTEM_BROWSER_SCREEN_WIDTH] = $browserScreenWidth;

        return $this;
    }

    /**
     * @param  string $browserTZ
     *
     * @return System
     */
    public function setBrowserTZ(string $browserTZ): self
    {
        $this->data[self::SYSTEM_BROWSER_TZ] = $browserTZ;

        return $this;
    }

    /**
     * @param  string $userAgent
     *
     * @return System
     */
    public function setUserAgent(string $userAgent): self
    {
        $this->data[self::SYSTEM_BROWSER_USER_AGENT] = $userAgent;

        return $this;
    }
}
