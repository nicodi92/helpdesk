<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateRequest;
use App\Processors\Profile\ProfileProcessor;

class ProfileController extends Controller
{
    /**
     * @var ProfileProcessor
     */
    protected $processor;

    /**
     * Constructor.
     *
     * @param ProfileProcessor $processor
     */
    public function __construct(ProfileProcessor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Displays the current users profile.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        return $this->processor->show();
    }

    /**
     * Displays the form for editing the current users.
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return $this->processor->edit();
    }

    /**
     * Updates the current users profile.
     *
     * @param UpdateRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request)
    {
        if ($this->processor->update($request)) {
            flash()->success('Success!', 'Your profile has been updated.');

            return redirect()->route('profile.show');
        } else {
            flash()->error('Error!', 'There was an issue updating your profile. Please try again.');

            return redirect()->route('profile.edit');
        }
    }
}
