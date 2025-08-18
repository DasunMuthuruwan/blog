<?php

namespace App\Livewire\Admin\Category;

use App\Exceptions\CategoryCannotbeDeletedWhenPostsExistsException;
use App\Models\Category;
use App\Models\ParentCategory;
use Exception;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;

class Categories extends Component
{
    use WithPagination;

    public $isUpdateParentCategoryModal = false;
    public $isUpdateCategoryModal = false;
    public $pcategory_id, $pcategory_name, $parent_icon;
    public $category_id, $category_name, $category_description, $parent, $icon;
    public $pcategoriesPerPage = 5;
    public $categoriesPerPage = 5;

    protected $listeners = [
        'updateParentCategoryOrdering',
        'updateCategoryOrdering',
        'deleteParentCategoryAction',
        'deleteCategoryAction'
    ];
    protected string $serverError;

    public function __construct()
    {
        $this->serverError = config('exception-errors.errors.server-error');
    }

    public function AddParentCategory()
    {
        $this->pcategory_id = null;
        $this->pcategory_name = null;
        $this->parent_icon = null;
        $this->isUpdateParentCategoryModal = false;
        $this->showParentCategoryModalForm();
    }

    public function AddCategory()
    {
        $this->category_id = null;
        $this->category_name = null;
        $this->category_description = null;
        $this->parent = 0;
        $this->icon = null;
        $this->isUpdateCategoryModal = false;
        $this->showCategoryModalForm();
    }

    public function createParentCategory(Request $request)
    {
        $this->validate([
            'pcategory_name' => 'required|unique:parent_categories,name'
        ], [
            'pcategory_name.required' => 'Parent category field is required.',
            'pcategory_name.unique' => 'Parent category name is already exists.'
        ]);

        try {
            // Store new parent category
            $pCategory = new ParentCategory;
            $pCategory->name = $this->pcategory_name;
            $pCategory->icon = $this->parent_icon;
            $pCategory->save();
            $this->hideParentCategoryModalForm();

            $this->dispatch('showToastr', [
                'type' => 'info',
                'message' => 'Parent category has been created successfully.'
            ]);
        } catch (Exception $e) {
            $this->dispatch('showToastr', [
                'type' => 'error',
                'message' => $this->serverError
            ]);
        }
    }

    /**
     * pop up edit modal with parent category details
     * @param int $pCategoryId
     * 
     * @return void
     */
    public function editParentCategory(int $pCategoryId)
    {
        $pCategory = ParentCategory::findOrFail($pCategoryId);
        $this->pcategory_id = $pCategory->id;
        $this->pcategory_name = $pCategory->name;
        $this->parent_icon = $pCategory->icon;
        $this->isUpdateParentCategoryModal = true;
        $this->showParentCategoryModalForm();
    }

    /**
     * Update parent category functionality
     * 
     * @return void
     */
    public function updateParentCategory()
    {
        $pCategory = ParentCategory::findOrFail($this->pcategory_id);

        $this->validate([
            'pcategory_name' => "required|unique:parent_categories,name,{$pCategory->id}"
        ], [
            'pcategory_name.required' => 'Parent category field is required.',
            'pcategory_name.unique' => 'Parent category name is already exists.'
        ]);
        try {
            $this->isUpdateParentCategoryModal = true;
            $pCategory->name = $this->pcategory_name;
            $pCategory->icon = $this->parent_icon;
            $pCategory->slug = null;
            $pCategory->save();

            $this->hideParentCategoryModalForm();
            $this->dispatch('showToastr', [
                'type' => 'info',
                'message' => 'Parent category has been updated successfully.'
            ]);
        } catch (Exception $exception) {
            $this->dispatch('showToastr', [
                'type' => 'error',
                'message' => $this->serverError
            ]);
        }
    }

    public function updateParentCategoryOrdering(array $positions)
    {
        try {
            foreach ($positions as $key => $position) {
                [$index, $newPosition] = $position;
                ParentCategory::find($index)->update([
                    'ordering' => $newPosition
                ]);
            }

            $this->dispatch('showToastr', [
                'type' => 'info',
                'message' => 'Parent category ordering have been updated successfully.'
            ]);
        } catch (Exception $exception) {
            $this->dispatch('showToastr', [
                'type' => 'error',
                'message' => $this->serverError
            ]);
        }
    }

    public function deleteParentCategory(int $id)
    {
        $this->dispatch('deleteParentCategory', ['id' => $id]);
    }

    public function deleteParentCategoryAction(int $id)
    {
        try {
            $pCategory = ParentCategory::findOr($id);

            // Check if this parent catefiry as children
            if ($pCategory->children->count()) {
                foreach ($pCategory->children as $key => $category) {
                    Category::where('id', $category->id)->update([
                        'parent' => 0
                    ]);
                }
            }

            $pCategory->delete();
            $this->dispatch('showToastr', [
                'type' => 'info',
                'message' => 'Parent category have been deleted successfully.'
            ]);
        } catch (Exception $exception) {
            $this->dispatch('showToastr', [
                'type' => 'error',
                'message' => $this->serverError
            ]);
        }
    }

