<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple HTML Template</title>
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link href="//cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }
        header {
            background: #007BFF;
            color: #fff;
            padding: 1rem 0;
            text-align: center;
        }
        main {
            padding: 1rem;
        }
        footer {
            background: #333;
            color: #fff;
            text-align: center;
            padding: 0.5rem 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
       
    </style>
</head>
<body>
    <header>
        <h1>Welcome to My Website</h1>
    </header>
    <main>
        <p>This is a simple HTML template. You can customize it as per your needs.</p>
        <div class="container" style="height: 60px; background-color:red;">
            <button class="btn btn-success btn-sm" id="AddProduct">Add Product</button>
            <div id="response-delete"></div>
            <table id="product_tbl">
                <thead>
                     <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Action</th>
                     </tr>
                </thead>
            </table>
        </div>
        <div class="modal fade" id="AddproductModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                            <div class="modal-body">
                                <!-- Card goes here -->
                                   <div id="response-message"></div>
                                    <form id="productFrm" enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Product Name</label>
                                                <input type="text" class="form-control" id="name" name="name" >
                                                <input type="hidden" name="product_id" id="product_id">
                                            </div>

                                            <div class="mb-3">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea class="form-control" id="description" name="description" rows="3" ></textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label for="stock" class="form-label">Stock</label>
                                                <input type="number" class="form-control" id="stock" name="stock" min="0" >
                                            </div>

                                            <div class="mb-3">
                                                <label for="price" class="form-label">Price ($)</label>
                                                <input type="number" step="0.01" class="form-control" id="price" name="price" >
                                            </div>

                                            <div class="mb-3">
                                                <label for="image" class="form-label">Product Image</label>
                                                <input class="form-control" type="file" id="image" name="image" accept="image/*">
                                                <input type="hidden" name="existing_image" id="existing_image">
                                                <div id="image-preview"></div>
                                            </div>

                                            <button type="submit" class="btn btn-primary">Save Product</button>
                                    </form>
                            </div>
                    </div>
                </div>
        </div>
        <div class="modal fade" id="ViewproductModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Product Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                            <div class="modal-body">
                                <!-- Card goes here -->
                                   <div id="response-message"></div>
                                    <div id="product-details-card" class="card">
                                    <div class="card-body">
                                        <p><strong>Product Name:</strong> <span id="view-product-name"></span></p>
                                        <p><strong>Stock:</strong> <span id="view-product-price"></span></p>
                                        <p><strong>Price:</strong> <span id="view-product-stock"></span></p>
                                        <p><strong>Description:</strong> <span id="view-product-description"></span></p>
                                        <p><strong>Image:</strong> <span id="view-product-image"></span></p>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
        </div>
            
    </main>
    <footer>
        <p>&copy; 2025 Your Name. All rights reserved.</p>
    </footer>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> -->

     
<script src="//code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="//cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        $(document).ready(function(){
           $('#product_tbl').DataTable({
                ajax:{
                    url : '/api/get-products',
                    dataSrc : 'data',
                },
                columns :[
                    {
                        data: null,
                        render : function(data,type,row,meta){
                            return meta.row+1;
                        }
                    },
                    {data: 'name'},
                    {data: 'price'},
                    {data: 'stock'},
                    {data: 'description'},
                    {
                        data: 'image' ,
                            render: function(data){
                            let imgURL = `/storage/${data}`;
                            return `<img src="${imgURL}" style="max-width: 50px; margin: 5px; border: 1px solid #ddd; padding: 3px;" />`;
                            }

                    },
                    {
                        data : null ,
                        render : function(row,data,type){
                            return `
                                <div class="d-flex">
                                    <button class="btn btn-sm viewBtn"  data-id="${row.id}" title="View">
                                    <i class="bi bi-eye action-icon"></i>
                                    </button>
                                    <button class="btn btn-sm editBtn" data-id="${row.id}" title="Edit">
                                    <i class="bi bi-pencil-square action-icon"></i>
                                    </button>
                                    <button class="btn btn-sm deleteBtn" data-id="${row.id}" title="Delete">
                                    <i class="bi bi-trash action-icon"></i>
                                    </button>
                                </div>
                            `;
                        }
                    }
                    
                ]
           });
           $('#AddProduct').click(function () {
           $('#AddproductModal').modal('show');
           });
           $('#productFrm').on('submit',function(e){
            e.preventDefault();
            alert('click on submit');
            const formData = new FormData($('$productFrm'));
            const product_id = $('#product_id').val();
            if(product_id){formData.set('_method','PUT')} 
            $.ajax({
                url :'/api/get-products/',
                type :'POST',
                data : fomData,
                success :function(response){
                    $('#response-message').html(response.message);
                },
                error : function(xhr,status,error){
                    if(xhr.status == 403){
                        let errors = xhr.responseJSON.errors;
                        let messages ='';
                        for(let field in errors){
                            messages += errors[field].join('<br>')+'<br>';
                        } $('#response-message').html('<div class="alert alert-danger">' + messages + '</div>');
                    }else {
                         $('#response-message').html('<div class="alert alert-danger">Something went wrong.</div>');
                    }
                    $('#response-message').focus();
                }
            })
           })
           $('#product_tbl').on('click', '.editBtn', function (e) {
                e.preventDefault();
                $product_id = $(this).data('id');
                alert('hello');
                $('#product_id').val($product_id);
                $.ajax({
                    url :`/api/get-products/${$product_id}`,
                    type :'GET',
                    success : function(response){
                        const data = response.data;
                        $('#name').val(data.name);
                        $('#price').val(data.price);
                        $('#stock').val(data.stock);
                        $('#description').val(data.description);
                        $('#existing_image').val(data.image);
                        const imgURL = `/storage/${data.image}`;
                        const img = $('<img>').attr('src',imgURL).css({
                        maxWidth: '50px',
                        margin: '5px',
                        border: '1px solid #ddd',
                        padding: '3px'
                        });
                        $('#image-preview').html(img);
                         $('#AddproductModal').modal('show');
                    },
                    error :function(xhr,status,error){
                        alert('somthing went worng ');
                    },
                });
            });
           $('#product_tbl').on('click', '.viewBtn', function (e) {
                e.preventDefault();
              const id = $(this).data('id');
               $('#view-product-image').empty();
              $.ajax({
                  url :`/api/get-products/${id}`,
                  type :'GET',
                  success : function(response){
                      const data = response.data;
                      $('#view-product-name').text(data.name)
                      $('#view-product-price').text(data.price)
                      $('#view-product-stock').text(data.stock)
                      $('#view-product-description').text(data.description)
                      const  imgURL = `/storage/${data.image}`;
                      const img = $('<img>').attr('src',imgURL).css({
                          maxWidth: '50px',
                          margin: '5px',
                          border: '1px solid #ddd',
                          padding: '3px'
                        })
                        $('#view-product-image').append(img);
                        $('#ViewproductModal').modal('show');
                    },
                    error :function(xhr,status,error){

                    },
                });
            });
           $('#product_tbl').on('click', '.deleteBtn', function () {
              if(confirm('Are you sure to delete!')){
                    const id = $(this).data('id');
                    $.ajax({
                        url :`/api/get-products/${id}`,
                        type :'GET',
                        success : function(response){
                            $('#response-delete').addClass('alert alert-danger');
                            $('#response-delete').html(`${response.message}`);
                            $('#product_tbl').DataTable().ajax.reload();
                        },
                        error :function(xhr,status,error){
                            alert('something went worng ');
                        },
                    });
               }
            });

           $('#image').on('change',function(){
              const file = $(this).file();
              $('#image-preview').empty();
              $imgURL = URL.createObjectURL(file);
              $('#image-preview').html(`<img src="${imgURL}" style="width:100px; height:100px;" />`)
           })
        
        
        
        
        });
    </script>
</body>
</html>


