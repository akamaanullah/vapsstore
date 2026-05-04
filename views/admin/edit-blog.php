<?php 
$pageTitle = "Edit Blog | Vape Store Admin";
$pageScript = "edit-blog.js";
include __DIR__ . '/partials/header.php'; 
?>

<div class="page-header-container page-header-between">
    <div class="header-title-group">
        <a href="<?= BASE_URL ?>/admin/blogs" class="btn-action-icon icon-action-btn">
            <i data-lucide="arrow-left" class="icon-md"></i>
        </a>
        <h1 class="m-0">Edit blog post</h1>
    </div>
</div>

<div class="form-layout">
    <div class="form-main">
        <!-- Title & Content Card -->
        <div class="card">
            <div class="form-group">
                <label>Title</label>
                <div class="input-with-icon">
                    <input type="text" class="modal-field-input" placeholder="e.g. Blog about your latest products or deals">
                    <i data-lucide="sparkles"></i>
                </div>
            </div>
            <div class="form-group mb-0">
                <label>Content</label>
                <div class="rich-text-editor">
                    <div class="rte-toolbar">
                        <select class="rte-select-clean" id="formatSelect" title="Text Format">
                            <option value="p">Normal</option>
                            <option value="h1">Heading 1</option>
                            <option value="h2">Heading 2</option>
                            <option value="h3">Heading 3</option>
                        </select>
                        
                        <button type="button" title="Bold" data-command="bold"><i data-lucide="bold"></i></button>
                        <button type="button" title="Italic" data-command="italic"><i data-lucide="italic"></i></button>
                        <button type="button" title="Underline" data-command="underline"><i data-lucide="underline"></i></button>
                        <button type="button" title="Strikethrough" data-command="strikeThrough"><i data-lucide="strikethrough"></i></button>
                        
                        <button type="button" title="Numbered List" data-command="insertOrderedList"><span style="font-weight: 700; font-size: 14px;">1.</span></button>
                        <button type="button" title="Bulleted List" data-command="insertUnorderedList"><i data-lucide="list"></i></button>
                        
                        <label class="color-picker-label" title="Text Color">
                            <span class="icon-text-color">A</span>
                            <input type="color" id="colorPicker" class="rte-color-picker">
                        </label>
                        
                        <label class="color-picker-label" title="Highlight Color">
                            <span class="icon-bg-color">A</span>
                            <input type="color" id="bgColorPicker" class="rte-color-picker">
                        </label>
                        
                        <div style="position: relative; display: inline-flex;">
                            <button type="button" title="Insert Link" id="insertLinkBtn"><i data-lucide="link"></i></button>
                            <div class="rte-link-popover" id="linkPopover" style="display: none;">
                                <input type="text" id="linkInput" placeholder="Paste link..." class="modal-field-input">
                                <button type="button" id="applyLinkBtn" class="btn btn-primary">Add</button>
                            </div>
                        </div>
                        <button type="button" title="Insert Image" data-command="insertImage">
                            <svg width="18" height="18" stroke-width="1.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                                <path d="M21 3.6V20.4C21 20.7314 20.7314 21 20.4 21H3.6C3.26863 21 3 20.7314 3 20.4V3.6C3 3.26863 3.26863 3 3.6 3H20.4C20.7314 3 21 3.26863 21 3.6Z" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M3 16L10 13L21 18" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M16 10C17.1046 10 18 9.10457 18 8C18 6.89543 17.1046 6 16 6C14.8954 6 14 6.89543 14 8C14 9.10457 14.8954 10 16 10Z" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <button type="button" title="Insert Video" data-command="insertVideo"><i data-lucide="video"></i></button>
                        <button type="button" title="Clear Formatting" data-command="removeFormat">
                            <span class="icon-clear-format">T<sub>x</sub></span>
                        </button>
                    </div>
                    <div class="rte-editor-content" id="editorContent" contenteditable="true" data-placeholder="Write your blog content here..."></div>
                </div>
            </div>
        </div>

        <!-- Excerpt Card -->
        <div class="card">
            <div class="card-header-flex">
                <h3 class="card-title-sm">Excerpt</h3>
                <a href="#" id="toggleExcerptBtn" class="link-primary-sm">Add Excerpt</a>
            </div>
            <p class="text-muted-sm">Add a summary of the post to appear on your home page or blog.</p>
            
            <div id="excerptField" class="hidden-field">
                <textarea class="modal-field-input" rows="3" placeholder="Add an excerpt..."></textarea>
            </div>
        </div>

        <!-- SEO Card -->
        <div class="card">
            <div class="card-header-flex">
                <h3 class="card-title-sm">Search engine listing</h3>
                <a href="#" id="toggleSeoBtn" class="link-primary-sm">Edit website SEO</a>
            </div>
            <p class="text-muted-sm">Add a title and description to see how this Blog post might appear in a search engine listing</p>
            
            <div id="seoFields" class="seo-fields-container">
                <div class="form-group">
                    <label>Page title</label>
                    <input type="text" class="modal-field-input seo-title-input" placeholder="Enter page title" maxlength="70">
                    <div class="char-counter"><span class="seo-title-count">0</span> of 70 characters used</div>
                </div>
                
                <div class="form-group">
                    <label>Meta description</label>
                    <textarea class="modal-field-input seo-desc-input" rows="4" placeholder="Enter meta description" maxlength="320"></textarea>
                    <div class="char-counter"><span class="seo-desc-count">0</span> of 320 characters used</div>
                </div>

                <div class="seo-preview-box">
                    <div class="seo-preview-header">
                        <i data-lucide="globe" class="seo-preview-icon"></i>
                        <span class="seo-preview-site">The Perfect Vape</span>
                    </div>
                    <div class="seo-preview-url">www.theperfectvape.com/blogs/news/...</div>
                    <div class="seo-preview-title">Blog Post Title</div>
                    <div class="seo-preview-desc">Blog post description will appear here...</div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-sidebar">
        <!-- Visibility Card -->
        <div class="card">
            <h3 class="card-title-sm">Visibility</h3>
            <div class="form-group mb-10">
                <select class="modal-field-input" name="visibility">
                    <option value="visible">Visible</option>
                    <option value="hidden" selected>Hidden</option>
                </select>
            </div>
            <a href="#" id="toggleVisibilityDateBtn" class="link-primary-sm fw-normal">Set visibility date</a>
            
            <div id="visibilityDateField" class="hidden-field">
                <div class="form-group mb-0">
                    <label>Visibility date</label>
                    <input type="datetime-local" class="modal-field-input">
                </div>
            </div>
        </div>

        <!-- Category Card -->
        <div class="card">
            <h3 class="card-title-sm">Category</h3>
            <div class="form-group mb-0">
                <select class="modal-field-input" name="blog_category">
                    <option value="" disabled selected>Select category</option>
                    <option value="news">News & Announcements</option>
                    <option value="reviews">Product Reviews</option>
                    <option value="guides">Guides & Tutorials</option>
                    <option value="promotions">Promotions</option>
                </select>
            </div>
        </div>

        <!-- Featured Image Card -->
        <div class="card">
            <h3 class="card-title-sm">Featured image</h3>
            <div class="image-upload-box" id="imageUploadBox">
                <input type="file" id="featuredImageInput" accept="image/*" style="display: none;">
                <img id="imagePreview" src="" alt="Featured image preview">
                <button class="btn-outline" id="addImageBoxBtn">Add image</button>
            </div>
        </div>
    </div>
</div>

<div class="form-actions-bar">
    <div class="actions-left">
        <a href="<?= BASE_URL ?>/admin/blogs" class="btn-outline" style="text-decoration: none;">Discard</a>
    </div>
    <div class="actions-right">
        <button class="btn btn-primary">Save changes</button>
    </div>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>


