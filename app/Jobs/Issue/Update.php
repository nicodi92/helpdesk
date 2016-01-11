<?php

namespace App\Jobs\Issue;

use App\Http\Requests\IssueRequest;
use App\Jobs\Job;
use App\Models\Issue;

class Update extends Job
{
    /**
     * @var IssueRequest
     */
    protected $request;

    /**
     * @var Issue
     */
    protected $issue;

    /**
     * Constructor.
     *
     * @param IssueRequest $request
     * @param Issue        $issue
     */
    public function __construct(IssueRequest $request, Issue $issue)
    {
        $this->request = $request;
        $this->issue = $issue;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle()
    {
        $this->issue->title = $this->request->input('title', $this->issue->title);
        $this->issue->description = $this->request->input('description', $this->issue->description);
        $this->issue->occurred_at = $this->request->input('occurred_at', $this->issue->occurred_at);

        if ($this->issue->save()) {
            // Sync the issues labels.
            $labels = $this->request->input('labels', []);

            if (is_array($labels)) {
                $this->issue->labels()->sync($labels);
            }

            // Sync the issues users.
            $users = $this->request->input('users', []);

            if (is_array($users)) {
                $this->issue->users()->sync($users);
            }

            return true;
        }

        return false;
    }
}