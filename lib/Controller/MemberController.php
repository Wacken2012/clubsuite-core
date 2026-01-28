<?php

declare(strict_types=1);

namespace OCA\ClubSuiteCore\Controller;

use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\JSONResponse;
use OCP\AppFramework\Http\Attribute\NoAdminRequired;
use OCP\IRequest;
use OCP\IUserSession;
use OCP\IGroupManager;
use OCA\ClubSuiteCore\Service\MemberService;

/**
 * Controller exposing member meta endpoints.
 * © 2026 Stefan Schulz – Alle Rechte vorbehalten.
 */
class MemberController extends Controller {
    private MemberService $service;
    private IUserSession $userSession;
    private IGroupManager $groupManager;

    public function __construct(
        string $appName,
        IRequest $request,
        MemberService $service,
        IUserSession $userSession,
        IGroupManager $groupManager
    ) {
        parent::__construct($appName, $request);
        $this->service = $service;
        $this->userSession = $userSession;
        $this->groupManager = $groupManager;
    }

    /**
     * Check if the current user has permission to access the target user's data
     */
    private function checkPermissions(string $targetUserId): bool {
        $user = $this->userSession->getUser();
        if ($user === null) {
            return false;
        }
        $currentUserId = $user->getUID();

        // Self-access is allowed
        if ($currentUserId === $targetUserId) {
            return true;
        }

        // Admin is allowed
        if ($this->groupManager->isAdmin($currentUserId)) {
            return true;
        }

        // Check for 'board' group (example)
        if ($this->groupManager->isInGroup($currentUserId, 'board') || $this->groupManager->isInGroup($currentUserId, 'admin')) {
             return true;
        }

        return false;
    }

    /**
     * Get member metadata by user ID
     */
    #[NoAdminRequired]
    public function get(string $userId): JSONResponse {
        if (!$this->checkPermissions($userId)) {
             return new JSONResponse(['message' => 'Forbidden'], 403);
        }

        $entity = $this->service->getMemberMeta($userId);
        if ($entity === null) {
            return new JSONResponse(['message' => 'Not found'], 404);
        }

        return new JSONResponse($entity);
    }

    /**
     * Get detailed member information
     * © 2026 Stefan Schulz – Alle Rechte vorbehalten.
     */
    #[NoAdminRequired]
    public function detail(string $id): JSONResponse {
        // In this app, the ID is the userId
        if (!$this->checkPermissions($id)) {
            return new JSONResponse(['message' => 'Forbidden'], 403);
        }

        $entity = $this->service->getMemberMeta($id);
        
        if ($entity === null) {
            return new JSONResponse(['message' => 'Not found'], 404);
        }

        return new JSONResponse($entity);
    }

    /**
     * Get nextcloud user ID for Talk integration
     */
    #[NoAdminRequired]
    public function getTalkUser(string $id): JSONResponse {
        $entity = $this->service->getMemberMeta($id);
        if ($entity === null) {
            return new JSONResponse(['message' => 'Not found'], 404);
        }

        $nextcloudUserId = $entity->getNextcloudUserId();
        if (!$nextcloudUserId) {
            return new JSONResponse(['message' => 'Talk user not configured'], 404);
        }

        return new JSONResponse([
            'member_id' => $id,
            'nextcloud_user_id' => $nextcloudUserId
        ]);
    }

    /**
     * Update member metadata
     */
    #[NoAdminRequired]
    public function update(string $userId): JSONResponse {
        $params = $this->request->getParams();
        $allowed = [
            'mitgliedsnummer', 'eintrittsdatum', 'status',
            'firstname', 'lastname', 'email', 'phone', 'street', 'zip', 'city',
            'nextcloud_user_id'
        ];
        $data = array_intersect_key($params, array_flip($allowed));
        
        $entity = $this->service->updateMemberMeta($userId, $data);
        
        return new JSONResponse($entity);
    }

    /**
     * Search members by query string
     */
    #[NoAdminRequired]
    public function search(): JSONResponse {
        $query = $this->request->getParam('q', '');
        $results = $this->service->searchMembers((string)$query);
        
        // Simple DTOs for search results/dropdowns
        $out = array_map(function ($e) {
            return [
                'user_id' => $e->getUserId(),
                'mitgliedsnummer' => $e->getMitgliedsnummer(),
                'status' => $e->getStatus(),
                'firstname' => $e->getFirstname(),
                'lastname' => $e->getLastname(),
            ];
        }, $results);
        
        return new JSONResponse($out);
    }

    /**
     * List all members with pagination
     */
    #[NoAdminRequired]
    public function index(): JSONResponse {
        $limit = (int)$this->request->getParam('limit', 50);
        $offset = (int)$this->request->getParam('offset', 0);
        $sort = (string)$this->request->getParam('sort', 'user_id');
        $order = (string)$this->request->getParam('order', 'ASC');

        $res = $this->service->listMembers($limit, $offset, $sort, $order);
        
        return new JSONResponse([
            'total' => $res['total'],
            'limit' => $limit,
            'offset' => $offset,
            'rows' => $res['rows']
        ]);
    }
}
