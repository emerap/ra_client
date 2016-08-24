<?php

namespace Emerap\RaClient;

/**
 * Class RaClient.
 *
 * @package Emerap\RaClient
 */
class RaClient {

  protected $tag;
  protected $platform;
  protected $path;
  protected $format;
  protected $lang;
  protected $request;

  /**
   * RaClient constructor.
   *
   * @param string $tag
   *   Client tag.
   */
  public function __construct($tag) {
    if ($source = self::getSource($tag)) {
      $this->setTag($tag)
        ->setPath($source['path'])
        ->setPlatform($source['platform'])
        ->setFormat('json')
        ->setLang('en');
    }
  }

  /**
   * Build and execute query.
   *
   * @param string $method
   *   Method name.
   * @param array $params
   *   Method parameters.
   *
   * @return $this
   */
  public function query($method, $params = []) {
    $this->setRequest();
    $req = FALSE;

    if ($curl = curl_init()) {
      curl_setopt($curl, CURLOPT_URL, $this->getPath() . '/' . $method);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($curl, CURLOPT_POST, TRUE);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
      $req = curl_exec($curl);
      curl_close($curl);
    }
    $this->setRequest($req);
    return $this;
  }

  /**
   * Register client.
   *
   * @param int $pin
   *   Client pin.
   *
   * @return $this
   */
  public function register($pin) {
    $params = [
      'tag' => $this->getTag(),
      'platform' => $this->getPlatform(),
      'pin' => $pin,
    ];
    return $this->query('ra.pair', $params);
  }

  /**
   * Get source.
   *
   * @param string $tag
   *   Client tag.
   *
   * @return bool
   *   Source or false.
   */
  public static function getSource($tag) {
    $sources = self::getSources();
    return (isset($sources[$tag])) ? $sources[$tag] : FALSE;
  }

  /**
   * Get raw request.
   *
   * @return string
   *   Raw request.
   */
  public function getRaw() {
    return (string) $this->request;
  }

  /**
   * GETTERS & SETTERS.
   */

  /**
   * Get tag.
   *
   * @return string
   *   Client tag.
   */
  private function getTag() {
    return $this->tag;
  }

  /**
   * Set tag.
   *
   * @param string $tag
   *   Client tag.
   *
   * @return $this
   */
  private function setTag($tag) {
    $this->tag = $tag;
    return $this;
  }

  /**
   * Get platform.
   *
   * @return string
   *   Client platform.
   */
  private function getPlatform() {
    return $this->platform;
  }

  /**
   * Set platform.
   *
   * @param string $platform
   *   Client platform.
   *
   * @return $this
   */
  private function setPlatform($platform) {
    $this->platform = $platform;
    return $this;
  }

  /**
   * Get path.
   *
   * @return string
   *   Path.
   */
  private function getPath() {
    return $this->path;
  }

  /**
   * Set path.
   *
   * @param string $path
   *   Path.
   *
   * @return $this
   */
  private function setPath($path) {
    $this->path = $path;
    return $this;
  }

  /**
   * Get format.
   *
   * @return string
   *   Format.
   */
  private function getFormat() {
    return $this->format;
  }

  /**
   * Set format.
   *
   * @param string $format
   *   Format.
   *
   * @return $this
   */
  public function setFormat($format) {
    $this->format = $format;
    return $this;
  }

  /**
   * Get language.
   *
   * @return string
   *   Language code.
   */
  private function getLang() {
    return $this->lang;
  }

  /**
   * Set language.
   *
   * @param string $lang
   *   Language code.
   *
   * @return $this
   */
  public function setLang($lang) {
    $this->lang = $lang;
    return $this;
  }

  /**
   * Get request.
   *
   * @return array
   *   Request.
   */
  public function getRequest() {
    $req = $this->getRaw();
    // TODO module deserialize.
    switch ($this->getFormat()) {
      case 'json':
        return json_decode($req, TRUE);
    }
  }

  /**
   * Set request.
   *
   * @param string $request
   *   Request data.
   *
   * @return $this
   */
  private function setRequest($request = NULL) {
    $this->request = $request;
    return $this;
  }

}
