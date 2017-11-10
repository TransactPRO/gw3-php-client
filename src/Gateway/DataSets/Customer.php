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
 * Class Customer.
 *
 * Class Customer has all methods to fill `general-data.customer-data` block of the request.
 */
class Customer extends DataSet implements DataSetInterface
{
    /**
     * @param  string   $email
     * @return Customer
     */
    public function setEmail(string $email): self
    {
        $this->data[self::GENERAL_DATA_CUSTOMER_DATA_EMAIL] = $email;

        return $this;
    }

    /**
     * @param string $phone
     *
     * @return Customer
     */
    public function setPhone(string $phone): self
    {
        $this->data[self::GENERAL_DATA_CUSTOMER_DATA_PHONE] = $phone;

        return $this;
    }

    /**
     * @param string $birthDate Format: MMDDYYYY
     *
     * @return Customer
     */
    public function setBirthDate(string $birthDate): self
    {
        $this->data[self::GENERAL_DATA_CUSTOMER_DATA_BIRTH_DATE] = $birthDate;

        return $this;
    }

    /**
     * @param  string   $country
     * @return Customer
     */
    public function setBillingAddressCountry(string $country): self
    {
        $this->data[self::GENERAL_DATA_CUSTOMER_DATA_BILLING_ADDRESS_COUNTRY] = $country;

        return $this;
    }

    /**
     * @param  string   $state
     * @return Customer
     */
    public function setBillingAddressState(string $state): self
    {
        $this->data[self::GENERAL_DATA_CUSTOMER_DATA_BILLING_ADDRESS_STATE] = $state;

        return $this;
    }

    /**
     * @param  string   $city
     * @return Customer
     */
    public function setBillingAddressCity(string $city): self
    {
        $this->data[self::GENERAL_DATA_CUSTOMER_DATA_BILLING_ADDRESS_CITY] = $city;

        return $this;
    }

    /**
     * @param  string   $street
     * @return Customer
     */
    public function setBillingAddressStreet(string $street): self
    {
        $this->data[self::GENERAL_DATA_CUSTOMER_DATA_BILlING_ADDRESS_STREET] = $street;

        return $this;
    }

    /**
     * @param  string   $house
     * @return Customer
     */
    public function setBillingAddressHouse(string $house): self
    {
        $this->data[self::GENERAL_DATA_CUSTOMER_DATA_BILLING_ADDRESS_HOUSE] = $house;

        return $this;
    }

    /**
     * @param  string   $flat
     * @return Customer
     */
    public function setBillingAddressFlat(string $flat): self
    {
        $this->data[self::GENERAL_DATA_CUSTOMER_DATA_BILLING_ADDRESS_FLAT] = $flat;

        return $this;
    }

    /**
     * @param  string   $zip
     * @return Customer
     */
    public function setBillingAddressZIP(string $zip): self
    {
        $this->data[self::GENERAL_DATA_CUSTOMER_DATA_BILLING_ADDRESS_ZIP] = $zip;

        return $this;
    }

    /**
     * @param  string   $country
     * @return Customer
     */
    public function setShippingAddressCountry(string $country): self
    {
        $this->data[self::GENERAL_DATA_CUSTOMER_DATA_SHIPPING_ADDRESS_COUNTRY] = $country;

        return $this;
    }

    /**
     * @param  string   $state
     * @return Customer
     */
    public function setShippingAddressState(string $state): self
    {
        $this->data[self::GENERAL_DATA_CUSTOMER_DATA_SHIPPING_ADDRESS_STATE] = $state;

        return $this;
    }

    /**
     * @param  string   $city
     * @return Customer
     */
    public function setShippingAddressCity(string $city): self
    {
        $this->data[self::GENERAL_DATA_CUSTOMER_DATA_SHIPPING_ADDRESS_CITY] = $city;

        return $this;
    }

    /**
     * @param  string   $street
     * @return Customer
     */
    public function setShippingAddressStreet(string $street): self
    {
        $this->data[self::GENERAL_DATA_CUSTOMER_DATA_SHIPPING_ADDRESS_STREET] = $street;

        return $this;
    }

    /**
     * @param  string   $house
     * @return Customer
     */
    public function setShippingAddressHouse(string $house): self
    {
        $this->data[self::GENERAL_DATA_CUSTOMER_DATA_SHIPPING_ADDRESS_HOUSE] = $house;

        return $this;
    }

    /**
     * @param  string   $flat
     * @return Customer
     */
    public function setShippingAddressFlat(string $flat): self
    {
        $this->data[self::GENERAL_DATA_CUSTOMER_DATA_SHIPPING_ADDRESS_FLAT] = $flat;

        return $this;
    }

    /**
     * @param  string   $zip
     * @return Customer
     */
    public function setShippingAddressZIP(string $zip): self
    {
        $this->data[self::GENERAL_DATA_CUSTOMER_DATA_SHIPPING_ADDRESS_ZIP] = $zip;

        return $this;
    }
}
