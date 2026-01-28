<?php
/**
 * Minimal template to display additional member meta in the user profile.
 * This file is intended to be included by the profile view of Nextcloud.
 * It expects a $member variable of type \OCA\ClubSuiteCore\Db\Member or null.
 */

/** @var \OCA\ClubSuiteCore\Db\Member|null $member */
?>
<div class="section" id="core-member-meta">
  <h3>Vereins-Informationen</h3>
  <ul>
    <li><strong>Mitgliedsnummer:</strong> <?= isset($member) && $member->getMitgliedsnummer() ? htmlspecialchars($member->getMitgliedsnummer()) : '-' ?></li>
    <li><strong>Eintrittsdatum:</strong> <?= isset($member) && $member->getEintrittsdatum() ? $member->getEintrittsdatum()->format('Y-m-d') : '-' ?></li>
    <li><strong>Status:</strong> <?= isset($member) && $member->getStatus() ? htmlspecialchars($member->getStatus()) : '-' ?></li>
  </ul>
</div>
