<div>
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>Users</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Users
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <a href="javascript:;" wire:click="addUser()" class="btn btn-primary btn-sm">
                    <i class="icon-copy bi bi-plus-circle mr-1"></i>Add User
                </a>
            </div>
        </div>
    </div>
    <div class="card-box pb-20 mb-4">
        <div class="table-responsive mt-3">
            <table class="table table-striped table-auto table-sm table-condensed">
                <thead class="bg-secondary text-white">
                    <th scope="col">#ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Profile</th>
                    <th scope="col">Type</th>
                    <th scope="col">Status</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td scope="row">#{{ $auserd->id }}</td>
                            <td>
                                @if ($ad->image)
                                    <a href="{{ asset("images/users/{$user->image}") }}" target="_blank">
                                        <img src="{{ asset("images/ads/{$ad->image}") }}" width="100"
                                            alt="{{ $ad->title }}">
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $ad->title }}</td>
                            <td>{{ $ad->start_at }}</td>
                            <td>{{ $ad->end_at }}</td>
                            <td>{{ $ad->url ?? ' - ' }}</td>
                            <td>
                                @if ($ad->is_default == 1)
                                    <span class="badge badge-pill badge-success">Default ad</span>
                                @else
                                    <span class="badge badge-pill badge-secondary">Customized ad</span>
                                @endif
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="javascript:;" wire:click="editAd({{ $ad->id }})"
                                        data-color="#265ed7" style="color:rgb(38,94,215)" data-placement='top'
                                        title='Edit'>
                                        <i class="icon-copy dw dw-edit2"></i>
                                    </a>
                                    <a href="javascript:;"
                                        wire:click="$dispatch('deleteAd', {id: {{ $ad->id }} })"
                                        data-color="#e95959" style="color:rgb(233,89,89)" data-placement='top'
                                        title='Delete'>
                                        <i class="icon-copy dw dw-delete-3"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center"><span class="text-danger">No slide item found!</span></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-block mt-1 text-center">
        {{ $ads->links('livewire::simple-bootstrap') }}
    </div>

    {{-- SLIDE MODEL --}}
    <div wire:ignore.self class="modal fade" tabindex="-1" id="advertisement_modal" role="dialog" aria-hidden="true"
        aria-labelledby="myLargeModalLabel" data-backdrop="static" data-keyword="false" aria-modal="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form class="modal-content"
                wire:submit="{{ $isUpdateAdsMode ? 'updateAdvertisement()' : 'createAdvertisement()' }}">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ $isUpdateAdsMode ? 'Update Advertisement' : 'Add Advertisement' }}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                </div>
                <div class="modal-body">
                    @if ($isUpdateAdsMode)
                        <input type="hidden" wire:model="ad_id">
                    @endif
                    <div class="form-group">
                        <label for="title"><b>Ad Title</b>:</label>
                        <input type="text" class="form-control form-control-sm" wire:model="title"
                            placeholder="Enter Ad title">
                        @error('title')
                            <span class="text-danger small ml-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="type"><b>Ad Type</b>:</label>
                        <select name="type" id="type" wire:model="type"
                            class="custom-select form-control form-control-sm">
                            <option>Choose...</option>
                            <option value="corner">Corner</option>
                            <option value="banner">Banner</option>
                            <option value="popup">Popup</option>
                        </select>
                        @error('type')
                            <span class="text-danger small ml-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="content"><b>Content</b><small>
                                (HTML)</small></label>
                        <textarea wire:model="content" id="content" class="form-control" placeholder="Add content(HTML)..."></textarea>
                        @error('content')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Started</label>
                        <input class="form-control form-control-sm date-picker" id="start_at_picker"
                            wire:ignore placeholder="Choose start date" type="text" />
                        @error('start_at')
                            <span class="text-danger small ml-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Ended</label>
                        <input class="form-control form-control-sm date-picker" wire:ignore
                            id="end_at_picker" placeholder="Choose end date" type="text" />
                        @error('end_at')
                            <span class="text-danger small ml-1">{{ $message }}</span>
                        @enderror
                    </div>
                    @if ($selected_image)
                        <div class="d-block" style="max-width: 200px">
                            <img src="{{ $selected_image }}" alt=image" class="img-thumbnail"
                                style="max-width: 100%; height:auto">
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="image"><b>Image</b>:</label>
                        <input type="file" wire:model="image" class="form-control form-control-sm">
                        @error('image')
                            <span class="text-danger small ml-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="url"><b>URL</b>:</label>
                        <input type="text" wire:model="url" class="form-control form-control-sm">
                        @error('url')
                            <span class="text-danger small ml-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="custom-control custom-checkbox mb-5">
                        <input type="checkbox" class="custom-control-input" id="customCheck"
                            wire:model="is_default">
                        <label for="customCheck" class="custom-control-label">Active</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fa fa-save"></i> {{ $isUpdateUserMode ? 'Save Changes' : 'Create' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
