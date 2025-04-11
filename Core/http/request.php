<?php

namespace core\http;

class Request{

  private $method;
  private $url;
  private $headers;
  private $body;
  private $params;
  private $postFields;

  function __construct($method, $url, $headers, $body, $params, $postFields){
    $this->method = $method;
    $this->url = $url;
    $this->headers = $headers;
    $this->body = $body;
    $this->params = $params;
    $this->postFields = $postFields;
  }

  // NO setters

  // Getters
  public function getMethod(){
    return $this->method;
  }
  public function getURL(){
    return $this->url;
  }
  public function getHeaders(){
    return $this->headers;
  }
  public function getBody(){
    return $this->body;
  }
  public function getParams(){
    return $this->params;
  }
  public function getpostFields(){
    return $this->postFields;
  }
}