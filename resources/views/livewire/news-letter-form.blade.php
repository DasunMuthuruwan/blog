<div>
    <form class="subscription" wire:submit="subscribe()" method="post">
        <x-form-alerts />
        <div class="position-relative">
            <i class="fa fa-envelope email-icon"></i>
            <input type="text" wire:model.live="news_letter_email" class="form-control" placeholder="Your Email Address">
            @error('news_letter_email')
            <span class="text-danger small ml-1">{{ $message }}</span>
            @enderror
        </div>
        <button class="btn btn-primary btn-block rounded" type="submit">Subscribe now</button>
    </form>
</div>
