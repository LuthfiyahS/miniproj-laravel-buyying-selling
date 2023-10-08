@extends('_layout.main')

@section('title')
    BnS App
@endsection


{{-- //konten setiap menu --}}
@section('content')
    <div class="page-header">
        <div class="page-title">
            <h3 class="page-title">Users</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item">Master Data</li>
                <li class="breadcrumb-item active">User</li>
            </ul>
        </div>
        <div class="page-btn">
            <a href="#" class="btn btn-added " data-bs-toggle="modal" data-bs-target="#create"><img
                    src="{{ 'theme/assets/img/icons/plus.svg' }}" alt="img" class="me-2" />Add User</a>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-top">
                        <div class="search-set">
                            {{-- <div class="search-path">
                                <a class="btn btn-filter" id="filter_search">
                                    <img src="{{ 'theme/assets/img/icons/filter.svg' }}" alt="img" />
                                    <span><img src="{{ 'theme/assets/img/icons/closes.svg' }}" alt="img" /></span>
                                </a>
                            </div> --}}
                            <div class="search-input">
                                <a class="btn btn-searchset">
                                    <img src="{{ 'theme/assets/img/icons/search-white.svg' }}" alt="img" />
                                </a>
                            </div>
                        </div>
                        <div class="wordset">
                            <ul>
                                <li>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel" href="/users-export/excel"><img
                                            src="{{ 'theme/assets/img/icons/excel.svg' }}" alt="img" /></a>
                                </li>
                                <li>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf" href="/users-pdf"><img
                                            src="{{ 'theme/assets/img/icons/pdf.svg' }}" alt="img" /></a>
                                </li>
                                {{-- <li>
                                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img
                                            src="{{ 'theme/assets/img/icons/printer.svg' }}" alt="img" /></a>
                                </li> --}}
                            </ul>
                        </div>
                    </div>

                    {{-- <div class="card" id="filter_inputs">
                        <div class="card-body pb-0">
                            <div class="row">
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="form-group">
                                        <input type="text" placeholder="Enter User Name" />
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="form-group">
                                        <input type="text" placeholder="Enter Phone" />
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-6 col-12">
                                    <div class="form-group">
                                        <input type="text" placeholder="Enter Email" />
                                    </div>
                                </div>
                                <div class="col-lg-1 col-sm-6 col-12 ms-auto">
                                    <div class="form-group">
                                        <a class="btn btn-filters ms-auto"><img
                                                src="{{ 'theme/assets/img/icons/search-whites.svg' }}"
                                                alt="img" /></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    <div class="table-responsive">
                        <table class="table datanew">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Name </th>
                                    <th>Email</th>
                                    <th>Role Users</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $x)
                                    <tr>
                                        <td class="productimgname">
                                            @if ($x->gambar != null)
                                                <a href="javascript:void(0);" class="product-img">
                                                    <img src="{{ url('$x->gambar') }}" alt="user" />
                                                </a>
                                            @else
                                                <a href="javascript:void(0);" class="product-img">
                                                    <img src="{{ 'theme/assets/img/customer/customer1.jpg' }}"
                                                        alt="user" />
                                                </a>
                                            @endif
                                        </td>
                                        <td>{{ $x->name }}</td>
                                        <td>{{ $x->email }}</td>
                                        <td>
                                            @if ($x->role == 'Manager')
                                                <span class="badges bg-lightgreen">{{ $x->role }}</span>
                                            @elseif ($x->role == 'Purchase')
                                                <span class="badges bg-primary">{{ $x->role }}</span>
                                            @elseif ($x->role == 'Sales')
                                                <span class="badges bg-info">{{ $x->role }}</span>
                                            @else
                                                <span class="badges bg-danger">{{ $x->role }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a class="confirm-text" href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#edit{{ $x->id }}">
                                                <img src="{{ 'theme/assets/img/icons/edit.svg' }}" alt="img" />
                                            </a>
                                            <a class="me-3 confirm-text edit" href="javascript:void(0);"
                                                data-bs-toggle="modal" data-bs-target="#delete{{ $x->id }}">
                                                <img src="{{ 'theme/assets/img/icons/delete.svg' }}" alt="img" />
                                            </a>
                                        </td>
                                    </tr>
                                    {{-- modal edit --}}
                                    <div class="modal fade" id="edit{{ $x->id }}" tabindex="-1" aria-labelledby="create"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Data</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{route('users.update',$x->id)}}" method="post">
                                                        @csrf
                                                        @method('PUT')
                                                    <div class="row">
                                                        <div class="col-lg-6 col-sm-12 col-12">
                                                            <div class="form-group">
                                                                <label>Name</label>
                                                                <input type="text" name="name" value="{{ $x->name }}" />
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-sm-12 col-12">
                                                            <div class="form-group">
                                                                <label>Email</label>
                                                                <input type="email" name="email" class="form-control" value="{{ $x->email }}"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-sm-12 col-12">
                                                            <div class="form-group">
                                                                <label>Password</label>
                                                                <input type="hidden" name="password" value="{{$x->password}}">
                                                                <input type="password" name="passwordbaru" value=""/>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-sm-12 col-12">
                                                            <div class="form-group">
                                                                <label>Level User</label>
                                                                <select class=" js-example-basic-single select2" name="role">
                                                                    <option value="SuperAdmin" @if ($x->role == "SuperAdmin") selected @endif>Super Admin</option>
                                                                    <option value="Sales" @if ($x->role == "Saled") selected @endif>Sales</option>
                                                                    <option value="Purchase" @if ($x->role == "Purchase") selected @endif>Purchase</option>
                                                                    <option value="Manager" @if ($x->role == "Manager") selected @endif>Manager</option>
                                                                </select>
                                                                {{-- <select class="js-example-basic-single select2">
                                                                    <option selected="selected">orange</option>
                                                                    <option>white</option>
                                                                    <option>purple</option>
                                                                    </select> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <button type="submit" class="btn btn-submit me-2">Submit</button>
                                                        <a class="btn btn-cancel" data-bs-dismiss="modal">Cancel</a>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- end modal --}}
                                    {{-- modal delete --}}
                                    <div class="modal fade" id="delete{{$x->id}}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Hapus Data</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="delete-order">
                                                        <img src="{{asset('theme/assets/img/icons/close-circle1.svg')}}" alt="img" />
                                                    </div>
                                                    <div class="para-set text-center">
                                                        <p>
                                                            The current order will be deleted as no payment
                                                            has been <br />
                                                            made so far.
                                                        </p>
                                                    </div>
                                                    <div class="col-lg-12 text-center">
                                                        <form action="{{route('users.destroy',$x->id)}}" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger me-2">Yes</button>
                                                            <a class="btn btn-cancel" data-bs-dismiss="modal">No</a>
                                                        </form>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- end modal delete --}}
                                @endforeach
                            </tbody>
                        </table>
                        {{-- modal create --}}
                        <div class="modal fade" id="create" tabindex="-1" aria-labelledby="create"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Tambah Pengguna</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('users.store')}}" method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-lg-6 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label>Name</label>
                                                        <input type="text" name="name" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <input type="email" name="email" class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label>Password</label>
                                                        <input type="password" name="password" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label>Level User</label>
                                                        <select class="form-control js-example-basic-single select2" name="role">
                                                            <option value="SuperAdmin">Super Admin</option>
                                                            <option value="Sales">Sales</option>
                                                            <option value="Purchase">Purchase</option>
                                                            <option value="Manager">Manager</option>
                                                        </select>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <button type="submit" class="btn btn-submit me-2">Submit</button>
                                                <a class="btn btn-cancel" data-bs-dismiss="modal">Cancel</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- end modal --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection
