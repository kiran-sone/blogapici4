<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Posts API</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">

    <style>
    body {
        background: #f5f7fa;
    }

    .card {
        border-radius: 10px;
    }

    .post-row:hover {
        background: #f1f1f1;
        cursor: pointer;
    }
    </style>
</head>

<body>
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-md-12 mb-3">
                <h1 class="">Blog Posts API in CodeIgniter 4 (Bootstrap UI) | Kiran Sone</h1>
            </div>
            <!-- Form -->
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 id="formTitle">Add New Post</h5>
                    </div>

                    <div class="card-body">
                        <form id="postForm">
                            <input type="hidden" id="pid">
                            <div class="form-group">
                                <label for="post_title">Title</label>
                                <input type="text" name="post_title" class="form-control" id="post_title" required>
                            </div>

                            <div class="form-group">
                                <label for="post_descr">Description</label>
                                <textarea name="post_descr" class="form-control" id="post_descr"></textarea required>
                            </div>

                            <div class="form-group">
                                <label for="post_catg">Category</label>
                                <!-- <input type="text" name="post_catg" class="form-control" id="post_catg" required> -->
                                 <select name="post_catg" id="post_catg" class="form-control" required>
                                    <option value="">SELECT</option>
                                 </select>
                            </div>

                            <button class="btn btn-sm btn-success btn-block" type="submit">Save Post</button>

                            <button class="btn btn-sm btn-secondary btn-block mt-2" type="button" id="btnReset">Reset</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Posts table -->
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h5>Blog Posts</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Content</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody id="postsTable"></tbody>
                            <nav>
                                <ul class="pagination" id="pagination"></ul>
                            </nav>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Custom JS -->
    <script src="posts.js"></script>

    <script>
        const apiUrl = "<?php echo base_url(); ?>api/posts";
        $(document).ready(function() {
            loadCategs();
            loadPosts();

            $("#postForm").on('submit', function(e) {
                e.preventDefault();
                const pid = $("#pid").val();
                const postData = {
                    p_title : $("#post_title").val(),
                    p_descr : $("#post_descr").val(),
                    cat_id : $("#post_catg").val(),
                };

                if(pid) {
                    // edit post submit
                    $.ajax({
                        url: apiUrl+'/'+pid,
                        method: "PATCH",
                        contentType: "application/json",
                        data: JSON.stringify(postData),
                        success: function() {
                            resetForm();
                            loadPosts();
                        }
                    });
                }
                else {
                    // create post submit
                    $.ajax({
                        url: apiUrl,
                        method: "POST",
                        contentType: "application/json",
                        data: JSON.stringify(postData),
                        success: function() {
                            resetForm();
                            loadPosts();
                        }
                    });
                }
            });

            $("#btnReset").on('click', resetForm);
        });

        let currentPage = 1;

        function loadPosts(page = 1) {
            $.get(apiUrl + '?page=' + page, function (response) {
                let rows = "";

                response.data.forEach(post => {
                    rows += `
                        <tr class="post-row">
                            <th>${post.p_title}</th>
                            <td>${post.cat_name}</td>
                            <td>${post.p_descr}</td>
                            <td class="text-nowrap">
                                <button class="btn btn-sm btn-info"
                                    onclick="editPost(${post.pid})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger"
                                    onclick="deletePost(${post.pid})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                });

                $("#postsTable").html(rows);
                renderPagination(response.pager);
                currentPage = page;
            });
        }

        function renderPagination(pager) {
            let pagination = "";

            for (let i = 1; i <= pager.totalPages; i++) {
                pagination += `
                    <li class="page-item ${i === pager.currentPage ? 'active' : ''}">
                        <a class="page-link" href="#" onclick="loadPosts(${i})">
                            ${i}
                        </a>
                    </li>
                `;
            }

            $("#pagination").html(pagination);
        }

        function loadCategs() {
            $.get(apiUrl+"/categs", function (response) {
                let rows = "";

                rows += `<option value="">SELECT</option>`;
                response.forEach(catg => {
                    rows += `<option value="${catg.cid}">${catg.cat_name}</option>`;
                });

                $("#post_catg").html(rows);
            });
        }

        function editPost(pid) {
            $.get(apiUrl+"/"+pid, function (post) {
                $("#formTitle").text("Edit Post");
                $("#pid").val(post[0].pid);
                $("#post_title").val(post[0].p_title);
                $("#post_descr").val(post[0].p_descr);
                $("#post_catg").val(post[0].cat_id);
            });
        }

        function deletePost(pid) {
            if (!confirm("Are you sure you want to delete this post?")) return;

            $.ajax({
                url: apiUrl+"/"+ pid,
                method: "DELETE",
                success: function () {
                    loadPosts();
                }
            });
        }

        function resetForm() {
            $("#formTitle").text("Add New Post");
            $("#postForm")[0].reset();
            $("#pid").val("");
        }
    </script>
</body>
</html>