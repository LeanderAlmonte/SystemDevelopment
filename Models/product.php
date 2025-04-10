<?php

namespace models;

class Product {

  //Properties
  private $productID;
  private $productType;
  private $productName;
  private $language;
  private $listedPrice;
  private $paidPrice;
  private $quantity;

  //Constructor
  public function _construct($productID, $productType, $productName, $language, $listedPrice, $paidPrice, $quantity) {
    $this->productID = $productID;
    $this->productType = $productType;
    $this->productName = $productName;
    $this->language = $language;
    $this->listedPrice = $listedPrice;
    $this->paidPrice = $paidPrice;
    $this->quantity = $quantity;
  }

  //Getters and Setters
  public function getProductID() {
    return $this->productID;
  }

  public function setProductID($productID) {
    $this->productID = $productID;
  }

  public function getProductType() {
    return $this->productType;
  }

  public function setProductType($productType) {
    $this->productType = $productType;
  }

  public function getProductName() {
    return $this->productName;
  }

  public function setProductName($productName) {
    $this->productName = $productName;
  }

  public function getLanguage() {
    return $this->language;
  }

  public function setLanguage($language) {
    $this->language = $language;
  }

  public function getListedPrice() {
    return $this->listedPrice;
  }

  public function setListedPrice($listedPrice) {
    $this->listedPrice = $listedPrice;
  }

  public function getPaidPrice() {
    return $this->paidPrice;
  }

  public function setPaidPrice($paidPrice) {
    $this->paidPrice = $paidPrice;
  }

  public function getQuantity() {
    return $this->quantity;
  }

  public function setQuantity($quantity) {
    $this->quantity = $quantity;
  }




}


?>