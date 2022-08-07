<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class SetAdmin extends Component
{
	use AuthorizesRequests;

	public User $user;
	    
    /**
     * Render the component
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render(): View
    {
        return view('livewire.set-admin', [
			'user' => $this->user
		]);
    }
	
	/**
	 * Set or unset admin
	 *
	 * @param  int $admin
	 * @return void
	 */
	public function setAdmin(int $admin): void
	{
		$this->authorize('delete', $this->user);

		// Only edit the role for other users
		if ($this->user->id != auth()->id())
			$this->user->update(['is_admin' => $admin]);
	}
}
