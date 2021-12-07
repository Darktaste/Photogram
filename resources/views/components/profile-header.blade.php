@php
if (!isset($user)) {
    $user = auth()->user();
}
@endphp
<div class="row">
    <div class="col-md-1">
        <img src="{{ $user->details->profile_photo }}" class="rounded main-profile-photo" width="75" />
    </div>
    <div class="col-md-9">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $user->details->display_name }}
        </h2>
        <div class="row">
            <p>
        @if ($user->details->bio)
                {{ $user->details->bio }}<br />
        @endif
        @if($user->details->phone)
                {{ $user->details->phone }}<br />
        @endif
            </p>
        </div>
    </div>
    @if(auth()->id() !== $user->id)
        <div class="col-md-1 text-end">
            <a href="#" class="btn btn-primary">
                @if($user->followers->contains(auth()->user()))
                    {{ __('Unfollow') }}
                @else
                    {{ __('Follow') }}
                @endif
            </a>
        </div>
    @endif
</div>
