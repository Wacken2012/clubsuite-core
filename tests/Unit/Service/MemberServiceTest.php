<?php

declare(strict_types=1);

namespace OCA\ClubSuiteCore\Tests\Unit\Service;

use OCA\ClubSuiteCore\Db\MemberMapper;
use OCA\ClubSuiteCore\Service\MemberService;
use OCP\ILogger;
use PHPUnit\Framework\MockObject\MockObject;
use Test\TestCase;

class MemberServiceTest extends TestCase {
    private MemberService $service;
    private MemberMapper|MockObject $mapper;
    private ILogger|MockObject $logger;

    protected function setUp(): void {
        parent::setUp();
        $this->mapper = $this->createMock(MemberMapper::class);
        $this->logger = $this->createMock(ILogger::class);
        $this->service = new MemberService($this->mapper, $this->logger);
    }

    public function testListMembers(): void {
        $this->mapper->expects($this->once())
            ->method('findAll')
            ->willReturn([]);

        $result = $this->service->listMembers();
        $this->assertIsArray($result);
    }
}
