<?php

namespace VATPRC\OAuthVATSIM\Providers;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Tool\ArrayAccessorTrait;

class VATSIMResourceOwner implements ResourceOwnerInterface
{
  use ArrayAccessorTrait;

  /**
   * @var array
   */
  protected $response;

  /**
   * @param array $response
   */
  public function __construct(array $response = [])
  {
    $this->response = $response;
  }

  /**
   * Returns the identifier of the authorized resource owner.
   *
   * @return mixed
   */
  public function getId()
  {
    return $this->getValueByKey($this->response, 'data.cid');
  }

  /**
   * Returns email address of the resource owner
   *
   * @return string|null
   */
  public function getEmail()
  {
    return $this->getValueByKey($this->response, 'data.personal.email');
  }

  /**
   * Returns full name of the resource owner
   *
   * @return string|null
   */
  public function getName()
  {
    return $this->getValueByKey($this->response, 'data.personal.name_full');
  }

  /**
   * Return all of the owner details available as an array.
   *
   * @return array
   */
  public function toArray()
  {
    return $this->response;
  }
}
