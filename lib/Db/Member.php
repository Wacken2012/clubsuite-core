<?php

declare(strict_types=1);

namespace OCA\ClubSuiteCore\Db;

use DateTime;
use JsonSerializable;
use OCP\AppFramework\Db\Entity;

/**
 * Member Entity - must match database table oc_clubsuite_core_members
 * 
 * Database columns:
 * - id, user_id, mitgliedsnummer, eintrittsdatum, status, created_at, updated_at
 * - firstname, lastname, email, phone, address, zip, city, street
 * - nextcloud_user_id, iban, joined_at
 */
class Member extends Entity implements JsonSerializable {

    // All properties must match database columns (camelCase version of snake_case)
    protected ?string $userId = null;
    protected ?string $mitgliedsnummer = null;
    protected ?DateTime $eintrittsdatum = null;
    protected ?string $status = 'active';
    protected ?DateTime $createdAt = null;
    protected ?DateTime $updatedAt = null;
    protected ?string $firstname = null;
    protected ?string $lastname = null;
    protected ?string $email = null;
    protected ?string $phone = null;
    protected ?string $address = null;
    protected ?string $zip = null;
    protected ?string $city = null;
    protected ?string $street = null;
    protected ?string $nextcloudUserId = null;
    protected ?string $iban = null;
    protected ?DateTime $joinedAt = null;

    public function __construct() {
        $this->addType('userId', 'string');
        $this->addType('mitgliedsnummer', 'string');
        $this->addType('eintrittsdatum', 'datetime');
        $this->addType('status', 'string');
        $this->addType('createdAt', 'datetime');
        $this->addType('updatedAt', 'datetime');
        $this->addType('firstname', 'string');
        $this->addType('lastname', 'string');
        $this->addType('email', 'string');
        $this->addType('phone', 'string');
        $this->addType('address', 'string');
        $this->addType('zip', 'string');
        $this->addType('city', 'string');
        $this->addType('street', 'string');
        $this->addType('nextcloudUserId', 'string');
        $this->addType('iban', 'string');
        $this->addType('joinedAt', 'datetime');
    }

    // Getters and Setters for all properties
    
    public function getUserId(): ?string {
        return $this->userId;
    }

    public function setUserId(?string $userId): void {
        $this->userId = $userId;
        $this->markFieldUpdated('userId');
    }

    public function getMitgliedsnummer(): ?string {
        return $this->mitgliedsnummer;
    }

    public function setMitgliedsnummer(?string $mitgliedsnummer): void {
        $this->mitgliedsnummer = $mitgliedsnummer;
        $this->markFieldUpdated('mitgliedsnummer');
    }

    public function getEintrittsdatum(): ?DateTime {
        return $this->eintrittsdatum;
    }

    public function setEintrittsdatum(?DateTime $eintrittsdatum): void {
        $this->eintrittsdatum = $eintrittsdatum;
        $this->markFieldUpdated('eintrittsdatum');
    }

    public function getStatus(): ?string {
        return $this->status;
    }

    public function setStatus(?string $status): void {
        $this->status = $status;
        $this->markFieldUpdated('status');
    }

    public function getCreatedAt(): ?DateTime {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTime $createdAt): void {
        $this->createdAt = $createdAt;
        $this->markFieldUpdated('createdAt');
    }

    public function getUpdatedAt(): ?DateTime {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTime $updatedAt): void {
        $this->updatedAt = $updatedAt;
        $this->markFieldUpdated('updatedAt');
    }

    public function getFirstname(): ?string {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): void {
        $this->firstname = $firstname;
        $this->markFieldUpdated('firstname');
    }

    public function getLastname(): ?string {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): void {
        $this->lastname = $lastname;
        $this->markFieldUpdated('lastname');
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function setEmail(?string $email): void {
        $this->email = $email;
        $this->markFieldUpdated('email');
    }

    public function getPhone(): ?string {
        return $this->phone;
    }

    public function setPhone(?string $phone): void {
        $this->phone = $phone;
        $this->markFieldUpdated('phone');
    }

    public function getAddress(): ?string {
        return $this->address;
    }

    public function setAddress(?string $address): void {
        $this->address = $address;
        $this->markFieldUpdated('address');
    }

    public function getZip(): ?string {
        return $this->zip;
    }

    public function setZip(?string $zip): void {
        $this->zip = $zip;
        $this->markFieldUpdated('zip');
    }

    public function getCity(): ?string {
        return $this->city;
    }

    public function setCity(?string $city): void {
        $this->city = $city;
        $this->markFieldUpdated('city');
    }

    public function getStreet(): ?string {
        return $this->street;
    }

    public function setStreet(?string $street): void {
        $this->street = $street;
        $this->markFieldUpdated('street');
    }

    public function getNextcloudUserId(): ?string {
        return $this->nextcloudUserId;
    }

    public function setNextcloudUserId(?string $nextcloudUserId): void {
        $this->nextcloudUserId = $nextcloudUserId;
        $this->markFieldUpdated('nextcloudUserId');
    }

    public function getIban(): ?string {
        return $this->iban;
    }

    public function setIban(?string $iban): void {
        $this->iban = $iban;
        $this->markFieldUpdated('iban');
    }

    public function getJoinedAt(): ?DateTime {
        return $this->joinedAt;
    }

    public function setJoinedAt(?DateTime $joinedAt): void {
        $this->joinedAt = $joinedAt;
        $this->markFieldUpdated('joinedAt');
    }

    public function jsonSerialize(): array {
        return [
            'id' => $this->id,
            'userId' => $this->userId,
            'mitgliedsnummer' => $this->mitgliedsnummer,
            'eintrittsdatum' => $this->eintrittsdatum?->format('Y-m-d'),
            'status' => $this->status,
            'createdAt' => $this->createdAt?->format(DateTime::ATOM),
            'updatedAt' => $this->updatedAt?->format(DateTime::ATOM),
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'zip' => $this->zip,
            'city' => $this->city,
            'street' => $this->street,
            'nextcloudUserId' => $this->nextcloudUserId,
            'iban' => $this->iban,
            'joinedAt' => $this->joinedAt?->format(DateTime::ATOM),
        ];
    }
}
