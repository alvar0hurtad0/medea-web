<?php

namespace Drupal\Tests\medea\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Tests Minimal installation profile expectations.
 *
 * @group minimal
 */
class MedeaTest extends BrowserTestBase {

  protected $profile = 'medea';

  /**
   * Tests Medea installation profile.
   */
  public function testMedea() {
    $this->drupalGet('');
    // Check the login block is present.
    $this->assertLink(t('Create new account'));
    $this->assertResponse(200);

    // Create a user to test tools and navigation blocks for logged in users
    // with appropriate permissions.
    $user = $this->drupalCreateUser(['access administration pages', 'administer content types']);
    $this->drupalLogin($user);
    $this->drupalGet('');
    $this->assertSession()->responseContains(t('Tools'));
    $this->assertSession()->responseContains(t('Administration'));

    // Ensure that there are no pending updates after installation.
    $this->drupalLogin($this->rootUser);
    $this->drupalGet('update.php/selection');
    $this->assertSession()->responseContains('No pending updates.');

    // Ensure that there are no pending entity updates after installation.
    $this->assertFalse($this->container->get('entity.definition_update_manager')->needsUpdates(), 'After installation, entity schema is up to date.');
  }

}
