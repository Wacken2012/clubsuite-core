<?php

declare(strict_types=1);

namespace OCA\ClubSuiteCore\Privacy;

use OCA\ClubSuiteCore\Db\MemberMapper;
use OCP\Privacy\IPersonalDataProvider;
use OCP\IL10N;

class Register implements IPersonalDataProvider {

    public function __construct(
        private IL10N $l,
        private MemberMapper $mapper
    ) {}

    public function getName(): string {
        return $this->l->t('ClubSuite Core');
    }

    public function userDeleted(string $uid): void {
        try {
            $member = $this->mapper->findByUserId($uid);
            if ($member) {
                $this->mapper->delete($member);
            }
        } catch (\Exception $e) {
            // Log error or ignore if user data notably not found
        }
    }

    public function userExport(string $uid): array {
        try {
            $member = $this->mapper->findByUserId($uid);
            if (!$member) {
                return ['data' => []];
            }
            return [
                'data' => [
                    [
                        'key' => 'firstname',
                        'title' => $this->l->t('First name'),
                        'value' => $member->getFirstname()
                    ],
                    [
                        'key' => 'lastname',
                        'title' => $this->l->t('Last name'),
                        'value' => $member->getLastname()
                    ],
                    [
                        'key' => 'email',
                        'title' => $this->l->t('Email'),
                        'value' => $member->getEmail()
                    ],
                    [
                        'key' => 'address',
                        'title' => $this->l->t('Address'),
                        'value' => $member->getAddress()
                    ]
                ]
            ];
        } catch (\Exception $e) {
            return ['data' => []];
        }
    }
}
