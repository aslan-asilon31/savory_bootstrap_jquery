@extends('adminlte::page')

@section('title', 'Food ')

@section('content_header')
    <h1>Food </h1>
@stop

@section('css')

<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css' />
<link rel='stylesheet'
  href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.css" />

@stop

@section('content')

{{-- add new food modal start --}}
<div class="modal fade" id="addFoodModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Food</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="POST" id="add_food_form" enctype="multipart/form-data">
        @csrf
        <div class="modal-body p-4 bg-light">
          <div class="row">
            <div class="col-lg">
              <label for="fname">Name</label>
              <input type="text" name="name" class="form-control" placeholder="Name" required>
            </div>
          </div>
          <div class="my-2">
            <label for="avatar">Select Image</label>
            <input type="file" name="image" class="form-control" required>
          </div>
          <div class="my-2">
            <label for="price">Price</label>
            <input type="number" name="price" class="form-control" placeholder="Price" required>
          </div>
          <div class="my-2">
            <label for="rate">Rate</label>
            <input type="number" name="rate" class="form-control" placeholder="Rate" required>
          </div>
          <div class="my-2">
            <label for="discount">Discount</label>
            <input type="number" name="discount" class="form-control" placeholder="Discount" required>
          </div>
          <div class="my-2">
            <label for="description">Description</label>
            <textarea type="text" name="description" class="form-control" placeholder="Description" required></textarea>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="add_food_btn" class="btn btn-primary">Add Food</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- add new food modal end --}}

{{-- edit Food modal start --}}
<div class="modal fade" id="editFoodModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Food</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="POST" id="edit_food_form" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="food_id" id="food_id">
        <input type="hidden" name="food_image" id="food_image">
        <div class="modal-body p-4 bg-light">
          <div class="row">
            <div class="col-lg">
              <label for="fname">Name</label>
              <input type="text" name="name" id="name" class="form-control" placeholder="Name" required>
            </div>
          </div>
          <div class="my-2">
            <label for="image">Select Image</label>
            <input type="file" name="image" class="form-control">
          </div>
          <div class="mt-2" id="avatar">

          </div>
          <div class="my-2">
            <label for="price">Price</label>
            <input type="number" name="price" id="price" class="form-control" placeholder="Price" required>
          </div>
          <div class="my-2">
            <label for="rate">Rate</label>
            <input type="number" name="rate" id="rate" class="form-control" placeholder="Rate" required>
          </div>
          <div class="my-2">
            <label for="discount">Discount</label>
            <input type="number" name="discount" id="discount" class="form-control" placeholder="Discount" required>
          </div>
          <div class="my-2">
            <label for="description">Description</label>
            <textarea type="text" name="description" id="description" class="form-control" placeholder="Description" required></textarea>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="edit_food_btn" class="btn btn-success">Update Food</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- edit Food modal end --}}

<div class="row my-0">
    <div class="col-lg-12">
      <div class="card shadow">
        <div class="card-header bg-danger d-flex justify-content-between align-items-center">
          <h3 class="text-light">Manage Foods</h3>
          @foreach ($foods as $food)
             @foreach ($food->FoodOrigins()->get() as $ffo)
                {{ $ffo->origin }}
                 
             @endforeach
              
          @endforeach
          <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addFoodModal"><i
              class="bi-plus-circle me-2"></i>Add New Food</button>
        </div>
        <div class="card-body" id="show_all_foods">
          <h1 class="text-center text-secondary my-5">Loading...</h1>
        </div>
      </div>
    </div>
</div>

@stop



@section('js')

<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js'></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  $(function() {

    // add new food ajax request
    $("#add_food_form").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);
      $("#add_food_btn").text('Adding...');
      $.ajax({
        url: '{{ route('food.store') }}',
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            Swal.fire(
              'Added!',
              'Food Added Successfully!',
              'success'
            )
            fetchAllFoods();
          }
          $("#add_food_btn").text('Add Food');
          $("#add_food_form")[0].reset();
          $("#addFoodModal").modal('hide');
        }
      });
    });

    // edit food ajax request
    $(document).on('click', '.editIcon', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      $.ajax({
        url: '{{ route('food.edit') }}',
        method: 'get',
        data: {
          id: id,
          _token: '{{ csrf_token() }}'
        },
        success: function(response) {
          $("#name").val(response.name);
          $("#image").html(
            `<img src="storage/foods/${response.image}" width="100" class="img-fluid img-thumbnail">`);
          $("#price").val(response.price);
          $("#rate").val(response.rate);
          $("#discount").val(response.discount);
          $("#description").val(response.description);
          $("#food_id").val(response.id);
          $("#food_image").val(response.image);
        }
      });
    });

    // update food ajax request
    $("#edit_food_form").submit(function(e) {
      e.preventDefault();
      const fd = new FormData(this);
      $("#edit_food_btn").text('Updating...');
      $.ajax({
        url: '{{ route('food.update') }}',
        method: 'post',
        data: fd,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          if (response.status == 200) {
            Swal.fire(
              'Updated!',
              'Food Updated Successfully!',
              'success'
            )
            fetchAllFoods();
          }
          $("#edit_food_btn").text('Update Food');
          $("#edit_food_form")[0].reset();
          $("#editFoodModal").modal('hide');
        }
      });
    });

    // delete food ajax request
    $(document).on('click', '.deleteIcon', function(e) {
      e.preventDefault();
      let id = $(this).attr('id');
      let csrf = '{{ csrf_token() }}';
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: '{{ route('food.delete') }}',
            method: 'delete',
            data: {
              id: id,
              _token: csrf
            },
            success: function(response) {
              console.log(response);
              Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
              )
              fetchAllFoods();
            }
          });
        }
      })
    });

    // fetch all foods ajax request
    fetchAllFoods();

    function fetchAllFoods() {
      $.ajax({
        url: '{{ route('food.fetchAll') }}',
        method: 'get',
        success: function(response) {
          $("#show_all_foods").html(response);
          $("table").DataTable({
            order: [0, 'desc']
          });
        }
      });
    }
  });
</script>

@stop