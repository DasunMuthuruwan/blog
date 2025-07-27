<div class="row">
    <div class="col-12">
        <div class="pd-20 card-box mb-30">
            <div class="clearfix">
                <div class="pull-left">
                    <h4 class="h4 text-blue">Parent Categories</h4>
                </div>
                <div class="pull-right">
                    <a href="javascript:;" wire:click="AddParentCategory()" class="btn btn-primary btn-sm"><i
                            class="icon-copy bi bi-plus-circle mr-1"></i> Add P.Category</a>
                </div>
            </div>
            <div class="table-responsive mt-3">
                <table class="table table-borderless table-striped table-sm">
                    <thead class="bg-secondary text-white">
                        <th>#</th>
                        <th>Name</th>
                        <th>N. of categories</th>
                        <th>Actions</th>
                    </thead>
                    <tbody id="sortable_parent_categories">
                        @forelse ($pcategories as $pCategory)
                            <tr data-index="{{ $pCategory->id }}" data-ordering="{{ $pCategory->ordering }}">
                                <td>{{ $pCategory->id }}</td>
                                <td>{{ $pCategory->name }}</td>
                                <td>{{ $pCategory->children->count() }}</td>
                                <td>
                                    <div class="table-actions">
                                        <a href="javascript:;" wire:click="editParentCategory({{ $pCategory->id }})"
                                            class="text-primary">
                                            <i class="dw dw-edit2 text-sm"></i>
                                        </a>
                                        <a href="javascript:;" wire:click="deleteParentCategory({{ $pCategory->id }})"
                                            class="text-danger mx-2">
                                            <i class="dw dw-delete-3 text-sm"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4"><span class="text-danger">No record found.</span></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-block mt-1 text-center">
                {{ $pcategories->links('livewire::simple-bootstrap') }}
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="pd-20 card-box mb-30">
            <div class="clearfix">
                <div class="pull-left">
                    <h4 class="h4 text-blue">Categories</h4>
                </div>
                <div class="pull-right">
                    <a href="javascript:;" wire:click="AddCategory()" class="btn btn-primary btn-sm"><i
                            class="icon-copy bi bi-plus-circle mr-1"></i> Add Category</a>
                </div>
            </div>
            <div class="table-responsive mt-3">
                <table class="table table-borderless table-striped table-sm">
                    <thead class="bg-secondary text-white">
                        <th>#</th>
                        <th>Name</th>
                        <th>parent category</th>
                        <th>No of posts</th>
                        <th>Actions</th>
                    </thead>
                    <tbody id="sortable_categories">
                        @forelse ($categories as $category)
                            <tr data-index="{{ $category->id }}" data-ordering="{{ $category->ordering }}">
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category?->parentCategory->name ?? 'Uncategorized' }}</td>
                                <td>{{ $category->posts_count }}</td>
                                <td>
                                    <div class="table-actions">
                                        <a href="javascript:;" wire:click="editCategory({{ $category->id }})"
                                            class="text-primary">
                                            <i class="dw dw-edit2 text-sm"></i>
                                        </a>
                                        <a href="javascript:;" wire:click="deleteCategory({{ $category->id }})"
                                            class="text-danger mx-2">
                                            <i class="dw dw-delete-3 text-sm"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4"><span class="text-danger">No record found.</span></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-block mt-1 text-center">
                {{ $categories->links('livewire::simple-bootstrap') }}
            </div>
        </div>
    </div>

    {{-- MODALS --}}
    <div wire:ignore.self class="modal fade" id="parent_category_modal" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" data-backdrop="static" data-keyboard="false" aria-modal="true">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content"
                wire:submit="{{ $isUpdateParentCategoryModal ? 'updateParentCategory()' : 'createParentCategory()' }}">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ $isUpdateParentCategoryModal ? 'Update Parent Catgory' : 'Create Parent Category' }}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                </div>
                <div class="modal-body">
                    @if ($isUpdateParentCategoryModal)
                        <input type="hidden" wire:model="pcategory_id">
                    @endif
                    <div class="form-group">
                        <label for="pcategory_name"><b>Parent category name</b></label>
                        <input type="text" class="form-control form-control-sm" wire:model="pcategory_name"
                            placeholder="Enter parent category name">
                        @error('pcategory_name')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="parent_icon"><b>Icon</b>:</label>
                        <input type="text" class="form-control form-control-sm" wire:model="parent_icon"
                            placeholder="Enter icon(Example: ti-user)">
                        @error('parent_icon')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                        <i class="fa fa-times"></i> Close
                    </button>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fa fa-save"></i> {{ $isUpdateParentCategoryModal ? 'Save Changes' : 'Create' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="category_modal" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" data-backdrop="static" data-keyboard="false" aria-modal="true">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content"
                wire:submit="{{ $isUpdateCategoryModal ? 'updateCategory()' : 'createCategory()' }}">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ $isUpdateCategoryModal ? 'Update Catgory' : 'Create Category' }}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                </div>
                <div class="modal-body">
                    @if ($isUpdateCategoryModal)
                        <input type="hidden" wire:model="category_id">
                    @endif
                    <div class="form-group">
                        <label for="parent_category"><b>Parent category</b>:</label>
                        <select wire:model="parent" id="parent_category" class="custom-select custom-select-sm">
                            <option value="0">Uncategorized</option>
                            @foreach ($pcategories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('parent')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="category_name"><b>Category name</b>:</label>
                        <input type="text" class="form-control form-control-sm" wire:model="category_name"
                            placeholder="Enter category name">
                        @error('category_name')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="category_description"><b>Category description</b>:</label>
                        <textarea wire:model="category_description" id="category_description" cols="30" rows="10"
                            class="form-control" placeholder="Enter category description here..."></textarea>
                        @error('category_description')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                        <i class="fa fa-times"></i> Close
                    </button>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fa fa-save"></i> {{ $isUpdateCategoryModal ? 'Save Changes' : 'Create' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
