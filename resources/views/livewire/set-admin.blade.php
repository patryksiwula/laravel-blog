<div class="text-gray-900 whitespace-no-wrap">
	<label class="flex items-center space-x-3 mb-3">
		<input wire:change="setAdmin(!{{ $user->is_admin }})" @checked($user->is_admin) @disabled($user->id == Auth::user()->id) type="checkbox"
			name="checked-demo" class="form-tick appearance-none bg-white bg-check h-6 w-6 border border-gray-300 rounded-md checked:bg-gray-500
			checked:border-transparent focus:outline-none"/>
	</label>
</div>