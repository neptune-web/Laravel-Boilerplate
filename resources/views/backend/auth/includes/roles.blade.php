<x-forms.group for="roles" :label="__('Roles')">
    @forelse($roles as $role)
        <span class="d-block mb-2">
            <x-forms.form-check
                :label="$role->name"
                name="roles[]"
                value="{{ $role->id }}"
                id="role_{{ $role->id }}"
                :checked="(old('rules') && in_array($role->id, old('rules'), true)) || (isset($user) && in_array($role->id, $user->roles->modelKeys(), true))"
            />
        </span>

        @if ($role->isAdmin())
            <blockquote class="ml-3">
                <i class="fa fa-check-circle"></i> @lang('All Permissions')
            </blockquote>
        @else
            @if ($role->permissions->count())
                <blockquote class="ml-3">
                    @foreach ($role->permissions as $permission)
                        <i class="fa fa-check-circle"></i> {{ $permission->description }}<br/>
                    @endforeach
                </blockquote>
            @else
                <blockquote class="ml-3">
                    <i class="fa fa-minus-circle"></i> @lang('No Permissions')
                </blockquote>
            @endif
        @endif
    @empty
        <p>@lang('There are no roles to choose from.')</p>
    @endforelse
</x-forms.group>
