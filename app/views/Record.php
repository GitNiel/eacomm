<?php require APPROOT . '/views/inc/header.php'; ?>

<body>
  <main>

      <div class="table-wrapper">
        <div class="table-title">
          <div class="row">
            <div class="col-sm-6">
              <h2>Manage <b>Products</b></h2>
            </div>
            <div class="col-sm-6">
              <button class="btn bg-success btn-success text-white shadow-sm" data-toggle="modal" data-target="#addModal"><i class="fa fa-plus"></i> <span>Add New Product</span></button>
            </div>
          </div>
        </div>
        <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead class="thead-dark">
            <tr>
              <th>ID</th>
              <th>Product Name</th>
              <th>Unit</th>
              <th>Price</th>
              <th>Date of Expiry</th>
              <th>Available Inventory</th>
              <th>Available Inventory Cost</th>
              <th>Image</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="record-data">
          </tbody>
        </table>
        </div>
      </div>

  </main>

  <!-- add modal -->
  <div id="addModal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            Add New Product
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form enctype="multipart/form-data" id="submit-record" method="POST">
            <div class="form-group">
              <label for="product-name" class="col-form-label">Product Name:</label>
              <input type="text" class="form-control" id="product-name" required>
            </div>
            <div class="form-group">
              <label for="unit" class="col-form-label">Unit:</label>
              <input type="text" class="form-control" id="unit" required>
            </div>
            <div class="form-group">
              <label for="price" class="col-form-label">Price:</label>
              <input type="number" class="form-control" id="price" min="0" required>
            </div>
            <div class="form-group">
              <label for="date-of-expiry" class="col-form-label">Date of Expiry:</label>
              <input type="date" id="date-of-expiry" required>
            </div>
            <div class="form-group">
              <label for="available-inventory" class="col-form-label">Available Inventory:</label>
              <input type="text" class="form-control" id="available-inventory" required>
            </div>
            <div class="form-group">
              <label for="image" class="col-form-label">Upload Image:</label>
              <input type="file" class="form-control" id="image-input" accept=".png, .jpg, .jpeg" required>
              <img src="" class="img-fluid" id="image-upload" style="max-height: 350px">
            </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" name="submit" value="Submit" class="btn btn-success">Submit</button>
        </div>
        </form>
      </div>
    </div>

  </div>

  <!-- edit modal -->
  <div id="editModal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            Update Product
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form enctype="multipart/form-data" id="update-record" method="POST">
            <input type="hidden" id="product-id">
            <div class="form-group">
              <label for="product-name" class="col-form-label">Product Name:</label>
              <input type="text" class="form-control" id="update-product-name" required>
            </div>
            <div class="form-group">
              <label for="unit" class="col-form-label">Unit:</label>
              <input type="text" class="form-control" id="update-unit" required>
            </div>
            <div class="form-group">
              <label for="price" class="col-form-label">Price:</label>
              <input type="number" class="form-control" id="update-price" min="0" required>
            </div>
            <div class="form-group">
              <label for="date-of-expiry" class="col-form-label">Date of Expiry:</label>
              <input type="date" id="update-date-of-expiry" required>
            </div>
            <div class="form-group">
              <label for="available-inventory" class="col-form-label">Available Inventory:</label>
              <input type="text" class="form-control" id="update-available-inventory" required>
            </div>
            <div class="form-group">
              <label for="image" class="col-form-label">Upload Image:</label>
              <input type="file" class="form-control" id="update-image-input">
              <img src="" class="img-fluid" id="update-image-upload" style="max-height: 350px">
            </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" name="submit" value="Submit" class="btn btn-success">Submit</button>
        </div>
        </form>
      </div>
    </div>

  </div>
</body>
</html>