@extends('layouts.base')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-10">
                    <div class="card-title">Expense Category</div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#categoryModel">Add Expense Category</button>
                </div>
            </div>
         </div>
    </div>
    <div class="card-body">
        <div class="">
            <div class="table-responsive">
                <table id="example" class="table table-bordered text-nowrap key-buttons">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">No #</th>
                            <th class="border-bottom-0">Name</th>
                            <th class="border-bottom-0">Controls</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($expenseCategories as $item)
                        <tr>
                            <td>@php echo $i++; @endphp</td>
                            <td>{{ $item->name }}</td>
                            <td>
                                <a href="{{ route('expense.category.update', ['id'=>$item->id]) }}"><i class="fa fa-edit" style="font-size: 22px; color: blue;"></i></a>
                                <a href="{{ route('expense.category.delete', ['id'=>$item->id]) }}" class="delete-confirm"><i class="fa fa-trash" style="font-size: 22px; color: red; margin-left: 10px;"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="categoryModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Expense Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="expenseCategory">
                    @csrf
                    <div class="col-md-12">
                        <label class="label-control" for="name">Enter Expense Category Name</label>
                        <input type="text" class="form-control mb-2" name="name" id="name" required :value="old('name')">
                        <span class="text-danger" id="nameErrorMsg"></span>
                    </div>
                    <div class="col-md-12 mt-4">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')

<script type="text/javascript">

    $('#expenseCategory').on('submit',function(e){
        e.preventDefault();

        let name = $('#name').val();

        $.ajax({
          url: "/admin/expense-category/store",
          type:"POST",
          data:{
            "_token": "{{ csrf_token() }}",
            name:name,
          },
          success:function(response){
            $('#categoryModel').modal('toggle');
            Swal.fire({
                title: 'Success!',
                text: 'Expense Category has been added successfully!',
                icon: 'success',
                confirmButtonText: 'Done'
            });
            setTimeout(function() {   //calls click event after a certain time
                location.reload()
            }, 2000);

          },
          error: function(response) {
            $('#nameErrorMsg').text(response.responseJSON.errors.name);
          },
          });
        });
</script>
@endpush
