<?php

namespace App\Tests\Issue;

use App\Models\Issue;
use App\Tests\TestCase;

class IssueTest extends TestCase
{
    public function test_issue_index_regular_user()
    {
        $user = $this->createUser();

        $this->actingAs($user);

        $this->visit(route('issues.index'))->see('Tickets');
    }

    public function test_issue_index_regular_user_sees_only_their_own_tickets()
    {
        $issue = factory(Issue::class)->create();

        $user = $this->createUser();

        $this->actingAs($user);

        $this->visit(route('issues.index'))
            ->see('There are no records to display.');

        $this->seeInDatabase('issues', ['user_id' => $issue->user_id]);
    }

    public function test_admins_can_see_all_tickets()
    {
        $user = $this->createAdmin();

        $this->actingAs($user);

        $issue = factory(Issue::class)->create();

        $this->visit(route('issues.index'))
            ->see($issue->title);
    }

    public function test_regular_users_cannot_see_labels_and_users_field()
    {
        $user = $this->createUser();

        $this->actingAs($user);

        $this->visit(route('issues.create'))
            ->dontSee('Labels')
            ->dontSee('Users');

        $issue = factory(Issue::class)->create(['user_id' => $user->getKey()]);

        $this->visit(route('issues.show', [$issue->getKey()]))
            ->dontSee('Labels')
            ->dontSee('Users');
    }

    public function test_admins_can_see_labels_and_users_field()
    {
        $user = $this->createAdmin();

        $this->actingAs($user);

        $this->visit(route('issues.create'))
            ->see('Labels')
            ->see('Users');

        $issue = factory(Issue::class)->create(['user_id' => $user->getKey()]);

        $this->visit(route('issues.show', [$issue->getKey()]))
            ->see('Labels')
            ->see('Users');
    }

    public function test_index_only_shows_open_issues()
    {
        $user = $this->createUser();

        $this->actingAs($user);

        $issue = factory(Issue::class)->create([
            'user_id' => $user->getKey(),
            'closed'  => true,
        ]);

        $this->visit(route('issues.index'))
            ->see('There are no records to display.');

        $this->visit(route('issues.closed'))
            ->see($issue->title);
    }
}
