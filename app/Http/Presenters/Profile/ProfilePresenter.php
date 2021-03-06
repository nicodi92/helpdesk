<?php

namespace App\Http\Presenters\Profile;

use App\Http\Presenters\Presenter;
use App\Models\User;
use Orchestra\Contracts\Html\Form\Fieldset;
use Orchestra\Contracts\Html\Form\Grid as FormGrid;

class ProfilePresenter extends Presenter
{
    /**
     * Returns a new form for editing the current users profile.
     *
     * @param User $user
     * @param bool $viewing
     *
     * @return \Orchestra\Contracts\Html\Builder
     */
    public function form(User $user, $viewing = false)
    {
        return $this->form->of('profile', function (FormGrid $form) use ($user, $viewing) {
            $form->attributes([
                'method'    => 'POST',
                'url'       => ($viewing ? null : route('profile.update')),
            ]);

            $form->with($user);

            $form->submit = 'Save';

            $form->fieldset(function (Fieldset $fieldset) use ($viewing) {
                $fieldset->control('input:text', 'full_name')
                    ->label('Full Name')
                    ->value(function (User $user) {
                        return $user->name;
                    })
                    ->attributes([
                        'placeholder' => 'Your Full Name',
                        ($viewing ? 'disabled' : null),
                    ]);

                $fieldset->control('input:text', 'email')
                    ->label('Email')
                    ->attributes([
                        'placeholder' => 'Your Email Address',
                        ($viewing ? 'disabled' : null),
                    ]);
            });
        });
    }
}