    public function createCategory(Request $request)
    {
        $this->validate([
            'category_name' => 'required|unique:categories,name',
            'category_description' => 'required'
        ], [
            'category_name.required' => 'category field is required.',
            'category_name.unique' => 'category name is already exists.'
        ]);

        try {
            // Store new category
            $category = new Category;
            $category->parent = $this->parent;
            $category->name = $this->category_name;
            $category->description = $this->category_description;
            $category->save();
            $this->hideCategoryModalForm();

            $this->dispatch('showToastr', [
                'type' => 'info',
                'message' => 'Category has been created successfully.'
            ]);
        } catch (Exception $e) {
            $this->dispatch('showToastr', [
                'type' => 'error',
                'message' => $this->serverError
            ]);
        }
    }

    /**
     * pop up edit modal with category details
     * @param int $categoryId
     * 
     * @return void
     */
    public function editCategory(int $categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $this->category_id = $category->id;
        $this->category_name = $category->name;
        $this->category_description = $category->description;
        $this->parent = $category->parent;
        $this->isUpdateCategoryModal = true;
        $this->showCategoryModalForm();
    }

    /**
     * Update category functionality
     * 
     * @return void
     */
    public function updateCategory()
    {
        $category = Category::findOrFail($this->category_id);

        $this->validate([
            'category_name' => "required|unique:categories,name,{$category->id}",
            'category_description' => 'nullable'
        ], [
            'category_name.required' => 'category field is required.',
            'category_name.unique' => 'category name is already exists.'
        ]);
        try {
            $this->isUpdateCategoryModal = true;
            $category->name = $this->category_name;
            $category->description = $this->category_description;
            $category->parent = $this->parent;
            $category->slug = null;
            $category->save();

            $this->hideCategoryModalForm();
            $this->dispatch('showToastr', [
                'type' => 'info',
                'message' => 'category has been updated successfully.'
            ]);
        } catch (Exception $exception) {
            $this->dispatch('showToastr', [
                'type' => 'error',
                'message' => $this->serverError
            ]);
        }
    }

    public function updateCategoryOrdering(array $positions)
    {
        try {
            foreach ($positions as $key => $position) {
                [$index, $newPosition] = $position;
                Category::find($index)->update([
                    'ordering' => $newPosition
                ]);
            }
            cache()->forget('site_navigation');
            $this->dispatch('showToastr', [
                'type' => 'info',
                'message' => 'Category ordering have been updated successfully.'
            ]);
        } catch (Exception $exception) {
            $this->dispatch('showToastr', [
                'type' => 'error',
                'message' => $this->serverError
            ]);
        }
    }

    public function deleteCategory(int $id)
    {
        $this->dispatch('deleteCategory', ['id' => $id]);
    }

    public function deleteCategoryAction(int $id)
    {
        try {
            $category = Category::findOr($id);
            $category->delete();
            
            $this->dispatch('showToastr', [
                'type' => 'info',
                'message' => 'Category have been deleted successfully.'
            ]);
        } catch (CategoryCannotbeDeletedWhenPostsExistsException $exception) {
            $this->dispatch('showToastr', [
                'type' => 'error',
                'message' => $exception->getMessage()
            ]);
        } catch (Exception $exception) {
            $this->dispatch('showToastr', [
                'type' => 'error',
                'message' => $this->serverError
            ]);
        }
    }

    // Parent Category
    public function showParentCategoryModalForm()
    {
        $this->resetErrorBag();
        $this->dispatch('showParentCategoryModalForm');
    }

    public function hideParentCategoryModalForm()
    {
        $this->dispatch('hideParentCategoryModalForm');
        $this->isUpdateParentCategoryModal = false;
        $this->pcategory_id = null;
        $this->pcategory_name = null;
        $this->parent_icon = null;
    }

    // Category
    public function showCategoryModalForm()
    {
        $this->resetErrorBag();
        $this->dispatch('showCategoryModalForm');
    }

    public function hideCategoryModalForm()
    {
        $this->dispatch('hideCategoryModalForm');
        $this->isUpdateCategoryModal = false;
        $this->category_id = null;
        $this->parent = 0;
        $this->category_name = null;
        $this->category_description = null;
    }

    public function render()
    {
        return view('livewire.admin.category.categories', [
            'pcategories' => ParentCategory::orderBy('ordering', 'asc')->paginate($this->pcategoriesPerPage, ['*'], 'pcat_page'),
            'categories' => Category::with('parentCategory')->withCount('posts')->orderBy('ordering', 'asc')->paginate($this->categoriesPerPage, ['*'], 'cat_page')
        ]);
    }
}
