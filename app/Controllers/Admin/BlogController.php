<?php
namespace App\Controllers\Admin;

class BlogController extends AdminController {
    
    public function index() {
        $blogModel = new \App\Models\BlogPost();
        $posts = $blogModel->all();
        $this->view('admin/blogs', ['posts' => $posts]);
    }

    public function create() {
        $blogModel = new \App\Models\BlogPost();
        $categories = $blogModel->getCategories();
        $this->view('admin/add-blog', ['categories' => $categories]);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $blogModel = new \App\Models\BlogPost();
            
            $data = [
                'title' => $_POST['title'],
                'custom_url_path' => $_POST['slug'] ?: strtolower(str_replace(' ', '-', $_POST['title'])),
                'category_id' => $_POST['category_id'] ?: null,
                'featured_image_url' => $_POST['featured_image_url'] ?? null,
                'excerpt' => $_POST['excerpt'] ?? '',
                'meta_title' => $_POST['seo_title'] ?? null,
                'meta_desc' => $_POST['seo_description'] ?? null,
                'is_active' => isset($_POST['status']) && $_POST['status'] === 'active' ? 1 : 0,
                'published_at' => date('Y-m-d H:i:s')
            ];

            if ($id = $blogModel->create($data)) {
                // Sync UI Sections
                if (isset($_POST['sections'])) {
                    $uiModel = $this->model('UISection');
                    $uiModel->syncSections('blog', $id, $_POST['sections']);
                }
                $this->redirect('/admin/blogs?success=Blog post created successfully');
            } else {
                $this->redirect('/admin/blogs/create?error=Failed to create blog post');
            }
        }
    }

    public function edit($id = null) {
        if (!$id) $this->redirect('/admin/blogs');
        
        $blogModel = new \App\Models\BlogPost();
        $uiModel = $this->model('UISection');
        
        $post = $blogModel->find($id);
        if (!$post) $this->redirect('/admin/blogs');
        
        $categories = $blogModel->getCategories();
        $sections = $uiModel->getSections('blog', $id);

        $this->view('admin/edit-blog', [
            'post' => $post,
            'categories' => $categories,
            'sections' => $sections
        ]);
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $blogModel = new \App\Models\BlogPost();
            
            $data = [
                'title' => $_POST['title'],
                'custom_url_path' => $_POST['slug'],
                'category_id' => $_POST['category_id'] ?: null,
                'featured_image_url' => $_POST['featured_image_url'] ?? null,
                'excerpt' => $_POST['excerpt'] ?? '',
                'meta_title' => $_POST['seo_title'] ?? null,
                'meta_desc' => $_POST['seo_description'] ?? null,
                'is_active' => isset($_POST['status']) && $_POST['status'] === 'active' ? 1 : 0
            ];

            if ($blogModel->update($id, $data)) {
                // Sync UI Sections
                if (isset($_POST['sections'])) {
                    $uiModel = $this->model('UISection');
                    $uiModel->syncSections('blog', $id, $_POST['sections']);
                }
                $this->redirect('/admin/blogs?success=Blog post updated successfully');
            } else {
                $this->redirect('/admin/blogs/edit/' . $id . '?error=Failed to update blog post');
            }
        }
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $blogModel = new \App\Models\BlogPost();
            if ($blogModel->delete($id)) {
                $this->redirect('/admin/blogs?success=Blog post deleted');
            }
        }
        $this->redirect('/admin/blogs?error=Delete failed');
    }

    public function categories() {
        $blogModel = new \App\Models\BlogPost();
        $categories = $blogModel->getCategories();
        $this->view('admin/blog-categories', ['categories' => $categories]);
    }

    public function storeCategory() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $slug = $_POST['slug'] ?: strtolower(str_replace(' ', '-', $name));
            
            $blogModel = new \App\Models\BlogPost();
            if ($blogModel->createCategory($name, $slug)) {
                $this->redirect('/admin/blog-categories?success=Category created');
            }
        }
        $this->redirect('/admin/blog-categories?error=Failed to create category');
    }

    public function updateCategory($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $slug = $_POST['slug'] ?: strtolower(str_replace(' ', '-', $name));
            
            $blogModel = new \App\Models\BlogPost();
            if ($blogModel->updateCategory($id, $name, $slug)) {
                $this->redirect('/admin/blog-categories?success=Category updated');
            }
        }
        $this->redirect('/admin/blog-categories?error=Update failed');
    }

    public function deleteCategory($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $blogModel = new \App\Models\BlogPost();
            if ($blogModel->deleteCategory($id)) {
                $this->redirect('/admin/blog-categories?success=Category deleted');
            }
        }
        $this->redirect('/admin/blog-categories?error=Delete failed');
    }
}
