$(document).ready(function () {
  // read
  getRecord();

  // create
  fileUploadHandler();
  const submitForm = document.getElementById("submit-record");
  submitForm.addEventListener("submit", (e) => {
    e.preventDefault();
    validateRecord();
  });

  // delete
  $(document).on("click", "#delete-button", function (e) {
    let id = $(this).data("id");
    swal({
      title: "Approval",
      text: "Do you wish to add this record?",
      icon: "warning",
      buttons: ["Cancel", "Confirm"],
      dangerMode: true,
    }).then((isConfirm) => {
      isConfirm && deleteRecord(id);
    });
  });

  // update
  fileUploadHandlerUpdate();
  $(document).on("click", "#edit-modal", function (e) {
    let id = $(this).data("id");
    getSingleRecord(id);
  });
  const updateForm = document.getElementById("update-record");
  updateForm.addEventListener("submit", (e) => {
    e.preventDefault();
    validateUpdateRecord();
  });
});

const fileUploadHandler = () => {
  const fileUpload = document.getElementById("image-input");
  const img_box = document.getElementById("image-upload");
  const reader = new FileReader();
  fileUpload.addEventListener("change", function (event) {
    const files = event.target.files;
    const file = files[0];
    reader.readAsDataURL(file);
    reader.addEventListener("load", function (event) {
      img_box.src = event.target.result;
      img_box.alt = file.name;
    });
  });
};

const fileUploadHandlerUpdate = () => {
  const fileUpload = document.getElementById("update-image-input");
  const img_box = document.getElementById("update-image-upload");
  const reader = new FileReader();
  fileUpload.addEventListener("change", function (event) {
    const files = event.target.files;
    const file = files[0];
    reader.readAsDataURL(file);
    reader.addEventListener("load", function (event) {
      img_box.src = event.target.result;
      img_box.alt = file.name;
    });
  });
};

const validateRecord = () => {
  const p_img = document.getElementById("image-input");
  const product_image = p_img.getAttribute("value")
    ? p_img.getAttribute("value")
    : p_img.files[0];

  const product_name = document.getElementById("product-name").value;
  const unit = document.getElementById("unit").value;
  const price = document.getElementById("price").valueAsNumber.toFixed(2);
  const date_of_expiry = document.getElementById("date-of-expiry").value;
  const available_inventory = document.getElementById(
    "available-inventory"
  ).value;

  const data = {
    product_name,
    unit,
    price,
    date_of_expiry,
    available_inventory,
    product_image,
  };

  const newData = new FormData();
  newData.append("product_name", data.product_name);
  newData.append("unit", data.unit);
  newData.append("price", data.price);
  newData.append("date_of_expiry", data.date_of_expiry);
  newData.append("available_inventory", data.available_inventory);
  newData.append("product_image", data.product_image);

  swal({
    title: "Approval",
    text: "Do you wish to add this record?",
    icon: "warning",
    buttons: ["Cancel", "Confirm"],
    dangerMode: true,
  }).then((isConfirm) => {
    isConfirm && addRecord(newData);
  });
};

const addRecord = (data) => {
  $.ajax({
    type: "POST",
    url: `/eacomm/record/addRecord`,
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    method: "POST",
    success: function (data) {
      const response = JSON.parse(data);
      if (response.isSuccess) {
        swal("Submitted Successfully", `${response.message}`, "success").then(
          () => {
            window.location.replace(`/eacomm/record`);
          }
        );
      } else {
        swal("Error", `${response.message}`, "error");
      }
    },
    error: function (xhr, status, error) {
      console.error(error);
    },
  });
};

const getRecord = () => {
  $.ajax({
    url: "/eacomm/record/getRecord",
    method: "GET",
    success: function (result) {
      var data = jQuery.parseJSON(result);
      var output;
      if (data.length === 0) {
        output = `<tr>
        <td colspan="9" class="text-center">No Record Found</td>`;
      } else {
        data.forEach((x) => {
          output += `<tr>
          <td>${x.id}</td>
          <td>${x.product_name}</td>
          <td>${x.unit}</td>
          <td>₱ ${x.price}</td>
          <td>${x.date_of_expiry}</td>
          <td>${x.available_inventory}</td>
          <td>₱ ${x.available_inventory * x.price}.00</td>
          <td><img src="http://localhost/eacomm/uploads/${
            x.image
          }" class="img-fluid" style="max-height: 350px"></td>
          <td>
            <ul class="list-inline m-0">
                <li class="list-inline-item">
                    <button class="btn btn-success btn-sm" type="button" data-id="${
                      x.id
                    }" id="edit-modal" data-toggle="modal" data-target="#editModal"><i class="fa fa-edit"></i></button>
                </li>
                <li class="list-inline-item">
                    <button class="btn btn-danger btn-sm" type="button" data-id="${
                      x.id
                    }" id="delete-button"><i class="fa fa-trash"></i></button>
                </li>
            </ul>
          </td>
        </tr>`;
        });
      }
      $("#record-data").html(output);
    },
    error: function (xhr, status, error) {
      console.error(error);
    },
  });
};

const deleteRecord = (id) => {
  $.ajax({
    url: `/eacomm/Record/deleteRecord/${id}`,
    method: "POST",
    success: function (data) {
      const response = JSON.parse(data);
      if (response.isSuccess) {
        swal("Deleted Successfully", `${response.message}`, "success").then(
          () => {
            window.location.replace(`/eacomm/record`);
          }
        );
      } else {
        swal("Error", `${response.message}`, "error");
      }
    },
    error: function (xhr, status, error) {
      console.error(error);
    },
  });
};

const getSingleRecord = (id) => {
  $.ajax({
    url: `/eacomm/record/getRecordById/${id}`,
    method: "GET",
    success: function (data) {
      var result = jQuery.parseJSON(data);
      $("#update-product-name").val(result.product_name);
      $("#update-unit").val(result.unit);
      $("#update-price").val(result.price);
      $("#update-date-of-expiry").val(result.date_of_expiry);
      $("#update-available-inventory").val(result.available_inventory);
      $("#update-image-upload").attr(
        "src",
        `http://localhost/eacomm/uploads/${result.image}`
      );
    },
  });
};

const validateUpdateRecord = () => {
  const u_p_img = document.getElementById("update-image-input");
  const u_product_image = u_p_img.getAttribute("value")
    ? u_p_img.getAttribute("value")
    : u_p_img.files[0];

  const product_name = document.getElementById("update-product-name").value;
  const unit = document.getElementById("update-unit").value;
  const price = document
    .getElementById("update-price")
    .valueAsNumber.toFixed(2);
  const date_of_expiry = document.getElementById("update-date-of-expiry").value;
  const available_inventory = document.getElementById(
    "update-available-inventory"
  ).value;
  const id = document.getElementById("product-id").value;

  const data = {
    product_name,
    unit,
    price,
    date_of_expiry,
    available_inventory,
    u_product_image,
    id,
  };

  const newData = new FormData();
  newData.append("product_name", data.product_name);
  newData.append("unit", data.unit);
  newData.append("price", data.price);
  newData.append("date_of_expiry", data.date_of_expiry);
  newData.append("available_inventory", data.available_inventory);
  newData.append("product_image", data.u_product_image);
  newData.append("id", data.id);

  swal({
    title: "Approval",
    text: "Do you wish to edit this record?",
    icon: "warning",
    buttons: ["Cancel", "Confirm"],
    dangerMode: true,
  }).then((isConfirm) => {
    isConfirm && updateRecord(newData);
  });
};

const updateRecord = (data) => {
  $.ajax({
    type: "POST",
    url: `/eacomm/record/updateRecord`,
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    method: "POST",
    success: function (data) {
      const response = JSON.parse(data);
      console.log(response);
      if (response.isSuccess) {
        swal("Submitted Successfully", `${response.message}`, "success").then(
          () => {
            window.location.replace(`/eacomm/record`);
          }
        );
      } else {
        swal("Error", `${response.message}`, "error");
      }
    },
    error: function (xhr, status, error) {
      console.error(error);
    },
  });
};
